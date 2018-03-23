<?php 
Theme::partial('navbar');
?>

<div class="container no-padding">
<?php 
Theme::partial('banner');
?>
</div>


<div id="page" class="container no-padding">
        <div class="row">
          <!-- Main Column -->
          <div class="main-column col-lg-9 col-md-9 col-xs-12">
            
            <div class="panel">
              <div class="panel-body">
                <?php the_post(); the_content();?>
              </div>
            </div>
  

            <div class="panel panel-default">
              <div class="panel-header">
                <h3>Latest Updates</h3>
              </div>
              <div class="panel-body">
                <?php //Theme::view('clip-latest',array(),3);?>
              </div>
            </div>
          </div>
          <!-- Side Column -->
          <div class="side-column col-lg-3 col-md-3 col-xs-12">
            
            <div class="panel panel-default">
              <div class="panel-header">
                <h3>Live Cam</h3>
              </div>
              <div class="panel-body">
                <div class="livecam-status">
                  <h4>Livecam currently <span class="green">ON!</span></h4>
                  <a href="#">Click here to view!</a>
                  <span class="note">(Members Only)</span>
                </div>
                <div class="livecam-links">
                  <a href="#">Livecam Schedule</a>
                  <a href="#">VIP Sessions</a>
                </div>
              </div>
            </div>

            <div class="panel panel-default">
              <div class="panel-header">
                <h3>Astro Updates</h3>
              </div>
              <div class="panel-body">

              </div>
            </div>

            <div class="panel panel-default">
              <div class="panel-header">
                <h3>Astro Links</h3>
              </div>
              <div class="panel-body">
                <ul class="astro-links">
                  <li><a href="#">Clips 4 Sale Store</a></li>
                  <li><a href="#">IWantClips Store</a></li>
                  <li><a href="#">Amazon Wishlist</a></li>
                  <li><a href="#">Custom Clips</a></li>
                  <li><a href="#">Instagram Feed</a></li>
                  <li><a href="#">Bookings</a></li>
                  <li><a href="#">Tributes</a></li>
                  <li><a href="#">Contact Astro</a></li>

                </ul>
              </div>
            </div>

          </div>

        </div>
      </div>