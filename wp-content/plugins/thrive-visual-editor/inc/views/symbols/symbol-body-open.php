<?php
/**
 * FileName  symbol-body-open.php.
 *
 * @project  : thrive-visual-editor
 * @developer: Dragos Petcu
 * @company  : BitStone
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden!
}
?>

<?php $is_gutenberg_preview = isset( $_GET['tve_block_preview'] ); ?>
<!doctype html>
<html <?php language_attributes(); ?> style="overflow: unset;">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<title>
		<?php wp_title( '' ); ?><?php echo wp_title( '', false ) ? ' :' : ''; ?><?php bloginfo( 'name' ); ?>
	</title>
	<meta name="description" content="<?php bloginfo( 'description' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> style="overflow: unset;">
<?php if ( $is_gutenberg_preview ) { ?>
	<style type="text/css">#wpadminbar, .symbol-extra-info {
            display: none !important;
        }</style>

	<script>
		document.addEventListener( "DOMContentLoaded", () => {
			if ( window.TVE_Dash ) {
				TVE_Dash.forceImageLoad( document );
			}
		} );
	</script>
<?php } ?>
<div class="sym-new-container">
