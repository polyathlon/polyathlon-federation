<?php

//Helper functions
function feder_ajax_return( $response ){
    echo  json_encode( $response );
    die();
}

function wp_ajax_feder_get_portfolio(){
    global $wpdb;
    $response = new stdClass();

    if( !isset($_GET['id']) ){
        $response->status = 'error';
        $response->errormsg = 'Invalid portfolio identifier!';
        feder_ajax_return($response);
    }

    $pid = (int)$_GET['id'];
    $query = $wpdb->prepare("SELECT * FROM ".FEDER_TABLE_PORTFOLIOS." WHERE ".FEDER_TABLE_PORTFOLIOS_ID." = %d", $pid);
    $res = $wpdb->get_results( $query , OBJECT );

    if( count($res) ){
        $portfolio = $res[0];
        $response->status = 'success';
        $response->federation = $portfolio;
    }else{
        $response->status = 'error';
        $response->errormsg = 'Unknown portfolio identifier!';
    }

    feder_ajax_return($response);
}

function wp_ajax_feder_save_portfolio() {
    global $wpdb;
    $response = new stdClass();

    if( !isset($_POST['data']) ){
        $response->status = 'error';
        $response->errormsg = 'Invalid portfolio passed!';
        feder_ajax_return( $response );
    }

    //Convert to stdClass object
    $portfolio = json_decode( stripslashes( $_POST['data']), true );

    $pid = isset($portfolio[FEDER_TABLE_PORTFOLIOS_ID]) ? (int)$portfolio[FEDER_TABLE_PORTFOLIOS_ID] : 0;

    //Insert if portfolio is draft yet
    if(isset($portfolio['isDraft']) && (int)$portfolio['isDraft']){
        $title = isset($portfolio['title']) ? filter_var($portfolio['title'], FILTER_SANITIZE_STRING) : "";
        $image = isset($portfolio['image']) ? filter_var($portfolio['image'], FILTER_SANITIZE_STRING) : "";
        $full_name = isset($portfolio['full_name']) ? filter_var($portfolio['full_name'], FILTER_SANITIZE_STRING) : "";
        $e_mail = isset($portfolio['e_mail']) ? filter_var($portfolio['e_mail'], FILTER_SANITIZE_STRING) : "";
        $phone = isset($portfolio['phone']) ? filter_var($portfolio['phone'], FILTER_SANITIZE_STRING) : "";
        $address = isset($portfolio['address']) ? filter_var($portfolio['address'], FILTER_SANITIZE_STRING) : "";
        $other = isset($portfolio['other']) ? filter_var($portfolio['other'], FILTER_SANITIZE_STRING) : "";

        $wpdb->insert(
            FEDER_TABLE_PORTFOLIOS,
            array(
                'title' => $title,
                'image' => $image,
                'full_name' => $full_name,
                'e_mail' => $e_mail,
                'phone' => $phone,
                'address' => $address,
                'other' => $other,
            ),
            array(
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
            )
        );

        //Get real identifier and use it instead of draft identifier for tmp usage
        $pid = $wpdb->insert_id;
    }

    $title = isset($portfolio['title']) ? filter_var($portfolio['title'], FILTER_SANITIZE_STRING) : "";
    $image = isset($portfolio['image']) ? filter_var($portfolio['image'], FILTER_SANITIZE_STRING) : "";
    $full_name = isset($portfolio['full_name']) ? filter_var($portfolio['full_name'], FILTER_SANITIZE_STRING) : "";
    $e_mail = isset($portfolio['e_mail']) ? filter_var($portfolio['e_mail'], FILTER_SANITIZE_STRING) : "";
    $phone = isset($portfolio['phone']) ? filter_var($portfolio['phone'], FILTER_SANITIZE_STRING) : "";
    $address = isset($portfolio['address']) ? filter_var($portfolio['address'], FILTER_SANITIZE_STRING) : "";
    $other = isset($portfolio['other']) ? filter_var($portfolio['other'], FILTER_SANITIZE_STRING) : "";

    $wpdb->update(
        FEDER_TABLE_PORTFOLIOS,
        array(
            'title' => $title,
            'image' => $image,
            'full_name' => $full_name,
            'e_mail' => $e_mail,
            'phone' => $phone,
            'address' => $address,
            'other' => $other,
        ),
        array( FEDER_TABLE_PORTFOLIOS_ID => $pid ),
        array(
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
        ),
        array(
            '%d',
        )
    );

    $response->status = 'success';
    $response->pid = $pid;
    feder_ajax_return($response);
}
