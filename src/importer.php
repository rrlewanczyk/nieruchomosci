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

function getProductsByEstiId($esti_id): array
{
    $args = array(
        'post_type' => "product",
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => "esti_id",
                'value' => "$esti_id",
                'compare' => '=',
            )
        )
    );

    $posts = get_posts($args);
    wp_reset_postdata();
    return $posts;
}

function getProductById($id): ?WP_Post
{
    $args = array(
        'post_type' => "product",
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => "id",
                'value' => "$id",
                'compare' => '=',
            )
        )
    );

    $posts = get_posts($args);
    wp_reset_postdata();
    if ($posts) {
        return $posts[0];
    }
    return null;
}

function getProductsNotMatchingIds($ids): ?array
{
    $args = array(
        'post_type' => "product",
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => "id",
                'value' => $ids,
                'compare' => 'NOT IN',
            )
        )
    );

    $posts = get_posts($args);
    wp_reset_postdata();
    return $posts;
}

function getAgentPostsNotMatchingIds($esti_ids): array
{
    $args = array(
        'post_type' => "agent",
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => "esti_id",
                'value' => $esti_ids,
                'compare' => 'NOT IN',
            )
        )
    );

    $posts = get_posts($args);
    wp_reset_postdata();
    return $posts;
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
        print_r("   skipping image download $url\n");
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

function removeAgent($agentPost)
{
    foreach (getProductsByEstiId(get_post_meta($agentPost->ID, "esti_id", false)) as $product) {
        wp_delete_post($product->ID, true);
        print_r("product " . $product->ID . " removed\n");
    }
    wp_delete_user($agentPost->post_author, false);
    print_r("removing user " . $agentPost->post_author . "\n");
    wp_delete_post($agentPost->ID, true);
    print_r("removing post " . $agentPost->ID . "\n");
}


class RealEstateProduct
{
    public array $response;

    public function asMd5(): string
    {
        return md5(json_encode($this->response));
    }

    public function __construct($response)
    {
        $this->response = $response;
    }

    public function create(): bool
    {
        $existingPost = getProductById($this->response["id"]);
        if ($existingPost) {
            print_r("product md5 " . get_post_meta($existingPost->ID, "response_md5", true) . "\n");
            print_r("this md5 " . $this->asMd5() . "\n");
        }
        if ($existingPost && get_post_meta($existingPost->ID, "response_md5", true) === $this->asMd5()) {
            print_r("product already exists ($existingPost->ID)\n");
            return false;
        } elseif ($existingPost) {
            print_r("product changed, removing existing product, \n");
            wp_delete_post($existingPost->ID, true);
        }


        $product = new WC_Product_Simple();
        $product->set_name($this->response["portalTitle"]);
        $product->set_status('publish');
        $product->set_catalog_visibility('visible');
        $product->set_price($this->response["price"]);
        $product->set_regular_price($this->response["price"]);

        $product->set_description($this->response["description"]);
        $product->set_short_description($this->response["description"]);

        $product->set_category_ids(array(createOrGetCategory($this->response["typeName"])));

        $search_term = $this->response["main_picture"];
        $thumbnail_url = array_filter($this->response["pictures"], function ($string) use ($search_term) {
            return str_contains($string, $search_term);
        })[0];
        $all_images_wo_thumbnail = array_filter($this->response["pictures"], function ($string) use ($search_term) {
            return !str_contains($string, $search_term);
        });
        $product->set_image_id(downloadImage($thumbnail_url));
        $gallery = array_map('downloadImage', $all_images_wo_thumbnail);
        $product->set_gallery_image_ids($gallery);

        $product_id = $product->save();
        wp_update_post(array(
            'ID' => $product_id,
            'post_author' => findUserByEstiId($this->response["companyId"]),
        ));
        update_post_meta($product_id, "locationLatitudeLongitude",
            $this->response["locationLatitude"] . ',' . $this->response["locationLongitude"]);
        update_post_meta($product_id, "response_md5", $this->asMd5());

        foreach ($this->response as $key => $value) {
            update_post_meta($product_id, $key, $value);
        }


        # agent fields
        $agentPost = getAgentPostByEstiId($this->response["contactId"]);
        update_post_meta($product_id, "agent", $agentPost->post_author);
        update_post_meta($product_id, "esti_id", get_post_meta($agentPost->ID, "esti_id", true));
        update_post_meta($product_id, "pretty_name", get_post_meta($agentPost->ID, "pretty_name", true));
        update_post_meta($product_id, "profile_picture", get_post_meta($agentPost->ID, "pretty_name", true));
        update_post_meta($product_id, "email", get_post_meta($agentPost->ID, "email", true));
        update_post_meta($product_id, "phone", get_post_meta($agentPost->ID, "phone", true));

        return $product->save();
    }

}

