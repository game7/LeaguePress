<?php

class Router {
  
  
  public function __construct( $route, $default_controller, $default_method, $parameters = null )
  {
    
    /* First let's try the specified $route.  If not then 
     * fallback to the provided defaults
     */
    $try = $this->route_it( $route, $default_method, $parameters );
    
    if( $try = false ) {
      return $this->default_route_it( $default_controller, $default_method, $route[2] );
    }
        
  }
  
  public function route_it( $route, $default_method, $parameters ) {
    
    $controller = $route[0];
    $method = $route[1];
    
    //$parameters = ( isset( $data[2] )  ? $data[2] : NULL );

    include_once(LEAGUEPRESS_CONTROLLER_PATH.$controller.'.php');    
    
    if( is_object( $controller ) and $controller instanceof $controller )
      $obj = $controller;
    elseif( class_exists( $controller ) )
      $obj = new $controller;
    else
      return false;
    
    if( method_exists( $obj, $method ) )
      return $obj->$method( $parameters );
    elseif( method_exists( $obj, $default_method ) )
      return $obj->$default_method( $parameters );
    else
      return false;
    
    
  }
  
  public function default_route_it( $controller, $method, $parameters = null ) {
    
    if( is_object( $controller ) and $controller instanceof $controller )
      $obj = $controller;
    elseif( class_exists( $controller ) )
      $obj = new $controller;
    else
      return false;
      
    if( method_exists( $obj, $method ) )
      return $obj->$method( $parameters );
    else
      return false;
      
  }
  
  
  
}


?>