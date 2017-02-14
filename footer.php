<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package base_theme
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">

<?php

if (! is_active_sidebar('footer-widget-area' )) {
return;
} 
?>

<div class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'footer-widget-area' ); ?>
</div><!-- #secondary -->


<?php wp_nav_menu( array(
'theme_location' => 'secondary-menu',
'container_class' => 'secondary-menu')
); ?>

		<div class="site-info">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'base_theme' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'base_theme' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'base_theme' ), 'base_theme', '<a href="https://automattic.com/" rel="designer">Underscores.me</a>' ); ?>
		</div><!-- .site-info -->



	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
