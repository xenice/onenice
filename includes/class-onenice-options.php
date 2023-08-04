<?php
/**
 * Onenice_Options
 *
 * Theme options class.
 *
 * @package Onenice
 */

/**
 * Onenice_Options
 *
 * Theme options class.
 */
class Onenice_Options {

	/**
	 * Constructor
	 *
	 * @param object $wp_customize  wp customize object.
	 */
	public function __construct( $wp_customize ) {
		$this->global( $wp_customize );
		$this->footer( $wp_customize );
		$this->header( $wp_customize );
		$this->slides( $wp_customize );
		$this->archive( $wp_customize );
		$this->posts( $wp_customize );
	}

	/**
	 * Global
	 *
	 * @param object $wp_customize  wp customize object.
	 */
	public function global( $wp_customize ) {
		global $onenice_defaults;

		$wp_customize->add_section(
			'global',
			array(
				'title'    => esc_html__( 'Global', 'onenice' ),
				'priority' => 1,
			)
		);

		// site_icon.
		$wp_customize->add_setting(
			'site_icon',
			array(
				'default'           => $onenice_defaults['site_icon'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'site_icon',
				array(
					'label'    => __( 'Site Icon', 'onenice' ),
					'section'  => 'global',
					'settings' => 'site_icon',
				)
			)
		);
		// #site_icon.

		// theme_color.
		$wp_customize->add_setting(
			'theme_color',
			array(
				'default'           => $onenice_defaults['theme_color'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'theme_color',
			array(
				'label'   => esc_html__( 'Theme Color', 'onenice' ),
				'section' => 'global',
				'type'    => 'radio',
				'choices' => array(
					'#0099FF #007bff #99CCFF' => esc_html__( 'Blue', 'onenice' ),
					'#FF5E52 #f13c2f #fc938b' => esc_html__( 'Red', 'onenice' ),
					'#1fae67 #229e60 #35dc89' => esc_html__( 'Green', 'onenice' ),
					'#ff4979 #f2295e #fb94af' => esc_html__( 'Pink', 'onenice' ),
				),
			)
		);
		// #theme_color.

		// static_lib_cdn.
		$wp_customize->add_setting(
			'static_lib_cdn',
			array(
				'default'           => $onenice_defaults['static_lib_cdn'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'static_lib_cdn',
			array(
				'label'   => esc_html__( 'Static library CDN', 'onenice' ),
				'section' => 'global',
				'type'    => 'radio',
				'choices' => array(
					''                                  => esc_html__( 'Defalut', 'onenice' ),
					'https://cdn.staticfile.org'        => 'https://cdn.staticfile.org',
					'https://cdn.bootcdn.net/ajax/libs' => 'https://cdn.bootcdn.net/ajax/libs',
					'https://libs.cdnjs.net'            => 'https://libs.cdnjs.net',
				),
			)
		);
		// #static_lib_cdn.

		// page_width.
		$wp_customize->add_setting(
			'page_width',
			array(
				'default'           => $onenice_defaults['page_width'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'page_width',
			array(
				'label'   => esc_html__( 'Page Width', 'onenice' ),
				'section' => 'global',
				'type'    => 'radio',
				'choices' => array(
					'1140px' => esc_html__( '1140px', 'onenice' ),
					'1200px' => esc_html__( '1200px', 'onenice' ),
				),
			)
		);
		// #page_width.

		// enable_back_to_top.
		$wp_customize->add_setting(
			'enable_back_to_top',
			array(
				'default'           => $onenice_defaults['enable_back_to_top'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'enable_back_to_top',
			array(
				'label'   => esc_html__( 'Back to top', 'onenice' ),
				'section' => 'global',
				'type'    => 'checkbox',
			)
		);
		// #enable_back_to_top.

		// #global.
	}

	/**
	 * Header
	 *
	 * @param object $wp_customize  wp customize object.
	 */
	public function header( $wp_customize ) {
		global $onenice_defaults;

		$wp_customize->add_section(
			'header',
			array(
				'title'    => esc_html__( 'Header', 'onenice' ),
				'priority' => 2,
			)
		);

		// site_logo.
		$wp_customize->add_setting(
			'site_logo',
			array(
				'default'           => $onenice_defaults['site_logo'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'site_logo',
				array(
					'label'    => __( 'Site Logo', 'onenice' ),
					'section'  => 'header',
					'settings' => 'site_logo',
				)
			)
		);
		// #site_logo.

		// show_search.
		$wp_customize->add_setting(
			'show_search',
			array(
				'default'           => $onenice_defaults['show_search'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'show_search',
			array(
				'label'   => esc_html__( 'Show Search', 'onenice' ),
				'section' => 'header',
				'type'    => 'checkbox',
			)
		);
		// #show_search.

		// show_login_button.
		$wp_customize->add_setting(
			'show_login_button',
			array(
				'default'           => $onenice_defaults['show_login_button'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'show_login_button',
			array(
				'label'   => esc_html__( 'Show Login Button', 'onenice' ),
				'section' => 'header',
				'type'    => 'checkbox',
			)
		);
		// #show_login_button.
	}

	/**
	 * Footer
	 *
	 * @param object $wp_customize  wp customize object.
	 */
	public function footer( $wp_customize ) {
		global $onenice_defaults;

		$wp_customize->add_section(
			'footer',
			array(
				'title'    => esc_html__( 'Footer', 'onenice' ),
				'priority' => 3,
			)
		);

		// delete_theme_copyright.
		$wp_customize->add_setting(
			'delete_theme_copyright',
			array(
				'default'           => $onenice_defaults['delete_theme_copyright'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'delete_theme_copyright',
			array(
				'label'   => esc_html__( 'Delete Theme Copyright', 'onenice' ),
				'section' => 'footer',
				'type'    => 'checkbox',
			)
		);
		// #delete_theme_copyright.

		if ( get_locale() === 'zh_CN' ) {
			// service_qq.
			$wp_customize->add_setting(
				'service_qq',
				array(
					'default'           => $onenice_defaults['service_qq'],
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			$wp_customize->add_control(
				'service_qq',
				array(
					'label'   => esc_html__( 'Service QQ', 'onenice' ),
					'section' => 'footer',
					'type'    => 'text',
				)
			);
			// #service_qq.

			// icp_number.
			$wp_customize->add_setting(
				'icp_number',
				array(
					'default'           => $onenice_defaults['icp_number'],
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			$wp_customize->add_control(
				'icp_number',
				array(
					'label'   => esc_html__( 'ICP Number', 'onenice' ),
					'section' => 'footer',
					'type'    => 'text',
				)
			);
			// #icp_number.
		}

	}

	/**
	 * Slides
	 *
	 * @param object $wp_customize  wp customize object.
	 */
	public function slides( $wp_customize ) {
		global $onenice_defaults;

		$wp_customize->add_section(
			'slides',
			array(
				'title'    => esc_html__( 'Slides', 'onenice' ),
				'priority' => 4,
			)
		);

		// enable_slides.
		$wp_customize->add_setting(
			'enable_slides',
			array(
				'default'           => $onenice_defaults['enable_slides'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'enable_slides',
			array(
				'label'   => esc_html__( 'Enable Slides', 'onenice' ),
				'section' => 'slides',
				'type'    => 'checkbox',
			)
		);
		// #enable_slides.

		// slides_image_1.
		$wp_customize->add_setting(
			'slides_image_1',
			array(
				'default'           => $onenice_defaults['slides_image_1'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'slides_image_1',
				array(
					'label'    => __( 'Slides Image 1', 'onenice' ),
					'section'  => 'slides',
					'settings' => 'slides_image_1',
				)
			)
		);

		$wp_customize->add_setting(
			'slides_url_1',
			array(
				'default'           => $onenice_defaults['slides_url_1'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'slides_url_1',
			array(
				'label'   => esc_html__( 'Slides URL', 'onenice' ),
				'section' => 'slides',
				'type'    => 'text',
			)
		);

		$wp_customize->add_setting(
			'slides_title_1',
			array(
				'default'           => $onenice_defaults['slides_title_1'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'slides_title_1',
			array(
				'label'   => esc_html__( 'Slides Title', 'onenice' ),
				'section' => 'slides',
				'type'    => 'text',
			)
		);

		$wp_customize->add_setting(
			'slides_description_1',
			array(
				'default'           => $onenice_defaults['slides_description_1'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'slides_description_1',
			array(
				'label'   => esc_html__( 'Slides Description', 'onenice' ),
				'section' => 'slides',
				'type'    => 'textarea',
			)
		);
		// #slides_image_1.

		// slides_image_2.
		$wp_customize->add_setting(
			'slides_image_2',
			array(
				'default'           => $onenice_defaults['slides_image_2'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'slides_image_2',
				array(
					'label'    => __( 'Slides Image 2', 'onenice' ),
					'section'  => 'slides',
					'settings' => 'slides_image_2',
				)
			)
		);

		$wp_customize->add_setting(
			'slides_url_2',
			array(
				'default'           => $onenice_defaults['slides_url_2'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'slides_url_2',
			array(
				'label'   => esc_html__( 'Slides URL', 'onenice' ),
				'section' => 'slides',
				'type'    => 'text',
			)
		);

		$wp_customize->add_setting(
			'slides_title_2',
			array(
				'default'           => $onenice_defaults['slides_title_2'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'slides_title_2',
			array(
				'label'   => esc_html__( 'Slides Title', 'onenice' ),
				'section' => 'slides',
				'type'    => 'text',
			)
		);

		$wp_customize->add_setting(
			'slides_description_2',
			array(
				'default'           => $onenice_defaults['slides_description_2'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'slides_description_2',
			array(
				'label'   => esc_html__( 'Slides Description', 'onenice' ),
				'section' => 'slides',
				'type'    => 'textarea',
			)
		);
		// #slides_image_2.

		// slides_image_3.
		$wp_customize->add_setting(
			'slides_image_3',
			array(
				'default'           => $onenice_defaults['slides_image_3'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'slides_image_3',
				array(
					'label'    => __( 'Slides Image 3', 'onenice' ),
					'section'  => 'slides',
					'settings' => 'slides_image_3',
				)
			)
		);

		$wp_customize->add_setting(
			'slides_url_3',
			array(
				'default'           => $onenice_defaults['slides_url_3'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'slides_url_3',
			array(
				'label'   => esc_html__( 'Slides URL', 'onenice' ),
				'section' => 'slides',
				'type'    => 'text',
			)
		);

		$wp_customize->add_setting(
			'slides_title_3',
			array(
				'default'           => $onenice_defaults['slides_title_3'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'slides_title_3',
			array(
				'label'   => esc_html__( 'Slides Title', 'onenice' ),
				'section' => 'slides',
				'type'    => 'text',
			)
		);

		$wp_customize->add_setting(
			'slides_description_3',
			array(
				'default'           => $onenice_defaults['slides_description_3'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'slides_description_3',
			array(
				'label'   => esc_html__( 'Slides Description', 'onenice' ),
				'section' => 'slides',
				'type'    => 'textarea',
			)
		);
		// #slides_image_3.
	}

	/**
	 * Archive
	 *
	 * @param object $wp_customize  wp customize object.
	 */
	public function archive( $wp_customize ) {
		global $onenice_defaults;

		$wp_customize->add_section(
			'archive',
			array(
				'title'    => esc_html__( 'Archive', 'onenice' ),
				'priority' => 5,
			)
		);

		// list_style.
		$wp_customize->add_setting(
			'list_style',
			array(
				'default'           => $onenice_defaults['list_style'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'list_style',
			array(
				'label'   => esc_html__( 'List Style', 'onenice' ),
				'section' => 'archive',
				'type'    => 'radio',
				'choices' => array(
					'text'      => esc_html__( 'Text', 'onenice' ),
					'thumbnail' => esc_html__( 'Thumbnail', 'onenice' ),
				),
			)
		);
		// #list_style.

		// excerpt_length.
		$wp_customize->add_setting(
			'excerpt_length',
			array(
				'default'           => $onenice_defaults['excerpt_length'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'excerpt_length',
			array(
				'label'   => esc_html__( 'Excerpt Length', 'onenice' ),
				'section' => 'archive',
				'type'    => 'number',
				'choices' => array(
					'text'      => esc_html__( 'Text', 'onenice' ),
					'thumbnail' => esc_html__( 'Thumbnail', 'onenice' ),
				),
			)
		);
		// #excerpt_length.

		// site_thumbnail.
		$wp_customize->add_setting(
			'site_thumbnail',
			array(
				'default'           => $onenice_defaults['site_thumbnail'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'site_thumbnail',
				array(
					'label'    => __( 'Site Thumbnail', 'onenice' ),
					'section'  => 'archive',
					'settings' => 'site_thumbnail',
				)
			)
		);
		// #site_thumbnail.

		// site_loading_image.
		$wp_customize->add_setting(
			'site_loading_image',
			array(
				'default'           => $onenice_defaults['site_loading_image'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'site_loading_image',
				array(
					'label'    => __( 'Site Loading Image', 'onenice' ),
					'section'  => 'archive',
					'settings' => 'site_loading_image',
				)
			)
		);
		// #site_loading_image.
	}

	/**
	 * Posts
	 *
	 * @param object $wp_customize  wp customize object.
	 */
	public function posts( $wp_customize ) {
		global $onenice_defaults;

		$wp_customize->add_section(
			'posts',
			array(
				'title'    => esc_html__( 'Posts', 'onenice' ),
				'priority' => 6,
			)
		);

		// archive_show_date.
		$wp_customize->add_setting(
			'archive_show_date',
			array(
				'default'           => $onenice_defaults['archive_show_date'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'archive_show_date',
			array(
				'label'   => esc_html__( 'Show Date', 'onenice' ),
				'section' => 'archive',
				'type'    => 'checkbox',
			)
		);
		// #archive_show_date.

		// archive_show_author.
		$wp_customize->add_setting(
			'archive_show_author',
			array(
				'default'           => $onenice_defaults['archive_show_author'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'archive_show_author',
			array(
				'label'   => esc_html__( 'Show Author', 'onenice' ),
				'section' => 'archive',
				'type'    => 'checkbox',
			)
		);
		// #archive_show_author.

		// single_show_date.
		$wp_customize->add_setting(
			'single_show_date',
			array(
				'default'           => $onenice_defaults['single_show_date'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'single_show_date',
			array(
				'label'   => esc_html__( 'Show Date', 'onenice' ),
				'section' => 'posts',
				'type'    => 'checkbox',
			)
		);
		// #single_show_date.

		// single_show_author.
		$wp_customize->add_setting(
			'single_show_author',
			array(
				'default'           => $onenice_defaults['single_show_author'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'single_show_author',
			array(
				'label'   => esc_html__( 'Show Author', 'onenice' ),
				'section' => 'posts',
				'type'    => 'checkbox',
			)
		);
		// #single_show_author.

		// single_show_tags.
		$wp_customize->add_setting(
			'single_show_tags',
			array(
				'default'           => $onenice_defaults['single_show_tags'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'single_show_tags',
			array(
				'label'   => esc_html__( 'Show Tags', 'onenice' ),
				'section' => 'posts',
				'type'    => 'checkbox',
			)
		);
		// #single_show_tags.

		// single_show_previous_next.
		$wp_customize->add_setting(
			'single_show_previous_next',
			array(
				'default'           => $onenice_defaults['single_show_previous_next'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'single_show_previous_next',
			array(
				'label'   => esc_html__( 'Show Previous/Next Posts', 'onenice' ),
				'section' => 'posts',
				'type'    => 'checkbox',
			)
		);
		// #single_show_previous_next.

		// show_related_posts.
		$wp_customize->add_setting(
			'show_related_posts',
			array(
				'default'           => $onenice_defaults['show_related_posts'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'show_related_posts',
			array(
				'label'   => esc_html__( 'Show Related Posts', 'onenice' ),
				'section' => 'posts',
				'type'    => 'checkbox',
			)
		);
		// #show_related_posts.

		// single_show_share.
		$wp_customize->add_setting(
			'single_show_share',
			array(
				'default'           => $onenice_defaults['single_show_share'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'single_show_share',
			array(
				'label'   => esc_html__( 'Show Share', 'onenice' ),
				'section' => 'posts',
				'type'    => 'checkbox',
			)
		);
		// #single_show_share.

		// single_disable_share_buttons.
		$wp_customize->add_setting(
			'single_disable_share_buttons',
			array(
				'default'           => $onenice_defaults['single_disable_share_buttons'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'single_disable_share_buttons',
			array(
				'label'       => esc_html__( 'Disable Share Buttons', 'onenice' ),
				'description' => 'weibo,wechat,qq,douban,qzone,tencent,<br/>linkedin,diandian,google,twitter,facebook',
				'section'     => 'posts',
				'type'        => 'textarea',

			)
		);
		// #single_disable_share_buttons.

		// single_enable_highlight.
		$wp_customize->add_setting(
			'single_enable_highlight',
			array(
				'default'           => $onenice_defaults['single_enable_highlight'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'single_enable_highlight',
			array(
				'label'   => esc_html__( 'Enable Code Highlight', 'onenice' ),
				'section' => 'posts',
				'type'    => 'checkbox',
			)
		);
		// #single_enable_highlight.
	}

}
