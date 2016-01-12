<div class="white-container">
    <legend class="rim2">Pasien Sudah <b>Pulang - Rawat Inap</b></legend>
    <?php
    $arrMenu = array();
                    array_push($arrMenu,array('label'=>Yii::t('mds','Search Patient'), 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //$this->menu=$arrMenu;
    $this->widget('bootstrap.widgets.BootAlert');
    ?>

    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'caripasien-form',
            'enableAjaxValidation'=>false,
                    'type'=>'horizontal',
                    'focus'=>'#',
                    'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
    ));

    Yii::app()->clientScript->registerScript('cariPasien', "
    $('#caripasien-form').submit(function(){
            $.fn.yiiGridView.update('pencarianpasien-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootMenu', array(
        'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
        'stacked'=>false, // whether this is a stacked menu
        'items'=>array(
            array('label'=>'Pasien Rawat Jalan', 'url'=>$this->createUrl('/farmasiApotek/infoPasienPulang/indexRJ',array())),
            array('label'=>'Pasien Rawat Inap', 'url'=>'','linkOptions'=>array(),'active'=>true),
            array('label'=>'Pasien Rawat Darurat', 'url'=>$this->createUrl('/farmasiApotek/infoPasienPulang/indexRD',array())),
        ),
    ));
           echo $this->renderPartial('_formCariRI', array('model'=>$modRI,'form'=>$form,'format'=>$format,),true); 
    ?>
    <?php $this->endWidget(); ?>
    <?php 
    // Dialog buat nambah data propinsi =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogPenjualanResep',
        'options'=>array(
            'title'=>'Penjualan Resep',
            'autoOpen'=>false,
            'modal'=>true,
            'zIndex'=>1004,
            'minWidth'=>980,
            'minHeight'=>610,
            'resizable'=>false,
        ),
    ));
    ?>
    <iframe src="" name="iframePenjualanResep" width="100%" height="550" >
    </iframe>
    <?php
    $this->endWidget();
    //========= end propinsi dialog =============================
    ?>
</div>