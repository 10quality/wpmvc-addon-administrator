/**
 * Gulp
 *
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-administrator
 * @license MIT
 * @version 1.0.4
 */

'use strict';

// Prepare
var gulp = require('gulp');

gulp.task('vendorcss', function() {
    return gulp.src([
            './node_modules/font-awesome/css/font-awesome.min.css',
            './node_modules/jquery-ui/themes/base/datepicker.css',
            './node_modules/spectrum-colorpicker/spectrum.css',
            './node_modules/select2/dist/css/select2.min.css',
            './node_modules/jquery-datetimepicker/build/jquery.datetimepicker.min.css',
        ])
        .pipe(gulp.dest('./assets/css'));
});

gulp.task('select2i18n', function() {
    return gulp.src([
            './node_modules/select2/dist/js/i18n/**/*',
            './node_modules/spectrum-colorpicker/i18n/**/*',
        ])
        .pipe(gulp.dest('./assets/js/i18n'));
});

gulp.task('vendorjs', gulp.series(['select2i18n'], function() {
    return gulp.src([
            './node_modules/wordpress-media-gallery/dist/jquery.wp-media-uploader.min.js',
            './node_modules/spectrum-colorpicker/spectrum.js',
            './node_modules/select2/dist/js/select2.min.js',
            './node_modules/jquery-datetimepicker/build/jquery.datetimepicker.full.min.js',
        ])
        .pipe(gulp.dest('./assets/js'));
}));

gulp.task('vendorfonts', function() {
    return gulp.src([
            './node_modules/font-awesome/fonts/**/*',
        ])
        .pipe(gulp.dest('./assets/fonts'));
});

gulp.task('default', gulp.parallel('vendorcss', 'vendorfonts', 'vendorjs'));