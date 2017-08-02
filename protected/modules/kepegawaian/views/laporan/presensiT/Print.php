
<?php 
if($caraPrint == 'EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>$periode, 'colspan'=>10));      
?>
<?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
	'id'=>'laporanpresensi-t-grid',
	'dataProvider'=>$model->searchPrintpresensi(),
//	'filter'=>$model,
        'template'=>"{pager}\n{items}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//        'mergeColumns' => array('pegawai.nomorindukpegawai'),
         'mergeHeaders'=>array(
                    array(
                        'name'=>'<center>Jadwal Presensi</center>',
                        'start'=>'6',
                        'end'=>'10',
                    ),
                ),
	'columns'=>array(
		/* array(
                    'header'=>'No.',
                    'type'=>'raw',
                    'value' => '$row+1'
                ),*/
               array(
                    'header' => 'No FP',
                    'name' => 'no_fingerprint'
                ),
				array(
					'header' => 'Kelompok Pegawai/ <br/> Kategori Pegawai Asal',
					'type' => 'raw',
					'value' => function ($data){
							$kelPeg = !empty($data->pegawai->kelompokpegawai_id)?$data->pegawai->kelompokpegawai->kelompokpegawai_nama:'-';
							$katPegAsl =  !empty($data->pegawai->kategoripegawaiasal)?$data->pegawai->kategoripegawaiasal:'-';
						
							return $kelPeg."/ <br/>".$katPegAsl;
					}
				),                               
				array(
					'header' => 'Jabatan/ <br/> Kelompok Jabatan',
					'type' => 'raw',
					'value' => function ($data){
							$jab = !empty($data->pegawai->jabatan_id)?$data->pegawai->jabatan->jabatan_nama:'-';
							$kelJab =  !empty($data->pegawai->kelompokjabatan)?$data->pegawai->kelompokjabatan:'-';
						
							return $jab."/ <br/>".$kelJab;
					}
				),                
				array(
					'header' => 'Jenis Tenaga Medis',
					'type' => 'raw',
					'value' => function ($data){
							$jnsTegMedis = !empty($data->pegawai->jenistenagamedis)?$data->pegawai->jenistenagamedis:'-';							
						
							return $jnsTegMedis;
					}
				),     
                'pegawai.nomorindukpegawai',
                'pegawai.nama_pegawai',  
                 array(
                        'header' => 'Shift / Jam Kerja',
						'type' => 'raw',
                        'value'=>'$this->grid->owner->renderPartial("presensiT/_shift",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id,"kelompok_jabatan"=>$data->pegawai->kelompokjabatan ,"statusscan_id"=>Params::STATUSSCAN_MASUK, "datepresensi"=>$data->datepresensi),true)',
                    ),
            
                array(
                    'header'=>'Tanggal Presensi',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->datepresensi)',
                ),
                /*
                array(
                    'header'=>'Jabatan',
                    'value'=>'$data->pegawai->jabatan->jabatan_nama',
                ),
                 * 
                 */
//                array(
//                    'header'=>'Tanggal Presensi',
//                    'value'=>'$data->tglpresensi',
//                ),
                array(
                    'header'=>'<center>Masuk</center>',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_statusscan",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>Params::STATUSSCAN_MASUK, "datepresensi"=>$data->datepresensi),true)',
                ),
                array(
                    'header'=>'<center>Keluar</center>',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_statusscan",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>Params::STATUSSCAN_KELUAR, "datepresensi"=>$data->datepresensi),true)',
                ),
                array(
                    'header'=>'<center>Pulang</center>',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_statusscan",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>Params::STATUSSCAN_PULANG, "datepresensi"=>$data->datepresensi),true)',
                ),                
                array(
                    'header'=>'<center>Datang</center>',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_statusscan",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>Params::STATUSSCAN_DATANG, "datepresensi"=>$data->datepresensi),true)',
                ),
                array(
                    'header' => 'Terlambat (Menit)',
                     'value'=>'$this->grid->owner->renderPartial("presensiT/_terlambat",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>Params::STATUSSCAN_MASUK, "datepresensi"=>$data->datepresensi, "kelompokjabatan"=>$data->pegawai->kelompokjabatan),true)',
                      'htmlOptions' => array('style'=>'text-align:center;')   
                ),
                array(
                    'header' => 'Pulang Awal (Menit)',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_pulangAwal",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>Params::STATUSSCAN_PULANG, "datepresensi"=>$data->datepresensi, "kelompokjabatan"=>$data->pegawai->kelompokjabatan),true)',
                     'htmlOptions' => array('style'=>'text-align:center;')   
                ),
                array(
                    'header'=>'<center>Status</center>',
					'type' => 'raw',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_statuskehadiran",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id, "datepresensi"=>$data->datepresensi, "kelompokjabatan"=>$data->pegawai->kelompokjabatan),true)',
                ),
                array(
						'header' => 'Keterangan',						
						'value' => function($data) use (&$cr) {                            
                            $cr = new CDbCriteria();
                            $cr->compare('tglpresensi::date', $data->datepresensi);
                            $cr->compare('pegawai_id', $data->pegawai_id);
                            //$cr->compare('statuskehadiran_id', $data->statuskehadiran_id);
                            $cr->addCondition('statusscan_id=:p1');
                            $cr->params[':p1'] = Params::STATUSSCAN_MASUK;
                            $pr = PresensiT::model()->find($cr);
                            
							if (count($pr)>0){
								if (!empty($pr->keterangan)){
									echo "<u>Ket - Masuk</u> : ".$pr->keterangan.'<br/>';
								}
							}
							
							$cr = new CDbCriteria();
                            $cr->compare('tglpresensi::date', $data->datepresensi);
                            $cr->compare('pegawai_id', $data->pegawai_id);
                            //$cr->compare('statuskehadiran_id', $data->statuskehadiran_id);
                            $cr->addCondition('statusscan_id=:p1');
                            $cr->params[':p1'] = Params::STATUSSCAN_PULANG;
                            $pr = PresensiT::model()->find($cr);
                            
							if (count($pr)>0){
								if (!empty($pr->keterangan)){
									echo "<u>Ket - Pulang</u> : ".$pr->keterangan.'<br/>';
								}
							}
                        },
					),
            )
)); ?>

