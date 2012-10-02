<?php
global $_ppt;

// Fixed styles
$about_padding = '0 150px 0 0px';
$about_margin = '-35px auto 0 50px';

$logo_padding = '50px 0 0 0';
$logo_margin = '0 50px 0 auto';
$logo_align = 'right';

$background_fade = 'left: 0; background: url("' . get_bloginfo( 'stylesheet_directory' ) . '/images/gradient-left.png") repeat-y scroll top left; ';

if ( of_get_option( 'layout', $_ppt['std']['layout']) === 'right' ) {
	$about_padding = '0 0 0 150px';
	$about_margin = '-35px 50px 0 auto';

	$logo_padding = '50px 0 0 0';
	$logo_margin = '0 auto 0 50px';
	$logo_align = 'left';

	$background_fade = 'right: 0; background: url("' . get_bloginfo( 'stylesheet_directory' ) . '/images/gradient-right.png") repeat-y scroll top left; ';

}

// Other
$about_width = of_get_option( 'about_width', $_ppt['std']['about_width'] );
if ( $about_width === '' ) {
	$about_width = $_ppt['std']['about_width'];
}

$background_color = of_get_option( 'background_color', $_ppt['std']['background_color']);
$link_color = of_get_option( 'link_color' ,$_ppt['std']['link_color']);
$link_hover_color = of_get_option( 'link_hover_color', $_ppt['std']['link_hover_color']);
$link_underline_color = of_get_option( 'link_underline_color', $_ppt['std']['link_underline_color']);
$link_underline_color_rvb = implode( ',', hex2rgb($link_underline_color) );
$link_weight = of_get_option( 'link_weight', $_ppt['std']['link_weight']);

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><?php bloginfo( 'name' ); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<?php if ( of_get_option( 'head' ) ): ?><?php echo of_get_option( 'head' ); ?><?php endif; ?>

	<?php echo options_typography_google_fonts(); ?>

	<!--[if IE]><meta http-equiv="imagetoolbar" content="false" /><![endif]-->
	<!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->	
	<style>
		<?php if ( of_get_option( 'custom_css_only', $_ppt['std']['custom_css_only'] ) !== '1' ): ?>

		* { padding: 0; margin: 0; }
		body { background-color: <?php echo $background_color; ?>; <?php echo options_typography_font_styles( of_get_option( 'font_paragraphs', $_ppt['std']['font_paragraphs'] )); ?> }
		#about img, #logo img { width: auto\9; height: auto; max-width: 100%; vertical-align: middle; border: 0; -ms-interpolation-mode: bicubic; }
		h1,h2,h3,h4,h5,h6 { <?php echo options_typography_font_styles( of_get_option( 'font_headings', $_ppt['std']['font_headings'] )); ?> margin-bottom: 22px; -webkit-font-smoothing: antialiased; }
		p { margin-bottom: 22px; -webkit-font-smoothing: antialiased; }
		a { color: <?php echo $link_color; ?>; font-weight: <?php echo $link_weight ?>; text-decoration: none; <?php if ( of_get_option( 'link_underline_disabled', $_ppt['std']['link_underline_disabled'] ) !== '1' ): ?>border-bottom: 1px solid rgba(<?php echo $link_underline_color_rvb ?>,0.3);<?php endif; ?> -webkit-transition: all .2s ease 0s; -moz-transition: all .2s ease 0s; -o-transition: all .2s ease 0s; transition: all .2s ease 0s; }
		a:hover { color: <?php echo $link_hover_color; ?>; <?php if ( of_get_option( 'link_underline_disabled', $_ppt['std']['link_underline_disabled'] ) !== '1' ): ?>border-bottom: 1px solid rgba(<?php echo $link_underline_color_rvb ?>,1);<?php endif; ?> }
		ul { list-style-position: inside; }
		#logo { width: 50px; padding: <?php echo $logo_padding; ?>; margin: <?php echo $logo_margin; ?>; text-align: <?php echo $logo_align; ?>; }
		#about { width: <?php echo $about_width; ?>; padding: <?php echo $about_padding; ?>; margin: <?php echo $about_margin; ?> !important; }
		.icon { margin: 0 5px 10px 0; display: inline-block;}
		a.icon, a img { border-bottom : none; }
		a:hover.icon { opacity: 0.7; }
		<?php if ( of_get_option( 'background_fade', $_ppt['std']['background_fade'] ) ): ?>#fade { z-index: -999998; width: 450px; height: 100%; position: absolute; top:0; <?php echo $background_fade; ?> }<?php endif; ?>

		@media (max-width: 767px) {
			#logo { position: relative; width: auto; padding: 20px; margin: 0; text-align: left; }
			#about { position: relative; width: auto; padding: 20px; margin: 0 !important; }
			#backstretch { display: none; }
			<?php if ( of_get_option( 'background_fade', $_ppt['std']['background_fade'] ) ): ?>#fade { display: none; }<?php endif; ?>
		}

		<?php if ( of_get_option( 'css' ) ): ?><?php echo of_get_option( 'css' ); ?><?php endif; ?>

		<?php endif; ?>

	</style>
	<?php wp_head(); ?>

