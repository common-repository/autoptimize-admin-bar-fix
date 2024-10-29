<?php
/**
Plugin Name: Autoptimize admin bar fix
Plugin URI: http://www.mijnpress.nl
Description: Fixes issue with Autoptimize plugin. This plugin will show your admin bar on frontend again.
Version: 1.1
Author: Ramon Fincken
Author URI: http://www.mijnpress.nl
Based on: http://www.mijnpress.nl/blog/plugin-framework/
*/
if (!defined('ABSPATH')) die("Aren't you supposed to come here via WP-Admin?");

if(!class_exists('mijnpress_plugin_framework'))
{
	include('mijnpress_plugin_framework.php');
}

class autoptimize_admin_bar_fix extends mijnpress_plugin_framework
{
	function __construct()
	{
		$this->showcredits = true;
		$this->showcredits_fordevelopers = true;
		$this->plugin_title = 'Autoptimize admin bar fix';
		$this->plugin_class = 'autoptimize_admin_bar_fix';
		$this->plugin_filename = 'autoptimize-admin-bar-fix/autoptimize_admin_bar_fix.php';
		$this->plugin_config_url = NULL;
	}

	function autoptimize_admin_bar_fix()
	{
		$args= func_get_args();
		call_user_func_array
		(
		    array(&$this, '__construct'),
		    $args
		);
	}

	function init_admin()
	{
		// perhaps use wp_get_active_and_valid_plugins() ?
		$plugins = get_option('active_plugins');

		// Admin bar frontend fix by disabling autoptimize for admin
    	$required_plugin = 'autoptimize/autoptimize.php';
    	if ( in_array( $required_plugin , $plugins ) ) {	  
    		remove_action('template_redirect','autoptimize_start_buffering',2);	
		}			
	}
		
	function addPluginSubMenu()
	{
		$plugin = new autoptimize_admin_bar_fix();
		parent::addPluginSubMenu($plugin->plugin_title,array($plugin->plugin_class, 'admin_menu'),__FILE__);
	}

	/**
	 * Additional links on the plugin page
	 */
	function addPluginContent($links, $file) {
		$plugin = new autoptimize_admin_bar_fix();
		$links = parent::addPluginContent($plugin->plugin_filename,$links,$file,$plugin->plugin_config_url);
		return $links;
	}

	/**
	 * Shows the admin plugin page
	 */
	public function admin_menu()
	{
		$plugin = new autoptimize_admin_bar_fix();
		$plugin->content_start();		
		
		$plugin->content_end();
	}
}

// Admin only
if(mijnpress_plugin_framework::is_admin())
{
	add_filter('plugin_row_meta',array('autoptimize_admin_bar_fix', 'addPluginContent'), 10, 2);
	add_action('init',  array('autoptimize_admin_bar_fix', 'init_admin'), 1);
}
?>