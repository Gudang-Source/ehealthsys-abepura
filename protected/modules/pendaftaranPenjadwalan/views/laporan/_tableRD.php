<?php
  $table = 'ext.bootstrap.widgets.BootGridView';
if (isset($caraPrint)){
  $data = $model->searchPrint();
  $template = '{items}';
  if ($caraPrint=='EXCEL') {
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
  }
} else{
  $data = $model->searchTableLaporan();
  $template = "{summary}{items}{pager}";
}
?>
<?php if(isset($caraPrint)){ ?>
<?php }else{ ?>
<?php } ?>
<?php $this->widget($table,array(
	'id'=>'PPInfoKunjungan-v',
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
           array(
              'header'=>'Tanggal Pendaftaran <br/> / No Pendaftaran',
              'type'=>'raw',
              'value'=>'MyFormatter::formatDateTimeForUser(date("d/m/Y H:i:s",strtotime($data->tgl_pendaftaran)))." <br/> / ".$data->no_pendaftaran',
            ),
            array(
              'header'=>'No. Pendaftaran',
              'type'=>'raw',
              'value'=>'$data->no_pendaftaran',
            ),
            array(
              'header'=>'No. Rekam Medik',
              'type'=>'raw',
              'value'=>'$data->no_rekam_medik',
            ),
//            'no_rekam_medik',    
            array(
              'header'=>'Nama Pasien / Alias',
              'type'=>'raw',
              'value'=>'$data->NamaNamaBIN',
            ),
//            'NamaNamaBIN',
            array(
              'header'=>'Jenis Kelamin',
              'type'=>'raw',
              'value'=>'$data->jeniskelamin',
            ),
            array(
              'header'=>'Golongan Umur',
              'type'=>'raw',
              'value'=>'$data->golonganumur_nama',
            ),
            array(
              'header'=>'Agama',
              'type'=>'raw',
              'value'=>'$data->agama',
            ),
            array(
              'header'=>'Status Perkawinan',
              'type'=>'raw',
              'value'=>'$data->statusperkawinan',
            ),
            array(
              'header'=>'Pekerjaan',
              'type'=>'raw',
              'value'=>'$data->pekerjaan_nama',
            ),
            array(
              'header'=>'Alamat Lengkap',
              'type'=>'raw',
              'value'=>'$data->alamat_pasien',
            ),
//            'alamat_pasien',
            array(
              'header'=>'Kecamatan',
              'type'=>'raw',
              'value'=>'$data->kecamatan_nama',
            ),
            array(
              'header'=>'Kab. / Kota. ',
              'type'=>'raw',
              'value'=>'$data->kabupaten_nama',
            ),
            
            array(
              'header'=>'Cara Masuk',
              'type'=>'raw',
              'value'=>'$data->statusmasuk',
            ),
            array(
              'header'=>'Kunjungan',
              'type'=>'raw',
              'value'=>'$data->kunjungan',
            ),
            
            array(
              'header'=>'Penanggung Jawab / Pihak Ke-3',
              'type'=>'raw',
              'value'=>'$data->nama_pj',
            ),
            array(
              'header'=>'Nama Perujuk',
              'type'=>'raw',
              'value'=>'$data->nama_perujuk',
            ),
           array(
               'header'=>'Jenis Kasus Penyakit',
               'type'=>'raw',
               'value'=>'$data->jeniskasuspenyakit_nama'
              
           ),
            array(
               'name'=>'CaraBayar/Penjamin',
               'type'=>'raw',
               'value'=>'$data->CaraBayarPenjamin',
               'htmlOptions'=>array('style'=>'text-align: center')
            ),            
            array(
               'header'=>'Instalasi <br/> / Ruangan',
               'name'=>'ruangan_nama',
               'type'=>'raw',
               'value'=>'$data->instalasi_nama." <br/> /".$data->ruangan_nama',
               'htmlOptions'=>array('style'=>'text-align: center')
            ),
            array(
               'header'=>'Nama Dokter UGD',
               'type'=>'raw',
               'value'=>'$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
               'htmlOptions'=>array('style'=>'text-align: center')
            ),
         array(
                   'header'=>'Ket. Pulang',
                   'type'=>'raw',
                   //'value'=>'$data->nama_pegawai',
                    'value' => function ($data){
                        $cek = PasienpulangT::model()->find(" pendaftaran_id  = '".$data->pendaftaran_id."' ");
                        if (count($cek)>0){
                            echo $cek->keterangankeluar;
                        }else{
                            echo "-";
                        }
                    },
                   'htmlOptions'=>array('style'=>'text-align: center')
                ),
            array(
               'name'=>'statusperiksa',
               'type'=>'raw',
               'value'=>'$data->statusperiksa',
               'htmlOptions'=>array('style'=>'text-align: center')
            ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
<br/>