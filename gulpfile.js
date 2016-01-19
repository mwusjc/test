var gulp = require('gulp');
var rev = require('gulp-rev-append');

gulp.task('cache-bust', function() {
	gulp.src(['htdocs/prod/web/application/views/**/*.php', 'htdocs/prod/web/application/views/**/*.html'])
	.pipe(rev())
	.pipe(gulp.dest('htdocs/prod/web/application/views/'));
});

gulp.task('default', ['cache-bust']);