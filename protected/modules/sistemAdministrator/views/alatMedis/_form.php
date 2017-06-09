<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'saalatmedis-m-form',
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
                                                                                                'class' => 'hurufs-only'
												
											),
											'tombolDialog'=>array('idDialog'=>'dialogInstalasi'),
										)); 
						 ?>
				</div>
			</div>
			<div class="control-group ">
				<?php echo $form->labelEx($model,'Jenis Alat Medis <span class="required">*</span>',array('class'=>'control-label required')); ?>
					<div class="controls">
					<?php echo $form->hiddenField($model,'jenisalatmedis_id'); ?>
					<?php 
							$model->jenisalatmedis_nama = !empty($model->jenisalatmedis_id) ? $model->jenisalatmedis->jenisalatmedis_nama : "";
							$this->widget('MyJuiAutoComplete', array(
											'model'=>$model,
											'attribute'=>'jenisalatmedis_nama',
											'source'=>'js: function(request, response) {
														   $.ajax({
															   url: "'.$this->createUrl('AutocompleteJenisalatmedis').'",
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
														$("#'.CHtml::activeId($model, 'jenisalatmedis_id').'").val(ui.item.jenisalatmedis_id);
														$("#jenisalatmedis_nama").val(ui.item.jenisalatmedis_nama);
														return false;
													}',
											),
											'htmlOptions'=>array(
												'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                                            'class' => 'hurufs-only'
												
											),
											'tombolDialog'=>array('idDialog'=>'dialogJenisalatmedis'),
                                                            
										)); 
						 ?>
				</div>
			</div>
			<?php echo $form->textFieldRow($model,'alatmedis_noaset',array('class'=>'span3 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style' => 'text-align:right;')); ?>
			<?php echo $form->textFieldRow($model,'alatmedis_nama',array('class'=>'span3 kode-alatmedis', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
			<?php echo $form->textFieldRow($model,'alatmedis_namalain',array('class'=>'span3 hurufs-only', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
			<?php echo $form->checkBoxRow($model,'alatmedis_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
		</div>
		<div class = "span4">
			<?php echo $form->textFieldRow($model,'alatmedis_kode',array('class'=>'span3 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>2, 'style' => 'text-align:right;')); ?>
			<?php echo $form->textFieldRow($model,'alatmedis_format',array('class'=>'span3 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10, 'style' => 'text-align:right;')); ?>
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
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Alat Medis',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php  
                        $tips = array(
                            '0' => 'autocomplete-search',
                            '1' => 'simpan',
                            '2' => 'ulang',
                        );
                        $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips' => $tips),true);
                        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
		</div>
	</div>
<?php $this->endWidget(); ?>
<?php
//========= Dialog buat cari data jenisalatmedis =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
	'id'=>'dialogJenisalatmedis',
	'options'=>array(
		'title'=>'Daftar Jenis Alat Medis',
		'autoOpen'=>false,
		'modal'=>true,
		'width'=>980,
		'height'=>580,
		'resizable'=>false,
	),
));

$modJenis = new SAJenisalatmedisM('search');
$modJenis->unsetAttributes();
if(isset($_GET['SAJenisalatmedisM'])){
	$modJenis->attributes = $_GET['SAJenisalatmedisM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'jenisalatmedis-m-grid',
	'dataProvider'=>$modJenis->searchDialog(),
	'filter'=>$modJenis,
		'template'=>"{summary}\n{items}\n{pager}",
		'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>",
							"#",
							array(
								"class"=>"btn-small", 
								"id" => "selectAlatmedis",
								"onClick" => "
								$(\"#'.CHtml::activeId($model, 'jenisalatmedis_id').'\").val(\'$data->jenisalatmedis_id\');
								$(\"#'.CHtml::activeId($model, 'jenisalatmedis_nama').'\").val(\'$data->jenisalatmedis_nama\');
								
								$(\'#dialogJenisalatmedis\').dialog(\'close\');return false;"))'
			),
			'jenisalatmedis_id',
			'jenisalatmedis_nama',
			'jenisalatmedis_namalain',
		),
		'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
?>
<?php
//========= Dialog buat cari data Instalasi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
	'id'=>'dialogInstalasi',
	'options'=>array(
		'title'=>'Daftar Instalasi',
		'autoOpen'=>false,
		'modal'=>true,
		'width'=>980,
		'height'=>580,
		'resizable'=>false,
	),
));

$modInstalasi = new SAInstalasiM('search');
$modInstalasi->unsetAttributes();
if(isset($_GET['SAInstalasiM'])){
	$modInstalasi->attributes = $_GET['SAInstalasiM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'instalasi-m-grid',
	'dataProvider'=>$modInstalasi->searchDialog(),
	'filter'=>$modInstalasi,
		'template'=>"{summary}\n{items}\n{pager}",
		'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>",
							"#",
							array(
								"class"=>"btn-small", 
								"id" => "selectAlatmedis",
								"onClick" => "
								$(\"#'.CHtml::activeId($model, 'instalasi_id').'\").val(\'$data->instalasi_id\');
								$(\"#'.CHtml::activeId($model, 'instalasi_nama').'\").val(\'$data->instalasi_nama\');
								
								$(\'#dialogInstalasi\').dialog(\'close\');return false;"))'
			),
			'instalasi_id',
			'instalasi_nama',
			'instalasi_namalainnya',
			'instalasi_lokasi',
		),
		'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
?>
