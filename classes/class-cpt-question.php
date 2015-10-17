<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines a custom post type and other related functionality.
 *
 * @link       http://slushman.com
 * @since      1.0.0
 *
 * @package    Just_The_FAQs
 * @subpackage Just_The_FAQs/classes
 * @author     Slushman <chris@slushman.com>
 */
class Just_The_FAQs_CPT_Question {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Constructor
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Changes the placeholder text for the title field
	 *
	 * @param 	string 	$title 			The current placeholder text
	 * @return 	string 					The modified placeholder text
	 */
	function change_title_text( $title ) {

		$screen = (object) get_current_screen();

		if  ( 'question' == $screen->post_type ) {

			$title = 'Enter the question here';

		}

		apply_filters( $this->plugin_name . '-title-text', $title );

		return $title;

	} // change_title_text()

	/**
	 * Creates a new custom post type
	 *
	 * @uses   register_post_type()
	 */
	public static function new_cpt_question() {

		$cap_type 	= 'post';
		$plural 	= 'Questions';
		$single 	= 'Question';
		$cpt_name 	= 'question';

		$opts['can_export']								= TRUE;
		$opts['capability_type']						= $cap_type;
		$opts['description']							= '';
		$opts['exclude_from_search']					= FALSE;
		$opts['has_archive']							= FALSE;
		$opts['hierarchical']							= FALSE;
		$opts['map_meta_cap']							= TRUE;
		$opts['menu_icon']								= 'dashicons-groups';
		$opts['menu_position']							= 25;
		$opts['public']									= TRUE;
		$opts['publicly_querable']						= TRUE;
		$opts['query_var']								= TRUE;
		$opts['register_meta_box_cb']					= '';
		$opts['rewrite']								= FALSE;
		$opts['show_in_admin_bar']						= TRUE;
		$opts['show_in_menu']							= TRUE;
		$opts['show_in_nav_menu']						= TRUE;
		$opts['show_ui']								= TRUE;
		$opts['supports']								= array( 'title', 'editor' );
		$opts['taxonomies']								= array();

		$opts['capabilities']['delete_others_posts']	= "delete_others_{$cap_type}s";
		$opts['capabilities']['delete_post']			= "delete_{$cap_type}";
		$opts['capabilities']['delete_posts']			= "delete_{$cap_type}s";
		$opts['capabilities']['delete_private_posts']	= "delete_private_{$cap_type}s";
		$opts['capabilities']['delete_published_posts']	= "delete_published_{$cap_type}s";
		$opts['capabilities']['edit_others_posts']		= "edit_others_{$cap_type}s";
		$opts['capabilities']['edit_post']				= "edit_{$cap_type}";
		$opts['capabilities']['edit_posts']				= "edit_{$cap_type}s";
		$opts['capabilities']['edit_private_posts']		= "edit_private_{$cap_type}s";
		$opts['capabilities']['edit_published_posts']	= "edit_published_{$cap_type}s";
		$opts['capabilities']['publish_posts']			= "publish_{$cap_type}s";
		$opts['capabilities']['read_post']				= "read_{$cap_type}";
		$opts['capabilities']['read_private_posts']		= "read_private_{$cap_type}s";

		$opts['labels']['add_new']						= esc_html__( "Add New {$single}", 'just-the-faqs' );
		$opts['labels']['add_new_item']					= esc_html__( "Add New {$single}", 'just-the-faqs' );
		$opts['labels']['all_items']					= esc_html__( $plural, 'just-the-faqs' );
		$opts['labels']['edit_item']					= esc_html__( "Edit {$single}" , 'just-the-faqs');
		$opts['labels']['menu_name']					= esc_html__( $plural, 'just-the-faqs' );
		$opts['labels']['name']							= esc_html__( $plural, 'just-the-faqs' );
		$opts['labels']['name_admin_bar']				= esc_html__( $single, 'just-the-faqs' );
		$opts['labels']['new_item']						= esc_html__( "New {$single}", 'just-the-faqs' );
		$opts['labels']['not_found']					= esc_html__( "No {$plural} Found", 'just-the-faqs' );
		$opts['labels']['not_found_in_trash']			= esc_html__( "No {$plural} Found in Trash", 'just-the-faqs' );
		$opts['labels']['parent_item_colon']			= esc_html__( "Parent {$plural} :", 'just-the-faqs' );
		$opts['labels']['search_items']					= esc_html__( "Search {$plural}", 'just-the-faqs' );
		$opts['labels']['singular_name']				= esc_html__( $single, 'just-the-faqs' );
		$opts['labels']['view_item']					= esc_html__( "View {$single}", 'just-the-faqs' );

		$opts['rewrite']['ep_mask']						= EP_PERMALINK;
		$opts['rewrite']['feeds']						= FALSE;
		$opts['rewrite']['pages']						= TRUE;
		$opts['rewrite']['slug']						= esc_html__( $cpt_name, 'just-the-faqs' );
		$opts['rewrite']['with_front']					= TRUE;

		$opts = apply_filters( 'just-the-faqs-cpt-' . $cpt_name . '-options', $opts );

		register_post_type( $cpt_name, $opts );

	} // new_cpt_question()

} // class