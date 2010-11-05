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
                <?php if ( $model->leagues ) : $class = ''; ?>
                <?php foreach ( $model->leagues AS $league ) : ?>
                <?php $class = ( 'alternate' == $class ) ? '' : 'alternate'; ?>
                <tr class="<?php echo $class ?>">
                  <th scope="row" class="check-column"><input type="checkbox" value="<?php echo $league->id ?>" name="league[<?php echo $league->id ?>]" /></th>
                  <td class="num"><?php echo $league->id ?></td>
                  <td><?php echo $this->html->link($league->name, $this->url->action( 'leagues', 'show', array( 'id' => $league->id ) ) ) ?></td>
                  <td class="num"><?php echo $league->seasonCount ?></td>
                  <td>{to do}</td>
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
          <?php echo $this->form->begin( array(), 'leagues', 'add') ?>
          <form action="" method="post" class="validate">
            <?php $this->form->anti_forgery_token( 'leaguepress-leagues-add' ) ?>
            <div class="form-field form-required">
              <label for="league_name"><?php _e( 'Name', 'leaguepress' ) ?></label>
              <input type="text" name="name" id="league_name" value="" size="30" />
              <p>The name is how it appears on your site.</p>
            </div>        
            <p class="submit"><input type="submit" name="addLeague" value="<?php _e( 'Add New League', 'leaguepress' ) ?> &raquo;" class="button" /></p>
          <?php echo $this->form->end() ?>
        </div> 
      </div>
    </div>
    
  </div>

</div>