var gulp = require('gulp');
var less = require('gulp-less');
var concat = require('gulp-concat');
var cssmin = require('gulp-cssmin');
var replace = require('gulp-replace');
var merge = require('merge-stream');
var uglify = require('gulp-uglify');

gulp.task('css', function() {
    return gulp.src([
        'node_modules/bootstrap/less/bootstrap.less',
        'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css',
        'node_modules/toastr/toastr.less',
        'node_modules/font-awesome/less/font-awesome.less',
        'node_modules/ionicons/dist/css/ionicons.css',
        'node_modules/bootstrap-datepicker/build/build3.less',
        'node_modules/admin-lte/dist/css/skins/_all-skins.css',
        'node_modules/icheck/skins/square/blue.css',
        'vendor/acacha/admin-lte-template-laravel/public/css/toastr.css',
        'vendor/acacha/admin-lte-template-laravel/public/plugins/datatables/dataTables.bootstrap.css',
        'vendor/acacha/admin-lte-template-laravel/public/plugins/select2/select2.css',
        'node_modules/admin-lte/build/less/AdminLTE.less',
        'vendor/acacha/admin-lte-template-laravel/resources/assets/less/adminlte-app.less',
        'vendor/acacha/admin-lte-template-laravel/public/css/app.css',
        'vendor/acacha/admin-lte-template-laravel/public/css/adminlte-less.css',
        'vendor/acacha/admin-lte-template-laravel/public/css/adminlte-app.css',
        'resources/assets/less/styles.less'
    ])
        .pipe(replace('@import "node_modules/bootstrap-less/bootstrap/bootstrap.less";', '@import "node_modules/bootstrap/less/bootstrap.less";'))
        .pipe(replace('@import "../../bootstrap-less/variables.less";', ''))
        .pipe(less())
        .pipe(concat('styles.min.css'))
        .pipe(cssmin())
        .pipe(gulp.dest('public/css'));
});

gulp.task('js', function() {
    gulp.src([
        'node_modules/jquery/dist/jquery.js',
        'node_modules/bootstrap/dist/js/bootstrap.js',
        'node_modules/admin-lte/plugins/datatables/jquery.dataTables.js',
        'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap.js',
        'node_modules/admin-lte/plugins/select2/select2.full.js',
        'node_modules/bootstrap-datepicker/js/bootstrap-datepicker.js',
        'node_modules/bootstrap-datepicker/js/locales/bootstrap-datepicker.ru.js',
        'node_modules/jquery-mask-plugin/dist/jquery.mask.js',
        'public/js/app.js',
        'resources/assets/js/scripts.js'
    ])
        .pipe(concat('scripts.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('public/js'));
});

gulp.task('copy', function () {
    gulp.src('node_modules/font-awesome/fonts/*').pipe(gulp.dest('public/fonts'));
    gulp.src('node_modules/ionicons/dist/fonts/*.*').pipe(gulp.dest('public/fonts'));
    gulp.src('node_modules/bootstrap/fonts/*.*').pipe(gulp.dest('public/fonts/bootstrap/'));
    gulp.src('node_modules/admin-lte/dist/css/skins/*.*').pipe(gulp.dest('public/css/skins'));
    gulp.src('node_modules/admin-lte/dist/img/*.*').pipe(gulp.dest('public/img'));
    gulp.src('node_modules/icheck/skins/square/blue.png').pipe(gulp.dest('public/css'));
});

gulp.task('default', ['css', 'copy', 'js']);