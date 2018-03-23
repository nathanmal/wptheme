<div id="main" class="container-fluid">
            
     <section id="splash">
                    
        <div class="agreement">
          <a href="<?php echo site_url('home');?>">Enter</a>
          <a href="http://www.disney.com">Leave</a>
        </div>


        <div class="warning">
            <h2>Warning: Adult Content!</h2>
            <img src="<?php echo Theme::asset('images/site/fancyline.png')?>" />
            <p>THIS SITE CONTAINS UNCENSORED SEXUALLY EXPLICIT MATERIAL
UNSUITABLE FOR MINORS. YOU MUST BE AT LEAST 18 TO ENTER. 
YOU ARE UNDER 18 YEARS OF AGE AND YOU DO ENTER, YOU MAY
BE VIOLATING LOCAL, STATE OR FEDRAL LAW. BY ENTERING THIS
SITE YOU ARE AGREEING TO THE TERMS AND CONDITIONS.</p>
            <p>18 U.S.C. 2257 Record-Keeping Requirements Compliance Statement 
©Astrodomina 2012-2017 
All video, images, design, graphics are copyright </p>
        </div>
        
        <div id="starfield"></div>

    </section>

    <section id="content">
      <div class="container">
         <?php the_post(); the_content(); ?>
      </div>
    </section>
        
</div><!-- End #page.page-wrapper -->


