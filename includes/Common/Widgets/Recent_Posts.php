<?php

namespace WP_Starter\Common\Widgets;

class Recent_Posts extends \WP_Widget {

    public $defaults;

    public function __construct() {

        parent::__construct(
            'wp_starter_recent_posts',
            __( 'Wp Starter Recent Posts', 'textdomain' ),
            [
                'classname'   => 'wp-starter_recent_posts_widget',
                'description' => __( 'Add Recent Posts widget to sidebar.', 'textdomain' ),
            ]
        );
    }

    public function widget( $args, $instance ) {
        $q = new \WP_Query( [
            'posts_per_page'      => array_default( 'number', $instance, 5 ),
            'post_status'         => 'publish',
            'no_found_rows'       => true,
            'ignore_sticky_posts' => true,
        ] );

        if ( $q->have_posts() ):
        
            echo wp_kses_post( $args['before_widget'] );

            if ( ! empty( $instance['title'] ) ) {
                echo wp_kses_post( $args['before_title'] . $instance['title'] . $args['after_title'] );
            }
        ?>
            <ul>
            <?php
            while ( $q->have_posts() ):
                $q->the_post();
                ?>
                <li>
                    <?php the_post_thumbnail() ?>
                    <div class="post-content">
                        <h4 class="post-title">
                            <a href="<?php the_permalink() ?>"> <?php the_title(); ?> </a>
                        </h4>
                        <?php
                            if ( isset( $instance['show_date'] ) && $instance['show_date'] == 1 ):
                                the_date();
                            endif;
                        ?>
                    </div>
                </li>
                <?php
            endwhile;

            echo wp_kses_post( $args['after_widget'] );
            ?>
            </ul>
        <?php endif;

        wp_reset_postdata();
    }

    public function form( $instance ) {
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ) ?>">
                <?php _e( 'Title', 'textdomain' ) ?>
            </label>
            <input
                type="text"
                class="widefat"
                id="<?php echo esc_attr( $this->get_field_id( 'title' ) ) ?>"
                name="<?php echo esc_attr( $this->get_field_name( 'title' ) ) ?>"
                value="<?php echo esc_attr( array_default( 'title', $instance, 'WP Starter Recent Posts' ) ) ?>"
            />
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ) ?>">
                <?php _e( 'Number of posts', 'textdomain' ) ?>
            </label>
            <input
                type="text"
                class="widefat"
                id="<?php echo esc_attr( $this->get_field_id( 'number' ) ) ?>"
                name="<?php echo esc_attr( $this->get_field_name( 'number' ) ) ?>"
                value="<?php echo esc_attr( array_default( 'number', $instance, 5 ) ) ?>"
            />
        </p>
        <p>
            <input
                type="checkbox"
                class="checkbox"
                value="1"
                id="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ) ?>"
                name="<?php echo esc_attr( $this->get_field_name( 'show_date' ) ) ?>"
                <?php echo checked( array_default( 'show_date', $instance, '1' ), '1' ) ?>
            />
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ) ?>">
                <?php _e( 'Show Date', 'textdomain' ) ?>
            </label>
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance['title']     = $new_instance['title'];
        $instance['number']    = $new_instance['number'];
        $instance['show_date'] = array_default( 'show_date', $new_instance, 0 );

        return $instance;
    }
}
