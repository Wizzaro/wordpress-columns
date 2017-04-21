(function() {
    tinymce.PluginManager.add( 'wizzaro_columns', function( editor, url ) {
        var shortcode_tag = wpWizzaroColumns.shortcode.tag;
        var row_shortcode_tag = wpWizzaroColumns.shortcode.row_tag;
        var screens = wpWizzaroColumns.grid.screens;
        var columns = wpWizzaroColumns.grid.columns;

        var column_add_popup_body = [];
        var columns_values = [];

        if ( 'wizzaro_column_empty_size' in columns ) {
            columns_values.push({
                text: columns['wizzaro_column_empty_size'],
                value: 'wizzaro_column_empty_size'
            });
        }

        jQuery.each( columns , function( value, text ) {
            if ( value !== 'wizzaro_column_empty_size' ) {
                columns_values.push({
                    text: text,
                    value: value
                });
            }
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

        editor.addButton( 'wizzaro_row_add', {
			icon: 'wizzaro-grid-add-row',
			tooltip: editor.getLang( 'wizzaro_columns.add_row_button_title' ),
			onclick: function() {
                var content = '[' + row_shortcode_tag + '][/' + row_shortcode_tag + ']';
                editor.insertContent( content );
			}
		});

        editor.addCommand( 'wizzaro_column_add_popup', function( ui, v ) {
            editor.windowManager.open({
                title: editor.getLang('wizzaro_columns.add_button_title'),
                body: column_add_popup_body,
                onsubmit: function( e ) {
                    var content = '[' + shortcode_tag;

                    jQuery.each( screens , function( key, settings ) {
                        if ( jQuery.type( e.data[key] ) === "string" && e.data[key] !== 'wizzaro_column_empty_size' && jQuery.type( columns[e.data[key]] ) === "string" ) {
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
