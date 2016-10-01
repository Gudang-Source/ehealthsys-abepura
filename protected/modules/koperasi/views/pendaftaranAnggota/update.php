<?php
/* @var $this PendaftaranAnggotaController */

$this->breadcrumbs=array(
	'Pendaftaran Anggota',
);
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'pendaftaran-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'focus' => '#adcontact-form div.form-group:first-child div input',
	'htmlOptions'=>array('class'=>'form-groups-bordered','onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);', 'enctype' => 'multipart/form-data'),
)); ?>

<div class="col-md-12">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<div class="panel-title">
				Ubah Anggota
			</div>
		</div>
		<div class="panel-body">
			<?php 
			echo $form->errorSummary($pegawai);
			echo $form->errorSummary($anggota);
			//echo $form->errorSummary($simpanan);
			?>
			<?php echo $form->hiddenField($pegawai, 'pegawai_id'); ?>
			<?php echo $form->hiddenField($anggota, 'keanggotaan_id'); ?>
			<?php echo $this->renderPartial('subview/_pegawai', array('model'=>$pegawai, 'form'=>$form)); ?>
			<?php echo $this->renderPartial('subview/_anggota', array('model'=>$anggota, 'form'=>$form)); ?>
			<?php // echo $this->renderPartial('subview/_simpanan', array('model'=>$simpanan, 'kasmasuk'=>$kasmasuk, 'form'=>$form)); ?>
			
			<div class="form-group">
				<div class="col-sm-12" style="text-align: center;">
					<?php $this->widget('bootstrap.widgets.TbButton', array(
						'buttonType'=>'submit',
						'type'=>'primary',
						'label'=>'Simpan',
						'htmlOptions'=>array('class'=>'btn-success', 'onkeypress'=>'return formSubmit(this,event)',),
					)); ?>
					<?php echo CHtml::link('Batal', $this->createUrl('informasi'),array('class' => 'btn btn-default')); ?>
				</div>
			</div>
			<?php echo $this->renderPartial('subview/_js'); ?>
			<?php echo Yii::app()->modal->register($this->renderPartial('subview/_dialog', null, true)); ?>
		</div>
	</div>
</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">

$('.numbersOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9]*/g, "");
var msg = "Only Integer Values allowed.";

if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}

if (value != '') {
orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
$(this).val(orignalValue);
}
});

$('.alphaonlyK').bind('keyup blur',function(){ 
    $(this).val( $(this).val().replace(/[^a-zA-Z ]/g,'') );}
);

function convertToUpper(obj)
{
    var string = obj.value;
    $(obj).val(string.toUpperCase());
}
</script>