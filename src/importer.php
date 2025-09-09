<?php

if (!defined('ABSPATH')) {
    exit; // Blokada bezpośredniego dostępu
}
function createOrGetCategory($category_name)
{
    $existing_term = term_exists($category_name, 'product_cat');
    if (is_array($existing_term) && isset($existing_term['term_id'])) {
        return (int)$existing_term['term_id'];
    }
    $args = array(
        'description' => "A description for the " . $category_name . " category.",
        'slug' => sanitize_title($category_name),
    );

    $result = wp_insert_term($category_name, 'product_cat', $args);

    if (!is_wp_error($result)) {
        return (int)$result['term_id'];
    } else {
        print_r($result->errors);
        return $result;
    }
}

function findUserByEstiId($custom_id): ?int
{
    $args = array(
        'meta_query' => array(
            array(
                'key' => 'esti_id',
                'value' => $custom_id,
                'compare' => '=',
            ),
        ),
    );
    $users = get_users($args);
    if (!empty($users)) {
        return $users[0]->id;
    }
    return null;
}

function getAgentPostByEstiId($custom_id): ?WP_Post
{
    $args = array(
        'post_type' => "agent",
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => "esti_id",
                'value' => "$custom_id",
                'compare' => '=',
            )
        )
    );

    $posts = get_posts($args);
    wp_reset_postdata();
    return $posts[0];
}

function downloadImage($url): int
{
    global $wpdb;
    $query = $wpdb->prepare(
        "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_value LIKE %s LIMIT 1",
        '%' . $wpdb->esc_like(basename($url)) . '%'
    );
    $attachment_id = $wpdb->get_var($query);

    if ($attachment_id) {
        print_r("skipping image download $url\n");
        return $attachment_id;
    }

    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');

    $file_array = media_sideload_image($url, 0, null, 'id');

    if (is_wp_error($file_array)) {
        return 0;
    }
    print_r("downloaded image $url\n");
    return $file_array;
}


class RealEstateProduct
{
    public array $request;
    public function asMd5(): string
    {
        return md5(json_encode($this->request));
    }

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function create(): bool
    {
        $product = new WC_Product_Simple();
        $product->set_name($this->request["portalTitle"]);
        $product->set_status('publish');
        $product->set_catalog_visibility('visible');
        $product->set_price($this->request["price"]);
        $product->set_regular_price($this->request["price"]);

        $product->set_description($this->request["description"]);
        $product->set_short_description($this->request["description"]);

        $product->set_category_ids(array(createOrGetCategory($this->request["typeName"])));

        $search_term = $this->request["main_picture"];
        $thumbnail_url = array_filter($this->request["pictures"], function ($string) use ($search_term) {
            return str_contains($string, $search_term);
        })[0];
        $all_images_wo_thumbnail = array_filter($this->request["pictures"], function ($string) use ($search_term) {
            return !str_contains($string, $search_term);
        });
        $product->set_image_id(downloadImage($thumbnail_url));
        $gallery = array_map('downloadImage', $all_images_wo_thumbnail);
        $product->set_gallery_image_ids($gallery);

        $product_id = $product->save();
        wp_update_post(array(
            'ID' => $product_id,
            'post_author' => findUserByEstiId($this->request["companyId"]),
        ));
        update_post_meta($product_id, "locationLatitudeLongitude",
            $this->request["locationLatitude"]. ',' . $this->request["locationLongitude"]);
        foreach($this->request as $key => $value){
            update_post_meta($product_id, $key, $value);
        }


        # agent fields
        $agentPost = getAgentPostByEstiId($this->request["contactId"]);
        update_post_meta($product_id, "agent", $agentPost->ID);
        update_post_meta($product_id, "esti_id", $agentPost->esti_id);
        update_post_meta($product_id, "pretty_name", $agentPost->pretty_name);
        update_post_meta($product_id, "profile_picture", $agentPost->profile_picture);
        update_post_meta($product_id, "email", $agentPost->email);
        update_post_meta($product_id, "phone", $agentPost->phone);


        return $product->save();
    }

}

