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

  <div class="row wpt-styles">
    <div class="col-lg-12">
        <h3>Style Guide</h3>
    </div>
    <div class="col-lg-4">
      <div class="wpt-styles-panel">
        <strong>Headings</strong>
        <h1>Heading 1</h1>
        <h2>Heading 2</h2>
        <h3>Heading 3</h3>
        <h4>Heading 4</h4>
        <h5>Heading 5</h5>
        <h6>Heading 6</h6>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="wpt-styles-panel">
        <strong>Paragraph Text</strong>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus vel finibus orci, et tincidunt velit. Quisque eget urna in tellus ultricies pharetra. Morbi id mi in nisl elementum efficitur dictum non nibh.</p>
        <p>Fusce pellentesque magna neque, quis pretium orci varius non.</p>
        <hr/>
        <strong>This is &lt;strong&gt; text</strong>
        <hr/>
        <em>This is &lt;em&gt; text</em>
        <hr/>
        <small>This is &lt;small&gt; text</small>
        <hr/>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="wpt-styles-panel">
        <strong>Blockquote</strong>
        <blockquote>This is a blockquote tag. Somebody probably said this once.</blockquote>
        <hr/>
        
      </div>
    </div>

  </div>


</div>


