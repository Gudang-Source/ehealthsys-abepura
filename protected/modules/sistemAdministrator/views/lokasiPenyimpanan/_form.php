<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'salokasipenyimpanan-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">

		<div class = "span4">
			<div class="control-group ">
				<?php echo $form->labelEx($model,'Instalasi <span class="required">*</span>',array('class'=>'control-label required')); ?>
					<div class="controls">
					<?php echo $form->hiddenField($model,'instalasi_id'); ?>
					<?php 
							$model->instalasi_nama = !empty($model->instalasi_id) ? $model->instalasi->instalasi_nama : "";
							$this->widget('MyJuiAutoComplete', array(
											'model'=>$model,
											'attribute'=>'instalasi_nama',
											'source'=>'js: function(request, response) {
														   $.ajax({
															   url: "'.$this->createUrl('AutocompleteInstalasi').'",
															   dataType: "json",
															   data: {
																   term: request.term,
															   },
															   success: function (data) {
																	   response(data);
															   }
														   })
														}',
											 'options'=>array(
												   'showAnim'=>'fold',
												   'minLength' => 2,
												   'focus'=> 'js:function( event, ui ) {
														$(this).val( ui.item.label);
														return false;
													}',
												   'select'=>'js:function( event, ui ) { 
														$("#'.CHtml::activeId($model, 'instalasi_id').'").val(ui.item.instalasi_id);
														$("#instalasi_nama").val(ui.item.instalasi_nama);
														return false;
													}',
											),
											'htmlOptions'=>array(
												'onkeypress'=>"return $(this).focusNextInputField(event)",
												
											),
											'tombolDialog'=>array('idDialog'=>'dialogInstalasi'),
										)); 
						 ?>
				</div>
			</div>
			<?php echo $form->textFieldRow($model,'lokasipenyimpanan_kode',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
			<?php echo $form->textFieldRow($model,'lokasipenyimpanan_nama',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
			<?php echo $form->textFieldRow($model,'lokasipenyimpanan_namalain',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
		</div>
		<div class = "span4">
			<?php echo $form->checkBoxRow($model,'lokasipenyimpanan_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
		</div>
		<div class="span4">
				
		</div>
	</div>
	<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Simpan',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('create'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Lokasi Penyimpanan',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
<?php $this->endWidget(); ?>

<?php
//========= Dialog =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
	'id'=>'dialogInstalasi',
	'options'=>array(
		'title'=>'Daftar Instalasi',
		'autoOpen'=>false,
		'modal'=>true,
		'width'=>980,
		'height'=>480,
		'resizable'=>false,
	),
));

$modInstalasi = new SAInstalasiM('search');
$modInstalasi->unsetAttributes();
if(isset($_GET['SAInstalasiM'])){
	$modInstalasi->attributes = $_GET['SAInstalasiM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'intalasi-m-grid',
	'dataProvider'=>$modInstalasi->searchDialog(),
	'filter'=>$modInstalasi,
		'template'=>"{summary}\n{items}\n{pager}",
		'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-check\"></i>",
							"#",
							array(
								"class"=>"btn-small", 
								"id" => "selectInstalasi",
								"onClick" => "
								$(\"#'.CHtml::activeId($model, 'instalasi_id').'\").val(\'$data->instalasi_id\');
								$(\"#'.CHtml::activeId($model, 'instalasi_nama').'\").val(\'$data->instalasi_nama\');
								
								$(\'#dialogInstalasi\').dialog(\'close\');return false;"))'
			),
			'instalasi_id',
			'instalasi_nama',
			'instalasi_singkatan',
			'instalasi_lokasi',
			'instalasi_namalainnya',
		),
		'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
?>
