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
//    'filter'=>$model,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
       'mergeColumns' => array('instalasi_nama', 'ruangan_nama', 'dokter_nama'),
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
          'header'=>'No. Rekam Medis'."/"."<br/>".'No. Pendaftaran',
          'value'=>'$data->no_rekam_medik."<br/>".$data->no_pendaftaran',
          'type'=>'raw',
        ),
        array(
          'header'=>'Nama Pasien'." /"."<br/>".'Alias',
          'value'=>'$data->nama_pasien."<br/>".$data->nama_bin',
          'type'=>'raw',
        ),
        array(
          'header'=>'Tanggal Pendaftaran',
          'value'=>'$data->tgl_pendaftaran',
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
