module.exports = function(grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		watch: {
			sass: {
				files: [
					'css/sass/*.scss',
					'css/sass/importer.scss',
				],
				tasks: ['sass:dist'],
				options: {
					livereload: true,
					port: 9000
				}
			}
		},
		sass: {
			options: {
				sourceMap: true,
				outputStyle: 'expanded',
				sourceComments: false
			},
			dist: {
				files: {
					'css/style.css': 'css/sass/importer.scss'
				}
			}
		}
	});
	grunt.registerTask('default', ['sass:dist', 'watch']);
	grunt.loadNpmTasks('grunt-sass');
	grunt.loadNpmTasks('grunt-contrib-watch');
};
/*
SASS to CSS Project Set-up
    1.0: Step by step NPM install
        1.1: Use [npm install grunt --save-dev]
        1.2: Use [npm install grunt-sass --save-dev]
        1.3: Use [npm install grunt-contrib-watch --save-dev]
    2.0: Shorthand NPM Install
        2.1: npm install grunt --save-dev; npm install grunt-sass --save-dev; npm install grunt-contrib-watch --save-dev;
    3.0: Use "Grunt" command to start your project.
        3.1: Type "Grunt"
*/
