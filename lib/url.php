<?php


class UrlHelper
{
  
  
  function __construct() {
    
    
  }
  
  
  function action( $controller, $action, $params = array() ) {
    
    $url = $_SERVER['SCRIPT_NAME'];
    $url .= '?page=' . $_GET['page'];
    $url .= '&controller=' . $controller;
    $url .= '&action=' . $action;
    foreach($params as $key => $value)
      $url .= '&'.$key.'='.$value;
    
    return $url;
        
  }
  
  
}





?>