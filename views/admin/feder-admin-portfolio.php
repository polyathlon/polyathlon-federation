<?php

$feder_pid = 0;

if(isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])){
    $feder_action = 'edit';
    $feder_pid = (int)$_GET['id'];
}else if(isset($_GET['action']) && $_GET['action'] === 'create'){
    $feder_action = 'create';
}

global $feder_theme;
?>

<div class="feder-federation-header">

    <div class="feder-three-parts feder-fl">
        <a id="feder-button-secondary" class='button-secondary federation-button feder-glazzed-btn feder-glazzed-btn-dark' href="<?php echo "?page={$feder_adminPage}"; ?>">
            <div class='feder-icon feder-federation-button-icon'><i class="fa fa-long-arrow-left"></i></div>
        </a>
    </div>

    <div class="feder-three-parts feder-fl feder-title-part">
    <input id="feder-portfolio-title" class="feder-federation-title" name="federation-title" maxlength="250" placeholder="Enter person name" type="text"></div>

    <div class="feder-three-parts feder-fr">
        <a id="feder-save-portfolio-button" class='button-secondary federation-button feder-glazzed-btn feder-glazzed-btn-green feder-fr' href="#">
            <div class='feder-icon feder-federation-button-icon'><i class="fa fa-save fa-fw"></i></div>
        </a>
    </div>
</div>

<hr />

<table id="feder-gallery-project-list">
    <tr id="feder-gallery-project-id" class="feder-gallery-project">
        <td class="feder-draggable"><i class="fa fa-reorder"></i></td>
        <td class="feder-attachment">
            <div>
                <div class="feder-attachment-img">
                    <div class="feder-attachment-img-overlay" onclick="feder_onImageEdit('id')"><i class="fa fa-pencil"></i>
                    </div>
                </div>
                <input type="hidden" class="feder-project-cover-src" name="portfolio.image" value="" />
            </div>
        </td>
        <td class="feder-content">
            <div class="feder-content-box"><input id="feder-portfolio-full-name" type="text" placeholder="Enter fullname" value=""></div>
            <div class="feder-content-box"><input id="feder-portfolio-e-mail" type="text" placeholder="Enter e-mail" value=""></div>
            <div class="feder-content-box"><input id="feder-portfolio-phone" type="text" placeholder="Enter phone" value=""></div>
            <div class="feder-content-box"><input type="text" id="feder-portfolio-address" placeholder="Enter address" value=""></div>
            <div class="feder-content-box"><textarea rows=3 id="feder-portfolio-about" placeholder="Enter about" ></textarea></div>
        </td>
    </tr>
</table>

<script>

//Show loading while the page is being complete loaded
feder_showSpinner();

//Configure javascript vars passed PHP
var feder_adminPage = "<?php echo $feder_adminPage ?>";
var feder_action = "<?php echo $feder_action ?>";
var feder_selectedProjectId = 0;

var feder_categoryAutocompleteDS = [];
var feder_attachmentTypePicture = 'pic';

//Configure portfolio model
var feder_portfolio = {};

feder_portfolio.id = "<?php echo $feder_pid ?>";
feder_portfolio.isDraft = true;


