<div class="white-container">
	<?php
		$sukses = null;
		if(isset($_GET['sukses'])){
			$sukses = $_GET['sukses'];
		}
		if($sukses > 0){ 
			Yii::app()->user->setFlash('success',"Data Penjadwalan Pegawai berhasil disimpan !");
			$this->widget('bootstrap.widgets.BootAlert');
		}
	?>
	<legend class="rim2">Penjadwalan <b>Pegawai</b></legend>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'kppenjadwalan-t-form',
    'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>
<?php echo $form->errorSummary($model); ?>
	
	<fieldset class="box" id="datapenjadwalan">
		<legend class="rim">Data Penjadwalan</legend>
		<?php $this->renderPartial('_dataPenjadwalan',array('form'=>$form,'model'=>$model,'instalasiAsal'=>$instalasiAsal,'ruanganAsal'=>$ruanganAsal)); ?>
	</fieldset>
	
	<fieldset class="box">	
		<legend class="rim">Shift Pegawai</legend>
		<?php $this->renderPartial('_shiftPegawai',array('form'=>$form,'model'=>$model)); ?>
	</fieldset>
	
	<fieldset class="box">
		<legend class="rim">Data Tambahan</legend>
		<?php $this->renderPartial('_dataTambahan',array('form'=>$form,'model'=>$model)); ?>
	</fieldset>
    <div class="form-actions">
        <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) :
        Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
        array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan')); ?>
        <?php if(!isset($_GET['frame'])){
			echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl($this->id.'/index'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);'));
		} ?>
    </div>
<?php $this->endWidget(); ?>
</div>
<?php $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model,'modPenjadwalanDetail'=>$modPenjadwalanDetail)); ?>