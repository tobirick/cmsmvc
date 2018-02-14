const gulp = require('gulp');
const watch = require('gulp-watch');
const sass = require('gulp-sass');
const sourcemaps = require('gulp-sourcemaps');
const babel = require('gulp-babel');
const browserSync = require('browser-sync');

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
    .pipe(babel({
      presets: ['es2015']
    }))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('./public/admin/js'))
});

browserSync.init({
  open: "http://testseite.local:81",
  host: "http://testseite.local:81",
  proxy: "http://testseite.local:81",
  port: 81,
  notify: false
});

//Watch task
gulp.task('default',function() {
  gulp.watch('./resources/styles/**/*.scss',['styles']).on('change', browserSync.reload);;
  gulp.watch('./resources/scripts/**/*.js', ['scripts']).on('change', browserSync.reload);;
});