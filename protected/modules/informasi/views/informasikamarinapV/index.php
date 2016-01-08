<style>
    .contentKamar, .bed{
        -moz-box-shadow: 0px 5px 10px rgba(0,0,0,.6);
        -webkit-box-shadow: 0px 5px 10px rgba(0,0,0,.6);
        -o-box-shadow: 0px 5px 10px rgba(0,0,0,.6);
        -moz-border-radius:3px;
        -webkit-border-radius:3px;
        -o-border-radius:3px;
    }
    .contentKamar{
        border:1px solid black;
        margin:10px;
		
    }
    .bed{
        display:inline-block;
        width:13%;
        border-color:#ccc;
        margin:10px;
    }
    .popover-inner{
        width:100%;
    }
    .image_ruangan{
        height:100px;
        width:100px;
    }
	.pintu{
		background-image:url(images/pintu.png);
		width:16px;
		height:75px;
		margin-top:80px;
		float:right;
		margin-right:-2px;
		}
</style>
<div class="white-container">
    <legend class="rim2">Informasi <b>Kamar</b></legend> 
    <?php 
    echo CHtml::dropDownList('ruangan', '', CHtml::listData(
        RuanganM::model()->findAllByAttributes(
            array(
                'instalasi_id'=>Params::INSTALASI_ID_RI,
                'ruangan_aktif'=>true
            ),
            array('order'=>'ruangan_nama')
        ), 'ruangan_id', 'ruangan_nama'),
        array('empty'=>'-- Pilih --', 'onchange'=>'getListRuangan();')
    ); 
    ?>
    <div class="isi">
        <?php echo $row; ?>
    </div>
</div>
<?php 
$url = Yii::app()->createUrl($this->route);
Yii::app()->clientScript->registerScript('list', '
    function getListRuangan(){
        ruangan = $("#ruangan").val();
        $(".contentKamar").addClass("animation-loading");
        $.post("'.$url.'", {ajax:true,ruangan:ruangan},function(data){
            $(".isi").html(data);
            $(".contentKamar").removeClass("animation-loading");
            jQuery(\'a[rel="popover"]\').popover();
            jQuery(\'.poping\').popover({placement:"bottom"});
        },"json");
    }
',  CClientScript::POS_HEAD); ?>
<?php Yii::app()->clientScript->registerScript('readyFunction','
    jQuery(\'.poping\').popover({placement:"bottom"});
//    $(".bed").mousemove(function(e){
//        $(".popover").show();
//        tinggi = $(".popover").height()/2;
//        $(".popover").css("left",e.clientX);        
//        $(".popover").css("top",($(document).scrollTop())+e.clientY-tinggi);   
//    });
//    
//    $(".bed").click(function(e){
//        $(".popover").slideToggle();
//    });
    
    ',  CClientScript::POS_READY); ?>