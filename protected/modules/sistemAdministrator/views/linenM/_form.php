<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'salinen-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);', 'enctype' => 'multipart/form-data'),
	'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">

		<div class = "span4">
			<div class="control-group ">
				<?php echo $form->labelEx($model, 'barang_id', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo CHtml::hiddenField('barang_id'); ?>
					<?php 
						$this->widget('MyJuiAutoComplete', array(
							'name'=>'namaBarang',
							'source'=>'js: function(request, response) {
										   $.ajax({
											   url: "'.$this->createUrl('AutocompleteBarang').'",
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
										$(this).val("");
										return false;
									}',
								   'select'=>'js:function( event, ui ) {
										$(this).val(ui.item.value);
										$("#barang_id").val(ui.item.barang_id);
										$("#namaBarang").val(ui.item.barang_nama);
										return false;
									}',
							),
							'htmlOptions'=>array(
								'onkeypress'=>"return $(this).focusNextInputField(event)",
								'onblur' => 'if(this.value === "") $("#barang_id").val(""); '
							),
							'tombolDialog'=>array('idDialog'=>'dialogBarang'),
						)); 
						?>

				</div>
			</div>
			<?php echo $form->textFieldRow($model,'noregisterlinen',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
			<?php echo $form->dropDownListRow($model,'bahanlinen_id',CHtml::listData(BahanlinenM::model()->findAll(), 'bahanlinen_id', 'bahanlinen_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
            <?php echo $form->dropDownListRow($model,'jenislinen_id',CHtml::listData(JenislinenM::model()->findAll(), 'jenislinen_id', 'jenislinen_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
            <?php echo $form->textFieldRow($model,'kodelinen',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
			<?php echo $form->textFieldRow($model,'namalinen',array('class'=>'span3', 'onkeyup'=>"namaLain(this)", 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
		</div>
		<div class = "span4">
			<?php echo $form->textFieldRow($model,'namalainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
			<?php echo $form->textFieldRow($model,'merklinen',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
			<div class="control-group ">
				<?php echo $form->labelEx($model, 'beratlinen', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'beratlinen',array('class'=>'span3 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
					<?php echo $form->label($model,'gram');?>
				</div>
			</div>
			<?php echo $form->textFieldRow($model,'tahunbeli',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>6)); ?>
			<?php echo $form->textFieldRow($model,'warna',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
			<?php echo $form->dropDownListRow($model,'rakpenyimpanan_id',CHtml::listData(LokasipenyimpananM::model()->findAll(), 'instalasi_id', 'lokasipenyimpanan_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
		</div>
		<div class="span4">
			<?php echo $form->dropDownListRow($model,'satuanlinen',LookupM::getItems('satuanbarang'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
			<?php echo $form->textFieldRow($model,'tglregisterlinen',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			<div class="control-group">
				<?php echo $form->labelEx($model, 'gambarlinen',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo CHtml::activeFileField($model, 'gambarlinen') ?>
				</div>
			</div>
			<?php echo $form->textFieldRow($model,'jmlcucilinen',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			<?php echo $form->checkBoxRow($model,'linen_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
				
		</div>
	</div>
	<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('create'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Linen',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogBarang',
    'options' => array(
        'title' => 'Daftar Barang',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 570,
        'resizable' => false,
    ),
));

$modBarang = new SABarangM('search');
$modBarang->unsetAttributes();
if (isset($_GET['SABarangM'])){
    $modBarang->attributes = $_GET['SABarangM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'barang-t-grid',
    'dataProvider'=>$modBarang->search(),
    'filter'=>$modBarang,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectBarang",
				"onClick" => "
					$(\'#barang_id\').val(\'$data->barang_id\');
					$(\'#namaBarang\').val(\'$data->barang_nama\');
					$(\'#dialogBarang\').dialog(\'close\');
					return false;"))',
        ),
        array(
			'name'=>'barang_id',
			'value'=>'$data->barang_id',
			'filter'=>false,
		),
        'bidang.subkelompok.kelompok.golongan.golongan_nama',
        'bidang.subkelompok.kelompok.kelompok_nama',
        'bidang.subkelompok.subkelompok_nama',
        'bidang.bidang_nama',
        'barang_nama',
        array(
            'name'=>'barang_satuan',
            'filter'=>LookupM::getItems('satuanbarang'),
            'value'=>'$data->barang_satuan',
        ),
        'barang_ukuran',
        'barang_bahan',
    ),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
$this->endWidget();
?>

<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('SALinenM_namalainnya').value = nama.value.toUpperCase();
    }
</script>