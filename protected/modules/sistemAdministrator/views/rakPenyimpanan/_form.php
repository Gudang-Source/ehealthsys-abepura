<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sarakpenyimpanan-m-form',
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
				<?php echo $form->labelEx($model,'Lokasi Penyimpanan <span class="required">*</span>',array('class'=>'control-label required')); ?>
					<div class="controls">
					<?php echo $form->hiddenField($model,'lokasipenyimpanan_id'); ?>
					<?php 
							$model->lokasipenyimpanan_nama = !empty($model->lokasipenyimpanan_id) ? $model->lokasipenyimpanan->lokasipenyimpanan_nama : "";
							$this->widget('MyJuiAutoComplete', array(
											'model'=>$model,
											'attribute'=>'lokasipenyimpanan_nama',
											'source'=>'js: function(request, response) {
														   $.ajax({
															   url: "'.$this->createUrl('AutocompleteLokasipenyimpanan').'",
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
														$("#'.CHtml::activeId($model, 'lokasipenyimpanan_id').'").val(ui.item.lokasipenyimpanan_id);
														$("#lokasipenyimpanan_nama").val(ui.item.lokasipenyimpanan_nama);
														return false;
													}',
											),
											'htmlOptions'=>array(
												'onkeypress'=>"return $(this).focusNextInputField(event)",
												
											),
											'tombolDialog'=>array('idDialog'=>'dialogLokasipenyimpanan'),
										)); 
						 ?>
				</div>
			</div>
			<?php echo $form->textFieldRow($model,'rakpenyimpanan_label',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
			<?php echo $form->textFieldRow($model,'rakpenyimpanan_kode',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>5)); ?>
			<?php echo $form->textFieldRow($model,'rakpenyimpanan_nama',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
			<?php echo $form->textFieldRow($model,'rakpenyimpanan_namalain',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
		</div>
		<div class = "span4">
			<?php echo $form->checkBoxRow($model,'rakpenyimpanan_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
		</div>
		<div class="span4">
				
		</div>
	</div>
	<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('create'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Rak Penyimpanan',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		 <?php
                            $content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit3a',array(),true);
                            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                        ?>
		</div>
	</div>
<?php $this->endWidget(); ?>

<?php
//========= Dialog =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
	'id'=>'dialogLokasipenyimpanan',
	'options'=>array(
		'title'=>'Daftar Lokasi Penyimpanan',
		'autoOpen'=>false,
		'modal'=>true,
		'width'=>980,
		'height'=>480,
		'resizable'=>false,
	),
));

$modLokasipenyimpanan = new SALokasipenyimpananM('search');
$modLokasipenyimpanan->unsetAttributes();
if(isset($_GET['SALokasipenyimpananM'])){
	$modLokasipenyimpanan->attributes = $_GET['SALokasipenyimpananM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'lokasipenyimpanan-m-grid',
	'dataProvider'=>$modLokasipenyimpanan->searchDialog(),
	'filter'=>$modLokasipenyimpanan,
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
								"id" => "selectLokasipenyimpanan",
								"onClick" => "
								$(\"#'.CHtml::activeId($model, 'lokasipenyimpanan_id').'\").val(\'$data->lokasipenyimpanan_id\');
								$(\"#'.CHtml::activeId($model, 'lokasipenyimpanan_nama').'\").val(\'$data->lokasipenyimpanan_nama\');
								
								$(\'#dialogLokasipenyimpanan\').dialog(\'close\');return false;"))'
			),
			'lokasipenyimpanan_id',
			array(
				'name'=>'instalasi_id',
				'value'=>'$data->instalasi->instalasi_nama',
				'filter'=> CHtml::dropDownList('SALokasipenyimpananM[instalasi_id]',$modLokasipenyimpanan->instalasi_id,CHtml::listData($modLokasipenyimpanan->getInstalasiItems(), 'instalasi_id', 'instalasi_nama'),array('empty'=> '-- Pilih --')),
			),
			'lokasipenyimpanan_kode',
			'lokasipenyimpanan_nama',
			'lokasipenyimpanan_namalain',
		),
		'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
?>
