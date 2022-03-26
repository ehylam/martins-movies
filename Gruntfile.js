const sass = require('sass');

module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    uglify: {
      my_target: {
        options: {
          sourceMap: true,
          sourceMapName: 'lib/js/scripts.js.map'
        },
        files: {
          'lib/js/scripts.min.js': ['lib/js/scripts.js']
        }
      }
    },
    sass: {
      dist: {
        options: {
          implementation: sass,
          sourcemap: true,
          compress: true,
          style: 'compressed'
        },
        files: {
          'lib/css/styles.min.css' : 'lib/scss/main.scss'
        }
      },
    },
    watch: {
      css: {
        files: '**/*.scss',
        tasks: ['sass']
      },
      js: {
        files: '**/*.js',
        tasks: ['uglify'],
        options: {
          spawn: false
        }

      }
    }
  });

  grunt.loadNpmTasks('grunt-sass');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.registerTask('default', ['watch']);

};