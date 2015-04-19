# Eggshell for Perch
## Theme Applicator for the Perch CMS

In the search for a way to create customisable themes for the Perch CMS comes this app created to allow for user generated variables which can then be used in your SCSS files, so we created 'Eggshell', a Perch App to allow you to create themes/skins for Perch using variables editable within the Perch admin area.

One of the great things about Perch is how you control the level of involvement within your development setup it is. We wanted to carry this over and make sure Perch provides you with what you need and not the other way around. We compile all the variables you want to be controllable into a SCSS file which you include into your own SCSS files. You can then work and compile using your favourite method (Codekit, Grunt, etc.). Perch will also be able to compile specified SCSS files to allow these variables to be dynamic allowing changes during production. 

## Requirements for SCSS compiler (SCSSPHP)
- SCSS syntax
- Support for SCSS 3.2.12 and below

## Release Notes

#### Eggshell 0.1 (Developer Preview?) + Compiling Errors
Initial Release and still polishing and testing things. 

Still to work out a way to proof things before compiling, however these are only shown while developing things as it may fall into one of these situations:
- If you have added a new field to the `settings.html` template, either make sure you refresh the admin area before attempting to save. 
- If you have a field that has an empty value when saving (compiling). You could make this field required or have a `<perch:if>` fallback.
- You are attempting to compile anything that is not SCSS or above version 3.2.12. Check mixins that are also being compiled are not causing hiccups either. Will try to keep track on any compilers that update their supported versions.

## Setup
1. Install the `Theme` app inside `perch/addons/apps`. 
4. Setup your `settings.html` and `config.json file`. See next two sections.
5. Within Perch Admin, select the Theme app. 
6. You will be presented with the available theme variables.
7. Save changes to update these variables as well as compile SCSS files.

### Stylesheet Setup
1. Include `@import('perch/perch');` in your stylesheet.
2. Link your compiled stylesheet into, your HTML the way you normally would. Example > `<link href="/lib/css/main.css" rel="stylesheet" />` 

### Theme Settings
There are no required Perch fields for your theme, you can make the variables you need to and use any of the Perch field types to achieve this. In the example we use the color field type.
```
$bgcolor: <perch:theme type="color" id="bgcolor" label="Background" />;
```
Your template will be compiled into a scss file so make sure the markup in this template reflects that.

### Configuration
Within your templates for `theme` include your config.json which will contain the settings for your Theme settings.

```
"scss_folder": "/lib/scss/"
```
Set the folder which contains your scss files. This folder only needs to be 'readable' within here add a writeable folder named 'perch'.

```
"css_folder": "/lib/css/"
```
Set the folder you wish to compile files to. This folder will need to be writeable.

```
"files_to_compile": [
		{ "source":"main.scss","compiled":"main.css" },
		{ "source":"blog.scss","compiled":"blog.css" }
	]
```
Enter the file names of the source and the destination you would like compilable files to have. Any file not noted will not be compiled by Perch.

```
"css_format": "scss_formatter_compressed"
```
Set the formatting of the compiled css, options are 'scss_formatter', 'scss_formatter_nested' and 'scss_formatter_compressed'.

### Thanks

- The amazing compiler we use which you best check out http://leafo.net/scssphp/ 
- And of course the amazing folk at http://grabaperch.com
