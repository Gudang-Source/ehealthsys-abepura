<?php

class DaftarPasienController extends MyAuthController
{
    public $defaultAction = 'pasienRJ';
	public $upTandabuktibayarT =false;
	public $delTandabuktibayarT	= false;
	public $delTindakansudahbayarT = false;
	public $delPembayaranpelayananT = false;
	
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionPasienRD()
	{
                $format = new MyFormatter();
                $modRD = new BKInformasikasirrdpulangV;
                $modRD->tgl_awal = date("Y-m-d");
                $modRD->tgl_akhir = date('Y-m-d');
                
                if(isset($_GET['BKInformasikasirrdpulangV'])){
                    $modRD->attributes = $_GET['BKInformasikasirrdpulangV'];
                    if(!empty($_GET['BKInformasikasirrdpulangV']['tgl_awal']))
                    {
                        $modRD->tgl_awal = $format->formatDateTimeForDb($_GET['BKInformasikasirrdpulangV']['tgl_awal']);
                    }
                    if(!empty($_GET['BKInformasikasirrdpulangV']['tgl_awal']))
                    {
                        $modRD->tgl_akhir = $format->formatDateTimeForDb($_GET['BKInformasikasirrdpulangV']['tgl_akhir']);
                    }

                }
                
		$this->render('pasienRD',array('modRD'=>$modRD,'format'=>$format));
	}

	public function actionPasienRI()
	{
                $format = new MyFormatter();
                $modRI = new BKInformasikasirinappulangV;
                $modRI->tgl_awal = date('Y-m-d');
                $modRI->tgl_akhir = date('Y-m-d');
                $modRI->tgl_awal_admisi = date('Y-m-d');
                $modRI->tgl_akhir_admisi = date('Y-m-d');
                
                if(isset($_GET['BKInformasikasirinappulangV'])){
                    $modRI->attributes = $_GET['BKInformasikasirinappulangV'];
                    if(!empty($_GET['BKInformasikasirinappulangV']['tgl_awal'])){
                        $modRI->tgl_awal = $format->formatDateTimeForDb($_GET['BKInformasikasirinappulangV']['tgl_awal']);
                    }
                    if(!empty($_GET['BKInformasikasirinappulangV']['tgl_akhir'])){
                        $modRI->tgl_akhir = $format->formatDateTimeForDb($_GET['BKInformasikasirinappulangV']['tgl_akhir']);
                    }
                    $modRI->ceklis = $_GET['BKInformasikasirinappulangV']['ceklis'];
                    if($modRI->ceklis==1){
                        $modRI->tgl_awal_admisi = $format->formatDateTimeForDb($_GET['BKInformasikasirinappulangV']['tgl_awal_admisi']);
                        $modRI->tgl_akhir_admisi = $format->formatDateTimeForDb($_GET['BKInformasikasirinappulangV']['tgl_akhir_admisi']);
                    }
                }
                if (Yii::app()->request->isAjaxRequest) {
                    echo $this->renderPartial('_tablePasienRI', array('modRI'=>$modRI,'format'=>$format),true);
                }else{
                    $this->render('pasienRI',array('modRI'=>$modRI,'format'=>$format));
                }
	}

	public function actionPasienRJ()
	{
                $format = new MyFormatter();
                $modRJ = new BKInformasikasirrawatjalanV;
                $modRJ->tgl_awal = date("Y-m-d");
                $modRJ->tgl_akhir = date('Y-m-d');
                
                if(isset($_GET['BKInformasikasirrawatjalanV'])){
                    $modRJ->attributes = $_GET['BKInformasikasirrawatjalanV'];
                    if(!empty($_GET['BKInformasikasirrawatjalanV']['tgl_awal']))
                    {
                        $modRJ->tgl_awal = $format->formatDateTimeForDb($_GET['BKInformasikasirrawatjalanV']['tgl_awal']);
                    }
                    if(!empty($_GET['BKInformasikasirrawatjalanV']['tgl_awal']))
                    {
                        $modRJ->tgl_akhir = $format->formatDateTimeForDb($_GET['BKInformasikasirrawatjalanV']['tgl_akhir']);
                    }
                }
                
		$this->render('pasienRJ',array('modRJ'=>$modRJ,'format'=>$format));
	}

