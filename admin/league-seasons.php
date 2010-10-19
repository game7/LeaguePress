<?php

// Authorization Check
if ( !current_user_can( 'manage_leagues' ) ) : 
  
  echo '<p style="text-align: center;">'.__("You do not have sufficient permissions to access this page.").'</p>';

else :
  
  // Add New Season
  if ( isset($_POST['addSeason']) ) {
  
    check_admin_referer('leaguepress-league-seasons');
    $startsOn = $_POST['season_starts_on_year'].'-'.$_POST['season_starts_on_month'].'-'.$_POST['season_starts_on_day'];
    $this->createNewSeasonForLeague( $_POST["leagueId"], $_POST["season_name"], $startsOn );
    
  }
  
  $leagueId = $_GET['leagueId'];
  $league = $this->getLeague($leagueId);
  $seasons = $this->listSeasonsForAdmin($leagueId);

?>

<div class="wrap nosubsub">

  <!-- Breadcrumb -->
  <p class="leaguepress_breadcrumb">
    <a href="admin.php?page=leaguepress"><?php _e( 'LeaguePress', 'leaguepress' ) ?></a>
     &raquo; <a href="admin.php?page=leaguepress-leagues">Leagues</a>
     &raquo; <a href="admin.php?page=leaguepress&amp;view=league&amp;leagueId=<?php echo $league->id ?>"><?php echo $league->name ?></a>
     &raquo; <?php _e( 'Seasons', 'leaguepress' ) ?>
  </p>
  
  <!-- Title -->
  <h2><?php echo $league->name ?> Seasons</h2>
  
  
  <div id="col-container">
  

    <div id="col-right">
      <div class="col-wrap">
        <div class="form-wrap">   
          <form id="seasons-filter" action="" method="post">
            <?php wp_nonce_field( 'seasons-bulk' ) ?>  
            
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
                <th scope="col"><?php _e( 'Starts On', 'leaguePress' ) ?></th>
                <th scope="col" class="num"><?php _e( 'Teams', 'leaguepress' ) ?></th>
                <th scope="col" class="num"><?php _e( 'Games', 'leaguepress' ) ?></th>
              </tr>
              </thead>
              <tfoot>
              <tr>
                <th scope="col" class="check-column"><input type="checkbox" onclick="Leaguemanager.checkAll(document.getElementById('seaons-filter'));" /></th>
                <th scope="col"><?php _e( 'Name', 'leaguePress' ) ?></th>
                <th scope="col"><?php _e( 'Starts On', 'leaguePress' ) ?></th>
                <th scope="col" class="num"><?php _e( 'Teams', 'leaguepress' ) ?></th>
                <th scope="col" class="num"><?php _e( 'Games', 'leaguepress' ) ?></th>
              </tr>
              </tfoot>              
              <tbody id="the-list" class="list">
                <?php foreach( $seasons AS $season ) : $class = ( 'alternate' == $class ) ? '' : 'alternate' ?>
                <tr class="<?php echo $class ?>">
                  <th scope="row" class="check-column"><input type="checkbox" value="<?php echo $key ?>" name="del_season[<?php echo $key ?>]" /></th>
                  <td>
                    <?php echo $season->name; ?><br/>
                    <div class="row-actions">
                      <span class="inline">
                        <a href="#" class="editinline">Rename</a> | 
                      </span> 
                      <span class="inline">
                        <a href="#" class="editinline">Change Dates</a>
                      </span>                    
                    </div>
                  </td>
                  <td><?php echo date("d M y", strtotime($season->startsOn)) ?></td>
                  <td class="num">0</td>
                  <td class="num">0</td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </form>
        </div>
      </div>
    </div> 
      
     
    <div id="col-left">
      <div class="col-wrap">
        <div class="form-wrap">
          <h3>
            <?php _e( 'Add new Season', 'leaguepress' ) ?>
          </h3>    
          <form action="" method="post" class="validate">
            <?php wp_nonce_field( 'leaguepress-league-seasons' ) ?> 
            <div class="form-field form-required">
              <label for="season_name"><?php _e( 'Name', 'leaguepress' ) ?></label>
              <input type="text" name="season_name" id="season_name" size="20" />
              <p>The name is how it will appear on your site.</p>
            </div> 
            <div class="form-field form-required">
              <label for="season_starts_on_day"><?php _e( 'Starts On', 'leaguepress' ) ?></label>
              <?php echo $this->renderDateSelector( "season_starts_on", null, null, null ) ?>
              <p>The date that this season will begin.  Primarily used for sorting seasons when displayed in a list</p>
            </div>       
       
            <input type="hidden" name="leagueId" value="<?php echo $leagueId ?>" />
            <p class="submit"><input type="submit" name="addSeason" class="button" value="<?php _e( 'Add New Season', 'leaguePress' ); ?>" /></p>
          </form> 

        </div> 
      </div>
    </div>
    
   
  </div>

</div>

<?php endif; ?>
