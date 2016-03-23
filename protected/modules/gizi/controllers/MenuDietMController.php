<?php

class MenuDietMController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/iframe';
	public $defaultAction='admin';

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
		$model=new MenuDietM;
                $models=new ZatMenuDietM;

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['MenuDietM']))
		{
                    $model->attributes=$_POST['MenuDietM'];
                    if ($model->validate()){
                        $model->save();
                    }
                    if(isset($_POST['zatgizi_id']))
                    {
                        
                        for($i=0;$i<count($_POST['zatgizi_id']);$i++)
                        {
                            $models=new ZatMenuDietM;
                            $idZatgizi = $_POST['zatgizi_id'][$i];
                            $models->zatgizi_id = $_POST['zatgizi_id'][$i];
                            $models->menudiet_id = $model->menudiet_id;
                            if (!empty($idZatgizi)){
                               $models->kandunganmenudiet = $_POST['kandunganmenudiet'][$idZatgizi]; 
                            }
                            if($models->validate()){
                                $models->save();
                            }
                        }
                    }
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->redirect(array('admin'));
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
		$model=MenuDietM::model()->findByPK($id);
                $zatgizi = "";
                                $modZatMenuDietM=ZatMenuDietM::model()->findAllbyAttributes(array('menudiet_id'=>$model->menudiet_id));
                                //foreach ($modZatMenuDietM as $i=>$zat){
                                //    $zatgizi[$zat->zatgizi_id] = $zat->kandunganmenudiet;
                                //    $models=ZatMenuDietM::model()->findByPK($zatgizi[$zat->zatmenudiet_id]);
                                //}

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['MenuDietM']))
		{
                    $model->attributes=$_POST['MenuDietM'];
                    if ($model->validate()){
                        $model->save();
                    }
                    if(isset($_POST['zatgizi_id']))
                    {
                        ZatMenuDietM::model()->deleteAllByAttributes(array(
                            'menudiet_id'=>$model->menudiet_id
                        ));
                        for($i=0;$i<count($_POST['zatgizi_id']);$i++)
                        {
                            $models=new ZatMenuDietM;
                            $idZatgizi = $_POST['zatgizi_id'][$i];
                            $models->zatgizi_id = $_POST['zatgizi_id'][$i];
                            $models->menudiet_id = $model->menudiet_id;
                            if (!empty($idZatgizi)){
                               $models->kandunganmenudiet = $_POST['kandunganmenudiet'][$idZatgizi]; 
                            }
                            if($models->validate()){
                                $models->save();
                            }
                        }
                    }
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->redirect(array('admin'));
		}

		$this->render('update',array(
			'model'=>$model,
                                                'modZatMenuDietM'=>$modZatMenuDietM,
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
	            $zatmenudiet = ZatMenuDietM::model()->findByAttributes(array('menudiet_id'=>$id));
	            $anamesadiet = AnamesadietT::model()->findByAttributes(array('menudiet_id'=>$id));
	            $jadwalmakan = JadwalMakanM::model()->findByAttributes(array('menudiet_id'=>$id));
	            if($zatmenudiet || $anamesadiet || $jadwalmakan){
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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('MenuDietM');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new MenuDietM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MenuDietM']))
			$model->attributes=$_GET['MenuDietM'];

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
		$model=MenuDietM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='menu-diet-m-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
                public function actionPrint()
                {
                     
                    $model= new GZMenuDietM;
                    if(isset($_GET['MenuDietM']))
			$model->attributes=$_GET['MenuDietM'];
                    $judulLaporan='Data Menu Diet';
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
