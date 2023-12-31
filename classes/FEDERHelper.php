<?php

class FEDERHelper {

const API_RC_OK = 'OK';
private static $banners = null;

  static public function shortcodeWithPID($pid){
      return "[id={$pid}]";
  }

  static public function tcButtonShortcodes(){
      global $wpdb;

      $results = $wpdb->get_results( "SELECT * FROM ".FEDER_TABLE_SCHEDULES , ARRAY_A );

      $shortcodes = array();
      for($i=0; $i<count($results); $i++){
          $shortcode = new stdClass();

          $shortcode->id = $results[$i]["id"];
          $shortcode->title = $results[$i]["title"];
          $shortcode->shortcode = FEDERHelper::shortcodeWithPID($results[$i]["id"]);

          $shortcodes[] = $shortcode;
      }

      return $shortcodes;
  }

  static public function getPortfolioWithId($pid){
      if(!$pid) return null;

      global $wpdb;
      $schedule = null;

      $query = $wpdb->prepare("SELECT * FROM ".FEDER_TABLE_PORTFOLIOS." WHERE ".FEDER_TABLE_PORTFOLIOS_ID." = %d", $pid);
      $res = $wpdb->get_results( $query , OBJECT );

      if(count($res)) {
          $schedule = $res[0];

          $query = $wpdb->prepare("SELECT * FROM " . FEDER_TABLE_PROJECTS . " WHERE pid = %d", $pid);
          $res = $wpdb->get_results($query, OBJECT);

          $projects = array();
          foreach ($res as $project) {
              $project->pics = explode(',', $project->pics);
              $project->categories = explode(',', $project->categories);
              $projects[$project->id] = $project;
          }
          $schedule->projects = $projects;
          $schedule->corder = explode(',', $schedule->corder);

          $gridType = FEDERGridType::ALBUM;
          if (!empty($schedule->extoptions)) {
              $extoptions = json_decode($schedule->extoptions);
              if (!empty($extoptions->type)) {
                  $gridType = $extoptions->type;
              }
          }
          $schedule->grid_type = $gridType;

          if($schedule->options && !empty($schedule->options)){
              $schedule->options = json_decode( base64_decode($schedule->options), true);
          }else{
              $schedule->options = json_decode( base64_decode(FEDERHelper::getScheduleDefaultOptions(0, $gridType)), true);
          }
          if(!empty($schedule->extoptions)){
              $schedule->extoptions = json_decode($schedule->extoptions, true);
          } else {
              $schedule->extoptions = array('type' => FEDERGridType::ALBUM);
          }
      }

      return $schedule;
  }


  static public function getPortfolios($pid){
    if( !$pid ) return null;

    global $wpdb;
    $federation = null;
    $query = "SELECT * FROM ".FEDER_TABLE_PORTFOLIOS." WHERE ".FEDER_TABLE_PORTFOLIOS_ID." = ".$pid;

    $federation = $wpdb->get_results( $query , OBJECT );

    if( count($federation) ){
        foreach( $federation as $portfolio ){
            $portfolio->pic = json_decode( base64_decode( $portfolio->image ) );
        }
    }

    return $federation;
}

