!function($, wysi) {
    "use strict";
    var exec = function (composer) {        

        var pre = this.state(composer);
        
        if (pre) {
            
            // caret is already within a <pre><code>...</code></pre>
            composer.selection.executeAndRestore(function () {
                var codeSelector = pre.querySelector("code");
                wysi.dom.replaceWithChildNodes(pre);
                if (codeSelector) {
                    wysi.dom.replaceWithChildNodes(pre);
                    hljs.highlightBlock(codeSelector);
                }
            });
        } 
		else 
		{
                        
            // Wrap in <pre><code>...</code></pre>
            var range = composer.selection.getRange();

            if (!range) return false;

            var selectedNodes = range.extractContents(),
                preElem = composer.doc.createElement("pre"),
                codeElem = composer.doc.createElement("code");
            
            preElem.appendChild(codeElem);
            codeElem.appendChild(selectedNodes);
            range.insertNode(preElem);
            hljs.highlightBlock(codeElem);
            composer.selection.selectNode(preElem);
            
        }
    };

    var state = function (composer) {        
        var selectedNode = composer.selection.getSelectedNode();
        return wysi.dom.getParentElement(selectedNode, { nodeName: "CODE" }) && wysi.dom.getParentElement(selectedNode, { nodeName: "PRE" });
    };

    wysi.commands.formatCode = {
        exec: exec,
        state: state
    };
	
    var tpl = {
        "font-styles": function(locale, options) {
            var size = (options && options.size) ? ' btn-'+options.size : '';
            return "<li class='dropdown'>" +
              "<a class='btn btn-default dropdown-toggle" + size + "' data-toggle='dropdown' href='#'>" +
              "<i class='icon-font'></i>&nbsp;<span class='current-font'>" + locale.font_styles.normal + "</span>&nbsp;<b class='caret'></b>" +
              "</a>" +
              "<ul class='dropdown-menu'>" +
                "<li><a data-wysihtml5-command='formatBlock' data-wysihtml5-command-value='div' tabindex='-1'>" + locale.font_styles.normal + "</a></li>" +
                "<li><a data-wysihtml5-command='formatBlock' data-wysihtml5-command-value='h1' tabindex='-1'>" + locale.font_styles.h1 + "</a></li>" +
                "<li><a data-wysihtml5-command='formatBlock' data-wysihtml5-command-value='h2' tabindex='-1'>" + locale.font_styles.h2 + "</a></li>" +
                "<li><a data-wysihtml5-command='formatBlock' data-wysihtml5-command-value='h3' tabindex='-1'>" + locale.font_styles.h3 + "</a></li>" +
                "<li><a data-wysihtml5-command='formatBlock' data-wysihtml5-command-value='h4'>" + locale.font_styles.h4 + "</a></li>" +
                "<li><a data-wysihtml5-command='formatBlock' data-wysihtml5-command-value='h5'>" + locale.font_styles.h5 + "</a></li>" +
                "<li><a data-wysihtml5-command='formatBlock' data-wysihtml5-command-value='h6'>" + locale.font_styles.h6 + "</a></li>" +
              "</ul>" +
            "</li>";
        },

        "emphasis": function(locale, options) {
            var size = (options && options.size) ? ' btn-'+options.size : '';
            return "<li>" +
              "<div class='btn-group'>" +
                "<a class='btn btn-default" + size + "' data-wysihtml5-command='bold' title='CTRL+B' tabindex='-1'>" + locale.emphasis.bold + "</a>" +
                "<a class='btn btn-default" + size + "' data-wysihtml5-command='italic' title='CTRL+I' tabindex='-1'>" + locale.emphasis.italic + "</a>" +
                "<a class='btn btn-default" + size + "' data-wysihtml5-command='underline' title='CTRL+U' tabindex='-1'>" + locale.emphasis.underline + "</a>" +
              "</div>" +
            "</li>";
        },

        "lists": function(locale, options) {
            var size = (options && options.size) ? ' btn-'+options.size : '';
            return "<li>" +
              "<div class='btn-group'>" +
                "<a class='btn" + size + "' data-wysihtml5-command='insertUnorderedList' title='" + locale.lists.unordered + "' tabindex='-1'><i class='icon-list'></i></a>" +
                "<a class='btn" + size + "' data-wysihtml5-command='insertOrderedList' title='" + locale.lists.ordered + "' tabindex='-1'><i class='icon-th-list'></i></a>" +
                "<a class='btn" + size + "' data-wysihtml5-command='Outdent' title='" + locale.lists.outdent + "' tabindex='-1'><i class='icon-indent-right'></i></a>" +
                "<a class='btn" + size + "' data-wysihtml5-command='Indent' title='" + locale.lists.indent + "' tabindex='-1'><i class='icon-indent-left'></i></a>" +
              "</div>" +
            "</li>";
        },

        "link": function(locale, options) {
            var size = (options && options.size) ? ' btn-'+options.size : '';
            return "<li>" +
              "<div class='bootstrap-wysihtml5-insert-link-modal modal fade'>" +
                "<div class='modal-header'>" +
                  "<a class='close' data-dismiss='modal'>&times;</a>" +
                  "<h3>" + locale.link.insert + "</h3>" +
                "</div>" +
                "<div class='modal-body'>" +
                  "<input value='http://' class='bootstrap-wysihtml5-insert-link-url input-xlarge'>" +
                  "<label class='checkbox'> <input type='checkbox' class='bootstrap-wysihtml5-insert-link-target' checked>" + locale.link.target + "</label>" +
                "</div>" +
                "<div class='modal-footer'>" +
                  "<a href='#' class='btn' data-dismiss='modal'>" + locale.link.cancel + "</a>" +
                  "<a href='#' class='btn btn-primary' data-dismiss='modal'>" + locale.link.insert + "</a>" +
                "</div>" +
              "</div>" +
              "<a class='btn" + size + "' data-wysihtml5-command='createLink' title='" + locale.link.insert + "' tabindex='-1'><i class='icon-share'></i></a>" +
            "</li>";
        },

        "image": function(locale, options) {
            var size = (options && options.size) ? ' btn-'+options.size : '';
            return "<li>" +
              "<div class='bootstrap-wysihtml5-insert-image-modal modal fade'>" +
                "<div class='modal-header'>" +
                  "<a class='close' data-dismiss='modal'>&times;</a>" +
                  "<h3>" + locale.image.insert + "</h3>" +
                "</div>" +
                "<div class='modal-body'>" +
                  "<input type='file' class='bootstrap-wysihtml5-insert-image-url input-xlarge'>" +
                "</div>" +
                "<div class='modal-footer'>" +
                  "<a href='#' class='btn' data-dismiss='modal'>" + locale.image.cancel + "</a>" +
                  "<a href='#' class='btn btn-primary' data-dismiss='modal'>" + locale.image.insert + "</a>" +
                "</div>" +
              "</div>" +
              "<a class='btn" + size + "' data-wysihtml5-command='insertImage' title='" + locale.image.insert + "' tabindex='-1'><i class='icon-picture'></i></a>" +
            "</li>";
        },

        "html": function(locale, options) {
            var size = (options && options.size) ? ' btn-'+options.size : '';
            return "<li>" +
              "<div class='btn-group'>" +
                "<a class='btn" + size + "' data-wysihtml5-action='change_view' title='" + locale.html.edit + "' tabindex='-1'><i class='icon-pencil'></i></a>" +
              "</div>" +
            "</li>";
        },
		
		"format-code": function(locale, options) {
              var size = (options && options.size) ? ' btn-'+options.size : '';
              return "<li>" +
                "<div class='btn-group'>" +
                  "<a class='btn " + size + "' data-wysihtml5-action='formatCode' title='" + locale.formatCode.highlight + "'><i class='fa fa-code'></i></a>" +
                "</div>" +
              "</li>";
         },
		 
        "video": function(locale) { 
    		return "<li>" +
	            "<div class='bootstrap-wysihtml5-insert-video-modal modal fade'>" +
	                "<div class='modal-header'>" +
	                    "<a class='close' data-dismiss='modal'>&times;</a>" +
	                    "<h3>" + locale.video.insert + "</h3>" +
	                "</div>" +
	                "<div class='modal-body'>" +
	                    "<div class='control-group'>" +
	                        "<input type='text' data-wysihtml5-dialog-field='src' value='https://' class='bootstrap-wysihtml5-insert-video-url input-xlarge'>" +
	                    "</div>" +
	                    "<div class='control-group error form-inline'>" +
                    		"<label class='video-error hide'>" + locale.video.invalid + "</label>" +
	                    "</div>" +
	                "</div>" +
	                "<div class='modal-footer'>" +
	                    "<a href='#' class='btn' data-dismiss='modal' data-wysihtml5-dialog-action='cancel'>" + locale.video.cancel + "</a>" +
	                    "<a href='#' class='btn btn-primary' data-dismiss='modal' data-wysihtml5-dialog-action='save'>" + locale.video.insert + "</a>" +
	                "</div>" +
	            "</div>" +
	            "<a class='btn' data-wysihtml5-command='insertVideo' title='" + locale.video.insert + "'><i class='icon-film'></i></a>" +
	       "</li>";
	    },

        "color": function(locale, options) {
            var size = (options && options.size) ? ' btn-'+options.size : '';
            return "<li class='dropdown'>" +
              "<a class='btn dropdown-toggle" + size + "' data-toggle='dropdown' href='#' tabindex='-1'>" +
                "<span class='current-color'>" + locale.colours.black + "</span>&nbsp;<b class='caret'></b>" +
              "</a>" +
              "<ul class='dropdown-menu'>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='black'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='black'>" + locale.colours.black + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='silver'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='silver'>" + locale.colours.silver + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='gray'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='gray'>" + locale.colours.gray + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='maroon'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='maroon'>" + locale.colours.maroon + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='red'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='red'>" + locale.colours.red + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='purple'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='purple'>" + locale.colours.purple + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='green'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='green'>" + locale.colours.green + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='olive'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='olive'>" + locale.colours.olive + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='navy'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='navy'>" + locale.colours.navy + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='blue'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='blue'>" + locale.colours.blue + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='orange'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='orange'>" + locale.colours.orange + "</a></li>" +
              "</ul>" +
            "</li>";
        }
    };

    var templates = function(key, locale, options) {
        return tpl[key](locale, options);
    };


    var Wysihtml5 = function(el, options) {
        this.el = el;
        var toolbarOpts = options || defaultOptions;
        for(var t in toolbarOpts.customTemplates) {
          tpl[t] = toolbarOpts.customTemplates[t];
        }
        this.toolbar = this.createToolbar(el, toolbarOpts);
        this.editor =  this.createEditor(options);

        window.editor = this.editor;

        $('iframe.wysihtml5-sandbox').each(function(i, el){
            $(el.contentWindow).off('focus.wysihtml5').on({
                'focus.wysihtml5' : function(){
                    $('li.dropdown').removeClass('open');
                }
            });
        });
    };

    Wysihtml5.prototype = {

        constructor: Wysihtml5,

        createEditor: function(options) {
            options = options || {};
            
            // Add the toolbar to a clone of the options object so multiple instances
            // of the WYISYWG don't break because "toolbar" is already defined
            options = $.extend(true, {}, options);
            options.toolbar = this.toolbar[0];

            var editor = new wysi.Editor(this.el[0], options);

            if(options && options.events) {
                for(var eventName in options.events) {
                    editor.on(eventName, options.events[eventName]);
                }
            }
            return editor;
        },

        createToolbar: function(el, options) {
            var self = this;
            var toolbar = $("<ul/>", {
                'class' : "wysihtml5-toolbar",
                'style': "display:none"
            });
            var culture = options.locale || defaultOptions.locale || "en";
            for(var key in defaultOptions) {
                var value = false;

                if(options[key] !== undefined) {
                    if(options[key] === true) {
                        value = true;
                    }
                } else {
                    value = defaultOptions[key];
                }

                if(value === true) {
                    toolbar.append(templates(key, locale[culture], options));

                    if(key === "html") {
                        this.initHtml(toolbar);
                    }

                    if(key === "link") {
                        this.initInsertLink(toolbar);
                    }

                    if(key === "image") {
                        this.initInsertImage(toolbar);
                    }
					
					if (key == "format-code") {
                        this.initFormatCode(toolbar);
                    }
					
					if(key === "video") {
                        this.initInsertVideo(toolbar);
                    }
                }
            }

            if(options.toolbar) {
                for(key in options.toolbar) {
                    toolbar.append(options.toolbar[key]);
                }
            }

            toolbar.find("a[data-wysihtml5-command='formatBlock']").click(function(e) {
                var target = e.target || e.srcElement;
                var el = $(target);
                self.toolbar.find('.current-font').text(el.html());
            });

            toolbar.find("a[data-wysihtml5-command='foreColor']").click(function(e) {
                var target = e.target || e.srcElement;
                var el = $(target);
                self.toolbar.find('.current-color').text(el.html());
            });

            this.el.before(toolbar);

            return toolbar;
        },

        initHtml: function(toolbar) {
            var changeViewSelector = "a[data-wysihtml5-action='change_view']";
            toolbar.find(changeViewSelector).click(function(e) {
                toolbar.find('a.btn').not(changeViewSelector).toggleClass('disabled');
            });
        },
		
		initFormatCode: function (toolbar) {
            var self = this;
            var formatCodeSelector = "a[data-wysihtml5-action='formatCode']";
            toolbar.find(formatCodeSelector).click(function (e) {
                self.editor.composer.commands.exec("formatCode");
            });
        },
		
		initInsertVideo: function(toolbar) {
            var self = this;
            var insertVideoModal = toolbar.find('.bootstrap-wysihtml5-insert-video-modal');
            var urlInput = insertVideoModal.find('.bootstrap-wysihtml5-insert-video-url');
            var insertButton = insertVideoModal.find('a.btn-primary');
            var errorSpan = insertVideoModal.find('.video-error');
			var caretBookmark;

            var insertVideo = function() {
                errorSpan.hide();
                //urlInput.parent().removeClass('error');
                var linkUrl = urlInput.val();
                var embedUrl = linkUrl;

                if ( linkUrl.substr(0,32) == 'https://www.youtube.com/watch?v=' ) {
                    var linkParams = linkUrl.substr(32);
                    embedUrl = 'https://www.youtube.com/embed/' + linkParams.split('&')[0];

                    urlInput.val(linkUrl);
                    self.editor.currentView.element.focus();
                    self.editor.composer.commands.exec("insertVideo", { src: embedUrl });
                } else {
                    errorSpan.show();
                    //urlInput.parent().addClass('error');
                    return false;
                }
            };

            urlInput.keypress(function(e) {
                if(e.which == 13) {
                    insertVideo();
                    insertVideoModal.modal('hide');
                }
            });

            insertButton.click(insertVideo);

            insertVideoModal.on('shown', function() {
                urlInput.focus();
            });

            insertVideoModal.on('hide', function() {
                self.editor.currentView.element.focus();
            });

            toolbar.find('a[data-wysihtml5-command=insertVideo]').click(function() {
                var activeButton = $(this).hasClass("wysihtml5-command-active");

                if (!activeButton) {
                    self.editor.currentView.element.focus(false);
                    caretBookmark = self.editor.composer.selection.getBookmark();
                    insertVideoModal.appendTo('body').modal('show');
                    insertVideoModal.on('click.dismiss.modal', '[data-dismiss="modal"]', function(e) {
                        e.stopPropagation();
                    });
                    return false;
                }
                else {
                    return true;
                }
            });
        },

        initInsertImage: function(toolbar) {
            var self = this;
            var insertImageModal = toolbar.find('.bootstrap-wysihtml5-insert-image-modal');
            //var urlInput = insertImageModal.find('.bootstrap-wysihtml5-insert-image-url');
            var insertButton = insertImageModal.find('a.btn-primary');
            //var initialValue = urlInput.val();
            var caretBookmark;

            var insertImage = function() {
				//var url = urlInput.val();
                //urlInput.val(initialValue);
                self.editor.currentView.element.focus();
                if (caretBookmark) {
                  self.editor.composer.selection.setBookmark(caretBookmark);
                  caretBookmark = null;
                }
				var urlInput = document.querySelector('.bootstrap-wysihtml5-insert-image-url').files[0];
				InsertImageBase64(self.editor, urlInput);
            };

            // urlInput.keypress(function(e) {
                // if(e.which == 13) {
                    // insertImage();
                    // insertImageModal.modal('hide');
                // }
            // });

            insertButton.click(insertImage);

            // insertImageModal.on('shown', function() {
                // urlInput.focus();
            // });

            insertImageModal.on('hide', function() {
                self.editor.currentView.element.focus();
            });

            toolbar.find('a[data-wysihtml5-command=insertImage]').click(function() {
                var activeButton = $(this).hasClass("wysihtml5-command-active");

                if (!activeButton) {
                    self.editor.currentView.element.focus(false);
                    caretBookmark = self.editor.composer.selection.getBookmark();
                    insertImageModal.appendTo('body').modal('show');
                    insertImageModal.on('click.dismiss.modal', '[data-dismiss="modal"]', function(e) {
                        e.stopPropagation();
                    });
                    return false;
                }
                else {
                    return true;
                }
            });
        },

        initInsertLink: function(toolbar) {
            var self = this;
            var insertLinkModal = toolbar.find('.bootstrap-wysihtml5-insert-link-modal');
            var urlInput = insertLinkModal.find('.bootstrap-wysihtml5-insert-link-url');
            var targetInput = insertLinkModal.find('.bootstrap-wysihtml5-insert-link-target');
            var insertButton = insertLinkModal.find('a.btn-primary');
            var initialValue = urlInput.val();
            var caretBookmark;

            var insertLink = function() {
                var url = urlInput.val();
                urlInput.val(initialValue);
                self.editor.currentView.element.focus();
                if (caretBookmark) {
                  self.editor.composer.selection.setBookmark(caretBookmark);
                  caretBookmark = null;
                }

                var newWindow = targetInput.prop("checked");
                self.editor.composer.commands.exec("createLink", {
                    'href' : url,
                    'target' : (newWindow ? '_blank' : '_self'),
                    'rel' : (newWindow ? 'nofollow' : '')
                });
            };
            var pressedEnter = false;

            urlInput.keypress(function(e) {
                if(e.which == 13) {
                    insertLink();
                    insertLinkModal.modal('hide');
                }
            });

            insertButton.click(insertLink);

            insertLinkModal.on('shown', function() {
                urlInput.focus();
            });

            insertLinkModal.on('hide', function() {
                self.editor.currentView.element.focus();
            });

            toolbar.find('a[data-wysihtml5-command=createLink]').click(function() {
                var activeButton = $(this).hasClass("wysihtml5-command-active");

                if (!activeButton) {
                    self.editor.currentView.element.focus(false);
                    caretBookmark = self.editor.composer.selection.getBookmark();
                    insertLinkModal.appendTo('body').modal('show');
                    insertLinkModal.on('click.dismiss.modal', '[data-dismiss="modal"]', function(e) {
                        e.stopPropagation();
                    });
                    return false;
                }
                else {
                    return true;
                }
            });
        }
    };

    // these define our public api
    var methods = {
        resetDefaults: function() {
            $.fn.wysihtml5.defaultOptions = $.extend(true, {}, $.fn.wysihtml5.defaultOptionsCache);
        },
        bypassDefaults: function(options) {
            return this.each(function () {
                var $this = $(this);
                $this.data('wysihtml5', new Wysihtml5($this, options));
            });
        },
        shallowExtend: function (options) {
            var settings = $.extend({}, $.fn.wysihtml5.defaultOptions, options || {}, $(this).data());
            var that = this;
            return methods.bypassDefaults.apply(that, [settings]);
        },
        deepExtend: function(options) {
            var settings = $.extend(true, {}, $.fn.wysihtml5.defaultOptions, options || {});
            var that = this;
            return methods.bypassDefaults.apply(that, [settings]);
        },
        init: function(options) {
            var that = this;
            return methods.shallowExtend.apply(that, [options]);
        }
    };

    $.fn.wysihtml5 = function ( method ) {
        if ( methods[method] ) {
            return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
        } else if ( typeof method === 'object' || ! method ) {
            return methods.init.apply( this, arguments );
        } else {
            $.error( 'Method ' +  method + ' does not exist on jQuery.wysihtml5' );
        }    
    };

    $.fn.wysihtml5.Constructor = Wysihtml5;

    var defaultOptions = $.fn.wysihtml5.defaultOptions = {
        "font-styles": true,
        "color": false,
        "emphasis": true,
        "lists": true,
        "html": false,
        "link": true,
        "image": true,
		"format-code": false,
		"video": true,
        events: {},
        parserRules: {
            classes: {
                // (path_to_project/lib/css/wysiwyg-color.css)
                "wysiwyg-color-silver" : 1,
                "wysiwyg-color-gray" : 1,
                "wysiwyg-color-white" : 1,
                "wysiwyg-color-maroon" : 1,
                "wysiwyg-color-red" : 1,
                "wysiwyg-color-purple" : 1,
                "wysiwyg-color-fuchsia" : 1,
                "wysiwyg-color-green" : 1,
                "wysiwyg-color-lime" : 1,
                "wysiwyg-color-olive" : 1,
                "wysiwyg-color-yellow" : 1,
                "wysiwyg-color-navy" : 1,
                "wysiwyg-color-blue" : 1,
                "wysiwyg-color-teal" : 1,
                "wysiwyg-color-aqua" : 1,
                "wysiwyg-color-orange" : 1
            },
            tags: {
                "b":  {},
                "i":  {},
                "br": {},
                "ol": {},
                "ul": {},
                "li": {},
                "h1": {},
                "h2": {},
                "h3": {},
                "h4": {},
                "h5": {},
                "h6": {},
                "blockquote": {},
                "u": 1,
                "img": {
                    "check_attributes": {
                        "width": "numbers",
                        "alt": "emojione",
                        "src": "emojione",
                        "height": "numbers",
						"class": "alt",
						"title": "alt"
                    }
                },
                "a":  {
                    "check_attributes": {
                        'href': "url", // important to avoid XSS
                        'rel': 'alt'
                    },
					"set_attributes":{
                        "target":"_blank",
                    }
                },
                "span": 
				{
					"check_attributes": 
					{
                        "class": "alt"
                    }
				},
                "div": 
				{
					"check_attributes": 
					{
                        "class": "alt"
                    }
				},
                // to allow save and edit files with code tag hacks
                "code": 
				{
					"check_attributes": 
					{
                        "class": "alt"
                    }
				},
                "pre": 
				{
					"check_attributes": 
					{
                        "class": "alt"
                    }
					
				},
				"iframe": {
                    "check_attributes": {
                        "src":"url",
                        "width":"numbers",
                        "height":"numbers"
                    },
                    "set_attributes":{
                        "frameborder":"0",
						"class":"embed-responsive-item"
                    }
                },
            }
        },
        //stylesheets: ["../../../assets/global/plugins/bower_components/bootstrap-wysihtml5/lib/css/wysiwyg-color.css"], // (path_to_project/lib/css/wysiwyg-color.css)
        locale: "en"
    };

    if (typeof $.fn.wysihtml5.defaultOptionsCache === 'undefined') {
        $.fn.wysihtml5.defaultOptionsCache = $.extend(true, {}, $.fn.wysihtml5.defaultOptions);
    }

    var locale = $.fn.wysihtml5.locale = {
        en: {
            font_styles: {
                normal: "Normal text",
                h1: "Heading 1",
                h2: "Heading 2",
                h3: "Heading 3",
                h4: "Heading 4",
                h5: "Heading 5",
                h6: "Heading 6"
            },
            emphasis: {
                bold: "Bold",
                italic: "Italic",
                underline: "Underline"
            },
            lists: {
                unordered: "Unordered list",
                ordered: "Ordered list",
                outdent: "Outdent",
                indent: "Indent"
            },
            link: {
                insert: "Insert link",
                cancel: "Cancel",
                target: "Open link in new window"
            },
            image: {
                insert: "Insert image",
                cancel: "Cancel"
            },
            html: {
                edit: "Edit HTML"
            },
            colours: {
                black: "Black",
                silver: "Silver",
                gray: "Grey",
                maroon: "Maroon",
                red: "Red",
                purple: "Purple",
                green: "Green",
                olive: "Olive",
                navy: "Navy",
                blue: "Blue",
                orange: "Orange"
            },
			formatCode: {
                highlight: "Highlight Code"
            },
			video: {
                insert: "Insert YouTube Video",
                cancel: "Cancel",
                invalid: "invalid video URL"
            },
        }
    };

}(window.jQuery, window.wysihtml5);




