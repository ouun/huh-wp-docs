<?php
/**
 * Main plugin file.
 */

namespace Required\WP_Huh;

/**
 * Main plugin class.
 */
class Plugin {
	public $markdown_doc_url = null;

	/**
	 * Constructor.
	 */
	public function __construct() {
	}

	/**
	 * Initialize.
	 *
	 * @param string $markdown_doc_url URL of the raw markdown file.
	 */
	public function init( $markdown_doc_url ) {

		if ( is_array( $markdown_doc_url ) && ! empty( $markdown_doc_url ) ) {

		} else {
			// Explode URLs and Trim Whitespace
			$this->markdown_doc_url = array_map( 'trim', explode( ',', $markdown_doc_url ) );
		}

		if ( is_admin() ) {
			add_action( 'admin_enqueue_scripts', [ $this, 'huh_load_scripts' ] );
			add_action( 'admin_enqueue_scripts', [ $this, 'huh_data_urls' ] );
			add_action( 'admin_footer', [ $this, 'display_huh' ] );
		}

		// Load in the customizer
		add_action( 'customize_preview_init', function () {
			add_action( 'wp_enqueue_scripts', [ $this, 'huh_load_scripts' ] );
			add_action( 'wp_enqueue_scripts', [ $this, 'huh_data_urls' ] );
			add_action( 'wp_footer', [ $this, 'display_huh' ] );
		} );


		//add_action( 'wp_footer', [ $this, 'big_demo' ] );
	}

	public function big_demo() {
		if ( is_customize_preview() ) {
			$this->display_huh();
		}
	}

	/**
	 * Enqueue CSS and JS.
	 */
	public function huh_load_scripts() {
		wp_register_style( 'huh_admin_css', plugin_dir_url( dirname( __FILE__ ) ) . 'huh-wp-docs.min.css', false );
		wp_enqueue_style( 'huh_admin_css' );

		wp_register_script( 'huh_admin_js', plugin_dir_url( dirname( __FILE__ ) ) . 'js/huh-wp-docs.min.js', array( 'underscore' ) );
		wp_enqueue_script( 'huh_admin_js' );

		wp_register_script( 'huh_markdown_js', plugin_dir_url( dirname( __FILE__ ) ) . 'js/marked.min.js', false );
		wp_enqueue_script( 'huh_markdown_js' );
	}

	public function huh_data_urls() {
		wp_localize_script( 'huh_admin_js', 'HuhWPDocs', [ 'huhDocUrl' => $this->markdown_doc_url ] );
	}

	/**
	 * Get admin color scheme.
	 */
	public function huh_get_admin_color() {
		if ( is_admin() ) {
			global $_wp_admin_css_colors;
			$current_color_scheme = get_user_meta( get_current_user_id(), 'admin_color', true );
			$colors_array         = $_wp_admin_css_colors[ $current_color_scheme ]->colors;
			$color                = $colors_array[2];
		} else {
			$color = '#0073aa';
		}

		return $color;
	}

	/**
	 * Display the HTML.
	 *
	 * @param $markdown_doc_url URL of the raw markdown file.
	 */
	public function display_huh() {
		$huh_accent_color = $this->huh_get_admin_color();

		?>
		<!--<script type="text/javascript">var huhDocUrl = <?php echo json_encode( $this->markdown_doc_url ); ?>;</script>-->
		<div class="huh-launcher">
			<button class="huh-launcher--button" id="huh-launcher--button" data-accent-color="<?php echo esc_attr( $huh_accent_color ); ?>">
				<svg class="huh-launcher--icon-enable" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve"><g>
						<circle cx="50" cy="63.5" r="3"></circle>
						<g>
							<path d="M88.6,50c0-21.3-17.3-38.6-38.6-38.6S11.4,28.7,11.4,50S28.7,88.6,50,88.6S88.6,71.3,88.6,50z M15.6,50    c0-18.9,15.4-34.4,34.4-34.4S84.4,31.1,84.4,50S68.9,84.4,50,84.4S15.6,68.9,15.6,50z"></path>
							<path d="M55.8,42.1c0.1,2.5-1.4,4.8-3.7,5.7c-2.6,1-4.3,3.6-4.3,6.5v1.4h4.2v-1.4c0-1.1,0.7-2.2,1.6-2.6c4-1.6,6.5-5.5,6.3-9.8    c-0.2-5.1-4.5-9.4-9.6-9.6C47.7,32.1,45,33.1,43,35c-2,1.9-3.1,4.5-3.1,7.3h4.2c0-1.6,0.6-3.1,1.8-4.2c1.2-1.1,2.7-1.7,4.3-1.6    C53.3,36.6,55.7,39.1,55.8,42.1z"></path>
						</g>
					</g></svg>
				<svg class="huh-launcher--icon-close" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24">
					<g id="plus">
						<path d="M18.36,19.78L12,13.41,5.64,19.78,4.22,18.36,10.59,12,4.22,5.64,5.64,4.22,12,10.59l6.36-6.36,1.41,1.41L13.41,12l6.36,6.36Z" />
					</g>
				</svg>
				<span class="huh-launcher--label"><?php esc_html_e( 'Need help?', 'huh-wp-docs' ); ?></span>
			</button>
		</div>

		<div class="huh-container" id="huh-container">
			<div class="huh-container--head" id="huh-header">
				<h4 class="huh-container--heading"><?php esc_html_e( 'Need help?', 'huh-wp-docs' ); ?></h4>
				<a href="javascript:;" class="huh-container--back" id="huh-back-to-toc">
					<svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24">
						<rect x="0" fill="none" width="24" height="24" />
						<g>
							<path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
						</g>
					</svg>
					<?php esc_html_e( 'Back', 'huh-wp-docs' ); ?>
				</a>
				<svg class="huh-container--close-mobile" id="huh-mobile-close" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24">
					<g id="plus">
						<path d="M18.36,19.78L12,13.41,5.64,19.78,4.22,18.36,10.59,12,4.22,5.64,5.64,4.22,12,10.59l6.36-6.36,1.41,1.41L13.41,12l6.36,6.36Z" />
					</g>
				</svg>
			</div>
			<div class="huh-container--content" id="huh-content"></div>
		</div>
		<?php
	}

}