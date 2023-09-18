var elixir = require('laravel-elixir'),
	gulp    = require('gulp'),
    htmlmin = require('gulp-htmlmin');

/* compress view */
elixir.extend('compress', function() {
    new elixir.Task('compress', function() {
        return gulp.src('./storage/framework/views/*')
            .pipe(htmlmin({
                collapseWhitespace:    true,
                //removeAttributeQuotes: true,
                removeComments:        true,
                minifyJS:              true,
            }))
            .pipe(gulp.dest('./storage/framework/views/'));
    })
    .watch('./storage/framework/views/*');
});

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) 
{
	mix.compress();
	
	this.config.assetsPath = '';
	this.config.css.folder = '';
	this.config.js.folder = '';
    mix.styles(
		[
			'public/assets/global/plugins/bower_components/bootstrap/dist/css/bootstrap.min.css',
			'public/assets/global/plugins/bower_components/fontawesome/css/font-awesome.css',
			'public/assets/global/plugins/bower_components/animate.css/animate.min.css',
			'public/assets/global/plugins/bower_components/simple-line-icons/css/simple-line-icons.css',
			'public/assets/global/plugins/bower_components/flag-icon-css/css/flag-icon.min.css',
			'public/assets/global/plugins/bower_components/chartist/dist/chartist.min.css',
			'public/assets/global/plugins/bower_components/bootstrap-wysihtml5/src/bootstrap-wysihtml5.css',
			'public/assets/global/plugins/bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css',
			'public/assets/commercial/plugins/cube-portfolio/cubeportfolio/css/cubeportfolio.min.css',
			'public/assets/admin/css/reset.css',
			'public/assets/admin/css/layout.css',
			'public/assets/admin/css/components.css',
			'public/assets/admin/css/plugins.css',
			'public/assets/admin/css/custom.css',
			'public/assets/global/plugins/bower_components/bootstrap-wysihtml5/lib/css/github.css',
			'public/assets/global/plugins/bower_components/emojione/css/emojione.css',
			
		]
	, 'public/css/theme.css');
	
    mix.scripts(
		[
			'public/assets/global/plugins/bower_components/jquery/dist/jquery.min.js',
			'public/assets/admin/js/notifications.js',
			'public/assets/admin/js/client.js',
			'public/assets/global/plugins/bower_components/jquery-cookie/jquery.cookie.js',
			'public/assets/global/plugins/bower_components/bootstrap/dist/js/bootstrap.min.js',
			'public/assets/global/plugins/bower_components/jquery-easing-original/jquery.easing.1.3.min.js',
			'public/assets/global/plugins/bower_components/ionsound/js/ion.sound.min.js',
			'public/assets/global/plugins/bower_components/retina.js/dist/retina.min.js',
			'public/assets/global/plugins/bower_components/typehead.js/dist/handlebars.js',
			'public/assets/global/plugins/bower_components/typehead.js/dist/typeahead.bundle.min.js',
			'public/assets/global/plugins/bower_components/jquery-nicescroll/jquery.nicescroll.min.js',
			'public/assets/global/plugins/bower_components/jquery.sparkline.min/index.js',
			'public/assets/global/plugins/bower_components/bootbox/bootbox.js',
			'public/assets/global/plugins/bower_components/bootstrap-wysihtml5/lib/js/wysihtml5-0.3.0.min.js',
			'public/assets/global/plugins/bower_components/bootstrap-wysihtml5/lib/js/highlight.js',
			'public/assets/global/plugins/bower_components/bootstrap-wysihtml5/src/bootstrap-wysihtml5.js',
			'public/assets/global/plugins/bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js','public/assets/commercial/plugins/cube-portfolio/cubeportfolio/js/jquery.cubeportfolio.min.js','public/assets/global/plugins/bower_components/peity/jquery.peity.min.js','public/assets/global/plugins/bower_components/chartist/dist/chartist.min.js',
			'public/assets/admin/js/apps.js',
			'public/assets/admin/js/demo.js',
			'public/assets/global/plugins/bower_components/emojione/js/emojione.js',
			
		]
	, 'public/js/theme.js');
});

elixir(function(mix) 
{
    mix.version(['public/css/theme.css', 'public/js/theme.js']);
});