  static public function getScheduleDefaultOptions($pid = 0, $gridType = FEDERGridType::ALBUM){
      //TODO: Update this each time if any default option is changed

      if ($gridType == FEDERGridType::CLIENT_LOGOS) {
          $options = '{"id":"' . $pid . '","kThumbnailQuality":"large","kShowCategoryFilters":false,"kShowCaptionTitle":false,"kShowCaptionSubtitle":false,"kDisableAlbumStylePresentation":true,"kEnablePictureCaptions":false,"kExcludeCoverPicture":true,"kLinkIcon":"link","kZoomIcon":"search","kGoIcon":"","kLayoutWidth":"100","kLayoutWidthUnit":"%","kTileApproxWidth":"200","kTileApproxHeight":"150","kTileMinWidth":"150","kTileMargins":"4","kLayoutAlignment":"center","kTintColor":"#000000","kProgressColor":"#5c9b30","kFiltersColor":"#969696","kFiltersHoverColor":"#1e73be","kPaginationColor":"#969696","kPaginationHoverColor":"#1e73be","kTileTitleColor":"#ffffff","kTileTitleHoverColor":"#eeee22","kTileDescColor":"#ffffff","kTileDescHoverColor":"#ffffff","kTileOverlayColor":"#000000","kTileOverlayOpacity":"80","kTileIconsColor":"#000000","kTileIconsBgColor":"#ffffff","kTileIconsBgOpacity":"CC","kTileIconsBgHoverColor":"#dd9933","kTileIconsBgHoverOpacity":"E6","kDirectLinking":true,"kLoadUrlBlank":true,"kGoogleMapApiKey":"","kEnableGridLazyLoad":false,"kEnableCategoryAjaxLoad":true,"kCustomJS":"","kCustomCSS":"","kLayoutType":"3","kViewerType":"2","kTileCaptionType":"btn01","kMouseType":"pointer","kItemsPerPage":"' . FEDEROption::kItemsPerPageDefault . '","kEnablePagination":false,"kMaxVisiblePageNumbers":"' . FEDEROption::kMaxVisiblePageNumbersDefault . '","kPaginationAlignment":"right","kPaginationStyle":"feder-pagination-style-1","kDescMaxLength":"15","kTileTitleFontSize":"18","kTileDescFontSize":"11","kTileTitleAlignment":"center","kTileDescAlignment":"center","kShowTitle":false,"kShowDesc":true,"kShowOverlay":false,"kShowLinkButton":true,"kShowExploreButton":false,"kShowFacebookButton":false,"kShowTwitterButton":false,"kShowGooglePlusButton":false,"kShowPinterestButton":false,"kHideAllCategoryFilter":true,"kAllCategoryAlias":"All","kFilterStyle":"feder-filter-style-1","kDetailsDisplayStyle":"details27","kPictureHoverEffect":"image06","kOverlayDisplayStyle":"overlay00","kOverlayButtonsDisplayStyle":"button05","kShareButtonsDisplayStyle":"share20","kOverlayButtonsHoverEffect":""}';
      } elseif ($gridType == FEDERGridType::TEAM) {
          $options = '{"id":"' . $pid . '","kThumbnailQuality":"large","kShowCategoryFilters":false,"kShowCaptionTitle":false,"kShowCaptionSubtitle":false,"kDisableAlbumStylePresentation":true,"kEnablePictureCaptions":false,"kExcludeCoverPicture":true,"kLinkIcon":"link","kZoomIcon":"search","kGoIcon":"","kLayoutWidth":"100","kLayoutWidthUnit":"%","kTileApproxWidth":"200","kTileApproxHeight":"300","kTileMinWidth":"170","kTileMargins":"4","kLayoutAlignment":"center","kTintColor":"#000000","kProgressColor":"#5c9b30","kFiltersColor":"#969696","kFiltersHoverColor":"#1e73be","kPaginationColor":"#969696","kPaginationHoverColor":"#1e73be","kTileTitleColor":"#ffffff","kTileTitleHoverColor":"#eeee22","kTileDescColor":"#ffffff","kTileDescHoverColor":"#ffffff","kTileOverlayColor":"#000000","kTileOverlayOpacity":"80","kTileIconsColor":"#000000","kTileIconsBgColor":"#ffffff","kTileIconsBgOpacity":"CC","kTileIconsBgHoverColor":"#dd9933","kTileIconsBgHoverOpacity":"E6","kDirectLinking":false,"kLoadUrlBlank":true,"kGoogleMapApiKey":"","kEnableGridLazyLoad":false,"kEnableCategoryAjaxLoad":true,"kCustomJS":"","kCustomCSS":"","kLayoutType":"3","kViewerType":"2","kTileCaptionType":"btn01","kMouseType":"pointer","kItemsPerPage":"' . FEDEROption::kItemsPerPageDefault . '","kEnablePagination":false,"kMaxVisiblePageNumbers":"' . FEDEROption::kMaxVisiblePageNumbersDefault . '","kPaginationAlignment":"right","kPaginationStyle":"feder-pagination-style-1","kDescMaxLength":"15","kTileTitleFontSize":"18","kTileDescFontSize":"11","kTileTitleAlignment":"right","kTileDescAlignment":"right","kShowTitle":true,"kShowDesc":true,"kShowOverlay":true,"kShowLinkButton":true,"kShowFacebookLink":true,"kShowLinkedinLink":true,"kShowExploreButton":false,"kShowFacebookButton":false,"kShowTwitterButton":false,"kShowGooglePlusButton":false,"kShowPinterestButton":false,"kHideAllCategoryFilter":true,"kAllCategoryAlias":"All","kFilterStyle":"feder-filter-style-1","kDetailsDisplayStyle":"details03","kPictureHoverEffect":"image05","kOverlayDisplayStyle":"overlay00","kOverlayButtonsDisplayStyle":"button06","kShareButtonsDisplayStyle":"share20","kOverlayButtonsHoverEffect":""}';
      } elseif ($gridType == FEDERGridType::SLIDER) {
          $options = '{"id":"' . $pid . '","kThumbnailQuality":"large","kShowTitle":false,"kShowDesc":false,"kShowArrows":true,"kShowInfoMobile":"false","kShowPagination":false,"kShowPaginationMobile":false,"kEnableGridLazyLoad":false,"kLoadUrlBlank":false,"kTileOverlayOpacity":"A6","kTileTitleFontStyle":"bold","kTileDescFontStyle":"normal","kTileTitleAlignment":"center","kTileDescAlignment":"center","kPaginationColor":"#b1b0b0","kPaginationHoverColor":"#000000","kTileTitleColor":"#ffffff","kTileDescColor":"#ffffff","kTileOverlayColor":"#000000","kCustomJS":"","kCustomCSS":"","kTileApproxHeight":"450","kSliderArrowsTopDistance":"225","kTileMargins": "0", "kTilePaddings": "20","kTileTitleFontSize":"18","kTileDescFontSize":"13","kArrowFontSize":"60","kSliderAutoplay":false,"kSliderAutoHeight":false,"kSliderLoop":false,"kSliderPauseOnHover":false,"kArrowIconStyle":"fa-angle-","kSliderPaginationStyle":"Ovals","kSliderPaginationPosition":"AfterSlider","kSliderTextWidthStyle":"Auto","kArrowBgStyle":"None","kSlideAnimateIn":"","kSlideAnimateOut":"","kSliderTextPosition":"BottomCenter","kArrowBgColor":"#000000","kArrowBgHoverColor":"#000000","kArrowBgOpacity":"A6","kArrowBgHoverOpacity":"BF","kArrowColor":"#e2e2e2","kArrowHoverColor":"#ffffff","kSliderAutoplaySpeed":"5"}';
      } else {
          $options = '{"id":"' . $pid . '","kThumbnailQuality":"large","kShowCategoryFilters":false,"kShowCaptionTitle":false,"kShowCaptionSubtitle":false,"kDisableAlbumStylePresentation":false,"kEnablePictureCaptions":false,"kExcludeCoverPicture":false,"kLinkIcon":"","kZoomIcon":"","kGoIcon":"","kLayoutWidth":"100","kLayoutWidthUnit":"%","kTileApproxWidth":"250","kTileApproxHeight":"250","kTileMinWidth":"200","kTileMargins":"4","kLayoutAlignment":"","kTintColor":"#000000","kProgressColor":"#5c9b30","kFiltersColor":"#969696","kFiltersHoverColor":"#1e73be","kPaginationColor":"#969696","kPaginationHoverColor":"#1e73be","kTileTitleColor":"#ffffff","kTileTitleHoverColor":"#eeee22","kTileDescColor":"#ffffff","kTileDescHoverColor":"#ffffff","kTileOverlayColor":"#000000","kTileOverlayOpacity":"80","kTileIconsColor":"#000000","kTileIconsBgColor":"#ffffff","kTileIconsBgOpacity":"CC","kTileIconsBgHoverColor":"#dd9933","kTileIconsBgHoverOpacity":"E6","kDirectLinking":false,"kLoadUrlBlank":false,"kEnableGridLazyLoad":false,"kCustomJS":"","kCustomCSS":"","kLayoutType":"3","kViewerType":"1","kTileCaptionType":"btn01","kMouseType":"pointer","kItemsPerPage":"' . FEDEROption::kItemsPerPageDefault . '","kEnablePagination":false,"kMaxVisiblePageNumbers":"' . FEDEROption::kMaxVisiblePageNumbersDefault . '","kPaginationAlignment":"","kPaginationStyle":"","kDescMaxLength":"15","kTileTitleFontSize":"18","kTileDescFontSize":"11","kTileTitleAlignment":"center","kTileDescAlignment":"center","kShowTitle":false,"kShowDesc":false,"kShowOverlay":true,"kShowLinkButton":false,"kShowExploreButton":false,"kShowFacebookButton":false,"kShowTwitterButton":false,"kShowGooglePlusButton":false,"kShowPinterestButton":false,"kHideAllCategoryFilter":false,"kAllCategoryAlias":"All","kFilterStyle":"","kDetailsDisplayStyle":"details-none","kPictureHoverEffect":"image-none","kOverlayDisplayStyle":"overlay-none","kOverlayButtonsDisplayStyle":"","kShareButtonsDisplayStyle":"","kOverlayButtonsHoverEffect":""}';
      }

      $options = str_replace("'", '"', $options);
      $options = base64_encode($options);
      return $options;
  }

