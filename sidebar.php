<div id="sidebar" class="sidebar" role="complementary">

<?php if ( is_active_sidebar( 'main' ) ) : ?>

    <?php dynamic_sidebar( 'main' ); ?>

<?php else : ?>

    <?php
        /*
         * This content shows up if there are no widgets defined in the backend.
        */
    ?>

    <div class="no-widgets">
        <p><?php _e( 'This is a widget ready area. Add some and they will appear here.', THEME_DOMAIN );  ?></p>
    </div>

<?php endif; ?>

</div>