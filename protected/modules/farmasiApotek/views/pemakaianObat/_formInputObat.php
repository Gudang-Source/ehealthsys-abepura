<div class="span4">
        <div class="control-group ">
            <?php echo CHtml::hiddenField('obatalkes_id'); ?>
            <?php echo CHtml::hiddenField('obatalkes_kode'); ?>
            <label class="control-label" for="namaObat">Nama Obat</label>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'namaObatNonRacik',
                    'source' => 'js: function(request, response) {
                                                           $.ajax({
                                                               url: "' . $this->createUrl('AutocompleteObatReseptur') . '",
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
                                                       $("#obatalkes_id").val(ui.item.obatalkes_id);
                                                       $("#obatalkes_kode").val(ui.item.obatalkes_kode);
                                                        return false;
                                                    }',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogObat', 'idTombol' => 'tombolDialogOa'),
                    'htmlOptions' => array("rel" => "tooltip", "title" => "Pencarian Data Obat/Alkes",'class'=>'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"),
                ));
                ?>
            </div>
        </div>
        
</div>
<div class="span4">
	<div class="control-group ">
		<label class="control-label" for="qty">Jumlah</label>
		<div class="controls">
			<?php echo CHtml::textField('qtyNonRacik', '1', array('readonly' => false, 'onblur' => '$("#qty").val(this.value);', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'inputFormTabel span1 numbers-only')) ?>
			<?php
			echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array('onclick' => 'tambahObat(this);return false;',
				'class' => 'btn btn-primary',
				'onkeypress' => "tambahObat(this);return false;",
				'rel' => "tooltip",
				'title' => "Klik untuk menambahkan resep",));
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

$modObatDialog = new FAObatalkesM('searchObatFarmasi');
$modObatDialog->unsetAttributes();
$format = new MyFormatter();
if (isset($_GET['FAObatalkesM'])) {
    $modObatDialog->attributes = $_GET['FAObatalkesM'];
    if (isset($_GET['FAObatalkesM']['therapiobat_id'])) {
        $modObatDialog->therapiobat_id = $_GET['FAObatalkesM']['therapiobat_id'];
    }
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatAlkesDialog-m-grid',
    'dataProvider' => $modObatDialog->searchObatFarmasi(),
    'filter' => $modObatDialog,
    //'template' => "{items}\n{pager}",
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Obat/Alkes","class"=>"btn_small",
                "id"=>"selectObat",
                "onClick"=>"
                            $(\"#obatalkes_id\").val(\"$data->obatalkes_id\");
                            $(\"#obatalkes_kode\").val(\"$data->obatalkes_kode\");
                            $(\"#namaObatNonRacik\").val(\"$data->obatalkes_nama\");
                            $(\"#dialogObat\").dialog(\"close\");
                            return false;
                ",
               ))'
        ),
        'obatalkes_kode',
        'obatalkes_nama',
        array(
            'header' => 'Tanggal Kadaluarsa',
            'name' => 'tglkadaluarsa',
            'filter' => '',
        ),
        array(
            'name' => 'satuankecil.satuankecil_nama',
            'header' => 'Satuan Kecil',
        ),
        array(
            'name' => 'satuanbesar.satuanbesar_nama',
            'header' => 'Satuan Besar',
        ),
        array(
            'header' => 'Stok',
            'type' => 'raw',
            'value' => '$data->StokObatRuangan',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>