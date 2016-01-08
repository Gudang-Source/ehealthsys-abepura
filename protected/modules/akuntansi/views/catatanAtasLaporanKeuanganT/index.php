<div class="white-container">
<legend class="rim2">Transaksi <b>Catatan atas Laporan Keuangan</b></legend>
<?php 
	if(!empty($_GET['sukses'])){        
?>
<?php echo Yii::app()->user->setFlash('success',"Data berhasil disimpan !"); ?>
<?php } ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'calk-t-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'enctype' => 'multipart/form-data'),
	'focus'=>'#namaBarang',
)); ?>

<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

<?php // echo $form->errorSummary($model); ?>
	<fieldset class="box">
		<legend class="rim">Pencarian</legend>
		<?php $this->renderPartial('_search',array('model'=>$model,'form'=>$form));?>
	</fieldset>

	<fieldset class="box">
		<legend class="rim">Catatan atas Laporan Keuangan</legend>
		<?php $this->renderPartial('_calk', array('model'=>$model,'form'=>$form,)); ?>		
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
		<?php echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')",'disabled'=>$disablePrint)); ?>
		<?php
			$content = $this->renderPartial('/tips/transaksi',array(),true);
			$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
		?>
	</div>
<?php $this->endWidget(); ?>
</div>
<script type="text/javascript">
function print(caraPrint)
{
    var calk_id = '<?php echo isset($_GET['calk_id']) ? $_GET['calk_id'] : null; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&calk_id='+calk_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}
</script>
