<?php 
	$itemCssClass = 'table table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
    $sort = true;
	$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchPrintJasaDokter();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
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
        $data = $model->searchJasaDokter();
        $template = "{summary}\n{items}\n{pager}";
    }
?>

<?php if($tab == "rekap") { ?>
<div id="div_rekap">
    <?php if(isset($caraPrint)){ 
        
    }else{ ?>
            <legend class="rim">Tabel Rekap Jasa Dokter</legend>
    <?php } ?>
    <?php             
        $this->widget($table,array(
            'id'=>'laporanrekapjasadokter-grid',
            'dataProvider'=>$data,
            'enableSorting'=>$sort,
            'template'=>$template,
                'itemsCssClass'=>$itemCssClass,
                'columns'=>array(
                    array(
                     'header' => 'No.',
                     'value' => $row
                    ),
                    array(
                        'header' => 'No.',
                        'value' => $row
                    ),
                    array(
                        'header' => 'Tanggal Pendaftaran/ No Pendaftaran',
                        'type' => 'raw',
                        'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/ <br/>".$data->no_pendaftaran',
                    ),
                    array(
                        'header' => 'No. Rekam Medis',
                        'type' => 'raw',
                        'value' => '$data->no_rekam_medik',
                    ),
                    array(
                        'header' => 'Nama Pasien',
                        'type' => 'raw',
                        'value' => '$data->namadepan." ".$data->nama_pasien',
                    ),
                    array(
                        'header' => 'Kelas Pelayanan',
                        'type' => 'raw',
                        'value' => '$data->kelaspelayanan_nama',
                    ),
                    array(
                        'header' => 'Nama Tindakan',
                        'type' => 'raw',
                        'value' => '$data->daftartindakan_nama',
                    ),
					array(
                        'header' => 'Nama Dokter',
                        'type' => 'raw',
                        'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
                    ),
                    array(
                        'header' => 'Tanggal Keluar',
                        'type' => 'raw',
                        'value' => '(isset($data->tgl_keluar) ?MyFormatter::formatDateTimeForUser($data->tgl_keluar) : "-")',
                    ),                   
                    array(
                        'header' => 'Jasa Pelayanan',
                        'type' => 'raw',
                        'value' => 'MyFormatter::formatNumberForPrint($data->tarif_tindakankomp)',
						'htmlOptions' => array('style' => 'text-align:right;'),
					),
					array(
						'header' => 'Instalasi/ <br/>Ruangan',
						'type' => 'raw',
						'value' => '$data->instalasi_nama."/<br/>".$data->ruangan_nama'
					),    
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            )); 
        ?>
</div>
<?php }else if($tab == "detail"){ ?>
<div id="div_detail">
    <?php if(isset($caraPrint)){ 
            $dataDetail = $model->searchPrintDetailJasaDokter();
    }else{ 
        $dataDetail = $model->searchDetailJasaDokter();
   ?>
            <legend class="rim">Table Rekap Detail Jasa Dokter</legend>
    <?php } ?>
    <?php 
        $this->widget($table,array(
            'id'=>'laporandetailjasadokter-grid',
            'dataProvider'=>$dataDetail,
            'enableSorting'=>$sort,
            'template'=>$template,
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                 'mergeHeaders'=>array(
                    array(
                        'name'=>'<center>Dokter</center>',
                        'start'=>7, //indeks kolom 3
                        'end'=>9, //indeks kolom 4
                    ),
                    array(
                        'name'=>'<center>Bedah</center>',
                        'start'=>12, //indeks kolom 3
                        'end'=>15, //indeks kolom 4
                    ),
                ),
                'columns'=>array(
                    array(
                        'header' => 'No',
                        'value' => '$row+1'
                    ),
                    array(
                      'header'=>'Tanggal Transaksi',
                      'type'=>'raw',
                      'value'=>'date("d/m/Y",strtotime($data->tgl_pendaftaran))',
                    ),
                    array(
                      'header'=>'No. Rekam Medik',
                      'type'=>'raw',
                      'value'=>'$data->no_rekam_medik',
                    ),
                    array(
                      'header'=>'Nama Lengkap',
                      'type'=>'raw',
                      'value'=>'$data->nama_pasien',
                    ),
                    array(
                      'header'=>'Unit Pelayanan',
                      'type'=>'raw',
                      'value'=>'$data->instalasi_nama',
                    ),
                    array(
                      'header'=>'Nama Ruangan',
                      'type'=>'raw',
                      'value'=>'$data->ruangan_nama',
                    ),
                    array(
                      'header'=>'Jumlah',
                      'type'=>'raw',
                      'value'=>'$data->qty_tindakan',
                    ),
                    array(
                      'header'=>'Gelar Depan',
                      'type'=>'raw',
                      'value'=>'(empty($data->gelardepan) ? "-" : "$data->gelardepan" )',
                    ),
                    array(
                      'header'=>'Nama Dokter',
                      'type'=>'raw',
                      'value'=>'(empty($data->nama_pegawai) ? "-" : "$data->nama_pegawai" )',
                    ),
                    array(
                      'header'=>'Gelar Belakang',
                      'type'=>'raw',
                      'value'=>'(empty($data->gelarbelakang_nama) ? "-" : "$data->gelarbelakang_nama" )',
                    ),
                    array(
                      'header'=>'Visite',
                      'type'=>'raw',
                      'value'=>'$this->grid->owner->renderPartial("bedahSentral.views.laporan/jasaDokter/_tarifVisit",array("pendaftaran_id"=>"$data->pendaftaran_id","ruangan_id"=>"$data->ruangan_id","tgl_pendaftaran"=>"$data->tgl_pendaftaran"),true)',
                      'htmlOptions'=>array('style'=>'text-align:right;'),
                    ),
                    array(
                      'header'=>'Konsul',
                      'type'=>'raw',
                      'value'=>'$this->grid->owner->renderPartial("bedahSentral.views.laporan/jasaDokter/_tarifKonsul",array("pendaftaran_id"=>"$data->pendaftaran_id","ruangan_id"=>"$data->ruangan_id","tgl_pendaftaran"=>"$data->tgl_pendaftaran"),true)',
                      'htmlOptions'=>array('style'=>'text-align:right;'),
                    ),
                    array(
                      'header'=>'Tindakan',
                      'type'=>'raw',
                      'value'=>'$this->grid->owner->renderPartial("bedahSentral.views.laporan/jasaDokter/_tarifTindakan",array("pendaftaran_id"=>"$data->pendaftaran_id","ruangan_id"=>"$data->ruangan_id","tgl_pendaftaran"=>"$data->tgl_pendaftaran"),true)',
                      'htmlOptions'=>array('style'=>'text-align:right;'),
                    ),
                    array(
                      'header'=>'Jasa Operator',
                      'type'=>'raw',
                      'value'=>'$this->grid->owner->renderPartial("bedahSentral.views.laporan/jasaDokter/_tarifOperator",array("pendaftaran_id"=>"$data->pendaftaran_id","ruangan_id"=>"$data->ruangan_id","tgl_pendaftaran"=>"$data->tgl_pendaftaran"),true)',
                      'htmlOptions'=>array('style'=>'text-align:right;'),
                    ),
                    array(
                      'header'=>'Sewa Alat',
                      'type'=>'raw',
                      'value'=>'$this->grid->owner->renderPartial("bedahSentral.views.laporan/jasaDokter/_tarifSewaAlat",array("pendaftaran_id"=>"$data->pendaftaran_id","ruangan_id"=>"$data->ruangan_id","tgl_pendaftaran"=>"$data->tgl_pendaftaran"),true)',
                      'htmlOptions'=>array('style'=>'text-align:right;'),
                    ),
                    array(
                      'header'=>'Alat Bahan',
                      'type'=>'raw',
                      'value'=>'$this->grid->owner->renderPartial("bedahSentral.views.laporan/jasaDokter/_tarifAlatBahan",array("pendaftaran_id"=>"$data->pendaftaran_id","ruangan_id"=>"$data->ruangan_id","tgl_pendaftaran"=>"$data->tgl_pendaftaran"),true)',
                      'htmlOptions'=>array('style'=>'text-align:right;'),
                    ),
                    array(
                      'header'=>'Total',
                      'type'=>'raw',
                      'value'=>'$this->grid->owner->renderPartial("bedahSentral.views.laporan/jasaDokter/_tarifTotal",array("pendaftaran_id"=>"$data->pendaftaran_id","ruangan_id"=>"$data->ruangan_id","tgl_pendaftaran"=>"$data->tgl_pendaftaran"),true)',
                      'htmlOptions'=>array('style'=>'text-align:right;'),
                    ),

                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            )); 
        ?>
</div>
<?php } ?>
