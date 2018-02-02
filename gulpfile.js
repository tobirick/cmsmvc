const gulp = require('gulp');
const watch = require('gulp-watch');
const sass = require('gulp-sass');

gulp.task('styles', function() {
  // place code for your default task here
  gulp.src('./resources/styles/main.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest('./public/css'))
});

//Watch task
gulp.task('default',function() {
  gulp.watch('./resources/styles/**/*.scss',['styles']);
});