const   gulp = require( 'gulp' ),
        postcss = require('gulp-postcss'),
        autoprefixer = require('autoprefixer'),
        browserSync = require('browser-sync').create(),
        sass = require('gulp-sass')(require('sass')),
        cleanCSS = require('gulp-clean-css'),
        sourcemaps = require('gulp-sourcemaps'),
        rename = require('gulp-rename'),
        concat = require('gulp-concat'),
        // imagemin = require('gulp-imagemin'),
        uglify = require('gulp-uglify-es').default,
        del = require('del');
        plumber = require('gulp-plumber');

const cfg = require('./gulpconfig.json');
const paths = cfg.paths;

gulp.task( 'sass', function() {
    return gulp.src( paths.sass + '/*.scss' )
    .pipe(sourcemaps.init({ loadMaps: true }))
    .pipe( sass({
        errorLogToConsole: true,
        outputStyle: 'expanded' 
    }).on('error', sass.logError ))
    .pipe(postcss([autoprefixer()]))
    .pipe(sourcemaps.write(undefined, { sourceRoot: null }))
    .pipe(rename('apis.admin.style.css'))
    .pipe(gulp.dest(paths.css));
});

gulp.task('minifycss', function() {
    return gulp.src(`${paths.css}/apis.admin.style.css`)
    .pipe(sourcemaps.init({ loadMaps: true }))
    .pipe( cleanCSS() )
    .pipe( rename({ suffix: '.min' }) )
    .pipe(sourcemaps.write('./'))
    .pipe( gulp.dest(paths.css) )
});

gulp.task('styles', function(callback) {
	gulp.series('sass', 'minifycss')(callback);
});

gulp.task('watch', function() {
    // css
    gulp.watch(`${paths.sass}/**/*.scss`, gulp.series('styles') );
    // js 
    // gulp.watch( 
    //     [
    //         `${paths.js}/*.js`,
    //         `!${paths.js}/main.js`,
    //         `!${paths.js}/main.min.js`,
    //     ]
    //     , gulp.series('scripts') );
    // image
});

gulp.task('copy-resource', function(done){
    // select2
    gulp.src(`${paths.node}/select2/**/*`)
    .pipe(gulp.dest(`${paths.resource}/select2`));

    done();
});
