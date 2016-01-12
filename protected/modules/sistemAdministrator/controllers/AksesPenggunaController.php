<?php

class AksesPenggunaController extends MyAuthController
{
	/**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/iframe';
    public $defaultAction = 'admin';


    /**
     * Menampilkan detail data.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $model = $this->loadModel($id);
        $this->render('view',array(
                'model'=>$model,
        ));
    }
    
    /**
     * Pengaturan data.
     */
    public function actionAdmin()
    {
        $model=new SAAksespenggunaK('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['SAAksespenggunaK'])){
            $model->attributes=$_GET['SAAksespenggunaK'];
            $model->nama_pemakai=$_GET['SAAksespenggunaK']['nama_pemakai'];
        }
        $this->render('admin',array(
                'model'=>$model,
        ));
    }

    /**
     * Membuat dan menyimpan data baru.
     */
    public function actionCreate()
    {
        $model=new SAAksespenggunaK;
        $data = array();

        $modPeran = SAPeranpenggunaK::model()->findAll();

        if(isset($_POST['SAAksespenggunaK']))
        {
            $transaction = Yii::app()->db->beginTransaction();
            try{
                foreach ($_POST['modul'] as $i => $peran) {
                    foreach ($peran as $j => $modul) {
                        $model= new SAAksespenggunaK;
                        $model->attributes = $_POST['SAAksespenggunaK'];
                        $model->peranpengguna_id = $i;
                        $model->modul_id = $modul;
                        $model->create_time = date('Y-m-d H:i:s');
                        $model->create_loginpemakai_id =Yii::app()->user->id;
                        $model->save();
                    }
                }
                $transaction->commit();
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                $this->redirect(array('admin'));
            }
            catch(Exception $exc){
                $transaction->rollback();
                $model->isNewRecord = true;
                Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }
        }
        $this->render('create',array(
            'model'=>$model,
            'modPeran'=>$modPeran,
        ));
    }

    /**
     * Memanggil dan Mengubah sebagian data.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $data = array();

        $modPeran = SAPeranpenggunaK::model()->findAll();



        $criteria = new CDbCriteria;
        $criteria->select = array('peranpengguna_id');
        $criteria->group = 'peranpengguna_id';
		if (!empty($model->peranpengguna_id)){
			$criteria->addCondition('peranpengguna_id ='.$model->peranpengguna_id);
		}
        $perans = SAAksespenggunaK::model()->findAll($criteria);

        foreach ($modPeran as $i => $peran) {
            $data[$peran->peranpengguna_id]['nama'] = $peran->peranpenggunanama;
            foreach ($perans as $j => $per) {
                if ($peran->peranpengguna_id==$per->peranpengguna_id) {
                    $criteria = new CDbCriteria;
                    $criteria->select = array('modul_id');
                    $criteria->group = 'modul_id';
					if (!empty($peran->peranpengguna_id)){
						$criteria->addCondition('peranpengguna_id ='.$peran->peranpengguna_id);
					}
                    $modTugas = SATugaspenggunaK::model()->findAll($criteria);
                    $data[$peran->peranpengguna_id]['modul'] = $modTugas;
                }else{
                    $data[$peran->peranpengguna_id]['modul'] = array();
                }
            }
        }

        $criteria1 = new CDbCriteria;
		if (!empty($model->peranpengguna_id)){
			$criteria1->addCondition('peranpengguna_id ='.$model->peranpengguna_id);
		}
        $moduls = SAAksespenggunaK::model()->findAll($criteria1);

        if(isset($_POST['SAAksespenggunaK']))
        {
            $transaction = Yii::app()->db->beginTransaction();
            try{
                SAAksespenggunaK::model()->deleteAllByAttributes(array(
                    'loginpemakai_id'=>$_POST['SAAksespenggunaK']['loginpemakai_id'],
                ));
				if(isset($_POST['modul'])){
					foreach ($_POST['modul'] as $i => $peran) {
						foreach ($peran as $j => $modul) {
							$model= new SAAksespenggunaK;
							$model->attributes = $_POST['SAAksespenggunaK'];
							$model->peranpengguna_id = $i;
							$model->modul_id = $modul;
							$model->create_time = date('Y-m-d H:i:s');
							$model->create_loginpemakai_id =Yii::app()->user->id;
							$model->save();
						}
					}
				}
                $transaction->commit();
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                $this->redirect(array('admin'));
            }
            catch(Exception $exc){
                $transaction->rollback();
                $model->isNewRecord = true;
                Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }
        }


        $this->render('update',array(
                'model'=>$model,
                'modPeran'=>$modPeran,
                'moduls'=>$moduls,
                'perans'=>$perans,
                'data'=>$data
        ));
    }

    /**
     * Memanggil dan Menghapus data.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
            $this->loadModel($id)->delete();
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Memanggil data dari model.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
            $model=SAAksespenggunaK::model()->findByAttributes(array('aksespengguna_id'=>$id));
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='satugaspengguna-k-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Mencetak data
     */
    public function actionPrint()
    {
        $model= new SAAksespenggunaK;
        $model->attributes=$_REQUEST['SAAksespenggunaK'];
        $judulLaporan='Data Akses Pengguna';
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

    public function actionGetModuls($encode=false)
    {
        if(Yii::app()->request->isAjaxRequest) {
            $peranpengguna_id = (isset($_POST['id']) ? $_POST['id'] : null);
            $criteria = new CDbCriteria;
	        $criteria->select = array('modul_id');
	        $criteria->group = 'modul_id';
			if (!empty($peranpengguna_id)){
				$criteria->addCondition('peranpengguna_id ='.$peranpengguna_id);
			}
	        $moduls = SATugaspenggunaK::model()->findAll($criteria);
            
            echo "<span id='modul_".$peranpengguna_id."'>";
            foreach ($moduls as $i => $modul) {

                echo CHtml::CheckBox('modul['.$peranpengguna_id.'][]','', array(
                                    'value'=>$modul->modul_id,
                                    ));
                echo '&nbsp;'.$modul->modul->modul_nama.'<br>';
            }
            echo "</span>";

        }
        Yii::app()->end();
    }

    public function actionGetPemakai(){
        if(Yii::app()->request->isAjaxRequest) {
            $id = (isset($_POST['id']) ? $_POST['id'] : null);
            $modLoginPemakai = LoginpemakaiK::model()->findByPk($id);
            $data = array();

            $data['id']=$id;
            $data['nama_pemakai'] = $modLoginPemakai->nama_pemakai;
            $data['nama_pegawai'] = empty($modLoginPemakai->pegawai_id)?'':$modLoginPemakai->pegawai->nama_pegawai;
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }

    public function actionAutocompleteLoginPemakai()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $namaloginpemakai = isset($_GET['term']) ? $_GET['term'] : null;
            $criteria = new CDbCriteria;
            $criteria->compare("LOWER(nama_pemakai)",strtolower($namaloginpemakai),true);
            $models = LoginpemakaiK::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['value'] = $model->loginpemakai_id;
                $returnVal[$i]['label'] = $model->nama_pemakai;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    public function actionCekLoginPemakai(){
        if(Yii::app()->request->isAjaxRequest) {
            $id = (isset($_POST['pemakai']) ? $_POST['pemakai'] : null);
            $data=array();
            $model=SAAksespenggunaK::model()->findByAttributes(array('loginpemakai_id'=>$id));
            $data['success']=count($model);
            $data['id']=isset($model->aksespengguna_id)?$model->aksespengguna_id:'';
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }

}