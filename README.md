# Eggshell for Perch
## Theme Applicator for the Perch CMS

In the search for a way to create customisable themes for the Perch CMS comes this app created to allow for user generated variables which can then be used in your SCSS files, so we created 'Eggshell', a Perch App to allow you to create themes/skins for Perch using variables editable within the Perch admin area.

One of the great things about Perch is how you control the level of involvement within your development setup it is. We wanted to carry this over and make sure Perch provides you with what you need and not the other way around. We compile all the variables you want to be controllable into a SCSS file which you include into your own SCSS files. You can then work and compile using your favourite method (Codekit, Grunt, etc.). Perch will also be able to compile specified SCSS files to allow these variables to be dynamic allowing changes during production. 

## Requirements for SCSS compiler (SCSSPHP)
- SCSS syntax
- Support for SCSS 3.2.12 and below

## Installation

Once you have downloaded or cloned this repository, make sure you have moved these contents to your development folder along side your `Perch` Folder. 

If you don't wish to use the Grunt Task Runner to setup files and folders then please skip to the **Manual Installation** section. 

1. Make sure you have Node installed on your system - instructions can be found on their [official website](http://nodejs.org)
2. Install Grunt - instructions can be found on their [official website](http://gruntjs.com/getting-started)
3. Within your project directory run: ```npm install```
4. Once this has successfully completed run: ```grunt``` This will run several task including adding the app to Perch. 
5. Now login or setup Perch and you will see the new app 'Theme' is selectable.

## Manual Installation
1. Move the `eggshell` folder to `perch/addons/apps` 
2. Add `eggshell` to the app list array within `perch/config/apps.php`. For more information on installing Perch Apps visit the [official documentation](https://docs.grabaperch.com/docs/installing-perch/installing-apps/)
3. Copy the `eggshell/templates/eggshell` folder to the `perch/templates` folder.
4. We have several files that require to have writable permissions so that Perch can write variables as well as compile scss files. Make sure that `lib/css`, `lib/scss` and `lib/scss/perch/` folders and contents are writable.

## Usage
Provided is an example set of scss and css files to showcase the capabilities. Each section has the path of an example file

#### Stylesheet Setup 
Example File:
```
lib/scss/main.scss
```

Inside your `scss` files where you want access to variables set in Perch include `@import('eggshell_variables/perch');` at the beginning. You can include this in as many scss files as you require and the example file included can be replaced if you wish. Make sure that this `eggshell_variables` folder is alongside your scss files.

#### Editable Variables 
File:
```
perch/templates/eggshell/settings.html
```

This is a typical Perch Template. Here we use the Perch Tag structure with the tag name `perch:eggshell`. Instead of html code however we use scss. For example:
```
$variable: <perch:eggshell type="color" id="color" label="Color" />;
```
This example file can be edited however is required.

#### Configurations
File: 
```
perch/templates/eggshell/config.json
```

This file contains configuration for how Perch will compile scss files. This is important to make sure the files that use variables from Perch are compiled to the right directory.

Formatting of the compiled css can be set to 'scss_formatter', 'scss_formatter_nested' and 'scss_formatter_compressed'.

This example file can be edited however is required.

#### Default Variables
Example File:
```
lib/scss/eggshell_variables/theme.json
```

These are the variables that Perch will read when you first load the theme variables. They can also be the variables that you reset to within the admin panel. You can write these manually, or you can save them via Perch. To save them, check the `Developer Tools` option inside Perch's settings panel. This will allow a checkbox option to `Update Default Variables` when you next save.

## Possibile Errors

If you receive an error while saving via Perch this may be related to the actual scss or permissions.

```
Fatal error: Uncaught exception 'Exception' with message
``` 

This error will be followed by a compiling error, this may be that you have not included `@import('eggshell_variables/perch');` correctly, or you are missing a variable in your `settings.html` template. Also make sure you are using scss syntax and SCSS 3.2.12 or below as part of the compiler requirements.

```
Warning: file_put_contents
```
This error will note a path to a file it has not been able to save to. Make sure that the css files are writable if they are not already. Assuming you have compiled the scss files via Perch this should not be an issue. If you have manually compiled these files the css files my not be writable.

## Release Notes

#### Eggshell 0.3
- Updated some paths and fixed a few js errors.
- Updated readme
- Included a gruntfile for easy install

#### Eggshell 0.2: Developer Preview
- Can now save your theme.json for sharing. This file is now moved to the same folder as the `perch/perch.scss`. This option is available if you select this checkbox in the Admin settings.
- You can reset each variable to the default (`theme.json`) either one by one or all in one (has a confirm alert).
- Won't compile if no changes are made. But still can update the default variables.
- Updated the default template files to show off some variables for Google fonts and dividers. 

#### Eggshell 0.1: Developer Preview
Initial Release and still polishing and testing things. 

Still to work out a way to proof things before compiling, however these are only shown while developing things as it may fall into one of these situations:
- If you have added a new field to the `settings.html` template, either make sure you refresh the admin area before attempting to save. 
- If you have a field that has an empty value when saving (compiling). You could make this field required or have a `<perch:if>` fallback.
- You are attempting to compile anything that is not SCSS or above version 3.2.12. Check mixins that are also being compiled are not causing hiccups either. Will try to keep track on any compilers that update their supported versions.

### Thanks

- The amazing compiler we use which you best check out http://leafo.net/scssphp/ 
- And of course the amazing folk at http://grabaperch.com
