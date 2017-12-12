<?php
/**
 * Getting Started
 *
 * @package WP Pro Real Estate 7
 * @subpackage Admin
 */

function ct_load_admin_scripts() {

	// Load styles only on our page
	global $pagenow;
	if( 'themes.php' != $pagenow )
		return;

	wp_enqueue_script( 'ct-getting-started', get_template_directory_uri() . '/admin/getting-started/getting-started.js', array( 'jquery' ), '1.0.0', true );
	wp_enqueue_script( 'ct-getting-started-fitvid', get_template_directory_uri() . '/js/jquery.fitvids.js', array( 'jquery' ), '1.0', true );
	wp_enqueue_style( 'ct-getting-started', get_template_directory_uri() . '/admin/getting-started/getting-started.css', false, '1.0.0' );
	add_thickbox();
}
add_action( 'admin_enqueue_scripts', 'ct_load_admin_scripts' );

class ct_getting_started_admin {

	protected $theme_slug = null;
	protected $version = null;
	protected $author = null;
	protected $strings = null;

	function __construct( $config = array(), $strings = array() ) {

		$config = wp_parse_args( $config, array(
			'remote_api_url' => '',
			'theme_slug' => get_template(),
			'api_slug' => get_template() . '-wordpress-theme',
			'item_name' => '',
			'license' => '',
			'version' => '',
			'author' => '',
			'download_id' => '',
			'renew_url' => ''
		) );

		// Set config arguments
		$this->item_name = $config['item_name'];
		$this->theme_slug = sanitize_key( $config['theme_slug'] );
		$this->version = $config['version'];
		$this->author = $config['author'];

		// Populate version fallback
		if ( '' == $config['version'] ) {
			$theme = wp_get_theme( $this->theme_slug );
			$this->version = $theme->get( 'Version' );
		}

		// Strings passed in from the updater config
		$this->strings = $strings;

		add_action( 'admin_menu', array( $this, 'ct_getting_started_menu' ) );

	}

	function ct_getting_started_menu() {

		$strings = $this->strings;

		add_theme_page(
			$strings['getting-started'],
			$strings['getting-started'],
			'manage_options',
			$this->theme_slug . '-getting-started',
			array( $this, 'ct_getting_started_page' )
		);
	}

