<div class="feder-admin-header-banner">
<?php
    $federBanner = FEDERHelper::getBanner('header');
    if (!empty($federBanner)) {
        echo $federBanner['content'];
    } else {
?>
        <style>
            .feder-default-banner-box {
                width: 100%;
                background-color: #6001d2;
                height: 100px;
                margin-bottom: 20px;
                color: white;
            }
            .feder-default-banner-box--bg-image {
                background-size: contain;
                background-position: center;
                background-repeat: no-repeat;
            }
            .feder-default-banner-box--logo-block {
                padding:4px 0px 0px 20px;
                float: left;
            }
            .feder-default-banner-box--logo {
                background-image: url('<?php echo FEDER_IMAGES_URL.'/admin/banner/logo.png'; ?>');
                width: 100px;
                height: 100px;
            }
            .feder-default-banner-box--logo-title {
                text-align: center;
                margin-top: -5px;
            }
            .feder-default-banner-box--title-block {
                padding-top: 20px;
            }
            .feder-default-banner-box--title-block-icon {
                background-image: url('<?php echo FEDER_IMAGES_URL.'/admin/banner/polyathlon.png'; ?>');
                width: 220px;
                height: 70px;
                margin: 0 auto;
            }
            .feder-default-banner-box--menu-block {
                float: right;
            }
            .feder-default-banner-box--menu-block-help {
                background-image: url('<?php echo FEDER_IMAGES_URL.'/admin/banner/support.png'; ?>');
                margin-top: -60px;
                width: 45px;
                height: 45px;
                margin-right: 20px;
                display: block;
            }
            .feder-default-banner-box--menu-block-help:hover {
                opacity: 0.8;
            }
            .feder-default-banner-box--menu-block-help:active,
            .feder-default-banner-box--menu-block-help:focus {
                -webkit-box-shadow: none;
                -moz-box-shadow: none;
                box-shadow: none;
            }
        </style>
        <div class="feder-default-banner-box">
            <div class="feder-default-banner-box--logo-block">
                <div class="feder-default-banner-box--logo feder-default-banner-box--bg-image"></div>
                <!-- <div class="feder-default-banner-box--logo-title">FREE</div> -->
            </div>
            <div class="feder-default-banner-box--title-block">
                <div class="feder-default-banner-box--title-block-icon feder-default-banner-box--bg-image"></div>
            </div>
            <div class="feder-default-banner-box--menu-block">
                <a href="https://wordpress.org/support/plugin/schedule-wp/" target="_blank" class="feder-default-banner-box--menu-block-help feder-default-banner-box--bg-image"></a>
            </div>
        </div>
<?php
    }
?>
</div>
