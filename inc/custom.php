<?php

function growlink_getoption( $key = '', $default = false ) {
    if ( function_exists( 'cmb2_get_option' ) ) {
        // Use cmb2_get_option as it passes through some key filters.
        return cmb2_get_option( 'growlink_options', $key, $default );
    }
    // Fallback to get_option if CMB2 is not loaded yet.
    $opts = get_option( 'growlink_options', $default );
    $val = $default;
    if ( 'all' == $key ) {
        $val = $opts;
    } elseif ( is_array( $opts ) && array_key_exists( $key, $opts ) && false !== $opts[ $key ] ) {
        $val = $opts[ $key ];
    }
    return $val;
}

add_action( 'cmb2_admin_init', 'growlink_optionsdata' );
function growlink_optionsdata() {
    $cmb_options = new_cmb2_box( array(
        'id'           => 'growlink_options',
        'title'        => 'Options',
        'object_types' => array( 'options-page' ),
        'option_key'      => 'growlink_options', // The option key and admin menu page slug.
        'icon_url'        => 'dashicons-networking', // Menu icon. Only applicable if 'parent_slug' is left empty.
        'capability'      => 'edit_posts', // Cap required to view options-page.
    ));

    $cmb_options->add_field( array(
        'name' => 'Integrations API',
        'type' => 'title',
        'id'   => 'title'
    ) );

    $cmb_options->add_field(
        array(
            'name'       => 'Instagram Client ID',
            'id'         => 'ig_client_id',
            'type' => 'text',
        )
    );

    $cmb_options->add_field(
        array(
            'name'       => 'Instagram Client Secret',
            'id'         => 'ig_client_secret',
            'type' => 'text',
        )
    );

    $cmb_options->add_field( array(
        'name' => 'Scripts',
        'type' => 'title',
        'id'   => 'title2'
    ));

    $cmb_options->add_field(
        array(
            'name'       => 'Header scripts',
            'id'         => 'header_scripts',
            'type' => 'textarea_code',
        )
    );

     $cmb_options->add_field(
        array(
            'name'       => 'Footer scripts',
            'id'         => 'footer_scripts',
            'type' => 'textarea_code',
        )
    );
}

add_action( 'cmb2_admin_init', 'growlink_metapages' );
function growlink_metapages() {
    $prefix = 'growlink_';
    $cmb_demo = new_cmb2_box( array(
        'id'            => $prefix . 'pagemeta',
        'title'         => esc_html__( 'SEO', 'growlink' ),
        'object_types'  => array('page'), // Post type
    ));

    $cmb_demo->add_field( array(
        'name'       => esc_html__( 'Meta title', 'growlink' ),
        'id'         => $prefix . 'metatitle',
        'type'       => 'text',
    ) );

    $cmb_demo->add_field( array(
        'name'       => esc_html__( 'Meta Description', 'growlink' ),
        'id'         => $prefix . 'metadesc',
        'type'       => 'text',
    ) );

    $cmb_demo->add_field( array(
        'name'       => esc_html__( 'Meta Keywords', 'growlink' ),
        'id'         => $prefix . 'metakeys',
        'type'       => 'text',
    ) );
}


