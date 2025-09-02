<?php
function create_elementor_page(string $page_title)
{

    $existing_page = get_page_by_title($page_title, OBJECT, 'page');

    if (null === $existing_page) {

        $page_args = array(
            'post_title' => wp_strip_all_tags($page_title),
            'post_content' => '',
            'post_status' => 'publish',
            'post_type' => 'page',
        );

        $new_page_id = wp_insert_post($page_args);
        if (!is_wp_error($new_page_id)) {
            update_post_meta($new_page_id, '_wp_page_template', 'elementor_full_width');
            update_post_meta($new_page_id, '_elementor_edit_mode', 'yes');
            update_post_meta($new_page_id, '_elementor_template_type', 'page');
        }
    }
}

function init_website_pages(): void {
    $titles = ["Strona główna", "Oferty"];
    foreach ($titles as $title) {
        create_elementor_page($title);
    }
}

add_action('init', 'init_website_pages');

