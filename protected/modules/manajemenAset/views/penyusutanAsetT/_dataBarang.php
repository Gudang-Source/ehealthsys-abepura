<div class="row-fluid">
	<div class="span4">
		<div class="control-group ">
			<?php echo $form->labelEx($model, 'barang_id', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php echo CHtml::hiddenField('barang_id','',array('readonly'=>true)); ?>
				<?php echo CHtml::hiddenField('inv_id','',array('readonly'=>true)); ?>
				<?php echo CHtml::hiddenField('nama_inv','',array('readonly'=>true)); ?>
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
									$("#'.CHtml::activeId($model,'hargaperolehan').'").val(ui.item.barang_harganetto);
									setAutoLoad(ui.item.barang_id);
									return false;
								}',
						),
						'htmlOptions'=>array(
							'onkeyup'=>"return $(this).focusNextInputField(event)",
							'onblur' => 'if(this.value === "") $("#barang_id").val(""); '
						),
						'tombolDialog'=>array('idDialog'=>'dialogBarangSusut'),
					)); 
					?>

			</div>
		</div>
		<?php echo $form->textFieldRow($model,'kodeInventarisasi',array('class'=>'span3','onkeypress'=>'return $(this).focusNextInputField(event)','readonly'=>true)); ?>
	</div>
        <div class="span4">
            <?php echo $form->textFieldRow($model,'noRegister',array('class'=>'span3','onkeypress'=>'return $(this).focusNextInputField(event)','readonly'=>true)); ?>
            <?php echo $form->textFieldRow($model,'hargaperolehan',array('class'=>'span3 integer2','onkeypress'=>'return $(this).focusNextInputField(event)','readonly'=>true)); ?>
        </div>
	<div class="span4">
		<div class="control-group ">
			<?php echo CHtml::label('Tanggal Perolehan Barang', 'tglPerolehanBarang', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($model,'tglPerolehanBarang',array('class'=>'span3','onkeypress'=>'return $(this).focusNextInputField(event)','readonly'=>true)); ?>
			</div>
		</div>
		<div class="control-group ">
			<?php echo $form->labelEx($model, 'umurekonomis', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($model,'umurekonomis',array('class'=>'span3 integer2','onkeypress'=>'return $(this).focusNextInputField(event)','readonly'=>true)); ?>
				<?php echo CHtml::activeLabel($model, 'tahun') ?>
			</div>
		</div>
	</div>
</div>
<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogBarangSusut',
    'options' => array(
        'title' => 'Daftar Barang',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 570,
        'resizable' => false,
    ),
));

$modBarang = new MABarangV('search');
$modBarang->unsetAttributes();
if (isset($_GET['MABarangV'])){
    $modBarang->attributes = $_GET['MABarangV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'barangsusut-t-grid',
    'dataProvider'=>$modBarang->searchDialog(),
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
					$(\'#'.CHtml::activeId($model,'hargaperolehan').'\').val(\'".MyFormatter::formatNumberForPrint($data->barang_harganetto)."\');
//					$(\'#'.CHtml::activeId($model,'hargaperolehan').'\').val(\'5000\');
					setAutoLoad($data->barang_id);
					$(\'#dialogBarangSusut\').dialog(\'close\');
					return false;"))',
        ),
		'barang_nama',
		'barang_kode',
		'barang_ekonomis_thn',
		'barang_harganetto',
		
		'invasetlain_namabrg',
		'invasetlain_kode',
		'invasetlain_noregister',
		array(
			'header'=>'Inv. Aset Lain Tanggal Guna',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->invasetlain_tglguna)'
		),
		
		'invgedung_namabrg',
		'invgedung_kode',
		'invgedung_noregister',
		array(
			'header'=>'Inv. Gedung Tanggal Guna',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->invgedung_tglguna)'
		),
		
		'invperalatan_namabrg',
		'invperalatan_kode',
		'invperalatan_noregister',
		array(
			'header'=>'Inv. Peralatan Tanggal Guna',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->invperalatan_tglguna)'
		),
		'invperalatan_umurekonomis',
		
		'invjalan_kode',
		'invjalan_noregister',
		'invjalan_namabrg',
		array(
			'header'=>'Inv. Jalan Tanggal Guna',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->invjalan_tglguna)'
		),
		
		'invtanah_namabrg',
		'invtanah_kode',
		'invtanah_noregister',
		array(
			'header'=>'Inv. Tanah Tanggal Guna',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->invtanah_tglguna)'
		),
		'invtanah_umurekonomis',
		
    ),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
$this->endWidget();
?>