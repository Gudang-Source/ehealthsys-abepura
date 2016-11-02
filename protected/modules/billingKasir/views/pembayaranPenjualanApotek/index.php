<div class="white-container">
    <legend class="rim2">Pembayaran <b>Penjualan Apotek</b></legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'bkpembayaranpelayanan-t-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);'),//DIMATIKAN KARENA PAKAI VERIFIKASI FORM >> , 'onsubmit'=>'return requiredCheck(this);'
            'focus'=>'#jenispenjualan',
    )); ?>
    <?php echo $form->errorSummary($modPenjualan); ?>
    <?php echo $form->errorSummary($model); ?>
    <?php echo $form->errorSummary($modTandabukti); ?>
    <?php echo $form->errorSummary($modPemakaianuangmuka); ?>

    <fieldset class="box" id="form-datapenjualan">
        <legend class="rim"><span class='judul'>Data Penjualan </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'setPenjualanReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengulang data penjualan')); ?></span></legend>
        <div class="row-fluid">
            <?php $this->renderPartial('_formInfoPenjualan', array('form'=>$form,'modPenjualan'=>$modPenjualan)); ?>
        </div>
    </fieldset>
    <div class="block-tabel">
        <h6>Rincian Tagihan <b>Penjualan Apotek</b> <?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'setRincianObatalkes();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk me-refresh rincian tagihan apotek')); ?></h6>
        <div style="overflow-x: auto; max-width: 100%; margin-bottom: 5px;" id="form-rincianobatalkes">
            <?php $this->renderPartial('_formRincianPenjualanApotek', array('dataOas'=>$dataOas)); ?>
        </div>
        <fieldset class="box">
            <legend class="rim">Data Pembayaran</legend>
            <?php 
                if(isset($_GET['sukses'])){
                    Yii::app()->user->setFlash('success', "Data pembayaran berhasil disimpan !");
                    $this->widget('bootstrap.widgets.BootAlert');
                }
            ?>
            <?php 
                echo $form->hiddenField($model,'noresep',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
                echo $this->renderPartial($this->path_view.'_formPembayaran', array('form'=>$form,'model'=>$model,'modTandabukti'=>$modTandabukti,'modPemakaianuangmuka'=>$modPemakaianuangmuka), true); 
            ?>
        </fieldset>
    </div>
    <div class="row-fluid">
        <div class="form-actions">
                <?php 
                    if($model->isNewRecord){
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'setVerifikasi();', 'onkeypress'=>'setVerifikasi();')); //formSubmit(this,event)
                    }else{
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'return false', 'onkeypress'=>'return false', 'disabled'=>true, 'style'=>'cursor:not-allowed;')); 
                    }
                ?>
                <?php
                    if(!isset($_GET['frame'])){
                        echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                            $this->createUrl($this->id.'/index'), 
                            array('class'=>'btn btn-danger',
                                  'onclick'=>'return refreshForm(this);'));
                    }
                ?>
                <?php
                    if($model->isNewRecord){
                        echo CHtml::link(Yii::t('mds', '{icon} Print Rincian', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printRincian(\"PRINT\");return false",'disabled'=>TRUE  ));
                        echo "&nbsp;";
                        echo CHtml::link(Yii::t('mds', '{icon} Print BKM', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Tombol akan aktif setelah data tersimpan','class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;'));
                    }else{
                        echo CHtml::link(Yii::t('mds', '{icon} Print Rincian', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printRincian(\"PRINT\");return false",'disabled'=>FALSE  ));
                        echo "&nbsp;";
                        echo CHtml::link(Yii::t('mds', '{icon} Print BKM', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printBkm(\"PRINT\");return false",'disabled'=>FALSE  ));
                    }
                ?>
                <?php 
                    $content = $this->renderPartial($this->path_view.'tips/tipsPembayaranTagihanPasien',array(),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
                ?> 
        </div>
    </div>

<?php $this->renderPartial($this->path_view.'_jsFunctions', array('modPenjualan'=>$modPenjualan,'model'=>$model,'modTandabukti'=>$modTandabukti,'modPemakaianuangmuka'=>$modPemakaianuangmuka)); ?>
<?php $this->renderPartial('_jsFunctions', array('modPenjualan'=>$modPenjualan,'model'=>$model,'modTandabukti'=>$modTandabukti,'modPemakaianuangmuka'=>$modPemakaianuangmuka)); ?>
<?php $this->endWidget(); ?>


<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialog-verifikasi',
    'options'=>array(
        'title'=>'Verifikasi Pembayaran',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>960,
        'minHeight'=>480,
        'resizable'=>false,
    ),
));

echo '<div class="dialog-content"></div>';
?>
<div class="row-fluid">
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Lanjutkan',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'disableOnSubmit(this); $("#bkpembayaranpelayanan-t-form").submit();')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'button', 'onclick'=>'batalDialog("dialog-verifikasi");')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
