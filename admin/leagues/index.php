<?php
if ( isset($_POST['addLeague']) ) {
  check_admin_referer('leaguepress-leagues-add');
  $this->createNewLeague( $_POST['league_name']);
  $this->printMessage();
} elseif ( isset($_POST['doaction']) && $_POST['action'] == 'delete' ) {
  check_admin_referer('leaguepress-leagues-multi');
  foreach( $_POST['league'] as $leagueId )
    $this->deleteLeague($leagueId);
}

?>
<div class="wrap nosubsub" style="margin-bottom: 1em;">
  <h2>Leagues</h2>
  <br class="clear"/>
  
  <div id="col-container">
  
    <div id="col-right">
      <div class="col-wrap">
        <div class="form-wrap">
          <form id="leagues-filter" method="post" action="">
            <?php wp_nonce_field( 'leaguepress-leagues-multi' ) ?>
            
            <div class="tablenav" style="margin-bottom: 0.1em;">
              <!-- Bulk Actions -->
              <select name="action" size="1">
                <option value="-1" selected="selected"><?php _e('Bulk Actions') ?></option>
                <option value="delete"><?php _e('Delete')?></option>
              </select>
              <input type="submit" value='<?php _e("Apply"); ?>' name="doaction" id="doaction" class="button-secondary action" />
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
              
              <tbody id="the-list">
                <?php if ( $leagues = $this->listLeaguesForAdmin() ) : $class = ''; ?>
                <?php foreach ( $leagues AS $league ) : ?>
                <?php $class = ( 'alternate' == $class ) ? '' : 'alternate'; ?>
                <tr class="<?php echo $class ?>">
                  <th scope="row" class="check-column"><input type="checkbox" value="<?php echo $league->id ?>" name="league[<?php echo $league->id ?>]" /></th>
                  <td class="num"><?php echo $league->id ?></td>
                  <td><a href="admin.php?page=leaguepress-leagues&amp;view=detail&amp;leagueId=<?php echo $league->id ?>"><?php echo $league->name ?></a></td>
                  <td class="num"><?php echo $league->seasonCount ?></td>
                  <td>Winter 2010</td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
            
          </form>
        </div>
      </div>
    </div>
    
    <div id="col-left">
      <div class="col-wrap">
 
        <!-- Add New League -->
        <div class="form-wrap">
          <h3><?php _e( 'Add New League', 'leaguepress' ) ?></h3>
          <form action="" method="post" class="validate">
            <?php wp_nonce_field( 'leaguepress-leagues-add' ) ?>
            <div class="form-field form-required">
              <label for="league_name"><?php _e( 'Name', 'leaguepress' ) ?></label>
              <input type="text" name="league_name" id="league_name" value="" size="30" />
              <p>The name is how it appears on your site.</p>
            </div>        
            <p class="submit"><input type="submit" name="addLeague" value="<?php _e( 'Add New League', 'leaguepress' ) ?> &raquo;" class="button" /></p>
          </form> 
        </div> 
      </div>
    </div>
    
  </div>

</div>