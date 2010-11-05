<?php


class leaguepress_controller_base
{
  
  var $url;
  
  var $form;
  
  var $html;
  
  function __construct() {
    $this->form = new FormHelper();
    $this->html = new HtmlHelper();
    $this->url = new UrlHelper();
  }
  
   
  function view( $model, $view = NULL, $controller = NULL ) {

    if (!$view || !$controller) {
      $backtrace = debug_backtrace();
      $controller = $controller ? $controller : $backtrace[1]['class'];
      $view = $view ? $view : $backtrace[1]['function'];
    }
    
    if( is_object($controller) )
      $controller = get_class($controller);

    include( LEAGUEPRESS_VIEW_PATH . $controller . '/' . $view . '.php');
    
  }  
  
  
  function redirect( $url ) {
        
  }
  
}

?>