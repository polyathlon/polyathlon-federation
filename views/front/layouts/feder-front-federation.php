<!--Here Goes HTML-->
<style>

.feder-wrapper {
    margin: 0;
    box-sizing: border-box;
}

.feder-wrapper .feder-items {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

.feder-items .feder-item {
    flex: 1;
    margin: 5px;
    width: 100%;
    min-width: 300px;

}

.feder-item .feder-portfolio {
    display: flex;
    margin: 5px 0px;
}

.feder-portfolio .feder-main {
    flex: 1;
    width: 70%;
    display: flex;
    flex-direction: column;
    align-content: flex-start;
    justify-content: flex-start;
}

@media only screen and (min-width : 320px) and (max-width : 480px) {
    .feder-main .feder-portfolio-title{
        font-size: 16px;
    }

    .feder-main .feder-portfolio-email,
    .feder-main .feder-portfolio-phone,
    .feder-main .feder-portfolio-address {
        font-size: 16px;
    }
}

@media only screen and (max-width : 550px) {
    .feder-main .feder-portfolio-title{
        font-size: 16px;
    }

    .feder-main .feder-portfolio-email,
    .feder-main .feder-portfolio-phone,
    .feder-main .feder-portfolio-address {
        font-size: 16px;
    }
}

@media only screen and (min-width : 550px) {
    .feder-main .feder-portfolio-title{
        font-size: 20px;
    }

    .feder-main .feder-portfolio-email,
    .feder-main .feder-portfolio-phone,
    .feder-main .feder-portfolio-address {
        font-size: 18px;
    }
}

.feder-main .feder-portfolio-title{
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    align-content: center;
    width: 100%;
    background: darkgray;
    padding-top: 10px;
    padding-bottom: 10px;
    line-height: 1.5em;
    text-align: center;
    font-weight: 600;
    color: #FFF;
    border-radius: 5px;
}

.feder-portfolio-title span{
    padding-bottom: 3px;
}

.feder-main .feder-portfolio-email,
.feder-main .feder-portfolio-phone,
.feder-main .feder-portfolio-address {
    flex: 1;
    display: flex;
    align-items: center;
    width: 100%;
    background: white;
    padding-top: 5px;
    padding-bottom: 5px;

    line-height: 1.5em;
}

.feder-portfolio .feder-image {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    max-width: 35%;
 }

 .feder-image img{
    max-width: 100%;
    max-height: 300px;
 }

.feder-item .feder-footer,
.feder-item .feder-main,
.feder-item .feder-image {
    padding: 5px;
}

.feder-item .feder-header {
    user-select: none;
    background-color: #6001d2;
    font-family: 'Comfortaa', 'Rubik', sans-serif;
    font-size: 35px;
    color: #FFF;
    line-height: 45px;
    box-sizing: border-box;
    font-weight: 600;
    text-align: center;
    padding: 10px;
}

.feder-item .feder-footer {
    background-color: #121026;
    font-family: 'Rubik', sans-serif;
    font-size: 16px;
    color: #FFF;
    line-height: 25px;
    box-sizing: border-box;
    font-weight: 400;
    text-align: center;
    user-select: none;
    border-radius: 5px;
    cursor: pointer;
}
</style>

<body>
    <div class="feder-wrapper">
        <div class="feder-items">
            <?php foreach($feder_portfolios as $feder_portfolio): ?>
                <div class="feder-item">
                    <div class="feder-header">
                        <?php echo $feder_portfolio->title?>
                    </div>
                    <div class="feder-portfolio">
                        <div class="feder-image">
                            <img src="<?php echo $feder_portfolio->pic->src?>">
                        </div>
                        <div class="feder-main">
                            <div class="feder-portfolio-title"><span><?php echo $feder_portfolio->full_name?></span></div>
                            <div class="feder-portfolio-address"><span><?php echo $feder_portfolio->address?></span></div>
                            <div class="feder-portfolio-email"><span><?php echo $feder_portfolio->e_mail?></span></div>
                            <div class="feder-portfolio-phone"><span><?php echo $feder_portfolio->phone?></span></div>
                        </div>
                    </div>
                    <div class="feder-footer">
                        Подробнее
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>