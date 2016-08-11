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
	$modBarang->jenis_inv = $_GET['MABarangV']['jenis_inv'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'barangsusut-t-grid',
    'dataProvider'=>$modBarang->searchDialogPemeliharaan(),
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
		array(
			'header'=>'Jenis Inventarisasi',
			'name'=>'jenis_inv',
			'type'=>'raw',
			'value'=>function($data) {
				if (!empty($data->invasetlain_noregister)) return "Aset Lain";
				if (!empty($data->invgedung_noregister)) return "Gedung";
				if (!empty($data->invperalatan_noregister)) return "Peralatan";
				if (!empty($data->invjalan_noregister)) return "Jaringan";
				if (!empty($data->invtanah_noregister)) return "Tanah";
				return "-";	
			},
			'filter'=>CHtml::activeDropDownList($modBarang, 'jenis_inv', array(
				1=>'Aset Lain',
				2=>'Gedung',
				4=>'Jaringan',
				3=>'Peralatan',
				5=>'Tanah'
			), array('empty'=>'-- Pilih --')),
		),
		//'barang_ekonomis_thn',
		array(
			'name'=>'barang_harganetto',
			'value'=>'MyFormatter::formatNumberForPrint($data->barang_harganetto)',
			'htmlOptions'=>array('style'=>'text-align: right'),
			'filter'=>false,
		),
		array(
			'header'=>'Tahun Ekonomis',
			'type'=>'raw',
			'value'=>function($data) {
				if (!empty($data->invperalatan_umurekonomis)) return $data->invperalatan_umurekonomis;
				if (!empty($data->invtanah_umurekonomis)) return $data->invtanah_umurekonomis;
				return $data->barang_ekonomis_thn;	
			}
		),
		array(
			'header'=>'No. Register',
			'type'=>'raw',
			'value'=>function($data) {
				if (!empty($data->invasetlain_noregister)) return $data->invasetlain_noregister;
				if (!empty($data->invgedung_noregister)) return $data->invgedung_noregister;
				if (!empty($data->invperalatan_noregister)) return $data->invperalatan_noregister;
				if (!empty($data->invjalan_noregister)) return $data->invjalan_noregister;
				if (!empty($data->invtanah_noregister)) return $data->invtanah_noregister;
				return "-";	
			}
		),
		array(
			'header'=>'Tgl. Guna',
			'type'=>'raw',
			'value'=>function($data) {
				if (!empty($data->invasetlain_tglguna)) return MyFormatter::formatDateTimeForUser ($data->invasetlain_tglguna);
				if (!empty($data->invgedung_tglguna)) return MyFormatter::formatDateTimeForUser ($data->invgedung_tglguna);
				if (!empty($data->invperalatan_tglguna)) return MyFormatter::formatDateTimeForUser ($data->invperalatan_tglguna);
				if (!empty($data->invjalan_tglguna)) return MyFormatter::formatDateTimeForUser ($data->invjalan_tglguna);
				if (!empty($data->invtanah_tglguna)) return MyFormatter::formatDateTimeForUser ($data->invtanah_tglguna);
				return "-";	
			}
		),
		/*
		'barang_nama',
		'barang_kode',
                array(
                    'name'=>'barang_ekonomis_thn',
                    'htmlOptions'=>array(
                        'style'=>'text-align: right',
                    ),
                ),
                array(
                    'name'=>'barang_harganetto',
                    'value'=>'MyFormatter::formatNumberForPrint($data->barang_harganetto)',
                    'htmlOptions'=>array(
                        'style'=>'text-align: right',
                    ),
                ),
		'invasetlain_namabrg',
		'invasetlain_kode',
		'invasetlain_noregister',
		array(
			'header'=>'Tgl Penggunaan (Aset Lain)',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->invasetlain_tglguna)'
		),
		
		'invgedung_namabrg',
		'invgedung_kode',
		'invgedung_noregister',
		array(
			'header'=>'Tgl Penggunaan (Gedung)',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->invgedung_tglguna)'
		),
		
		'invperalatan_namabrg',
		'invperalatan_kode',
		'invperalatan_noregister',
		array(
			'header'=>'Tgl Penggunaan (Peralatan)',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->invperalatan_tglguna)'
		),
                array(
                    'name'=>'invperalatan_umurekonomis',
                    'htmlOptions'=>array(
                        'style'=>'text-align: right',
                    ),
                ),
		'invjalan_namabrg',
		'invjalan_kode',
		'invjalan_noregister',
		array(
			'header'=>'Tgl Penggunaan (Jaringan)',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->invjalan_tglguna)'
		),
		
		'invtanah_namabrg',
		'invtanah_kode',
		'invtanah_noregister',
		array(
			'header'=>'Tgl Penggunaan (Tanah)',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->invtanah_tglguna)'
		),
                array(
                    'name'=>'invtanah_umurekonomis',
                    'htmlOptions'=>array(
                        'style'=>'text-align: right',
                    ),
                ),
		 * 
		 */
		
    ),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
$this->endWidget();
?>