
   
  <form id="teams-filter" action="" method="post">
    <?php wp_nonce_field( 'leaguepress-leagues-teams-list' ) ?>  
    
    <!-- Table Navigation -->
    <div class="tablenav" style="margin-bottom: 0.1em;">
        <!-- Bulk Actions -->
        <select name="action" size="1">
          <option value="-1" selected="selected"><?php _e('Bulk Actions') ?></option>
          <option value="delete"><?php _e('Delete')?></option>
        </select>
        <input type="submit" value="<?php _e('Apply'); ?>" name="doaction" id="doaction" class="button-secondary action" />
    </div>
    
    <!-- Table -->
    <table class="widefat">
      <thead>
        <tr>
          <th scope="col" class="check-column"><input type="checkbox" onclick="Leaguemanager.checkAll(document.getElementById('seaons-filter'));" /></th>
          <th scope="col"><?php _e( 'Name', 'leaguePress' ) ?></th>
          <th scope="col"><?php _e( 'Short Name', 'leaguePress' ) ?></th>
          <th scope="col" class="num"><?php _e( 'Players', 'leaguepress' ) ?></th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <th scope="col" class="check-column"><input type="checkbox" onclick="Leaguemanager.checkAll(document.getElementById('seaons-filter'));" /></th>
          <th scope="col"><?php _e( 'Name', 'leaguePress' ) ?></th>
          <th scope="col"><?php _e( 'Short Name', 'leaguePress' ) ?></th>
          <th scope="col" class="num"><?php _e( 'Players', 'leaguepress' ) ?></th>
        </tr>
      </tfoot>              
      <tbody id="the-list" class="list">
        <?php foreach( $teams AS $team ) : $class = ( 'alternate' == $class ) ? '' : 'alternate' ?>
        <tr class="<?php echo $class ?>">
          <th scope="row" class="check-column"><input type="checkbox" value="<?php echo $key ?>" name="del_team[<?php echo $key ?>]" /></th>
          <td>
            <?php echo $team->name; ?><br/>
            <div class="row-actions">
              <span class="inline">
                <a href="#" class="editinline">Rename</a>
              </span>                   
            </div>
          </td>
          <td><?php echo $team->shortName; ?></td>                      
          <td class="num">0</td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </form> 
