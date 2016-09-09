<?php 
    $merge = array('instalasi_nama', 'ruangan_nama', 'dokter_nama');
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
        if ($caraPrint == "PDF"){
            $merge = array();
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
<?php $this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$data,
//    'filter'=>$model,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>$itemCssClass,
       'mergeColumns' => $merge,
    'columns'=>array(
        array(
          'header'=>'No.',
          'value'=>'(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
          'type'=>'raw',
        ),
       'instalasi_nama',
       'ruangan_nama',
        'dokter_nama',
        array(
          'header'=>'Tanggal Pendaftaran',
          'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
          'type'=>'raw',
        ),
        array(
          'header'=>'No. Rekam Medis'."/"."<br/>".'No. Pendaftaran',
          'value'=>'$data->no_rekam_medik."<br/>".$data->no_pendaftaran',
          'type'=>'raw',
        ),
        array(
          'header'=>'Nama Pasien',
          'value'=>'$data->namadepan." ".$data->nama_pasien',
          'type'=>'raw',
        ),        
        array(
          'header'=>'Jenis Kelamin'."/"."<br/>".'Umur',
          'value'=>'$data->jeniskelamin."<br/>".$data->umur',
          'type'=>'raw',
        ),
        array(
          'header'=>'Kelas Pelayanan'."/"."<br/>".'Kelas penyakit',
          'value'=>'$data->kelaspelayanan_nama."<br/>".$data->jeniskasuspenyakit_nama',
          'type'=>'raw',
        ),
        array(
          'header'=>'Alamat'."/"."<br/>".'RT'." / ".'RW',
          'value'=>'$data->alamat_pasien."<br/>".$data->rt." / ".$data->rw',
          'type'=>'raw',
        ),
        array(
          'header'=>'Cara Bayar'."/"."<br/>".'Penjamin',
          'value'=>'$data->carabayar_nama."<br/>".$data->penjamin_nama',
          'type'=>'raw',
        ),
        
    ),
//        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?> 
