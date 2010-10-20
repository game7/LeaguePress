<?php
/*
Plugin Name: LeaguePress
Plugin URI: http://wordpress.org/extend/plugins/LeaguePress/
Description: Sports league management plugin
Version: 0.1
Author: Game 7

Copyright 2010  Game 7 Digital Solutions  (email : cmwoodall@game7.net)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
* Loading class for the WordPress plugin LeaguePress
* 
* @author 	Chris Woodall
* @package	LeaguePress
* @copyright 	Copyright 2010
*/
class LeaguePressLoader
{
	/**
	 * plugin version
	 *
	 * @var string
	 */
	var $version = '0.1';
	
	
	/**
	 * database version
	 *
	 * @var string
	 */
	var $dbversion = '0.1';
	
	/**
	 * admin Panel object
	 *
	 * @var object
	 */
	var $adminPanel;


	/**
	 * constructor
	 *
	 * @param none
	 * @return void
	 */
	function __construct()
	{
		global $leaguepress, $wpdb;
		$wpdb->show_errors();
		$this->loadOptions();
		$this->defineConstants();
		$this->defineTables();
		$this->loadTextdomain();
		$this->loadLibraries();

		register_activation_hook(__FILE__, array(&$this, 'activate') );
			
		if (function_exists('register_uninstall_hook'))
			register_uninstall_hook(__FILE__, array(&$this, 'uninstall'));

		add_action( 'widgets_init', array(&$this, 'registerWidget') );
		// Start this plugin once all other plugins are fully loaded
		add_action( 'plugins_loaded', array(&$this, 'initialize') );
		
		$leaguemanager = new LeaguePress(  );
		
		if ( is_admin() )
			$this->adminPanel = new LeaguePressAdminPanel();
	}
  
	function LeaguePressLoader()
	{
		$this->__construct();
	}
	
		
	/**
	 * initialize plugin
	 *
	 * @param none
	 * @return void
	 */
	function initialize()
	{
		// Add the script and style files
		add_action('wp_head', array(&$this, 'loadScripts') );
		add_action('wp_print_styles', array(&$this, 'loadStyles') );
		// Add TinyMCE Button
		add_action( 'init', array(&$this, 'addTinyMCEButton') );
		add_filter( 'tiny_mce_version', array(&$this, 'changeTinyMCEVersion') );
	}
		
	
	/**
	 * register Widget
	 */
	function registerWidget()
	{
		register_widget('LeaguePressWidget');
	}


	/**
	 * define constants
	 *
	 * @param none
	 * @return void
	 */
	function defineConstants()
	{
		if ( !defined( 'WP_CONTENT_URL' ) )
			define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
		if ( !defined( 'WP_PLUGIN_URL' ) )
			define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
		if ( !defined( 'WP_CONTENT_DIR' ) )
			define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
		if ( !defined( 'WP_PLUGIN_DIR' ) )
			define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );
			