  static public function getCategoryFiltersFor($project){
      $filter = "";
      foreach($project->categories as $category ){
          $filter .= "ftg-".str_replace(" ","-",$category)." ";
      }
      return $filter;
  }

  static public function thumbWithQuality($picInfo, $quality){
      if(!isset($picInfo)) return "";
      if(!isset($quality)) return $picInfo->medium;

      if($quality === "medium"){
          return $picInfo->medium;
      }elseif($quality === "large"){
          return $picInfo->large;
      }elseif($quality === "small"){
          return $picInfo->small;
      }else{
          return $picInfo->original;
      }
  }

  static function hex2rgba($color) {

      $default = 'rgb(0,0,0)';

      //Return default if no color provided
      if(empty($color))
          return $default;

      //Sanitize $color if "#" is provided
      if ($color[0] == '#' ) {
          $color = substr( $color, 1 );
      }

      $opacity = 255;

      //Check if color has 8, 6 or 3 characters and get values
      if (strlen($color) == 8) {
          $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
          $opHex = array ($color[6] . $color[7]);
      } elseif (strlen($color) == 6) {
          $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
      } elseif ( strlen( $color ) == 3 ) {
          $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
      } else {
          return $default;
      }

      //Convert hexadec to rgba
      $rgb =  array_map('hexdec', $hex);
      $opacity = array_map('hexdec',$opHex);
      $opacity = $opacity[0]/255;

      $output = 'rgba('.implode(",",$rgb).','.$opacity.')';

      //Return rgb(a) color string
      return $output;
  }

