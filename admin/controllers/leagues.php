<?php

class leagues extends leaguepress_controller_base
{
  
  function __construct() {
    parent::__construct();
    require_once( LEAGUEPRESS_MODEL_PATH . 'league.php');
    require_once( LEAGUEPRESS_MODEL_PATH . 'season.php');
    require_once( LEAGUEPRESS_MODEL_PATH . 'team.php');
  }
  
  public function index( $args = NULL )
  {
    
    $model->leagues = League::ListForAdmin();

    $this->view( $model );
  } 
  
  public function add( $args = NULL )
  {

    $id = League::Create( $args['name']);
    
    $this->index();  
      
    //parent::setMessage( __('New League added', 'leaguepress') );
        
  }
  
  public function delete( $args = NULL )
  {
    
    League::Delete( $args['id'] );
    $this->index();
    
  }
  
  public function show( $args = NULL )
  {
      
    $leagueId = $args['id'];
    
    $model->league = League::Get( $leagueId );
    
    // fetch seasons
    $model->seasons = Season::ListForAdmin( $leagueId );
    
    // determine season to display
    $model->season = $model->seasons[0];
    if ( $args['seasonId'] ) {
      foreach ( $model->seasons as $season ) {
        if ( $season->id == $args['seasonId'] ) {
          $model->season = $season;
          break;
        }
      }
    }
    
    // fetch teams
    $model->teams = Team::ListForAdmin( $model->season->id );

    $this->view( $model );

  }
  
}

?>