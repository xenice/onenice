<div id="comments" class="comments left-card">
    <?php if ( $comment->has()) : ?>
        <div class="comments-list">
            <div class="comments-count"><?=_t( 'Comments'); ?> (<?=$comment->count()?>) </div>
                <?=$comment->list()?>
                <ul class="pagination">
                    <?=$comment->paginate()?>
                </ul>
        </div>
    <?php endif; ?>
        
    <?php if ( $comment->open()): ?>
      <div class="comments-close"><?=_t( 'Leave a reply')?></div>
      <div id="respond" class="respond">
        
        <form method="post" action="<?=site_url('wp-comments-post.php');?>" id="comment_form">
            
            <?php if ($comment->register() && !$user->login()) : ?>
                <label><?=_t( 'You need <a href="javascript:;" data-toggle="modal" data-target="#login-modal">login</a> to reply.')?>
                </label>
            <?php else : ?>
                <?php if ( $user->login()) : ?>
                <div class="d-flex">
                    <label>
                      <?php printf( _t( 'Welcome <a href="%1$s">%2$s</a> back，'), $option->info['url']. '/wp-admin/profile.php', $user->nicename()); ?>
                        <a href="<?=$user->logoutUrl()?>" title="<?=_t( 'Log out of this account')?>">
                          <?=_t( 'Log out »'); ?>
                        </a>
                    </label>
                    <label class="flex-grow-1 text-right">
                      <?=$comment->cancelReplyLink() ?>
                    </label>
                </div>
                <?php else : ?>
                    <div class="d-flex">
                        <label>
                            <?=_t( 'Not logged in. I want to <a href="javascript:;" data-toggle="modal" data-target="#login-modal">login</a>')?>
                        </label>
                        <label class="flex-grow-1 text-right">
                          <?=$comment->cancelReplyLink() ?>
                        </label>
                    </div>
                    <div class="form-group d-md-flex justify-content-between">
                      <input type="text" name="author" id="author" class="form-control" size="15" placeholder="<?=_t('Username (required)')?>" value="" />
                      <input type="text" name="email" id="mail" class="form-control" size="15" placeholder="<?=_t('Email (required)')?>" value="" /> 
                      <input type="text" name="url" id="url" class="form-control" size="15" placeholder="<?=_t('URL')?>" value="" /> 
					</div>
                    
                <?php endif; ?>
                    
                <div class="form-group">
                    <textarea name="comment" id="comment" class="form-control" rows="4" tabindex="4" placeholder="<?=$comment->tip()?>" onkeydown="if(event.ctrlKey&&event.keyCode==13){document.getElementById('submit').click();return false};"></textarea>
                </div>
                <div class="form-group form-inline justify-content-end">
					<img style="vertical-align:middle"  src=<?=admin_url('admin-ajax.php')?>?action=validation onclick="this.src=this.src+'&k='+Math.random();"></img>
            	    <input type="text" name="sum" class="form-control validation" value="" size="10" placeholder="<?=_t('Validation')?>">
                    <input id="submit" type="submit" name="submit" value="<?=_t( 'Submit')?>" class="btn btn-custom" />
                </div>
                <?=$comment->fields()?>
            <?php endif; ?>
        </form>
      </div>
    <?php endif; ?>
</div>