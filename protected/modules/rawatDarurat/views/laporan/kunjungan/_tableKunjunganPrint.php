<?php
$itemCssClass = 'table table-striped table-condensed';
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
  $data = $model->searchPrint();
  $template = "{items}";
  if ($caraPrint=='EXCEL') {
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
                    border-spacing:0px;
                    padding:0px;
                }

                .table tbody tr:hover td, .table tbody tr:hover th {
                    background-color: none;
                }
            </style>";
          $itemCssClass = 'table border';
} else{
  $data = $model->searchTable();
}
$sort=true;
?>
<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'enableSorting'=>$sort,
	'dataProvider'=>$data,
	'template'=>$template,
	'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
            array(
                'header' => 'No',
                'value' => '$row+1'
            ),
            array(
                'header' => 'No Rekam Medik',
                'value' => '$data->no_rekam_medik'
            ),            
            array(
              'header'=>'Nama Pasien',
              'value'=>'$data->namadepan." ".$data->nama_pasien',
            ),
//            'NamaNamaBIN',
          /*  array(
                'header'=>'Jenis Kelamin',
                'value'=>'$data->jeniskelamin',
            ), */
//            'jeniskelamin',
             array(
                'header' => 'Umur',
                'value' => '$data->umur'
            ), 
            array(
                'header' => 'Alamat',
                'value' => '$data->alamat_pasien'
            ), 
            array(
                'header' => 'Status Pasien',
                'value' => '$data->statuspasien'
            ), 
            array(
                'header' => 'Status Masuk',
                'value' => '$data->statusmasuk'
            ),
            array(
                'header' => 'Kunjungan',
                'value' => '$data->kunjungan'
            ),            

//            'diagnosa_nama',
//            'daftartindakan_nama',
            array(
               'name'=>'CaraBayar/Penjamin',
               'type'=>'raw',
               'value'=>'$data->CaraBayarPenjamin',
               'htmlOptions'=>array('style'=>'text-align: center')
            ), 
            array(
               'name'=>'Cara Masuk',
               'type'=>'raw',
               'value'=>'$data->caramasuk_nama',
            ),     
                        // 'caramasuk_nama',
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>