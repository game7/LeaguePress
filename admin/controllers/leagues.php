<?php

class leagues extends leaguepress_controller_base
{
  
  function __construct() {
    parent::__construct();
    require_once( LEAGUEPRESS_MODEL_PATH . 'league.php');
    require_once( LEAGUEPRESS_MODEL_PATH . 'season.php');
  }
  
  public function index( $args = NULL )
  {
    
    $model->leagues = League::ListForAdmin();

    $this->view( $model );
  } 
  
  public function add( $args = NULL )
  {
    echo 'add';
    $id = League::Create( $_POST['name']);
    
    $this->index();  
      
    //parent::setMessage( __('New League added', 'leaguepress') );
        
  }
  
  public function show( $args = NULL )
  {
      
    $leagueId = $args['id'];
    
    $model->league = League::Get( $leagueId );
    $model->seasons = Season::ListForAdmin( $leagueId );
    $model->season = $model->seasons[0];

    $this->view( $model );

  }
  
}

?>