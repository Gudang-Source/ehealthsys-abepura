<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'saloket-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">

		<div class = "span4">
			<?php echo $form->textFieldRow($model,'loket_nama',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
			<?php echo $form->textFieldRow($model,'loket_namalain',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
			<?php echo $form->textAreaRow($model,'loket_fungsi',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
		</div>
		<div class = "span4">
			<?php echo $form->textFieldRow($model,'loket_singkatan',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>1)); ?>
			
				<?php echo $form->textFieldRow($model,'loket_nourut',array('class'=>'span3 integer', 'onkeyup'=>'numberOnly(this);', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
		
			<?php echo $form->textFieldRow($model,'loket_formatnomor',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>5)); ?>
			<?php echo $form->textFieldRow($model,'loket_maksantrian',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			<?php echo $form->checkBoxRow($model,'loket_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
		</div>
		<div class = "span4">
			<div class="control-group ">
				<?php echo $form->labelEx($model,'Cara Bayar <span class="required">*</span>',array('class'=>'control-label required')); ?>
					<div class="controls">
					<?php echo $form->hiddenField($model,'carabayar_id'); ?>
					<?php 
							$model->carabayar_nama = !empty($model->carabayar_id) ? $model->carabayar->carabayar_nama : "";
							$this->widget('MyJuiAutoComplete', array(
											'model'=>$model,
											'attribute'=>'carabayar_nama',
											'source'=>'js: function(request, response) {
														   $.ajax({
															   url: "'.$this->createUrl('AutocompleteCarabayar').'",
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
														$("#'.CHtml::activeId($model, 'carabayar_id').'").val(ui.item.carabayar_id);
														$("#carabayar_nama").val(ui.item.carabayar_nama);
														return false;
													}',
											),
											'htmlOptions'=>array(
												'onkeypress'=>"return $(this).focusNextInputField(event)",
												
											),
											'tombolDialog'=>array('idDialog'=>'dialogCarabayar'),
										)); 
						 ?>
				</div>
			</div>
			<?php echo $form->textFieldRow($model,'filesuara',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>500)); ?>
			<?php echo $form->checkBoxRow($model,'ispendaftaran', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			<?php echo $form->checkBoxRow($model,'iskasir', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
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
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Loket',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php 
                $content = $this->renderPartial($this->path_tips.'tipsaddedit3a',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));                 
                ?>
		</div>
	</div>
<?php $this->endWidget(); ?>

<?php
	//========= Dialog buat cari Cara Bayar =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
	'id'=>'dialogCarabayar',
	'options'=>array(
		'title'=>'Daftar Carabayar',
		'autoOpen'=>false,
		'modal'=>true,
		'width'=>980,
		'height'=>480,
		'resizable'=>false,
	),
));

$modCarabayar = new SACaraBayarM('search');
$modCarabayar->unsetAttributes();
if(isset($_GET['SACaraBayarM'])){
	$modCarabayar->attributes = $_GET['SACaraBayarM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'carabayar-m-grid',
	'dataProvider'=>$modCarabayar->search(),
	'filter'=>$modCarabayar,
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
								"id" => "selectAlatmedis",
								"onClick" => "
								$(\"#'.CHtml::activeId($model, 'carabayar_id').'\").val(\'$data->carabayar_id\');
								$(\"#'.CHtml::activeId($model, 'carabayar_nama').'\").val(\'$data->carabayar_nama\');
								
								$(\'#dialogCarabayar\').dialog(\'close\');return false;"))'
			),
			'carabayar_id',
			'carabayar_nama',
			'metode_pembayaran',
			'carabayar_loket',
		),
		'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
?>
