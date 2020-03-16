<?php
	$sidebar = cao_sidebar();
	$column_classes = cao_column_classes( $sidebar );
	get_header();
?>

<div class="container">

	<div class="row">
		<div class="<?php echo esc_attr( $column_classes[0] ); ?>">
			<div class="content-area">
				<main class="site-main">
					<?php while ( have_posts() ) : the_post();
						get_template_part( 'parts/template-parts/content', 'single' );
					endwhile; ?>
				</main>
			</div>
		</div>
		
		
	</div>
</div>

<?php
  get_template_part( 'parts/related-posts' );
?>
<?php get_footer(); ?>