(function() {
    tinymce.PluginManager.add('feder_tc_buttons', function( editor, url ) {
        var menuItems = new Array();
        for (var i = 0; i < feder_shortcodes.length; i++){
            var shortcode = feder_shortcodes[i];

            item = {
               text: shortcode.title,
               value: shortcode.shortcode,
               onclick: function() {
                   editor.insertContent(this.value());
               }
            };
            menuItems.push(item);
        }

        editor.addButton( 'feder_insert_tc_button', {
            text: 'Polyathlon Federation',
            icon: 'icon dashicons-before dashicons-schedule',
            type: 'menubutton',
            menu: menuItems
        });
    });
})();