	public function actionPasienKarcis()
	{
            $format = new MyFormatter();
            $model = new BKInfopasienkarcisV('searchPasienKarcis');
            $model->tgl_awal = date('Y-m-d');
            $model->tgl_akhir = date('Y-m-d');
            
            if(isset($_GET['BKInfopasienkarcisV'])){
                    $model->attributes = $_GET['BKInfopasienkarcisV'];
                    $model->no_pendaftaran = $_GET['BKInfopasienkarcisV']['no_pendaftaran'];
                    $model->no_rekam_medik = $_GET['BKInfopasienkarcisV']['no_rekam_medik'];
                    $model->nama_pasien = $_GET['BKInfopasienkarcisV']['nama_pasien'];
                    $model->nama_bin = $_GET['BKInfopasienkarcisV']['nama_bin'];
                    $model->statusperiksa = $_GET['BKInfopasienkarcisV']['statusperiksa'];
                    if(!empty($_GET['BKInfopasienkarcisV']['tgl_awal']))
                    {
                        $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKInfopasienkarcisV']['tgl_awal']);
                    }
                    if(!empty($_GET['BKInfopasienkarcisV']['tgl_awal']))
                    {
                        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKInfopasienkarcisV']['tgl_akhir']);
                    }
                }
            
            $this->render('pasienKarcis',array('model'=>$model,'format'=>$format));
	}

	// RND-9745
//	public function actionPasienDeposit()
//	{
//            $format = new MyFormatter();
//            $model = new BKBayaruangmukaT('searchPasienDeposit');
//            $model->tgl_awal = date('d M Y');
//            $model->tgl_akhir = date('d M Y');
//            if(isset($_GET['BKBayaruangmukaT'])){
//                    $model->attributes = $_GET['BKBayaruangmukaT'];
//                    $model->no_pendaftaran = $_GET['BKBayaruangmukaT']['no_pendaftaran'];
//                    $model->no_rekam_medik = $_GET['BKBayaruangmukaT']['no_rekam_medik'];
//                    $model->nama_pasien = $_GET['BKBayaruangmukaT']['nama_pasien'];
//                    $model->nama_bin = $_GET['BKBayaruangmukaT']['nama_bin'];
//                    if(!empty($_GET['BKBayaruangmukaT']['tgl_awal']))
//                    {
//                        $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKBayaruangmukaT']['tgl_awal']);
//                    }
//                    if(!empty($_GET['BKBayaruangmukaT']['tgl_awal']))
//                    {
//                        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKBayaruangmukaT']['tgl_akhir']);
//                    }
//                }
//            
//            $this->render('pasienDeposit',array('model'=>$model,'format'=>$format));
//	}

        /**
         * url to see all pasien that already pay
         * used in :
         * 1. Billing Kasir -> informasi pasien sudah bayar
         */
	public function actionPasienSudahBayar()
	{
                    $format = new MyFormatter();
                    $model = new BKInformasipasiensudahbayarV('searchInformasi');
                    
                    $model->tgl_awal = date('d M Y');
                    $model->tgl_akhir = date('d M Y');
                    $model->tgl_bkm_awal = date('d M Y');
                    $model->tgl_bkm_akhir= date('d M Y');
                    //$model->ceklis=false;
                    if(isset($_GET['BKInformasipasiensudahbayarV'])){
                            $model->attributes = $_GET['BKInformasipasiensudahbayarV'];
                            $model->ceklis = $_GET['BKInformasipasiensudahbayarV']['ceklis'];
                            if(!empty($_GET['BKInformasipasiensudahbayarV']['tgl_awal']))
                            {
                                $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKInformasipasiensudahbayarV']['tgl_awal']);
                            }
                            if(!empty($_GET['BKInformasipasiensudahbayarV']['tgl_akhir']))
                            {
                                $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKInformasipasiensudahbayarV']['tgl_akhir']);
                            }
                            
                             if(!empty($_GET['BKInformasipasiensudahbayarV']['tgl_bkm_awal']))
                            {
                
								 
								 
								 $model->tgl_bkm_awal = $format->formatDateTimeForDb($_GET['BKInformasipasiensudahbayarV']['tgl_bkm_awal']);
                            }
                            if(!empty($_GET['BKInformasipasiensudahbayarV']['tgl_bkm_akhir']))
                            {
                                $model->tgl_bkm_akhir = $format->formatDateTimeForDb($_GET['BKInformasipasiensudahbayarV']['tgl_bkm_akhir']);
                            }
                        }

                    $this->render('pasienSudahBayar',array('model'=>$model));
	}

