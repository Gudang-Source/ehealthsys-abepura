<?php
    class LaporanController extends MyAuthController{
        public $layout='//layouts/column1';
        
        public function actionLaporanPegawai()
        {
            $model = new PegawaiM();
           
            $model->tglpresensi = date('Y-m-01');
            $model->tglpresensi_akhir = date('Y-m-d');
            if(isset($_GET['PegawaiM']))
            {
                $model->attributes = $_GET['PegawaiM'];
                $model->tglpresensi = $_GET['PegawaiM']['tglpresensi'].' 00:00:00';
                $model->tglpresensi_akhir = $_GET['PegawaiM']['tglpresensi_akhir'].' 23:59:59';                            }
            $this->render('daftarHadir/index',array(
                'model'=>$model,
            ));            
        }
        
        public function actionDetailLaporanAbsen($id,$tgl_awal,$tgl_akhir)
        {
            $format = new MyFormatter();
            $this->layout='//layouts/iframe';
            $model = new KPPresensiT('detailPresensi');
            $model->pegawai_id = $id;
            $model->tglpresensi = $format->formatDateTimeForDb($tgl_awal);
            $model->tglpresensi_akhir = $format->formatDateTimeForDb($tgl_akhir);
            
            /*
            $model->tglpresensi = date('Y-m-d', strtotime('2013-05-25'));
            $model->tglpresensi_akhir = date('Y-m-d');
            
            if(isset($_GET['PresensiT']))
            {
                $criteria->addBetweenCondition('DATE(tglpresensi)', $_GET['PresensiT']['tglpresensi'], $_GET['PresensiT']['tglpresensi_akhir']);
            }
             * 
             */
            
            if(isset($_GET['KPPresensiT']))
            {   
                $format = new MyFormatter();
                $tglpresensi = $format->formatDateTimeForDb($_GET['KPPresensiT']['tglpresensi']);
                $tglpresensi_akhir = $format->formatDateTimeForDb($_GET['KPPresensiT']['tglpresensi_akhir']);
                $model->tglpresensi = $tglpresensi;
                $model->tglpresensi_akhir = $tglpresensi_akhir;
            }
            
            $modPegawai = KPPegawaiM::model()->findByPk($id);
            $modPegawai->hadir = $modPegawai->getTotalStatusKehadiran(Params::STATUSKEHADIRAN_HADIR, $id, $tgl_awal, $tgl_akhir);
            $modPegawai->izin = $modPegawai->getTotalStatusKehadiran(Params::STATUSKEHADIRAN_IZIN, $id, $tgl_awal, $tgl_akhir);
            $modPegawai->sakit = $modPegawai->getTotalStatusKehadiran(Params::STATUSKEHADIRAN_SAKIT, $id, $tgl_awal, $tgl_akhir);
            $modPegawai->dinas = $modPegawai->getTotalStatusKehadiran(Params::STATUSKEHADIRAN_DINAS, $id, $tgl_awal, $tgl_akhir);
            $modPegawai->alpha = $modPegawai->getTotalStatusKehadiran(Params::STATUSKEHADIRAN_ALPHA, $id, $tgl_awal, $tgl_akhir);
            $modPegawai->rerata_jam_masuk = $this->renderPartial("daftarHadir/_rerataJamMasuk",array("pegawai_id"=>$id ,"statusscan_id"=>  Params::STATUSSCAN_MASUK,'tgl_awal'=>$tgl_awal,'tgl_akhir'=>$tgl_akhir),true);
            $modPegawai->rerata_jam_keluar = $this->renderPartial("daftarHadir/_rerataJamKeluar",array("pegawai_id"=>$id ,"statusscan_id"=>  Params::STATUSSCAN_PULANG,'tgl_awal'=>$tgl_awal,'tgl_akhir'=>$tgl_akhir),true);
            $this->render('daftarHadir/detailAbdesensi',array(
                'model'=>$model,
                'modPegawai' => $modPegawai
            ));            
        }
        
        //buat ngeprint detailPresensi
        public function actionPrintDetailPresensi(){
            $model= new PegawaiM;
            $model->attributes=$_REQUEST['PegawaiM'];
            $model->tglpresensi = $_REQUEST['PegawaiM']['tglpresensi'];
            $model->tglpresensi_akhir = $_REQUEST['PegawaiM']['tglpresensi_akhir'];
            $judulLaporan='Laporan Presensi';
            $caraPrint=$_REQUEST['caraPrint'];
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
                $this->render('daftarHadir/Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($caraPrint=='EXCEL') {
                $this->layout='//layouts/printExcel';
                $this->render('daftarHadir/Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($_REQUEST['caraPrint']=='PDF') {
                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
                $mpdf = new MyPDF('',$ukuranKertasPDF); 
                $mpdf->useOddEven = 2;  
                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                $mpdf->WriteHTML($stylesheet,1);  
                $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                $mpdf->WriteHTML($this->renderPartial('daftarHadir/Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
                $mpdf->Output();
            }
        }
        
        
        public function actionPrintDetailLaporanPresensi($id,$tglpresensi, $tglpresensi_akhir)
        {
            $model = new KPPresensiT('detailPresensi');
            $model->pegawai_id = $id;
            $modPegawai = KPPegawaiM::model()->findByPk($id);
            
            /*
            if(isset($_GET['PresensiT']))
            {
                $criteria->addBetweenCondition('DATE(tglpresensi)', $_GET['PresensiT']['tglpresensi'], $_GET['PresensiT']['tglpresensi_akhir']);
            }
             * 
             */
            $modPegawai = KPPegawaiM::model()->findByPk($id);
            $modPegawai->hadir = $modPegawai->getTotalStatusKehadiran(Params::STATUSKEHADIRAN_HADIR, $id, $tglpresensi, $tglpresensi_akhir);
            $modPegawai->izin = $modPegawai->getTotalStatusKehadiran(Params::STATUSKEHADIRAN_IZIN, $id, $tglpresensi, $tglpresensi_akhir);
            $modPegawai->sakit = $modPegawai->getTotalStatusKehadiran(Params::STATUSKEHADIRAN_SAKIT, $id, $tglpresensi, $tglpresensi_akhir);
            $modPegawai->dinas = $modPegawai->getTotalStatusKehadiran(Params::STATUSKEHADIRAN_DINAS, $id, $tglpresensi, $tglpresensi_akhir);
            $modPegawai->alpha = $modPegawai->getTotalStatusKehadiran(Params::STATUSKEHADIRAN_ALPHA, $id, $tglpresensi, $tglpresensi_akhir);
            $modPegawai->rerata_jam_masuk = $this->renderPartial("daftarHadir/_rerataJamMasuk",array("pegawai_id"=>$id ,"statusscan_id"=>  Params::STATUSSCAN_MASUK,'tgl_awal'=>$tglpresensi,'tgl_akhir'=>$tglpresensi_akhir),true);
            $modPegawai->rerata_jam_keluar = $this->renderPartial("daftarHadir/_rerataJamKeluar",array("pegawai_id"=>$id ,"statusscan_id"=>  Params::STATUSSCAN_PULANG,'tgl_awal'=>$tglpresensi,'tgl_akhir'=>$tglpresensi_akhir),true);
            
            $judulLaporan = 'Laporan Presensi Per Pegawai';
            $caraPrint = $_REQUEST['caraPrint'];
            $periode = null;
            if(isset($_REQUEST['tglpresensi']))
            {   
                $tglpresensi = date('Y-m-d ', strtotime($_REQUEST['tglpresensi']));
                $tglpresensi_akhir = date('Y-m-d ', strtotime($_REQUEST['tglpresensi_akhir']));
                $model->tglpresensi = $tglpresensi;
                $model->tglpresensi_akhir = $tglpresensi_akhir;
            }
            
            if($caraPrint == 'PRINT')
            {
                $this->layout='//layouts/printWindows';
                $this->render(
                    'daftarHadir/_printWindows',
                    array(
                        'model'=>$model,
                        'modPegawai'=>$modPegawai,
                        'periode'=>$periode,
                        'judulLaporan'=>$judulLaporan,
                        'caraPrint'=>$caraPrint
                    )
                );
            }
            else if($caraPrint=='EXCEL')
            {
                $this->layout = '//layouts/printExcel';
                $judulLaporan = $modPegawai->nama_pegawai;
                $this->render(
                    'daftarHadir/_printExel',
                    array(
                        'model'=>$model,
                        'modPegawai'=>$modPegawai,
                        'periode'=>$periode,
                        'judulLaporan'=>$judulLaporan,
                        'caraPrint'=>$caraPrint
                    )
                );
            }
            else if($_REQUEST['caraPrint'] == 'PDF')
            {
                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); // Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
                $mpdf = new MyPDF('',$ukuranKertasPDF); 
                $mpdf->useOddEven = 2;  
                $mpdf->WriteHTML($stylesheet,1);
                $mpdf->AddPage($posisi,'','','','',5,5,5,5,5,5);
                $mpdf->WriteHTML(
                    $this->renderPartial(
                        'daftarHadir/_printPdf',
                        array(
                            'model'=>$model,
                            'modPegawai'=>$modPegawai,
                            'periode'=>$periode,
                            'judulLaporan'=>$judulLaporan,
                            'caraPrint'=>$caraPrint
                        ),true
                    )
                );
                $mpdf->Output($judulLaporan.'-'.date('Y/m/d').'.pdf','I');
            }
        }
        
        public function actionLaporanPresensi()
	{
            $model = new KPPresensiT('search');
            $format = new MyFormatter();
            
            if (isset($_GET['KPPresensiT'])) {
                $model->attributes = $_GET['KPPresensiT'];
                $tglpresensi = $format->formatDateTimeForDb($_GET['KPPresensiT']['tglpresensi']);
                $tglpresensi_akhir = $format->formatDateTimeForDb($_GET['KPPresensiT']['tglpresensi_akhir']);
                $tglpresensi = date('Y-m-d ', strtotime($_GET['KPPresensiT']['tglpresensi']));
                $tglpresensi_akhir = date('Y-m-d ', strtotime($_GET['KPPresensiT']['tglpresensi_akhir']));
                $model->tglpresensi = $tglpresensi;
                $model->tglpresensi_akhir = $tglpresensi_akhir;
				if(!empty($_GET['KPPresensiT']['ruangan_id'])){
					$model->ruangan_id = $_GET['KPPresensiT']['ruangan_id'];
				}
//				else{
//					$model->ruangan_id = Yii::app()->user->getState('ruangan_id');
//				}
                $model->unit_perusahaan = $_GET['KPPresensiT']['unit_perusahaan'];
            }else{
                $model->tglpresensi = date('d M Y');
                $model->tglpresensi_akhir = date('d M Y');
            }
            $this->render('presensiT/_laporanpresensi',array(
                'model'=>$model,'format'=>$format,
            ));
	}
        
        public function actionPrintLaporanPresensi()
        {
            $model= new KPPresensiT('search');
            $model->tglpresensi = date('Y-m-d 00:00:00');
            $model->tglpresensi_akhir = date('Y-m-d 23:59:59');
            $format = new MyFormatter();
            $model->attributes = $_GET['KPPresensiT'];
            $model->tglpresensi = date('Y-m-d ', strtotime($_GET['KPPresensiT']['tglpresensi']));
            $model->tglpresensi_akhir = date('Y-m-d ', strtotime($_GET['KPPresensiT']['tglpresensi_akhir']));
            $model->unit_perusahaan = $_GET['KPPresensiT']['unit_perusahaan'];
            
            $judulLaporan = 'Laporan Presensi';
            $caraPrint = $_REQUEST['caraPrint'];
            $periode = $format->formatDateTimeForUser($model->tglpresensi).' s/d '.$format->formatDateTimeForUser($model->tglpresensi_akhir);
            
            if($caraPrint == 'PRINT')
            {
                $this->layout = '//layouts/printWindows';
                $this->render('presensiT/Print',array('model'=>$model,'periode'=>$periode,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($caraPrint == 'EXCEL') {
                $this->layout = '//layouts/printExcel';
                $this->render('presensiT/Print',array('model'=>$model,'periode'=>$periode,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($_REQUEST['caraPrint'] == 'PDF')
            {
                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); // Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
                $mpdf = new MyPDF('',$ukuranKertasPDF); 
                $mpdf->useOddEven = 2;
                $mpdf->WriteHTML($stylesheet,1);
                $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                $mpdf->WriteHTML($this->renderPartial('presensiT/Print',array('model'=>$model, 'periode'=>$periode,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
                $mpdf->Output($judulLaporan.'-'.date('Y/m/d').'.pdf','I');
            }                    
        }
                
        public function actionFramePresensi() 
        {
            $this->layout = '//layouts/iframe';

            $model = new PresensiT;
            $model->tglpresensi = date('Y-m-d 00:00:00');
            $model->tglpresensi_akhir = date('Y-m-d 23:59:59');

            //Data Grafik
            $data['title'] = 'Grafik Presensi';
            $data['type'] = $_GET['type'];

            if (isset($_REQUEST['PresensiT'])) {
                    $format = new MyFormatter;
                    $model->attributes = $_GET['PresensiT'];
                    $tglpresensi = date('Y-m-d ', strtotime($_GET['PresensiT']['tglpresensi']));
                            $tglpresensi_akhir = date('Y-m-d ', strtotime($_GET['PresensiT']['tglpresensi_akhir']));
                            
                            $model->tglpresensi = $tglpresensi;
                            $model->tglpresensi_akhir = $tglpresensi_akhir;
            }
            $searchdata = $model->searchPresensiGrafik();
            $this->render('_grafik', array(
                'model' => $model,
                'data' => $data,
                'searchdata'=>$searchdata,
            ));
        }
        
        public function actionLaporanPenggajian()
        {
            $model = new KPPenggajianpegT('search');
            $model->tgl_awal = date('Y-m-d 00:00:00');
            $model->tgl_akhir = date('Y-m-d 23:59:59');
            if (isset($_GET['KPPenggajianpegT'])) {
                $format = new MyFormatter;
                $model->nama_pegawai = $_GET['KPPenggajianpegT']['nama_pegawai'];
                $model->jabatan_id = $_GET['KPPenggajianpegT']['jabatan_id'];
                $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['KPPenggajianpegT']['tgl_awal']);
                $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['KPPenggajianpegT']['tgl_akhir']);
            }

            $this->render('penggajianpegT/index',array(
                'model'=>$model,
            ));
        }
        
        public function actionPrintLaporanPenggajian()
                {
                    $model= new KPPenggajianpegT('search');
                    $model->tgl_awal = date('Y-m-d 00:00:00');
                    $model->tgl_akhir = date('Y-m-d 23:59:59');
                    
                    $format = new MyFormatter;
                    if (isset($_GET['KPPenggajianpegT'])) {
                        $model->nama_pegawai = $_GET['KPPenggajianpegT']['nama_pegawai'];
                        $model->jabatan_id = $_GET['KPPenggajianpegT']['jabatan_id'];
                        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['KPPenggajianpegT']['tgl_awal']);
                        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['KPPenggajianpegT']['tgl_akhir']);
                    }
                    $caraPrint=$_REQUEST['caraPrint'];
//                    $periode = $this->parserTanggal($model->tgl_awal).' s/d '.$this->parserTanggal($model->tgl_akhir);
                    $periode = 'asdasdasd';
                    $judulLaporan='Laporan Penggajian';
                    if($caraPrint=='PRINT') {
                        $this->layout='//layouts/printWindows';
                        $this->render('penggajianpegT/Print',array('model'=>$model,'periode'=>$periode,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
                    }
                    else if($caraPrint=='EXCEL') {
                        $this->layout='//layouts/printExcel';
                        $this->render('penggajianpegT/Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint,'periode'=>$periode));
                    }
                    else if($_REQUEST['caraPrint']=='PDF') {
                        $ukuranKertasPDF = Yii::app()->session['ukuran_kertas'];                  // Ukuran Kertas Pdf
                        $posisi = Yii::app()->session['posisi_kertas'];                                      // Posisi L->Landscape,P->Portait
                        $mpdf = new MyPDF('',$ukuranKertasPDF); 
                        $mpdf->useOddEven = 2;  
                        $mpdf->WriteHTML($stylesheet,1);
                        $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                        $mpdf->WriteHTML($this->renderPartial('penggajianpegT/Print',array('model'=>$model, 'periode'=>$periode,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
                        $mpdf->Output();
                    }                    
                }

//        protected function parserTanggal($tglpresensi){
//                    return Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($tgl, 'yyyy-MM-dd hh:mm:ss'));
//
//                }
                
                protected function parserTanggal($tgl){
                    $tgl = explode(' ', $tgl);
                    $result = array();
                    foreach ($tgl as $row){
                        if (!empty($row)){
                            $result[] = $row;
                        }
                    }
                    return Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($result[0], 'yyyy-MM-dd'),'medium',null).' '.$result[1];

                }
				
		public function actionGetRuanganForCheckBox($encode=false,$namaModel='')
		{
			if(Yii::app()->request->isAjaxRequest) {
			   $instalasi_id = $_POST["$namaModel"]['instalasi_id'];
			   if($encode){
					echo CJSON::encode($ruangan);
			   } else {
					if(empty($instalasi_id)){
						$ruangan = RuanganM::model()->findAll('instalasi_id=9999');
					} else {
						$ruangan = RuanganM::model()->findAll('instalasi_id='.$instalasi_id.'');
					}
					$ruangan = CHtml::listData($ruangan,'ruangan_id','ruangan_nama');
					echo CHtml::hiddenField(''.$namaModel.'[ruangan_id]');
					$i = 0;
					if (count($ruangan) > 0){
						  echo "<div>".CHtml::checkBox('checkAllRuangan',true, array('onkeypress'=>"return $(this).focusNextInputField(event)",
									'class'=>'checkbox-column','onclick'=>'checkAll()','checked'=>'checked'))."Pilih Semua";
						  echo "</div><br>";
						foreach($ruangan as $value=>$name) {

	//                        echo '<label class="checkbox">';
	//                        echo CHtml::checkBox(''.$namaModel."[ruangan_id][]", true, array('value'=>$value));
	//                        echo '<label for="'.$namaModel.'_ruangan_id_'.$i.'">'.$name.'</label>';
	//                        echo '</label>';
							$selects[] = $value;
							$i++;
						}
						echo CHtml::checkBoxList(''.$namaModel."[ruangan_id]", $selects, $ruangan);
					}
					else{
						echo '<label>Data Tidak Ditemukan</label>';
					}
			   }
			}
			Yii::app()->end();
		}

    }
?>