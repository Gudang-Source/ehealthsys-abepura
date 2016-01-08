<?php
class InformasiFakturFarmasiController extends MyAuthController
{
	public $path_view = 'keuangan.views.informasiFakturFarmasi.';
	protected $successSave = true;
	protected $pesan = "succes"; 
	
	public function actionIndex()
	{
		$model = new KUInformasifakturpembelianV('searchInformasi');
		$format = new MyFormatter();
		$model->tgl_awal=date('Y-m-d');
		$model->tgl_akhir=date('Y-m-d');

		if(isset($_GET['KUInformasifakturpembelianV'])){
			$model->attributes=$_GET['KUInformasifakturpembelianV'];
			$model->tgl_awal = $format->formatDateTimeForDb($_GET['KUInformasifakturpembelianV']['tgl_awal']);
			$model->tgl_akhir = $format->formatDateTimeForDb($_GET['KUInformasifakturpembelianV']['tgl_akhir']);
			if($_GET['berdasarkanJatuhTempo'] > 0){
				$model->tgl_awalJatuhTempo = $format->formatDateTimeForDb($_GET['KUInformasifakturpembelianV']['tgl_awalJatuhTempo']);
				$model->tgl_akhirJatuhTempo = $format->formatDateTimeForDb($_GET['KUInformasifakturpembelianV']['tgl_akhirJatuhTempo']);
			} else {
				$model->tgl_awalJatuhTempo = null;
				$model->tgl_akhirJatuhTempo = null;
			}
		}

		$this->render($this->path_view.'index',array('model'=>$model));
	}
	
	
	public function actionDetailsFaktur($idFakturPembelian)
	{
		$this->layout='//layouts/iframe';
		$modFakturPembelian = KUFakturpembelianT::model()->findByPk($idFakturPembelian);
		$modFakturPembelianDetails = KUFakturdetailT::model()->findAll('fakturpembelian_id='.$idFakturPembelian.'');

		$this->render('detailsFaktur',array('modFakturPembelian'=>$modFakturPembelian,
											'modFakturPembelianDetails'=>$modFakturPembelianDetails));

	}
	
	public function actionPrint($fakturpembelian_id = null)
	{
		 $judulFaktur = '----- PEMBAYARAN KLAIM / PIUTANG -----';
		 $format = new MyFormatter();
		 $modPembayaranKlaim = BKPembayaranklaimT::model()->findByPk($pembayarklaim_id);
		 $modPembayaranKlaimDetail = BKPembayarklaimdetailT::model()->findAllByAttributes(array('pembayarklaim_id'=>$pembayarklaim_id));

		 if(!empty($modPembayaranKlaimDetail->pendaftaran_id)){
			 $modPendaftaran = PendaftaranT::model()->findByPk($modPembayaranKlaimDetail->pendaftaran_id);
			 $modPendaftaran->tgl_pendaftaran = $format->formatDateTimeForDb($modPembayaranKlaimDetail->pendaftaran->tgl_pendaftaran);
		 }else{
			 $modPendaftaran = new PendaftaranT;
		 }

		 $caraPrint=$_REQUEST['caraPrint'];
		 if($caraPrint=='PRINT') {
			$this->layout='//layouts/printWindows';
			$this->render($this->path_view.'print', array( 
					'modPendaftaran'=>$modPendaftaran, 
					'judulKuitansi'=>$judulKuitansi, 
					'caraPrint'=>$caraPrint, 
					'modPembayaranKlaim'=>$modPembayaranKlaim,
					'modPembayaranKlaimDetail'=>$modPembayaranKlaimDetail));
		 }
		 else if($caraPrint=='EXCEL') {
			$this->layout='//layouts/printExcel';
			$this->render($this->path_view.'print',array( 
					'modPendaftaran'=>$modPendaftaran, 
					'judulKuitansi'=>$judulKuitansi, 
					'caraPrint'=>$caraPrint, 
					'modPembayaranKlaim'=>$modPembayaranKlaim,
					'modPembayaranKlaimDetail'=>$modPembayaranKlaimDetail));
		 }
		 else if($_REQUEST['caraPrint']=='PDF') {
 //			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
 //            $ukuranKertasPDF = 'KW';                  //Ukuran Kertas Pdf
			 $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
			 //$mpdf = new MyPDF('',$ukuranKertasPDF); 
			 //$mpdf = new MyPDF('','B5-L');
			 $mpdf = new MyPDF('','','15', '', 15, 15, 16, 16, 9, 9, 'B5');                
			 $mpdf->useOddEven = 2;  
			 $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			 $mpdf->WriteHTML($stylesheet,1); 
			 /*
			  * cara ambil margin
			  * tinggi_header * 72 / (72/25.4)
			  *  tinggi_header = inchi
			  */

			 /*font-family: tahoma;*/
			 // $header = 0.50 * 72 / (72/25.4);
			 $header = 0.3 * 72 / (72/25.4);
			 $mpdf->AddPage($posisi,'','','','',3,8,$header,5,0,0);
			 $mpdf->WriteHTML(
				 $this->renderPartial(
					 $this->path_view.'print',
					 array(
						 'modPendaftaran'=>$modPendaftaran, 
						 'judulKuitansi'=>$judulKuitansi, 
						 'caraPrint'=>$caraPrint, 
						 'modPembayaranKlaim'=>$modPembayaranKlaim,
						 'modPembayaranKlaimDetail'=>$modPembayaranKlaimDetail
					 ),true
				 )
			 );
			 $mpdf->Output();
		 }                       
	}
	   
