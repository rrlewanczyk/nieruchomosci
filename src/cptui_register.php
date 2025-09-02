<?php

add_action('init', function () {
    $labels = [
        "name" => esc_html__("Agents", "custom-post-type-ui"),
        "singular_name" => esc_html__("Agent", "custom-post-type-ui"),
        "menu_name" => esc_html__("My Agents", "custom-post-type-ui"),
        "all_items" => esc_html__("All Agents", "custom-post-type-ui"),
        "add_new" => esc_html__("Add new", "custom-post-type-ui"),
        "add_new_item" => esc_html__("Add new Agent", "custom-post-type-ui"),
        "edit_item" => esc_html__("Edit Agent", "custom-post-type-ui"),
        "new_item" => esc_html__("New Agent", "custom-post-type-ui"),
        "view_item" => esc_html__("View Agent", "custom-post-type-ui"),
        "view_items" => esc_html__("View Agents", "custom-post-type-ui"),
        "search_items" => esc_html__("Search Agents", "custom-post-type-ui"),
        "not_found" => esc_html__("No Agents found", "custom-post-type-ui"),
        "not_found_in_trash" => esc_html__("No Agents found in trash", "custom-post-type-ui"),
        "parent" => esc_html__("Parent Agent:", "custom-post-type-ui"),
        "featured_image" => esc_html__("Featured image for this Agent", "custom-post-type-ui"),
        "set_featured_image" => esc_html__("Set featured image for this Agent", "custom-post-type-ui"),
        "remove_featured_image" => esc_html__("Remove featured image for this Agent", "custom-post-type-ui"),
        "use_featured_image" => esc_html__("Use as featured image for this Agent", "custom-post-type-ui"),
        "archives" => esc_html__("Agent archives", "custom-post-type-ui"),
        "insert_into_item" => esc_html__("Insert into Agent", "custom-post-type-ui"),
        "uploaded_to_this_item" => esc_html__("Upload to this Agent", "custom-post-type-ui"),
        "filter_items_list" => esc_html__("Filter Agents list", "custom-post-type-ui"),
        "items_list_navigation" => esc_html__("Agents list navigation", "custom-post-type-ui"),
        "items_list" => esc_html__("Agents list", "custom-post-type-ui"),
        "attributes" => esc_html__("Agents attributes", "custom-post-type-ui"),
        "name_admin_bar" => esc_html__("Agent", "custom-post-type-ui"),
        "item_published" => esc_html__("Agent published", "custom-post-type-ui"),
        "item_published_privately" => esc_html__("Agent published privately.", "custom-post-type-ui"),
        "item_reverted_to_draft" => esc_html__("Agent reverted to draft.", "custom-post-type-ui"),
        "item_trashed" => esc_html__("Agent trashed.", "custom-post-type-ui"),
        "item_scheduled" => esc_html__("Agent scheduled", "custom-post-type-ui"),
        "item_updated" => esc_html__("Agent updated.", "custom-post-type-ui"),
        "template_name" => esc_html__("Single Agent: Agent", "custom-post-type-ui"),
        "parent_item_colon" => esc_html__("Parent Agent:", "custom-post-type-ui"),
    ];

    $args = [
        "label" => esc_html__("Agents", "custom-post-type-ui"),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "rest_namespace" => "wp/v2",
        "has_archive" => false,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "delete_with_user" => false,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "can_export" => false,
        "rewrite" => ["slug" => "agent", "with_front" => true],
        "query_var" => true,
        "supports" => ["title", "editor", "thumbnail"],
        "show_in_graphql" => false,
    ];
    register_post_type("agent", $args);
});

add_action('jet-engine/meta-boxes/register-instances', function ($meta_manager) {

    if (!class_exists('Jet_Engine_CPT_Meta')) {
        require jet_engine()->plugin_path('includes/components/meta-boxes/post.php');
    }

    $meta_fields = array(
        array(
            "title" => "esti_id",
            "name" => "esti_id",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
            "is_required" => true
        ),
        array(
            "title" => "Pretty Name",
            "name" => "pretty_name",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
            "is_required" => true
        ),
        array(
            "title" => "Profile Picture",
            "name" => "profile_picture",
            "object_type" => "field",
            "width" => "100%",
            "type" => "media",
            "value_format" => "id"
        ),
        array(
            "title" => "Email",
            "name" => "email",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),
        array(
            "title" => "Phone",
            "name" => "phone",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),
    );

    new Jet_Engine_CPT_Meta('agent', $meta_fields, 'agent_box', 'normal', 'high', array());

    $meta_manager->store_fields('agent', $meta_fields);
    $meta_manager->store_fields('product', $meta_fields);
});

add_action('jet-engine/meta-boxes/register-instances', function ($meta_manager) {

    if (!class_exists('Jet_Engine_CPT_Meta')) {
        require jet_engine()->plugin_path('includes/components/meta-boxes/post.php');
    }

    $meta_fields = array(
        array(
            "title" => "Powierzchnia",
            "name" => "powierzchnia",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),
        array(
            "title" => "Liczba Pokoi",
            "name" => "liczba_pokoi",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),
        array(
            "title" => "Współrzędne",
            "name" => "wspolrzedne",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),
        array(
            "title" => "Agent",
            "name" => "agent",
            "object_type" => "field",
            "width" => "100%",
            "type" => "posts",
            "search_post_type" => [
                "agent"
            ],
            "is_required" => true
        )
    );

    new Jet_Engine_CPT_Meta('product', $meta_fields, 'product_box', 'normal', 'high', array());

    $meta_manager->store_fields('product', $meta_fields);
});