function runProducts()
{
    $url = 'https://client-api.esticrm.pl/apiClient/offer/list?company=15323&token=21254db602';

    $options = [
        'http' => [
            'method' => 'GET',
            'header' => [
                "User-Agent: Mozilla/5.0",
            ],
            'timeout' => 10,
            'ignore_errors' => true,
        ]
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    if ($response === false) {
        echo "Request failed.";
    } else {
        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "Failed to decode JSON: " . json_last_error_msg();
            echo '<pre>';
            print_r($data);  // print array in readable format
            echo '</pre>';
        }
    }

    $offers = $data['data'];
    echo('Downloaded ' . count($offers) . ' offers');

    foreach ($offers as $offer) {
        $product = new RealEstateProduct($offer);
        $product->create();
    }
}

class RealEstateAgent
{
    public int $Id;
    public string $firstname;
    public string $lastname;
    public string $email;
    public string $phone;
    public ?string $email_contact;
    public string $avatar_url;

    public static function fromApiResponse($response): RealEstateAgent
    {
        $agent = new RealEstateAgent();
        $agent->id = $response['id'];
        $agent->firstname = $response['firstname'];
        $agent->lastname = $response['lastname'];
        $agent->email = $response['email'];
        $agent->email_contact = $response['email_contact'];
        $agent->phone = $response['phone'];
        $agent->avatar_url = $response['avatar_url'];
        return $agent;
    }

    public function asMd5(): string
    {
        return md5(
            $this->id . $this->firstname . $this->lastname .
            $this->email . $this->phone . $this->email_contact
        );

    }

    public static function mock(): RealEstateAgent
    {
        $agent = new RealEstateAgent();
        $agent->id = 1;
        $agent->firstname = "mock_firstname";
        $agent->lastname = "mock_lastname";
        $agent->email = "mock_email@email.com";
        $agent->phone = "mock_phone";
        $agent->email_contact = "mock_email_contact";
        $agent->avatar_url = "https://static.esticrm.pl/public/images/users/15323/152264_max.jpg";
        return $agent;
    }

    public function create(): bool
    {
        $user_id = wp_insert_user(array(
                'user_login' => $this->email,
                'user_pass' => "password",
                'user_email' => $this->email,
                'first_name' => $this->firstname,
                'last_name' => $this->lastname,
                'display_name' => $this->firstname . " " . $this->lastname,
                'role' => 'vendor')
        );
        add_user_meta($user_id, 'wcv_vendor_settings', array(
            'approved' => 1,
        ), true);

        add_user_meta($user_id, 'md5', $this->asMd5(), false);
        add_user_meta($user_id, 'esti_id', $this->id, false);

        $user_post = wp_insert_post(array(
            'post_title' => $this->firstname . " " . $this->lastname,
            'post_content' => $this->firstname . " " . $this->lastname,
            'post_status' => 'publish',
            'post_type' => 'agent',
            'post_author' => $user_id
        ));

        update_post_meta($user_post, 'pretty_name', $this->firstname . " " . $this->lastname);
        $avatar = downloadImage($this->avatar_url);
        update_post_meta($user_post, 'profile_picture', $avatar);
        update_post_meta($user_post, "esti_id", $this->id);
        update_post_meta($user_post, "email", $this->email);
        update_post_meta($user_post, "phone", $this->phone);

        wp_update_post(array(
            'ID' => $user_post,
            'post_author' => $user_id,
        ));

        return true;
    }
}

function runAgents()
{
    $url = 'https://client-api.esticrm.pl/apiClient/user/exported-list?company=15323&token=21254db602';

    $options = [
        'http' => [
            'method' => 'GET',
            'header' => [
                "User-Agent: Mozilla/5.0",
            ],
            'timeout' => 10,
            'ignore_errors' => true,
        ]
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    if ($response === false) {
        echo "Request failed.";
    } else {
        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "Failed to decode JSON: " . json_last_error_msg();
            echo '<pre>';
            print_r($data);  // print array in readable format
            echo '</pre>';
        }
    }

    $users = $data['data'];
    echo('Downloaded ' . count($users) . "users\n");

    foreach ($users as $user) {
        RealEstateAgent::fromApiResponse($user)->create();
    }
}

function debug()
{
    echo 123123456;
}


?>