	public function actionPasienBerhutang()
	{
                    $format = new MyFormatter();
                    $model = new BKPembayaranpelayananT('searchPasienBerhutang');
                    $model->tgl_awal = date('d M Y');
                    $model->tgl_akhir = date('d M Y');
                    if(isset($_GET['BKPembayaranpelayananT'])){
                            $model->attributes = $_GET['BKPembayaranpelayananT'];
                            $model->no_pendaftaran = $_GET['BKPembayaranpelayananT']['no_pendaftaran'];
                            $model->no_rekam_medik = $_GET['BKPembayaranpelayananT']['no_rekam_medik'];
                            $model->nama_pasien = $_GET['BKPembayaranpelayananT']['nama_pasien'];
                            $model->nama_bin = $_GET['BKPembayaranpelayananT']['nama_bin'];
                            if(!empty($_GET['BKPembayaranpelayananT']['tgl_awal']))
                            {
                                $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKPembayaranpelayananT']['tgl_awal']);
                            }
                            if(!empty($_GET['BKPembayaranpelayananT']['tgl_awal']))
                            {
                                $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKPembayaranpelayananT']['tgl_akhir']);
                            }
                        }

                    $this->render('pasienBerhutang',array('model'=>$model));
	}

        public function actioninformasiPenanggung($id)
        {
            $this->layout = '//layouts/iframe';
            $model = BKInformasikasirrawatjalanV::model()->findByAttributes(array('no_pendaftaran'=>$id));
            $modPenanggungJawab = PenanggungjawabM::model()->findByPk($model->penanggungjawab_id);
            $this->render('informasiPenanggung',
                array(
                    'model'=>$modPenanggungJawab
                )
            );
        }
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
        
//        public function actionDetailKasMasuk($idPembayaran)
//        {
//            $this->layout = '//layouts/iframe';
//            $model = new BKPembayaranpelayananT();
//            $model->pembayaranpelayanan_id = $idPembayaran;
//            $detail = $model->detailPembayaran();
//            $func = new CustomFunction;
//            
//            $no_bkm = '';
//            $tgl_bkm = '';
//            $pembayar = '';
//            $total_bayar = '';
//            $total_bayar_huruf = '';
//            
//            $rec = array();
//            foreach($detail as $key=>$val)
//            {
//                $data = null;
//                $data->tglpembayaran = date('d-m-Y', strtotime($val['tglpembayaran']));
//                $data->keterangan = $val['daftartindakan_nama'];
//                $data->jumlah = $val['qty_tindakan']*$val['tarif_tindakan'];
//                
//                $total_bayar += $data->jumlah;
//                $no_bkm = $val['nobuktibayar'];
//                $tgl_bkm = date('d-m-Y', strtotime($val['tglbuktibayar']));
//                $pembayar = $val['darinama_bkm'];
//                
//                $rec[] = $data;
//            }
//            
//            $data = array(
//                'header'=>array(
//                    'no_bkm'=>$no_bkm,
//                    'tgl_bkm'=>$tgl_bkm,
//                    'total_bayar'=>$total_bayar,
//                    'total_bayar_huruf'=>$func->terbilang($total_bayar),
//                    'pembayar'=>$pembayar,
//                ),
//                'detail'=>$rec,
//                'footer'=>123,
//            );
//            $action_url = Yii::app()->createAbsoluteUrl(
//                Yii::app()->controller->module->id .'/'. Yii::app()->controller->id .'/print' . Yii::app()->controller->action->id,
//                array(
//                    'idPembayaran'=>$idPembayaran
//                )
//            );
//            
//            $this->render('detailKasMasuk',
//                array(
//                    'data'=>$data,
//                    'actionUrl'=>$action_url,   
//                )
//            );
//        }
        
