<?php

namespace WCL\PostTypes;

class Course
{
    public const POST_TYPE = 'course';

    public function register(): void
    {
        if ( post_type_exists( self::POST_TYPE ) ) {
            return;
        }

        register_post_type(
            self::POST_TYPE,
            [
                'label'              => __( 'Courses', 'wp-courses-lite' ),
                'public'             => true,
                'has_archive'        => false,
                'show_in_rest'       => true,
                'supports'           => [ 'title', 'editor', 'thumbnail' ],
                'rewrite'            => [ 'slug' => 'course' ],
                'show_ui'            => true,
                'show_in_menu'       => true,
                'menu_position'      => 20,
                'menu_icon'          => 'dashicons-welcome-learn-more',
                'capability_type'    => 'post',
                'map_meta_cap'       => true,
            ]
        );
    }
}
