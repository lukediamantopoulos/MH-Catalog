"use strict";

var gulp = require('gulp');
var sass = require('gulp-sass');
var browserSync = require('browser-sync').create();
var babel = require('gulp-babel');
var autoprefixer = require('gulp-autoprefixer');
var sourcemaps = require('gulp-sourcemaps');
var cssnano = require('gulp-cssnano');
var concat = require('gulp-concat');

gulp.task('browserSync', function() {
  browserSync.init({
    server: {
      baseDir: './'
    },
  })
})

gulp.task('sass', function(){
  return gulp.src('dev/sass/**/*.scss')
  	.pipe(sourcemaps.init())
  	.pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer('last 5 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1'))
    .pipe(cssnano())
    .pipe(sourcemaps.write('./'))
    .pipe(concat('style.css'))
    .pipe(gulp.dest('./'))
    .pipe(browserSync.reload({
     	stream: true
    }))
});

gulp.task('script', function(){
  return gulp.src('dev/js/**/*.js')
    .pipe(sourcemaps.init())
    .pipe(babel({
            presets: ['env']
        }))
    .pipe(concat('script.js'))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('./'))
    .pipe(browserSync.reload({
     	stream: true
    }))
});

gulp.task('default', ['sass', 'script'], function () {
  gulp.watch('./dev/sass/**/*.scss', ['sass']);
  gulp.watch('./dev/js/**/*.js', ['script']);
});

