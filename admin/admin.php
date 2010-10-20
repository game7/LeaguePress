<?php

class LeaguePressAdminPanel extends LeaguePress
{
  
  
  function __construct() {
    require_once( ABSPATH . 'wp-admin/includes/template.php' );
    add_action( 'admin_menu', array(&$this, 'menu') );
  }
  
  function LeaguePressAdminPanel() {
    $this->__construct();
  }
  
  
  /**
   * adds menu to the admin interface
   *
   * @param none
   */
  function menu()
  {
    $plugin = 'leaguepress/leaguepress.php';

    if ( function_exists('add_object_page') )
      add_object_page( __('LeaguePress','leaguepress'), __('LeaguePress','leaguepress'), 'leagues', LEAGUEPRESS_PATH, array(&$this, 'display') );
    else
      add_menu_page( __('LeaguePress','leaguepress'), __('LeaguePress','leaguepress'), 'leagues', LEAGUEPRESS_PATH, array(&$this, 'display'));

    add_submenu_page(LEAGUEPRESS_PATH, __('LeaguePress', 'leaguepress'), __('Dashboard','leaguepress'), 'leagues', LEAGUEPRESS_PATH, array(&$this, 'display'));
    add_submenu_page(LEAGUEPRESS_PATH, __('Leagues', 'leaguepress'), __('Leagues','leaguepress'),'manage_leagues', 'leaguepress-leagues', array(&$this, 'display' ));    
    add_submenu_page(LEAGUEPRESS_PATH, __('Schedule', 'leaguepress'), __('Schedule','leaguepress'),'manage_leagues', 'leaguepress-schedule', array(&$this, 'display' ));    
    add_submenu_page(LEAGUEPRESS_PATH, __('Post Results', 'leaguepress'), __('Post Results','leaguepress'),'manage_leagues', 'leaguepress-results', array(&$this, 'display' ));    
    add_submenu_page(LEAGUEPRESS_PATH, __('Settings', 'leaguepress'), __('Settings','leaguepress'),'manage_leagues', 'leaguepress-settings', array(&$this, 'display' ));
  
    add_filter( 'plugin_action_links_' . $plugin, array( &$this, 'pluginActions' ) );
  }
  
  function display() {
    
    global $leaguepress;
    
    $options = get_option('leaguepress');
    $page = str_replace('leaguepress-', '', $_GET['page']);
    
    $view = isset($_GET['view']) ? $_GET['view'] : 'index';

    switch ($page) {
      case 'leaguepress':
        include_once(dirname(__FILE__) . '/dashboard/index.php');
        break;      
      default:
        include_once(dirname(__FILE__) . '/' . $page . '/' . $view . '.php');
        break;
    }
    
    
  }

  /**
   * set message by calling parent function
   *
   * @param string $message
   * @param boolean $error (optional)
   * @return void
   */
  function setMessage( $message, $error = false )
  {
    parent::setMessage( $message, $error );
  }
  
  /**
   * print message calls parent
   *
   * @param none
   * @return string
   */
  function printMessage()
  {
    parent::printMessage();
  }
  
  
  
  
  function pluginActions( $links ) {
    
    $settings_link = '<a href="admin.php?page=leaguepress-settings">' . __('Settings') . '</a>';
    array_unshift( $links, $settings_link );
  
    return $links;
    
  }

  function listLeaguesForAdmin()
  {
    global $wpdb;
    
    $leagues = $wpdb->get_results( "SELECT `name`, `id`, `settings` FROM {$wpdb->leaguepress_leagues} ORDER BY id ASC" );
    
    $i = 0;
    foreach ( $leagues AS $league ) {
      $league->settings = maybe_unserialize($league->settings);
      $league->seasonCount = 0;      
      $leagues[$i] = (object)array_merge((array)$league,(array)$league->settings);
      unset($leagues[$i]->settings, $league->settings);
      $i++;
    }
    
    return $leagues;
  }

  function createNewLeague( $name )
  {
    global $wpdb;
    
    //$settings = array( 'upload_dir' => 'wp-content/uploads/leaguemanager', 'standings' => array('pld' => 1, 'won' => 1, 'tie' => 1, 'lost' => 1) );
    $wpdb->insert($wpdb->leaguepress_leagues, array( 'name' => $name), array( '%s' ));
    $id = $wpdb->insert_id;
    parent::setMessage( __('New League added', 'leaguepress') );
    return $id;
  }
  
  function deleteLeague($leagueId)
  {
    global $wpdb;
    $wpdb->query( $wpdb->prepare ( "DELETE FROM {$wpdb->leaguepress_leagues} WHERE `id` = '%d'", $leagueId ) );
  }
  
  function renameLeague( $leagueId, $newName )
  {
    global $wpdb;

    $wpdb->query( $wpdb->prepare ( "UPDATE {$wpdb->leaguepress_leagues} SET `name` = '%s' WHERE `id` = '%d'", $title, $leagueId ) );
    parent::setMessage( __('League renamed', 'leaguepress') );    
  }
  
