<?php

$countOfTeams = 8;

// Authorization Check
if ( !current_user_can( 'manage_leagues' ) ) : 
  
  echo '<p style="text-align: center;">'.__("You do not have sufficient permissions to access this page.").'</p>';

else :
  
  $leagueId = $_GET['leagueId'];
  $league = $this->getLeague( $leagueId );
  
  $seasonId = $_GET['seasonId'];
  $season = $this->getSeason( $seasonId );
  
  // Add New Teams
  if ( isset($_POST['addTeams']) ) {
  
    check_admin_referer('leaguepress-league-teams-add');
    
    for( $i = 0; $i < $countOfTeams; $i++ ) {
      $name = $_POST['name'.$i];
      if (isset($name) && $name != '') {
        $this->createTeamForSeason( $seasonId, $name, $_POST['shortName'.$i], $_POST['showInStandings'.$i] );       
      }            
    }
  }
  
endif
  
?>
<div class="wrap">
  
  <!-- Breadcrumb -->
  <p class="leaguepress_breadcrumb">
    <a href="admin.php?page=leaguepress"><?php _e( 'LeaguePress', 'leaguepress' ) ?></a>
     &raquo; <a href="admin.php?page=leaguepress-leagues">Leagues</a>
     &raquo; <a href="admin.php?page=leaguepress-leagues&amp;view=detail&amp;leagueId=<?php echo $league->id ?>"><?php echo $league->name ?></a>
     &raquo; <a href="admin.php?page=leaguepress-leagues&amp;view=detail&amp;leagueId=<?php echo $league->id ?>&amp;seasonId=<?php echo $season->id ?>"><?php echo $season->name ?></a>
  </p>
  
  <!-- Title -->
  <h2>Add Teams</h2>
  
  <div id="poststuff" class="metabox-holder has-right-sidebar">
    <div id="side-info-column" class="inner-sidebar">
      <div >
        <div class="stuffbox">
          <h3>Help</h3>
          <div class="inside">

          </div>
        </div>
      </div>
    </div>
    <div id="post-body">
      <div id="post-body-content">
        
        <form action="" method="post">
        <?php wp_nonce_field('leaguepress-league-teams-add') ?>
        <!-- Table -->
        <table class="widefat">
          <thead>
            <tr>
              <th scope="col"><?php _e( 'Name', 'leaguePress' ) ?></th>
              <th scope="col"><?php _e( 'Short Name', 'leaguePress' ) ?></th>
              <th scope="col" class="num"><?php _e( 'Show in Standings', 'leaguepress' ) ?></th>
            </tr>
          </thead>
          <tbody id="the-list" class="list">
            <?php for( $i = 0; $i < $countOfTeams; $i++ ) : $class = ( 'alternate' == $class ) ? '' : 'alternate' ?>
            <tr class="<?php echo $class ?>">
              <td><input name="name<?php echo $i ?>" id="name<?php echo $i ?>" size="30"/></td>                      
              <td><input name="short_name<?php echo $i ?>" id="short_name<?php echo $i ?>" size="20" /></td>
              <td class="num"><input type="checkbox" name="show_in_standings<?php echo $i ?>" /></td>              
            </tr>
            <?php endfor; ?>
          </tbody>
        </table>

        <!--
        <input type="hidden" name="leagueId" value="<?php echo $leagueId ?>" />
        <input type="hidden" name="seasonId" value="<?php echo $seasonId ?>" />   
        -->     
        <p class="submit"><input type="submit" name="addTeams" class="button" value="<?php _e( 'Add New Teams', 'leaguePress' ); ?>" /></p>
        </form>        
      </div>
    </div>
  </div>

</div>