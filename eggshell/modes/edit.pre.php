<?php
    require "scssphp/scss.inc.php";
    
    $Themes = new Eggshell_Themes($API);
    
    $HTML     = $API->get('HTML');
    $Form     = $API->get('Form');
    $Text     = $API->get('Text');
    $Template = $API->get('Template');

    $themes = array();
    
    $themes = $Themes->all();

    // For first setup.
    if ($themes == false) {
        $Themes->attempt_install();
        
        // Get values from theme.json
        $Template->set('eggshell/theme.json', 'eggshell');
        $data['themeID'] = 1;
        $data['themeDynamicFields'] = $Template->render('file');
        $new_theme = $Themes->create($data);
    }

    // Setup configurations
    $Template->set('eggshell/config.json', 'eggshell');
    $json = PerchUtil::json_safe_decode($Template->render('file'),true);

    // Setup SCSS Compiler
    $scss = new scssc();
    $scss->setImportPaths($_SERVER['DOCUMENT_ROOT'] . $json['scss_folder']);
    $scss->setFormatter($json['css_format']);

    // Load master template
    $Template->set('eggshell/settings.html', 'eggshell');

    $result = false;
    $message = false;
    
    // We only use one item so lets edit it
    $themeID = (int) 1;    
    $Theme = $Themes->find($themeID, true);
    $details = $Theme->to_array();

    // handle creation of new blocks
    $Form->handle_empty_block_generation($Template);
   
    if ($Form->submitted()) {
        $postvars = array('themeID');
    	$data = $Form->receive($postvars);

        // Read in dynamic fields from the template
        $previous_values = false;

        if (isset($details['themeDynamicFields'])) {
            $previous_values = PerchUtil::json_safe_decode($details['themeDynamicFields'], true);
        }
        
        $dynamic_fields = $Form->receive_from_template_fields($Template, $previous_values, $Themes, $Theme);
        $data['themeDynamicFields'] = PerchUtil::json_safe_encode($dynamic_fields);

        $result = $Theme->update($data);
        
        // SCSS Compiling
        // Get the submitted variables and export to scss
        $sassvar = $Template->render($Theme);
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . $json['scss_folder'] . 'perch/perch.scss', $sassvar);
        // Get the list of files that we need to compile with the new perch.scss
        $scssfile = $json['files_to_compile'];
        foreach ($scssfile as $file_key => $file) {
            $cssfile = $_SERVER['DOCUMENT_ROOT'] . $json['css_folder'] . $file[compiled];
            $compile =  $scss->compile('@import "' . $file[source] . '"');
            file_put_contents($cssfile, $compile);
        }

        // Let them know its updated
        $message = $HTML->success_message('Your settings have been successfully updated.');  
        
        if (is_object($Theme)) {
            $details = $Theme->to_array();
        }else{
            $details = array();
        }
        
    }   