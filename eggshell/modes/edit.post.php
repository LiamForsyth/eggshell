<?php
    echo $HTML->side_panel_start();
    echo $HTML->para('Perch Theme Settings');
    echo $HTML->side_panel_end();

    echo $HTML->main_panel_start();

        include('_subnav.php');

        if ($message) echo $message; 

        $template_help_html = $Template->find_help();
        if ($template_help_html) {
            echo $HTML->heading2('Help');
            echo '<div id="template-help">' . $template_help_html . '</div>';
        }

        echo $Form->form_start();
            echo $Form->fields_from_template($Template, $details, $Themes->static_fields);
            echo $Form->submit_field('btnSubmit', 'Save Settings', $API->app_path());
        echo $Form->form_end();

    echo $HTML->main_panel_end();

