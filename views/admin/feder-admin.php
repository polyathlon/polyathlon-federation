<div class="feder-background">
</div>
<div id="feder-wrap" class="feder-wrap feder-glazzed-wrap">

<?php include_once( FEDER_ADMIN_VIEWS_DIR_PATH.'/feder-header-banner.php' ); ?>

<div class="feder-wrap-main">

    <script>
        FEDER_AJAX_URL = '<?php echo admin_url( 'admin-ajax.php', 'relative' ); ?>';
        FEDER_IMAGES_URL = '<?php echo FEDER_IMAGES_URL ?>';
    </script>

    <?php

    abstract class FEDERTabType{
        const Dashboard = 'dashboard';
        const Settings = 'settings';
        const Help = 'help';
        const Terms = 'terms';
    }

    $feder_tabs = array(
        FEDERTabType::Dashboard => 'All Schedules',
        FEDERTabType::Settings => 'General Settings',
        FEDERTabType::Help => 'User Manual',
    );

    $feder_adminPage = isset( $_REQUEST['page']) ? filter_var($_REQUEST['page'], FILTER_SANITIZE_STRING) : null;
    $feder_currentTab = isset ( $_GET['tab'] ) ? filter_var($_GET['tab'], FILTER_SANITIZE_STRING) : FEDERTabType::Dashboard;
    $feder_action = isset ( $_GET['action'] ) ? filter_var($_GET['action'], FILTER_SANITIZE_STRING) : null;
    $feder_gridType = isset ( $_GET['type'] ) ? filter_var($_GET['type'], FILTER_SANITIZE_STRING) : null;

    include_once(FEDER_ADMIN_VIEWS_DIR_PATH."/feder-admin-modal-spinner.php");
    include_once(FEDER_ADMIN_VIEWS_DIR_PATH."/feder-admin-header.php");

    if($feder_action == 'create' || $feder_action == 'edit'){
        if($feder_gridType == FEDERTableType::PORTFOLIO) {
            include_once(FEDER_ADMIN_VIEWS_DIR_PATH."/feder-admin-portfolio.php");
        }else{
            include_once(FEDER_ADMIN_VIEWS_DIR_PATH."/feder-admin-position.php");
        }

    }else if ($feder_action == 'options'){
        include_once(FEDER_ADMIN_VIEWS_DIR_PATH."/feder-admin-options.php");
    }else{
        //Tabs are not fully developed yet, that's why we have disabled them in this version
        //feder_renderAdminTabs($feder_currentTab, $feder_adminPage, $feder_tabs);

        if($feder_currentTab == FEDERTabType::Dashboard){
            include_once(FEDER_ADMIN_VIEWS_DIR_PATH."/feder-admin-table.php");
        }else if($feder_currentTab == FEDERTabType::Settings){
            include_once(FEDER_ADMIN_VIEWS_DIR_PATH."/feder-admin-settings.php");
        }else if($feder_currentTab == FEDERTabType::Help){
            include_once(FEDER_ADMIN_VIEWS_DIR_PATH."/feder-admin-help.php");
        }
    }

    function feder_renderAdminTabs( $current, $page, $tabs = array()){
        //Hardcoded style for removing dynamically added bottom-border
        echo '<h2 class="nav-tab-wrapper feder-admin-nav-tab-wrapper" style="border: 0px">';

        foreach ($tabs as $tab => $name) {
            $class = ($tab == $current) ? 'nav-tab-active' : '';
            echo "<a class='nav-tab $class' href='?page=$page&tab=$tab'>$name</a>";
        }
        echo '</h2>';
    }

    ?>
    <div style="clear:both;"></div>
</div>
</div>
