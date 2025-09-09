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
            "title" => "id",
            "name" => "id",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "companyId",
            "name" => "companyId",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "estateOfferUuid",
            "name" => "estateOfferUuid",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "originId",
            "name" => "originId",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "officeId",
            "name" => "officeId",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "companyName",
            "name" => "companyName",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "companyStatus",
            "name" => "companyStatus",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "companyDeleted",
            "name" => "companyDeleted",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "mainTypeId",
            "name" => "mainTypeId",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "investmentId",
            "name" => "investmentId",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "residentialId",
            "name" => "residentialId",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "locationLatitude",
            "name" => "locationLatitude",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "locationLongitude",
            "name" => "locationLongitude",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "locationLatitudeLongitude",
            "name" => "locationLatitudeLongitude",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "locationPostal",
            "name" => "locationPostal",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "offerExport",
            "name" => "offerExport",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "importId",
            "name" => "importId",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "importNumber",
            "name" => "importNumber",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "market",
            "name" => "market",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "transaction",
            "name" => "transaction",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "numberPrime",
            "name" => "numberPrime",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "number",
            "name" => "number",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "numberExport",
            "name" => "numberExport",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "numberExportDate",
            "name" => "numberExportDate",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "price",
            "name" => "price",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "priceCurrency",
            "name" => "priceCurrency",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "pricePermeter",
            "name" => "pricePermeter",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "priceHide",
            "name" => "priceHide",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "vatRate",
            "name" => "vatRate",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "pricePrevious",
            "name" => "pricePrevious",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "lastLowestPrice",
            "name" => "lastLowestPrice",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "areaTotal",
            "name" => "areaTotal",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "areaUsable",
            "name" => "areaUsable",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "areaPlot",
            "name" => "areaPlot",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "availableDescription",
            "name" => "availableDescription",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "availableDate",
            "name" => "availableDate",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "availableDateDays",
            "name" => "availableDateDays",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "addDate",
            "name" => "addDate",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "activateDate",
            "name" => "activateDate",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "updateDate",
            "name" => "updateDate",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "exportGalleryDate",
            "name" => "exportGalleryDate",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "exportDate",
            "name" => "exportDate",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "exchange",
            "name" => "exchange",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "mdm",
            "name" => "mdm",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "status",
            "name" => "status",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "portalTitle",
            "name" => "portalTitle",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "portalPromote",
            "name" => "portalPromote",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "portalWwwTitle",
            "name" => "portalWwwTitle",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "typeName",
            "name" => "typeName",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "labelSold",
            "name" => "labelSold",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "labelNew",
            "name" => "labelNew",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "labelReserved",
            "name" => "labelReserved",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "agreementType",
            "name" => "agreementType",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "contactId",
            "name" => "contactId",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "contactEmail",
            "name" => "contactEmail",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "contactStatus",
            "name" => "contactStatus",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "contactDeleted",
            "name" => "contactDeleted",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "contactFirstname",
            "name" => "contactFirstname",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "contactLastname",
            "name" => "contactLastname",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "contactPhone",
            "name" => "contactPhone",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "locationCityName",
            "name" => "locationCityName",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "locationStreetName",
            "name" => "locationStreetName",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "locationStreetType",
            "name" => "locationStreetType",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "locationPrecinctName",
            "name" => "locationPrecinctName",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "locationParentPrecinctName",
            "name" => "locationParentPrecinctName",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "locationCommuneName",
            "name" => "locationCommuneName",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "locationDistrictName",
            "name" => "locationDistrictName",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "locationProvinceName",
            "name" => "locationProvinceName",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "locationPlaceName",
            "name" => "locationPlaceName",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "locationCountryName",
            "name" => "locationCountryName",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "locationExportCityName",
            "name" => "locationExportCityName",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "locationExportStreetName",
            "name" => "locationExportStreetName",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "locationExportStreetType",
            "name" => "locationExportStreetType",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "locationExportStreetCustom",
            "name" => "locationExportStreetCustom",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "locationExportPrecinctName",
            "name" => "locationExportPrecinctName",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "locationExportParentPrecinctName",
            "name" => "locationExportParentPrecinctName",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "locationExportCommuneName",
            "name" => "locationExportCommuneName",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "locationExportDistrictName",
            "name" => "locationExportDistrictName",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "locationExportProvinceName",
            "name" => "locationExportProvinceName",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "locationExportPlaceName",
            "name" => "locationExportPlaceName",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "locationExportCountryName",
            "name" => "locationExportCountryName",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "locationCityForeign",
            "name" => "locationCityForeign",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "locationStreetForeign",
            "name" => "locationStreetForeign",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "description",
            "name" => "description",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "descriptionPrefix",
            "name" => "descriptionPrefix",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "descriptionEnglish",
            "name" => "descriptionEnglish",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "descriptionGerman",
            "name" => "descriptionGerman",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "descriptionWebsite",
            "name" => "descriptionWebsite",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "descriptionRussian",
            "name" => "descriptionRussian",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "descriptionSuffix",
            "name" => "descriptionSuffix",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "descriptionRoom",
            "name" => "descriptionRoom",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "descriptionAdditional",
            "name" => "descriptionAdditional",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "portalEnglishTitle",
            "name" => "portalEnglishTitle",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "tagList",
            "name" => "tagList",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "videoLink",
            "name" => "videoLink",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "tourLink",
            "name" => "tourLink",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "onlinePresentation",
            "name" => "onlinePresentation",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "brightKitchen",
            "name" => "brightKitchen",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "apartmentKitchen",
            "name" => "apartmentKitchen",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "apartmentFloor",
            "name" => "apartmentFloor",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "apartmentRoomNumber",
            "name" => "apartmentRoomNumber",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "apartmentRoomRent",
            "name" => "apartmentRoomRent",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "apartmentBathroomNumber",
            "name" => "apartmentBathroomNumber",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "apartmentBedroomNumber",
            "name" => "apartmentBedroomNumber",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "apartmentToiletNumber",
            "name" => "apartmentToiletNumber",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "apartmentRent",
            "name" => "apartmentRent",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "apartmentCharges",
            "name" => "apartmentCharges",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "apartmentLevelNumber",
            "name" => "apartmentLevelNumber",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "apartmentOwnership",
            "name" => "apartmentOwnership",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "apartmentFurnishings",
            "name" => "apartmentFurnishings",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "apartmentHeight",
            "name" => "apartmentHeight",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "apartmentHeightTo",
            "name" => "apartmentHeightTo",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "additionalIsLuxury",
            "name" => "additionalIsLuxury",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "apartmentDeposit",
            "name" => "apartmentDeposit",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "apartmentEquipment",
            "name" => "apartmentEquipment",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "apartmentWindow",
            "name" => "apartmentWindow",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "apartmentNorth",
            "name" => "apartmentNorth",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "apartmentEast",
            "name" => "apartmentEast",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "apartmentSouth",
            "name" => "apartmentSouth",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "apartmentWest",
            "name" => "apartmentWest",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "commercialType",
            "name" => "commercialType",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "commercialHallClearHeight",
            "name" => "commercialHallClearHeight",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "commercialTypeAlternative",
            "name" => "commercialTypeAlternative",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "commercialLocalExposition",
            "name" => "commercialLocalExposition",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "additionalLoggia",
            "name" => "additionalLoggia",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "additionalBalcony",
            "name" => "additionalBalcony",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "additionalTerrace",
            "name" => "additionalTerrace",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "additionalBasement",
            "name" => "additionalBasement",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "additionalAttic",
            "name" => "additionalAttic",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "additionalStorage",
            "name" => "additionalStorage",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "additionalEntresol",
            "name" => "additionalEntresol",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "additionalParking",
            "name" => "additionalParking",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "additionalParkingunderground",
            "name" => "additionalParkingunderground",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "additionalGarage",
            "name" => "additionalGarage",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "additionalGarden",
            "name" => "additionalGarden",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "securityIntercom",
            "name" => "securityIntercom",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "securityGuarded",
            "name" => "securityGuarded",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "securityReception",
            "name" => "securityReception",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "securityVideointercom",
            "name" => "securityVideointercom",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "securityGated",
            "name" => "securityGated",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "securitySecuredoor",
            "name" => "securitySecuredoor",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "securityBlinds",
            "name" => "securityBlinds",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "securityGrating",
            "name" => "securityGrating",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "securityVideocameras",
            "name" => "securityVideocameras",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "securityMonitoring",
            "name" => "securityMonitoring",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "securitySmokeDetector",
            "name" => "securitySmokeDetector",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "securityAccessControl",
            "name" => "securityAccessControl",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "securityAlarm",
            "name" => "securityAlarm",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "buildingElevatornumber",
            "name" => "buildingElevatornumber",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "buildingTwostorey",
            "name" => "buildingTwostorey",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "usableEnergyIndicator",
            "name" => "usableEnergyIndicator",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "finalEnergyIndicator",
            "name" => "finalEnergyIndicator",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "primaryEnergyIndicator",
            "name" => "primaryEnergyIndicator",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "co2EmissionUnit",
            "name" => "co2EmissionUnit",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "renewableEnergySourcesIndicator",
            "name" => "renewableEnergySourcesIndicator",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "buildingElevatorhoist",
            "name" => "buildingElevatorhoist",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "buildingAdapted",
            "name" => "buildingAdapted",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "buildingResidential",
            "name" => "buildingResidential",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "buildingFloornumber",
            "name" => "buildingFloornumber",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "buildingYear",
            "name" => "buildingYear",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "buildingType",
            "name" => "buildingType",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "buildingSwimmingpool",
            "name" => "buildingSwimmingpool",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "buildingMaterial",
            "name" => "buildingMaterial",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "buildingRoofmaterial",
            "name" => "buildingRoofmaterial",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "buildingRooftype",
            "name" => "buildingRooftype",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "buildingCarPark",
            "name" => "buildingCarPark",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "buildingConstruction",
            "name" => "buildingConstruction",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "buildingFlooring",
            "name" => "buildingFlooring",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "buildingHeating",
            "name" => "buildingHeating",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "buildingCondition",
            "name" => "buildingCondition",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "buildingAirConditioning",
            "name" => "buildingAirConditioning",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "buildingGym",
            "name" => "buildingGym",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "buildingCommecialStandard",
            "name" => "buildingCommecialStandard",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "mediaPhone",
            "name" => "mediaPhone",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "mediaInternet",
            "name" => "mediaInternet",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "mediaTelevision",
            "name" => "mediaTelevision",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "mediaWaterPurification",
            "name" => "mediaWaterPurification",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "mediaGas",
            "name" => "mediaGas",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "mediaWater",
            "name" => "mediaWater",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "mediaWell",
            "name" => "mediaWell",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "mediaCurrent",
            "name" => "mediaCurrent",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "mediaSewerage",
            "name" => "mediaSewerage",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "mediaCesspool",
            "name" => "mediaCesspool",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "apartmentBathroomType",
            "name" => "apartmentBathroomType",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "apartmentCurrentmeter",
            "name" => "apartmentCurrentmeter",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "apartmentHeatmeter",
            "name" => "apartmentHeatmeter",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "apartmentWatermeter",
            "name" => "apartmentWatermeter",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "apartmentGasmeter",
            "name" => "apartmentGasmeter",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "apartmentType",
            "name" => "apartmentType",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "recreationForest",
            "name" => "recreationForest",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "recreationPark",
            "name" => "recreationPark",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "recreationLake",
            "name" => "recreationLake",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "recreationSea",
            "name" => "recreationSea",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "communicationPks",
            "name" => "communicationPks",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "communicationBus",
            "name" => "communicationBus",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "communicationSuburbanrailway",
            "name" => "communicationSuburbanrailway",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "communicationSubway",
            "name" => "communicationSubway",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "communicationTram",
            "name" => "communicationTram",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "communicationTrolleybus",
            "name" => "communicationTrolleybus",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "communicationRailway",
            "name" => "communicationRailway",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "neighborhoodFitness",
            "name" => "neighborhoodFitness",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "neighborhoodPool",
            "name" => "neighborhoodPool",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "neighborhoodBank",
            "name" => "neighborhoodBank",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "neighborhoodPharmacy",
            "name" => "neighborhoodPharmacy",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "neighborhoodHospital",
            "name" => "neighborhoodHospital",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "neighborhoodAirport",
            "name" => "neighborhoodAirport",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "neighborhoodBazaar",
            "name" => "neighborhoodBazaar",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "neighborhoodShoppingcenter",
            "name" => "neighborhoodShoppingcenter",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "neighborhoodNursery",
            "name" => "neighborhoodNursery",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "neighborhoodKindergarten",
            "name" => "neighborhoodKindergarten",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "neighborhoodPlayground",
            "name" => "neighborhoodPlayground",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "neighborhoodPrimaryschool",
            "name" => "neighborhoodPrimaryschool",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "neighborhoodSecondaryschool",
            "name" => "neighborhoodSecondaryschool",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "neighborhoodUniversity",
            "name" => "neighborhoodUniversity",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "neighborhoodGrocery",
            "name" => "neighborhoodGrocery",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "locationtypeCenter",
            "name" => "locationtypeCenter",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "locationtypeOutsidecenter",
            "name" => "locationtypeOutsidecenter",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "locationtypeSuburbs",
            "name" => "locationtypeSuburbs",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "locationtypeOutsidecity",
            "name" => "locationtypeOutsidecity",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "locationtypeCountryside",
            "name" => "locationtypeCountryside",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "locationtypeOpenspace",
            "name" => "locationtypeOpenspace",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "locationtypeOther",
            "name" => "locationtypeOther",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "groundPlotNumber",
            "name" => "groundPlotNumber",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "groundPlotwidth",
            "name" => "groundPlotwidth",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "groundPlotheight",
            "name" => "groundPlotheight",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "groundType",
            "name" => "groundType",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "groundFencing",
            "name" => "groundFencing",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "groundShape",
            "name" => "groundShape",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "groundConditions",
            "name" => "groundConditions",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "groundRoad",
            "name" => "groundRoad",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "groundBuilding",
            "name" => "groundBuilding",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "groundOwnership",
            "name" => "groundOwnership",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "locationExportCityBiurowin",
            "name" => "locationExportCityBiurowin",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "locationExportPrecinctBiurowin",
            "name" => "locationExportPrecinctBiurowin",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "locationExportStreetBiurowin",
            "name" => "locationExportStreetBiurowin",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "locationExternalCityId",
            "name" => "locationExternalCityId",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "locationExternalDistrictId",
            "name" => "locationExternalDistrictId",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "priceVisibility",
            "name" => "priceVisibility",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "investmentName",
            "name" => "investmentName",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "investmentTypeId",
            "name" => "investmentTypeId",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "customField1",
            "name" => "customField1",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "customField2",
            "name" => "customField2",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "customField3",
            "name" => "customField3",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "customField4",
            "name" => "customField4",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "customField5",
            "name" => "customField5",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "customField6",
            "name" => "customField6",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "customField7",
            "name" => "customField7",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "customField8",
            "name" => "customField8",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "customField9",
            "name" => "customField9",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "customField10",
            "name" => "customField10",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "readyState",
            "name" => "readyState",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "officeProvisionSource",
            "name" => "officeProvisionSource",
            "object_type" => "field",
            "width" => "100%",
            "type" => "number",
        ),

        array(
            "title" => "offerBuildingId",
            "name" => "offerBuildingId",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "estateInvestmentBuildingReadyDate",
            "name" => "estateInvestmentBuildingReadyDate",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "estateInvestmentBuildingUuid",
            "name" => "estateInvestmentBuildingUuid",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "estateInvestmentOriginId",
            "name" => "estateInvestmentOriginId",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "estateInvestmentUuid",
            "name" => "estateInvestmentUuid",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "commercialHallUnloadingType",
            "name" => "commercialHallUnloadingType",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "saleOfficeName",
            "name" => "saleOfficeName",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "saleOfficePhone",
            "name" => "saleOfficePhone",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "saleOfficeMobile",
            "name" => "saleOfficeMobile",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "saleOfficeAddress",
            "name" => "saleOfficeAddress",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "source",
            "name" => "source",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "offerConditions",
            "name" => "offerConditions",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "locationBuildingnumber",
            "name" => "locationBuildingnumber",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "locationApartmentnumber",
            "name" => "locationApartmentnumber",
            "object_type" => "field",
            "width" => "100%",
            "type" => "text",
        ),

        array(
            "title" => "main_picture",
            "name" => "main_picture",
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
