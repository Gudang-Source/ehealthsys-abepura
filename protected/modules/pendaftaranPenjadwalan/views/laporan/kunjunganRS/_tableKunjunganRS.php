<h6>Tabel <b>Kunjungan RS</b></h6>
<?php 
    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
         $table = 'ext.bootstrap.widgets.BootExcelGridView';        
        }
    } else{
        $data = $model->searchTable();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php if(!isset($caraPrint)){ ?>
<?php } ?>
<?php $this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$data,
//    'filter'=>$model,
	'template'=>$template,
	'enableSorting'=>$sort,
	'itemsCssClass'=>'table table-striped table-condensed',
    //'mergeColumns' => array('instalasi_nama', 'ruangan_nama'),
    'columns'=>array(
        'instalasi_nama',
        'ruangan_nama',
        'no_rekam_medik',
        'nama_pasien',
        'alamat_pasien',
        'jeniskelamin',
        'umur',
        'jeniskasuspenyakit_nama',
        'kelaspelayanan_nama',
        array(
            'name'=>'tgl_pendaftaran',
            'value'=>'date("d/m/Y H:i:s", strtotime($data->tgl_pendaftaran))',
        ),
    ),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?> 
