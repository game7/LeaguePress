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
    
    $htmlAttributes = $options;
    
    // method
    if (!$htmlAttributes['method'])
      $htmlAttributes['method'] = 'POST'; 
      
    // controller
    if ( !$controller ) $controller = $_GET['controller'  ];
            
    $output .= $this->html->beginTag( 'form', $htmlAttributes );
    $output .= $this->html->hidden( 'page', $_GET['page']);
    if ( $controller ) $output .= $this->html->hidden( 'controller', $controller);
    if ( $action ) $output .= $this->html->hidden( 'action', $action);
    
    return $output;
    
  }

  function end() {
    return $this->html->endTag( 'form' );
  }
    
  function anti_forgery_token( $key ) {
    return wp_nonce_field( $key );
  }
  
}


?>