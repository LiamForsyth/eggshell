<?php
    include('../../../core/inc/api.php');
    
    $API  = new PerchAPI(1.0, 'eggshell');

    include('Eggshell_Themes.class.php');
    include('Eggshell_Theme.class.php');

    include('modes/edit.pre.php');
    include(PERCH_CORE . '/inc/top.php');
    include('modes/edit.post.php');
    echo '<script type="text/javascript"> var sassfolder = "' . $json['scss_folder'] . '";</script>';
?>
    <script type='text/javascript'>(function() {function onLoad() { $.getScript( "/perch/addons/apps/eggshell/script.js", function() {});}if ('jQuery' in window) onLoad();else {var t = setInterval(function() {if ('jQuery' in window) {onLoad();clearInterval(t);}}, 50);}})();</script>
<?php 
    include(PERCH_CORE . '/inc/btm.php');