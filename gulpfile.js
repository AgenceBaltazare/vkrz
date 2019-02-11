var gulp = require('gulp'),
    sass = require('gulp-sass'),
    sassimport = require('gulp-sass-bulk-import'),
    scsslint = require('gulp-scsslint'),
    csso = require('gulp-csso'),
    sourcemaps = require('gulp-sourcemaps')


var theme = 'wp-content/themes/psppsv/';

gulp.task('style', function () {
    return gulp.src([theme + 'styles/src/main.scss'], {sourcemap: true})
        .pipe(scsslint('scsslint.yml'))
        .pipe(sassimport())
        .pipe(sourcemaps.init())
        .pipe(sass({
            includePaths: [theme + 'styles/src/']
        }))
        .pipe(csso())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(theme + 'styles/build/'))
});


gulp.task('default', ['style']);


gulp.task('watch', function () {
    gulp.watch(
        theme + 'styles/src/**/*.scss', ['style']
    ).on('change', function(event){
        console.log('Le fichier ' + event.path + ' a ete modifie.');
    });
});
