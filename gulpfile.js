var gulp = require('gulp');
var less = require('gulp-less');
var uglify = require('gulp-uglify');
var cssmin = require('gulp-minify-css');
var autoprefixer = require('gulp-autoprefixer');

// Perform tasks in given sequence
gulp.task('assets', ['less', 'js']);

// Compile less sources and copy css
gulp.task('less', function () {
	gulp.src('src/assets/less/**/*').pipe(less()).pipe(autoprefixer()).pipe(cssmin({ processImport: false })).pipe(gulp.dest('public/css'));
	gulp.src('src/assets/less/**/*').pipe(less()).pipe(autoprefixer()).pipe(cssmin({ processImport: false })).pipe(gulp.dest('../../../public/massets/css'));
});

// Minify and copy js
gulp.task('js', function () {
	gulp.src('src/assets/js/**/*').pipe(uglify()).pipe(gulp.dest('public/js'));
	gulp.src('src/assets/js/**/*').pipe(uglify()).pipe(gulp.dest('../../../public/massets/js'));
});

gulp.task('default', function () {
	gulp.watch(['src/assets/js/*.js'], ['js']);
	gulp.watch(['src/assets/less/*.less'], ['less']);
});