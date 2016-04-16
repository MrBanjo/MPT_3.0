module.exports = function(grunt){

	require('load-grunt-tasks')(grunt);

	grunt.initConfig({

		jshint: {
			all: ['web/js/*.js', '!web/js/main.min.js']
		},

		concat: {
			dist: {
				src: [
					'web/js/vendor/jquery-1.11.2.min.js', 
					'web/bundles/fosjsrouting/js/router.js',
					'web/js/fos_js_routes.js', 
					'web/js/vendor/bxslider/jquery.bxslider.min.js',
					'web/js/vendor/jquery.magnific-popup.min.js', 
					'web/js/main.js'
				],
				dest: 'web/js/main.min.js'
			}		
		},

		cssmin: {
			target: {
			    files: [{
			      expand: true,
			      cwd: 'web/css/',
			      src: ['*.css', '!*.min.css'],
			      dest: 'web/css/',
			      ext: '.min.css'
			    }]
			}
		},

		uglify: {
			dist: {
				files: {
					'web/js/main.min.js': ['web/js/main.min.js']
				}
			}
		},

		imagemin: {                          // Task 
		    dynamic: {                         // Another target 
		      files: [{
	        expand: true,                  // Enable dynamic expansion 
		        cwd: 'web/img/',                   // Src matches are relative to this path 
		        src: ['**/*.{png,jpg,gif}'],   // Actual patterns to match 
		        dest: 'web/imgmin/'                  // Destination path prefix 
		      }]
		    }
		  },

		phpcs: {
		    application: {
		        src: ['src/AppBundle/**/*.php']
		    },
		    options: {
		        bin: 'phpcs',
		        standard: 'PSR2'
		    }
		}

	});

	grunt.registerTask('default', ['jshint', 'concat', 'cssmin', 'uglify', 'phpcs']);
};
