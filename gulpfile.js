var gulp = require('gulp');
var cachebust = require('gulp-cache-bust');
 
gulp.task('css', function() {
	return gulp.src('./htdocs/prod/web/assets/css/*.css')
	.pipe(cachebust({
		type: 'timestamp'
	}))
	.pipe(gulp.dest('./htdocs/prod/web/assets/css/'));
});

gulp.task('js', function() {
	return gulp.src('./htdocs/prod/web/assets/js/*.js')
	.pipe(cachebust({
		type: 'timestamp'
	}))
	.pipe(gulp.dest('./htdocs/prod/web/assets/js/'));
});

gulp.task('default', ['css', 'js'], function() {
	return gulp.src('./htdocs/prod/web/application/views/*.php')
	.pipe(cachebust({
		type: 'timestamp'
	}))
	.pipe(gulp.dest('./htdocs/prod/web/application/views/'));
});