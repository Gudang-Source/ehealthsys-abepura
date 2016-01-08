<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sapemeriksaanlab-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#'.CHtml::activeId($model, 'pemeriksaanlab_urutan'),
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">

		<div class = "span4">
			<?php echo $form->textFieldRow($model,'pemeriksaanlab_urutan',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			<?php echo $form->dropDownListRow($model,'jenispemeriksaanlab_id',CHtml::listData(JenispemeriksaanlabM::model()->findAll(array('order'=>'jenispemeriksaanlab_urutan'),'jenispemeriksaanlab_aktif = true'), 'jenispemeriksaanlab_id', 'jenispemeriksaanlab_nama'),array('empty'=>'-- Pilih --','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			<div class="control-group ">
				<?php echo $form->labelEx($model,'Tindakan / Pemeriksaan <span class="required">*</span>',array('class'=>'control-label required')); ?>
					<div class="controls">
					<?php echo $form->hiddenField($model,'daftartindakan_id'); ?>
					<?php 
							$model->daftartindakan_nama = !empty($model->daftartindakan_id) ? $model->daftartindakan->daftartindakan_nama : " ";
							$this->widget('MyJuiAutoComplete', array(
											'model'=>$model,
											'name'=>'daftartindakan_nama',
											//'value'=>$model,
											'attribute'=>'daftartindakan_nama',
											'source'=>'js: function(request, response) {
														   $.ajax({
															   url: "'.$this->createUrl('AutocompleteTindakan').'",
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
														$("#'.CHtml::activeId($model, 'daftartindakan_id').'").val(ui.item.daftartindakan_id);
														$("#daftartindakan_nama").val(ui.item.daftartindakan_nama);
														return false;
													}',
											),
//											'htmlOptions'=>array(
//												'onkeypress'=>"return $(this).focusNextInputField(event)",
//												
//											),
											'tombolDialog'=>array('idDialog'=>'dialogTindakan'),
											'htmlOptions'=>array('placeholder'=>'Ketik Nama Tindakan','rel'=>'tooltip','title'=>'Ketik Nama Tindakan','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3'),
										)); 
						 ?>
				</div>
			</div>
		</div>
		<div class = "span4">
			<?php echo $form->textFieldRow($model,'pemeriksaanlab_kode',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
			<?php echo $form->textFieldRow($model,'pemeriksaanlab_nama',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>500)); ?>
		</div>
		<div class = "span4">
			<?php echo $form->textFieldRow($model,'pemeriksaanlab_namalainnya',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>500)); ?>
			<?php echo $form->checkBoxRow($model,'pemeriksaanlab_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
		</div>
	</div>
	<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('create'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Pemeriksaan Lab',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php 
		$content = $this->renderPartial($this->path_view.'tips/tipsCreate',array(),true);
		$this->widget('UserTips',array('type'=>'create','content'=>$content));
		?>
		</div>
	</div>
<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari data Bidang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
	'id'=>'dialogTindakan',
	'options'=>array(
		'title'=>'Daftar Tindakan',
		'autoOpen'=>false,
		'modal'=>true,
		'width'=>980,
		'height'=>480,
		'resizable'=>false,
	),
));

$modTindakan = new SADaftarTindakanM('search');
$modTindakan->unsetAttributes();
if(isset($_GET['SADaftarTindakanM'])){
	$modTindakan->attributes = $_GET['SADaftarTindakanM'];
	$modTindakan->daftartindakan_nama=$_GET['SADaftarTindakanM']['daftartindakan_nama'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'sainstalasi-m-grid',
	'dataProvider'=>$modTindakan->searchDialog(),
	'filter'=>$modTindakan,
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
								"id" => "selectTindakan",
								"onClick" => "
								$(\"#'.CHtml::activeId($model, 'daftartindakan_id').'\").val(\'$data->daftartindakan_id\');
								$(\"#daftartindakan_nama\").val(\'$data->daftartindakan_nama\');
								$(\'#dialogTindakan\').dialog(\'close\');return false;"))'
			),
			'kategoritindakan_nama',
			'kelompoktindakan_nama',
			'daftartindakan_kode',
			'daftartindakan_nama',
		),
		'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
?>
