<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'masukkamar-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#PJPasienpulangT_penerimapasien',
        'method'=>'post',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
));

$this->widget('bootstrap.widgets.BootAlert');
?>

<?php $this->renderPartial('/_ringkasDataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,'readOnlyNoRm'=>true)) ?>

<?php $this->renderPartial('_formPasienPulang',array('modelPulang'=>$modelPulang,
                                                     'modPasien'=>$modPasien,
                                                     'form'=>$form,
                                                     'idInstalasi'=>$idInstalasi,
                                                     'modMasukKamar'=>$modMasukKamar,
                                                     'tersimpan'=>$tersimpan,
        )); ?>

<?php $this->endWidget(); ?>
