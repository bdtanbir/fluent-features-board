<!doctype html>
<html <?php language_attributes(); ?> <?php twentytwentyone_the_html_classes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php 
        wp_head();
        /**
         * Template Name: Fluent Features Request
         */
    ?>
</head>

<body <?php body_class('fluent-features-request-lists-wrapper'); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">

	<div id="content" class="site-content">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">

                <div class="ff-request-list-single-wrap">
                    <h3>Hello I am From Request Single</h3>
                </div>

			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!-- #content -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>

