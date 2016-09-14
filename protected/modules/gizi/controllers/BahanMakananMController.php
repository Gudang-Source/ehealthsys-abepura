<?php

class BahanMakananMController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
                public $defaultAction='index';

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{   $this->layout = '//layouts/iframe';
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{   $this->layout = '//layouts/iframe';
		$model=new BahanmakananM;
                                $models=new ZatBahanMakananM;

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['BahanmakananM']))
		{
                        //var_dump($_POST);
			$model->attributes=$_POST['BahanmakananM'];
                        $model->tglkadaluarsabahan = MyFormatter::formatDateTimeForDb($model->tglkadaluarsabahan);
                        //$model->validate();
                        //var_dump($model->errors); die;
                        
                        
                                                $model->save();
                                                if(isset($_POST['zatgizi_id']))
                                                {
                                                    for($i=0;$i<count($_POST['zatgizi_id']);$i++){
                                                        $models=new ZatBahanMakananM;
                                                        $idZatgizi = $_POST['zatgizi_id'][$i];
                                                        // $Kandunganbahan = $_POST['kandunganbahan'][$idZatgizi];
                                                        $models->zatgizi_id = $_POST['zatgizi_id'][$i];
                                                        $models->bahanmakanan_id = $model->bahanmakanan_id;
                                                        if (!empty($idZatgizi)){
                                                            $models->kandunganbahan = $_POST['kandunganbahan'][$idZatgizi];                                
                                                        }
                                                        if($models->validate())
                                                                $models->save();
                                                    } 
                                                }
                                                Yii::app()->user->setFlash('success', '<strong>Berhasil!!</strong> Data berhasil disimpan.');
                                                $this->redirect(array('admin','tab'=>'frame'));
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
	{   $this->layout = '//layouts/iframe';
                $zatgizi = "";
		$model=BahanmakananM::model()->findByPK($id);
                                $modZatBahanMakananM=ZatBahanMakananM::model()->findAllByAttributes(array('bahanmakanan_id'=>$model->bahanmakanan_id));
                                foreach ($modZatBahanMakananM as $i=>$zat){
                                        $zatgizi[$zat->zatgizi_id] = $zat->kandunganbahan;
                                        $models=ZatBahanMakananM::model()->findByPK($zatgizi[$zat->zatgizi_id]);
                                }

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['BahanmakananM']))
		{
			$model->attributes=$_POST['BahanmakananM'];
                        $model->tglkadaluarsabahan = MyFormatter::formatDateTimeForDb($model->tglkadaluarsabahan);
                        // var_dump($_POST); die;
			$model->save();
                        if(isset($_POST['zatgizi_id']))
                        {
                            ZatBahanMakananM::model()->deleteAllByAttributes(array(
                                'bahanmakanan_id'=>$model->bahanmakanan_id,
                            ));
                            for($i=0;$i<count($_POST['zatgizi_id']);$i++){
                                $models=  new ZatBahanMakananM;
                                $models->bahanmakanan_id = $model->bahanmakanan_id;
                                $idZatgizi = $_POST['zatgizi_id'][$i];
                                $models->zatgizi_id = $idZatgizi;
                                // $Kandunganbahan = $_POST['kandunganbahan'][$idZatgizi];
                                if (!empty($idZatgizi)) {
                                    $models->kandunganbahan = $_POST['kandunganbahan'][$idZatgizi];
                                }
                                var_dump($models->attributes);
                                $models->save();
                            } 
                        }
                        //die;
                        if($model->save())
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                                $this->redirect(array('admin','id'=>$model->bahanmakanan_id ,'tab'=>'frame'));
		}

		$this->render('update',array(
			'model'=>$model,
                                                'modZatBahanMakananM'=>$modZatBahanMakananM,
                                                'zatgizi'=>$zatgizi,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
				$id = $_POST['id'];
	            $bahanmenudiet = BahanMenuDietM::model()->findByAttributes(array('bahanmakanan_id'=>$id));
	            $anamesadiet = AnamesadietT::model()->findByAttributes(array('bahanmakanan_id'=>$id));
	            $zatbahanmakanan = ZatBahanMakananM::model()->findByAttributes(array('bahanmakanan_id'=>$id));
	            if($bahanmenudiet || $anamesadiet || $zatbahanmakanan){
	                    	echo CJSON::encode(array(
	                            	'status'=>'error',
	                            ));
	                        exit();
	            }else{
	                $this->loadModel($id)->delete();
	                if (Yii::app()->request->isAjaxRequest)
	                    {
	                        echo CJSON::encode(array(
	                            'status'=>'proses_form', 
	                            'div'=>"<div class='flash-success'>Data berhasil dihapus.</div>",
	                            ));
	                        exit;               
	                    }
	            }
	                    
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
        
         public function actionRemoveTemporary()
        {
                
            $id = $_POST['id'];   
            if(isset($_POST['id']))
            {
               $update = BahanmakananM::model()->updateByPk($id,array('bahanmakanan_aktif'=>false));
               if($update)
                {
                    if (Yii::app()->request->isAjaxRequest)
                    {
                        echo CJSON::encode(array(
                            'status'=>'proses_form', 
                            ));
                        exit;               
                    }
                }
            } else {
                    if (Yii::app()->request->isAjaxRequest)
                    {
                        echo CJSON::encode(array(
                            'status'=>'proses_form', 
                            ));
                        exit;               
                    }
            }

        }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('BahanmakananM');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                if (!isset($_GET['tab'])):
                    //$this->layout = '//layouts/column1';    
                    $this->redirect($this->createUrl('/gizi/BahanMakananM&modul_id',array('modul_id'=>Yii::app()->session['modul_id'])));
                else:
                    $this->layout = '//layouts/iframe';
                endif;
            
		$model=new BahanmakananM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['BahanmakananM']))
			$model->attributes=$_GET['BahanmakananM'];

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
		$model=BahanmakananM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='bahan-makanan-m-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

                public function actionPrint()
                {
                     
                    $model= new BahanmakananM;
                    $model->unsetAttributes();
                    if(isset($_GET['BahanmakananM']))
			$model->attributes=$_GET['BahanmakananM'];
                    $judulLaporan='Data Bahan Makanan';
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
                        $mpdf->Output($judulLaporan.'-'.date('Y/m/d').'.pdf','I');
                    }                       
                }
}


