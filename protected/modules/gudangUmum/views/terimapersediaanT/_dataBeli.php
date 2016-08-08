<table width="100%">
    <tr>
        <td>
            <div class="control-group ">
                <?php echo CHtml::activeLabel($modBeli, 'nopembelian', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php
                    //echo CHtml::activeTextField($modBeli, 'nopembelian', array('readonly'=>false))
                    ?>
					<?php echo CHtml::activeHiddenField($modBeli, 'pembelianbarang_id'); ?>
                        <!--                <div class="input-append" style='display:inline'>-->
					<?php
					$this->widget('MyJuiAutoComplete', array(
						'model' => $modBeli,
						'attribute' => 'nopembelian',
						'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl("autoCompletePembelian"). '",
										   dataType: "json",
										   data: {
											   term: request.term,
										   },
										   success: function (data) {
												   response(data);
										   }
									   })
									}',
						'options' => array(
							'showAnim' => 'fold',
							'minLength' => 2,
							'focus' => 'js:function( event, ui ) {
																	$(this).val( ui.item.label);
																	return false;
																}',
							'select' => 'js:function( event, ui ) {
																	$("#' . Chtml::activeId($modBeli, 'nopembelian') . '").val(ui.item.label); 
																	$("#' . Chtml::activeId($modBeli, 'pembelianbarang_id') . '").val(ui.item.value); 
																	$("#' . Chtml::activeId($modBeli, 'supplier_id') . '").val(ui.item.supplier_id);
																	$("#' . Chtml::activeId($modBeli, 'tglpembelian') . '").val(ui.item.tglpembelian);
																	$("#' . Chtml::activeId($model, 'sumberdana_id') . '").val(ui.item.sumberdana_id);
																	loadPembelian(ui.item.value);
																	return false;
																}',
						),
						'htmlOptions' => array(
							'class' => 'namaPegawai',
							'onkeypress' => "return $(this).focusNextInputField(event)",
							'placeholder' => 'Ketikan Nomor Pembelian Barang',
						),
						'tombolDialog' => array('idDialog' => 'dialogPembelian'),
					));
					?>
                </div>
            </div>
        </td>
        <td>
            <div class="control-group ">
                <?php echo CHtml::activeLabel($modBeli, 'tglpembelian', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php
                    echo CHtml::activeTextField($modBeli, 'tglpembelian', array('readonly'=>true))
                    ?>
                </div>
            </div>
        </td>
        <td>
            <div class="control-group ">
                <?php echo CHtml::label('Supplier <span class="required">*</span>', '', array('class'=>'control-label required')) ?>
                <div class="controls">
				
                    <?php
						echo CHtml::activeDropDownList($modBeli,'supplier_id', CHtml::listData(SupplierM::model()->findAll('supplier_aktif = true ORDER BY supplier_nama ASC'), 'supplier_id', 'supplier_nama'), array('empty'=>'-- Pilih --', 'class'=>'span3 required', 'onkeypress'=>"return $(this).focusNextInputField(event);"));
                    ?>
                </div>
            </div>
        </td>
    </tr>
</table>



<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPembelian',
    'options' => array(
        'title' => 'Daftar Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

$modPembelian=new GUPembelianbarangT('search');
$format= new MyFormatter;
$modPembelian->unsetAttributes();  // clear any default values
$modPembelian->belum = true;
if(isset($_GET['GUPembelianbarangT'])){
	 $modPembelian->attributes=$_GET['GUPembelianbarangT'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pembelian-m-grid',
    'dataProvider'=>$modPembelian->searchInformasi(),
    'filter'=>$modPembelian,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => '
				CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectBahan",
                                    "onClick" => "
									$(\"#PembelianbarangT_tglpembelian\").val(\"".MyFormatter::formatDateTimeForUser($data->tglpembelian)."\");
									$(\"#PembelianbarangT_pembelianbarang_id\").val(\"".($data->pembelianbarang_id)."\");
									$(\"#PembelianbarangT_nopembelian\").val(\"".($data->nopembelian)."\");
									$(\"#PembelianbarangT_supplier_id\").val(\"".($data->supplier_id)."\");
									$(\"#GUTerimapersediaanT_sumberdana_id\").val(\"".($data->sumberdana_id)."\");
									loadPembelian(".$data->pembelianbarang_id.");
									$(\'#dialogPembelian\').dialog(\'close\');
                                    return false;"));',
        ),
		'nopembelian',
		'sumberdana.sumberdana_nama',
		'supplier.supplier_nama',                    
		 array(
			'header' => 'Tanggal Pembelian',
			'value' => 'Myformatter::formatDateTimeForUser($data->tglpembelian)',
		),  
		 array(
			'header' => 'Tanggal Dikirim',
			'value' => 'Myformatter::formatDateTimeForUser($data->tgldikirim)',
		), 
		array(
			'header' => 'Pegawai Pemesan',
			'value' => 'empty($data->pemesan)?"-":$data->pemesan->nama_pegawai'
		),                    
		array(
			'header' => 'Pegawai Mengetahui',
			'value' => 'empty($data->mengetahui)?"-":$data->mengetahui->nama_pegawai'
		),                    
		array(
			'header' => 'Pegawai Menyetujui',
			'value' => 'empty($data->menyetujui)?"-":$data->menyetujui->nama_pegawai'
		),     
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>