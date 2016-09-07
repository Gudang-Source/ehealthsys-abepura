<?php 
    $table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
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
        'mergeHeaders'=>array(
            array(
                'name'=>'<center>Tindakan</center>',
                'start'=>6, //indeks kolom 3
                'end'=>11, //indeks kolom 4
            ),
            array(
                'name'=>'<center>Karcis</center>',
                'start'=>13, //indeks kolom 3
                'end'=>16, //indeks kolom 4
            ),
        ),
        'mergeColumns'=>array('nama_pasien','no_rekam_medik'),
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
		array(
			'header'=>'No.',
			'value' => $row,
		),
		array(
			'header'=>'No. Rekam Medik/<br/>Nama Pasien',
			'value'=> '$data->noRMNamaPasien',
			'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
		),
		array(
			'header' => 'No.Pendaftaran/<br/> Kelas Pelayanan',
			'value'=>'$data->NoPendaftaranKelas',
			'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
		),
                array(
                    'header' => 'Dokter',
                    'value' => function($data){
                        $pegawai_id = TindakanpelayananT::model()->findByPk($data->tindakanpelayanan_id)->dokterpemeriksa1_id;
                        
                        $nama = RIPegawaiM::model()->findByPk($pegawai_id);
                        
                        if (count($nama)>0){
                            return $nama->namaLengkap;
                        }else{
                            return '-';
                        }
                    }
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
			'value'=>'($data->daftartindakan_karcis == false) ? "Rp".number_format($data->qty_tindakan*($data->tarif_rsakomodasi+$data->tarif_medis+$data->tarif_paramedis+$data->tarif_bhp),0,"",".") : \'\'',
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