<?php

class LeaguePress {
  
    /**
   * message
   *
   * @var string
   */
  var $message;
  
  
  
  function __construct() {
    $this->loadOptions();
  }
  
  function LeaguePress() {
    $this->__construct();
  }
  
  function loadOptions() {
    $this->options = get_option('leaguepress');
  }
  
  function getOptions() {
    return $this->options;
  }
  
  
  /**
   * return message
   *
   * @param none
   * @return string
   */
  function getMessage()
  {
    if ( $this->error )
      return $this->message['error'];
    else
      return $this->message['success'];
  }
  
    /**
   * get months
   *
   * @param none
   * @return void
   */
  function getMonths()
  {
    $locale = get_locale();
    setlocale(LC_ALL, $locale);
    for ( $month = 1; $month <= 12; $month++ ) 
      $months[$month] = htmlentities( strftime( "%B", mktime( 0,0,0, $month, date("m"), date("Y") ) ) );
      
    return $months;
  }
    
  
  
  /**
   * print formatted message
   *
   * @param none
   * @return string
   */
  function printMessage()
  {
    if ( $this->error )
      echo "<div class='error'><p>".$this->getMessage()."</p></div>";
    else
      echo "<div id='message' class='updated fade'><p><strong>".$this->getMessage()."</strong></p></div";
  }
  
  /**
   * set message
   *
   * @param string $message
   * @param boolean $error triggers error message if true
   * @return none
   */
  function setMessage( $message, $error = false )
  {
    $type = 'success';
    if ( $error ) {
      $this->error = true;
      $type = 'error';
    }
    $this->message[$type] = $message;
  }  
  
  function listLeagues()
  {
    global $wpdb;
    
    $leagues = $wpdb->get_results( "SELECT `name`, `id`, `settings` FROM {$wpdb->leaguepress_leagues} ORDER BY id ASC" );
    
    return $leagues;    
  }
  
  function getLeague( $leagueId ) {
    global $wpdb;
    
    $league = $wpdb->get_results( "SELECT `name`, `id`, `settings` FROM {$wpdb->leaguepress_leagues}" );
    $league = $league[0];
    $league->settings = (array)maybe_unserialize($league->settings);

    $league = (object)array_merge((array)$league,(array)$league->settings);
    unset($league->settings);

    $this->league = $league;
    return $league;

  }
  
  
}

?>