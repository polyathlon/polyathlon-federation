<?php

if( $feder_adminPageType == FEDERTableType::PORTFOLIO ){
    require_once( FEDER_CLASSES_DIR_PATH.'/FEDERPortfolioListTable.php');

    //Create an instance of our package class...
    $listTable = new FEDERPortfolioListTable();
}

//Prepare items of our package class...
$listTable->prepare_items();

function featuresListTooltip(){
    $tooltip = "";
    $tooltip .= "<div class=\"feder-tooltip-content\">";
    $tooltip .= "<ul>";
    $tooltip .= "<li>* Do Full Design Adjustments</li>";
    $tooltip .= "<li>* Put Multiple Grids On Pages</li>";
    $tooltip .= "<li>* Setup Masonry, Puzzle, Grid Layouts</li>";
    $tooltip .= "<li>* Embed YouTube, Vimeo & Native Videos</li>";
    $tooltip .= "<li>* Popup iFrame & Google Maps</li>";
    $tooltip .= "<li>* Open Light/Dark/Fixed/Fullscreen Popups</li>";
    $tooltip .= "<li>* 100+ Hover Styles & Animations</li>";
    $tooltip .= "<li>* Allow Category Filtration & Pagination</li>";
    $tooltip .= "<li>* Enable Social Sharing</li>";
    $tooltip .= "<li>* Perform Ajax/Lazy Loading</li>";
    $tooltip .= "<li>* Receive Product Enquiries</li>";
    $tooltip .= "</ul>";
    $tooltip .= "</div>";

    $tooltip = htmlentities($tooltip);
    return $tooltip;
}
?>

<div id="feder-dashboard-wrapper">
    <div id="feder-dashboard-add-new-wrapper">
        <div>
            <?php if ($feder_adminPageType == FEDERTableType::PORTFOLIO) { ?><a id="add-portfolio-button" class='button-secondary add-schedule-button feder-glazzed-btn feder-glazzed-btn-green' href="<?php echo "?page={$feder_adminPage}&action=create&type=".FEDERTableType::PORTFOLIO; ?>" title='Add new portfolio'>+ Portfolio</a><?php }
            else { ?><a id="add-position-button" class='button-secondary add-portfolio-button feder-glazzed-btn feder-glazzed-btn-green' href="<?php echo "?page={$feder_adminPage}&action=create&type=".FEDERTableType::POSITION; ?>" title='Add new position'>+ Position</a><?php } ?>
        </div>
    </div>
<!--    <div><a class='button-secondary upgrade-button feder-tooltip feder-glazzed-btn feder-glazzed-btn-orange' href='--><?php //echo FEDER_PRO_URL ?><!--' title='--><?php //echo featuresListTooltip(); ?><!--'>* UNLOCK ALL FEATURES *</a></div>-->

    <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
    <form id="" method="get">
        <!-- For plugins, we also need to ensure that the form posts back to our current page -->
        <input type="hidden" name="page" value="<?php echo $feder_adminPage ?>" />
        <!-- Now we can render the completed list table -->
        <?php $listTable->display() ?>
    </form>

</div>

<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery(".tablenav.top", jQuery(".wp-list-table .no-items").closest("#feder-dashboard-wrapper")).hide();
    });
</script>