  static function decode2Str($val){
      $str = base64_decode($val);
      return $str;
  }

  static function decode2Obj($str){
      $obj = json_decode($str);
      return $obj;
  }

  static function getAttachementMeta( $attachmentId, $quality = "full" ) {
    /* full, large, medium */
    $kQualityFull = "full";
    $kQualityLarge = "large";
    $kQualityMedium = "medium";

    $attachment = get_post( $attachmentId );

    $meta = array();
    $meta["title"] = $attachment->post_title;
    $meta["alt"] = get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true );
    $meta["caption"] = $attachment->post_excerpt;
    $meta["description"] = $attachment->post_content;

    //By default take full size & src
    $info = wp_get_attachment_image_src($attachmentId, $kQualityFull);

    if($quality === $kQualityLarge){
        $interInfo = wp_get_attachment_image_src($attachmentId, $kQualityFull);
        if($interInfo) {
          $info = $interInfo;
        }
    }elseif($quality === $kQualityMedium){
      $interInfo = wp_get_attachment_image_src($attachmentId, $kQualityMedium);
      if($interInfo) {
        $info = $interInfo;
      }
    }

    $meta["src"] = $info[0];
    $meta["width"] = $info[1];
    $meta["height"] = $info[2];

  	return $meta;
  }

  static public function proMark()
  {
      return '<span>(PRO)</span>';
  }

  static public function colorProMark()
  {
      return '<div class="color-pro-mark"><span>(PRO)</span></div>';
  }

  static function truncWithEllipsis($text, $limit){
      if (str_word_count($text, 0) > $limit) {
          $words = str_word_count($text, 2);
          $pos = array_keys($words);
          $text = substr($text, 0, $pos[$limit]) . '...';
      }
      return $text;
  }

  static function getBanner($zone)
  {
      if (is_null(FEDERHelper::$banners)) {
          $lastLoadedAt = get_option(FEDER_BANNERS_LAST_LOADED_AT);
          $lastLoadedAt = !empty($lastLoadedAt) ? $lastLoadedAt : 0;
          if ($lastLoadedAt == 0 || time() - $lastLoadedAt > 1 * 24 * 60 * 60) {
              $result = FEDERHelper::sendApiRequest(array(
                  'pkg' => FEDER_LICENSE_TYPE,
                  'action' => 'get_banners'
              ), 'GET');
              $cache = array();
              if (!empty($result) && $result['rc'] == FEDERHelper::API_RC_OK) {
                  $cache = !empty($result['banners']) ? $result['banners'] : array();
                  update_option(FEDER_BANNERS_CONTENT, $cache);
                  update_option(FEDER_BANNERS_LAST_LOADED_AT, time());
              }
          } else {
              $cache = get_option(FEDER_BANNERS_CONTENT);
          }
          FEDERHelper::$banners = $cache;
      }
      if (!empty(FEDERHelper::$banners[$zone])) {
          return FEDERHelper::$banners[$zone];
      }
      return array();
  }

  static function sendApiRequest($params, $method = 'POST')
  {
      $result = wp_remote_post( FEDER_API_URL,
          array(
              'method' => $method,
              'timeout' => 45,
              'blocking' => true,
              'headers' => array(),
              'body' => $params,
              'cookies' => array()
          )
      );
      if (!$result instanceof WP_Error && isset($result['response']['code']) && $result['response']['code'] == 200) {
          $result = json_decode($result['body'], true);
          if (json_last_error() != JSON_ERROR_NONE) {
              return false;
          }
          return $result;
      }
      return false;
  }

  static function validatedBase64String($str)
  {
      $str = base64_decode($str);
      if ($str == 'null' || empty($str)) {
          return "";
      }
      return $str;
  }
}
