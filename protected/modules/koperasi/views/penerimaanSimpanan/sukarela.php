<?php
/* @var $this TransaksiSimpananController */

$this->breadcrumbs=array(
	'Transaksi Simpanan'=>array('/simpanan/transaksiSimpanan'),
	'Sukarela',
);
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'simpanan-sukarela-pokok-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'focus' => '#adcontact-form div.form-group:first-child div input',
	'htmlOptions'=>array('class'=>'form-groups-bordered','onKeyPress'=>'return disableKeyPress(event);', //, 'onsubmit'=>'return requiredCheck(this);', 
	'enctype' => 'multipart/form-data'),
)); 

// echo $form->errorSummary($simpanan);
// echo $form->errorSummary($anggota);
// echo $form->errorSummary($kasmasuk);

?>

<div class="col-md-12">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<div class="panel-title">
				Simpanan Sukarela
			</div>
		</div>
		<div class="panel-body">
			<div class="form-group">
				<div class="col-sm-12" style="text-align: center;">
					<!-- view utama -->
					<?php echo $this->renderPartial('subview/_pegawai', array('pegawai'=>$pegawai, 'anggota'=>$anggota, 'form'=>$form)); ?>
					<?php echo $this->renderPartial('subview/_simpanan', array('simpanan'=>$simpanan, 'kasmasuk'=>$kasmasuk, 'form'=>$form)); ?>
					<?php echo $this->renderPartial('subview/_signature', array('kasmasuk'=>$kasmasuk, 'form'=>$form)); ?>
					
					<!-- view dialog -->
					<?php echo Yii::app()->modal->register($this->renderPartial('subview/_dialog', null, true)); ?>
					
					<!-- submit/batal -->
					<?php $this->widget('bootstrap.widgets.TbButton', array(
						'buttonType'=>'submit',
						'type'=>'primary',
						'label'=>'Simpan',
						'visible'=>$simpanan->isNewRecord,
						'htmlOptions'=>array('class'=>'btn-success', 'onkeypress'=>'return formSubmit(this,event)', 'onclick'=>'if (!cekValidasi()) return false;',),
					)); ?>
					<?php echo CHtml::link('Print BKM', $this->createUrl('/printKwitansi/kasmasuk', array('id'=>$kasmasuk->buktikasmasuk_id)), array('disabled'=>$kasmasuk->isNewRecord,'class'=>'print btn btn-green', 'target'=>'_blank','rel'=>'tooltip','title'=>'Klik Untuk Mencetak Kwitansi BKM'));?>
					<?php echo CHtml::link('Ulang', $this->createUrl('sukarela'),array('class' => 'btn btn-default')); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->endWidget(); ?>
<?php echo $this->renderPartial('subview/_js', array('form'=>$form)); ?>
<?php if (!$kasmasuk->isNewRecord): ?>
<script type="text/javascript">
   $(window).load(function() {
 		 $("html, body").animate({ scrollTop: $(document).height() }, 1000);
	});
	$('.print').tooltip('show');
</script>
<?php endif; ?>