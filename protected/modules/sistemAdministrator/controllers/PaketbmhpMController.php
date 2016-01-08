
<?php

class PaketbmhpMController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'admin';
	public $path_view = 'sistemAdministrator.views.paketbmhpM.';

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render($this->path_view.'view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$format = new MyFormatter;
		$model=new SAPaketbmhpM;
		// Uncomment the following line if AJAX validation is needed
		if(isset($_POST['SAPaketbmhpM']))
		{
			$model->attributes=$_POST['SAPaketbmhpM'];
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$model->obatalkes_id = isset($_POST['SAPaketbmhpM']['obatalkes_id']) ? $_POST['SAPaketbmhpM']['obatalkes_id'] : null;
				$model->daftartindakan_id = isset($_POST['SAPaketbmhpM']['daftartindakan_id']) ? $_POST['SAPaketbmhpM']['daftartindakan_id'] : null;
				$model->tipepaket_id = $_POST['SAPaketbmhpM']['tipepaket_id'];
				$model->satuankecil_id = (!empty($model->obatalkes_id) ? $model->obatalkes->satuankecil_id : null);
				$model->qtystokout = 0;
				$model->qtypemakaian = $_POST['SAPaketbmhpM']['qtypemakaian'];
				$model->hargapemakaian = $_POST['SAPaketbmhpM']['hargapemakaian'];

				if ($model->save()) {
					$transaction->commit();
					Yii::app()->user->setFlash('success', "Data Berhasil Disimpan ");
					$this->redirect($this->createUrl('admin',array('sukses'=>1)));
				}

			} catch (Exception $exc) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
			}
		}

		$this->render($this->path_view.'create',array(
			'model'=>$model
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$format = new MyFormatter;
		$model=$this->loadModel($id);
		$model->daftartindakan_nama = (isset($model->daftartindakan->daftartindakan_nama) ? $model->daftartindakan->daftartindakan_nama : "");
		$model->obatalkes_nama = (isset($model->obatalkes->obatalkes_nama) ? $model->obatalkes->obatalkes_nama : "");
		$model->qtypemakaian = $format->formatNumberForUser($model->qtypemakaian);
		$model->hargapemakaian = $format->formatNumberForUser($model->hargapemakaian);
		// Uncomment the following line if AJAX validation is needed
		if(isset($_POST['SAPaketbmhpM']))
		{
			$model->attributes=$_POST['SAPaketbmhpM'];
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$model->obatalkes_id = isset($_POST['SAPaketbmhpM']['obatalkes_id']) ? $_POST['SAPaketbmhpM']['obatalkes_id'] : null;
				$model->daftartindakan_id = isset($_POST['SAPaketbmhpM']['daftartindakan_id']) ? $_POST['SAPaketbmhpM']['daftartindakan_id'] : null;
				$model->tipepaket_id = $_POST['SAPaketbmhpM']['tipepaket_id'];
				$model->satuankecil_id = (!empty($model->obatalkes_id) ? $model->obatalkes->satuankecil_id : null);
				$model->qtystokout = 0;
				$model->qtypemakaian = $_POST['SAPaketbmhpM']['qtypemakaian'];
				$model->hargapemakaian = $_POST['SAPaketbmhpM']['hargapemakaian'];

				if ($model->update()) {
					$transaction->commit();
					Yii::app()->user->setFlash('success', "Data Berhasil Disimpan ");
					$this->redirect($this->createUrl('admin',array('sukses'=>1)));
				}

			} catch (Exception $exc) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
			}
		}

		$this->render($this->path_view.'update',array(
			'model'=>$model
		));
	}
	
	public function actionAutocompleteDaftarTindakan()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter();
			$returnVal = array();
			$term = isset($_GET['term']) ? $_GET['term'] : null;
			$criteria = new CDbCriteria;
			$criteria->compare("LOWER(daftartindakan_kode)",strtolower($term),true,"OR");
			$criteria->compare("LOWER(daftartindakan_nama)",strtolower($term),true,"OR");
			$criteria->compare("LOWER(daftartindakan_namalainnya)",strtolower($term),true,"OR");
			$criteria->compare("LOWER(daftartindakan_katakunci)",strtolower($term),true,"OR");
			$criteria->addCondition("daftartindakan_aktif = TRUE");
			$criteria->limit = 10;
			$models = SADaftarTindakanM::model()->findAll($criteria);
			foreach($models as $i=>$model)
			{
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['value'] = $model->daftartindakan_nama;
				$returnVal[$i]['label'] = $model->daftartindakan_kode." ".$model->daftartindakan_nama;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}
	
	public function actionAutocompleteObatalkes()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter();
			$returnVal = array();
			$term = isset($_GET['term']) ? $_GET['term'] : null;
			$criteria = new CDbCriteria;
			$criteria->compare("LOWER(obatalkes_kode)",strtolower($term),true,"OR");
			$criteria->compare("LOWER(obatalkes_nama)",strtolower($term),true,"OR");
			$criteria->addCondition("obatalkes_aktif = TRUE");
			$criteria->limit = 10;
			$models = SAObatalkesM::model()->findAll($criteria);
			foreach($models as $i=>$model)
			{
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['value'] = $model->obatalkes_nama;
				$returnVal[$i]['label'] = $model->obatalkes_kode." ".$model->obatalkes_nama;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
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
            $hapus = SAPaketbmhpM::model()->deleteByPk($id);
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
		$dataProvider=new CActiveDataProvider('SAPaketbmhpM');
		$this->render($this->path_view.'index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                
		$model=new SAPaketbmhpM('search');
		$model->unsetAttributes();
		if(isset($_GET['SAPaketbmhpM'])){
			$model->attributes=$_GET['SAPaketbmhpM'];
			$model->daftartindakan_nama=$_GET['SAPaketbmhpM']['daftartindakan_nama'];
			$model->obatalkes_kode=$_GET['SAPaketbmhpM']['obatalkes_kode'];
			$model->obatalkes_nama=$_GET['SAPaketbmhpM']['obatalkes_nama'];
		}

		$this->render($this->path_view.'admin',array(
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
		$model = new SAPaketbmhpM();
        $dataModel = SAPaketbmhpM::model()->findByAttributes(array('paketbmhp_id'=>$id));
		if(count($dataModel)>0){
			$model=$dataModel;
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='sapaketbmhp-m-form')
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
            $model= new SAPaketbmhpM;
            $model->attributes=$_REQUEST['SAPaketbmhpM'];
            $judulLaporan='Data Paket BMHP';
            $caraPrint=$_REQUEST['caraPrint'];
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
                $this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($caraPrint=='EXCEL') {
                $this->layout='//layouts/printExcel';
                $this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($_REQUEST['caraPrint']=='PDF') {
                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
                $mpdf = new MyPDF('',$ukuranKertasPDF); 
                $mpdf->useOddEven = 2;  
                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                $mpdf->WriteHTML($stylesheet,1);  
                $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                $mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
                $mpdf->Output();
            }                       
        }
		
		public function actionGetPaketBMHP()
		{
			$tr='';
			if(Yii::app()->request->isAjaxRequest) { 

				if (isset($_POST['tipePaket'])){
					$modPaketBMHP = PaketbmhpM::model()->findAllByAttributes(array('tipepaket_id'=>$_POST['tipePaket']));
					if (count($modPaketBMHP) > 0){
						$data['paket'] = 'Ada';
					}
					else{
						$data['paket'] = 'Tidak';
					}
				}else{
					$idTipePaket=$_POST['idTipePaket'];
					$idDaftarTindakan = $_POST['idDaftarTindakan'];
					$idObatAlkes = $_POST['idObatAlkes'];
					$qtyPemakaian = $_POST['qtyPemakaian'];
					$hargaPemakaian = $_POST['hargaPemakaian'];
					$modTipePaket = TipepaketM::model()->findByPk($idTipePaket);
					$modDaftarTindakan = DaftartindakanM::model()->findByPk($idDaftarTindakan);
					$modObatAlkes = ObatalkesM::model()->with('satuankecil')->findByPk($idObatAlkes);
					$modPaketBMHP = new PaketbmhpM;

					$tr .="<tr>
								<td>".CHtml::checkBox('checkList[]',true,array('class'=>'cekList','onclick'=>'hitungSemua()', 'onkeypress' => "return $(this).focusNextInputField(event)"))."</td>
								<td>" . CHtml::TextField('noUrut', '', array('class' => 'span1 noUrut', 'readonly' => TRUE)) .
										CHtml::activeHiddenField($modPaketBMHP, 'tipepaket_id[]', array('value' => $modTipePaket->tipepaket_id)) .
										CHtml::activeHiddenField($modPaketBMHP, 'daftartindakan_id[]', array('value' => $modDaftarTindakan->daftartindakan_id)) .
										CHtml::activeHiddenField($modPaketBMHP, 'obatalkes_id[]', array('value'=>$idObatAlkes)) .
										CHtml::activeHiddenField($modPaketBMHP, 'satuankecil_id[]', array('value'=>$modObatAlkes->satuankecil_id)) .

							"</td>
								<td>" . $modTipePaket->tipepaket_nama . "</td>
								<td>" . $modDaftarTindakan->daftartindakan_nama . "</td>
								<td>" . $modObatAlkes->satuankecil->satuankecil_nama . "</td>
								<td>" . $modObatAlkes->obatalkes_nama . "</td>

								<td>" . CHtml::activeTextField($modPaketBMHP, 'qtypemakaian[]', array('value' => $qtyPemakaian, 'class' => 'span1 qtypemakaian numbersOnly', 'onkeyup'=>'numberOnly(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>

								<td>" . CHtml::activeTextField($modPaketBMHP, 'hargapemakaian[]', array('value' => $hargaPemakaian, 'class' => 'span1 hargapemakaian numbersOnly', 'onkeyup'=>'numberOnly(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
							</tr>
							";

					$data['tr'] = $tr;
				}
				echo json_encode($data);
				Yii::app()->end();
			}
		}
		
}