function runProducts()
{
    print_r("Datetime: " . date('Y-m-d H:i:s') . "\n");
    $url = 'https://client-api.esticrm.pl/apiClient/offer/list?company=20765&token=6ee2f34a88';

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
    echo('Downloaded ' . count($offers) . " offers\n");

    $productsIds = [];

    foreach ($offers as $offer) {
        print_r("creating product " . $offer["id"] . "\n");
        $product = new RealEstateProduct($offer);
        $productsIds[] = $offer["id"];
        $product->create();
        print_r("\n");
    }
    $productsIdsToDelete = getProductsNotMatchingIds($productsIds);
    foreach ($productsIdsToDelete as $productId) {
        print_r("deleting product " . $productId->ID . "(". get_post_meta($productId->ID, "id", true).")\n");
        wp_delete_post($productId->ID, true);
    }
}

class RealEstateAgent
{
    public array $response;

    public function asMd5(): string
    {
        return md5(json_encode($this->response));
    }

    public function __construct($response)
    {
        $this->response = $response;
    }

    public function create(): bool
    {
        $agentPost = getAgentPostByEstiId($this->response["id"]);
        if ($agentPost) {
            print_r("user md5 " . get_user_meta($agentPost->post_author, "response_md5", true) . "\n");
            print_r("this md5 " . $this->asMd5() . "\n");
        }

        if ($agentPost && get_user_meta($agentPost->post_author, "response_md5", true) === $this->asMd5()) {
            print_r("agent already exists ($agentPost->ID)\n");
            return false;
        } elseif ($agentPost) {
            print_r("user changed, removing existing user, \n");
            removeAgent($agentPost);
        }


        $user_id = wp_insert_user(array(
                'user_login' => $this->response['email'],
                'user_pass' => "password",
                'user_email' => $this->response['email'],
                'first_name' => $this->response['firstname'],
                'last_name' => $this->response['lastname'],
                'display_name' => $this->response['firstname'] . " " . $this->response['lastname'],
                'role' => 'vendor')
        );
        if (is_wp_error($user_id)) {
            print_r($user_id->errors);
        }
        print_r("   created user " . $user_id . "\n");
        add_user_meta($user_id, 'wcv_vendor_settings', array(
            'approved' => 1,
        ), true);

        add_user_meta($user_id, 'response_md5', $this->asMd5(), false);
        add_user_meta($user_id, 'esti_id', $this->response["id"], false);

        $user_post = wp_insert_post(array(
            'post_title' => $this->response['firstname'] . " " . $this->response['lastname'],
            'post_content' => $this->response['firstname'] . " " . $this->response['lastname'],
            'post_status' => 'publish',
            'post_type' => 'agent',
            'post_author' => $user_id
        ));

        update_post_meta($user_post, 'pretty_name', $this->response['firstname'] . " " . $this->response['lastname']);
        $avatar = downloadImage($this->response['avatar_url']);
        update_post_meta($user_post, 'profile_picture', $avatar);
        update_post_meta($user_post, "esti_id", $this->response["id"]);
        update_post_meta($user_post, "email", $this->response['email']);
        update_post_meta($user_post, "phone", $this->response['phone']);
        update_post_meta($user_post, "description", $this->response['description']);
        update_post_meta($user_post, "company_function", $this->response['company_function']);

        wp_update_post(array(
            'ID' => $user_post,
            'post_author' => $user_id,
        ));
        print_r("created post " . $user_post . "\n");
        return true;
    }
}

function runAgents()
{
    print_r("Datetime: " . date('Y-m-d H:i:s') . "\n");
    $url = 'https://client-api.esticrm.pl/apiClient/user/exported-list?company=20765&token=6ee2f34a88';

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
    echo('Downloaded ' . count($users) . " users\n");

    $esti_ids = [];
    foreach ($users as $esti_user_data) {
        $esti_ids[] = $esti_user_data['id'];
        $agent = new RealEstateAgent($esti_user_data);
        print_r("creating user " . $agent->response['id'] . ": \n");
        $agent->create();

        print_r("\n\n");
    }

    foreach (getAgentPostsNotMatchingIds($esti_ids) as $agentPostToRemove) {
        print_r("removing post " . $agentPostToRemove->ID . "\n");
        removeAgent($agentPostToRemove);
    }

}

function debug()
{
    echo 123123456;
}


?>
