module.exports = function(grunt){

	require('load-grunt-tasks')(grunt);

	grunt.initConfig({

		jshint: {
			all: ['web/dev/js/*.js', '!web/js/main.min.js']
		},

		concat: {
			site: {
				src: [
					'web/dev/js/vendor/jquery-1.11.2.min.js', 
					'web/bundles/fosjsrouting/js/router.js',
					'web/dev/js/fos_js_routes.js', 
					'web/dev/js/vendor/bxslider/jquery.bxslider.min.js',
					'web/dev/js/vendor/jquery.magnific-popup.min.js', 
					'web/dev/js/main.js'
				],
				dest: 'web/prod/js/main.min.js'
			},
            admin: {
                src: [
                    'web/dev/js/vendor/jquery-1.11.2.min.js', 
                    'web/dev/js/vendor/bootstrap/bootstrap.min.js', 
                    'web/dev/js/vendor/bootstrap/ie10-viewport-bug-workaround.js',
                ],
                dest: 'web/prod/js/admin.min.js'                
            }	
		},

		cssmin: {
			target: {
			    files: [{
        			expand: true,
        			cwd: 'web/dev/css/',
        			src: ['*.css', '!*.min.css'],
        			dest: 'web/prod/css/',
        			ext: '.min.css'
			    }]
			}
		},

		uglify: {
			dist: {
				files: {
					'web/prod/js/main.min.js': ['web/prod/js/main.min.js'],
                    'web/prod/js/admin.min.js': ['web/prod/js/admin.min.js']
				}
			}
		},

		imagemin: {                          // Task 
		    dynamic: {                         // Another target 
		        files: [{
    	            expand: true,                  // Enable dynamic expansion 
    		        cwd: 'web/dev/img/',                   // Src matches are relative to this path 
    		        src: ['**/*.{png,jpg}'],   // Actual patterns to match 
    		        dest: 'web/prod/img/'                  // Destination path prefix 
		        }]
		    }
		},

        copy: {
          main: {
            files: [
              // includes files within path
              // {expand: true, src: ['path/*'], dest: 'dest/', filter: 'isFile'},
              // includes files within path and its sub-directories
              // {expand: true, src: ['path/**'], dest: 'dest/'},
              // makes all src relative to cwd
              // {expand: true, cwd: 'path/', src: ['**'], dest: 'dest/'},
              // flattens results to a single level
              // {expand: true, flatten: true, src: ['path/**'], dest: 'dest/', filter: 'isFile'},
              {expand: true, cwd: 'web/dev/', src: ['fonts/**'], dest: 'web/prod/'},
            ],
          },
        },

		phpcs: {
		    application: {
		        src: ['src/AppBundle/**/*.php']
		    },
		    options: {
		        bin: 'phpcbf',
		        standard: 'PSR2'
		    }
		}

	});

	grunt.registerTask('default', ['jshint', 'concat', 'cssmin', 'uglify', 'imagemin', 'copy', 'phpcs']);
};
