const gulp = require('gulp');
const watch = require('gulp-watch');
const sass = require('gulp-sass');
const sourcemaps = require('gulp-sourcemaps');
const babel = require('gulp-babel');
const browserSync = require('browser-sync');
const webpack = require('gulp-webpack');

gulp.task('styles', function() {
  // place code for your default task here
  gulp.src('./resources/styles/main.scss')
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('./public/admin/css'))
});

gulp.task('scripts', function() {
  gulp.src('./resources/scripts/app.js')
    .pipe(sourcemaps.init())
    .pipe(webpack(require('./webpack.config.js')))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('./public/admin/js'))
});

browserSync.init({
  open: "http://testseite.local", // Change with your dev url
  host: "http://testseite.local", // Change with your dev url
  proxy: "http://testseite.local", // Change with your dev url
  port: 8081,
  notify: false
});

//Watch task
gulp.task('default',function() {
  gulp.watch('./resources/styles/**/*.scss',['styles']).on('change', browserSync.reload);;
  gulp.watch('./resources/scripts/**/*.js', ['scripts']).on('change', browserSync.reload);;
});