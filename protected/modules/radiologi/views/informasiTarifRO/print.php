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

$format = new MyFormatter();
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'daftarTindakan-grid',
    'dataProvider'=>$modTarifRad->searchTarifPrint(),
    'template'=>"{items}",
    'itemsCssClass'=>'table table-condensed',
    'enableSorting'=>false,
    'columns'=>array(
      /*  array(
            'header'=>'No.',
            'value'=>'$row+1',
        ),
        'jenistarif_nama',
        'jenispemeriksaanrad_nama',
        'pemeriksaanrad_nama',
        array(
            'name'=>'kelaspelayanan_nama',
            'htmlOptions'=>array('style'=>'text-align: center'),
        ),
        
        array(
            'header'=>'Tarif Pemeriksaan (Rp.)',
            'name'=>'harga_tariftindakan',
            'value'=>'number_format($data->harga_tariftindakan,0,",",",")',
            'htmlOptions'=>array('style'=>'text-align: right;'),
        ),*/
         'jenistarif_nama',
		'kelompoktindakan_nama',
                'komponenunit_nama',
		'kategoritindakan_nama',
		'kelaspelayanan_nama',
		'daftartindakan_nama',
		
                 array(
			'name'=>'tarifTotal',
			'value'=>'$this->grid->getOwner()->renderPartial(\'radiologi.views.informasiTarifRO._tarifTotal\',array(\'kelaspelayanan_id\'=>$data->kelaspelayanan_id,\'daftartindakan_id\'=>$data->daftartindakan_id, \'jenistarif_id\'=>$data->jenistarif_id),true)',
                        'htmlOptions'=>array('style'=>'text-align: right'),
                ),
                array(
                    'name'=>'persencyto_tind',
                    'htmlOptions'=>array('style'=>'text-align: right'),
                ), 
                array(
                    'name'=>'persendiskon_tind',
                    'htmlOptions'=>array('style'=>'text-align: right'),
                ),
		//'persencyto_tind',		
//            array(
//                'header'=>'Cyto (%)',
//                'name'=>'persencyto_tind',
//                'value'=>'$data->persencyto_tind',
//            ),
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
<script>
    window.print(); 
</script>

