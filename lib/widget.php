<?php

class LeaguePressWidget extends WP_Widget
{
  
  function __construct() {
      $widget_ops = array('classname' => 'leaguepress_widget', 'description' => __('League results and upcoming matches at a glance', 'leaguepress') );
      parent::__construct('leaguepress-widget', __( 'LeaguePress', 'leaguepress' ), $widget_ops);
  }
  
  function LeaguePressWidget() {
    $this->__construct();
  }
  
  function widget( $args, $instance )
  {
    echo $before_widget . $before_title . 'LeaguePress Widget' . $season . $after_title;
    echo '<p>Content Here</p>';
    echo $after_widget;
  }
  
    /**
   * save settings
   *
   * @param array $new_instance
   * @param $old_instance
   * @return array
   */
  function update( $new_instance, $old_instance )
  {
    return $new_instance;
  }
  
  /**
   * widget control panel
   *
   * @param int|array $widget_args
   */
  function form( $instance )
  {
    
    return;
  }
    
}

?>