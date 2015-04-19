<?php
    include('../../../core/inc/api.php');
    
    $API  = new PerchAPI(1.0, 'eggshell');

    include('Eggshell_Themes.class.php');
    include('Eggshell_Theme.class.php');
    
    $Lang = $API->get('Lang');
    $Perch->page_title = $Lang->get('Eggshell app');

    include('modes/edit.pre.php');
    include(PERCH_CORE . '/inc/top.php');
    include('modes/edit.post.php');
    include(PERCH_CORE . '/inc/btm.php');
