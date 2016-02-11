<div class="white-container">
	<legend class="rim2">Pencarian <b>Peserta BPJS</b></legend>
	<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'pencarian-peserta-bpjs-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
    ));
    ?>
	<fieldset class="box">
		<legend class="rim">Data Pencarian</legend>
		<?php $this->renderPartial($this->path_view.'_formPencarian',array('form'=>$form)); ?>
	</fieldset>
	
	<fieldset class="box" id="data-peserta">
		<legend class="rim">Data peserta</legend>
		<?php $this->renderPartial($this->path_view.'_formDataPeserta',array('form'=>$form)); ?>
	</fieldset>
	
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue','type'=>'button','disabled'=>true,'onclick'=>'printPesertaBpjs(\'PRINT\')')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','Lihat Riwayat',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary btn-riwayat','type'=>'button','disabled'=>true,'onclick'=>'lihatRiwayat(\'PRINT\')')); ?>
	</div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view.'_jsFunctions',array());?>
<?php 
// Dialog untuk Melihat 10 riwayat terakhir peserta BPJS =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogRiwayatPesertaBpjs',
    'options' => array(
        'title' => '10 Riwayat Terakhir Peserta',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 400,
        'resizable' => true,
    ),
));
?>
<?php $this->renderPartial($this->path_view.'_riwayatPeserta',array());?>

</iframe>
<?php $this->endWidget(); ?>