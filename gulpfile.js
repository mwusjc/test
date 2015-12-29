var gulp = require('gulp');
var rev = require('gulp-rev-append');

gulp.task('rev', function() {
	gulp.src('./htdocs/prod/web/application/views/**/*.php')
	.pipe(rev())
	.pipe(gulp.dest('./htdocs/prod/web/application/views/'));
});