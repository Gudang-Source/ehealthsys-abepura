<style>
    .table {
        border-collapse: collapse;
        border: 1px solid black;
        box-shadow: none;
    }
    .table th, .table td, .table tbody tr:hover td {
        background-color: white;
        border: 1px solid black;
        color: black;
    }
</style>

<?php

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'daftarTindakan-grid',
    'dataProvider'=>$modTarifTindakanRuanganV->searchInformasiPrint(),
    'template'=>"{items}",
    'itemsCssClass'=>'table',
    'enableSorting'=>false,
    'columns'=>array(
        array(
            'header'=>'No.',
            'value'=>'$row+1',
        ),
            'jenistarif_nama',
            'kelompoktindakan_nama',
            'komponenunit_nama',
            'kategoritindakan_nama',
		'kelaspelayanan_nama',
            'daftartindakan_nama',
            
//                'ruangan_id',

        array(
            'name'=>'tarifTotal',
            'value'=>'$this->grid->getOwner()->renderPartial("_tarifTotal",array("kelaspelayanan_id"=>$data->kelaspelayanan_id,"daftartindakan_id"=>$data->daftartindakan_id,"jenistarif_id"=>$data->jenistarif_id),true)',
            'htmlOptions'=>array('style'=>'text-align: right;')
        ),
        array(
            'name'=>'persencyto_tind',
            'htmlOptions'=>array('style'=>'text-align: right;')
        ),
        array(
            'name'=>'persendiskon_tind',
            'htmlOptions'=>array('style'=>'text-align: right;')
        ),

    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
<script>
    window.print(); 
</script>