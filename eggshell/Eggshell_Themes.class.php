<?php
class Eggshell_Themes extends PerchAPI_Factory
{
    protected $table     = 'eggshell_themes';
	protected $pk        = 'themeID';
	protected $singular_classname = 'Eggshell_Theme';
	
	protected $default_sort_column = 'themeID';
	
	public $static_fields   = array('themeID', 'themeDynamicFields');	
	
}