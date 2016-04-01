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
					'web/js/vendor/bxslider/jquery.bxslider.min.js',
					'web/js/vendor/jquery.magnific-popup.min.js', 
					'web/js/main.js'
				],
				dest: 'web/js/main.min.js'
			}		
		},

		cssmin: {
			target: {
				files: {
					'web/css/main.min.css': ['web/css/main.css']
				}
			}
		},

		uglify: {
			dist: {
				files: {
					'web/js/main.min.js': ['web/js/main.min.js']
				}
			}
		}

	});

	grunt.registerTask('default', ['jshint', 'concat', 'cssmin', 'uglify']);
};
