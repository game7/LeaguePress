<?php

class FormHelper
{
  
  
  var $html;
  
  var $url;
  
  function __construct() {
    $this->html = new HtmlHelper();
    $this->url = new UrlHelper();
  }
  
  
  function begin( $options = array(), $controller = null, $action = null )
  {
    
    $htmlAttributes = array(
      'method' => 'post'      
    );
    
    if ( $action && $controller ) {
      $url = $this->url->action( $controller, $action ); 
      $htmlAttributes = array_merge($htmlAttributes, array( 'action' => $url ));
    }    
    return $this->html->beginTag( 'form', $htmlAttributes );  
    
  }

  function end() {
    return $this->html->endTag( 'form' );
  }
  
  function anti_forgery_token( $key ) {
    return wp_nonce_field( $key );
  }
  
}


?>