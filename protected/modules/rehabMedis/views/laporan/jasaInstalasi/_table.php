
<?php
$itemCssClass = 'table table-striped table-condensed';
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$template = "{summary}\n{items}\n{pager}";
$sort = true;
if (isset($caraPrint)){
  $data = $model->searchPrint();
  $template = "{items}";
  $sort = false;
  if ($caraPrint=='EXCEL') {
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
  }
  if ($caraPrint=='PDF') {
      $table = 'ext.bootstrap.widgets.BootGridViewPDF';
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
?>

<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'enableSorting'=>$sort,
        'template'=>$template,
        'mergeHeaders'=>array(
            array(
                'name'=>'<center>Tindakan</center>',
                'start'=>7, //indeks kolom 3
                'end'=>13, //indeks kolom 4
            ),
            array(
                'name'=>'<center>Karcis</center>',
                'start'=>14, //indeks kolom 3
                'end'=>18, //indeks kolom 4
            ),
        ),
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
                array(
                    'header' => 'No.',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1'
                ),
                array(
                    'header' => 'Tanggal Pendaftaran/ <br/> No Pendaftaran',
                    'type' => 'raw',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/ <br/>".$data->no_pendaftaran',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
			'header'=>'No. Rekam Medik',
			'value'=> '$data->no_rekam_medik',
			'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
		),
                array(
                    'header' => 'Nama Pasien',
                    'value' => '$data->namadepan." ".$data->nama_pasien'
                ),		
                array(
                    'header' => 'Dokter',
                    'value' => function($data){
                        $pegawai_id = TindakanpelayananT::model()->findByPk($data->tindakanpelayanan_id)->dokterpemeriksa1_id;
                        
                        $nama = RMPegawaiM::model()->findByPk($pegawai_id);
                        
                        if (count($nama)>0){
                            return $nama->namaLengkap;
                        }else{
                            return '-';
                        }
                    }
                ),
                array(
                    'header' => 'Kelas Pelayanan',
                    'value' => '$data->kelaspelayanan_nama'
                ),
		array(
			'header'=>'Cara Bayar Penjamin',
			'name' => 'carabayarPenjamin',
			'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
		),
		array(
			'header'=>'Daftar Nama Tindakan',
			'name' => 'daftartindakan_nama',
			'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
			'value'=>'($data->daftartindakan_karcis == false) ? $data->daftartindakan_nama : \'\'',
		),
		array(
			'name' => 'qty_tindakan',
			'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
			'value'=>'($data->daftartindakan_karcis == false) ? $data->qty_tindakan : \'\'',
		),
		array(
			'name' => 'tarif_rsakomodasi',
			'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
			'value'=>'($data->daftartindakan_karcis == false) ? "Rp".number_format($data->tarif_rsakomodasi,0,"",".") : \'\'',
                        'htmlOptions' => array('style'=>'text-align:right;'),
		),
		array(
			'name' => 'tarif_medis',
			'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
			'value'=>'($data->daftartindakan_karcis == false) ? "Rp".number_format($data->tarif_medis,0,"",".") : \'\'',
                        'htmlOptions' => array('style'=>'text-align:right;'),
		),
		array(
			'name' => 'tarif_paramedis',
			'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
			'value'=>'($data->daftartindakan_karcis == false) ? "Rp".number_format($data->tarif_paramedis,0,"",".") : \'\'',
                        'htmlOptions' => array('style'=>'text-align:right;'),
		),
		array(
			'name' => 'tarif_bhp',
			'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
			'value'=>'($data->daftartindakan_karcis == false) ? "Rp".number_format($data->tarif_bhp,0,"",".") : \'\'',
                        'htmlOptions' => array('style'=>'text-align:right;'),
		),
		array(
			'name'=>'subtotal',
			'type'=>'raw',
			'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
			'value'=>'($data->daftartindakan_karcis == false) ? "Rp".number_format(($data->tarif_rsakomodasi+$data->tarif_medis+$data->tarif_paramedis+$data->tarif_bhp),0,"",".") : \'\'',
                        'htmlOptions' => array('style'=>'text-align:right;'),
		),
		array(
			'name' => 'karcisnama',
			'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
			'value'=>'($data->daftartindakan_karcis == false) ? \'\' : $data->daftartindakan_nama',
		),
		array(
			'name' => 'karcisqty',
			'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
			'value'=>'($data->daftartindakan_karcis == false) ? \'\' : $data->qty_tindakan',
		),
		array(
			'name' => 'karcisrs',
			'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
			'value'=>'($data->daftartindakan_karcis == false) ? \'\' : "Rp".number_format($data->tarif_rsakomodasi,0,"",".")',
                        'htmlOptions' => array('style'=>'text-align:right;'),
		),
		array(
			'name' => 'karcismedis',
			'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
			'value'=>'($data->daftartindakan_karcis == false) ? \'\' : "Rp".number_format($data->tarif_medis,0,"",".")',
                        'htmlOptions' => array('style'=>'text-align:right;'),
		),

		array(
			'name'=>'subtotal',
			'type'=>'raw',
			'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
			'value'=>'($data->daftartindakan_karcis == false) ? \'\' : "Rp".number_format($data->qty_tindakan*($data->tarif_rsakomodasi+$data->tarif_medis),0,"",".")',
                        'htmlOptions' => array('style'=>'text-align:right;'),
		),
                        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>