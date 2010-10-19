<?php

$leagueId = $_GET['id'];
$league = $this->getLeague( $leagueId );
$seasons = $this->listSeasonsForAdmin( $leagueId );
$teams = $this->listTeamsForSeasonForAdmin( $seasons[0]->id );

?>
<div class="wrap">
  <h2><?php echo $league->name ?></h2>
  <ul class="subsubsub">
    <li><a href="admin.php?page=leaguepress-leagues&amp;view=settings&amp;leagueId=<?php echo $league->id ?>">Settings</a> | </li>
    <li><a href="admin.php?page=leaguepress-leagues&amp;view=seasons&amp;leagueId=<?php echo $league->id ?>">Seasons</a></li>
  </ul>  
  <div id="poststuff" class="metabox-holder has-right-sidebar">
    <div id="side-info-column" class="inner-sidebar">
      <div >
        <div class="stuffbox">
          <h3>Season</h3>
          <div class="inside">
            <form action="admin.php" method="get" style="display: inline">
              <select size="1" name="season" id="season">
                <?php foreach ( $seasons AS $season ) : ?>
                <option value="<?php echo $season->id ?>"><?php echo $season->name ?></option>
                <?php endforeach ?> 
              </select>    
              <input type="submit" value="Show" class="button"/>       
            </form>
          </div>
        </div>
      </div>
    </div>
    <div id="post-body">
      <div id="post-body-content">
        
        <div class="stuffbox">
          <h3>Teams</h3>
          <div class="inside">
           <div class="submitbox">
               
              <form id="teams-filter" action="" method="post">
                <?php wp_nonce_field( 'teams-bulk' ) ?>  
                
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
              
              <div class="form-wrap">
                <h3>
                  <?php _e( 'Add new Team', 'leaguepress' ) ?>
                </h3>    
                <form action="" method="post" class="validate">
                  <?php wp_nonce_field( 'leaguepress-league-teams' ) ?> 
                  <div class="form-field form-required">
                    <label for="team_name"><?php _e( 'Name', 'leaguepress' ) ?></label>
                    <input type="text" name="team_name" id="team_name" size="20" />
                    <p>The name is how it will appear on your site.</p>
                  </div> 
                  <div class="form-field form-required">
                    <label for="team_short_name"><?php _e( 'Short Name', 'leaguepress' ) ?></label>
                    <input type="text" name="team_short_name" id="team_short_name" size="20" />
                    <p>The name that will be used in smaller, more-compact locations.</p>
                  </div>                   
                  <input type="hidden" name="seasonId" value="<?php echo $leagueId ?>" />
                  <p class="submit"><input type="submit" name="addTeam" class="button" value="<?php _e( 'Add New Team', 'leaguePress' ); ?>" /></p>
                </form> 
              
              </div>                    
           
           </div>
          </div>
        </div>
        
        <div class="stuffbox">
          <h3>Games</h3>
          <div class="inside">
           <div class="submitbox">
           
           </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>