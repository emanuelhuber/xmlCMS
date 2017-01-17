jQuery(function() {
    jQuery('.wymeditor').wymeditor({
    
       // html: '<p>Hello, World!<\/p>', //set editor's value
		//skin: 'semanticeditor',
		skin: 'manu',
        stylesheet: '{CssPath}',
		lang: 'fr',
		containersItems: [
        {'name': 'P', 'title': 'Paragraph', 'css': 'wym_containers_p'},
        {'name': 'H1', 'title': 'Heading_1', 'css': 'wym_containers_h1'},
        {'name': 'H2', 'title': 'Heading_2', 'css': 'wym_containers_h2'},
        {'name': 'H3', 'title': 'Heading_3', 'css': 'wym_containers_h3'},
        {'name': 'H4', 'title': 'Heading_4', 'css': 'wym_containers_h4'},
        {'name': 'H5', 'title': 'Heading_5', 'css': 'wym_containers_h5'},
        {'name': 'H6', 'title': 'Heading_6', 'css': 'wym_containers_h6'},
        {'name': 'PRE', 'title': 'Preformatted', 'css': 'wym_containers_pre'},
        {'name': 'BLOCKQUOTE', 'title': 'Blockquote','css': 'wym_containers_blockquote'},
		{'name': 'TH', 'title': 'Table_Header', 'css': 'wym_containers_th'}],
		
		 toolsItems: [
        {'name': 'Bold', 'title': 'Strong', 'css': 'wym_tools_strong'}, 
        {'name': 'Italic', 'title': 'Emphasis', 'css': 'wym_tools_emphasis'},
        {'name': 'Superscript', 'title': 'Superscript', 'css': 'wym_tools_superscript'},
		{'name': 'Subscript', 'title': 'Subscript', 'css': 'wym_tools_subscript'},
        {'name': 'InsertOrderedList', 'title': 'Ordered_List', 'css': 'wym_tools_ordered_list'},
        {'name': 'InsertUnorderedList', 'title': 'Unordered_List', 'css': 'wym_tools_unordered_list'},
        {'name': 'Indent', 'title': 'Indent', 'css': 'wym_tools_indent'},
        {'name': 'Outdent', 'title': 'Outdent', 'css': 'wym_tools_outdent'},
        {'name': 'Undo', 'title': 'Undo', 'css': 'wym_tools_undo'},
        {'name': 'Redo', 'title': 'Redo', 'css': 'wym_tools_redo'},
        {'name': 'CreateLink', 'title': 'Link', 'css': 'wym_tools_link'},
        {'name': 'Unlink', 'title': 'Unlink', 'css': 'wym_tools_unlink'},
        {'name': 'InsertImage', 'title': 'Image', 'css': 'wym_tools_image'},
        {'name': 'InsertTable', 'title': 'Table', 'css': 'wym_tools_table'},
        {'name': 'Paste', 'title': 'Paste_From_Word', 'css': 'wym_tools_paste'},
        {'name': 'ToggleHtml', 'title': 'HTML', 'css': 'wym_tools_html'},
        {'name': 'Preview', 'title': 'Preview', 'css': 'wym_tools_preview'},
		{'name': 'Plugin', 'title': 'Plugin', 'css': 'wym_tools_plugin'},
        {'name': 'Wrap', 'title': 'Wrap', 'css': 'wym_tools_wrap'},
        {'name': 'Unwrap', 'title': 'Unwrap', 'css': 'wym_tools_unwrap'},
        {'name': 'Specialchar', 'title': 'Specialchar', 'css': 'wym_tools_spechar'},
        {'name': 'image_float_left', 'title': 'image_float_left', 'css': 'wym_tools_image_float_left'},
        {'name': 'image_float_right', 'title': 'image_float_right', 'css': 'wym_tools_image_float_right'},
        {'name': 'image_float_none', 'title': 'image_float_none', 'css': 'wym_tools_image_float_none'}
		],
		
		dialogFeatures:    "menubar=no,titlebar=no,toolbar=no,resizable=yes"
                      + ",width=560,height=560,top=0,left=0,scrollbars=yes",
					  
		dialogFeaturesPreview: "menubar=no,titlebar=no,toolbar=no,resizable=no"
                      + ",scrollbars=yes,width=560,height=560,top=0,left=0",
		

		dialogHtml:      '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" \n'
				  + ' "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\n'
				  + '<html xmlns="http://www.w3.org/1999/xhtml" dir="'
                  + WYMeditor.DIRECTION
                  + '">'
				  + '<head>'
				  + '<title>'
				  + WYMeditor.DIALOG_TITLE
				  + '</title>\n'
				  + '<link rel="stylesheet" type="text/css" media="screen" href="' + WYMeditor.CSS_PATH + '" />\n'
				  + '<script language="javascript" type="text/javascript" src="' + WYMeditor.JQUERY_PATH + '"></script>\n'
				  + '<script language="javascript" type="text/javascript" src="' + WYMeditor.WYM_PATH + '"></script>\n'
				  + '</head>\n'
				  + WYMeditor.DIALOG_BODY
				  + '</html>',
				  
		dialogLinkHtml:  "<body class='wym_dialog wym_dialog_link'"
               + " onload='WYMeditor.INIT_DIALOG(" + WYMeditor.INDEX + ")'"
               + ">"
			   // + '<p>ATTENTION : pour un lien externe, par exemple "lemonde.fr", '
			   // + 'il faut écrire "http://lemonde.fr"</p>'
			   // + '<p>Pour un lien interne "http://www.monsite/mapage.html", "mapage.html" suffit</p>'
               + "<form>"
               + "<fieldset>"
               + "<input type='hidden' class='wym_dialog_type' value='"
               + WYMeditor.DIALOG_LINK
               + "' />"
               + "<legend>{Link}</legend>"
               + "<div class='row'>"
               + "<label>{URL}</label>"
               + '<input type="text" class="wym_href" value="http://" size="40" />'
               + "</div>"
               + "<div class='row'>"
               + "<label>{Title}</label>"
               + "<input type='text' class='wym_title' value='' size='40' />"
               + "</div>"
               + "<div class='row row-indent'>"
               + "<input class='wym_submit' type='button'"
               + " value='{Submit}' />"
               + "<input class='wym_cancel' type='button'"
               + "value='{Cancel}' />"
               + "</div>"
               + "</fieldset>"
               + "</form>"
			   + '<div id="linkMisc"><h2>Loading links, please wait...</h2></div>'
			   //+ '<script language="javascript" type="text/javascript" src="{LIB_PATH}jquery-1.2.3.pack.js"></script>\n'
			   + '<script language="javascript" type="text/javascript" src="{LIB_PATH}link.js"></script>\n'
               + "</body>",
			   
		dialogImageHtml: '<body class="wym_dialog wym_dialog_image"\n'
               + ' onload="WYMeditor.INIT_DIALOG(' + WYMeditor.INDEX + ')"\n'
               + '>\n'
               + '<form>\n'
               + '<fieldset>\n'
               + '<input type="hidden" class="wym_dialog_type" value="'
               + WYMeditor.DIALOG_IMAGE
               + '" />'
               + '<legend>{Image}</legend>'
               + '<div class="row">'
               + '<label>{URL}</label>'
               + '<input type="text" class="wym_src" value="" size="40" />'
               + '</div>'
               + '<div class="row">'
               + '<label>{Alternative_Text}</label>'
               + '<input type="text" class="wym_alt" value="" size="40" />'
               + '</div>'
               + '<div class="row">'
               + '<label>{Title}</label>'
               + '<input type="text" class="wym_title" value="" size="40" />'
               + '</div>'
               + '<div class="row row-indent">'
               + '<input class="wym_submit" type="button"'
               + ' value="{Submit}" />'
               + '<input class="wym_cancel" type="button"'
               + 'value="{Cancel}" />'
               + '</div>'
               + '</fieldset>'
               + '</form>'
			   + '<div id="gallery"><h2>Loading images, please wait...</h2></div>'
			   + '<script language="javascript" type="text/javascript" src="{LIB_PATH}jquery-1.2.3.pack.js"></script>\n'
			   + '<script language="javascript" type="text/javascript" src="{LIB_PATH}image.js"></script>\n'
               + '</body>',
		
		
		
        postInit: function(wym) {
		///////////////////////////////////////
		// BUTTON PLUGIN
            wym.hovertools();
			wym.resizable();
			//wym.semantic();
			//wym.tidy();

            //add the button to the tools box
            // jQuery(wym._box)
            // .find(wym._options.toolsSelector + wym._options.toolsListSelector)
            // .append(html);

            //construct the dialog's html
          var  htmlplug = "<body class='wym_dialog wym_dialog_plugin'"
               + " onload='WYMeditor.INIT_DIALOG(" + WYMeditor.INDEX + ")'"
               + ">"
               + "<form>"
               + "<fieldset>"
               + "<input type='hidden' class='wym_dialog_type' value='"
               + "Plugin"
               + "' />"
               + "<legend>Plugin</legend>"
               + "<div class='row'>"
               + "<label>Référence du plugin</label>"
               + '<input type="text" class="wym_txt" value="" size="40" />'
               + "</div>"
               + "<div class='row'>"
               + "<div class='row row-indent'>"
               + "<input class='wym_submit wym_submit_plugin' type='button'"
               + " value='Submit' />"
               + "<input class='wym_cancel' type='button'"
               + "value='Cancel' />"
               + "</div>"
               + "</fieldset>"
               + "</form>"
			   + '<div id="list_plugin"><h2>Loading list, please wait...</h2></div>'
			   + ' <div class="spacer"> </div>'
			   + '<script language="javascript" type="text/javascript" src="{LIB_PATH}jquery-1.2.3.pack.js"></script>\n'
			   + '<script language="javascript" type="text/javascript" src="{LIB_PATH}plugin.js"></script>\n'
			   + "</body>";

            //handle click event on plugin button
            jQuery(wym._box)
            .find('li.wym_tools_plugin a').click(function() {
                wym.dialog( 'Plugin', null, htmlplug );
                return(false);
            });

            
		///////////////////////////////////////
		// BUTTON SPECIAL CHARACTERS
			//construct the symbol selector's html
			var htmlspechar = "<div id='symbolSelector' style='position: absolute;display: none;width: 100px;background:white;border:1px solid black;font-size:15px;margin:4px;'><span>£</span><span> sdf€ </span></div>";

			jQuery(wym._box).find(wym._options.toolsSelector + wym._options.toolsListSelector).append(htmlspechar);
			//Make the button show/hide the symbol selector
			jQuery(wym._box).find('li.wym_tools_spechar a').click(function() {
				jQuery(wym._box).find('div#symbolSelector').toggle();
				return(false);
			});

			//Paste symbol into document when symbol clicked, then hide symbol selector
			jQuery(wym._box)
			.find('div#symbolSelector span').click(function() {
				/* alert($(this).text());
				var txt = jQuery(body).find('.wym_txt').val(); */
				var txt = $(this).text();
				wym.paste(txt);
				jQuery(wym._box).find('div.symbolSelector').hide(); 
			});
					
		///////////////////////////////////////
		// BUTTON WRAP
			//add the 'Wrap' translation (used here for the dialog's title)
            jQuery.extend(WYMeditor.STRINGS['en'], {
                'Wrap': 'Wrap'
            });
            //construct the dialog's html
            htmlwrap = "<body class='wym_dialog wym_dialog_wrap'"
               + " onload='WYMeditor.INIT_DIALOG(" + WYMeditor.INDEX + ")'"
               + ">"
               + "<form>"
               + "<fieldset>"
               + "<input type='hidden' class='wym_dialog_type' value='"
               + "Wrap"
               + "' />"
               + "<legend>Wrap</legend>"
               + "<div class='row'>"
               + "<label>Type</label>"
               + "<select class='wym_select_inline_element'>"
               + "<option selected value='abbr'>Abbreviation</option>"
               + "<option value='acronym'>Acronym</option>"
               + "<option value='cite'>Citation, reference</option>"
               + "<option value='code'>Code</option>"
               + "<option value='del'>Deleted content</option>"
               + "<option value='ins'>Inserted content</option>"
               + "<option value='span'>Span</option>"
               + "</select>"
               + "</div>"
               + "<div class='row'>"
               + "<label>Title</label>"
               + "<input type='text' class='wym_title' value='' size='40' />"
               + "</div>"
               + "<div class='row row-indent'>"
               + "<input class='wym_submit wym_submit_wrap' type='button'"
               + " value='Submit' />"
               + "<input class='wym_cancel' type='button'"
               + "value='Cancel' />"
               + "</div>"
               + "</fieldset>"
               + "</form>"
               + "</body>";

            //handle click event on wrap button
            jQuery(wym._box)
            .find('li.wym_tools_wrap a').click(function() {
                wym.dialog( 'Wrap', null, htmlwrap );
                return(false);
            });

            //handle click event on unwrap button
            jQuery(wym._box)
            .find('li.wym_tools_unwrap a').click(function() {
                wym.unwrap();
                return(false);
            });
			
		///////////////////////////////////////
		// BOUTONS POUR ALIGNER IMAGE À DROITE, À GAUCHE
			jQuery(wym._box).find('li.wym_tools_image_float_left a').click(function() {
						var container = wym.container();
						$(container).find('img').removeClass('float_left float_right');
						$(container).find('img').addClass('float_left');
						return false;
				});
			jQuery(wym._box).find('li.wym_tools_image_float_right a').click(function() {
						var container = wym.container();
						$(container).find('img').removeClass('float_left float_right');
						$(container).find('img').addClass('float_right');
						return false;
				});
			jQuery(wym._box).find('li.wym_tools_image_float_none a').click(function() {
						var container = wym.container();
						// Here we just remove the classes
						$(container).find('img').removeClass('float_left float_right');
						return false;
				});
		},
		
		 //handle click event on dialog's submit button
        postInitDialog: function( wym, wdw ) {

            //wdw is the dialog's window
            //wym is the WYMeditor instance
            var body = wdw.document.body;
            jQuery( body )
                .find('input.wym_submit_wrap')
                .click(function() {
                    var tag   = jQuery(body).find('.wym_select_inline_element').val();
                    var title = jQuery(body).find('.wym_title').val();

                    wym.wrap( '<' + tag + ' title="' + title + '">', '</' + tag + '>' );
                    wdw.close();
                });
			jQuery( body )
                .find('input.wym_submit_plugin')
                .click(function() {
                    var txt = jQuery(body).find('.wym_txt').val();
                    wym.paste( txt );
                    wdw.close();
                });
        }    
    });
});