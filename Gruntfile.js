module.exports = function (grunt) {
	'use strict';

	grunt.initConfig({

		// Setting folder templates.
		dirs: {
			css: 'scss'
		},

		// Compile all .scss files.
		sass: {
			compile: {
				options: {
					sourcemap: 'none',
					loadPath : require('node-bourbon').includePaths
				},
				files  : [{
					expand: true,
					cwd   : '<%= dirs.css %>/',
					src   : ['*.scss'],
					dest  : './',
					ext   : '.css'
				}]
			}
		},

		// Minify all .css files.
		cssmin: {
			minify: {
				expand: true,
				cwd   : './',
				src   : [
					'*.css',
					'!*.min.css'
				],
				dest  : './',
				ext   : '.min.css'
			}
		},

		babel: {
			options: {
				sourceMap: false,
				presets: ['es2015']
			},
			dist: {
				files: {
					'js/src/huh-wp-docs-compiled.js': 'js/src/huh-wp-docs.js'
				}
			}
		},

		uglify: {
			target : {
				files: {
					'js/huh-wp-docs.min.js': ['js/src/huh-wp-docs-compiled.js'],
					'js/marked.min.js'     : ['js/src/marked.js']
				},
			},
			options: {
				sourceMap: false,
				mangle   : {
					except: ['jQuery', '_.']
				}
			}
		},

		// Watch changes for assets.
		watch: {
			css: {
				files: ['<%= dirs.css %>/*.scss'],
				tasks: ['sass', 'cssmin']
			}
		}
	});

	// Load NPM tasks to be used here
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-babel');

	// Register tasks
	grunt.registerTask('default', [
		'css',
		'js'
	]);

	grunt.registerTask('css', [
		'sass',
		'cssmin'
	]);

	grunt.registerTask('js', [
		'babel',
		'uglify'
	]);
};