	function ct_getting_started_page() {

		$strings = $this->strings;

		// Theme info
		$theme = wp_get_theme( 'realestate-7' );
		$theme_name_lower = get_template();
	?>


			<div class="wrap getting-started">
				<h2 class="notices"></h2>
				<div class="intro-wrap">
					<img class="theme-image" src="<?php echo get_template_directory_uri() . '/screenshot.png'; ?>" alt="" />
					<div class="intro">
						<h3><?php printf( __( 'Getting started with %1$s v%2$s', 'contempo' ), $theme['Name'], $theme['Version'] ); ?></h3>

						<h4><?php printf( __( 'Thanks for purchasing %1$s! I truly appreciate the support and the opportunity to share my work with you. Please visit the tabs below to get started setting up your theme!', 'contempo' ), $theme['Name'] ); ?></h4>
					</div>
				</div>

				<div class="panels">
					<ul class="inline-list">
						<li class="current"><a id="help" href="#"><i class="fa fa-check"></i> <?php _e( 'Start Here', 'contempo' ); ?></a></li>
						<li><a id="plugins" href="#"><i class="fa fa-plug"></i> <?php _e( 'Plugins', 'contempo' ); ?></a></li>
						<li><a id="support" href="#"><i class="fa fa-question-circle"></i> <?php _e( 'FAQ &amp; Support', 'contempo' ); ?></a></li>
						<li><a id="updates" href="#"><i class="fa fa-refresh"></i> <?php _e( 'Latest Updates', 'contempo' ); ?></a></li>
					</ul>

					<div id="panel" class="panel">

						<!-- Help file panel -->
						<div id="help-panel" class="panel-left visible">

							<h3><?php printf( __( 'Installing %s', 'contempo' ), $theme['Name'] ); ?></h3>

							<!-- Installation Video -->
							<iframe width="560" height="315" src="https://www.youtube.com/embed/qECw_cUIMsM" frameborder="0" allowfullscreen></iframe>
							<!-- //Installation Video -->

							<h3 class="marT25"><?php _e('Documentation', 'contempo'); ?></h3>

							<ul class="toc">
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#installation'); ?>">Installation</a></li>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#videos'); ?>">Instructional Videos</a></li>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#homepage'); ?>">Homepage Setup</a></li>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#listings'); ?>">Adding &amp; Managing Listings</a></li>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#taxonomies'); ?>">Custom Taxonomies and Usage</a></li>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#images'); ?>">Uploading Listing &amp; Blog Post Images</a></li>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#catimages'); ?>">Custom Category Header Background Images</a></li>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#navigation'); ?>">Building Out Your Navigation, "Find a Home"</a></li>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#megamenus'); ?>">Using Mega Menus</a></li>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#blog'); ?>">Setting Up Your Blog</a></li>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#frontend'); ?>">Front End Listing System</a></li>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#agents'); ?>">Agents</a></li>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#brokerages'); ?>">Brokerages</a></li>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#openhouse'); ?>">Open Houses</a></li>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#colisting'); ?>">Co-listing</a></li>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#sublistings'); ?>">Sub Listings</a></li>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#idx'); ?>">IDX Plugins</a></li>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#customizer'); ?>">Advanced Theme Customizer</a></li>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#visualcomposer'); ?>">Visual Composer</a></li>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#revslider'); ?>">Revolution Slider</a></li>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#compare'); ?>">Compare Listings</a></li>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#emailalerts'); ?>#">Saved Search &amp; Email Alerts</a></li>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#wpfavorites'); ?>">WP Favorite Posts</a></li>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#booking'); ?>">Booking Calendar</a>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#reviews'); ?>">Listing Reviews</a>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#walkscore'); ?>">Walk Score</a></li>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#whatsnearby'); ?>">Setting up "What's Nearby?" for Listings</a></li>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#wpallimport'); ?>">WP All Import</a></li>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#permalinks'); ?>">Using Permalinks</a></li>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#templates'); ?>">Custom Page Templates</a></li>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#widgets'); ?>">Custom Widgets</a></li>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#wpml'); ?>">WPML</a></li>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#translation'); ?>">Translation</a></li>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#css'); ?>">CSS</a></li>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#javascript'); ?>">JavaScript</a></li>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#psd'); ?>">PSD</a></li>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#childthemes'); ?>">Child Theme Generator</a></li>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#advdev'); ?>">Advanced Development</a></li>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#support'); ?>">Support</a></li>
							    <li><a href="<?php echo admin_url('admin.php?page=WPProRealEstate7&tab=52#faq'); ?>">FAQ</a></li>         
							</ul>
						</div>

						<!-- Updates panel -->
						<div id="plugins-panel" class="panel-left">
							<h4><?php _e( 'Required & Recommended Plugins', 'contempo' ); ?></h4>

							<p><?php _e( 'Below is a list of required and recommended plugins to install that will help you get the most out of WP Pro Real Estate 7. To begin please use the button below or browse through the list to learn about each one in a little more detail.', 'contempo' ); ?></p>

							<p><a class="button button-primary" href="<?php echo admin_url('themes.php?page=tgmpa-install-plugins'); ?>">Install Plugins</a></p>

							<hr/>

							<h4><span class="snipe required"><?php _e('Required', 'contempo'); ?></span> <?php _e( 'Redux Framework', 'contempo' ); ?>
								<?php if ( ! class_exists('Redux') ) { ?>
									<a class="button button-secondary" href="<?php echo admin_url('themes.php?page=tgmpa-install-plugins'); ?>" title="<?php esc_attr_e( 'Install Redux Framework', 'contempo' ); ?>"><i class="fa fa-download"></i> <?php _e( 'Install Now', 'contempo' ); ?></a>
								<?php } else { ?>
									<span class="button button-secondary disabled"><i class="fa fa-check"></i> <?php _e( 'Installed', 'contempo' ); ?></span>
								<?php } ?>
							</h4>

							<p><?php _e( 'This plugin is used for the admin options framework.', 'contempo' ); ?></p>

							<hr/>

							<h4><span class="snipe required"><?php _e('Required', 'contempo'); ?></span> <?php _e( 'Contempo Real Estate Custom Posts', 'contempo' ); ?>
								<?php if ( ! function_exists('ct_recp_load_textdomain') ) { ?>
									<a class="button button-secondary" href="<?php echo admin_url('themes.php?page=tgmpa-install-plugins'); ?>" title="<?php esc_attr_e( 'Install Contempo Real Estate Custom Posts', 'contempo' ); ?>"><i class="fa fa-download"></i> <?php _e( 'Install Now', 'contempo' ); ?></a>
								<?php } else { ?>
									<span class="button button-secondary disabled"><i class="fa fa-check"></i> <?php _e( 'Installed', 'contempo' ); ?></span>
								<?php } ?>
							</h4>

							<p><?php _e( 'This plugin registers the listings, brokerages & testimonials custom post types, along with related custom fields & taxonomies, as well as all the custom Visual Composer modules (if you have the Visual Composer plugin installed & activated).', 'contempo' ); ?></p>

							<hr/>

							<h4><span class="snipe required"><?php _e('Required', 'contempo'); ?></span> <?php _e( 'Contempo Real Estate 7 Extensions Loader', 'contempo' ); ?>
								<?php if ( ! function_exists('redux_register_custom_extension_loader') ) { ?>
									<a class="button button-secondary" href="<?php echo admin_url('themes.php?page=tgmpa-install-plugins'); ?>" title="<?php esc_attr_e( 'Install Contempo Real Estate 7 Extensions Loader', 'contempo' ); ?>"><i class="fa fa-download"></i> <?php _e( 'Install Now', 'contempo' ); ?></a>
								<?php } else { ?>
									<span class="button button-secondary disabled"><i class="fa fa-check"></i> <?php _e( 'Installed', 'contempo' ); ?></span>
								<?php } ?>
							</h4>

							<p><?php _e( 'This includes required extensions for the theme.', 'contempo' ); ?></p>

							<hr/>

							<h4><span class="snipe recommended"><?php _e('Recommended', 'contempo'); ?></span> <?php _e( 'Contempo Saved Searches & Email Alerts', 'contempo' ); ?>
								<?php if ( ! function_exists('ctea_load_textdomain') ) { ?>
									<a class="button button-secondary" href="<?php echo admin_url('themes.php?page=tgmpa-install-plugins'); ?>" title="<?php esc_attr_e( 'Install Contempo Saved Searches & Email Alerts', 'contempo' ); ?>"><i class="fa fa-download"></i> <?php _e( 'Install Now', 'contempo' ); ?></a>
								<?php } else { ?>
									<span class="button button-secondary disabled"><i class="fa fa-check"></i> <?php _e( 'Installed', 'contempo' ); ?></span>
								<?php } ?>
							</h4>

							<p><?php _e( 'This plugin allows users be alerted via email when a listing is added.', 'contempo' ); ?></p>

							<hr/>

							<h4><span class="snipe recommended"><?php _e('Recommended', 'contempo'); ?></span> <?php _e( 'Contempo Compare Listings', 'contempo' ); ?>
								<?php if ( ! class_exists('Redq_Alike') ) { ?>
									<a class="button button-secondary" href="<?php echo admin_url('themes.php?page=tgmpa-install-plugins'); ?>" title="<?php esc_attr_e( 'Install Contempo Compare Listings', 'contempo' ); ?>"><i class="fa fa-download"></i> <?php _e( 'Install Now', 'contempo' ); ?></a>
								<?php } else { ?>
									<span class="button button-secondary disabled"><i class="fa fa-check"></i> <?php _e( 'Installed', 'contempo' ); ?></span>
								<?php } ?>
							</h4>

							<p><?php _e( 'This plugin adds compare functionality for listings.', 'contempo' ); ?></p>

							<hr/>

							<h4><span class="snipe recommended"><?php _e('Recommended', 'contempo'); ?></span> <?php _e( 'Contempo Mortgage Calculator Widget', 'contempo' ); ?>
								<?php if ( ! class_exists('ct_MortgageCalculator') ) { ?>
									<a class="button button-secondary" href="<?php echo admin_url('themes.php?page=tgmpa-install-plugins'); ?>" title="<?php esc_attr_e( 'Install Contempo Mortgage Calculator Widget', 'contempo' ); ?>"><i class="fa fa-download"></i> <?php _e( 'Install Now', 'contempo' ); ?></a>
								<?php } else { ?>
									<span class="button button-secondary disabled"><i class="fa fa-check"></i> <?php _e( 'Installed', 'contempo' ); ?></span>
								<?php } ?>
							</h4>

							<p><?php _e( 'This plugin enables a simple mortgage calculator widget.', 'contempo' ); ?></p>

							<hr/>

							<h4><span class="snipe recommended"><?php _e('Recommended', 'contempo'); ?></span> <?php _e( 'Contempo Child Theme Generator', 'contempo' ); ?>
								<?php if ( ! class_exists('ct_ChildTheme') ) { ?>
									<a class="button button-secondary" href="<?php echo admin_url('themes.php?page=tgmpa-install-plugins'); ?>" title="<?php esc_attr_e( 'Install Contempo Compare Listings', 'contempo' ); ?>"><i class="fa fa-download"></i> <?php _e( 'Install Now', 'contempo' ); ?></a>
								<?php } else { ?>
									<span class="button button-secondary disabled"><i class="fa fa-check"></i> <?php _e( 'Installed', 'contempo' ); ?></span>
								<?php } ?>
							</h4>

							<p><?php _e( 'This plugin allows admin users to easily generate a child theme from your Admin > Appearance panel.', 'contempo' ); ?></p>

							<hr/>

							<h4><span class="snipe recommended"><?php _e('Recommended', 'contempo'); ?></span> <?php _e( 'Contempo Payment Gateways', 'contempo' ); ?>
								<?php if ( ! function_exists('ct_repg_load_textdomain') ) { ?>
									<a class="button button-secondary" href="<?php echo admin_url('themes.php?page=tgmpa-install-plugins'); ?>" title="<?php esc_attr_e( 'Install Contempo Payment Gateways', 'contempo' ); ?>"><i class="fa fa-download"></i> <?php _e( 'Install Now', 'contempo' ); ?></a>
								<?php } else { ?>
									<span class="button button-secondary disabled"><i class="fa fa-check"></i> <?php _e( 'Installed', 'contempo' ); ?></span>
								<?php } ?>
							</h4>

							<p><?php _e( 'This plugin enables various payment gateways only required if you\'re going to be charging listing submissions from the front end of the site.', 'contempo' ); ?></p>

							<hr/>

							<h4><span class="snipe recommended"><?php _e('Recommended', 'contempo'); ?></span> <?php _e( 'Slider Revolution', 'contempo' ); ?>
								<?php if ( ! class_exists('RevSliderFront') ) { ?>
									<a class="button button-secondary" href="<?php echo admin_url('themes.php?page=tgmpa-install-plugins'); ?>" title="<?php esc_attr_e( 'Install Slider Revolution', 'contempo' ); ?>"><i class="fa fa-download"></i> <?php _e( 'Install Now', 'contempo' ); ?></a>
								<?php } else { ?>
									<span class="button button-secondary disabled"><i class="fa fa-check"></i> <?php _e( 'Installed', 'contempo' ); ?></span>
								<?php } ?>
							</h4>

							<p><?php _e( 'Slider Revolution is an innovative, responsive WordPress Slider Plugin that displays your content the beautiful way.', 'contempo' ); ?></p>

							<hr/>

							<h4><span class="snipe recommended"><?php _e('Recommended', 'contempo'); ?></span> <?php _e( 'Visual Composer', 'contempo' ); ?>
								<?php if ( ! class_exists('Vc_Manager') ) { ?>
									<a class="button button-secondary" href="<?php echo admin_url('themes.php?page=tgmpa-install-plugins'); ?>" title="<?php esc_attr_e( 'Install Visual Composer', 'contempo' ); ?>"><i class="fa fa-download"></i> <?php _e( 'Install Now', 'contempo' ); ?></a>
								<?php } else { ?>
									<span class="button button-secondary disabled"><i class="fa fa-check"></i> <?php _e( 'Installed', 'contempo' ); ?></span>
								<?php } ?>
							</h4>

							<p><?php _e( 'WordPress Page Builder plugin with intuitive drag and drop interface. Build any page fast and easy. Unlimited layouts for your website.', 'contempo' ); ?></p>

							<hr/>

							<h4><span class="snipe recommended"><?php _e('Recommended', 'contempo'); ?></span> <?php _e( 'WPML', 'contempo' ); ?>
								<?php if ( ! class_exists('SitePress') ) { ?>
									<a class="button button-secondary" href="https://wpml.org/?aid=9098&affiliate_key=lzBo0CYyVMbn" target="_blank" title="<?php esc_attr_e( 'Install WPML', 'contempo' ); ?>"><i class="fa fa-download"></i> <?php _e( 'Install Now', 'contempo' ); ?></a>
								<?php } else { ?>
									<span class="button button-secondary disabled"><i class="fa fa-check"></i> <?php _e( 'Installed', 'contempo' ); ?></span>
								<?php } ?>
							</h4>

							<p><?php
								$ct_wpml_url = 'https://wpml.org/?aid=9098&affiliate_key=lzBo0CYyVMbn';
								printf( __( '<a href="%s" target="_blank">WPML</a> allows running fully multilingual websites with WordPress, making it easy to translate WordPress pages, posts, tags, categories and themes.', 'contempo' ), esc_url( $ct_wpml_url ) );
							?></p>

							<hr/>

							<h4><span class="snipe recommended"><?php _e('Recommended', 'contempo'); ?></span> <?php _e( 'WordPress Social Login', 'contempo' ); ?>
								<?php if ( ! function_exists('wsl_activate') ) { ?>
									<a class="button button-secondary" href="<?php echo admin_url('themes.php?page=tgmpa-install-plugins'); ?>" title="<?php esc_attr_e( 'Install WP Favorite Posts', 'contempo' ); ?>"><i class="fa fa-download"></i> <?php _e( 'Install Now', 'contempo' ); ?></a>
								<?php } else { ?>
									<span class="button button-secondary disabled"><i class="fa fa-check"></i> <?php _e( 'Installed', 'contempo' ); ?></span>
								<?php } ?>
							</h4>

							<p><?php _e( 'This plugin allows users to login/register with their social profiles like Facebook, Google, Twitter, etc&hellip;', 'contempo' ); ?></p>

							<hr/>

							<h4><span class="snipe recommended"><?php _e('Recommended', 'contempo'); ?></span> <?php _e( 'WP Favorite Posts', 'contempo' ); ?>
								<?php if ( ! function_exists('wp_favorite_posts') ) { ?>
									<a class="button button-secondary" href="<?php echo admin_url('themes.php?page=tgmpa-install-plugins'); ?>" title="<?php esc_attr_e( 'Install WP Favorite Posts', 'contempo' ); ?>"><i class="fa fa-download"></i> <?php _e( 'Install Now', 'contempo' ); ?></a>
								<?php } else { ?>
									<span class="button button-secondary disabled"><i class="fa fa-check"></i> <?php _e( 'Installed', 'contempo' ); ?></span>
								<?php } ?>
							</h4>

							<p><?php _e( 'This plugin allows users to favorite & save listings from the front end of the site.', 'contempo' ); ?></p>

							<hr/>

							<h4><span class="snipe recommended"><?php _e('Recommended', 'contempo'); ?></span> <?php _e( 'WordPress Social Login', 'contempo' ); ?>
								<?php if ( ! function_exists('wsl_install') ) { ?>
									<a class="button button-secondary" href="<?php echo admin_url('themes.php?page=tgmpa-install-plugins'); ?>" title="<?php esc_attr_e( 'Install WordPress Social Login', 'contempo' ); ?>"><i class="fa fa-download"></i> <?php _e( 'Install Now', 'contempo' ); ?></a>
								<?php } else { ?>
									<span class="button button-secondary disabled"><i class="fa fa-check"></i> <?php _e( 'Installed', 'contempo' ); ?></span>
								<?php } ?>
							</h4>

							<p><?php _e( 'This plugin allows users to login/register for your site via social networks like Facebook, Google, Twitter, etc&hellip;', 'contempo' ); ?></p>

							<hr/>

							<h4><span class="snipe recommended"><?php _e('Recommended', 'contempo'); ?></span> <?php _e( 'Booking Calendar', 'contempo' ); ?>
								<?php if ( ! class_exists('Booking_Calendar') ) { ?>
									<a class="button button-secondary" href="<?php echo admin_url('themes.php?page=tgmpa-install-plugins'); ?>" title="<?php esc_attr_e( 'Install Booking Calendar', 'contempo' ); ?>"><i class="fa fa-download"></i> <?php _e( 'Install Now', 'contempo' ); ?></a>
								<?php } else { ?>
									<span class="button button-secondary disabled"><i class="fa fa-check"></i> <?php _e( 'Installed', 'contempo' ); ?></span>
								<?php } ?>
							</h4>

							<p><?php _e( 'This plugin will enable online booking services, however you\'re free to use whatever booking plugin you\'d like as long as it supports shortcodes.', 'contempo' ); ?></p>

							<hr/>

							<h4><span class="snipe recommended"><?php _e('Recommended', 'contempo'); ?></span> <?php _e( 'Co-Authors Plus', 'contempo' ); ?>
								<?php if ( ! class_exists('CoAuthors_Plus') ) { ?>
									<a class="button button-secondary" href="<?php echo admin_url('themes.php?page=tgmpa-install-plugins'); ?>" title="<?php esc_attr_e( 'Install Co-Authors Plus', 'contempo' ); ?>"><i class="fa fa-download"></i> <?php _e( 'Install Now', 'contempo' ); ?></a>
								<?php } else { ?>
									<span class="button button-secondary disabled"><i class="fa fa-check"></i> <?php _e( 'Installed', 'contempo' ); ?></span>
								<?php } ?>
							</h4>

							<p><?php _e( 'This plugin allows you to assign multiple users or agents to listings, perfect for co-listings.', 'contempo' ); ?></p>

							<hr/>

							<h4><span class="snipe recommended"><?php _e('Recommended', 'contempo'); ?></span> <?php _e( 'Comments Ratings', 'contempo' ); ?>
								<?php if ( ! function_exists('pixreviews_init_plugin') ) { ?>
									<a class="button button-secondary" href="<?php echo admin_url('themes.php?page=tgmpa-install-plugins'); ?>" title="<?php esc_attr_e( 'Install Comments Ratings', 'contempo' ); ?>"><i class="fa fa-download"></i> <?php _e( 'Install Now', 'contempo' ); ?></a>
								<?php } else { ?>
									<span class="button button-secondary disabled"><i class="fa fa-check"></i> <?php _e( 'Installed', 'contempo' ); ?></span>
								<?php } ?>
							</h4>

							<p><?php _e( 'This plugin allows you to enable ratings for your listings.', 'contempo' ); ?></p>

							<hr/>

							<h4><span class="snipe recommended"><?php _e('Recommended', 'contempo'); ?></span> <?php _e( 'Envato Market', 'contempo' ); ?>
								<?php if ( ! class_exists('Envato_Market') ) { ?>
									<a class="button button-secondary" href="<?php echo admin_url('themes.php?page=tgmpa-install-plugins'); ?>" title="<?php esc_attr_e( 'Install Envato Market', 'contempo' ); ?>"><i class="fa fa-download"></i> <?php _e( 'Install Now', 'contempo' ); ?></a>
								<?php } else { ?>
									<span class="button button-secondary disabled"><i class="fa fa-check"></i> <?php _e( 'Installed', 'contempo' ); ?></span>
								<?php } ?>
							</h4>

							<p><?php _e( 'This plugin allows you to easily get theme updates through your WordPress admin.', 'contempo' ); ?></p>

							<hr/>
							
						</div><!-- .panel-left -->

						<!-- Support panel -->
						<div id="support-panel" class="panel-left">

							<h3><?php printf( __( 'Support for %s?', 'contempo' ), $theme['Name'] ); ?></h3>

							<p><?php
								$ct_documentation_url = admin_url('admin.php?page=WPProRealEstate7&tab=1');
								$ct_support_url = 'http://contempothemes.com/wp-real-estate-7';
								$ct_item_comments_url = 'https://themeforest.net/item/wp-pro-real-estate-7-responsive-real-estate-wordpress-theme/12473778/comments?ref=contempoinc';
								printf( __( 'If you\'ve read through the <a href="%1$s" target="_blank">documentation</a> and still have questions or are experiencing issues, I\'m happy to help! Simply <a href="%2$s"  target="_blank" title="Open a live chat">open a live chat</a> or <a href="%3$s" target="_blank">leave a comment</a> on the item page and I\'ll personally get back to you, thanks in advance for your patience.', 'contempo' ), esc_url( $ct_documentation_url ), esc_url( $ct_support_url ), esc_url( $ct_item_comments_url ) );
							?></p>

							<h3><?php printf( __( 'FAQ for %s?', 'contempo' ), $theme['Name'] ); ?></h3>

							<p class="marB3"><?php
								_e( 'The following articles below cover many frequently asked questions that you may have.', 'contempo' );
							?></p>

							<?php
								function ct_get_kb_article($id) {
									$kb_article = json_decode(file_get_contents('https://api.ticksy.com/v1/contempo/8ebf062c5048e22f7ad796aa40ccf7e5/article.json/' . $id), true);;

									$output = '<a href="https://contempo.ticksy.com/article/' . $id . '" target="_blank">' . $kb_article['article-data']['article_title'] . '</a>';
									return $output;
								}
							?>

							<ul class="toc">
								<li><?php echo ct_get_kb_article('5952'); ?></li>
								<li><?php echo ct_get_kb_article('7568'); ?></li>
								<li><?php echo ct_get_kb_article('5950'); ?></li>
								<li><?php echo ct_get_kb_article('8576'); ?></li>
								<li><?php echo ct_get_kb_article('10388'); ?></li>
								<li><?php echo ct_get_kb_article('6708'); ?></li>
								<li><?php echo ct_get_kb_article('8575'); ?></li>
								<li><?php echo ct_get_kb_article('8560'); ?></li>
								<li><?php echo ct_get_kb_article('8583'); ?></li>
								<li><?php echo ct_get_kb_article('6075'); ?></li>
								<li><?php echo ct_get_kb_article('7796'); ?></li>
								<li><?php echo ct_get_kb_article('8511'); ?></li>
								<li><?php echo ct_get_kb_article('5983'); ?></li>
								<li><?php echo ct_get_kb_article('5951'); ?></li>
								<li><?php echo ct_get_kb_article('5949'); ?></li>
								<li><?php echo ct_get_kb_article('7664'); ?></li>
								<li><?php echo ct_get_kb_article('8877'); ?></li>
							</ul>

						</div><!-- .panel-left support -->

						<!-- Updates panel -->
						<div id="updates-panel" class="panel-left">
							<?php
								$ct_changelog_contents = file_get_contents(dirname( __FILE__ ) . '/../ReduxFramework/theme-changelog/index.html');
								echo $ct_changelog_contents;
							?>
						</div><!-- .panel-left updates -->

						<div class="panel-right">
							<!-- Modifications -->
							<div class="panel-aside">
								
								<h4><?php _e( 'Need Modifications or Customizations?', 'contempo' ); ?></h4>

								<p>
									<?php
										$ct_email = 'chris@contempothemes.com';
										printf( __( 'Send me an email <a href="mailto:%s">chris@contempothemes.com</a>, with a detailed outline of what you’d like to accomplish and I’ll get you a quote and turnaround time.', 'contempo' ), esc_url( $ct_email ) );
									?>
								</p>

								<p>
									<em>
										<?php
											$ct_support_url = 'http://contempothemes.com/wp-real-estate-7';
											$ct_item_comments_url = 'https://themeforest.net/item/wp-pro-real-estate-7-responsive-real-estate-wordpress-theme/12473778/comments?ref=contempoinc';
											printf( __( 'Please note that support requests will not be answered via email, only through my <a href="%1$s" target="_blank">live chat</a> or within the <a href="%2$s" target="_blank">item comments</a>.', 'contempo' ), esc_url( $ct_support_url ), esc_url( $ct_item_comments_url ) );
										?>
									</em>
								</p>

							</div><!-- .panel-aside modifications -->

							<!-- Hosting -->
							<div class="panel-aside">
								
								<h4><?php _e( 'Hosting Recommendations', 'contempo' ); ?></h4>

								<p>Below are some of my personal recommendations, these providers are fast, affordable, secure and have outstanding support!</p>
				                
				                <ol>
				                    <!--<li><a href="http://contempothemes.com/wp-real-estate-7/hosting/">Contempo Managed WordPress Hosting</a></li>-->
				                    <li><a href="https://www.siteground.com/go/ct-wordpress-hosting">Siteground</a></li>
				                    <li><a href="http://www.shareasale.com/r.cfm?B=398782&U=829348&M=41388&urllink=">WP Engine</a></li>
				                </ol>

							</div><!-- .panel-aside modifications -->

							<!-- Knowledge base -->
							<div class="panel-aside">
								<h4><?php _e( 'Visit the Knowledge Base', 'contempo' ); ?></h4>
								<p><?php _e( 'New to the WordPress world? The Knowledge Base has a boat load of articles to help you with any issues that might arise.', 'contempo' ); ?></p>

								<a class="button button-primary" href="http://contempo.ticksy.com/articles" title="<?php esc_attr_e( 'Visit the knowledge base', 'contempo' ); ?>"><?php _e( 'Visit the Knowledge Base', 'contempo' ); ?></a>
							</div><!-- .panel-aside knowledge base -->
						</div><!-- .panel-right -->
					</div><!-- .panel -->
				</div><!-- .panels -->
			</div><!-- .getting-started -->

		<?php
	}

}