<div class="control-group ">
    <?php echo CHtml::label('Nama Obat & Kesehatan', 'obatalkes_nama', array('class'=>'control-label')); ?>
    <div class="controls">
        <?php echo CHtml::hiddenField('obatalkes_id'); ?>
        <?php echo CHtml::hiddenField('obatalkes_kode'); ?>
        <?php echo CHtml::hiddenField('qty_stok' ,0); ?>
        <?php echo CHtml::hiddenField('satuankecil_id'); ?>
        <?php echo CHtml::hiddenField('satuankecil_nama'); ?>
        <?php echo CHtml::hiddenField('sumberdana_id'); ?>
        <?php echo CHtml::hiddenField('hargajual'); ?>
        <?php echo CHtml::hiddenField('harganetto'); ?>

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
                            $("#obatalkes_id").val(ui.item.obatalkes_kode);
                            $("#qty_stok").val(ui.item.qty_stok);
                            $("#satuankecil_id").val(ui.item.satuankecil_id);
                            $("#satuankecil_nama").val(ui.item.satuankecil_nama);
                            $("#hargajual").val(ui.item.hargajual);
                            $("#harganetto").val(ui.item.harganetto);
                            $("#obatalkes_nama").val(ui.item.obatalkes_nama);
                            $("#sumberdana_id").val(ui.item.sumberdana_id);
                            return false;
                        }',
                ),
                'htmlOptions'=>array(
                        'onkeyup'=>"return $(this).focusNextInputField(event)",
                ),
                'tombolDialog'=>array('idDialog'=>'dialogObatAlkes'),
            )); 
        ?>
    </div>
</div>

<div class="control-group ">
    <?php echo CHtml::label('Jumlah', 'qty_input', array('class'=>'control-label')); ?>
    <div class="controls">
        <?php echo CHtml::textField('qty_input', '1', array('readonly'=>false,'onblur'=>'$("#qty").val(this.value);','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span1 integer')) ?>
        <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
                array('onclick'=>'tambahObatAlkesPasien();return false;',
                      'class'=>'btn btn-primary',
                      'onkeyup'=>"tambahObatAlkesPasien();",
                      'rel'=>"tooltip",
                      'title'=>"Klik untuk menambahkan resep",)); ?>
    </div>
</div>

