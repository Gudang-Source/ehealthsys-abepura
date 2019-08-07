<?php
$this->breadcrumbs=array(
	'Pemakaian Bahan',
);
$this->widget('bootstrap.widgets.BootAlert');

//$this->renderPartial('/_ringkasDataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien));

//$this->renderPartial('/_tabulasi', array('modPendaftaran'=>$modPendaftaran));
?>

<!--<legend class="rim2">Pemakaian Bahan Pasien</legend>-->
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'rjpemakaian-bahan-form',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#namaObatNonRacik',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)',
                             'onsubmit'=>'return requiredCheck(this);'),
)); ?>
<div class="formInputTab">
<?php $this->renderPartial('_listObatAlkesPasien',array('modViewBmhp'=>$modViewBmhp)); ?>
<?php $this->renderPartial('_formPemakaianBahan',array('modPendaftaran'=>$modPendaftaran)); ?>

    <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                    array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>			
            <?php 

            echo CHtml::link(Yii::t('mds', '{icon} Print', 
                array('{icon}'=>'<i class="icon-print icon-white"></i>')), 
                    'javascript:void(0);', array('class'=>'btn btn-info',
                    'onclick'=>"print(".$modPendaftaran->pendaftaran_id.");return false"))."&nbsp;";
            

            $content = $this->renderPartial('rawatJalan.views.tips.tips',array(),true);
			$this->widget('UserTips',array('type'=>'admin','content'=>$content));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial('_jsFunctions', array('modPendaftaran'=>$modPendaftaran)); ?>