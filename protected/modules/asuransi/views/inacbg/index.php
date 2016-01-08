<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
<div class="white-container">
	<legend  class="rim2">INA-CBG's <b>(Groupper)</b></legend>
	<?php 
		$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
			'id'=>'inacbg-t-form',
			'enableAjaxValidation'=>false,
			'type'=>'horizontal',
			'htmlOptions'=>array(
				'onKeyPress'=>'return disableKeyPress(event);',
				'onsubmit'=>'return requiredCheck(this);'),
			'focus'=>'#',
		)); 
	?>
	<?php 
		if(isset($_GET['sukses'])){ 
			Yii::app()->user->setFlash('success', "Data Pemesanan Kamar berhasil dibuat !");
		}
	?>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
	
	<div class="row-fluid">
		<div class="span12">
			<fieldset class="box" id="pencarian-data">
				<legend class="rim">Pencarian Data</legend>
				<?php $this->renderPartial($this->path_view_inacbg.'_formPencarian',array('form'=>$form,'modSEP'=>$modSEP)); ?>
			</fieldset>
		</div>

		<div class="span12">
			<fieldset class="box" id="data-sep">
				<legend class="rim">Data SEP</legend>
				<?php $this->renderPartial($this->path_view_inacbg.'_formSEP',array('form'=>$form,'modSEP'=>$modSEP)); ?>
			</fieldset>
		</div>
		
		<div class="span12">
			<fieldset class="box" id="data-kunjungan-pasien">
				<legend class="rim">Data Kunjungan Pasien</legend>
				<?php $this->renderPartial($this->path_view_inacbg.'_formKunjunganPasien',array('form'=>$form,'model'=>$model,'modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,'modPasienAdmisi'=>$modPasienAdmisi,'modPasienPulang'=>$modPasienPulang,'modPasienMorbiditas'=>$modPasienMorbiditas)); ?>
			</fieldset>
		</div>
		<div class="span6">
			<fieldset class="box" id="pencarian-cbg">
				<legend class="rim">CBG</legend>
				<?php $this->renderPartial($this->path_view.'_formCBG',array('form'=>$form)); ?>
			</fieldset>
		</div>
		<div class="span6">
			<fieldset class="box" id="pencarian-cmg">
				<legend class="rim">CMG</legend>
				<?php $this->renderPartial($this->path_view.'_formCMG',array('form'=>$form)); ?>
			</fieldset>
		</div>
		
		<div class="span12">
			<fieldset class="box" id="pencarian-grouper">
				<legend class="rim">Grouper</legend>
				<?php $this->renderPartial($this->path_view_inacbg.'_formGrouper',array('form'=>$form)); ?>
			</fieldset>
		</div>
		
		<div class="form-actions">
			<?php 
				$disabledSave = isset($_GET['sukses']) ? true : false;
				echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('disabled'=>$disabledSave,'class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'formSubmit(this,event);', 'onkeypress'=>'formSubmit(this,event);')); 
				echo "&nbsp;";
				if(!isset($_GET['sukses'])){
					echo CHtml::link(Yii::t('mds', '{icon} Finalisasi', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'disabled'=>'true'));
					echo "&nbsp;";
				}else{
					echo CHtml::link(Yii::t('mds', '{icon} Finalisasi', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"updateFinalisasi(".$model->inacbg_id.");return false"));
					echo "&nbsp;";
				}
			?> 
		</div>
	</div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view.'_jsFunctions',array()); ?>
<?php $this->renderPartial($this->path_view_inacbg.'_jsFunctions',array('model'=>$model,
			'modSEP'=>$modSEP,
			'modPendaftaran'=>$modPendaftaran,
			'modPasien'=>$modPasien,
			'modPasienAdmisi'=>$modPasienAdmisi,
			'modPasienPulang'=>$modPasienPulang,
			'modPasienMorbiditas'=>$modPasienMorbiditas)); ?>

 <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id' => 'dialogRincian',
	'options' => array(
		'title' => 'Rincian Tagihan Pasien',
		'autoOpen' => false,
		'modal' => true,
		'width' => 1000,
		'height' => 550,
		'resizable' => false,
	),
));
?>
<div class="divForForm"></div>
<?php $this->endWidget(); ?>