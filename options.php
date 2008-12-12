<?php $wp_rewrite->flush_rules() ?>
<div class="wrap">
  <h2>Link Control Options</h2>
  <pre><?php print_r(get_option('rewrite_rules')) ?></pre>
  <form method="post" action="options.php">
    <?php wp_nonce_field('update-options') ?>
    <input type="hidden" name="action" value="update" />
    <input type="hidden" name="page_options" value="lnkctrl_page_structure,lnkctrl_feed_base,lnkctrl_comment_base,lnkctrl_search_base,lnkctrl_paged_base" />
    <p class="submit">
      <input type="submit" name="Submit" value="<?php _e('Update Options »') ?>" />
    </p>
    <p>These options give more control over the link style of non-post items like
     pages and authors. Leaving options blank will just use the wordpress default
     structure.</p>
    <p>Page structure (must include %pagename%): <input name="lnkctrl_page_structure" id="lnkctrl_page_structure" type="text" class="code" style="width: 60%;" value="<?php echo get_option('lnkctrl_page_structure') ?>" size="50" /></p>
    <p>Feed base: <input name="lnkctrl_feed_base" id="lnkctrl_feed_base" type="text" class="code" style="width: 60%;" value="<?php echo get_option('lnkctrl_feed_base') ?>" size="50" /></p>
    <p>Comment base: <input name="lnkctrl_comment_base" id="lnkctrl_comment_base" type="text" class="code" style="width: 60%;" value="<?php echo get_option('lnkctrl_comment_base') ?>" size="50" /></p>
    <p>Search base: <input name="lnkctrl_search_base" id="lnkctrl_search_base" type="text" class="code" style="width: 60%;" value="<?php echo get_option('lnkctrl_search_base') ?>" size="50" /></p>
<!--    <p>Index pagination: <input name="lnkctrl_paged_base" id="lnkctrl_paged_base" type="text" class="code" style="width: 60%;" value="<?php echo get_option('lnkctrl_paged_base') ?>" size="50" /></p> -->
    <p class="submit">
      <input type="submit" name="Submit" value="<?php _e('Update Options »') ?>" />
    </p>
  </form>
</div>