//Perform some actions when window is ready
jQuery(window).load(function () {


    //In case of edit we should perform ajax call and retrieve the specified portfolio for editing
    if(feder_action == 'edit'){
        feder_portfolio = federAjaxGetWithId(feder_portfolio.id, 'feder_get_portfolio');

        //NOTE: The validation and moderation is very important thing. Here could be not expected conversion
        //from PHP to Javascript JSON objects. So here we will validate, if needed we will do changes
        //to meet our needs
        feder_portfolio = validatedPortfolio(feder_portfolio);
        //This portfolio is already exists on server, so it's not draft item
        feder_portfolio.isDraft = false;

    }

    jQuery("#feder-save-portfolio-button").on( 'click', function( evt ){
        evt.preventDefault();

        //Apply last changes to the model
        feder_updateModel();

        //Validate saving

        if(!feder_portfolio.title){
            alert("Oops! You're trying to save a portfolio without person name.");
            return;
        }

        //Show spinner
        feder_showSpinner();

        //Perform Ajax calls
        feder_result = federAjaxSave(feder_portfolio, 'feder_save_portfolio');

        //Get updated model from the server
        feder_portfolio = federAjaxGetWithId(feder_result['pid'], 'feder_get_portfolio');
        feder_portfolio = validatedPortfolio(feder_portfolio);
        feder_portfolio.isDraft = false;

        //Update UI
        feder_updateUI();

        //Hide spinner
        feder_hideSpinner();

        //Redirect to previous page
        jQuery( "#feder-button-secondary" )[0].click();
    });

    jQuery(document).keypress(function(event) {
        //cmd+s or control+s
        if (event.which == 115 && (event.ctrlKey||event.metaKey)|| (event.which == 19)) {
            event.preventDefault();

            jQuery( "#feder-save-portfolio-button" ).trigger( "click" );
            return false;
        }
        return true;
    });

    //Update UI based on retrieved/(just create) model
    feder_updateUI();

    //When the page is ready, hide loading spinner
    feder_hideSpinner();
});

function feder_changeImageCover(imageId, picInfo) {
    var thumb_img = "<?php echo ($feder_theme == 'dark') ? '/general/glazzed-image-placeholder_dark.png' : '/general/glazzed-image-placeholder.png'; ?>";

    if(picInfo) {
        picInfo.type = feder_attachmentTypePicture;
    }
    var bgImage = (picInfo ? picInfo.src : FEDER_IMAGES_URL + thumb_img);
    jQuery("#feder-gallery-project-"+imageId+" .feder-project-cover-src").val(JSON.stringify(picInfo));
    jQuery("#feder-gallery-project-"+imageId+" .feder-attachment-img").css('background', 'url('+bgImage+') center center / cover no-repeat');
}

function feder_onImageEdit(imageId) {
    feder_openMediaUploader(function callback(picInfo) {
        feder_changeImageCover(imageId, picInfo);
    }, false);
}

function feder_updateUI(){
    if(feder_portfolio.title){
        jQuery("#feder-portfolio-title").val( feder_portfolio.title );
    }

    if( feder_portfolio.full_name ){
        jQuery("#feder-portfolio-full-name").val( feder_portfolio.full_name );
    }

    if( feder_portfolio.e_mail ){
        jQuery("#feder-portfolio-e-mail").val( feder_portfolio.e_mail );
    }

    if(feder_portfolio.phone){
        jQuery("#feder-portfolio-phone").val( feder_portfolio.phone );
    }

    if( feder_portfolio.address ){
        jQuery("#feder-portfolio-address").val( feder_portfolio.address );
    }

    if( feder_portfolio.about ){
        jQuery("#feder-portfolio-about").val( feder_portfolio.about );
    }

    var image = feder_portfolio.image ? JSON.parse(federBase64.decode(feder_portfolio.image)) : null;
    feder_changeImageCover('id', image);

}

function feder_updateModel(){
    //To make sure it's valid JS object
    feder_portfolio = validatedPortfolio(feder_portfolio);

    feder_portfolio.title = jQuery("#feder-portfolio-title").val();
    feder_portfolio.e_mail = jQuery("#feder-portfolio-e-mail").val();
    feder_portfolio.full_name = jQuery("#feder-portfolio-full-name").val();
    feder_portfolio.phone = jQuery("#feder-portfolio-phone").val();
    feder_portfolio.address = jQuery("#feder-portfolio-address").val();
    feder_portfolio.about = jQuery("#feder-portfolio-about").val();
    feder_portfolio.image = federBase64.encode(jQuery("input[name='portfolio.image']").val());
}

function validatedPortfolio(portfolio){
    if (!portfolio) {
      portfolio = {};
    }
    return portfolio;
}

function htmlEntitiesEncode(str){
    return jQuery('<div/>').text(str).html();
}

</script>
