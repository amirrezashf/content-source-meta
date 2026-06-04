<?php
/**
 * Plugin Name: منبع محتوای مطالب
 * Description: افزودن فیلد لینک و نام منبع به مطالب وردپرس و نمایش آن در انتهای محتوا.
 * Version: 1.0.0
 * Author: امیررضا شایسته‌فر
 * Text Domain: content-source-meta
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Content_Source_Meta {

    public function __construct() {
        add_action( 'add_meta_boxes', [ $this, 'add_meta_box' ] );
        add_action( 'save_post_post', [ $this, 'save_meta_data' ] );
        add_filter( 'the_content', [ $this, 'display_source' ] );
    }

    public function add_meta_box() {
        add_meta_box(
            'content_source_meta_box',
            'منبع محتوا (در صورت لزوم)',
            [ $this, 'render_meta_box' ],
            'post',
            'normal',
            'high'
        );
    }

    public function render_meta_box( $post ) {
        wp_nonce_field( 'content_source_meta_save', 'content_source_meta_nonce' );

        $url    = get_post_meta( $post->ID, 'custom_url', true );
        $source = get_post_meta( $post->ID, 'custom_source', true );
        ?>
        <p>
            <label for="custom_url">لینک سایت منبع:</label>
            <input
                type="url"
                name="custom_url"
                id="custom_url"
                value="<?php echo esc_url( $url ); ?>"
                style="width:100%; margin-top:6px;"
            >
        </p>

        <p>
            <label for="custom_source">اسم سایت منبع:</label>
            <input
                type="text"
                name="custom_source"
                id="custom_source"
                value="<?php echo esc_attr( $source ); ?>"
                style="width:100%; margin-top:6px;"
            >
        </p>
        <?php
    }

    public function save_meta_data( $post_id ) {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if (
            ! isset( $_POST['content_source_meta_nonce'] ) ||
            ! wp_verify_nonce( $_POST['content_source_meta_nonce'], 'content_source_meta_save' )
        ) {
            return;
        }

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        if ( isset( $_POST['custom_url'] ) ) {
            update_post_meta(
                $post_id,
                'custom_url',
                esc_url_raw( wp_unslash( $_POST['custom_url'] ) )
            );
        }

        if ( isset( $_POST['custom_source'] ) ) {
            update_post_meta(
                $post_id,
                'custom_source',
                sanitize_text_field( wp_unslash( $_POST['custom_source'] ) )
            );
        }
    }

    public function display_source( $content ) {
        if ( ! is_singular( 'post' ) || ! in_the_loop() || ! is_main_query() ) {
            return $content;
        }

        $post_id = get_the_ID();
        $url     = get_post_meta( $post_id, 'custom_url', true );
        $source  = get_post_meta( $post_id, 'custom_source', true );

        if ( empty( $url ) || empty( $source ) ) {
            return $content;
        }

        $source_content = sprintf(
            '<p class="content-source-meta">منبع محتوا: <a href="%s" target="_blank" rel="noopener noreferrer">%s</a></p>',
            esc_url( $url ),
            esc_html( $source )
        );

        return $content . $source_content;
    }
}

new Content_Source_Meta();
