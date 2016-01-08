<div class="span4">
    <?php echo $form->textFieldRow($model,'tglstoreed',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100,'readonly'=>true)); ?>
    <?php if($disabled){ ?>
    <?php echo $form->textFieldRow($model,'nostoreed',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100, 'readonly'=>true)); ?>
    <?php } 
                    else{
                            echo $form->textFieldRow($model,'nostoreed',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); 
                    }
    ?>
</div>
<div class="span4">
    <div class="control-group ">
            <?php echo CHtml::hiddenField('obatalkes_id'); ?>
            <label class="control-label" for="namaObat">Nama Obat</label>
            <div class="controls">
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                            'name' => 'obatalkes_nama',
                            'source' => 'js: function(request, response) {
                                                                                                       $.ajax({
                                                                                                               url: "' . $this->createUrl('AutocompleteObatExpiredDate') . '",
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
                                    'select' => 'js:function( event, ui ) {
                                                                                               $(this).val( ui.item.label);
                                                                                               $("#obatalkes_nama").val(ui.item.obatalkes_nama);
                                                                                               $("#obatalkes_id").val(ui.item.obatalkes_id);
                                                                                               $("#supplier_nama").val(ui.item.supplier_nama);
                                                                                               $("#tglkadaluarsa").val(ui.item.tglkadaluarsa);
                                                                                               $("#satuankecil_id").val(ui.item.satuankecil_id);
                                                                                                    return false;
                                                                                            }',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogObat', 'idTombol' => 'tombolDialogOa'),
                            'htmlOptions' => array("placeholder"=>"Ketik nama obat alkes","rel" => "tooltip", "title" => "Pencarian Data Obat/Alkes",'class'=>'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"),
                    ));
                    ?>
            </div>
    </div>
    <div class="control-group">
            <label class="control-label" for="supplier_nama">Supplier</label>
            <div class="controls">
                    <?php echo CHTML::textField('supplier_nama', '',array('class'=>'span3', 'placeholder'=>'Supplier Otomatis','onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100,'readonly'=>true)); ?>
                    <?php echo CHtml::hiddenField('satuankecil_id'); ?>
            </div>
    </div>
</div>
<div class="span4">	
    <div class="control-group">
            <label class="control-label" for="tglkadaluarsa">Tanggal Kadaluarsa</label>
            <div class="controls">
                    <?php echo CHTML::textField('tglkadaluarsa', '',array('class'=>'span3', 'placeholder'=>'Tgl Kadaluarsa Otomatis','onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100,'readonly'=>true)); ?>
            </div>
    </div>
    <div class="control-group ">
        <label class="control-label" for="qty">Jumlah</label>
        <div class="controls">
            <?php echo CHtml::textField('qtystoked', '1', array('class'=>'span3', 'readonly' => false, 'onblur' => '$("#qty").val(this.value);', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'inputFormTabel span1 numbers-only')); ?>
            <?php
            echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array('onclick' => 'tambahObat();return false;',
                    'class' => 'btn btn-primary',
                    'onkeypress' => "tambahObat();return false;",
                    'rel' => "tooltip",
                    'title' => "Klik untuk menambahkan obat",));
            ?>
        </div>
    </div>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id' => 'dialogObat',
	'options' => array(
		'title' => 'Daftar Obat Alkes',
		'autoOpen' => false,
		'modal' => true,
		'minWidth' => 900,
		'minHeight' => 400,
		'resizable' => false,
	),
));
$modObatDialog = new GFObatSupplierM('searchObatED');
$modObatDialog->unsetAttributes();
$format = new MyFormatter();
if (isset($_GET['GFObatSupplierM'])) {
	$modObatDialog->attributes = $_GET['GFObatSupplierM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id' => 'obatAlkesDialog-m-grid',
	'dataProvider' => $modObatDialog->searchObatED(),
	'filter' => $modObatDialog,
	'template' => "{items}\n{pager}",
//    'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass' => 'table table-striped table-bordered table-condensed',
	'columns' => array(
		array(
			'header' => 'Pilih',
			'type' => 'raw',
			'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Obat/Alkes","class"=>"btn_small",
				"id"=>"selectObat",
				"onClick"=>"
							$(\"#obatalkes_id\").val(\"$data->obatalkes_id\");
							$(\"#obatalkes_nama\").val(\"$data->obatalkes_nama\");
							$(\"#supplier_nama\").val(\"$data->supplier_nama\");
							$(\"#tglkadaluarsa\").val(\"$data->tglkadaluarsa\");
							$(\"#satuankecil_id\").val(\"$data->satuankecil_id\");
							$(\"#dialogObat\").dialog(\"close\");
							return false;
				",
			   ))'
		),
		array(
			'header' => 'Nama Obat',
			'type' => 'raw',
			'value'=>'$data->obatalkes_nama',
			'filter' => '',
		),
		array(
			'header' => 'Supplier',
			'type' => 'raw',
			'value'=>'$data->supplier_nama',
			'filter' => '',
		),
		array(
			'header' => 'Tanggal Kadaluarsa',
			'type' => 'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->tglkadaluarsa)',
			'filter' => '',
		),
		array(
			'header' => 'Jumlah Stok',
			'type' => 'raw',
			'value'=>'$data->StokObatRuangan',
			'filter' => '',
		),
		array(
			'header' => 'Satuan Kecil',
			'type' => 'raw',
			'value'=>'$data->satuankecil_nama',
			'filter' => '',
		),
	),
	'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>


