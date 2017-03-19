(function() {
    tinymce.PluginManager.add( 'wizzaro_columns', function( editor, url ) {
        var shortcode_tag = wpWizzaroColumns.shortcode.tag;
        var screens = wpWizzaroColumns.grid.screens;
        var columns = wpWizzaroColumns.grid.columns;

        var column_add_popup_body = [];
        var columns_values = [];

        jQuery.each( columns , function( value, text ) {
            columns_values.push({
                text: text,
                value: value
            });
        });

        jQuery.each( screens , function( key, settings ) {
            column_add_popup_body.push({
                type: 'listbox',
                name: key,
                label: settings.label,
                values: columns_values
            });
        });

        column_add_popup_body.push({
            type: 'checkbox',
            name: 'last_column_in_row',
            label: editor.getLang( 'wizzaro_columns.last_column_in_row' ),
        });

        //Editor functions

		editor.addButton( 'wizzaro_column_add', {
			icon: 'wizzaro-grid-add-column',
			tooltip: editor.getLang( 'wizzaro_columns.add_button_title' ),
			onclick: function() {
				editor.execCommand( 'wizzaro_column_add_popup' );
			}
		});

        editor.addCommand( 'wizzaro_column_add_popup', function( ui, v ) {
            editor.windowManager.open({
                title: editor.getLang('wizzaro_columns.add_button_title'),
                body: column_add_popup_body,
                onsubmit: function( e ) {
                    var content = '[' + shortcode_tag;

                    jQuery.each( screens , function( key, settings ) {
                        if ( jQuery.type( e.data[key] ) === "string" && jQuery.type( columns[e.data[key]] ) === "string" ) {
                            content += ' ' + key + '="' + e.data[key] + '"';
                        }
                    });

                    if ( e.data.last_column_in_row === true ) {
                        content += ' last_column_in_row="true"';
                    }

                    content += '][/' + shortcode_tag + ']';

                    editor.insertContent( content );
                }
            });
        });
    });
})();
