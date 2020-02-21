/**
 * Gulp
 *
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.0
 */

'use strict';

// Prepare
var gulp = require('gulp');

gulp.task('vendorcss', function() {
    return gulp.src([
            './node_modules/font-awesome/css/font-awesome.min.css',
            './node_modules/jquery-ui/themes/base/datepicker.css',
        ])
        .pipe(gulp.dest('./assets/css'));
});

gulp.task('vendorjs', function() {
    return gulp.src([
            './node_modules/wordpress-media-gallery/dist/jquery.wp-media-uploader.min.js',
        ])
        .pipe(gulp.dest('./assets/js'));
});

gulp.task('vendorfonts', function() {
    return gulp.src([
            './node_modules/font-awesome/fonts/**/*',
        ])
        .pipe(gulp.dest('./assets/fonts'));
});

gulp.task('default', gulp.parallel('vendorcss', 'vendorfonts', 'vendorjs'));