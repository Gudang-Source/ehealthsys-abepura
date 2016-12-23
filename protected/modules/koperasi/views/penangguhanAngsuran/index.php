<?php
/* @var $this PenangguhanAngsuranController */

$this->breadcrumbs=array(
	'Permintaan Penangguhan',
);
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'pembayaran-angsuran-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'focus' => '#adcontact-form div.form-group:first-child div input',
	'htmlOptions'=>array('class'=>'form-groups-bordered','onKeyPress'=>'return disableKeyPress(event);', //, 'onsubmit'=>'return requiredCheck(this);',
	'enctype' => 'multipart/form-data'),
)); ?>

<div class="col-md-12">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<div class="panel-title">
				Permintaan Angsuran
			</div>
		</div>
		<div class="panel-body">
			<?php echo $this->renderPartial('subview/_anggota', array('form'=>$form, 'anggota'=>$anggota)); ?>
			<?php echo $this->renderPartial('subview/_penangguhan', array('form'=>$form, 'id'=>$id, 'anggota'=>$anggota, 'penangguhan'=>$penangguhan, 'angsuran'=>$angsuran, 'pembayaranan'=>$pembayaranan, 'pinjaman'=>$pinjaman)); ?>
			<?php echo $this->renderPartial('subview/_signature', array('form'=>$form, 'kaskeluar'=>$kaskeluar, 'pinjaman' => $pinjaman)); ?>
			<?php echo $this->renderPartial('subview/_js', array()); ?>
			<?php echo Yii::app()->modal->register($this->renderPartial('subview/_dialog', null, true)); ?>
			<div style="text-align: center">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>'Simpan',
				'visible'=>$penangguhan->isNewRecord,
				'htmlOptions'=>array('class'=>'btn-success', 'onclick'=>'if (!cekValidasi()) return false;', 'onkeypress'=>'return formSubmit(this,event)'),
			)); ?>
			<?php echo Yii::app()->modal->register($this->renderPartial('subview/_dialog', null, true)); ?>
			<?php echo CHtml::link('Print', $this->createUrl('print', array('id'=>$penangguhan->permohonanpenangguhan_id)), array('disabled'=>$penangguhan->isNewRecord, 'target'=>'_blank','class' => 'btn btn-success')); ?>
			<?php // echo CHtml::link('Print BKK', $this->createUrl('/printKwitansi/kaskeluar', array('id'=>$kaskeluar->bukitkaskeluar_id)), array('disabled'=>$kaskeluar->isNewRecord, 'target'=>'_blank','class' => 'btn btn-blue')); ?>
			<?php echo CHtml::link('Batal', $this->createUrl('infromasiKartuAngsuran/index'), array('class' => 'btn btn-default')); ?>
			</div>
		</div>
	</div>
</div>

<?php $this->endWidget(); ?>