<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogObatAlkes',
    'options'=>array(
        'title'=>'Obat & Alat Kesehatan Ruangan Ambulans',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>980,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modObatDialog = new InfostokobatalkesruanganV('search');
$modObatDialog->unsetAttributes();
$format = new MyFormatter();
if (isset($_GET['InfostokobatalkesruanganV'])) {
    $modObatDialog->attributes = $_GET['InfostokobatalkesruanganV'];
    if (isset($_GET['FAObatalkesM']['therapiobat_id'])) {
        $modObatDialog->therapiobat_id = $_GET['FAObatalkesM']['therapiobat_id'];
    }
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatAlkesDialog-m-grid',
    'dataProvider' => $modObatDialog->searchObat(),
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
                "onClick" => "
                                $(\'#obatalkes_id\').val($data->obatalkes_id);
                                $(\'#qty_stok\').val(".StokobatalkesT::getJumlahStok($data->obatalkes_id, Yii::app()->user->getState(\'ruangan_id\')).");
                                $(\'#satuankecil_id\').val($data->satuankecil_id);
                                $(\'#satuankecil_nama\').val(\'$data->satuankecil_nama\');
                                $(\'#hargajual\').val($data->hargajual);
                                $(\'#harganetto\').val($data->harganetto);
                                $(\'#obatalkes_nama\').val(\'$data->obatalkes_nama\');
                                $(\'#obatalkes_nama\').val(\'$data->obatalkes_kode\');
                                $(\'#sumberdana_id\').val(\'$data->sumberdana_id\');
                                $(\'#dialogObatAlkes\').dialog(\'close\');
                                return false;"
                                ))',
            ),
        array(
                    'name'=>'jenisobatalkes_id',
                    'type'=>'raw',
                    'value'=>'(!empty($data->jenisobatalkes_id) ? $data->jenisobatalkes->jenisobatalkes_nama : "")',
                    'filter'=>  CHtml::activeDropDownList($modObatDialog, 'jenisobatalkes_id', CHtml::listData(
                   JenisobatalkesM::model()->findAll(array(
                       'condition'=>'jenisobatalkes_aktif = true',
                       'order'=>'jenisobatalkes_nama',
                   )), 'jenisobatalkes_id', 'jenisobatalkes_nama'), array('empty'=>'-- Pilih --')),
                ),
                array(
                    'name'=>'obatalkes_kategori',
                    'filter'=>  CHtml::activeDropDownList($modObatDialog, 'obatalkes_kategori', LookupM::getItems('obatalkes_kategori'), array(
                        'empty'=>'-- Pilih --'
                    ))
                ),
                array(
                    'name'=>'obatalkes_golongan',
                    'filter'=>  CHtml::activeDropDownList($modObatDialog, 'obatalkes_golongan', LookupM::getItems('obatalkes_golongan'), array(
                        'empty'=>'-- Pilih --'
                    ))
                ),
                'obatalkes_nama',                                           
//                array(
//                    'name'=>'sumberdana_id',
//                    'type'=>'raw',
//                    'value'=>'$data->sumberdana->sumberdana_nama',
//                    'filter'=>  CHtml::activeTextField($modObatAlkes, 'sumberdana_nama'),
//                ),
                array(
                    'header'=>'Jumlah Stok',
                    'type'=>'raw',
                    'htmlOptions'=>array('style'=>'text-align: right;'),
                    'value'=>'StokobatalkesT::getJumlahStok($data->obatalkes_id, Yii::app()->user->getState("ruangan_id"))." ".$data->satuankecil_nama',
                ),
    ),
    
/*$modObatAlkes = new AMObatAlkesM('searchDialog');
$modObatAlkes->unsetAttributes();
if(isset($_GET['AMObatalkesM'])){
    $modObatAlkes->attributes = $_GET['AMObatalkesM'];
    $modObatAlkes->jenisobatalkes_nama = $_GET['AMObatalkesM']['jenisobatalkes_nama'];
    $modObatAlkes->satuankecil_nama = $_GET['AMObatalkesM']['satuankecil_nama'];
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
                                $(\'#qty_stok\').val(".StokobatalkesT::getJumlahStok($data->obatalkes_id, Yii::app()->user->getState(\'ruangan_id\')).");
                                $(\'#satuankecil_id\').val($data->satuankecil_id);
                                $(\'#satuankecil_nama\').val(\'$data->SatuanKecilNama\');
                                $(\'#hargajual\').val($data->hargajual);
                                $(\'#harganetto\').val($data->harganetto);
                                $(\'#obatalkes_nama\').val(\'$data->obatalkes_nama\');
                                $(\'#obatalkes_nama\').val(\'$data->obatalkes_kode\');
                                $(\'#sumberdana_id\').val(\'$data->sumberdana_id\');
                                $(\'#dialogObatAlkes\').dialog(\'close\');
                                return false;"
                                ))',
            ),
            array(
                'name'=>'jenisobatalkes_id',
                'type'=>'raw',
                'value'=>'(!empty($data->jenisobatalkes_id) ? $data->jenisobatalkes->jenisobatalkes_nama : "")',
                'filter'=>  CHtml::activeTextField($modObatAlkes, 'jenisobatalkes_nama'),
            ),
            'obatalkes_nama',
            'obatalkes_kategori',
            'obatalkes_golongan',
            array(
                'name'=>'satuankecil_id',
                'type'=>'raw',
                'value'=>'$data->satuankecil->satuankecil_nama',
                'filter'=>  CHtml::activeTextField($modObatAlkes, 'satuankecil_nama'),
            ),
            array(
                'header'=>'Jumlah Stok',
                'type'=>'raw',
                'value'=>'StokobatalkesT::getJumlahStok($data->obatalkes_id, Yii::app()->user->getState("ruangan_id"))',
            ),
	),*/
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); 
$this->endWidget();
?>
