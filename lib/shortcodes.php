<?php

class LeaguePressShortcodes extends LeaguePress {

  function __construct() {
    $this->addShortcodes();
  }
  
  function LeaguePressShortcodes() {
    $this->__construct();
  }
  
  function addShortcodes() {
    add_shortcode( 'lp-standings', array(&$this, 'showStandings') );
  }
  
    /**
   * Function to display League Standings
   *
   *  [lp-standings league_id="1" mode="extend|compact" template="name"]
   *
   * - league_id is the ID of league
   * - league_name (optional) get league by name and not id
   * - season: display specific season (optional). default is current season
   * - template is the template used for displaying. Replace name appropriately. Templates must be named "standings-template.php" (optional)
   * - group: optional
   *
   * @param array $atts
   * @param boolean $widget (optional)
   * @return the content
   */
  function showStandings( $atts, $widget = false )
  {
    return '<p>LeaguePress Standings</p>';
  }
  
}

?>