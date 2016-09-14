var gulp = require('gulp');
var uglify = require('gulp-uglify');    
var closureCompiler = require('gulp-closure-compiler');
var minify = require('node-minify');
 
gulp.task('mini', function () {
    gulp.src('../css/*.css')
        .pipe(compress({
            type: 'css'
        }))
        .pipe(gulp.dest('dest'));
});

// Using YUI Compressor for CSS 
new minify.minify({
  type: 'yui-css',
  fileIn: '../css/*.css',
  fileOut: 'build-css.css',
  callback: function(err, min){
    console.log(err);
    //console.log(min); 
  }
});

gulp.task('default', function() {
 return gulp.src("../js/*.js")
    .pipe(uglify())
    .pipe(gulp.dest('minjs'));
});


gulp.task('default', function() {
  return gulp.src('../js/*.js')
    .pipe(closureCompiler({
      compilerPath: '../../../node_modules/closurecompiler/compiler/closure-compiler-v20160822.jar',
      fileName: 'build.js'
    }))
    .pipe(gulp.dest('../ja'));
});

