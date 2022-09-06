<?php
/**
 * The header for Astra Theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?><!DOCTYPE html>
<?php astra_html_before(); ?>
<html <?php language_attributes(); ?>>
<head>
<?php astra_head_top(); ?>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="https://gmpg.org/xfn/11">
    <?php
    $post_type = get_queried_object();
    if($post_type->name === "reports"): ?>
        <meta property=”og:title” content=”Custom Company Profile | Competitive Intelligence | Industry Insight | Account Based Marketing (ABM) Research Reports - Business Brainz” />
        <meta property=”og:description” content=”Explore Custom Company Profile Reports | Competitive Intelligence Reports | Industry Insight Reports from Business Brainz. Outstanding Account based  Marketing Research Reports for IT Strategy and SWOT analysis.” />
        <title>Custom Company Profile | Competitive Intelligence | Industry Insight | Account Based Marketing (ABM) Research Reports - Business Brainz</title>
        <meta name="description" content="Explore Custom Company Profile Reports | Competitive Intelligence Reports | Industry Insight Reports from Business Brainz. Outstanding Account based  Marketing Research Reports for IT Strategy and SWOT analysis.">
  <?php endif ?>


<?php businsesBrainz_custom_tracker(); ?>
<?php wp_head(); ?>
<?php astra_head_bottom(); ?>

    <?php
        $header_scripts = get_field('header','option');
    if( have_rows('header','option') ):
        while( have_rows('header','option') ) : the_row();
            the_sub_field('header_script');
        endwhile;
    endif;
    render_schema_data(get_the_ID());
    ?>
    <link rel="stylesheet" type="text/css" href="https://cdn.wpcc.io/lib/1.0.2/cookieconsent.min.css"/><script src="https://cdn.wpcc.io/lib/1.0.2/cookieconsent.min.js" defer></script><script>window.addEventListener("load", function(){window.wpcc.init({"border":"thin","corners":"small","colors":{"popup":{"background":"#f6f6f6","text":"#000000","border":"#555555"},"button":{"background":"#555555","text":"#ffffff"}},"position":"bottom","content":{"message":"We use cookies and other tracking technologies to improve your browsing experience on our website, to show you personalized content and targeted ads, to analyze our website traffic, and to understand where our visitors are coming from. By browsing our website, you consent to our use of cookies and other tracking technologies.","href":"https://www.businessbrainz.com/cookie-policy/"}})});</script>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl+ '&gtm_auth=zJxpUDOYzK_CFAVS3cUk7w&gtm_preview=env-8&gtm_cookies_win=x';f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-W8335XN');</script>
<!-- End Google Tag Manager -->
	
</head>

<body <?php astra_schema_body(); ?> <?php body_class(); ?>>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W8335XN&gtm_auth=zJxpUDOYzK_CFAVS3cUk7w&gtm_preview=env-8&gtm_cookies_win=x"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<?php astra_body_top(); ?>
<?php wp_body_open(); ?>
<div 
	<?php
	echo astra_attr(
		'site',
		array(
			'id'    => 'page',
			'class' => 'hfeed site',
		)
	);
	?>
>
	<a class="skip-link screen-reader-text" href="#content"><?php echo esc_html( astra_default_strings( 'string-header-skip-link', false ) ); ?></a>

	<?php astra_header_before(); ?>

	<?php astra_header(); ?>

	<?php astra_header_after(); ?>

	<?php astra_content_before(); ?>


    <a href="/reports"><div class="sticky-ads">View our reports</div></a>
	<div id="content" class="site-content">

		<div class="ast-container">

		<?php astra_content_top(); ?>
