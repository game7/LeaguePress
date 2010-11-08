<div class="wrap nosubsub" style="margin-bottom: 1em;">
  <h2>Leagues</h2>
  <br class="clear"/>

  <div id="col-container">
  
    <div id="col-right">
      <div class="col-wrap">       
            
          <table class="widefat" summary="" title="LeagueManager">
            <thead>
            <tr>
              <th scope="col" class="num">ID</th>
              <th scope="col"><?php _e( 'League', 'leaguepress' ) ?></th>
              <th scope="col" class="num"><?php _e( 'Seasons', 'leaguepress' ) ?></th>
              <th scope="col"><?php _e( 'Current Season', 'leaguepress' ) ?></th>
            </tr>
            </thead>
            
            <tfoot>          
              <tr>
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
                <td class="num"><?php echo $league->id ?></td>
                <td><?php echo $this->html->link($league->name, $this->url->action( 'leagues', 'show', array( 'id' => $league->id ) ) ) ?></td>
                <td class="num"><?php echo $league->seasonCount ?></td>
                <td>{to do}</td>
              </tr>
              <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
          

      </div>
    </div>

    <div id="col-left">
      <div class="col-wrap">
 
        <!-- Add New League -->
        <div class="form-wrap">
          <h3><?php _e( 'Add New League', 'leaguepress' ) ?></h3>
          <?php echo $this->form->begin( array(), 'leagues', 'add') ?>
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