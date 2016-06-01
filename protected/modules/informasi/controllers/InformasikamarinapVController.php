
<?php

class InformasikamarinapVController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
        public $defaultAction = 'index';

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model=new INInformasikamarinapV;

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['INInformasikamarinapV']))
		{
			$model->attributes=$_POST['INInformasikamarinapV'];
			if($model->save()){
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('view','id'=>$model->ruangan_id));
                        }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['INInformasikamarinapV']))
		{
			$model->attributes=$_POST['INInformasikamarinapV'];
			if($model->save()){
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('view','id'=>$model->ruangan_id));
                        }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
        
        

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
                        //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
//		$model = INInformasikamarinapV::model()->findAll('kamarruangan_aktif = true order by ruangan_id, kelaspelayanan_id, kamarruangan_nokamar, kamarruangan_nobed');
            $model =INInformasikamarinapV::model()->findAll('kamarruangan_aktif = true order by ruangan_id, kelaspelayanan_id, kamarruangan_nokamar, kamarruangan_nobed');
            $row = $this->renderKamarRuangan($model);
            if ((isset($_POST['ajax']))&&(isset($_POST['ruangan']))){
                $ruangan = $_POST['ruangan'];
                $model =INInformasikamarinapV::model()->findAll(((!empty($ruangan)) ? "ruangan_id =".$ruangan." and " : "").'kamarruangan_aktif = true order by ruangan_id, kelaspelayanan_id, kamarruangan_nokamar, kamarruangan_nobed');
                $row = $this->renderKamarRuangan($model);
                
                echo json_encode($row);
                Yii::app()->end();
            }
                
            $this->render('index',array(
                    'model'=>$model,
                    'row'=>$row
            ));
	}
        
        protected function renderKamarRuangan($model){
                $result = '';
                $tempRuangan = '';
                $list1 = array();
                $jml = 0;
                foreach ($model as $i=>$row){
                    if ($row->ruangan_id != $tempRuangan){
                        $tempJumlah = 0;
                        $list1[$row->ruangan_id]['name'] = $row->ruangan_nama;
                        $list1[$row->ruangan_id]['ruangan_id'] = $row->ruangan_id;
                        $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['name'] = $row->kamarruangan_nokamar;
                        $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['kelaspelayanan'] = $row->kelaspelayanan_namalainnya;
                        $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['jml'] = $row->kamarruangan_jmlbed;
                        $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['name'] = $row->kamarruangan_nokamar;
                        $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['bed'][$i]['no'] = $row->kamarruangan_nobed;
                        $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['bed'][$i]['status'] = $row->kamarruangan_status;
                        $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['bed'][$i]['id'] = $row->kamarruangan_id;
                        $tempJumlah = $row->kamarruangan_jmlbed;
                        $tempRuangan = $row->ruangan_id;
                    }
                    else{
                        $list1[$tempRuangan]['kamar'][$row->kelaspelayanan_id]['name'] = $row->kamarruangan_nokamar;
                        $list1[$tempRuangan]['kamar'][$row->kelaspelayanan_id]['kelaspelayanan'] = $row->kelaspelayanan_namalainnya;
                        if ($row->kamarruangan_jmlbed >= $tempJumlah){
                            $jml = $row->kamarruangan_jmlbed;
                            $tempJumlah = $row->kamarruangan_jmlbed;
                        }
                        $list1[$tempRuangan]['kamar'][$row->kelaspelayanan_id]['jml'] = $jml;
                        $list1[$tempRuangan]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['name'] = $row->kamarruangan_nokamar;
                        $list1[$tempRuangan]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['bed'][$i]['no'] = $row->kamarruangan_nobed;
                        $list1[$tempRuangan]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['bed'][$i]['status'] = $row->kamarruangan_status;
                        $list1[$tempRuangan]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['bed'][$i]['id'] = $row->kamarruangan_id;
                    }
                }
//                echo "<pre>";
                foreach ($list1 as $i=>$v){
                    
                    $result .= '<div class="contentKamar">';				 			
                    $ruangan = RuanganM::model()->findByPk($v['ruangan_id']);
                        $dataRuangan ='';
						
                        if (count($ruangan) == 1){
                            $dataRuangan .='<table width=\'200px\'>';
                            $dataRuangan .='<tr><td rowspan=2><img src=\''.Yii::app()->baseUrl.'/images/'.$ruangan->ruangan_image.'\' class=\'image_ruangan\'></td><td>Fasilitas</td><td>'.((!empty($ruangan->ruangan_fasilitas)) ? $ruangan->ruangan_fasilitas : " - ").'</td></tr>';
                            $dataRuangan .='<tr><td>Lokasi</td><td>'.((!empty($ruangan->ruangan_lokasi)) ? $ruangan->ruangan_lokasi : " - ").'</td></tr>';
                            $dataRuangan .='<tr><td>Jumlah Bed</td><td>{$jmlbed}</td></tr>';
                            $dataRuangan .='<tr><td>Jumlah Terisi</td><td>{$jmlterisi}</td></tr>';
                            $dataRuangan .='<tr><td>Jumlah Dibooking</td><td>{$jmlbooked}</td></tr>';
                            $dataRuangan .='</table>';
                        }
                        foreach ($v['kamar'] as $j=>$w){
                            $jml_kasur = 0;
                            $jml_terisi = 0;
                            $jml_booked = 0;
                            foreach ($w['kamar'] as $t=>$bed){
                               $jml_kasur += count($bed['bed']);
                               foreach ($bed['bed'] as $d=>$e){
                                   $kamar = MasukkamarT::model()->find('kamarruangan_id = '.$e['id'].' order by tglmasukkamar desc');
                                   if (count($kamar) == 1){
                                       $jml_terisi += 1;
                                   }
                                   $booking = BookingkamarT::model()->find('kamarruangan_id = '.$e['id'].' AND statuskonfirmasi = \'SUDAH KONFIRMASI\'');
                                   if (count($booking) == 1){
                                       $jml_booked += 1; 
                                   }
                               }
                            }
                            $vars = array(
                              '{$jmlbed}' => $jml_kasur,
                              '{$jmlterisi}' => $jml_terisi,
                              '{$jmlbooked}' => $jml_booked,
                            );
                            $result .='<div class="pintu"></div><h3 class="popover-title"><img src=\''. Yii::app()->baseUrl.'/images/blue-home-icon.png\' style=\'height:30px;\'/>'.$v['name'].' - '.$w['kelaspelayanan'].' - '.$w['jml'].'<a style = "padding-left:100px;"  href="" class="pull-right poping" data-content="'.strtr($dataRuangan,$vars).'" onclick="return false;"><img src=\''. Yii::app()->baseUrl.'/images/fasilitas.png\' style=\'height:30px;\'/>Detail</a></h3>
                                <ul>';
                            foreach ($w['kamar'] as $x=>$y){            
                                $result .='<li class="bed">
                                    <div class="popover-inner">
                                        <h6 class="popover-title">'.$y['name'].'</h3>
                                        <div class="popover-content">';
                                    foreach ($y['bed'] as $a=>$b){   
                                        $kamar = MasukkamarT::model()->find('kamarruangan_id = '.$b['id'].' order by tglmasukkamar desc');
                                        $booking = BookingkamarT::model()->find('kamarruangan_id = '.$b['id'].' AND statuskonfirmasi = \'SUDAH KONFIRMASI\'');
                                        if (isset($booking)){
                                            $booked = 1;
                                        } else {
                                            $booked = 0;
                                        }
                                      
                                        $dataPasien = '';
                                        if (count($kamar) == 1){
                                            $dataPasien .='<table>';
                                            $dataPasien .='<tr><td>No. RM </td><td>: '.$kamar->admisi->pasien->no_rekam_medik.'</td></tr>';
                                            $dataPasien .='<tr><td>Nama </td><td>: '.$kamar->admisi->pasien->nama_pasien.'</td></tr>';
                                            $dataPasien .='<tr><td>Jenis Kelamin </td><td>: '.$kamar->admisi->pasien->jeniskelamin.'</td></tr>';
                                            $dataPasien .= '</table>';
//                                            $dataPasien .='<p><label class=\'control-label\'>Nama :</label> '.$kamar->admisi->pasien->nama_pasien.'</p>';
//                                            $dataPasien .='<p><label class=\'control-label\'>Jenis Kelamin :</label> '.$kamar->admisi->pasien->jeniskelamin.'</p>';
                                        }
                                        if ($booked == 0){
                                            $result .='<p><a href="" class="btn '.(($b['status']) ? 'btn-danger' : 'btn-primary').'" rel="popover" data-content="'.(($b['status']) ? 'Pasien Kosong' : $dataPasien).'" onclick="return false"><img src=\''. Yii::app()->baseUrl.'/images/'.(($b['status']) ?  'RanjangRumahSakit2' : 'RanjangRumahSakit').'.png\'/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No. Bed : '.$b['no'].'</a></p>';
                                        } else {
                                            $result .='<p><a href="" class="btn '.(($b['status']) ? 'btn-danger' : 'btn-primary').'" rel="popover" data-content="'.(($b['status']) ? 'Sudah dibooking' : $dataPasien).'" onclick="return false"><img src=\''. Yii::app()->baseUrl.'/images/'.'RanjangRumahSakit3'.'.png\'/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No. Bed : '.$b['no'].'</a></p>';
                                        }
                                    }
                                    for($d=1;$d<=($w['jml'] - (count($y['bed'])));$d++){
                                        
                                        $result .='<p><a href="" class="btn btn-info" onclick="return false"><img src=\''. Yii::app()->baseUrl.'/images/delete.png\'/>Kosong</a></p>';
                                    }
                                        $result .='</div>
                                    </div>
                                </li>';
                            }
                            $result .='</ul>';
                        }
                       
                    $result .='</div>';
                }
                
//            exit();
            return $result;
        }

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                
		$model=new INInformasikamarinapV('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['INInformasikamarinapV']))
			$model->attributes=$_GET['INInformasikamarinapV'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=INInformasikamarinapV::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='ininformasikamarinap-v-form')
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
        
        public function actionPrint()
        {
            $model= new INInformasikamarinapV;
            $model->attributes=$_REQUEST['INInformasikamarinapV'];
            $judulLaporan='Data INInformasikamarinapV';
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
}
