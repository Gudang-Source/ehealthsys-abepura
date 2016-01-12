<div id='isiScroll'>
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'penerimaansterilisasi-grid',
    'dataProvider'=>$modPenerimaanSterilisasiDetail->searchPenerimaanSterilisasi(),
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-condensed',
    'columns'=>array(
            array(
                'header'=> 'Pilih '.CHtml::checkBox('is_pilihsemua',true,array('onclick'=>'pilihSemua(this)','title'=>'Klik untuk pilih / tidak <br>semua penerimaan linen','rel'=>'tooltip')),
                'type'=>'raw',
                'value'=>'
                    CHtml::hiddenField(\'STDekontaminasidetailT[\'.$data->penerimaansterilisasidet_id.\'][linen_id]\',$data->linen_id).
                    CHtml::hiddenField(\'STDekontaminasidetailT[\'.$data->penerimaansterilisasidet_id.\'][barang_id]\',$data->barang_id).
                    CHtml::hiddenField(\'STDekontaminasidetailT[\'.$data->penerimaansterilisasidet_id.\'][penerimaansterilisasi_id]\',$data->penerimaansterilisasi_id).
                    CHtml::checkBox(\'STDekontaminasidetailT[\'.$data->penerimaansterilisasidet_id.\'][checklist]\', true, array(\'class\'=>\'checklist\', \'onclick\'=>\'setNol(this);\'));
                    ',
            ),
            array(
                'header'=>'Ruangan Asal',
                'type'=>'raw',
                'value'=>'isset($data->penerimaansterilisasi->ruangan_id) ? $data->penerimaansterilisasi->ruangan->ruangan_nama : ""',
            ),            
            array(
                'header'=>'Nama Peralatan',
                'type'=>'raw',
                'value'=>'isset($data->barang_id) ? $data->barang->barang_nama : ""',
            ),  
            array(
                'header'=>'Jumlah',
                'type'=>'raw',
                'value'=>'CHtml::textField(\'STDekontaminasidetailT[\'.$data->penerimaansterilisasidet_id.\'][dekontaminasidetail_jml]\',$data->penerimaansterilisasidet_jml,array("class"=>"span1 integer"))',
            ),  
            array(
                'header'=>'Bahan yang digunakan',
                'type'=>'raw',
                'value'=>'CHtml::textField(\'STDekontaminasidetailT[\'.$data->penerimaansterilisasidet_id.\'][dekontaminasidetail_lama]\',\'\',array("class"=>"span2 bahan"))',
            ),  
            array(
                'header'=>'Lama Dekontaminasi',
                'type'=>'raw',
                'value'=>'CHtml::textField(\'STDekontaminasidetailT[\'.$data->penerimaansterilisasidet_id.\'][dekontaminasidetail_lama]\',\'\',array("class"=>"span2"))',
            ),  
            array(
                'header'=>'Status',
                'type'=>'raw',
                'value'=>'CHtml::dropDownList(\'STDekontaminasidetailT[\'.$data->penerimaansterilisasidet_id.\'][dekontaminasidetail_ket]\',"",LookupM::getItems("statusdekontaminasi"),array("empty"=>"-- Pilih --","class"=>"span2", "onkeypress"=>"return $(this).focusNextInputField(event);","options" => array("BELUM"=>array("selected"=>true))))'
            ),
    ),
        'afterAjaxUpdate'=>'function(id, data){
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
		}',
)); ?> 
</div>