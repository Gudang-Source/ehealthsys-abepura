<?php $this->widget('bootstrap.widgets.BootAlert'); ?>  
<fieldset class="box">
    <legend class="rim">Data Faktur</legend>
    <table class="table-condensed" width="100%">
        <tr>
            <td><?php echo CHtml::activeLabel($modFakturBeli, 'nofaktur',array('class'=>'control-label')); ?></td>
            <td>
                <?php 
                $this->widget('MyJuiAutoComplete', array(
                    'model'=>$modFakturBeli,
                    'attribute'=>'nofaktur',
                    'source'=>'js: function(request, response) {
                                   $.ajax({
                                       url: "'.$this->createUrl('AutocompleteFakturFarmasi').'",
                                       dataType: "json",
                                       data: {
                                           no_faktur: request.term,
                                       },
                                       success: function (data) {
                                               response(data);
                                       }
                                   })
                                }',
                    'options'=>array(
                        'minLength' => 3,
                        'focus'=> 'js:function( event, ui ) {
                            $(this).val(ui.item.label2);
                            $(this).val("");
                            return false;
                        }',
                        'select'=>'js:function( event, ui ) {
                            $(this).val(ui.item.label2);
                            loadFakturPembelian(ui.item.value);
                            return false;
                        }',
                    ),
                    'tombolDialog'=>array('idDialog'=>'dialogFaktur'),
                    'htmlOptions'=>array('placeholder'=>'Ketik No. Faktur','class'=>'all-caps','rel'=>'tooltip','title'=>'Ketik no. faktur / klik icon untuk mencari data faktur',
                        'onkeyup'=>"return $(this).focusNextInputField(event)",                                    
                        ),
                )); 
                ?>
                <?php //echo CHtml::textField('FAPasienM[nofaktur]', $modFakturBeli->nofaktur, array('readonly'=>true)); ?>
            </td>
            
            <td><?php echo CHtml::activeLabel($modFakturBeli, 'tglfaktur',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('FAPendaftaranT[tglfaktur]', MyFormatter::formatDateTimeForUser($modFakturBeli->tglfaktur), array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modFakturBeli, 'totalhargabruto',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('FAPendaftaranT[totalhargabruto]', MyFormatter::formatNumberForPrint(empty($modFakturBeli->totalhargabruto)?0:$modFakturBeli->totalhargabruto), array('readonly'=>true, 'style'=>'text-align: right;')); ?></td>
            
            <td><?php echo CHtml::activeLabel($modFakturBeli, 'tgljatuhtempo',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('FAPendaftaranT[tgljatuhtempo]', MyFormatter::formatDateTimeForUser($modFakturBeli->tgljatuhtempo), array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modFakturBeli, 'supplier_id',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('FAPendaftaranT[supplier_id]', (!empty($modFakturBeli->supplier_id)?$modFakturBeli->supplier->supplier_nama:"-"), array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modFakturBeli, 'keteranganfaktur',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textArea('FAPasienM[keteranganfaktur]', $modFakturBeli->keteranganfaktur, array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::label('No. Penerimaan','',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('nopenerimaan', (!empty($modFakturBeli->penerimaanbarang_id)?$modFakturBeli->penerimaanbarang->noterima:"-"), array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::label('No. PO','',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('nopermintaan', isset($modFakturBeli->penerimaanbarang->permintaanpembelian->nopermintaan)?$modFakturBeli->penerimaanbarang->permintaanpembelian->nopermintaan:'', array('readonly'=>true)); ?></td>
        </tr>
    </table>
</fieldset> 

<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogFaktur',
    'options'=>array(
        'title'=>'Faktur Pembelian',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>1000,
        'height'=>700,
        'resizable'=>false,
    ),
));
$modInfoFaktur=new BKInformasifakturpembelianV;
$format = new MyFormatter();
$modInfoFaktur->tgl_awal  = date('Y-m-d');
$modInfoFaktur->tgl_akhir = date('Y-m-d');

if(isset($_GET['BKInformasifakturpembelianV'])){
    $modInfoFaktur->attributes=$_GET['BKInformasifakturpembelianV'];
    $modInfoFaktur->tgl_awal  = $format->formatDateTimeForDb($_GET['BKInformasifakturpembelianV']['tgl_awal']);
    $modInfoFaktur->tgl_akhir = $format->formatDateTimeForDb($_GET['BKInformasifakturpembelianV']['tgl_akhir']);
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'fakturpembelian-m-grid',
        'dataProvider' => $modInfoFaktur->searchInformasiUmum(),
        'filter'=>$modInfoFaktur,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-condensed',
        'columns' => array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
                                        loadFakturPembelian(".$data->fakturpembelian_id.")
                                        $(\'#dialogFaktur\').dialog(\'close\');;
                                        return false;"
                                        ))',
                ),
                'nofaktur',
                array(
                        'name' => 'tglfaktur',
                        'type' => 'raw',
                        'value' => 'MyFormatter::formatDateTimeForUser($data->tglfaktur)',
                        'filter' => false,
                ),
                array(
                        'name' => 'supplier_id',
                        'type' => 'raw',
                        'value' => '$data->supplier_nama',
                        'filter' => CHtml::activeDropDownList($modInfoFaktur, 'supplier_id', CHtml::listData($modInfoFaktur->supplierItems, 'supplier_id', 'supplier_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
				'empty' => '-- Pilih --',)),
                ),
                array(
                        'name' => 'tgljatuhtempo',
                        'type' => 'raw',
                        'value' => 'MyFormatter::formatDateTimeForUser($data->tgljatuhtempo)',
                        'filter' => false,
                ),
                'keteranganfaktur',
                array(
                        'header' => 'Umur Hutang',
                        'type' => 'raw',
                        'value' => '$data->umurHutang',
                        'filter' => false,
                ),
                array(
                        'name' => 'totharganetto',
                        'type' => 'raw',
                        'value' => 'MyFormatter::formatNumberForPrint($data->totharganetto)',
                        'filter' => false,
                        'htmlOptions'=>array('style'=>'text-align: right'),
                ),
                array(
                        'name' => 'jmldiscount',
                        'type' => 'raw',
                        'value' => 'MyFormatter::formatNumberForPrint($data->jmldiscount)',
                        'htmlOptions'=>array('style'=>'text-align: right'),
                        'filter'=>false,
                ),
                array(
                        'name' => 'totalpajakpph',
                        'type' => 'raw',
                        'value' => 'MyFormatter::formatNumberForPrint($data->totalpajakpph)',
                        'filter' => false,
                        'htmlOptions'=>array('style'=>'text-align: right'),
                ),
                array(
                        'name' => 'totalpajakppn',
                        'type' => 'raw',
                        'value' => 'MyFormatter::formatNumberForPrint($data->totalpajakppn)',
                        'filter' => false,
                        'htmlOptions'=>array('style'=>'text-align: right'),
                ),
                array(
                        'name' => 'totalhargabruto',
                        'type' => 'raw',
                        'value' => 'MyFormatter::formatNumberForPrint($data->totalhargabruto)',
                        'filter' => false,
                        'htmlOptions'=>array('style'=>'text-align: right'),
                ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