  function setCurrentSeasonForLeague( $leagueId, $seasonId )
  {
    global $wpdb;

    $wpdb->query( $wpdb->prepare ( "UPDATE {$wpdb->leaguepress_leageus} SET `currentSeasonId` = '%d' WHERE `id` = '%d'", $seasonId, $leagueId ) );
    parent::setMessage( __('Current season updated', 'leaguepress') );      
  }
  
  function listSeasonsForAdmin( $leagueId )
  {
    global $wpdb;
    $seasons = $wpdb->get_results( $wpdb->prepare ("SELECT `id`, `name`, `startsOn`, `settings` FROM {$wpdb->leaguepress_seasons} WHERE `leagueId` = '%d' ORDER BY startsOn DESC", $leagueId ) );

    $i = 0;
    foreach ( $seasons AS $season ) {
      $season->settings = maybe_unserialize($season->settings);
      $seasons[$i] = (object)array_merge((array)$season,(array)$season->settings);
      unset($seasons[$i]->settings, $season->settings);
      $i++;
    }
    
    return $seasons;
  }
  
  function createNewSeasonForLeague ( $leagueId, $name, $startsOn )
  {
     global $wpdb;
    
    //$settings = array( 'upload_dir' => 'wp-content/uploads/leaguemanager', 'standings' => array('pld' => 1, 'won' => 1, 'tie' => 1, 'lost' => 1) );
    $wpdb->insert($wpdb->leaguepress_seasons, array( 'leagueId' => $leagueId, 'name' => $name, 'startsOn' => $startsOn), array( '%d', '%s', '%s' ));
    $id = $wpdb->insert_id;    
    parent::setMessage( __('New Season added', 'leaguepress') ); 
    return $id;  
  }
  
  function renameSeason ( $seasonId, $newName )
  {
    global $wpdb;

    $wpdb->query( $wpdb->prepare ( "UPDATE {$wpdb->leaguepress_seasons} SET `name` = '%s' WHERE `id` = '%d'", $title, $seasonId ) );
    parent::setMessage( __('Season renamed', 'leaguepress') );       
  }
  
  function createTeamForSeason ( $seasonId, $name, $shortName )
  {
    global $wpdb;
    
    //$settings = array( 'upload_dir' => 'wp-content/uploads/leaguemanager', 'standings' => array('pld' => 1, 'won' => 1, 'tie' => 1, 'lost' => 1) );
    $wpdb->insert($wpdb->leaguepress_teams, array( 'seasonId' => $seasonId, 'name' => $name, 'shortName' => $shortName), array( '%d', '%s', '%s' ));
    $id = $wpdb->insert_id;    
    parent::setMessage( __('New Team added', 'leaguepress') );  
    return $id; 
  }
  
  function deleteTeam ( $teamId ) {
    global $wpdb;
    $wpdb->query( $wpdb->prepare ( "DELETE FROM {$wpdb->leaguepress_teams} WHERE `id` = '%d'", $teamId ) );
  }
  
  function listTEamsForSeasonForAdmin ( $seasonId )
  {
    global $wpdb;
    
    $teams = $wpdb->get_results( "SELECT `id`, `name`, `shortName` FROM {$wpdb->leaguepress_teams} ORDER BY name ASC" );  
   
    return $teams;
  }  
  
  function renameTeam ( $teamId, $newName, $newShortName )
  {
    
  }
  
  function createNewGame( $id, $seasonId, $leftTeamId, $leftTeamName, $rightTeamId, $rightTeamName)
  {
    
  }
  
  
    /**
   * renders HTML for a date selector.
   *
   * @param int $day
   * @param int $month
   * @param int $year
   * @param int $index default 0
   * @return string
   */
  function renderDateSelector( $name, $day, $month, $year)
  {
    $out = '<select size="1" name="'.$name.'_day" class="date">';
    $out .= "<option value='00'>".__('Day','leaguepress')."</option>";
    for ( $d = 1; $d <= 31; $d++ ) {
      $selected = ( $d == $day ) ? ' selected="selected"' : '';
      $out .= '<option value="'.str_pad($d, 2, 0, STR_PAD_LEFT).'"'.$selected.'>'.$d.'</option>';
    }
    $out .= '</select>';
    $out .= '<select size="1" name="'.$name.'_month" class="date">';
    $out .= "<option value='00'>".__('Month','leaguepress')."</option>";
    foreach ( parent::getMonths() AS $key => $m ) {
      $selected = ( $key == $month ) ? ' selected="selected"' : '';
      $out .= '<option value="'.str_pad($key, 2, 0, STR_PAD_LEFT).'"'.$selected.'>'.$m.'</option>';
    }
    $out .= '</select>';
    $out .= '<select size="1" name="'.$name.'_year" class="date">';
    $out .= "<option value='0000'>".__('Year','leaguepress')."</option>"; 
    $startYear = date("Y");
    $endYear = date("Y")+10;
    if (isset($year)) {
      if ($year < $startYear)
        $startYear = $year;
      elseif ($year > $endYear)
        $endYear = $year;
    }
    $y = $startYear;
    for ( $y = $startYear; $y <= $endYear; $y++ ) {
      $selected =  ( $y == $year ) ? ' selected="selected"' : '';
      $out .= '<option value="'.$y.'"'.$selected.'>'.$y.'</option>';
    }
    $out .= '</select>';
    return $out;
  }
  
  
}


?>