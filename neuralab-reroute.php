<?php
/*
	Plugin Name: Neuralab Mail Rerouter
	Description: Simple rerouter plugin that reroutes wordpress emails to a specified adress.
	Version: 0.9.0
	Author: Karlo Biscan
	Author URI: https://www.neuralab.net
	Text Domain: nrlbreroute
*/

class NrlbMailRerouter {

	private $plugin_name;

	// Constructor
	public function __construct() {
		$this->add_actions();
		$this->add_filters();
	}

	// Adds actions
	private function add_actions() {
		add_action('init', array($this, 'textdomain'));
		add_action('admin_menu', array($this, 'add_admin_menu'));
		add_action('phpmailer_init', array($this, 'modify_phpmailer_object'), 1000, 1);
		add_action('admin_notices', array($this, 'add_notice'));
	}

	// Adds filters
	private function add_filters() {
		add_filter('plugin_action_links', array($this, 'add_settings_link'), 10, 2);
	}

	// Add textdomain
	public function textdomain() {
		load_plugin_textdomain('nrlbreroute', false, basename(dirname(__FILE__)) . '/languages');
	}

	// Add a submenu for settings page under Settings menu
	public function add_admin_menu() {
		add_menu_page('NRLB Reroute', 'NRLB Reroute', 'manage_options', 'neuralab-reroute/neuralab-reroute-settings.php');
	}

	/**
	* Unsets all recipient addresses from PHPMailer object and adds emails address to which all mails will be rerouted.
	*
	* @param object $phpmailer
	*
	*/
	public function modify_phpmailer_object($phpmailer) {
		$enable = get_option('nrlb_reroute_enable', 0);
		$email = get_option('nrlb_reroute_address', '');

		if ($enable && $email) {
			$phpmailer->ClearAllRecipients();

			$email_array = explode(',', $email);

			foreach ($email_array as $email) {
				$phpmailer->AddAddress(trim($email));
			}
		}
	}


	/**
	*
	* Add a settings link to the Plugins page
	*
	* @param array $links
	* @param string $file
	*
	*/
	public function add_settings_link($links, $file) {

		if (is_null($this->plugin_name)) {
			$this->plugin_name = plugin_basename(__FILE__);
		}

		if ($file == $this->plugin_name) {
			$settings_link = '<a href="admin.php?page=neuralab-reroute/neuralab-reroute-settings.php">' . __('Settings', 'nrlbreroute') . '</a>';
			array_unshift($links, $settings_link);
		}

		return $links;
	}


	/**
	*
	* Adds a notice that the plugin is enabled and reroutings
	*
	*/
	public function add_notice(){
		if(get_option('nrlb_reroute_enable', 0)){
			if(get_option('nrlb_reroute_address')){
				$extra = sprintf(__('All emails from the site will be sent to <strong>%1$s</strong>', 'nrlbreroute'), get_option('nrlb_reroute_address'));
			}

			$admin_url = admin_url();
			echo '<div class="error"> <p>'
				. sprintf(__('This site has %1$sNRLB Rerouter%2$s enabled.', 'nrlbreroute'), '<strong>', '</strong>')
				. ($extra ? ' ' . $extra . ' ' : '')
				. sprintf(__('To change settings go %1$shere%2$s.', 'nrlbreroute'), '<a href="' . $admin_url . 'admin.php?page=neuralab-reroute%2Fneuralab-reroute-settings.php">', '</a>')
					. '</p></div>';
		}
	}
}

new NrlbMailRerouter();