        /**
            * module billingKasir/DaftarPasien/PasienSudahBayar&modul_id=19
            * icon     : BKM
            * date     : 06-May-2014
            * issue    : EHS-1126
            * desc     : error tampilan BKM : solusi : disamakan dengan aplikasi di JK
            * action   : actionDetailKasMasuk($idPembayaran)
         */
        public function actionDetailKasMasuk($idPembayaran)
        {
            $this->layout = '//layouts/iframe';
            $format = new MyFormatter;
            $criteria = new CDbCriteria();
//            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
            $criteria->addCondition('pembayaranpelayanan_id = '.$idPembayaran);
            $criteria->addCondition('tindakansudahbayar_id IS NOT NULL'); //sudah lunas
            $criteria->order = 'ruangan_id';
            $detail = BKRinciantagihanpasiensudahbayarV::model()->findAll($criteria);
            $func = new CustomFunction;
            $caraPrint=null;
            
            $no_bkm = '';
            $tgl_bkm = '';
            $pembayar = '';
            $total_bayar = '';
            $total_bayar_huruf = '';
            
            $rec = array();
            foreach($detail as $key=>$val)
            {
                $data[] = null;
                $data['tglpembayaran'] = date('d-m-Y', strtotime($format->formatDateTimeForDb($val->getTandaBukti("tglbuktibayar"))));
                $data['keterangan'] = $val->daftartindakan_nama;
                $data['jumlah'] = $val->SubTotal;
                
                $total_bayar += $data['jumlah'];
                $no_bkm = $val->getTandaBukti("nobuktibayar");
                $tgl_bkm = $val->getTandaBukti("tglbuktibayar");
                $pembayar = $val->getTandaBukti("darinama_bkm");
                
                $rec[] = $data;
            }
            
            $data = array(
                'header'=>array(
                    'no_bkm'=>$no_bkm,
                    'tgl_bkm'=>$tgl_bkm,
                    'total_bayar'=>$format->formatUang($total_bayar, "Rp. "),
                    'total_bayar_huruf'=>$format->formatNumberTerbilang($total_bayar),
                    'pembayar'=>$pembayar,
                ),
                'detail'=>$rec,
                'footer'=>123,
            );
            $action_url = Yii::app()->createAbsoluteUrl(
                Yii::app()->controller->module->id .'/'. Yii::app()->controller->id .'/print' . Yii::app()->controller->action->id,
                array(
                    'idPembayaran'=>$idPembayaran
                )
            );
            
            $this->render('detailKasMasuk',
                array(
                    'format'=>$format,
                    'data'=>$data,
                    'actionUrl'=>$action_url,   
                    'caraPrint'=>$caraPrint
                )
            );
        }
        
