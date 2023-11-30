<?php

/* Enable debugging */
/*
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);
*/


//***************** Immutable configurations ********************//
define( 'FEDER_ROOT_DIR_NAME', 'polyathlon-federation');
define( 'FEDER_ROOT_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'FEDER_CLASSES_DIR_PATH' , FEDER_ROOT_DIR_PATH.'classes' );
define( 'FEDER_IMAGES_DIR_PATH', FEDER_ROOT_DIR_PATH.'images' );
define( 'FEDER_VIEWS_DIR_PATH', FEDER_ROOT_DIR_PATH.'views' );
define( 'FEDER_ADMIN_VIEWS_DIR_PATH', FEDER_VIEWS_DIR_PATH.'/admin' );
define( 'FEDER_FRONT_VIEWS_DIR_PATH', FEDER_VIEWS_DIR_PATH.'/front' );
define( 'FEDER_PLUGIN_URL'   , plugins_url( FEDER_ROOT_DIR_NAME ) );
define( 'FEDER_CSS_URL'      , FEDER_PLUGIN_URL.'/css' );
define( 'FEDER_JS_URL'       , FEDER_PLUGIN_URL.'/js' );
define( 'FEDER_IMAGES_URL', FEDER_PLUGIN_URL.'/images' );
define( 'FEDER_API_URL', 'https://polyathlon.ru/deliver/api/v1/api.php' );

define( 'FEDER_LICENSE_TYPE', 'free' );
define( 'FEDER_BANNERS_LAST_LOADED_AT', 'feder_banners_last_loaded_at' );
define( 'FEDER_BANNERS_CONTENT', 'feder_banners_content' );

global $wpdb;

define( 'FEDER_PLUGIN_PREFIX', 'feder');
define( 'FEDER_DB_PREFIX'     , $wpdb->prefix.FEDER_PLUGIN_PREFIX.'_' );

define("FEDER_PLUGIN_NAME","Федерация");
define("FEDER_PLUGIN_SLAG","federation");

define("FEDER_SUBMENU_PORTFOLIOS_TITLE","Portfolios");
define("FEDER_SUBMENU_PORTFOLIOS_SLUG","federation-portfolios");

//**************** Configurable configurations *******************//
define( 'FEDER_PRO_URL' , 'http://www.polyathlon.ru/federation' );

//Define table names
define( 'FEDER_TABLE_PORTFOLIOS' , FEDER_DB_PREFIX.'portfolios' );
define( 'FEDER_TABLE_PORTFOLIOS_ID' , 'portfolio_id' );

//Enum simulated classes
abstract class FEDERTableType{
    const PORTFOLIO = 'portfolio';
}

abstract class FEDERDetailsDisplayStyle{
    const none = 'details-none';
    const style01 = 'details01';
    const style02 = 'details02';
    const style03 = 'details03';
    const style04 = 'details04';
    const style05 = 'details05';
    const style06 = 'details06';
    const style07 = 'details07';
    const style08 = 'details08';
    const style09 = 'details09';
    const style10 = 'details10';
    const style11 = 'details11';
    const style12 = 'details12';
    const style13 = 'details13';
    const style14 = 'details14';
    const style15 = 'details15';
    const style16 = 'details16';
    const style17 = 'details17';
    const style18 = 'details18';
    const style19 = 'details19';
    const style20 = 'details20';
    const style21 = 'details21';
    const style22 = 'details22';
    const style23 = 'details23';
    const style24 = 'details24';
    const style25 = 'details25';
    const style26 = 'details26';
    const style27 = 'details27';
    const style28 = 'details28';
    const style29 = 'details29';
    const style30 = 'details30';
    const style31 = 'details31 feder-details-bg';
    const style32 = 'details32 feder-details-bg';
    const style33 = 'details33 feder-details-bg';
    const style34 = 'details34 feder-details-bg';
    const style35 = 'details35 feder-details-bg';
    const style36 = 'details36 feder-details-bg';
    const style37 = 'details37 feder-details-bg';
    const style38 = 'details38 feder-details-bg';
    const style39 = 'details39 feder-details-bg';
    const style40 = 'details40 feder-details-bg';
    const style41 = 'details41 feder-details-bg';
    const style42 = 'details42 feder-details-bg';
    const style43 = 'details43 feder-details-bg';
    const style44 = 'details44 feder-details-bg';

    const dflt = 'details-none';
}

abstract class FEDERPictureHoverStyle{
    const none = 'image-none';
    const style01 = 'image01';
    const style02 = 'image02';
    const style03 = 'image03';
    const style04 = 'image04';
    const style05 = 'image05';
    const style06 = 'image06';
    const style07 = 'image07';

    const dflt = 'image-none';
}

abstract class FEDEROverlayDisplayStyle{
    const none = 'overlay-none';
    const style00 = 'overlay00';
    const style01 = 'overlay01';
    const style02 = 'overlay02';
    const style03 = 'overlay03';
    const style04 = 'overlay04';
    const style05 = 'overlay05';
    const style06 = 'overlay06';
    const style07 = 'overlay07';
    const style08 = 'overlay08';
    const style09 = 'overlay09';
    const style10 = 'overlay10';
    const style11 = 'overlay11';
    const style12 = 'overlay12';
    const style13 = 'overlay13';
    const style14 = 'overlay14';
    const style15 = 'overlay15';
    const style16 = 'overlay16';
    const style17 = 'overlay17';
    const style18 = 'overlay18';
    const style19 = 'overlay19';
    const style20 = 'overlay20';
    const style21 = 'overlay21';
    const style22 = 'overlay22';
    const style23 = 'overlay23';
    const style24 = 'overlay24';
    const style25 = 'overlay25';
    const style26 = 'overlay26';
    const style27 = 'overlay27';

    const dflt = 'overlay-none';
}

abstract class FEDEROverlayButtonsDisplayStyle{
    const none =    'button-none';
    const style01 = 'button01';
    const style02 = 'button02';
    const style03 = 'button03';
    const style04 = 'button04';
    const style05 = 'button05';
    const style06 = 'button06';
    const style07 = 'button07';
    const style08 = 'button08';
    const style09 = 'button09';
    const style10 = 'button10';
    const style11 = 'button11';
    const style12 = 'button12';
    const style13 = 'button13';
    const style14 = 'button14';
    const style15 = 'button15';
    const style16 = 'button16';
    const style17 = 'button17';
    const style18 = 'button18';
    const style19 = 'button19';
    const style20 = 'button20';
    const style21 = 'button21';
    const style22 = 'button22';

    const dflt = 'button-none';
}

abstract class FEDERShareButtonsDisplayStyle{
    const none =    'share-none';
    const style01 = 'share01';
    const style02 = 'share02';
    const style03 = 'share03';
    const style04 = 'share04';
    const style05 = 'share05';
    const style06 = 'share06';
    const style07 = 'share07';
    const style08 = 'share08';
    const style09 = 'share09';
    const style10 = 'share10';
    const style11 = 'share11';
    const style12 = 'share12';
    const style13 = 'share13';
    const style14 = 'share14';
    const style15 = 'share15';
    const style16 = 'share16';
    const style17 = 'share17';
    const style18 = 'share18';
    const style19 = 'share19';
    const style20 = 'share20';
    const style21 = 'share21';
    const style22 = 'share22';
    const style23 = 'share23';
    const style24 = 'share24';

    const dflt = 'share-none';
}

abstract class FEDEROverlayButtonsHoverEffect{
    const none =    '';

    //2D Transitions
    const style01 = 'feder-hvr-grow';
    const style02 = 'feder-hvr-shrink';
    const style03 = 'feder-hvr-pulse';
    const style04 = 'feder-hvr-pulse-grow';
    const style05 = 'feder-hvr-pulse-shrink';
    const style06 = 'feder-hvr-push';
    const style07 = 'feder-hvr-pop';
    const style08 = 'feder-hvr-bounce-in';
    const style09 = 'feder-hvr-bounce-out';
    const style10 = 'feder-hvr-rotate';
    const style11 = 'feder-hvr-grow-rotate';
    const style12 = 'feder-hvr-float';
    const style13 = 'feder-hvr-sink';
    const style14 = 'feder-hvr-bob';
    const style15 = 'feder-hvr-hang';
    const style16 = 'feder-hvr-skew';
    const style17 = 'feder-hvr-skew-forward';
    const style18 = 'feder-hvr-skew-backward';
    const style19 = 'feder-hvr-wobble-horizontal';
    const style20 = 'feder-hvr-wobble-vertical';
    const style21 = 'feder-hvr-wobble-to-bottom-right';
    const style22 = 'feder-hvr-wobble-to-top-right';
    const style23 = 'feder-hvr-wobble-top';
    const style24 = 'feder-hvr-wobble-bottom';
    const style25 = 'feder-hvr-wobble-skew';
    const style26 = 'feder-hvr-wobble-skew';
    const style27 = 'feder-hvr-buzz';
    const style28 = 'feder-hvr-buzz-out';

    //Background Transitions
    const style29 = 'feder-hvr-fade';
    const style30 = 'feder-hvr-sweep-to-right';
    const style31 = 'feder-hvr-sweep-to-left';
    const style32 = 'feder-hvr-sweep-to-bottom';
    const style33 = 'feder-hvr-sweep-to-top';
    const style34 = 'feder-hvr-bounce-to-right';
    const style35 = 'feder-hvr-bounce-to-left';
    const style36 = 'feder-hvr-bounce-to-bottom';
    const style37 = 'feder-hvr-bounce-to-top';
    const style38 = 'feder-hvr-radial-out';
    const style39 = 'feder-hvr-radial-in';
    const style40 = 'feder-hvr-rectangle-in';
    const style41 = 'feder-hvr-rectangle-out';
    const style42 = 'feder-hvr-shutter-in-horizontal';
    const style43 = 'feder-hvr-shutter-out-horizontal';
    const style44 = 'feder-hvr-shutter-in-vertical';
    const style45 = 'feder-hvr-shutter-out-vertical';

    //Underline & Overline Transitions
    const style46 = 'feder-hvr-underline-from-left';
    const style47 = 'feder-hvr-underline-from-center';
    const style48 = 'feder-hvr-underline-from-right';
    const style49 = 'feder-hvr-underline-reveal';
    const style50 = 'feder-hvr-overline-reveal';
    const style51 = 'feder-hvr-overline-from-left';
    const style52 = 'feder-hvr-overline-from-center';
    const style53 = 'feder-hvr-overline-from-right';

    const dflt = '';
}

abstract class FEDERFilterStyle{
    const style1 = 'feder-filter-style-1';
    const style2 = 'feder-filter-style-2';
    const style3 = 'feder-filter-style-3';
    const style4 = 'feder-filter-style-4';
    const style5 = 'feder-filter-style-5';
    const style6 = 'feder-filter-style-6';
    const style7 = 'feder-filter-style-7';
}

abstract class FEDERPaginationStyle{
    const style1 = 'feder-pagination-style-1';
    const style2 = 'feder-pagination-style-2';
    const style3 = 'feder-pagination-style-3';
    const style4 = 'feder-pagination-style-4';
    const style5 = 'feder-pagination-style-5';
    const style6 = 'feder-pagination-style-6';
    const style7 = 'feder-pagination-style-7';
}

//Enum simulated classes
abstract class FEDEROption{

    //Styles & Effects
    const kLayoutType = "kLayoutType";
    const kViewerType = "kViewerType";

    const kDetailsDisplayStyle = "kDetailsDisplayStyle";
    const kPictureHoverEffect = "kPictureHoverEffect";
    const kOverlayDisplayStyle = "kOverlayDisplayStyle";
    const kOverlayButtonsDisplayStyle = "kOverlayButtonsDisplayStyle";
    const kOverlayButtonsHoverEffect = "kOverlayButtonsHoverEffect";
    const kShareButtonsDisplayStyle = "kShareButtonsDisplayStyle";

    //Quality
    const kThumbnailQuality = "kThumbnailQuality";

    //Category filtration
    const kShowCategoryFilters = "kShowCategoryFilters";
    const kFilterStyle = "kFilterStyle";

    //Overlay items
    const kShowTitle = "kShowTitle";
    const kShowDesc = "kShowDesc";
    const kShowOverlay = "kShowOverlay";
    const kShowLinkButton = "kShowLinkButton";
    const kShowExploreButton = "kShowExploreButton";
    const kShowFacebookButton = "kShowFacebookButton";
    const kShowTwitterButton = "kShowTwitterButton";
    const kShowGooglePlusButton = "kShowGooglePlusButton";
    const kShowPinterestButton = "kShowPinterestButton";

    const kLinkIcon = "kLinkIcon";
    const kZoomIcon = "kZoomIcon";
    const kGoIcon = "kGoIcon";

    //Dimensions
    const kLayoutWidth = "kLayoutWidth";
    const kLayoutWidthUnit = "kLayoutWidthUnit";
    const kTileApproxWidth = "kTileApproxWidth";
    const kTileApproxHeight = "kTileApproxHeight";
    const kTileMinWidth = "kTileMinWidth";
    const kTileMargins = "kTileMargins";
    //Alignments
    const kLayoutAlignment = "kLayoutAlignment";
    //Colorization
    const kProgressColor = "kProgressColor";
    const kFiltersColor = "kFiltersColor";
    const kFiltersHoverColor = "kFiltersHoverColor";
    const kTileTitleColor = "kTileTitleColor";
    const kTileDescColor = "kTileDescColor";
    const kTileOverlayColor = "kTileOverlayColor";
    const kTileOverlayOpacity = "kTileOverlayOpacity";
    const kTileIconsColor = "kTileIconsColor";
    const kTileIconsBgColor = "kTileIconsBgColor";

    //Fonts
    const kTileTitleFontSize = "kTileTitleFontSize";
    const kTileDescFontSize = "kTileDescFontSize";
    const kTileTitleAlignment = "kTileTitleAlignment";
    const kTileDescAlignment = "kTileDescAlignment";

    //Other
    const kDirectLinking = "kDirectLinking";
    const kMouseType = "kMouseType";
    const kDescMaxLength = "kDescMaxLength";
    const kLinkTarget = "kLinkTarget";
    const kDisableAlbumStylePresentation = "kDisableAlbumStylePresentation";
    const kEnablePictureCaptions = "kEnablePictureCaptions";
    const kExcludeCoverPicture = "kExcludeCoverPicture";
    const kEnableGridLazyLoad = "kEnableGridLazyLoad";
    const kHideAllCategoryFilter = "kHideAllCategoryFilter";
    const kAllCategoryAlias = "kAllCategoryAlias";
    const kLoadUrlBlank = "kLoadUrlBlank";

    //Pagination
    const kItemsPerPage = "kItemsPerPage";
    const kMaxVisiblePageNumbers = "kMaxVisiblePageNumbers";
    const kEnablePagination = "kEnablePagination";
    const kPaginationAlignment = "kPaginationAlignment";
    const kPaginationStyle = "kPaginationStyle";
    const kPaginationColor = "kPaginationColor";
    const kPaginationHoverColor = "kPaginationHoverColor";
    const kItemsPerPageDefault = 15;
    const kMaxVisiblePageNumbersDefault = 15;

    //Customize CSS & JS
    const kCustomCSS = "kCustomCSS";
    const kCustomJS = "kCustomJS";

    //Extanded options
}

?>
