<?php

class Season extends leaguepress_model_base
{
  
  public static function ListForAdmin( $leagueId )
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
  
  public static function Get ( $id ) {
      
        
  }
  
  public static function Create( $name ) {


  }
  
}

?>