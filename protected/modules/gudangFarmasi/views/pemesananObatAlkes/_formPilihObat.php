<table>
    <tr>
        <td>
            <div class="control-group ">
                <?php echo CHtml::label('Nama Obat & Kesehatan', 'obatalkes_nama', array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::hiddenField('obatalkes_id'); ?>
                    <?php echo CHtml::hiddenField('obatalkes_kode'); ?>
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
                                            'placeholder'=>'Ketikan Nama Obat & Kesehatan',
                                            'onkeyup'=>"return $(this).focusNextInputField(event)",
                                            'class'=>'span3',
                        ),
                        'tombolDialog'=>array('idDialog'=>'dialogObatAlkes','idTombol' => 'tombolDialogObatAlkes'),
                    )); 
                    ?>
                </div>
            </div>
        </td>
        <td>
            <div class="control-group ">
                <?php echo CHtml::label('Jumlah', 'qty_input', array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::textField('qty_input', '1', array('readonly'=>false,'onblur'=>'$("#qty").val(this.value);','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span1 integer')) ?>
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
$modObatAlkes = new GFObatalkesM('searchDialog');
$modObatAlkes->unsetAttributes();
if(isset($_GET['GFObatalkesM'])){
    $modObatAlkes->attributes = $_GET['GFObatalkesM'];
    $modObatAlkes->jenisobatalkes_nama = isset($_GET['GFObatalkesM']['jenisobatalkes_nama'])?$_GET['GFObatalkesM']['jenisobatalkes_nama']:null;
    $modObatAlkes->satuankecil_nama = isset($_GET['GFObatalkesM']['satuankecil_nama'])?$_GET['GFObatalkesM']['satuankecil_nama']:null;
    if(isset($_GET['GFObatalkesM']['ruangan_id'])){
		$_GET['pesanobatalkes_id'] = $_GET['GFObatalkesM']['ruangan_id'];
	}
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'obatalkes-m-grid',
	'dataProvider'=>$modObatAlkes->searchDialog(),
	'filter'=>$modObatAlkes,
        'template'=>"{items}\n{pager}",
//        'template'=>"{summary}\n{items}\n{pager}",
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
                    'name'=>'jenisobatalkes_id',
                    'type'=>'raw',
                    'value'=>'(!empty($data->jenisobatalkes_id) ? $data->jenisobatalkes->jenisobatalkes_nama : "")',
                    'filter'=>  CHtml::listData(JenisobatalkesM::model()->findAll(), 'jenisobatalkes_id','jenisobatalkes_nama'),
                ),
                'obatalkes_nama',
                //'obatalkes_kategori',
                // yang bawah
                array(
                    'name'=>'obatalkes_kategori',
                    'type'=>'raw',
                    'value'=>'$data->obatalkes_kategori',
                    'filter'=> LookupM::getItems('obatalkes_kategori'),
                ),
            
                //'obatalkes_golongan',
                //yangbawah
                array(
                    'name'=>'obatalkes_golongan',
                    'type'=>'raw',
                    'value'=>'$data->obatalkes_golongan',
                    'filter'=> LookupM::getItems('obatalkes_golongan'),
                ),
            
                array(
                    'name'=>'satuankecil_id',
                    'type'=>'raw',
                    'value'=>'$data->satuankecil->satuankecil_nama',
                    'filter'=>  CHtml::listData(SatuankecilM::model()->findAll(), 'satuankecil_id','satuankecil_nama'),
                ),
		// dicomment karena RND-5732
//                array(
//                    'name'=>'hargajual',
//                    'type'=>'raw',
//                    'value'=>'"Rp.".MyFormatter::formatNumberForPrint($data->hargajual)',
//                    'filter'=>false,
//                ),
                array(
                    'header'=>'Jumlah Stok',
                    'type'=>'raw',
                    'value'=>'$data->StokObatRuanganPemesan',
                ),  
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
?>
