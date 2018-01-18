<?php 
// Helper functions
// 


if ( ! function_exists('template_header') ){

    function template_header( $name = '' ){

       echo '<style>body { margin:0 }</style>';
        
       echo '<div style="margin:0;text-align:center;display:flex;flex-direction:column;justify-content:center;align-items:center;height:100vh;width:100%;background:#eee;margin-bottom:">';

       $template = Theme::getTemplate();
       echo '<h1>[' . strtoupper($name) . ' Template]<h1/>';
       echo '<h2>Edit at /library/views/'.$template.'.php</h2>';
       echo '</div>';
    }
    
}