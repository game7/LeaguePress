<?php

class League extends leaguepress_model_base
{
  
  public static function ListForAdmin() {
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
  
  public static function Get ( $leagueId ) {
      
    global $wpdb;
    $league = $wpdb->get_results( $wpdb->prepare ( "SELECT `name`, `id`, `settings` FROM {$wpdb->leaguepress_leagues} WHERE `id` = %d", $leagueId ) );

    $league = $league[0];
    
    $league->settings = (array)maybe_unserialize($league->settings);

    $league = (object)array_merge((array)$league,(array)$league->settings);
    unset($league->settings);

    return $league;
        
  }
  
  public static function Create( $name ) {

    global $wpdb;
    
    $wpdb->insert($wpdb->leaguepress_leagues, array( 'name' => $name), array( '%s' ));
    $id = $wpdb->insert_id;
    return $id;

  }
  
}

?>