


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
        {'name': 'Specialchar', 'title': 'Specialchar', 'css': 'wym_tools_spechar'}
		],
		
		dialogFeatures:    "menubar=no,titlebar=no,toolbar=no,resizable=yes"
                      + ",width=560,height=400,top=0,left=0,scrollbars=yes",
		dialogFeaturesPreview: "menubar=no,titlebar=no,toolbar=no,resizable=no"
                      + ",scrollbars=yes,width=560,height=300,top=0,left=0",
		

		    dialogHtml:      '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" \n'
                      + ' "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\n'
                      + '<html xmlns="http://www.w3.org/1999/xhtml">\n<head>\n'
                      + '<title>'
                      + WYMeditor.DIALOG_TITLE
                      + '</title>\n'
					  + '<script language="javascript" type="text/javascript" src="' + WYMeditor.JQUERY_PATH + '"></script>\n'
					  + '<script language="javascript" type="text/javascript" src="' + WYMeditor.WYM_PATH + '"></script>\n'
					  + '<script language="javascript" type="text/javascript" src="{LIB_PATH}jcarousel/jquery-1.2.3.pack.js"></script>\n'
					  + '<script language="javascript" type="text/javascript" src="{LIB_PATH}jcarousel/jquery.jcarousel.pack.js"></script>\n'
					  + '<script language="javascript" type="text/javascript" src="{LIB_PATH}jcarousel/jquery.imager.js"></script>\n'
					  + '<script language="javascript" type="text/javascript" src="{LIB_PATH}plugin.js"></script>\n'
                      + '<link rel="stylesheet" type="text/css" media="screen" href="' + WYMeditor.CSS_PATH + '" />\n'
					  + '<link rel="stylesheet" type="text/css" media="screen" href="{LIB_PATH}jcarousel/css/jquery.jcarousel.css" />\n'
					  + '<link rel="stylesheet" type="text/css" media="screen" href="{LIB_PATH}jcarousel/css/skins/tango/skin.css" />\n'
					  + '<style type="text/css">\n'
					  + '// <![CDATA[\n'
					  + '.jcarousel-skin-tango .jcarousel-container-horizontal {\n'
					  + 'width: 85%;\n'
					  + '}\n'
					  + '.jcarousel-skin-tango .jcarousel-clip-horizontal {\n'
					  + 'width: 100%;\n'
					  +	'}\n'
					  + '//]]>\n'
					  + '</style>\n'
					  + '</head>\n'
                      + WYMeditor.DIALOG_BODY
                      + '</html>',
		
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
               + '</body>', 
		
		
		
        postInit: function(wym) {
		///////////////////////////////////////
		// BUTTON PLUGIN

            //add the button to the tools box
            jQuery(wym._box)
            .find(wym._options.toolsSelector + wym._options.toolsListSelector)
            .append(html);


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
			/* 
			
 */
			var html = "<div id='symbolSelector' style='position: absolute;display: none;width: 100px;background:white;border:1px solid black;font-size:15px;margin:4px;'><span>£</span><span> sdf€ </span></div>";
			//add the button to the tools box
		/* 	
 */
		jQuery(wym._box).find(wym._options.toolsSelector + wym._options.toolsListSelector).append(html);
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

            //set the editor's content
            //wym.html("<p>This is some text with which to test.</p>"
            //       + "<p>Select 'some text' and click on the Wrap button.</p>"
             //      + "<p>Select it again and click on the Unwrap button.</p>");

            //construct the wrap button's html
            //note: the button image needs to be created ;)
           /*  var html = "<li class='wym_tools_wrap'>"
                     + "<a href='#'"
                     + " title='Wrap'"
                     + " style='background-image:"
                     + " url(" + WYMeditor + "/skins/default/icons.png)'>"
                     + "Wrap"
                     + "</a></li>"; */
            jQuery(wym._box)
            .find(wym._options.toolsSelector + wym._options.toolsListSelector)
            .append(html);

            //construct the dialog's html
            html = "<body class='wym_dialog wym_dialog_wrap'"
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
               + "<option value='span'>Generic</option>"
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
                wym.dialog( 'Wrap', null, html );
                return(false);
            });

            //handle click event on unwrap button
            jQuery(wym._box)
            .find('li.wym_tools_unwrap a').click(function() {
                wym.unwrap();
                return(false);
            });
			
			
			wym.resizable();
			//wym.semantic();
			wym.tidy();
            wym.hovertools();

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