module.exports = (grunt) ->
  grunt.initConfig
    useminPrepare:
      html: ['app/presenters/templates/@layout.latte']
      options:
        dest: '.'

    netteBasePath:
      basePath: 'www'
      options:
        removeFromPath: ['app/presenters/templates/']

    less:
      development:
        options:
          compress: false
        files: # todo add all necessary files
          "www/style/main.css": [
            "www/style/bootstrap.less",
            "www/style/main.less"
          ]

    watch:
      styles:
        files: [
          'www/style/**/*.less'
          ]
        tasks: ['less']
        options:
          interrupt: true

  # These plugins provide necessary tasks.
  grunt.loadNpmTasks 'grunt-contrib-concat'
  grunt.loadNpmTasks 'grunt-contrib-uglify'
  grunt.loadNpmTasks 'grunt-contrib-cssmin'
  grunt.loadNpmTasks 'grunt-usemin'
  grunt.loadNpmTasks 'grunt-nette-basepath'
  grunt.loadNpmTasks 'grunt-contrib-less'
  grunt.loadNpmTasks 'grunt-contrib-watch'

  # Default task.
  grunt.registerTask 'default', [
    'less'
    'useminPrepare'
    'netteBasePath'
    'concat'
    'uglify'
    'cssmin'
  ]
