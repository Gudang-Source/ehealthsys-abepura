<?php

class TherapimapobatMController extends MyAuthController{
	public $layout='//layouts/column1';
	public $defaultAction = 'admin';
	

    public function actionView($therapiobat_id, $obatalkes_id)
    {
            $this->render('view',array(
            'model'=>$this->loadModel($therapiobat_id, $obatalkes_id),
        ));
    }

	/**
	 * Fungsi untuk create dan update
	 * parameter therapiobat_id & obatalkes_id
	 */
	public function actionIndex($therapiobat_id = null, $obatalkes_id = null)	
	{	
		$model=new GFTherapimapobatM;
		if ((!empty($therapiobat_id)) && (!empty($obatalkes_id))){
			$model->therapiobat_id = $therapiobat_id;
			$model->obatalkes_id = $obatalkes_id;
		}
		if(isset($_POST['GFTherapimapobatM']))
		{
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$sukses = true;
				$error = "";
				$posts = $_POST['GFTherapimapobatM'];
				if(count($posts) > 0){
					foreach($posts AS $i => $detail){
						$modValidasi = GFTherapimapobatM::model()->findByAttributes(array('therapiobat_id'=>$detail['therapiobat_id'],'obatalkes_id'=>$detail['obatalkes_id']));
						if(count($modValidasi) == 0){ //insert hanya untuk yg baru
							$model=new GFTherapimapobatM;
							$model->attributes=$detail;
							if($model->save()){
								$sukses &= true;
							}else{
								$sukses = false;
								$error .= CHtml::errorSummary($model);
							}
						}
					}
				}
				if($sukses){
					$transaction->commit();
					$this->redirect(array('admin','sukses'=>1));
				}else{
					$transaction->rollback();
					Yii::app()->user->setFlash('error', 'Data gagal disimpan.<br>'.$error);
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.'.MyExceptionMessage($exc));
		   }
		}

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new GFTherapimapobatM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['GFTherapimapobatM'])){
			$model->attributes=$_GET['GFTherapimapobatM'];
			$model->obatalkes_nama=$_GET['GFTherapimapobatM']['obatalkes_nama'];
			$model->therapiobat_nama=$_GET['GFTherapimapobatM']['therapiobat_nama'];
		}
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	
    public function loadModel($therapiobat_id, $obatalkes_id = null)
    {
		if ((!empty($therapiobat_id)) && (!empty($obatalkes_id))){
			$model=GFTherapimapobatM::model()->findByAttributes(array('therapiobat_id'=>$therapiobat_id, 'obatalkes_id'=>$obatalkes_id));
		}
		else{
			$model=GFObatAlkesM::model()->findByAttributes(array('obatalkes_id'=>$obatalkes_id));
		}
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
	
	/**
	 * Memanggil data dari model berdasarkan therapiobat_id.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModels($therapiobat_id)
	{
		$model=  GFTherapimapobatM::model()->findAllByAttributes(array('therapiobat_id'=>$therapiobat_id));
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='gflokasi-gudang-m-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
	/**
	 * Memanggil dan Menghapus data.
	 * @param integer $therapiobat_id & $obatalkes_id
	 */
	public function actionDelete($therapiobat_id, $obatalkes_id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$data['sukses'] = 0;
			$data['pesan'] = "Data gagal dihapus!";
			$transaction = Yii::app()->db->beginTransaction();
			try {
				if($this->loadModel($therapiobat_id, $obatalkes_id)->delete()){
					$data['sukses'] = 1;
					$data['pesan'] = "Data berhasil dihapus!";
					$transaction->commit();
				}else{
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = "Data gagal dihapus karna sudah digunakan di tabel lain!";
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = "Data gagal dihapus karna sudah digunakan di tabel lain!";
			}
			echo CJSON::encode($data);
			Yii::app()->end();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
        
	public function actionPrint()
	{
		$model= new GFTherapimapobatM;
		$model->attributes=$_REQUEST['GFTherapimapobatM'];
		$judulLaporan='Data Kelas Terapi Obat';
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
	
	public function actionGetKelasTerapi(){
        if(Yii::app()->request->isAjaxRequest) { 
            $obatalkes_id = $_POST['obatalkes_id'];
            $therapiobat_id = $_POST['therapiobat_id'];
			
            $modTherapi		=	TherapiobatM::model()->findByPk($therapiobat_id);
            $modObatAlkes	=	ObatalkesM::model()->findByPk($obatalkes_id);
			$modTherapimapobat = new GFTherapimapobatM;
            $modTherapimapobat->obatalkes_id = $modObatAlkes->obatalkes_id; 
			$modTherapimapobat->therapiobat_id = $modTherapi->therapiobat_id;
			
            echo CJSON::encode(array(
                'status'=>'create_form', 
                'form'=>$this->renderPartial('_rowKelasTerapi', array(
                        'modTherapimapobat'=>$modTherapimapobat
                    ), 
                true))
            );
            exit;  
        }
    }
	
	
	/**
	 * menampilkan data obat alkes
	 */
	public function actionAutocompleteObatAlkes()
    {
            if(Yii::app()->request->isAjaxRequest) {
                $returnVal = array();
                $term = isset($_GET['term']) ? $_GET['term'] : null;
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(obatalkes_nama)', strtolower($term), true);
                $criteria->order = 'obatalkes_nama';
                $criteria->addCondition('obatalkes_aktif = TRUE');
                $criteria->limit = 5;
                $models = ObatalkesM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->obatalkes_nama;
                    $returnVal[$i]['value'] = $model->obatalkes_id;
                }

                echo CJSON::encode($returnVal);
            }else
                throw new CHttpException(403,'Tidak dapat mengurai data');
            Yii::app()->end();
    }
	
	/**
	 * menampilkan data kelas terapi
	 */
	public function actionAutocompleteKelasTerapi()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $returnVal = array();
                $term = isset($_GET['term']) ? $_GET['term'] : null;
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(therapiobat_nama)', strtolower($term), true);
                $criteria->order = 'therapiobat_nama';
                $criteria->addCondition('therapiobat_aktif is true');
                $criteria->limit=5;
                $models = TherapiobatM::model()->findAll($criteria);
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
            }else
                throw new CHttpException(403,'Tidak dapat mengurai data');
            Yii::app()->end();
	}
	
	/**
	* menampilkan therapi map obat yg sudah pernah di inputkan
	*/
	public function actionGetTherapiMapObat()
	{
		if(Yii::app()->getRequest()->getIsAjaxRequest()) {
			$model = new GFTherapimapobatM;
			$data['form'] = "";
			$models = $this->loadModels($_POST['therapiobat_id']);
			if(count($models) > 0){
				foreach ($models AS $i=>$model){
					$model->kosong = 0;	// tanda jika data sudah ada.
					$data['form'] .= $this->renderPartial('_rowTherapiMapObat',array('model'=>$model),true);
				}
			}
			echo CJSON::encode($data);
			Yii::app()->end();
		}
	}
	
	/**
	* set therapi map obat yg baru
	*/
	public function actionSetFormTherapiMapObat()
	{
		if(Yii::app()->getRequest()->getIsAjaxRequest()) {
			$model = new GFTherapimapobatM;
			$model->therapiobat_id = $_POST['therapiobat_id'];
			$model->obatalkes_id = $_POST['obatalkes_id'];
			$model->kosong = 1; // tanda jika data belum ada.
			$data['form'] = $this->renderPartial('_rowTherapiMapObat',array('model'=>$model),true);
			echo CJSON::encode($data);
			Yii::app()->end();
		}
	}
	
}