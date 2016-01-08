<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/fonts.css">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/neon.css">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/custom.css">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo-codes.css">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo-embedded.css">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">

<div class="tile-stats tile-green span6" style="width:120px;height:120px;margin:0 0 0 8px;">
    <div class="icon" style="margin:50px 5px 40px">
        <i class="entypo-users"></i>
    </div>
    <div class="num" data-delay="0" data-duration="1500" data-postfix="" data-end="83" data-start="0">
        <?php echo $dataProviderRJ->totalItemCount;?>
    </div>
    <p><strong>Jumlah Pasien Rawat Jalan</strong></p>
</div>
<div class="tile-stats tile-red span6" style="width:120px;height:120px;margin:0 0 0 2px;">
    <div class="icon" style="margin:50px 5px 40px">
        <i class="entypo-users"></i>
    </div>
        <div class="num" data-delay="0" data-duration="1500" data-postfix="" data-end="83" data-start="0">
            <?php echo $dataProviderRD->totalItemCount;?>
        </div>
    <p><strong>Jumlah Pasien Rawat Darurat</strong></p>
</div>                 