<style>
	.num {
		text-align: right;
	}
	.input-group-addon{
		cursor: pointer;
	}
</style>

<?php
/* @var $this PemberhentianController */

$this->breadcrumbs=array(
	'Kas Keluar',
);

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'kaskeluar-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'focus' => '#adcontact-form div.form-group:first-child div input',
	'htmlOptions'=>array('class'=>'form-groups-bordered','onKeyPress'=>'return disableKeyPress(event);', 'enctype' => 'multipart/form-data'),
));
?>

<div class="col-md-12">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<div class="panel-title">
				Transaksi Kas Keluar
			</div>
		</div>
		<div class="panel-body">
			<?php echo $this->renderPartial('subview/_anggotaTransaksi', array('form'=>$form, 'anggota'=>$anggota)); ?>
			<?php //echo $this->renderPartial('subview/kasmasuk/_detailTransaksiAngsuran', array('form'=>$form, 'anggota'=>$anggota, 'angsuran'=>$angsuran, 'berhenti'=>$berhenti)); ?>
			<?php echo $this->renderPartial('subview/kaskeluar/_detailTransaksiSimpanan', array('form'=>$form, 'anggota'=>$anggota, 'simpanan'=>$simpanan, 'berhenti'=>$berhenti)); ?>
			<?php echo $this->renderPartial('subview/kaskeluar/_bkk', array('form'=>$form, 'kaskeluar'=>$kaskeluar)); ?>
      <?php echo $this->renderPartial('subview/kaskeluar/_signature', array('form'=>$form, 'kaskeluar'=>$kaskeluar)); ?>
			<?php echo $this->renderPartial('subview/kaskeluar/_js', array('kaskeluar'=>$kaskeluar)); ?>
			<?php echo Yii::app()->modal->register($this->renderPartial('subview/kaskeluar/_dialog', array(), true)); ?>
			<!-- submit/batal -->
		</div>
		<div class="panel-footer" style="text-align: center">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Simpan',
			'visible'=>$kaskeluar->isNewRecord,
			'htmlOptions'=>array('class'=>'btn-success', 'onkeypress'=>'return formSubmit(this,event)', 'onclick'=>'if (!cekValidasi()) return false;',),
		)); ?>
		<?php //echo $kaskeluar->isNewRecord?null:CHtml::link('Print', $this->createUrl('print',array('id'=>$kasmasuk->buktikasmasuk_id)),array('class' => 'btn btn-green')); ?>
		<?php echo CHtml::link('Print BKK', $this->createUrl('/printKwitansi/kaskeluar', array('id'=>$kaskeluar->bukitkaskeluar_id)), array('disabled'=>$kaskeluar->isNewRecord,'class'=>'print btn btn-green', 'target'=>'_blank','rel'=>'tooltip','title'=>'Klik Untuk Mencetak Kwitansi BKK'));?>
		<?php echo CHtml::link('Ulang', $this->createUrl('index'),array('class' => 'btn btn-default')); ?>
		</div>
	</div>
</div>

<?php $this->endWidget(); ?>
