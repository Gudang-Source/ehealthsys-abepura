
<?php

class RealisasiLemburTController extends MyAuthController
{
        public $realisasilemburtersimpan = true; //looping
        public $rencanalemburtersimpan = true; //looping
        public $defaultAction = 'buat';
        
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	
        public function actionBuat($norencana=null,$norealisasi = null)
	{
            if(isset($_GET['frame'])){
                $this->layout = '//layouts/iframe';
            }
            
            $format = new MyFormatter;
            $modRealisasiLembur = new KPRealisasiLemburT();
            $modRealisasiLemburDetail = new RealisasilemburT();
            $modRencanaLembur = new KPRencanaLemburT();
            $modRealisasiLembur->tglrealisasi = date('Y-m-d');
            $modRealisasiLembur->norealisasi = MyGenerator::noRealisasiLembur();
            $modDetail = array();
			$modPegawai = new KPPegawaiM();
            $i = 0;
            $sukses = 0;
            $gagal = 0;
            
            if($norencana != null){
                $modRencanaLembur = KPRencanaLemburT::model()->findByAttributes(array('norencana'=>$norencana));
                $modRencanaLemburDetail = KPRencanaLemburT::model()->findAllByAttributes(array('norencana'=>$norencana, 'realisasilembur_id'=>null));
//				foreach ($modRencanaLemburDetail as $i => $detail){
//					echo "<pre>";
//					print_r($detail->attributes);
//				}
//					exit;
            }
            
            if($norealisasi != null){
				
                $modRealisasiLembur = KPRealisasiLemburT::model()->findByAttributes(array('norealisasi'=>$norealisasi));
                $modRencanaLembur->mengetahui_nama = isset($modRealisasiLembur->pegawaimengetahui->NamaLengkap) ? $modRealisasiLembur->pegawaimengetahui->NamaLengkap : "";
                $modRencanaLembur->menyetujui_nama = isset($modRealisasiLembur->pegawaimenyetujui->NamaLengkap) ? $modRealisasiLembur->pegawaimenyetujui->NamaLengkap : "";
                $modRencanaLembur->pemberitugas_nama = isset($modRealisasiLembur->pemberitugas->NamaLengkap) ? $modRealisasiLembur->pemberitugas->NamaLengkap : "";
                $modDetail = RealisasilemburT::model()->findAllByAttributes(array('norealisasi'=>$norealisasi));
				$modRencanaLembur->attributes = $modDetail[0]->attributes;
            }
                        
            if (isset($modRencanaLembur)){
                $modRencanaLembur->tglrencana = date('d M Y H:i:s',strtotime($modRencanaLembur->tglrencana));
            }
            
            $transaction = Yii::app()->db->beginTransaction();
            if (isset($_POST['KPRealisasiLemburT'])){
            try {
                    if(isset($_POST['RealisasilemburT'])){
                        if(count($_POST['RealisasilemburT']) > 0){
                            foreach($_POST['RealisasilemburT'] AS $i => $detail){
                                $modRealisasiLembur = $this->simpanRealisasiLembur($_POST['KPRencanaLemburT'], $_POST['KPRealisasiLemburT'],$detail);
								
								if (isset($_POST['RealisasilemburT'][$i]['pilih'])){
									if ($_POST['RealisasilemburT'][$i]['pilih']){
										// insert 
										$format = new MyFormatter;
										$modRealisasiLembur = new KPRealisasiLemburT;
										$modRealisasiLembur->norealisasi = $_POST['KPRealisasiLemburT']['norealisasi'];                            
										$modRealisasiLembur->mengetahui_id = $_POST['KPRencanaLemburT']['mengetahui_id'];
										$modRealisasiLembur->menyetujui_id = $_POST['KPRencanaLemburT']['menyetujui_id'];
										$modRealisasiLembur->pemberitugas_id = $_POST['KPRencanaLemburT']['pemberitugas_id'];
										$modRealisasiLembur->keterangan = $_POST['KPRencanaLemburT']['keterangan'];
										$modRealisasiLembur->create_time = date('Y-m-d H:i:s');
										$modRealisasiLembur->create_user = Yii::app()->user->id;
										$modRealisasiLembur->isharilembur = $_POST['KPRealisasiLemburT']['isharilembur'];

										$tgljamrealisasi = $_POST['KPRealisasiLemburT']['tglrealisasi'];
										$tgljamrealisasi = $format->formatDateTimeForDb($tgljamrealisasi);
										$tglrealisasi = date('Y-m-d', strtotime($tgljamrealisasi));

											$modRealisasiLembur->rencanalembur_id = isset($detail['rencanalembur_id']) ? $detail['rencanalembur_id'] : null;
											$modRealisasiLembur->pegawai_id = $detail['pegawai_id'];
											$modRealisasiLembur->jamMulai = $detail['jamMulai'];
											$modRealisasiLembur->jamSelesai = $detail['jamSelesai'];
											$modRealisasiLembur->nourut = $detail['nourut'];
											$modRealisasiLembur->alasanlembur = $detail['alasanlembur'];
											if(!empty($modRealisasiLembur->jamMulai)){
												$modRealisasiLembur->tglmulai = $tglrealisasi." ".$modRealisasiLembur->jamMulai.":00";
											}
											if(!empty($modRealisasiLembur->jamSelesai)){
												$modRealisasiLembur->tglselesai = $tglrealisasi." ".$modRealisasiLembur->jamSelesai.":00";
											}
											$modRealisasiLembur->tglrealisasi = $tgljamrealisasi;

										if($modRealisasiLembur->save()){
											$this->realisasilemburtersimpan &= true;
										}else{
											$this->realisasilemburtersimpan &= false;
										}

										// update
										$modRencanaLembur = KPRencanaLemburT::model()->findByPk($modRealisasiLembur->rencanalembur_id );
										$modRencanaLembur->realisasilembur_id = $modRealisasiLembur->realisasilembur_id; 
										$modRencanaLembur->keterangan = $_POST['KPRencanaLemburT']['keterangan'];
										$modRencanaLembur->pemberitugas_id = $_POST['KPRencanaLemburT']['pemberitugas_id'];
										$modRencanaLembur->mengetahui_id = $_POST['KPRencanaLemburT']['mengetahui_id'];
										$modRencanaLembur->menyetujui_id = $_POST['KPRencanaLemburT']['menyetujui_id'];

										if($modRencanaLembur->update()){
											$this->rencanalemburtersimpan &= true;
										}else{
											$this->rencanalemburtersimpan &= false;
										}
									}
								}
                            }
                        }
                    }

                if($this->realisasilemburtersimpan && $this->rencanalemburtersimpan){
                    $transaction->commit();
                    $sukses = 1;
                    $norealisasi = $modRealisasiLembur->norealisasi;  
					if(isset($_GET['frame'])){
						$this->redirect(array('buat','norealisasi'=>$norealisasi,'sukses'=>$sukses,'frame'=>1));
					}
                    $this->redirect(array('buat','norealisasi'=>$norealisasi,'sukses'=>$sukses));
                }else{
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data realisasi lembur pegawai gagal disimpan !");
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data realisasi lembur pegawai gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
            }
        }else{
            $modRealisasiLembur->tglrealisasi = date('d M Y H:i:s');

        }
        if (!isset($modRencanaLembur)){
            $modRencanaLembur = new KPRencanaLemburT();
        }

        if (!isset($modRencanaLemburDetail)){
            $modRencanaLemburDetail = null;
        }

        $modRealisasiLembur->tglrealisasi = date('d M Y H:i:s', strtotime($modRealisasiLembur->tglrealisasi));
        $this->render('buat',array(
                    'modRealisasiLembur'=>$modRealisasiLembur, 
                    'modRencanaLembur'=>$modRencanaLembur, 
                    'modRealisasiLemburDetail'=>$modRealisasiLemburDetail,
                    'modRencanaLemburDetail'=>$modRencanaLemburDetail,
                    'norencana'=>$norencana,
                    'format'=>$format,
					'modPegawai'=>$modPegawai,
					'modDetail'=>$modDetail,
                ));   
    }
        
	     

	/**
	 * Informasi Realisasi Lembur.
	 */
	public function actionInformasi()
	{
            
            $modRealisasiLembur=new KPRealisasiLemburT('search');
            $modRealisasiLembur->unsetAttributes();  // clear any default values

            if(isset($_GET['KPRealisasiLemburT'])){
                    $modRealisasiLembur->tgl_awal=$_GET['KPRealisasiLemburT']['tgl_awal'];
                    $modRealisasiLembur->tgl_akhir=$_GET['KPRealisasiLemburT']['tgl_akhir'];
            }else{
                    $modRealisasiLembur->tgl_awal = date ('d M Y');
                    $modRealisasiLembur->tgl_akhir = date ('d M Y');
            }

            $this->render('informasi',array(
                    'modRealisasiLembur'=>$modRealisasiLembur,
            ));
	}

	/**
         * Untuk melihat detail transaksi rencana lembur
         */
        public function actionPrint($norealisasi = null)
	{
            $format = new MyFormatter;
            $modRealisasiLembur = KPRealisasiLemburT::model()->findByAttributes(array('norealisasi'=>$norealisasi));
            $modRealisasiLemburDetail = KPRealisasiLemburT::model()->findAllByAttributes(array('norealisasi'=>$norealisasi));
            
            $modRealisasiLembur->tglrealisasi = $format->formatDateTimeId($modRealisasiLembur->tglrealisasi);
  

            $judul_print = 'Realisasi Lembur';
            $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
            if (isset($_GET['frame'])){
                $this->layout='//layouts/iframe';
            }
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
            }
            else if($caraPrint=='EXCEL') {
                $this->layout='//layouts/printExcel';
            }else if($caraPrint == 'PDF'){
				$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');              // Ukuran Kertas Pdf
				$posisi = Yii::app()->user->getState('posisi_kertas');                                        // Posisi L->Landscape,P->Portait
				$mpdf = new MyPDF('', $ukuranKertasPDF);
				$mpdf->useOddEven = 2;
				$mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
				$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
				$mpdf->WriteHTML($stylesheet,1);
				$mpdf->WriteHTML($this->renderPartial('Print', array(
                    'format'=>$format,
                    'judul_print'=>$judul_print,
                    'modRealisasiLembur'=>$modRealisasiLembur,
                    'modRealisasiLemburDetail'=>$modRealisasiLemburDetail,
                    'caraPrint'=>$caraPrint), true));
				$mpdf->Output();
			}

            $this->render('Print', array(
                    'format'=>$format,
                    'judul_print'=>$judul_print,
                    'modRealisasiLembur'=>$modRealisasiLembur,
                    'modRealisasiLemburDetail'=>$modRealisasiLemburDetail,
                    'caraPrint'=>$caraPrint
            ));
                
	}
        
