<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
			<?php astra_content_bottom(); ?>

			</div> <!-- ast-container -->

		</div><!-- #content -->

		<?php astra_content_after(); ?>

		<?php astra_footer_before(); ?>

		<?php astra_footer(); ?>

		<?php astra_footer_after(); ?>

	</div><!-- #page -->

	<?php astra_body_bottom(); ?>
<?php
if( have_rows('footer','option') ):
    while( have_rows('footer','option') ) : the_row();
        the_sub_field('footer_script');
    endwhile;
endif;
include_once('cta-popup-form.php');
include_once('form-submitted.php');
?>
	<?php wp_footer(); ?>

	</body>
</html>
