<!-- WPTheme default screen -->
<div class="wpt-intro">
  <h1>WP Theme</h1>
  <p>Starter theme for Wordpress</p>
  <?php 
  $template = WPTheme\Theme::template();

  if( ! empty($template) )
  {
    echo '<br/><h5>This is the <strong>' . $template . '</strong> template</h5>';
    echo '<em>/views/' . $template.'.php</em>';
  }
  ?>
  <hr/>
</div>


