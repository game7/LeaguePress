<?php

$leagueId = $_GET['id'];
$league = $this->getLeague( $leagueId );
$seasons = $this->listSeasonsForAdmin( $leagueId )

?>
<div class="wrap">
  <h2><?php echo $league->name ?></h2>
  <ul class="subsubsub">
    <li><a href="admin.php?page=leaguepress-leagues&amp;view=league-settings&amp;leagueId=<?php echo $league->id ?>">Settings</a> | </li>
    <li><a href="admin.php?page=leaguepress-leagues&amp;view=league-seasons&amp;leagueId=<?php echo $league->id ?>">Seasons</a></li>
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