var el = wp.element.createElement,
    registerBlockType = wp.blocks.registerBlockType;

registerBlockType( 'grid-kit-premium/feder-shortcode-block', {
    title: 'Polyathlon Federation',

    icon: 'schedule',

    category: 'common',

    attributes: {
        content: {
            type: 'string',
            source: 'html',
            selector: 'div'
        },
        gridId: {
            type: 'string',
            source: 'attribute',
            selector: 'div',
            attribute: 'data-feder-id'
        }
    },

    edit: function( props ) {
        var updateFieldValue = function( val ) {
            props.setAttributes( { content: '[feder id='+val+']', gridId: val } );
        };
        var options = [];
        for (var i in feder_shortcodes) {
            options.push({label: feder_shortcodes[i].title, value: feder_shortcodes[i].id})
        }
        return el('div', {
            className: props.className
        }, [
            el( 'div', {className: 'feder-block-box'}, [ el( 'div', {className: 'feder-block-label'}, 'Select layout' ), el( 'div', {className: 'feder-block-logo'} )] ),
            el(
                wp.components.SelectControl,
                {
                    label: '',
                    value: props.attributes.gridId,
                    onChange: updateFieldValue,
                    options: options
                }
            )
        ]);
    },
    save: function( props ) {
        return el( 'div', {'data-feder-id': props.attributes.gridId}, props.attributes.content);
    }
} );
