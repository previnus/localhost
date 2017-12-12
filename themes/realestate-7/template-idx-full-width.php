<?php
/**
 * Template Name: IDX Full Width
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */

get_header();

while ( have_posts() ) : the_post(); ?>

	<?php do_action('before_page_header'); ?>

	<!-- Single Header -->
	<div id="single-header">
		<div class="dark-overlay">
			<div class="container">
				<h1 class="marT0 marB0"><?php the_title(); ?></h1>
			</div>
		</div>
	</div>
	<!-- //Single Header -->

	<?php do_action('before_page_content'); ?>

	<!-- Container -->
	<div class="container padB60">

		<!-- Page Content -->
		<div class="page-content col span_12 first">

			<!-- Inner Content -->
			<div class="inner-content">
				<?php the_content(); ?>
			</div>
			<!-- //Inner Content -->
			
		</div>
		<!-- //Page Content -->

	<?php endwhile; ?>

	</div>
	<!-- //Container -->

<?php get_footer(); ?>