/** Insert Video Functions 
 * 
 */ 

(function(wysihtml5) {
    var NODE_NAME = "IFRAME";

    wysihtml5.commands.insertVideo = {
        /**
         * @example
         *    // either ...
         *    wysihtml5.commands.insertVideo.exec(composer, 'insertVideo', 'http://www.youtube.com/embed/Hx_rRirV2vc');
         *    // ... or ...
         *    wysihtml5.commands.insertVideo.exec(composer, 'insertVideo', { src: 'http://www.youtube.com/embed/Hx_rRirV2vc', width: '560', height: '315' });
         */
        exec: function(composer, command, value) {
            value = typeof(value) === "object" ? value : { src: value };
            var doc   = composer.doc,
                video = this.state(composer),
                i,
                parent;

            if (video) {
                // Video already selected, set the caret before it and delete it
                composer.selection.setBefore(video);
                parent = video.parentNode;
                parent.removeChild(video);

                // and it's parent <a> too if it hasn't got any other relevant child nodes
                wysihtml5.dom.removeEmptyTextNodes(parent);
                if (parent.nodeName === "A" && !parent.firstChild) {
                    composer.selection.setAfter(parent);
                    parent.parentNode.removeChild(parent);
                }

                // firefox and ie sometimes don't remove the video handles, even though the video was removed
                wysihtml5.quirks.redraw(composer.element);
                return;
            }

            video = doc.createElement('div');
			video.className = 'embed-responsive embed-responsive-16by9';
			video.appendChild(doc.createElement(NODE_NAME));
			
            for (i in value) 
			{
				console.log(video.children[0]);
                video.children[0][i] = value[i];
            }
			
			composer.selection.insertNode(video);
			
	      	if (wysihtml5.browser.hasProblemsSettingCaretAfterImg()) {
	        	textNode = doc.createTextNode(wysihtml5.INVISIBLE_SPACE);
	        	composer.selection.insertNode(textNode);
	        	composer.selection.setAfter(textNode);
	      	} else 
			{
	        	composer.selection.setAfter(video);
	     	}
        },

        state: function(composer) {
            var doc = composer.doc,
                selectedNode,
                text,
                videosInSelection;

            if (!wysihtml5.dom.hasElementWithTagName(doc, NODE_NAME)) {
                return false;
            }

            selectedNode = composer.selection.getSelectedNode(doc);
            if (!selectedNode) {
                return false;
            }

            if (selectedNode.nodeName === NODE_NAME) {
                // This works perfectly in IE
                return selectedNode;
            }

            if (selectedNode.nodeType !== wysihtml5.ELEMENT_NODE) {
                return false;
            }

            text = composer.selection.getText(doc);
            text = wysihtml5.lang.string(text).trim();
            if (text) {
                return false;
            }

            videosInSelection = composer.selection.getNodes(doc, wysihtml5.ELEMENT_NODE, function(node) {
                return node.nodeName === "IFRAME";
            });

            if (videosInSelection.length !== 1) {
                return false;
            }

            return videosInSelection[0];
        },

        value: function(composer) {
            var video = this.state(composer);
            return video && video.src;
        }
    };
}(wysihtml5));

