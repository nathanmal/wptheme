<!-- WPTheme default screen -->
<div class="wpt-blog">
  <h1>WP Theme</h1>
  <p>Starter theme for Wordpress</p>
  <?php 

  $template = WPTheme\Theme::template();

  if( ! empty($template) )
  {
    echo '<br/><h5>This is the <strong>' . $template . '</strong> template</h5>';
    echo '<em>/views/' . $template.'.php</em>';
  }

  if( $s = sanitize_text_field(element($_GET, 's')) )
  {
    echo '<div class="search-term"><h4>Results for "<em>' . $s . '</em>"</h4></div>';
  }



  echo '<div class="posts">';

  if ( have_posts() ) : 
    while ( have_posts() ) : the_post(); 
      wpt_partial('wptheme/preview');
    endwhile; 
  endif;

  echo '</div>';
  ?>
  <hr/>
</div>
