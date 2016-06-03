<div class="white-container">
<legend class="rim2">Transaksi <b>Penyusutan Aset</b></legend>
<?php 
	if(!empty($_GET['sukses'])){        
?>
<?php echo Yii::app()->user->setFlash('success',"Data Penyusutan Aset berhasil disimpan !"); ?>
<?php } ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'mapenyusutanaset-t-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
	'focus'=>'#namaBarang',
)); ?>

<?php echo $form->errorSummary($model); ?>
	<fieldset class="box">
		<legend class="rim">Data Barang</legend>
                <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
		<?php $this->renderPartial($this->path_view.'_dataBarang',array('model'=>$model,'form'=>$form));?>
	</fieldset>

	<fieldset class="box">
		<legend class="rim">Penyusutan Aset</legend>
		<?php $this->renderPartial($this->path_view.'_penyusutanAset', array('model'=>$model, 'form'=>$form,)); ?>		
	</fieldset>
	
	<div class="block-tabel">
        <h6>Detail <b>Penyusutan Aset</b></h6>
		<div style="overflow-x: scroll;">
			<table class="items table table-striped table-condensed" id="table-detailpenyusutan">
				<thead>
					<tr>
						<th width="3%">No.</th>
						<th>Periode Penyusutan</th>
						<th>Saldo Penyusutan</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
				<tfoot>
				</tfoot>
			</table>
		</div>
	</div>

	<fieldset class="box">
		<legend class="rim">Penjurnalan</legend>
		<?php $this->renderPartial($this->path_view.'_penjurnalan', array('model'=>$model, 'form'=>$form,)); ?>		
	</fieldset>

	<div class="form-actions">
		<?php 
			$sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
			$disableSave = false;
			$disableSave = (!empty($_GET['id'])) ? true : ($sukses > 0) ? true : false;; 
		?>
		<?php $disablePrint = ($disableSave) ? false : true; ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); //formSubmit(this,event) ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
								$this->createUrl($this->module->id.'/Index'), 
								array('class'=>'btn btn-danger',
									'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('Index').'";} ); return false;'));  ?>
		<?php // echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')",'disabled'=>$disablePrint)); ?>
		<?php
			$content = $this->renderPartial('manajemenAset.views.tips/transaksi',array(),true);
			$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
		?>
	</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model)); ?>
</div>
