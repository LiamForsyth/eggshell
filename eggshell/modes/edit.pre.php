<?php
    require "scssphp/scss.inc.php";
    $Themes = new Eggshell_Themes($API);
    $HTML     = $API->get('HTML');
    $Form     = $API->get('Form');
    $Text     = $API->get('Text');
    $Template = $API->get('Template');
    $themes = array();
    $themes = $Themes->all();
    // Setup configurations
    $Template->set('eggshell/config.json', 'eggshell');
    $json = PerchUtil::json_safe_decode($Template->render('file'),true);
    // For first setup.
    if ($themes == false) {
        $Themes->attempt_install();
        // Get values from theme.json
        $data['themeID'] = 1;
        $data['themeDynamicFields'] = file_get_contents($_SERVER['DOCUMENT_ROOT'] . $json['scss_folder'] . 'perch/theme.json');
        $new_theme = $Themes->create($data);
    }
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
    $default = false;
    // handle creation of new blocks
    $Form->handle_empty_block_generation($Template);
    // Required Fields
    $Form->set_required_fields_from_template($Template, $details);
    if ($Form->submitted()) {
        $postvars = array('themeID');
    	$data = $Form->receive($postvars);
        if (isset($details['themeDynamicFields'])) {
            $previous_values = PerchUtil::json_safe_decode($details['themeDynamicFields'], true);
        }
     if(isset($_POST['eggshell_updateDefaults']) && $_POST['eggshell_updateDefaults'] == '1') { $default = true; }
        // Read in dynamic fields from the template
        $previous_values = false;
        $dynamic_fields = $Form->receive_from_template_fields($Template, $previous_values, $Themes, $Theme);
        $data['themeDynamicFields'] = PerchUtil::json_safe_encode($dynamic_fields);
        if($default) {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . $json['scss_folder'] . 'perch/theme.json' , $data['themeDynamicFields']);
        }
        if (is_object($Theme)) {
            $result = $Theme->update($data);
            // SCSS Compiling
            // Get the submitted variables and export to scss
            $sassvar = $Template->render($Theme);
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . $json['scss_folder'] . 'perch/perch.scss', $sassvar);
            // Get the list of files that we need to compile with the new perch.scss
            $scssfile = $json['files_to_compile'];
            foreach ($scssfile as $file_key => $file) {
                $cssfile = $_SERVER['DOCUMENT_ROOT'] . $json['css_folder'] . $file['compiled'];
                $compile =  $scss->compile('@import "' . $file['source'] . '"');
                file_put_contents($cssfile, $compile);
            }
        }
        // Messages
        // Default settings can be updated any time so we set this message first
        if($default){ 
            $message = $HTML->success_message('Default settings updated!');
        } else{
            // Message depending on if anything has been updated or not
            if ($result) {
                $message = $HTML->success_message('Your settings have been updated!');  
            }else{
                $message = $HTML->warning_message('You are already up to date!');
            }
        }
        if (is_object($Theme)) {
            $details = $Theme->to_array();
        }else{
            $details = array();
        }
    }   