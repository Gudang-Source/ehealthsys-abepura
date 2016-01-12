<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'assep-t-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">
		<fieldset class="box" id="noRm">
			<legend class="rim">Data No. Rekam Medik</legend>
			<?php echo $this->renderPartial('_formRekamMedik',array('form'=>$form,'model'=>$model,'modRujukanBpjs'=>$modRujukanBpjs,'modAsuransiPasien'=>$modAsuransiPasien,'modAsuransiPasienBpjs'=>$modAsuransiPasienBpjs)); ?>
		</fieldset>
		
		<fieldset class="box" id="content-bpjs">
			<legend class="rim">Data SEP</legend>
			<?php echo $this->renderPartial('_formSEP',array('form'=>$form,'model'=>$model,'modRujukanBpjs'=>$modRujukanBpjs,'modAsuransiPasien'=>$modAsuransiPasien,'modAsuransiPasienBpjs'=>$modAsuransiPasienBpjs)); ?>
		</fieldset>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
			<?php
				$sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
				$disabledSave = isset($_GET['id']) ? true : ($sukses == 1) ? true : false;
			?>
			<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','disabled'=>$disabledSave)); ?>
			<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
					$this->createUrl('create'), 
					array('class'=>'btn btn-danger',
						  'onclick'=>'return refreshForm(this);')); ?>
			<?php
				if(Yii::app()->user->getState('isbridging')){
					if (isset($model->sep_id)) {
						echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printSEP();return false",'disabled'=>FALSE  ));
					}else{
						echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Belum memiliki No. SEP!','class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;'));
					}
				}else{
					echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Fitur Bridging tidak aktif!','class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;'));
				}
			?>
			<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan SEP',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
			<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
<?php $this->endWidget(); ?>
<?php
	$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
		'id'=>'dialogDiagnosa',
		'options'=>array(
			'title'=>'Pencarian Diagnosa Rujukan',
			'autoOpen'=>false,
			'modal'=>true,
			'width'=>960,
			'height'=>480,
			'resizable'=>false,
		),
	));
	$modDiagnosa = new ARDiagnosaM('search');
	$modDiagnosa->unsetAttributes();
	if(isset($_GET['ARDiagnosaM'])) {
		$modDiagnosa->attributes = $_GET['ARDiagnosaM'];
	}
	$this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'diagnosa-m-grid',
		'dataProvider'=>$modDiagnosa->search(),
		'filter'=>$modDiagnosa,
		'template'=>"{summary}\n{items}\n{pager}",
		'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
				array(
					'header'=>'Pilih',
					'type'=>'raw',
					'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
									"id" => "selectPasien",
									"onClick" => "
										setDiagnosaBpjs(\"$data->diagnosa_kode\",\"$data->diagnosa_nama\");
										setDiagnosa(\"$data->diagnosa_kode\",\"$data->diagnosa_nama\");

										$(\"#dialogDiagnosa\").dialog(\"close\");
									"))',
				),
				'diagnosa_kode',
				'diagnosa_nama',
				'diagnosa_namalainnya',
		),
		'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
	));
	$this->endWidget();
?>
