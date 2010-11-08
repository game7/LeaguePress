<?php

class HtmlHelper {

/**
 * html tags used by this helper.
 *
 * @var array
 * @access public
 */
  var $tags = array(
    'meta' => '<meta%s/>',
    'metalink' => '<link href="%s"%s/>',
    'link' => '<a href="%s"%s>%s</a>',
    'mailto' => '<a href="mailto:%s" %s>%s</a>',
    'form' => '<form %s>',
    'formend' => '</form>',
    'input' => '<input name="%s" %s/>',
    'textarea' => '<textarea name="%s" %s>%s</textarea>',
    'hidden' => '<input type="hidden" name="%s" %s/>',
    'checkbox' => '<input type="checkbox" name="%s" %s/>',
    'checkboxmultiple' => '<input type="checkbox" name="%s[]"%s />',
    'radio' => '<input type="radio" name="%s" id="%s" %s />%s',
    'selectstart' => '<select name="%s"%s>',
    'selectmultiplestart' => '<select name="%s[]"%s>',
    'selectempty' => '<option value=""%s>&nbsp;</option>',
    'selectoption' => '<option value="%s"%s>%s</option>',
    'selectend' => '</select>',
    'optiongroup' => '<optgroup label="%s"%s>',
    'optiongroupend' => '</optgroup>',
    'checkboxmultiplestart' => '',
    'checkboxmultipleend' => '',
    'password' => '<input type="password" name="%s" %s/>',
    'file' => '<input type="file" name="%s" %s/>',
    'file_no_model' => '<input type="file" name="%s" %s/>',
    'submit' => '<input %s/>',
    'submitimage' => '<input type="image" src="%s" %s/>',
    'button' => '<button type="%s"%s>%s</button>',
    'image' => '<img src="%s" %s/>',
    'tableheader' => '<th%s>%s</th>',
    'tableheaderrow' => '<tr%s>%s</tr>',
    'tablecell' => '<td%s>%s</td>',
    'tablerow' => '<tr%s>%s</tr>',
    'block' => '<div%s>%s</div>',
    'blockstart' => '<div%s>',
    'blockend' => '</div>',
    'tag' => '<%s%s>%s</%s>',
    'tagstart' => '<%s%s>',
    'tagend' => '</%s>',
    'para' => '<p%s>%s</p>',
    'parastart' => '<p%s>',
    'label' => '<label for="%s"%s>%s</label>',
    'fieldset' => '<fieldset%s>%s</fieldset>',
    'fieldsetstart' => '<fieldset><legend>%s</legend>',
    'fieldsetend' => '</fieldset>',
    'legend' => '<legend>%s</legend>',
    'css' => '<link rel="%s" type="text/css" href="%s" %s/>',
    'style' => '<style type="text/css"%s>%s</style>',
    'charset' => '<meta http-equiv="Content-Type" content="text/html; charset=%s" />',
    'ul' => '<ul%s>%s</ul>',
    'ol' => '<ol%s>%s</ol>',
    'li' => '<li%s>%s</li>',
    'error' => '<div%s>%s</div>',
    'javascriptblock' => '<script type="text/javascript"%s>%s</script>',
    'javascriptstart' => '<script type="text/javascript">',
    'javascriptlink' => '<script type="text/javascript" src="%s"%s></script>',
    'javascriptend' => '</script>'
  );
  
  
  function beginTag( $tag, $attributes = array() ) {
       
    return sprintf( $this->tags['form'], $this->attributes_to_string($attributes) );
    
  }
  
  function endTag( $tag ) {
    return $this->tags['formend'];
  }

  function selfClosingTag( $tag, $attributes = array() ) {
    
  }
  
  /*
   * 'link' => '<a href="%s"%s>%s</a>'
   */
  function link( $title, $url = null, $options = array(), $confirmMessage = false) {
      
    return sprintf( $this->tags['link'], $url, $this->attributes_to_string($options), $title);
    
  }

  function hidden( $name, $value ) {
    return sprintf( $this->tags['hidden'], $name, $this->attributes_to_string( array( 'value' => $value ) ) );
  }

  function attributes_to_string( $array ) {
    foreach($array as $key => $value)
      $result .= ' '.$key.'="'.$value.'"';
    return $result;
  }
  
}

?>