<!-- WPTheme default welcome screen -->
<div class="container">
  <div class="row">
    <div class="col-lg-12">
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
        <br/><br/>
        <hr/>
        <?php WPTheme\Theme::content(); ?>
        <hr/>
      </div>
    </div>
  </div>
</div>