		define( 'LEAGUEPRESS_VERSION', $this->version );
		define( 'LEAGUEPRESS_DBVERSION', $this->dbversion );
		define( 'LEAGUEPRESS_URL', WP_PLUGIN_URL.'/leaguepress' );
		define( 'LEAGUEPRESS_PATH', WP_PLUGIN_DIR.'/leaguepress' );
	}

	
		
	/**
	 * load libraries
	 *
	 * @param none
	 * @return void
	 */
	function loadLibraries()
	{
		global $lpShortcodes, $lpAJAX;
		
		// Global libraries
		require_once (dirname (__FILE__) . '/lib/core.php');
		require_once (dirname (__FILE__) . '/lib/ajax.php');
		require_once (dirname (__FILE__) . '/lib/shortcodes.php');
		require_once (dirname (__FILE__) . '/lib/widget.php');
		require_once (dirname (__FILE__) . '/functions.php');
		$this->loadSports();
		//$lpAJAX = new LeaguePressAJAX();

		if ( is_admin() ) {
			require_once (dirname (__FILE__) . '/lib/image.php');
			require_once (dirname (__FILE__) . '/admin/admin.php');	
		}
			
		$lpShortcodes = new LeaguePressShortcodes();
	}
		

	/**
	 * load sport types
	 *
	 * @param none
	 * @return void
	 */
	function loadSports()
	{
		$dir = LEAGUEPRESS_PATH."/sports";
		if ( $handle = opendir($dir) ) {
			while ( false !== ($file = readdir($handle)) ) {
				$file_info = pathinfo($dir.'/'.$file);
				$file_type = $file_info['extension'];
				if ( $file != "." && $file != ".." && !is_dir($file) && substr($file, 0,1) != "."  && $file_type == 'php' )  {
					require_once($dir.'/'.$file);
				}
			}
		}
	}


	/**
	 * load options
	 *
	 * @param none
	 * @return void
	 */
	function loadOptions()
	{
		$this->options = get_option('leaguepress');
	}
		
		
	/**
	 * get options
	 *
	 * @param boolean $index (optional)
	 * @return void
	 */
	function getOptions($index = false)
	{
		if ( $index )
			return $this->options[$index];
			return $this->options;
	}
  
	
	/**
	 * load textdomain
	 *
	 * @param none
	 * @return void
	 */
	function loadTextdomain()
	{
		global $leaguepress;
		
		$textdomain = $this->getOptions('textdomain');
		if ( !empty($textdomain) ) {
			$locale = get_locale();
			$path = dirname(__FILE__) . '/languages';
			$domain = 'leaguepress';
			$mofile = $path . '/'. $domain . '-' . $textdomain . '-' . $locale . '.mo';
			
			if ( file_exists($mofile) ) {
				load_textdomain($domain, $mofile);
				return true;
			}
		}
		
		load_plugin_textdomain( 'leaguepress', false, 'leaguepress/languages' );
	}
	

	/**
	 * load scripts
	 *
	 * @param none
	 * @return void
	 */
	function loadScripts()
	{
		wp_register_script( 'leaguepress', LEAGUEMANAGER_URL.'/leaguepress.js', array('jquery', 'sack', 'thickbox'), LEAGUEPRESS_VERSION );
		wp_print_scripts('leaguepress');
		?>
		<script type="text/javascript">
		//<![CDATA[
		LeaguePessAjaxL10n = {
			blogUrl: "<?php bloginfo( 'wpurl' ); ?>", pluginPath: "<?php echo LEAGUEMANAGER_PATH; ?>", pluginUrl: "<?php echo LEAGUEPRESS_URL; ?>", requestUrl: "<?php echo LEAGUEPRESSURL ?>/ajax.php", Edit: "<?php _e("Edit"); ?>", Post: "<?php _e("Post"); ?>", Save: "<?php _e("Save"); ?>", Cancel: "<?php _e("Cancel"); ?>", pleaseWait: "<?php _e("Please wait..."); ?>", Revisions: "<?php _e("Page Revisions"); ?>", Time: "<?php _e("Insert time"); ?>", Options: "<?php _e("Options") ?>", Delete: "<?php _e('Delete') ?>"
	 	}
		//]]>
		</script>
		<?php
	}
		
		
	/**
	 * load styles
	 *
	 * @param none
	 * @return void
	 */
	function loadStyles()
	{
		wp_enqueue_style('thickbox');
		wp_enqueue_style('leaguepress', LEAGUEMANAGER_URL . "/style.css", false, '1.0', 'screen');
		/*
		echo "\n<style type='text/css'>";
		if ( !empty($this->options['colors']['headers']) )
		echo "\n\ttable.leaguemanager th { background-color: ".$this->options['colors']['headers']." }";

		if ( !empty($this->options['colors']['rows']['main']) )
		echo "\n\ttable.leaguemanager tr { background-color: ".$this->options['colors']['rows']['main']." }";

		if ( !empty($this->options['colors']['rows']['alternate']) )
		echo "\n\ttable.leaguemanager tr.alternate { background-color: ".$this->options['colors']['rows']['alternate']." }";

		if ( !empty($this->options['colors']['rows']['ascend']) )
		echo "\n\ttable.standingstable tr.ascend, table.standingstable tr.ascend.alternate { background-color: ".$this->options['colors']['rows']['ascend']." }";

		if ( !empty($this->options['colors']['rows']['descend']) )
		echo "\n\ttable.standingstable tr.descend, table.standingstable tr.descend.alternate { background-color: ".$this->options['colors']['rows']['descend']." }";

		if ( !empty($this->options['colors']['rows']['relegation']) )
		echo "\n\ttable.standingstable tr.relegation, table.standingstable tr.relegation.alternate { background-color: ".$this->options['colors']['rows']['relegation']." }";

		if ( !empty($this->options['colors']['rows']['alternate']) )
		echo "\n\ttable.crosstable th, table.crosstable td { border: 1px solid ".$this->options['colors']['rows']['alternate']."; }";
		echo "\n</style>";
     */
	}
		
		
	/**
	 * add TinyMCE Button
	 *
	 * @param none
	 * @return void
	 */
	function addTinyMCEButton()
	{
		// Don't bother doing this stuff if the current user lacks permissions
		if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) return;
		
		// Check for LeagueManager capability
		if ( !current_user_can('manage_leagues') ) return;
		
		// Add only in Rich Editor mode
		if ( get_user_option('rich_editing') == 'true') {
			add_filter("mce_external_plugins", array(&$this, 'addTinyMCEPlugin'));
			add_filter('mce_buttons', array(&$this, 'registerTinyMCEButton'));
		}
	}
	function addTinyMCEPlugin( $plugin_array )
	{
		$plugin_array['LeaguePress'] = LEAGUEMANAGER_URL.'/admin/tinymce/editor_plugin.js';
		return $plugin_array;
	}
	function registerTinyMCEButton( $buttons )
	{
		array_push($buttons, "separator", "LeaguePress");
		return $buttons;
	}
	function changeTinyMCEVersion( $version )
	{
		return ++$version;
	}
  
    
    
  /**
   * define database tables
   *
   * @param none
   * @return void
   */
  function defineTables()
  {
    global $wpdb;
    $wpdb->leaguepress_leagues = $wpdb->prefix . 'leaguepress_leagues';
    $wpdb->leaguepress_seasons = $wpdb->prefix . 'leaguepress_seasons';
    $wpdb->leaguepress_teams = $wpdb->prefix . 'leaguepress_teams';
    $wpdb->leaguepress_matches = $wpdb->prefix . 'leaguepress_matches';
  }
		
		
	/**
	 * Activate plugin
	 *
	 * @param none
	 */
	function activate()
	{
		$options = array();
		$options['version'] = $this->version;
		$options['dbversion'] = $this->dbversion;
		$options['textdomain'] = 'default';
		$options['colors']['headers'] = '#dddddd';
		$options['colors']['rows'] = array( '#ffffff', '#efefef' );
		add_option( 'leaguepress', $options, 'Leaguepress Options', 'yes' );
		add_option( 'leaguepress_widget', array(), 'Leaguepress Widget Options', 'yes' );
		/*
		* Set Capabilities
		*/
		$role = get_role('administrator');
		$role->add_cap('manage_leagues');
		$role->add_cap('leagues');
	
		$role = get_role('editor');
		$role->add_cap('leagues');
	
		$this->install();
	}
		
		
		
	function install()
	{
		global $wpdb;
		include_once( ABSPATH.'/wp-admin/includes/upgrade.php' );
		
		$charset_collate = '';
		if ( $wpdb->has_cap( 'collation' ) ) {
			if ( ! empty($wpdb->charset) )
				$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
			if ( ! empty($wpdb->collate) )
				$charset_collate .= " COLLATE $wpdb->collate";
		}
		
		$create_leagues_sql = "CREATE TABLE {$wpdb->leaguepress_leagues} (
						`id` int( 11 ) NOT NULL AUTO_INCREMENT,
						`name` varchar( 100 ) NOT NULL default '',
						`settings` longtext NOT NULL,
						PRIMARY KEY ( `id` )) $charset_collate;";
		maybe_create_table( $wpdb->leaguepress_leagues, $create_leagues_sql );

    $create_seasons_sql = "CREATE TABLE {$wpdb->leaguepress_seasons} (
            `id` int( 11 ) NOT NULL AUTO_INCREMENT,
            `leagueId` int( 11 ) NOT NULL,            
            `name` varchar( 100 ) NOT NULL default '',
            `startsOn` datetime NOT NULL default '0000-00-00',
            `settings` longtext NOT NULL,
            PRIMARY KEY ( `id` )) $charset_collate;";
    maybe_create_table( $wpdb->leaguepress_seasons, $create_seasons_sql );
        		
		$create_teams_sql = "CREATE TABLE {$wpdb->leaguepress_teams} (
						`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
            `seasonId` int( 11 ) NOT NULL,						
						`name` varchar( 100 ) NOT NULL default '',
            `shortName` varchar( 100 ) NOT NULL default '',	
            `showInStandings` bool NOT NULL default '0',		
						`logo` varchar( 150 ) NOT NULL default '',
						`website` varchar( 255 ) NOT NULL default '',
						PRIMARY KEY ( `id` )) $charset_collate;";
		maybe_create_table( $wpdb->leaguepress_teams, $create_teams_sql );
			
		$create_matches_sql = "CREATE TABLE {$wpdb->leaguepress_matches} (
						`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
						`group` varchar( 30 ) NOT NULL default '',
						`date` datetime NOT NULL default '0000-00-00',
						`home_team` varchar( 255 ) NOT NULL default '0',
						`away_team` varchar( 255 ) NOT NULL default '0',
						`match_day` tinyint( 4 ) NOT NULL default '0',
						`location` varchar( 100 ) NOT NULL default '',
						`league_id` int( 11 ) NOT NULL default '0',
						`season` varchar( 255 ) NOT NULL default '',
						`home_points` varchar( 30 ) NULL default NULL,
						`away_points` varchar( 30 ) NULL default NULL,
						`winner_id` int( 11 ) NOT NULL default '0',
						`loser_id` int( 11 ) NOT NULL default '0',
						`post_id` int( 11 ) NOT NULL default '0',
						`final` varchar( 150 ) NOT NULL default '',
						`custom` longtext NOT NULL,
						PRIMARY KEY ( `id` )) $charset_collate;";
		maybe_create_table( $wpdb->leaguepress_matches, $create_matches_sql );

	}
		
		
	/**
	 * Uninstall Plugin
	 *
	 * @param none
	 */
	function uninstall()
	{
		global $wpdb, $leaguemanager;
		
		$wpdb->query( "DROP TABLE {$wpdb->leaguepress_matches}" );
		$wpdb->query( "DROP TABLE {$wpdb->leaguepress_teams}" );
		$wpdb->query( "DROP TABLE {$wpdb->leaguepress_seasons}" );
		$wpdb->query( "DROP TABLE {$wpdb->leaguepress_leagues}" );
		
		delete_option( 'leaguepress_widget' );
		delete_option( 'leaguepress' );
		
		// Delete Logos
		$dir = $leaguemanager->getImagePath();
		if ( $handle = opendir($dir) ) {
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != "..")
					@unlink($file);
			}
			closedir($handle);
		}
		@rmdir($dir);
	}


	/**
	 * get admin object
	 *
	 * @param none
	 * @return object
	 */
	function getAdminPanel()
	{
		return $this->adminPanel;
	}
}

// Run the Plugin
global $lpLoader;
$lpLoader = new LeaguePressLoader();


?>
