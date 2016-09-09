<h6>Tabel <b>Kunjungan RS</b></h6>
<?php 
    $itemCssClass = 'table table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
         $table = 'ext.bootstrap.widgets.BootExcelGridView';        
        }
        echo "
            <style>
                .border th, .border td{
                    border:1px solid #000;
                }
                .table thead:first-child{
                    border-top:1px solid #000;        
                }

                thead th{
                    background:none;
                    color:#333;
                }

                .border {
                    box-shadow:none;
                }

                .table tbody tr:hover td, .table tbody tr:hover th {
                    background-color: none;
                }
            </style>";
        $itemCssClass = 'table border';
        
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
	'itemsCssClass'=>$itemCssClass,
    //'mergeColumns' => array('instalasi_nama', 'ruangan_nama'),
    'columns'=>array(                
        array(
            'name'=>'tgl_pendaftaran',
            'value'=>'MyFormatter::formatDateTimeForUser(date("d/m/Y H:i:s", strtotime($data->tgl_pendaftaran)))',
        ),
        'no_rekam_medik',
        array(
            'header' => 'Nama Pasien',
            'value' => '$data->namadepan." ".$data->nama_pasien'
        ),
        'nama_pasien',
        'alamat_pasien',
        'jeniskelamin',
        'umur',
        array(
            'header' => 'Instalasi <br> / Ruangan',
            'type' => 'raw',
            'value' => '$data->instalasi_nama." <br/> / ".$data->ruangan_nama'
        ),
        'jeniskasuspenyakit_nama',
        'kelaspelayanan_nama',
        
    ),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?> 
