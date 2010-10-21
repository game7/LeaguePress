

<div class="wrap nosubsub">

  <!-- Breadcrumb -->
  <p class="leaguepress_breadcrumb">
    <a href="admin.php?page=leaguepress"><?php _e( 'LeaguePress', 'leaguepress' ) ?></a>
     &raquo; <a href="admin.php?page=leaguepress-leagues">Schedule</a>
  </p>
  
  <!-- Title -->
  <h2>Schedule</h2>
  
  
  <div id="col-container">

    <div id="col-right">
      <div class="col-wrap">
        <div class="form-wrap">   
          <form id="schedule-filter" action="" method="post">
            <?php wp_nonce_field( 'schedule-bulk' ) ?>  
            
            <!-- Table Navigation -->
            <div class="tablenav" style="margin-bottom: 0.1em;">
                <!-- Bulk Actions -->
                <select name="action" size="1">
                  <option value="-1" selected="selected"><?php _e('Bulk Actions') ?></option>
                  <option value="delete"><?php _e('Delete')?></option>
                </select>
                <input type="submit" value="<?php _e('Apply'); ?>" name="doaction" id="doaction" class="button-secondary action" />
            </div>
            
            <table class="widefat" summary="" title="LeagueManager">
              <thead>
              <tr>
                <th scope="col" class="check-column"><input type="checkbox" onclick="Leaguemanager.checkAll(document.getElementById('leagues-filter'));" /></th>
                <th scope="col" class="num">ID</th>
                <th scope="col"><?php _e( 'League', 'leaguepress' ) ?></th>
                <th scope="col" class="num"><?php _e( 'Seasons', 'leaguepress' ) ?></th>
                <th scope="col"><?php _e( 'Current Season', 'leaguepress' ) ?></th>
              </tr>
              </thead>
              
              <tfoot>          
                <tr>
                  <th scope="col" class="check-column"><input type="checkbox" onclick="Leaguemanager.checkAll(document.getElementById('leagues-filter'));" /></th>
                  <th scope="col" class="num">ID</th>
                  <th scope="col"><?php _e( 'League', 'leaguepress' ) ?></th>
                  <th scope="col" class="num"><?php _e( 'Seasons', 'leaguepress' ) ?></th>
                  <th scope="col"><?php _e( 'Current Season', 'leaguepress' ) ?></th>
                </tr>           
              </tfoot>
            </table> 
