<?php 
    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchTable();
         $template = "{summary}\n{items}\n{pager}";
    }
?>

<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
             array(
                'header' => 'Nama Bin',
                'value' => '$data->NamaNamaBIN'
            ),
            'no_rekam_medik',    
//            'alamat_pasien',
            'umur',
            'jeniskelamin',
            'alamat_pasien',
            'kunjungan',
            'statuspasien',
            array(
                'header' => 'Nama Diagnosa',
                'value' => '$data->diagnosa_nama'
            ),
            array(
               'name'=>'CaraBayar/Penjamin',
               'type'=>'raw',
               'value'=>'$data->CaraBayarPenjamin',
               'htmlOptions'=>array('style'=>'text-align: center')
            ),            
//            'daftartindakan_nama',
            array(
                'name'=>'Nama Tindakan',
                'type'=>'raw',
                'value'=>'$this->grid->getOwner()->renderPartial(\''.$this->path_view.'sensus/_tindakan\', array(\'id\'=>$data->pendaftaran_id))',
            ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>