        /**
            * module billingKasir/DaftarPasien/PasienSudahBayar&modul_id=19
            * icon     : BKM
            * date     : 06-May-2014
            * issue    : EHS-1126
            * desc     : error tampilan BKM : solusi : disamakan dengan aplikasi di JK
            * action   : actionPrintDetailKasMasuk($idPembayaran, $caraPrint)
         */
        public function actionPrintDetailKasMasuk($idPembayaran, $caraPrint)
        {
            if (!isset($caraPrint)){
                $caraPrint=null;
            }
            $format = new MyFormatter;
            $criteria = new CDbCriteria();
//            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
            $criteria->addCondition('pembayaranpelayanan_id = '.$idPembayaran);
            $criteria->addCondition('tindakansudahbayar_id IS NOT NULL'); //sudah lunas
            $criteria->order = 'ruangan_id';
            $detail = BKRinciantagihanpasiensudahbayarV::model()->findAll($criteria);
            $func = new CustomFunction;
            
            $no_bkm = '';
            $tgl_bkm = '';
            $pembayar = '';
            $total_bayar = 0;
            $total_bayar_huruf = '';
            
            $rec = array();
            foreach($detail as $key=>$val)
            {
                $data[] = null;
                $data['tglpembayaran'] = date('d-m-Y', strtotime($format->formatDateTimeForDb($val->getTandaBukti("tglbuktibayar"))));
                $data['keterangan'] = $val->daftartindakan_nama;
                $data['jumlah'] = $val->SubTotal;
                
                $total_bayar += $data['jumlah'];
                $no_bkm = $val->getTandaBukti("nobuktibayar");
                $tgl_bkm = $val->getTandaBukti("tglbuktibayar");
                $pembayar = $val->getTandaBukti("darinama_bkm");
                
                $rec[] = $data;
            }
            $data = array(
                'header'=>array(
                    'no_bkm'=>$no_bkm,
                    'tgl_bkm'=>$tgl_bkm,
                    'total_bayar'=>$format->formatUang($total_bayar, "Rp. "),
                    'total_bayar_huruf'=>$format->formatNumberTerbilang($total_bayar),
                    'pembayar'=>$pembayar,
                ),
                'detail'=>$rec,
                'footer'=>123,
            );
            if($caraPrint == 'PRINT')
            {
                $this->layout='//layouts/printWindows';
                $this->render('detailKasMasuk',
                    array(
                        'data'=>$data,
                        'caraPrint'=>$caraPrint,
                        'format'=>$format
                    )
                );
            }else{
                $this->layout = '//layouts/iframe';
                $ukuranKertasPDF = 'RBK';                  //Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
                $mpdf = new MyPDF('',$ukuranKertasPDF); 
                $mpdf->useOddEven = 2;  
//                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                $mpdf->WriteHTML($stylesheet,1);  
                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                $mpdf->WriteHTML($stylesheet, 1);  
                $mpdf->AddPage($posisi,'','','','',5,5,5,5);
                $mpdf->WriteHTML(
                    $this->render('detailKasMasuk',
                        array(
                            'format'=>$format,
                            'data'=>$data,
                            'caraPrint'=>$caraPrint
                        ),true
                    )
                );
                $mpdf->Output();                
            }
        }
		
		public function actionCekLoginBatalBayar($task='BatalBayar') 
		{
			if(Yii::app()->request->isAjaxRequest){
				$username = $_POST['username'];
				$password = $_POST['password'];
				$idRuangan = Yii::app()->user->getState('ruangan_id');

				$user = LoginpemakaiK::model()->findByAttributes(array('nama_pemakai' => $username,
																	   'loginpemakai_aktif' =>TRUE));
				if ($user === null) {
					$data['error'] = "Login Pemakai salah!";
					$data['cssError'] = 'username';
					$data['status'] = 'Gagal Login';
				} else {
					// cek password
					if ($user->katakunci_pemakai !== $user->encrypt($password)) {
						$data['error'] = 'password salah!';
						$data['cssError'] = 'password';
						$data['status'] = 'Gagal Login';
					} else {
						// cek ruangan
						$ruangan_user = RuanganpemakaiK::model()->findByAttributes(array('loginpemakai_id'=>$user->loginpemakai_id,
																						 'ruangan_id'=> $idRuangan));
						if($ruangan_user===null) {
							$data['error'] = 'ruangan salah!';
							$data['status'] = 'Gagal Login';
						} else {
							$data['error'] = '';
							$cek = $this->checkAccess(array('loginpemakai_id'=>$user->loginpemakai_id)); //dari MyAuthController
							if($cek){
								$data['status'] = 'success';
								$data['userid'] = $user->loginpemakai_id;
								$data['username'] = $user->nama_pemakai;
							} else {
								$data['status'] = 'Anda tidak memiliki hak melakukan proses ini!';
							}
						}
					}
				}

				echo json_encode($data);
				Yii::app()->end();
			}
		}
		