	public function actionRetur($idFakturPembelian)
	{
		$this->layout='//layouts/frameDialog';
		$modFaktur = BKFakturPembelianT::model()->findByPk($idFakturPembelian);
		$modFakturDetail = BKFakturDetailT::model()->findAll('fakturpembelian_id='.$idFakturPembelian.'');
		$modRetur = new BKReturPembelianT;
		$modRetur->fakturpembelian_id=$modFaktur->fakturpembelian_id;
		$modRetur->noretur=  Generator::noRetur();
		$modRetur->totalretur=0;
		$modRetur->tglretur=date('Y-m-d H:i:s');
		$modRetur->supplier_id=$modFaktur->supplier_id;
		$modRetur->create_loginpemakai_id = Yii::app()->user->id;
		$modRetur->update_loginpemakai_id = Yii::app()->user->id;
		$modRetur->create_ruangan = Yii::app()->user->getState('ruangan_id');
		$modRetur->create_time = date('Y-m-d H:i:s');
		$modRetur->update_time = date('Y-m-d H:i:s');
		$modRetur->ruangan_id = Yii::app()->user->getState('ruangan_id');
		$modReturDetails = new BKReturDetailT;
		$tersimpan=false;
		$modRetur->is_posting = 'retur';

		if(isset($_POST['BKReturPembelianT'])){
			$modRetur->attributes = $_POST['BKReturPembelianT'];
			$modRetur->penerimaanbarang_id = $modFaktur->penerimaanbarang_id;

		$transaction = Yii::app()->db->beginTransaction();
		try {     
			$jumlahCekList=0;
			$jumlahSave=0;
			$modRetur = new BKReturPembelianT;

			$modRetur->attributes=$_POST['BKReturPembelianT'];
			$modRetur->ruangan_id=Yii::app()->user->getState('ruangan_id');
			$modRetur->penerimaanbarang_id = $modFaktur->penerimaanbarang_id;
			$modRetur->create_loginpemakai_id = Yii::app()->user->id;
			$modRetur->update_loginpemakai_id = Yii::app()->user->id;
			$modRetur->create_ruangan = Yii::app()->user->getState('ruangan_id');
			$modRetur->create_time = date('Y-m-d H:i:s');
			$modRetur->update_time = date('Y-m-d H:i:s');

			if($modRetur->save()){

			$modJurnalRekening = $this->saveJurnalRekening($modRetur, $_POST['BKReturPembelianT']);
			if($_POST['BKReturPembelianT']['is_posting']=='posting')
			{
				$modJurnalPosting = $this->saveJurnalPosting($modJurnalRekening);
			}else{
				$modJurnalPosting = null;
			}

			$noUrut = 0;
			foreach($_POST['RekeningakuntansiV'] AS $i => $post){
				$modJurnalDetail = $this->saveJurnalDetail($modJurnalRekening, $post, $noUrut, $modJurnalPosting);
				$noUrut ++;
			}


			$jumlahObat=COUNT($_POST['BKReturDetailT']['obatalkes_id']);
				for($i=0; $i<=$jumlahObat; $i++){

					// echo"<pre>";
					// print_r($_POST['checkList']);
				   // echo $i; 

				   if($_POST['checkList'][$i]=='1'){
						$jumlahCekList++;
						$modReturDetails = new BKReturDetailT;
						$modReturDetails->penerimaandetail_id=$_POST['BKReturDetailT']['penerimaandetail_id'][$i];
						$modReturDetails->obatalkes_id=$_POST['BKReturDetailT']['obatalkes_id'][$i];
						$modReturDetails->satuanbesar_id=$_POST['BKReturDetailT']['satuanbesar_id'][$i];
						$modReturDetails->fakturdetail_id=$_POST['BKReturDetailT']['fakturdetail_id'][$i];
						$modReturDetails->sumberdana_id=$_POST['BKReturDetailT']['sumberdana_id'][$i];
						$modReturDetails->returpembelian_id=$modRetur->returpembelian_id;
						$modReturDetails->satuankecil_id=$_POST['BKReturDetailT']['satuankecil_id'][$i];
						$modReturDetails->jmlretur=$_POST['BKReturDetailT']['jmlretur'][$i];                       
						$modReturDetails->harganettoretur=$_POST['BKReturDetailT']['harganettoretur'][$i];
						$modReturDetails->hargappnretur=$_POST['BKReturDetailT']['hargappnretur'][$i];
						$modReturDetails->hargapphretur=$_POST['BKReturDetailT']['hargapphretur'][$i];
						$modReturDetails->jmldiscount=$_POST['BKReturDetailT']['jmldiscount'][$i];
						$modReturDetails->hargasatuanretur=$_POST['BKReturDetailT']['hargasatuanretur'][$i];

						//ini digunakan untuk mendapatkan jumalah terima dari tabel faktur detail
						$fd = FakturdetailT::model()->findByPk($modReturDetails->fakturdetail_id);
						$idfd = $fd->fakturdetail_id;
						$jum1 = $fd->jmlterima;
						$jum2 = $modReturDetails->jmlretur;
						$jumupdate = $jum1-$jum2;

						if($modReturDetails->save()){
							$jumlahSave++;
							PenerimaandetailT::model()->updateByPk($modReturDetails->penerimaandetail_id,
																	array('returdetail_id'=>$modReturDetails->returdetail_id));

							//ini digunakan untuk mengupdata tabel faktur detail dan penerimaan detail ketika terjadi retur
							FakturdetailT::model()->updateByPk($idfd, array('jmlterima'=>$jumupdate));
							PenerimaandetailT::model()->updateByPk($modReturDetails->penerimaandetail_id, array('jmlterima'=>$jumupdate));
							//========================================================

							$idStokObatAlkes=PenerimaandetailT::model()->findByPk($modReturDetails->penerimaandetail_id)->stokobatalkes_id;

							$stokObatAlkesIN=StokobatalkesT::model()->findByPk($idStokObatAlkes)->qtystok_in;
							$stokCurrent=StokobatalkesT::model()->findByPk($idStokObatAlkes)->qtystok_current;

							$stokINBaru=$stokObatAlkesIN - $modReturDetails->jmlretur;
							$stokCurrentBaru=$stokCurrent - $modReturDetails->jmlretur;
							StokobatalkesT::model()->updateByPk($idStokObatAlkes,array('qtystok_in'=>$stokINBaru,
																						 'qtystok_current'=>$stokCurrentBaru));
						}

					}
				}//endfor

			 }

			 if(($jumlahCekList==$jumlahSave) and ($jumlahCekList>0)){
				 $transaction->commit();
					Yii::app()->user->setFlash('success',"Data Berhasil Disimpan ");
					$tersimpan=true;

			 }else{
					Yii::app()->user->setFlash('error',"Data gagal disimpan ");
					$transaction->rollback();
			 }
		 }catch(Exception $exc){
					$transaction->rollback();
					Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
				}   

		}

		$this->render($this->path_view.'retur',array('modFaktur'=>$modFaktur,
						'modFakturDetail'=>$modFakturDetail,
						'modRetur'=>$modRetur,
						'modReturDetails'=>$modReturDetails,
						'tersimpan'=>$tersimpan
					));
	}

