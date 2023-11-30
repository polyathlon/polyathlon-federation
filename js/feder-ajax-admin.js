function federAjaxGetWithId( pid, action ){
    if( !pid ){
        return null;
    }

    var result;
    var sendData = {
        action: action,
        id: pid,
    };

    jQuery.ajax ( {
            type		:	'get',
            data        :   sendData,
            url			: 	FEDER_AJAX_URL,
            dataType	: 	'json',
            async       :   false,
            success		: 	function( response ){
                result = federAjaxResponseValidate( response );
                if( result ){
                    var federation = response.federation;
                    result = response.federation;
                }
            },
            error: function( response ){
                alert( JSON.stringify( response ) );
                result = null;
            }
     } );

    return result;
}

function federAjaxGet( action ){
    var result;
    var sendData = {
        action: action
    };

    jQuery.ajax( {
            type		:	'get',
            data        :   sendData,
            url			: 	FEDER_AJAX_URL,
            dataType	: 	'json',
            async       :   false,
            success		: 	function( response ){
                result = federAjaxResponseValidate( response );
                if( result ){
                    var federation = response.federation;
                    result = response.federation;
                }
            },
            error: function( response ){
                alert( JSON.stringify( response ) );
                result = null;
            }
    });

    return result;
}

function federAjaxSave( data, action ){
    if( !data ){
        return null;
    }

    var result;
    var sendData = {
        action: action,
        data: JSON.stringify( data ),
    };

    jQuery.ajax ( {
        type		:	'post',
        data        :   sendData,
        url			: 	FEDER_AJAX_URL,
        dataType	: 	'html',
        async       :   false,
        success		:   function( response ){
            try{
                result = JSON.parse( response );
                result = federAjaxResponseValidate( result );
            }catch( error ){
                result = null;
            }
        },
        error: function( response ){
            alert(JSON.stringify( response ));
            result = null;
        }
    } );

    return result;
}

//Helper functions
function federAjaxResponseValidate( response ){
    if( !response ) return null;

    if( response.status != 'success' ){
        alert( JSON.stringify( response.errormsg ) );
        return null;
    }

    return response;
}
