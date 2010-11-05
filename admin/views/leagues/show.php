
<div class="wrap">
  
  <!-- Breadcrumb -->
  <p class="leaguepress_breadcrumb">
    <a href="admin.php?page=leaguepress"><?php _e( 'LeaguePress', 'leaguepress' ) ?></a>
     &raquo; <a href="admin.php?page=leaguepress-leagues">Leagues</a>
     &raquo; <a href="admin.php?page=leaguepress-leagues&amp;view=detail&amp;leagueId=<?php echo $model->league->id ?>"><?php echo $model->league->name ?></a>
     <?php if (isset($model->season)) echo '&raquo; ' . $model->season->name ?>
  </p>
  
  <!-- Title -->
  <h2><?php echo $model->league->name ?><?php if (isset($model->season)) echo ' :: ' . $model->season->name ?></h2>
  
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
        
        <div class="stuffbox">
          <h3>Season</h3>
          <div class="inside">
            <form action="admin.php" method="get" style="display: inline">
<?php if(isset($model->season)) : ?>
              <select size="1" name="seasonId" id="seasonId">
                <?php foreach ( $model->seasons AS $s ) : ?>
                <option value="<?php echo $s->id ?>"<?php if($model->season->id == $s->id) echo ' selected'; ?>><?php echo $s->name ?></option>
                <?php endforeach ?> 
              </select>
              <input type="hidden" name="page" value="leaguepress-leagues"/>
              <input type="hidden" name="view" value="detail"/>    
              <input type="hidden" name="leagueId" value="<?php echo $model->league->id ?>"/>
              <input type="submit" value="Change" class="button"/>
<?php endif ?>
              <a href="admin.php?page=leaguepress-leagues&amp;view=seasons&amp;leagueId=<?php echo $model->league->id ?>">Manage Seasons</a>      
            </form>
          </div>
        </div>

 <?php if(isset($model->season)) : ?>       
        <div class="stuffbox">
          <h3>Teams</h3>
          <div class="inside">
           <div class="submitbox">
 
            <?php include_once(dirname(__FILE__) . '\includes\teams-list.php') ?>
           
           </div>
          </div>
        </div>
<?php endif ?>
       
        <div class="stuffbox">
          <h3>Settings</h3>
          <div class="inside">
           <div class="submitbox">
           
           </div>
          </div>
        </div>
        
      </div>
    </div>
  </div>

</div>