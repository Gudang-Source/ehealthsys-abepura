<table>
    <tr>
        <td>
            <div class="control-group ">
                <?php echo CHtml::label('Nama Obat & Alkes', 'obatalkes_nama', array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::hiddenField('obatalkes_id','',array('onkeyup'=>"return $(this).focusNextInputField(event)",)); ?>
                <?php 
                    $this->widget('MyJuiAutoComplete', array(
                        'name'=>'obatalkes_nama',
                        'source'=>'js: function(request, response) {
                                       $.ajax({
                                           url: "'.$this->createUrl('AutocompleteObatAlkes').'",
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
                                    $("#obatalkes_id").val(ui.item.obatalkes_id);
                                    $("#obatalkes_nama").val(ui.item.obatalkes_nama);
                                    return false;
                                }',
                        ),
                        'htmlOptions'=>array(
                            'onkeyup'=>"return $(this).focusNextInputField(event)",
                            'onblur' => 'if(this.value === "") $("#obatalkes_id").val(""); '
                        ),
                        'tombolDialog'=>array('idDialog'=>'dialogObatAlkes'),
                    )); 
                    ?>
                </div>
            </div>
        </td>
        <td>
            <div class="control-group ">
                <?php echo CHtml::label('Jumlah', 'qty_input', array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::textField('qty_input', '1', array('readonly'=>false,'onblur'=>'$("#qty").val(this.value);','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span1 integer2')) ?>
                    <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
                            array('onclick'=>'tambahObatAlkes();return false;',
                                  'class'=>'btn btn-primary',
                                  'onkeyup'=>"tambahObatAlkes();",
                                  'rel'=>"tooltip",
                                  'title'=>"Klik untuk menambahkan resep",)); ?>
                </div>
            </div>
        </td>
    </tr>
</table>
<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogObatAlkes',
    'options'=>array(
        'title'=>'Obat & Alat Kesehatan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>980,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modObatAlkes = new ADObatalkesM('searchDialog');
$modObatAlkes->unsetAttributes();
if(isset($_GET['ADObatalkesM'])){
    $modObatAlkes->attributes = $_GET['ADObatalkesM'];
   // $modObatAlkes->satuankecil_nama = $_GET['ADObatalkesM']['satuankecil_nama'];
   // $modObatAlkes->jenisobatalkes_nama = $_GET['ADObatalkesM']['jenisobatalkes_nama'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'obatalkes-m-grid',
	'dataProvider'=>$modObatAlkes->searchDialog(),
	'filter'=>$modObatAlkes,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
                                        $(\'#obatalkes_id\').val($data->obatalkes_id);
                                        $(\'#obatalkes_nama\').val(\'$data->obatalkes_nama\');
                                        $(\'#dialogObatAlkes\').dialog(\'close\');
                                        return false;"
                                        ))',
                ),
               array(
                    'header'=>'Jenis',
                    'name'=>'jenisobatalkes_id',
                    'type'=>'raw',
                    'value'=>'(!empty($data->jenisobatalkes_id) ? $data->jenisobatalkes->jenisobatalkes_nama : "")',
                   // 'filter'=>  CHtml::activeTextField($modObatAlkes, 'jenisobatalkes_nama'),
                    'filter' => CHtml::dropDownList('ADObatalkesM[jenisobatalkes_id]', $modObatAlkes->jenisobatalkes_id, CHtml::listData($modObatAlkes->getJenisObatAlkesItems(), 'jenisobatalkes_id', 'jenisobatalkes_nama'), array('empty'=>'-- Pilih --'))
                ),
                array(
                    'header'=>'Kategori',
                    'name' => 'obatalkes_kategori',
                    'value' => '$data->obatalkes_kategori',
                    'filter' => CHtml::dropDownList('ADObatalkesM[obatalkes_kategori]', $modObatAlkes->obatalkes_kategori, LookupM::getItems('obatalkes_kategori'), array('empty'=>'-- Pilih --'))
                ),                
                array(
                    'header'=>'Golongan',
                    'name' => 'obatalkes_golongan',
                    'value' => '$data->obatalkes_golongan',                    
                    'filter' => CHtml::dropDownList('ADObatalkesM[obatalkes_golongan]', $modObatAlkes->obatalkes_golongan, LookupM::getItems('obatalkes_golongan'), array('empty'=>'-- Pilih --'))
                ),                  
                'obatalkes_nama',                
                array(
                    'name'=>'satuankecil_id',
                    'type'=>'raw',
                    'value'=>'$data->satuankecil->satuankecil_nama',
                    //'filter'=>  CHtml::activeTextField($modObatAlkes, 'satuankecil_nama'),
                    'filter' => CHtml::dropDownList('ADObatalkesM[satuankecil_id]', $modObatAlkes->satuankecil_id, CHtml::listData($modObatAlkes->getSatuanKecilItems(), 'satuankecil_id', 'satuankecil_nama'), array('empty'=>'-- Pilih --'))
                ),
                array(
                    'name'=>'hargajual',
                    'type'=>'raw',
                    'value'=>'"Rp.".MyFormatter::formatNumberForPrint($data->hargajual)',
                    'filter'=>false,
                ),
                array(
                    'header'=>'Jumlah Stok',
                    'type'=>'raw',
                    'value'=>'$data->StokObatRuangan',
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
?>
