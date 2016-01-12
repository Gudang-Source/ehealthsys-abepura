<div class="white-container">
    <legend class="rim2">Informasi Pasien <b>Rawat Inap</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Daftar Pasien'=>array('/billingKasir/daftarPasien'),
            'PasienRI',
    );?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <?php 


    Yii::app()->clientScript->registerScript('cariPasien', "
    $('#caripasien-form').submit(function(){
            $.fn.yiiGridView.update('pencarianpasien-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <div class="block-tabel">
        <?php echo $this->renderPartial('_tablePasienRI', array('modRI'=>$modRI),true);  ?>
    </div>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'caripasien-form',
            'enableAjaxValidation'=>false,
                    'type'=>'horizontal',
                    'focus'=>'#'.CHtml::activeId($modRI,'no_rekam_medik'),
                    'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
    )); ?>
    <fieldset class="box">
        <?php echo $this->renderPartial('_formKriteriaPencarianRI', array('model'=>$modRI,'form'=>$form,'format'=>$format),true);  ?> 
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>

            <?php //echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','ajax' => array(
 //                 'type' => 'GET', 
 //                 'url' => array("/".$this->route), 
 //                 'update' => '#pencarianpasien-grid',
 //                 'beforeSend' => 'function(){
 //                                      $("#pencarianpasien-grid").addClass("animation-loading");
 //                                  }',
 //                 'complete' => 'function(){
 //                                      $("#pencarianpasien-grid").removeClass("animation-loading");
 //                                  }',
 //             ))); ?>
             <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
            <?php  
            $content = $this->renderPartial('../tips/informasi_pencarian',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>

    <?php 
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogPembayaranKasir',
        'options'=>array(
            'title'=>'Pembayaran Kasir',
            'autoOpen'=>false,
            'modal'=>true,
            'minWidth'=>1124,
            'minHeight'=>510,
            'resizable'=>true,
            'close'=>"js:function(){ $.fn.yiiGridView.update('pencarianpasien-grid', {
                            data: $('#caripasien-form').serialize()
                        }); }",
        ),
    ));
    ?>
    <iframe src="" name="iframePembayaran" width="100%" height="550" >
    </iframe>
    <?php
    $this->endWidget();
    ?>
    <?php 
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogRincianTagihan',
        'options'=>array(
            'title'=>'Rincian Tagihan',
            'autoOpen'=>false,
            'modal'=>true,
            'minWidth'=>1024,
            'minHeight'=>610,
            'resizable'=>true,
        ),
    ));
    ?>
    <iframe src="" name="iframeRincianTagihan" width="100%" height="550" >
    </iframe>
    <?php
    $this->endWidget();
    ?>
</div>