        /**
         * Untuk print
         */
        public function actionLihatDetail($norealisasi)
	{
            $this->layout='//layouts/iframe';
            
            $modRealisasiLembur = KPRealisasiLemburT::model()->findByAttributes(array('norealisasi'=>$norealisasi));
            $modRealisasiLemburDetail = KPRealisasiLemburT::model()->findAllByAttributes(array('norealisasi'=>$norealisasi));
            $format = new MyFormatter;
            $modRealisasiLembur->tglrealisasi = $format->formatDateTimeId($modRealisasiLembur->tglrealisasi);

            $this->render('lihatdetail',array(
                    'modRealisasiLembur'=>$modRealisasiLembur, 'modDetail'=>$modRealisasiLemburDetail,
                    'norealisasi'=>$norealisasi
            ));
                
	}
       
        /**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=KPRealisasiLemburT::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='rencana-lembur-t-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        /**
         *Mengubah status aktif
         * @param type $id 
         */
        public function actionRemoveTemporary($id)
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
                //SAKabupatenM::model()->updateByPk($id, array('kabupaten_aktif'=>false));
                //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
        
        public function actionPrintRealisasi()
        {
            $model= new KPRealisasiLemburT;
            $model->attributes=$_REQUEST['KPRealisasiLemburT'];
            $judulLaporan='Data RealisasiLemburT';
            $caraPrint=$_REQUEST['caraPrint'];
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
                $this->render('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($caraPrint=='EXCEL') {
                $this->layout='//layouts/printExcel';
                $this->render('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($_REQUEST['caraPrint']=='PDF') {
                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
                $mpdf = new MyPDF('',$ukuranKertasPDF); 
                $mpdf->useOddEven = 2;  
                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                $mpdf->WriteHTML($stylesheet,1);  
                $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                $mpdf->WriteHTML($this->renderPartial('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
                $mpdf->Output();
            }                       
        }      
        
        /**
        * Untuk transaksi rencana lembur pegawai
        */
       public function actionSetPegawaiLembur()
       {
           $tr = "";
           if(Yii::app()->request->isAjaxRequest) {

               $modRencanaLembur=new KPRencanaLemburT;
               $modRealisasiLembur=new KPRealisasiLemburT;
               $modRealisasiLemburDetail=new RealisasilemburT;
               if(!empty($_POST['pegawailembur_id'])){
                   $pegawailembur_id=$_POST['pegawailembur_id'];
                   $modPegawai=PegawaiM::model()->findByPk($pegawailembur_id);
               }
               else if (!empty($_POST['nomorindukpegawai'])){
                   $nomorindukpegawaiPegawaiLembur=$_POST['nomorindukpegawai'];
                   $modPegawai=PegawaiM::model()->findByAttributes(array('nomorindukpegawai'=>$nomorindukpegawaiPegawaiLembur));
                   $pegawailembur_id=$modPegawai->pegawai_id;
               }


               if(!empty($modPegawai->pegawai_id)){
                   $tr.="<tr>
                           <td>". CHtml::activeTextField($modRealisasiLemburDetail,'['.$pegawailembur_id.']nourut',array('class'=>'span1 no_urut','readonly'=>TRUE)).
                                  CHtml::activeHiddenField($modRealisasiLemburDetail,'['.$pegawailembur_id.']pegawai_id',array('value'=>$modPegawai->pegawai_id, 'class'=>'karlemburNama')).                                
                                  CHtml::activeHiddenField($modRealisasiLemburDetail,'['.$pegawailembur_id.']nomorindukpegawai',array('value'=>$modPegawai->nomorindukpegawai, 'class'=>'karlemburNik')).                                
                          "</td>
                           <td>".$modPegawai->nomorindukpegawai."</td>
                           <td>".$modPegawai->nama_pegawai."</td>";      //<td>".$modPegawai->jabatan->jabatan_nama."</td>                  

                   $tr.="<td>".CHtml::activetextField($modRealisasiLemburDetail,'['.$pegawailembur_id.']jamMulai',array('placeholder'=>'00:00','class'=>'span1 detailRequired','readonly'=>false, 'maxLength'=>5, 'onkeypress'=>'return $(this).focusNextInputField(event)', 'onblur'=>'checkTime(this);'))."</td>";
                   $tr.="<td>".CHtml::activetextField($modRealisasiLemburDetail,'['.$pegawailembur_id.']jamSelesai',array('placeholder'=>'00:00','class'=>'span1','readonly'=>false, 'maxLength'=>5, 'onkeypress'=>'return $(this).focusNextInputField(event)', 'onblur'=>'checkTime(this);'))."</td>";

                   $tr.="        <td>".CHtml::activetextField($modRealisasiLemburDetail,'['.$pegawailembur_id.']alasanlembur',array('class'=>'span3','readonly'=>false, 'onkeypress'=>'return $(this).focusNextInputField(event)'))."</td>
                           <td>".CHtml::link("<span class='icon-remove'>&nbsp;</span>",'',array('href'=>'','onclick'=>'hapusBaris(this); return false'))."</td>
                        </tr>   
                       ";

                   $data['tr']=$tr;
                   echo json_encode($data);
                   Yii::app()->end();
               }else{
                   // Jika data pegawai salah
               }
           }
       }        
      
    /**
     * simpan RealisasilemburT
     * @param type $modRencanaLembur
     * @param type $postRencanaLembur
     * @return \RealisasilemburT
     */
    protected function simpanRealisasiLembur($postRencanaLembur,$postRealisasi,$postDetail){
        $format = new MyFormatter;
        $modRealisasiLembur = new KPRealisasiLemburT;
        $modRealisasiLembur->norealisasi = $postRealisasi['norealisasi'];
        $modRealisasiLembur->mengetahui_id = $postRencanaLembur['mengetahui_id'];
        $modRealisasiLembur->menyetujui_id = $postRencanaLembur['menyetujui_id'];
        $modRealisasiLembur->pemberitugas_id = $postRencanaLembur['pemberitugas_id'];
        $modRealisasiLembur->keterangan = $postRencanaLembur['keterangan'];
        $modRealisasiLembur->create_time = date('Y-m-d H:i:s');
        $modRealisasiLembur->create_user = Yii::app()->user->id;
        $modRealisasiLembur->isharilembur = $_POST['isharilembur'];
		
        $tgljamrealisasi = $postRealisasi['tglrealisasi'];
        $tgljamrealisasi = $format->formatDateTimeForDb($tgljamrealisasi);
        $tglrealisasi = date('Y-m-d', strtotime($tgljamrealisasi));
		
		$modRealisasiLembur->rencanalembur_id = isset($postDetail['rencanalembur_id']) ? $postDetail['rencanalembur_id'] : null;
		$modRealisasiLembur->pegawai_id = $postDetail['pegawai_id'];
		$modRealisasiLembur->jamMulai = $postDetail['jamMulai'];
		$modRealisasiLembur->jamSelesai = $postDetail['jamSelesai'];
		$modRealisasiLembur->nourut = $postDetail['nourut'];
		$modRealisasiLembur->alasanlembur = $postDetail['alasanlembur'];
		if(!empty($modRealisasiLembur->jamMulai)){
			$modRealisasiLembur->tglmulai = $tglrealisasi." ".$modRealisasiLembur->jamMulai.":00";
		}
		if(!empty($modRealisasiLembur->jamSelesai)){
			$modRealisasiLembur->tglselesai = $tglrealisasi." ".$modRealisasiLembur->jamSelesai.":00";
		}
		$modRealisasiLembur->tglrealisasi = $tgljamrealisasi;
		
        if($modRealisasiLembur->save()){
            $this->realisasilemburtersimpan &= true;
        }else{
            $this->realisasilemburtersimpan &= false;
        }
        return $modRealisasiLembur;
    }
	
	public function actionGetPegawai()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$criteria = new CDbCriteria();
			if (isset($_GET['term_nip'])){
				$criteria->compare('LOWER(nomorindukpegawai)', strtolower($_GET['term_nip']), true);
			}
			if (isset($_GET['term_nama'])){
				$criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term_nama']), true);
			}
			$criteria->addCondition("pegawai_aktif is TRUE");
			$criteria->order = 'nama_pegawai';
			if (isset($_GET['pegawai_id'])){
				if(!empty($_GET['pegawai_id'])){
					$criteria->addCondition("pegawai_id = ".$_GET['pegawai_id']);						
				}
			}
			$models = PegawaiM::model()->findAll($criteria);
			foreach($models as $i=>$model)
			{
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				if (isset($_GET['term_nama'])){
					$returnVal[$i]['label'] = $model->gelardepan." ".$model->nama_pegawai.", ".$model->gelarbelakang_nama." - ".$model->nomorindukpegawai;
					$returnVal[$i]['value'] = $model->pegawai_id;
				}else{
					$returnVal[$i]['label'] = $model->nomorindukpegawai." - ".$model->gelardepan." ".$model->nama_pegawai.", ".$model->gelarbelakang_nama;
					$returnVal[$i]['value'] = $model->pegawai_id;
				}
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}
	
}
