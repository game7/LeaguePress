<?php

class Team extends leaguepress_model_base
{
  
  public static function ListForAdmin( $seasonId )
  {
      
    global $wpdb;
    
    $teams = $wpdb->get_results( "SELECT `id`, `name`, `shortName` FROM {$wpdb->leaguepress_teams} ORDER BY name ASC" );  
   
    return $teams;
    
  }
  
  public static function Get ( $id ) {
      
        
  }
  
  public static function Create( $name ) {


  }
  
}

?>