    protected function saveJurnalRekening($modRetur, $postPenUmum)
    {
        $modJurnalRekening = new JurnalrekeningT;
        $modJurnalRekening->tglbuktijurnal = $modRetur->tglretur;
        $modJurnalRekening->nobuktijurnal = Generator::noBuktiJurnalRek();
        $modJurnalRekening->kodejurnal = Generator::kodeJurnalRek();
        $modJurnalRekening->noreferensi = 0;
        $modJurnalRekening->tglreferensi = $modRetur->tglretur;
        $modJurnalRekening->nobku = "";
        $modJurnalRekening->urianjurnal = "Retur ".$postPenUmum['noretur'];
        
        $modJurnalRekening->jenisjurnal_id = Params::JURNAL_PENGELUARAN_KAS;
        $periodeID = Yii::app()->session['periodeID'];
        $modJurnalRekening->rekperiod_id = $periodeID[0];
        $modJurnalRekening->create_time = $modRetur->tglretur;
        $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
        $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');

        if($modJurnalRekening->validate()){
            $modJurnalRekening->save();
            $this->successSave = true;
        } else {
            $this->successSave = false;
            $this->pesan = $modJurnalRekening->getErrors();
        }

        return $modJurnalRekening;
    }

    public function saveJurnalDetail($modJurnalRekening, $post, $noUrut=0, $modJurnalPosting){
        $modJurnalDetail = new JurnaldetailT();
        $modJurnalDetail->jurnalposting_id = ($modJurnalPosting == null ? null : $modJurnalPosting->jurnalposting_id);
        $modJurnalDetail->rekperiod_id = $modJurnalRekening->rekperiod_id;
        $modJurnalDetail->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
        $modJurnalDetail->uraiantransaksi = $modJurnalRekening->urianjurnal;
        $modJurnalDetail->saldodebit = $post['saldodebit'];
        $modJurnalDetail->saldokredit = $post['saldokredit'];
        $modJurnalDetail->nourut = $noUrut;
        $modJurnalDetail->rekening1_id = $post['struktur_id'];
        $modJurnalDetail->rekening2_id = $post['kelompok_id'];
        $modJurnalDetail->rekening3_id = $post['jenis_id'];
        $modJurnalDetail->rekening4_id = $post['obyek_id'];
        $modJurnalDetail->rekening5_id = $post['rincianobyek_id'];
        $modJurnalDetail->catatan = "";

        if($modJurnalDetail->validate()){
            $modJurnalDetail->save();
        }
        return $modJurnalDetail;        
    }

    protected function saveJurnalPosting($arrJurnalPosting)
    {
        $modJurnalPosting = new JurnalpostingT;
        $modJurnalPosting->tgljurnalpost = date('Y-m-d H:i:s');
        $modJurnalPosting->keterangan = "Posting automatis";
        $modJurnalPosting->create_time = date('Y-m-d H:i:s');
        $modJurnalPosting->create_loginpemekai_id = Yii::app()->user->id;
        $modJurnalPosting->create_ruangan = Yii::app()->user->getState('ruangan_id');
        if($modJurnalPosting->validate()){
            $modJurnalPosting->save();
            $this->successSave = true;
        } else {
            $this->successSave = false;
            $this->pesan = $modJurnalPosting->getErrors();
        }
        return $modJurnalPosting;
    }     
}
?>