	public function actionBatalBayar()
  {

    if(Yii::app()->request->isAjaxRequest) {
	$returnVal['hasil'] = '';
	  $transaction = Yii::app()->db->beginTransaction();
		try {
			$tandabuktibayar_id = (isset($_POST['tandabuktibayar_id']) ? $_POST['tandabuktibayar_id'] : null);
			$pembayaranpelayanan_id = (isset($_POST['pembayaranpelayanan_id']) ? $_POST['pembayaranpelayanan_id'] : null);
				$modTandaBuktiBayar = TandabuktibayarT::model()->findByPk($tandabuktibayar_id);
			
				$criteria = new CDbCriteria;
				if(!empty($tandabuktibayar_id)){
					$criteria->addCondition('tandabuktibayar_id ='.$tandabuktibayar_id);
				}
				$modBayarAngsuranPelayananT = BayarangsuranpelayananT::model()->find($criteria);
			
				$barisBayar = isset($modBayarAngsuranPelayananT)? COUNT($modBayarAngsuranPelayananT) : null;
				$closing = (isset($modTandaBuktiBayar->closingkasir_id) ? $modTandaBuktiBayar->closingkasir_id : null);
				
				$criteriaPasaienAdmisi = new CDbCriteria;
				if(!empty($pembayaranpelayanan_id)){
					$criteriaPasaienAdmisi->addCondition('pembayaranpelayanan_id ='.$pembayaranpelayanan_id);
				}
				$modPasienAdmisi = PasienadmisiT::model()->find($criteriaPasaienAdmisi);
				$pasienadmisi_id = isset($modPasienAdmisi->pasienadmisi_id)?$modPasienAdmisi->pasienadmisi_id:null;

				$modPendaftaran = PendaftaranT::model()->findByAttributes(array('pembayaranpelayanan_id'=>$pembayaranpelayanan_id));

				$criteriaTindakanSudahBayar = new CDbCriteria;
				if(!empty($pembayaranpelayanan_id)){
					$criteriaTindakanSudahBayar->addCondition('pembayaranpelayanan_id ='.$pembayaranpelayanan_id);
				}
				$modTindakanSudahBayar = TindakansudahbayarT::model()->findAll($criteriaTindakanSudahBayar);

				
				$criteriaOasudahbayarT = new CDbCriteria;
				if(!empty($pembayaranpelayanan_id)){
					$criteriaOasudahbayarT->addCondition('pembayaranpelayanan_id ='.$pembayaranpelayanan_id);
				}
				$modOA = OasudahbayarT::model()->findAll($criteriaOasudahbayarT);
				
				if (!empty($closing)){
					$returnVal['hasil'] = 'Pembayarang ini sudah diclose !';
				} elseif ($barisBayar > 0){
					$returnVal['hasil'] = 'Pasien sudah melakukan angsuran !';
				}elseif(empty($closing) && $barisBayar==0){
					$updateTandabuktibayarT = TandabuktibayarT::model()->updateByPk($tandabuktibayar_id,array('pembayaranpelayanan_id'=>null	));
					$deleteTandabuktibayarT = TandabuktibayarT::model()->deleteByPk($tandabuktibayar_id);
				
					if($updateTandabuktibayarT){
						$this->upTandabuktibayarT = true;
					}
					if($deleteTandabuktibayarT){
						$this->delTandabuktibayarT = true;
					}
							
						if(count($modOA)>0){	
						  foreach ($modOA as $i => $modOASudahBayar) {
							$modObatalkespasien = ObatalkespasienT::model()->findByAttributes(array('oasudahbayar_id'=>$modOASudahBayar->oasudahbayar_id));
							$idObatalkespasien = $modObatalkespasien->obatalkespasien_id;
							ObatalkespasienT::model()->updateByPk($idObatalkespasien,array('oasudahbayar_id'=>null));
						  }
							$deleteOasudahbayarT = OasudahbayarT::model()->deleteAllByAttributes(array('pembayaranpelayanan_id'=>$pembayaranpelayanan_id));
						}else{
							$returnVal['hasil'] = 'Pasien belum bayar obat alkes !';
						}	
						
						if(count($modTindakanSudahBayar)>0){
						  foreach ($modTindakanSudahBayar as $j => $modTindakans) {
							$modTindakanpelayanan = TindakanpelayananT::model()->findByAttributes(array('tindakansudahbayar_id'=>$modTindakans->tindakansudahbayar_id));
							$idTindakanpelayanan = (isset($modTindakanpelayanan->tindakanpelayanan_id) ? $modTindakanpelayanan->tindakanpelayanan_id : null);
							$updateTindakanpelayananT = TindakanpelayananT::model()->updateByPk($idTindakanpelayanan,array('tindakansudahbayar_id'=>null, 'subsidiasuransi_tindakan'=>0, 'subsidipemerintah_tindakan'=>0, 'subsisidirumahsakit_tindakan'=>0, 'iurbiaya_tindakan'=>0));
						  } 
						}else{
							$returnVal['hasil'] = 'Pasien belum bayar tindakan pelayanan !';
						}	
						
					$deleteTindakansudahbayarT = TindakansudahbayarT::model()->deleteAllByAttributes(array('pembayaranpelayanan_id'=>$pembayaranpelayanan_id)); 
					if ($deleteTindakansudahbayarT){
					  $this->delTindakansudahbayarT = true;
					}
					
					$criteriaPemakaianuangmukaT = new CDbCriteria;
					if(!empty($pembayaranpelayanan_id)){
						$criteriaPemakaianuangmukaT->addCondition('pembayaranpelayanan_id ='.$pembayaranpelayanan_id);
					}
					$modPemakaianuangmukaT = PemakaianuangmukaT::model()->findAll($criteriaPemakaianuangmukaT);
					if(count($modPemakaianuangmukaT)>0){
						$deletePemakaianuangmukaT = PemakaianuangmukaT::model()->deleteAllByAttributes(array('pembayaranpelayanan_id'=>$modPemakaianuangmukaT->pembayaranpelayanan_id));
					}else{
						$returnVal['hasil'] = 'Pasien belum bayar uang muka !';
					}
					

					
					
					$criteriaPasienadmisiT = new CDbCriteria;
					if(!empty($pembayaranpelayanan_id)){
						$criteriaPasienadmisiT->addCondition('pembayaranpelayanan_id ='.$pembayaranpelayanan_id);
					}
					$modPasienadmisiT = PasienadmisiT::model()->findAll($criteriaPasienadmisiT);
					if(count($modPasienadmisiT)>0){
						$updatePasienadmisiT = PasienadmisiT::model()->updateByPk($pasienadmisi_id,array('pembayaranpelayanan_id'=>null));	
					}else{
						$returnVal['hasil'] = 'Pasien belum bayar pelayanan sebagai pasien admisi !';
					}
					
						if (count($modPendaftaran) > 0){
							if($modPendaftaran->instalasi_id == Params::INSTALASI_ID_RJ){ //khusus untuk RJ saja Status periksa = sedang periksa
								PendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id,array('pembayaranpelayanan_id'=>null, 'statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA));
							}else{
								PendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id,array('pembayaranpelayanan_id'=>null));
							}
						}
						
					$deletePembayaranpelayananT = PembayaranpelayananT::model()->deleteAllByAttributes(array('tandabuktibayar_id'=>$tandabuktibayar_id));
					if ($deletePembayaranpelayananT){
					  $this->delPembayaranpelayananT = true;
					}
				 }
				 
				if($this->upTandabuktibayarT && $this->delTandabuktibayarT && $this->delTindakansudahbayarT && $this->delPembayaranpelayananT){
                    $transaction->commit();
                    $returnVal['hasil'] = 'BERHASIL';
                }else{
                    $transaction->rollback();
					if(empty($returnVal['hasil'])){
						$returnVal['hasil'] = 'Gagal di batalkan !';
					}
                }
		} catch (Exception $exc) {
			$transaction->rollback();
			$returnVal['hasil'] = 'Gagal di batalkan !';
		}
	  
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
     
}