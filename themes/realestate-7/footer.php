<?php
/**
 * Footer Template
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */
 
global $ct_options;

$ct_footer_widget = isset( $ct_options['ct_footer_widget'] ) ? esc_attr( $ct_options['ct_footer_widget'] ) : '';
$ct_footer_text = isset( $ct_options['ct_footer_text'] ) ? esc_attr( $ct_options['ct_footer_text'] ) : '';
$ct_footer_back_to_top = isset( $ct_options['ct_footer_back_to_top'] ) ? esc_attr( $ct_options['ct_footer_back_to_top'] ) : '';
$ct_boxed = isset( $ct_options['ct_boxed'] ) ? esc_attr( $ct_options['ct_boxed'] ) : '';

if(!empty($ct_options['ct_footer_background_img']['url'])) {
    echo '<style type="text/css">';
    echo '#footer-widgets { background-image: url(' . esc_html($ct_options['ct_footer_background_img']['url']) . '); background-repeat: no-repeat; background-position: center center; background-size: cover;}';
    echo '</style>';
}

?>
            <div class="clear"></div>
            
        </section>
        <!-- //Main Content -->

        <?php do_action('before_footer_widgets'); ?>
        
        <?php if($ct_footer_widget == 'yes') {
        echo '<!-- Footer Widgets -->';
        echo '<div id="footer-widgets">';
            echo '<div class="dark-overlay">';
                echo '<div class="container">';
        				if (is_active_sidebar('footer')) {
                            dynamic_sidebar('Footer');
                        }
                        echo '<div class="clear"></div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
        echo '<!-- //Footer Widgets -->';
        } ?>

        <?php do_action('before_footer'); ?>
        
        <!-- Footer -->
        <footer class="footer muted">
            <div class="container">   
                <?php ct_footer_nav(); ?>
                    
                <?php if($ct_footer_text) {
                    $ct_allowed_html = array(
                        'a' => array(
                            'href' => array(),
                            'title' => array()
                        ),
                        'em' => array(),
                        'strong' => array(),
                    );
                ?>
                    <p class="marB0 right"><?php echo wp_kses(stripslashes($ct_options['ct_footer_text']), $ct_allowed_html); ?>. <?php if($ct_footer_back_to_top != 'no') { echo '<a href="#top">' . esc_html( 'Back to top', 'contempo' ) . '</a>'; } ?></p>
                <?php } else { ?>
                    <p class="marB0 right">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>, <?php esc_html_e( 'All Rights Reserved.', 'contempo' ); ?> <?php if($ct_footer_back_to_top != 'no') { echo '<a id="back-to-top" href="#top">' . esc_html( 'Back to top ', 'contempo' ) . '</a>'; } ?></p>
                <?php } ?>
                <div class="clear"></div>
            </div>
        </footer>
        <!-- //Footer -->
        
    <?php if($ct_boxed == "boxed") {
	echo '</div>';
    echo '<!-- //Wrapper -->';
	} ?>

    <?php do_action('after_wrapper'); ?>

	<?php wp_footer(); ?>
</body>
</html>