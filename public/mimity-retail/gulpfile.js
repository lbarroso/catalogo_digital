const { src, dest, watch, series, parallel } = require('gulp')
const autoprefixer = require('gulp-autoprefixer')
const fileinclude = require('gulp-file-include')
const liveServer = require('live-server')
const cleanCSS = require('gulp-clean-css')
const concat = require('gulp-concat')
const rename = require('gulp-rename')
const uglify = require('gulp-terser')
const clean = require('gulp-clean')
const strip = require('gulp-strip-comments')
const sass = require('gulp-sass')
const all = require('gulp-all')

const dist = 'dist/'
const distJS = `${dist}js/`
const distCSS = `${dist}css/`
const distHTML = `${dist}html/`
const pluginsFolder = 'plugins/'

const requiredJS = [
  'node_modules/jquery/dist/jquery.js',
  'node_modules/bootstrap/dist/js/bootstrap.bundle.js',
  'node_modules/metismenu/dist/metisMenu.js',
  'node_modules/typeahead.js/dist/typeahead.jquery.js',
  'node_modules/noty/lib/noty.js'
]
const requiredJSmin = [
  'node_modules/jquery/dist/jquery.min.js',
  'node_modules/bootstrap/dist/js/bootstrap.bundle.min.js',
  'node_modules/metismenu/dist/metisMenu.min.js',
  'node_modules/typeahead.js/dist/typeahead.jquery.min.js',
  'node_modules/noty/lib/noty.min.js'
]

// Copy plugins from 'node_modules' to 'plugins' folder
function pluginsTask() {
  return all(

    // Swiper
    src(['node_modules/swiper/css/swiper.css', 'node_modules/swiper/css/swiper.min.css']).pipe(dest(`${pluginsFolder}/swiper`)),
    src(['node_modules/swiper/js/swiper.js', 'node_modules/swiper/js/swiper.min.js']).pipe(dest(`${pluginsFolder}/swiper`)),

    // noUiSlider
    src('node_modules/nouislider/distribute/**/*').pipe(dest(`${pluginsFolder}nouislider`)),

    // jQuery Countdown
    src(['node_modules/jquery-countdown/dist/jquery.countdown.js', 'node_modules/jquery-countdown/dist/jquery.countdown.min.js']).pipe(dest(`${pluginsFolder}/jquery-countdown`)),

    // Card (credit card for checkout)
    src('node_modules/card/dist/**/*').pipe(dest(`${pluginsFolder}card`)),
    src('node_modules/card/dist/jquery.card.js').pipe(uglify()).pipe(rename({ suffix: '.min' })).pipe(dest(`${pluginsFolder}card`)),

    // Photoswipe
    src('node_modules/photoswipe/dist/photoswipe.css').pipe(dest(`${pluginsFolder}photoswipe`)).pipe(cleanCSS()).pipe(rename({ suffix: '.min' })).pipe(dest(`${pluginsFolder}photoswipe`)),
    src('node_modules/photoswipe/dist/default-skin/*.*').pipe(dest(`${pluginsFolder}photoswipe/photoswipe-default-skin`)),
    src('node_modules/photoswipe/dist/default-skin/default-skin.css').pipe(cleanCSS()).pipe(rename({ suffix: '.min' })).pipe(dest(`${pluginsFolder}photoswipe/photoswipe-default-skin`)),
    src('node_modules/photoswipe/dist/*.js').pipe(dest(`${pluginsFolder}photoswipe`)),

    // Autosize
    src(['node_modules/autosize/dist/autosize.js', 'node_modules/autosize/dist/autosize.min.js']).pipe(dest(`${pluginsFolder}autosize`))

  )
}

function htmlTask() {
  return src('src/html/*.html').pipe(fileinclude()).pipe(dest(distHTML))
}

function cssTask() {
  return src('src/scss/style.scss', { sourcemaps: true })
    .pipe(sass({ outputStyle: 'expanded' }).on('error', sass.logError))
    .pipe(autoprefixer({ cascade: false }))
    .pipe(dest(distCSS, { sourcemaps: '.' }))
}

function cssMinTask() {
  return src([`${distCSS}**/*.css`, `!${distCSS}**/*.min.css`])
    .pipe(cleanCSS({ level: { 1: { specialComments: 0 } } }))
    .pipe(rename({ suffix: '.min' }))
    .pipe(dest(distCSS))
}

function vendorJsTask() {
  return all(
    src(requiredJS).pipe(concat('vendor.js')).pipe(dest(distJS)),
    src(requiredJSmin).pipe(concat('vendor.min.js')).pipe(strip()).pipe(dest(distJS))
  )
}

function templateJsTask() {
  return src('src/js/*.js')
    .pipe(dest(distJS))
    .pipe(uglify())
    .pipe(rename({ suffix: '.min' }))
    .pipe(dest(distJS))
}

function concatJsTask() {
  return all(
    src([
      `${distJS}vendor.js`,
      `${distJS}template.js`
    ])
      .pipe(concat('script.js'))
      .pipe(dest(distJS)),

    src([
      `${distJS}vendor.min.js`,
      `${distJS}template.min.js`
    ])
      .pipe(concat('script.min.js'))
      .pipe(dest(distJS))
  )
}

function cleanJsTask() {
  return src([
    `${distJS}vendor.js`,
    `${distJS}vendor.min.js`,
    `${distJS}template.js`,
    `${distJS}template.min.js`
  ], { read: false })
    .pipe(clean())
}

function jsTask(cb) {
  series(vendorJsTask, templateJsTask, concatJsTask, cleanJsTask)(cb)
}

function serveTask() {
  liveServer.start({
    watch: [
      'dist/css/style.min.css',
      'dist/js/script.min.js',
      'dist/html/*.html',
      'docs/*.html'
    ]
  })
  // if you use Windows, and experience random reload issue while using live-server,
  // please open cmd as Administrator, and run the following command
  // "fsutil behavior set disablelastaccess 1" without quotes
  // then restart your computer
  // Ref: https://github.com/nodejs/node/issues/21643
}

function watchTask() {
  watch([
    'src/html/*.html',
    'src/html/include/*.html'
  ], htmlTask)
  watch('src/scss/**/*.scss', series(cssTask, cssMinTask))
  watch('src/js/*.js', jsTask)
}

function cleanTask() {
  return src([dist, pluginsFolder], { read: false, allowEmpty: true })
    .pipe(clean())
}

exports.default = series(cleanTask, pluginsTask, htmlTask, cssTask, cssMinTask, jsTask, parallel(serveTask, watchTask))
exports.watch = parallel(serveTask, watchTask)
exports.plugins = pluginsTask
