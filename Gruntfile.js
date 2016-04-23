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
					'web/dev/bundles/fosjsrouting/js/router.js',
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
            options: {
                keepSpecialComments: 0
            },
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

        postcss: {
            options: {
                map: {
                    inline: false, // save all sourcemaps as separate files...
                    annotation: 'web/dev/css/' // ...to the specified directory
                },
                processors: [
                    require('postcss-pxtorem')(), // add fallbacks for rem units
                    require('autoprefixer')({browsers: 'last 2 versions'}), // add vendor prefixes
                    //require('cssnano')({
                    //    discardComments: {removeAll: true}
                    //}) // minify the result
                ]
            },
            dist: {
                src: 'web/dev/css/*.css',

            }
        },

        compass: {
            dist: {
                options: {
                    config: 'compass.rb',
                    watch: true
                }
            }
        },

        px_to_rem: {
            dist: {
                options: {
                    base: 16,
                    fallback: false,
                    fallback_existing_rem: false,
                    ignore: [],
                    map: false
                },
                files: {
                    'web/prod/css/main.min.css': ['web/prod/css/main.min.css']
                }
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
		},

        watch: {
            css: {
                files: ['web/dev/css/*.css'],
                tasks: ['postcss'],
                options: {
                    spawn: false,
                },
            },
        },

        concurrent: {
            target: ['compass', 'watch'],
        },

        browserSync: {
            dev: {
                bsFiles: {
                    src : [
                        'web/dev/css/main.css',
                        'app/resources/**/*.twig'
                        ]
                },
                options: {
                    watchTask: true,
                    proxy: "localhost/MPT_3.0/web/app_dev.php"
                }
            }
        }

	});

	grunt.registerTask('default', ['jshint', 'concat', 'cssmin', 'uglify', 'imagemin', 'copy', 'phpcs']);
    grunt.registerTask('watchall', ['browserSync', 'concurrent:target']);
    grunt.registerTask('rem', ['px_to_rem']);
    grunt.registerTask('post', ['postcss']);
    grunt.registerTask('sass', ['compass']);

};
