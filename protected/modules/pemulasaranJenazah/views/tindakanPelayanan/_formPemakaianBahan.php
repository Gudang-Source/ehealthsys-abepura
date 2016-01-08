<fieldset>
    <?php echo CHtml::hiddenField("obatalkes_kode", '',array('readonly'=>true,'class'=>'inputFormTabel span1')); ?>
	<?php echo CHtml::hiddenField('obatalkes_id',''); ?>
        <?php echo CHtml::dropDownList('daftartindakanPemakaianBahan', '',array(),array('empty'=>'Nama Tindakan')) ?>       
    <?php echo CHtml::radioButton('pilihAlkes', true, array('value'=>'bahan','onclick'=>'pilihAlkesMedis(this);')); ?>
    Pemakaian BMHP
    <?php echo CHtml::radioButton('pilihAlkes', false, array('value'=>'medis','onclick'=>'pilihAlkesMedis(this);')); ?>
    Alat Medis
        <?php $this->widget('MyJuiAutoComplete',array(
                'name'=>'pakaiBahan',
                'value'=>'',
                'source'=>'js: function(request, response) {
                               $.ajax({
                                   url: "'.Yii::app()->createUrl('pemulasaranJenazah/TindakanPelayanan/PemakaianBahan').'",
                                   dataType: "json",
                                   data: {
                                       term: request.term,
                                       tipepaket_id: $("#PJTindakanPelayananT_0_tipepaket_id").val(),
                                       kelaspelayanan_id: $("#PJPendaftaranT_kelaspelayanan_id").val(),
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
                        inputPemakaianBahan(ui.item.obatalkes_id);
                        return false;
                    }',
                ),
                'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2', 'placeholder'=>'Pemakaian BMHP'),
                'tombolDialog'=>array('idDialog'=>'dialogObatAlkes','jsFunction'=>"setDialogObatAlkes(this);"),
        )); ?>
    <?php $this->widget('MyJuiAutoComplete',array(
                'name'=>'alatMedis',
                'value'=>'',
                'source'=>'js: function(request, response) {
                               $.ajax({
                                   url: "'.Yii::app()->createUrl('pemulasaranJenazah/TindakanPelayanan/PemakaianAlatMedis').'",
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
                        inputAlatmedis(ui.item.alatmedis_id);
                        return false;
                    }',

                ),
                'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2', 'placeholder'=>'Alat Medis'),
                'tombolDialog'=>array('idDialog'=>'dialogAlatmedis'),
    )); ?>
    <table class="items table table-striped table-bordered table-condensed" id="tblInputPemakaianBahan">
        <thead>
            <tr>
                <th>Nama Tindakan</th>
                <th>Nama Alkes</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Sub Total</th>
                <th>Batal</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
    <div>
        <b>Total Pemakaian BMHP : </b>
        <?php echo CHtml::textField("totPemakaianBahan", 0,array('readonly'=>true,'class'=>'inputFormTabel currency')); ?>
    </div>
</fieldset>

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
$modObatAlkes = new PJInfostokobatalkesruanganV('searchDialog');
$modObatAlkes->unsetAttributes();
if(isset($_GET['PJInfostokobatalkesruanganV'])){
$modObatAlkes->attributes = $_GET['PJInfostokobatalkesruanganV'];
$modObatAlkes->ruangan_id = $_GET['PJInfostokobatalkesruanganV']['ruangan_id'];
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
                                        $(\'#obatalkes_kode\').val(\"$data->obatalkes_kode\");
                                        $(\'#qty_stok\').val(".StokobatalkesT::getJumlahStok($data->obatalkes_id, Yii::app()->user->getState(\'ruangan_id\')).");
                                        $(\'#satuankecil_id\').val($data->satuankecil_id);
                                        $(\'#satuankecil_nama\').val(\'$data->satuankecil_nama\');
                                        $(\'#hargajual\').val($data->hargajual);
                                        $(\'#harganetto\').val($data->harganetto);
                                        $(\'#obatalkes_nama\').val(\'$data->obatalkes_nama\');
                                        $(\'#sumberdana_id\').val(\'$data->sumberdana_id\');
                                        inputPemakaianBahan(this);
                                        $(\'#dialogObatAlkes\').dialog(\'close\');
                                        return false;"
                                        ))',
                ),
                array(
                    'name'=>'jenisobatalkes_id',
                    'type'=>'raw',
                    'value'=>'$data->jenisobatalkes_nama',
                    'filter'=>  CHtml::activeTextField($modObatAlkes, 'jenisobatalkes_nama'),
                ),
                'obatalkes_nama',
                'obatalkes_kategori',
                'obatalkes_golongan',
                array(
                    'name'=>'satuankecil_id',
                    'type'=>'raw',
                    'value'=>'$data->satuankecil_nama',
                    'filter'=>  CHtml::activeTextField($modObatAlkes, 'satuankecil_nama')." ". CHtml::activeHiddenField($modObatAlkes, 'ruangan_id',array('readonly'=>true)),
                ),
                array(
                    'header'=>'Harga Jual',
                    'name'=>'hargajual',
                    'type'=>'raw',
                    'value'=>'"Rp.".MyFormatter::formatNumberForPrint($data->hargajual)',
                    'filter'=>false,
                ),
                array(
                    'header'=>'Jumlah Stok',
                    'type'=>'raw',
                    'value'=>'StokobatalkesT::getJumlahStok($data->obatalkes_id, $data->ruangan_id)',
                ),

                
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
?>

<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogAlatmedis',
    'options'=>array(
        'title'=>'Alat Medis',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>600,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modAlat = new AlatmedisM('search');
$modAlat->unsetAttributes();
if(isset($_GET['AlatmedisM']))
    $modAlat->attributes = $_GET['AlatmedisM'];

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'almes-m-grid',
	'dataProvider'=>$modAlat->search(),
	'filter'=>$modAlat,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectObat",
				"onClick" => "inputAlatmedis($data->alatmedis_id);return false;"))',
		),
		'jenisalatmedis.jenisalatmedis_nama',
		'alatmedis_nama',                
	),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>