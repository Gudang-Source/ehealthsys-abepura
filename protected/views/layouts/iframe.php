<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--<link rel="stylesheet" type="text/css" href="<?php // echo Yii::app()->request->baseUrl; ?>/css/mws/mws.style.css" media="screen" />-->
	<!--<link rel="stylesheet" type="text/css" href="<?php // echo Yii::app()->request->baseUrl; ?>/css/mws/icons/icons.css" media="screen" />-->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/treeview/jquery.treeview.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/alertjs/css/jQuery.alert.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/animation-loading.css" />
<!--         css fancybox 
	<link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->request->baseUrl; ?>/themes/fancybox/fancybox/jquery.fancybox-1.3.4.css" />
        
         end css fancybox -->
        
	<!--<script type="text/javascript" src="<?php // echo Yii::app()->request->baseUrl; ?>/js/jquery-1.3.2.js"></script>-->
	<!--<script type="text/javascript" src="<?php // echo Yii::app()->request->baseUrl; ?>/js/mws.js"></script>-->

        
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.maskMoney.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.maskedinput.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/realtimeClock.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/webcam.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/alertjs/js/jQuery.alert.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/alertjs/js/jquery.ui.draggable.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/socket.io.js'); ?>
	
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<?php
	if(stripos($_GET['r'], 'antrian') !== false){
		echo '<body style="background: transparent;">';
	}else{
		echo '<body style="background:#ffffff;padding:7px;">';
	}
?>
<style>
	//untuk label yg bisa refresh
	label.refreshable:hover{
		cursor:pointer;
		color:#0000FF;
		font-weight: bold;
	}
</style>
<body>

<div class="container" style="width: 100%;">
    <div>
        <?php
        if(isset($this->menu)){
            $this->widget('bootstrap.widgets.BootMenu', array(
                'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
                'stacked'=>false, // whether this is a stacked menu
                'items'=>$this->menu,
            ));
        } ?>
    </div>
    <?php echo $content; ?>
    
</div>

</body>
<?php
Yii::app()->clientScript->registerScript('resizeBody','
		document.body.style.height = "10px";
', CClientScript::POS_END);
?>
</html>
<script type="text/javascript">
function insert_notifikasi(params)
{
    $.post("index.php?r=site/insertNotifikasi",{NofitikasiR:params},
        function(data){
            if(data.pesan === 'ok')
            {
                <?php if(Yii::app()->user->getState('is_nodejsaktif')){ ?>
					var chatServer='<?php echo Yii::app()->user->getState("nodejs_host") ?>';
					if (chatServer == ''){
					 chatServer='http://localhost';
					}
					var chatPort='<?php echo Yii::app()->user->getState("nodejs_port") ?>';
					socket = io.connect(chatServer+':'+chatPort);
					socket.emit('send',{conversationID:'notification',status:1,modul_id:data.modul_id});
					socket.disconnect();
                <?php } ?>

                $('#pesan_notifikasi').html(data.template);
                if(data.count_notif == 0)
                {
                    $('#count_notif').text("");
//                    $('#count_notif').removeClass("mws-dropdown-notif");
                }else{
                    if (data.count_notif>10) {
                        count_notif = '10+';
                    }else if(data.count_notif>0){
                        count_notif = data.count_notif;
                    }
                    $('#count_notif').text(count_notif);
//                    $('#count_notif').addClass("mws-dropdown-notif");
                }
            }
            return false;
        },"json"
    );
}
</script>
