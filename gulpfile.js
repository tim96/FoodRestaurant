var gulp = require('gulp');
var gulpif = require('gulp-if');
var uglify = require('gulp-uglify');
var uglifycss = require('gulp-uglifycss');
var less = require('gulp-less');
var concat = require('gulp-concat');
var sourcemaps = require('gulp-sourcemaps');
var env = process.env.type;

gulp.task('js', function () {
    return gulp.src([
            'bower_components/jquery/dist/jquery.js',
            'bower_components/bootstrap/dist/js/bootstrap.js',
            'src/Tim/FoodRestaurantBundle/Resources/public/js/**/*.js'])
        .pipe(concat('app.js'))
        // .pipe(gulpif(env === 'prod', uglify()))
        .pipe(uglify())
        // .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('web/js'));
});

gulp.task('css', function () {
    return gulp.src([
            'bower_components/bootstrap/dist/css/bootstrap.css',
            'bower_components/font-awesome/css/font-awesome.min.css',
            'src/Tim/FoodRestaurantBundle/Resources/public/css/**/*.css'])
        .pipe(gulpif(/[.]less/, less()))
        .pipe(concat('styles.css'))
        // .pipe(gulpif(env === 'prod', uglifycss()))
        // .pipe(sourcemaps.write('./'))
        .pipe(uglifycss())
        .pipe(gulp.dest('web/css'));
});

gulp.task('img', function() {
    return gulp.src('src/Tim/FoodRestaurantBundle/Resources/public/img/**/*.*')
        .pipe(gulp.dest('web/img'));
});

gulp.task('fonts', function() {
    return gulp.src('bower_components/bootstrap/dist/fonts/**/*.*')
        .pipe(gulp.dest('web/fonts'));
});

//define executable tasks when running "gulp" command
gulp.task('default', ['js', 'css', 'img', 'fonts']);