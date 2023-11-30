<?php
    global $feder_portfolios;

    //Validation goes here
    if( $feder_portfolios ){
        //Setup ordered projects array
        // $feder_portfolio = getOrderedPortfolios($feder_portfolio);

        require(FEDER_FRONT_VIEWS_DIR_PATH . "/layouts/feder-front-federation.php");

        // if($feder_portfolio->grid_type == FEDERGridType::SLIDER ){
        //     require(FEDER_FRONT_VIEWS_DIR_PATH . "/layouts/feder-front-slider.php");
        // }else{
        //     require_once(FEDER_FRONT_VIEWS_DIR_PATH . "/layouts/feder-front-tiled-layout-lightgallery.php");
        // }

        //Render user specified custom css
        // echo "<style>". $feder_portfolio->options[FEDEROption::kCustomCSS]."</style>";

        //Finally render custom js
        // echo "<script> jQuery(window).load(function() {".$feder_portfolio->options[FEDEROption::kCustomJS]."});</script>";

    }else{
        echo "Ooooops!!! Short-code related federation wasn't found in your database!";
    }


function getOrderedFederPortfolios( $feder_portfolio ){
    $orderedPortfolios = array();

    if(isset($feder_portfolio->projects) && isset($feder_portfolio->corder)){
        foreach($feder_portfolio->corder as $pid){
            $orderedProjects[] = $feder_portfolio->projects[$pid];
        }
    }

    return $orderedProjects;
}
