<div class = "white-container">
<style>
	.num , .num-des {
		text-align: right;
	}
	#tombolAnggota{
		cursor: pointer;	
	}
	.input-group-addon{
		cursor: pointer;	
	}
</style>

<?php
/* @var $this PermohonanPinjamanController */

$this->breadcrumbs=array(
	'Permohonan Pinjaman',
);
?>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'permohonan-pinjaman-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'focus' => '#adcontact-form div.form-group:first-child div input',
	'htmlOptions'=>array('class'=>'form-groups-bordered','onKeyPress'=>'return disableKeyPress(event);', //, 'onsubmit'=>'return requiredCheck(this);', 
	'enctype' => 'multipart/form-data'),
)); ?>
<legend class="rim2">Permohonan Pinjaman</legend>
<div class="col-md-12">
	<div class="panel panel-primary">		
		<div class="panel-body" style="text-align: center">
                    <fieldset class="box" id="form-datapegawai">
                        <legend class="rim"><span class='judul'>Data Anggota </span></legend>
                        <div class="row-fluid">
                            <?php echo $this->renderPartial('subview/_anggota', array('form'=>$form, 'anggota'=>$anggota, 'pegawai'=>$pegawai, 'golongan'=>$golongan, 'permintaan'=>$permintaan)); ?>
                        </div>
                    </fieldset>
                    
                     <fieldset class="box" id="form-datapegawai">
                        <legend class="rim"><span class='judul'>Data Anggota </span></legend>
                        <div class="row-fluid">
                            <?php echo $this->renderPartial('subview/_permintaan', array('form'=>$form, 'permintaan'=>$permintaan, 'potongan'=>$potongan)); ?>
                        </div>
                     </fieldset>
			<?php /*$this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>'Simpan',
				'visible'=>$permintaan->isNewRecord,
				'htmlOptions'=>array('class'=>'btn-success', 'onkeypress'=>'return formSubmit(this,event)', 'onclick'=>'if (!cekValidasi()) return false; '),
			));*/  ?>
                        <?php if ($permintaan->isNewRecord) echo CHtml::submitButton('Simpan', array('class'=>'btn btn-primary')); ?>
			<?php //echo $this->renderPartial('subview/_dialog', array(), true); ?>
			<?php echo !$permintaan->isNewRecord?
			CHtml::link('Print', $this->createUrl('print', array('id'=>$permintaan->permohonanpinjaman_id)), array('target'=>'_blank','class' => 'btn btn-success'))
			:CHtml::link('Print', '', array('class' => 'btn btn-success', 'disabled'=>true)); ?>
			<?php echo CHtml::link('Ulang', $this->createUrl('index'), array('class' => 'btn btn-default')); ?>
		</div>
	</div>
</div>

<?php $this->endWidget(); ?>
<?php //echo $this->renderPartial('subview/_js'); ?>
</div>