</head>	
    
<body>

<div id="fade"></div>

<div id="logo">
	<?php if ( of_get_option( 'logo' ) ): ?><img src="<?php echo of_get_option( 'logo' ); ?>" alt="<?php bloginfo( 'name' ); ?>" /><?php endif; ?><?php if ( of_get_option( 'logo' ) === false ): ?><img src="<?php echo get_bloginfo( 'stylesheet_directory' ) . '/images/' . $_ppt['std']['logo']; ?>" alt="<?php bloginfo( 'name' ); ?>" /><?php endif; ?>
</div>

<div id="about">
	<?php echo apply_filters( 'the_content', of_get_option( 'content', $_ppt['std']['content'] ) ); ?>

	<p>
		<?php if ( of_get_option( 'email' ) ): ?><a href="mailto:<?php echo of_get_option( 'email' ); ?>" class="icon"><img src="<?php echo get_bloginfo('stylesheet_directory'); ?>/icons/email_32.png" alt="Email" /></a><?php endif; ?>
		<?php if ( of_get_option( 'skype' ) ): ?><a href="skype:<?php echo of_get_option( 'skype' ); ?>?call" class="icon"><img src="<?php echo get_bloginfo('stylesheet_directory'); ?>/icons/skype_32.png" alt="Skype" /></a><?php endif; ?>
		<?php if ( of_get_option( 'facebook_url', $_ppt['std']['facebook_url'] ) ): ?><a href="<?php echo of_get_option( 'facebook_url', $_ppt['std']['facebook_url'] ); ?>" class="icon"><img src="<?php echo get_bloginfo('stylesheet_directory'); ?>/icons/facebook_32.png" alt="Facebook" /></a><?php endif; ?>
		<?php if ( of_get_option( 'twitter_url', $_ppt['std']['twitter_url']) ): ?><a href="<?php echo of_get_option( 'twitter_url', $_ppt['std']['twitter_url'] ); ?>" class="icon"><img src="<?php echo get_bloginfo('stylesheet_directory'); ?>/icons/twitter_32.png" alt="Twitter" /></a><?php endif; ?>
		<?php if ( of_get_option( 'googleplus_url' ) ): ?><a href="<?php echo of_get_option( 'googleplus_url' ); ?>" class="icon"><img src="<?php echo get_bloginfo('stylesheet_directory'); ?>/icons/google_plus_32.png" alt="Google+" /></a><?php endif; ?>
		<?php if ( of_get_option( 'linkedin_url' ) ): ?><a href="<?php echo of_get_option( 'linkedin_url' ); ?>" class="icon"><img src="<?php echo get_bloginfo('stylesheet_directory'); ?>/icons/linkedin_32.png" alt="Linkedin" /></a><?php endif; ?>
		<?php if ( of_get_option( 'flickr_url' ) ): ?><a href="<?php echo of_get_option( 'flickr_url' ); ?>" class="icon"><img src="<?php echo get_bloginfo('stylesheet_directory'); ?>/icons/flickr_32.png" alt="Flickr" /></a><?php endif; ?>
		<?php if ( of_get_option( 'dribbble_url' ) ): ?><a href="<?php echo of_get_option( 'dribbble_url' ); ?>" class="icon"><img src="<?php echo get_bloginfo('stylesheet_directory'); ?>/icons/dribbble_32.png" alt="Dribbble" /></a><?php endif; ?>
		<?php if ( of_get_option( 'vimeo_url' ) ): ?><a href="<?php echo of_get_option( 'vimeo_url' ); ?>" class="icon"><img src="<?php echo get_bloginfo('stylesheet_directory'); ?>/icons/vimeo_32.png" alt="Vimeo" /></a><?php endif; ?>
		<?php if ( of_get_option( 'tumblr_url' ) ): ?><a href="<?php echo of_get_option( 'tumblr_url' ); ?>" class="icon"><img src="<?php echo get_bloginfo('stylesheet_directory'); ?>/icons/tumblr_32.png" alt="Tumblr" /></a><?php endif; ?>

	</p>
	
</div>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo get_bloginfo('stylesheet_directory'); ?>/js/jquery.backstretch.min.js"></script>
<script type="text/javascript">
$(function(){
     $(window).resize(function(){
         if($(this).width() >= 767){
             $.backstretch("<?php if ( of_get_option( 'background' ) ) { echo background_src(); } else { echo get_bloginfo( 'stylesheet_directory' ) . '/images/' . of_get_option( 'default_background', $_ppt['std']['default_background'] ); } ?>", {speed: 150});
         }
      })
      .resize();
});
</script>
<?php wp_footer(); ?>

<?php if ( of_get_option( 'tracking_code' ) ): ?><?php echo of_get_option( 'tracking_code' ); ?><?php endif; ?>

</body>	
</html>