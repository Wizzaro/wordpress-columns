module.exports = function (grunt) {

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        //----------------------------------------
        compass: {
            dist_admin: {
                options: {
                    config: 'assets-dev/admin/sass/config.rb',
                    specify: [
                        'assets-dev/admin/sass/wizzaro-columns.scss',
                    ],
                    outputStyle: 'compressed',
                    environment: 'production'
                }
            }
        },
        //----------------------------------------
        concat: {
            dist_admin_mce_button: {
                src: [
                    'assets-dev/admin/js/wizzaro-columns.js'
                ],
                dest: 'assets/admin/js/wizzaro-columns.min.js'
            },
        },
        //----------------------------------------
        uglify: {
            dist_admin_mce_button: {
                files: {
                    'assets/admin/js/wizzaro-columns.min.js': [
                        'assets-dev/admin/js/wizzaro-columns.js'
                    ],
                },
            }
        },
        //----------------------------------------
        watch: {
            dist_admin_style: {
                files: [
                    'assets-dev/admin/sass/*.scss'
                ],
                tasks: ['compass:dist_admin']
            },
            dist_admin_mce_button: {
                files: [
                    'assets-dev/admin/js/wizzaro-columns.js'
                ],
                tasks: ['concat:dist_admin_mce_button']
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-uglify');

    grunt.registerTask('default', ['compass','uglify']);
    grunt.registerTask('liveupdate', ['watch']);
};
