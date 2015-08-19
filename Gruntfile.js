module.exports = function(grunt) {
	'use strict';
	grunt.initConfig({
		chmod: {
			options: {
				mode: '777'
			},
			scss_folder: {
				src: ['./lib/scss']
			},
			css_folder: {
				src: ['./lib/css']
			},
			eggshell_files: {
				src: ['./lib/scss/eggshell_variables/*']
			},
			scss_files: {
				src: ['./lib/scss/*.scss']
			}
		},
	    copy: {
		  main: {
		  	expand: true,
		    cwd: 'eggshell/templates/',
		    src: ['**'],
		    dest: 'perch/templates/'
		  },
		},
		shell: {
			move: {
				command: 'mv ./eggshell ./perch/addons/apps/'
	    	}
	    },
	    'string-replace': {
		  inline: {
		    files: {
		      './perch/config/apps.php': './perch/config/apps.php',
		    },
		    options: {
		      replacements: [
		        // place files inline example
		        {
		          pattern: '\'content\',',
		          replacement: '\'content\',\'eggshell\','
		        }
		      ]
		    }
		  }
		}
	});
	grunt.loadNpmTasks('grunt-chmod');
	grunt.loadNpmTasks('grunt-string-replace');
	grunt.loadNpmTasks('grunt-shell');
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.registerTask('default', [
		'chmod',
		'copy',
		'shell:move',
		'string-replace',

	]);
};