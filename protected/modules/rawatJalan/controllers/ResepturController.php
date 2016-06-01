<?php
class ResepturController extends MyAuthController
{
    public $layout='//layouts/iframe';
    public $path_view = 'rawatJalan.views.reseptur.';
    public $successSave = false;
    public $reseptur_id;
    
    public function actionIndex($pendaftaran_id)
	{
			$ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
            $modPendaftaran=RJPendaftaranT::model()->findByPk($pendaftaran_id);
            
            $konsul = ($modPendaftaran->ruangan_id == Yii::app()->user->getState('ruangan_id'))?null:KonsulpoliT::model()->findByAttributes(array(
                'pendaftaran_id'=>$modPendaftaran->pendaftaran_id,
                'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),
            ), array(
                'order'=>'tglkonsulpoli desc',
            ));
            
            if (!empty($konsul)) {
                $modPendaftaran->pegawai_id = $konsul->pegawai_id;
            }
            
            
            $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
            $modObatAlkesPasien =array();
            $modResepturDetail =array();
            $instalasi_id = Yii::app()->user->getState('instalasi_id');
            $modReseptur = new RJResepturT;
			$modReseptur->noresep = MyGenerator::noResepReseptur();
			
            $modReseptur->pegawai_id = $modPendaftaran->pegawai_id;
            //$modReseptur->ruangan_id = Params::RUANGAN_ID_APOTEK_1;
            $modReseptur->ruanganreseptur_id = $ruangan_id;
            $modReseptur->ruangan_id = 60; // Apotek Rawat Jalan
			
			if(isset($_GET['reseptur_id'])){
				$modReseptur = RJResepturT::model()->findByPk($_GET['reseptur_id']);
				$modObatAlkesPasien = RJObatalkesPasienT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
				$modResepturDetail = RJResepturDetailT::model()->findAllByAttributes(array('reseptur_id'=>$_GET['reseptur_id']));
			}
			
			if(isset($_POST['RJResepturT'])){
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $this->saveReseptur($_POST, $modPendaftaran);
				
                    $this->broadcastNotifReseptur($modPendaftaran);
                    
                    // die;
                    
                    if($this->successSave){
                        $transaction->commit();
                        Yii::app()->user->setFlash('success',"Data Resep berhasil disimpan");
//                        $this->redirect(array('index', 'status'=>1, 'pendaftaran_id'=>$pendaftaran_id, 'smspasien'=>$smspasien));
						$this->redirect(array('index','pendaftaran_id'=>$pendaftaran_id,'reseptur_id'=>$this->reseptur_id, 'sukses'=>1));
                    } else { 
                        $transaction->rollback();
                        $this->redirect(array('index', 'status'=>2, 'pendaftaran_id'=>$pendaftaran_id));
                        Yii::app()->user->setFlash('error',"Data gagal disimpan ");
                    }
                } catch (Exception $exc) {
                    $transaction->rollback();
                    $this->redirect(array('index', 'status'=>2, 'pendaftaran_id'=>$pendaftaran_id));
                    Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
                }
            }
			
			
			$modObatAlkesPasien = RJObatalkesPasienT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
			$modRiwayatResep = RJResepturT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'ruanganreseptur_id'=>$ruangan_id),array('order'=>'t.create_time DESC'));
            $this->render($this->path_view.'index',array('modPendaftaran'=>$modPendaftaran,
                                        'modPasien'=>$modPasien,
                                        'modReseptur'=>$modReseptur,
										'modRiwayatResep'=>$modRiwayatResep,
										'modObatAlkesPasien'=>$modObatAlkesPasien,
										'modResepturDetail'=>$modResepturDetail,
                                        ));
	}
	
        protected function broadcastNotifReseptur($modPendaftaran) {
            $reseptur = ResepturT::model()->findByPk($this->reseptur_id);
            
            //var_dump($modPendaftaran->attributes); 
            //var_dump($reseptur->attributes); 
            
            $rr = RuanganM::model()->findByPk($reseptur->ruanganreseptur_id);
            $dokter = PegawaiM::model()->findByPk($reseptur->pegawai_id);
            $pasien = PasienM::model()->findByPk($reseptur->pasien_id);
            
            //var_dump($rr->attributes);
            
            $judul = "Reseptur Pasien";
            $isi = $reseptur->noresep." - ".$rr->ruangan_nama." - ".$dokter->namaLengkap." - ".
                    $pasien->no_rekam_medik." - ".$pasien->namadepan.$pasien->nama_pasien;
            
            //var_dump($isi);
            
            $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                array('instalasi_id'=>Params::INSTALASI_ID_FARMASI, 'ruangan_id'=>$reseptur->ruangan_id, 'modul_id'=>10),
            ));     
        }
        
	protected function saveReseptur($post,$modPendaftaran)
	{
		$reseptur = new RJResepturT;
		$reseptur->pendaftaran_id = $modPendaftaran->pendaftaran_id;
		$reseptur->tglreseptur = $post['RJResepturT']['tglreseptur'];
		$instalasi_id = Yii::app()->user->getState('instalasi_id');
		$reseptur->noresep = MyGenerator::noResepReseptur();
		$reseptur->pegawai_id = $post['RJResepturT']['pegawai_id'];
		$reseptur->ruangan_id = $post['RJResepturT']['ruangan_id'];
		$reseptur->ruanganreseptur_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
		$reseptur->pasien_id = $modPendaftaran->pasien_id;
		
		if($reseptur->validate()){
			$reseptur->save();
 			$dat = PasienpulangT::model()->findByAttributes(array(
                            // 'carakeluar_id'=>Params::CARAKELUAR_ID_RAWATINAP,
                            'pendaftaran_id'=>$modPendaftaran->pendaftaran_id,
                        ));
                        if (empty($dat)) $updateStatusPeriksa=PendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id,array('statusperiksa'=>Params::STATUSPERIKSA_SUDAH_DIPERIKSA, 'tglselesaiperiksa'=>date('Y-m-d H:i:s')));
			
			/* ================================================ */
			/* Proses update status periksa KonsulPoli EHS-179  */
			/* ================================================ */
			$konsulPoli = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id, 'ruangan_id'=>isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id')));
			
			if(count($konsulPoli)>0){
				$updateStatusPeriksa=KonsulpoliT::model()->updateByPk($konsulPoli->konsulpoli_id,array('statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA));
			}
			/* ================================================ */
			
//			PendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id,
//				array(
//					'pembayaranpelayanan_id'=>null
//				)
//			);
			
			$modReseptur = $this->saveDetailReseptur($post, $reseptur);
			

		} else {
			$this->successSave = false;
		}
	}

	protected function saveDetailReseptur($post,$reseptur)
	{
		$valid = true;
		foreach($post['RJResepturDetailT'] as $i => $detailreseptur){
			$detail = new RJResepturDetailT;
			$detail->reseptur_id = $reseptur->reseptur_id;
			$detail->attributes = $detailreseptur;
			$detail->signa_reseptur = $detailreseptur['signa_reseptur'];
			$detail->iter = $detailreseptur['iter'];
			$detail->satuansediaan = $detailreseptur['satuansediaan'];
			$this->reseptur_id = $reseptur->reseptur_id;
			$valid = $detail->validate() && $valid;
			if($valid){
				$detail->save();
			}
		}
		
		$this->successSave = ($valid) ? true : false;
		
	}
	
	
	
	public function actionAutocompleteObatReseptur()
    {
            if(Yii::app()->request->isAjaxRequest)
            {
                $term = explode(';',$_GET['term']);
				$ruangan_id = $_GET['ruangantujuan_id'];
                $obatalkes_nama = isset($term[0])?$term[0]:'';
                $hargajual = isset($term[1])?$term[1]:'';
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(obatalkes_nama)', strtolower($obatalkes_nama), true);
                if($hargajual!=''){
                    $criteria->addCondition('hargajual ='.$hargajual,'or');
                }
                $criteria->addCondition('obatalkes_farmasi = TRUE');
                $criteria->addCondition('obatalkes_aktif = true');
                $criteria->order = 'obatalkes_nama';
                $criteria->limit = 5;
                $models = ObatalkesM::model()->with('sumberdana','satuankecil')->findAll($criteria);
                $persenjual = $this->persenJualRuangan();
                $format = new MyFormatter();
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $qtyStok = StokobatalkesT::getJumlahStok($model->obatalkes_id, $ruangan_id);
                    $returnVal[$i]['label'] = $model->obatalkes_kode." - ".$model->obatalkes_nama." - Jumlah Stok ".$qtyStok;
                    $returnVal[$i]['value'] = $model->obatalkes_nama;
                    $returnVal[$i]['obatalkes_id'] = $model->obatalkes_id;
                    $returnVal[$i]['sumberdana_nama'] = $model->sumberdana->sumberdana_nama;
                    $returnVal[$i]['qtyStok'] = $qtyStok;
                    $returnVal[$i]['hargajual'] = floor(($persenjual + 100 ) / 100 * $model->hargajual);
                    $returnVal[$i]['satuankecil'] = $model->satuankecil->satuankecil_nama;
                    $returnVal[$i]['idsatuankecil'] = $model->satuankecil_id;
                    $returnVal[$i]['diskonJual'] = empty($model->diskonJual) ? 0 : $model->diskonJual;
                    $returnVal[$i]['kadaluarsa'] = ((strtotime($format->formatDateTimeForDb($model->tglkadaluarsa)) - strtotime(date('Y-m-d'))) > 0) ? 0 : 1 ;
                }
                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
    }
	
	protected function persenJualRuangan()
    {
        switch(Yii::app()->user->getState('instalasi_id')){
            case Params::INSTALASI_ID_RI : $persen = Yii::app()->user->getState('ri_persjual');
                                            break;
            case Params::INSTALASI_ID_RJ : $persen = Yii::app()->user->getState('rj_persjual');
                                            break;
            case Params::INSTALASI_ID_RD : $persen = Yii::app()->user->getState('rd_persjual');
                                            break;
            default : $persen = 0; break;
        }

        return $persen;
    }
	
	public function actionSetFormObatAlkesPasien()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $obatalkes_id = $_POST['obatalkes_id'];
            $jumlah = $_POST['jumlah'];
			$isRacikan = $_POST['isRacikan'];
			$ruangan_id = $_POST['ruangan_id'];
			$therapiobat_id = isset($_POST['therapiobat_id'])?$_POST['therapiobat_id']:null;
            $form = "";
            $pesan = "";
            $format = new MyFormatter();
            $modResepturDetail = new RJResepturDetailT;
			$jmlStok = StokobatalkesT::getJumlahStok($obatalkes_id, $ruangan_id);
			
			$modObatAlkes = RJObatAlkesM::model()->findByPk($obatalkes_id);
            //if($jmlStok > 0){
                $modResepturDetail->obatalkes_id = $modObatAlkes->obatalkes_id;
                $modResepturDetail->sumberdana_id = $modObatAlkes->sumberdana_id;
                $modResepturDetail->satuankecil_id = $modObatAlkes->satuankecil_id;
				$modResepturDetail->racikan_id = ($isRacikan == 0) ? Params::RACIKAN_ID_NONRACIKAN : Params::RACIKAN_ID_RACIKAN;
                $modResepturDetail->r = 'R/';
                $modResepturDetail->qty_reseptur = ceil($jumlah); // LNG Ceil (Pembulatan keatas request pak tito)
		$modResepturDetail->jmlstok = $jmlStok;
                $modResepturDetail->kekuatan_reseptur = $modObatAlkes->kekuatan;
                $modResepturDetail->satuankekuatan = $modObatAlkes->satuankekuatan;
                
                $modResepturDetail->hargasatuan_reseptur = $modObatAlkes->hargajual;
                $modResepturDetail->harganetto_reseptur = $modObatAlkes->harganetto;
                $modResepturDetail->hargajual_reseptur = $modObatAlkes->hargajual * $modResepturDetail->qty_reseptur;
                $modResepturDetail->therapiobat_id = $therapiobat_id;
                
//                $modResepturDetail->permintaan_reseptur = $post['jmlpermintaan'][$i];
//                $modResepturDetail->jmlkemasan_reseptur = $post['jmlkemasan'][$i];
				
				$form .= $this->renderPartial($this->path_view.'_rowDetail', array('modResepturDetail'=>$modResepturDetail), true);
				
            //}else{
            //    $pesan = "Stok tidak mencukupi!";
            //}
            
            echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan));
            Yii::app()->end(); 
        }
    }
	
	/**
	* method to get Therapi Obat
	* made for : LNG Projects
	* LNG-321
	*/
	public function actionAutoCompleteTherapiObat()
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			$term = $_GET['term'];
			$criteria = new CDbCriteria();
			$criteria->addCondition("therapiobat_nama ILIKE '%".$term."%'");
			$criteria->addCondition('therapiobat_aktif = true');          
			$models = RJTherapiobatM::model()->findAll($criteria);
			$returnVal = array();
			foreach($models as $i=>$model)
			{
				$attributes = $model->attributeNames();

				foreach($attributes as $j=>$attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->therapiobat_nama;
				$returnVal[$i]['value'] = $model->therapiobat_id;
			}
			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}
	
	public function actionSetTherapiobatid(){
		if(Yii::app()->request->isAjaxRequest) {
			$obatalkes_id = $_POST['obatalkes_id'];
			$modTherapi = RJTherapimapobatM::model()->findByAttributes(array('obatalkes_id'=>$obatalkes_id));
			if(count($modTherapi)>0){
				$data = $modTherapi->therapiobat_id;
			}else{
				$data = null;
			}
			echo CJSON::encode($data);
		}
		Yii::app()->end();
	}
	
	public function actionPrint($idReseptur = null)
        {
			$pendaftaran_id = $_GET['id'];
			$criteria=new CDbCriteria;
                        if (empty($idReseptur)) {
                            $criteria->addCondition("create_time=(select max(create_time) from reseptur_t)");
                        } else {
                            $criteria->compare('reseptur_id', $idReseptur);
                        }
			$maxtime = RJResepturT::model()->find($criteria);
			$modDetailResep = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id'=>$maxtime->reseptur_id));
			$modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
			$judulLaporan='Reseptur';
			$caraPrint=$_REQUEST['caraPrint'];
			If(isset($_GET['idReseptur'])){
				$modDetailResep = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id'=>$_GET['idReseptur']));
				if($caraPrint=='PRINT') {
					$this->layout='//layouts/printWindows';
					$this->render($this->path_view.'Print',array('modPendaftaran'=>$modPendaftaran,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint,'modDetailResep'=>$modDetailResep, 'modReseptur'=>$maxtime));
				}
			}else{
			if($caraPrint=='PRINT') {
				$this->layout='//layouts/printWindows';
				$this->render($this->path_view.'Print',array('modPendaftaran'=>$modPendaftaran,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint,"modDetailResep"=>$modDetailResep, 'modReseptur'=>$maxtime));
			}
		}
        }
		
	public function actionSetDropdownRke()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$data = '';
			$rmax = isset($_POST['rmax'])?$_POST['rmax']:null;
			if(!empty($rmax)){
				for ($i = $rmax+1; $i <= 20; $i++) {
					$data .=  CHtml::tag('option', array('value'=>$i),CHtml::encode($i),true);
				}
			}
			echo CJSON::encode($data);
		}
		Yii::app()->end();
	}
	
	public function actionAjaxDetailResep()
	{
		if(Yii::app()->request->isAjaxRequest) {
		$idReseptur = $_POST['idReseptur'];
		$pendaftaran_id = $_POST['pendaftaran_id'];
	$modPendaftaran=RJPendaftaranT::model()->findByPk($pendaftaran_id);
                $modReseptur = RJResepturT::model()->findByPk($idReseptur);
		$modDetailResep = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id'=>$idReseptur));

		$data['result'] = $this->renderPartial($this->path_view.'_viewDetailResep', array('modDetailResep'=>$modDetailResep,'modPendaftaran'=>$modPendaftaran, 'modReseptur'=>$modReseptur), true);

		echo json_encode($data);
		 Yii::app()->end();
		}
	}
	
	public function actionHapusRiwayatReseptur(){
		if(Yii::app()->request->isAjaxRequest) {
			$data['pesan'] = "";
			$data['sukses'] = 0;
			$transaction = Yii::app()->db->beginTransaction();
			try {
                            $detailResep = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id'=>$_POST['reseptur_id']));
                            $resep = ResepturT::model()->findByPk($_POST['reseptur_id']);
                            
                            if (!empty($resep->penjualanresep_id)) {
                                $data['pesan'] = "Reseptur ".$resep->noresep." sudah terjual.";
				$data['sukses'] = 0;
                                $transaction->rollback();
                                goto prints;
                            }
                            
                            $deleteDetailResep = ResepturdetailT::model()->deleteAllByAttributes(array('reseptur_id'=>$_POST['reseptur_id']));
                            if($deleteDetailResep){
                                    if($resep->delete()){
                                            $data['pesan'] = "Riwayat Resep Termasuk Detail Resep Berhasil Dihapus!";
                                            $data['sukses'] = 1;
                                            $transaction->commit();
                                    }else{
                                            $transaction->rollback();
                                            $data['pesan'] = "Gagal Menghapus Reseptur";
                                            $data['sukses'] = 0;
                                    }
                            }else{
                                    $transaction->rollback();
                                    $data['pesan'] = "Gagal Menghapus Detail Reseptur";
                                    $data['sukses'] = 0;
                            }
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['pesan'] = "Transaksi Gagal :".MyExceptionMessage::getMessage($exc,true);
			}
                        prints:
			echo CJSON::encode($data);
		}
		Yii::app()->end();
	}	
	
}