(function(wysihtml5) {
  wysihtml5.commands.insertEmbedVideo = {
    /**     
     * @example
     *    wysihtml5.commands.insertEmbedVideo.exec(element, "insertEmbedVideo", "<iframe width="560" height="315" src="http://www.youtube.com/embed/dJfSS0ZXYdo" frameborder="0" allowfullscreen></iframe>");
     */
    exec: function(element, command, value) {
      var code = value.src,
	  attributes = {
	    src: wysihtml5.commands.getAttributeValue.exec(code,"src"),
	    width: wysihtml5.commands.getAttributeValue.exec(code,"width"),
	    height: wysihtml5.commands.getAttributeValue.exec(code,"height")
	  },
	  obj = (Object.create) ? Object.create(attributes) : new Object(attributes); //Object.create doesn't work in IE8
      wysihtml5.commands.insertVideo.exec(element, command, obj);
    },

    state: function(element) {
      wysihtml5.commands.insertVideo.state(element);
    },

    value: function(element) {
      wysihtml5.commands.insertVideo.value(element);
    }
  };
}(wysihtml5));

(function(wysihtml5) {
  wysihtml5.commands.getAttributeValue = {
    exec: function (code,attr){
      return code.substring(parseInt(code.indexOf(attr))+attr.length + 2,code.length).split("\" ")[0];
    }  
  };
}(wysihtml5));

function InsertImageBase64(editor, url)
{
	var file    = url;
	var reader  = new FileReader();

	reader.addEventListener("load", function () 
	{
		editor.composer.commands.exec("insertImage", reader.result);
	}, false);

	if(file) 
	{
		reader.readAsDataURL(file);
	}
}

