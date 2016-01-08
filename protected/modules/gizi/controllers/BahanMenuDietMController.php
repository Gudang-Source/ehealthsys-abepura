<?php

class BahanMenuDietMController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
                public $defaultAaction='admin';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	

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
        
        public function actionGetBahanMenuDiet()
        {
           if(Yii::app()->request->isAjaxRequest)
               { 
                    $menudiet_id=$_POST['menudiet_id'];
                    $bahanmakanan_id = $_POST['bahanmakanan_id'];
                    $jmlbahan = $_POST['jmlbahan'];
                    $satuan = $_POST['satuan'];
                    $modBahanMenuDiet = new BahanMenuDietM;
                    $modMenuDiet = MenuDietM::model()->findByPk($menudiet_id);
                    $modBahanMakanan=BahanmakananM::model()->findByPK($bahanmakanan_id);
                    $return = array();
                        $tr = "";
                        $tr .="<tr><td>";
                        $tr .= CHtml::checkBox('checkList[]',true,array('class'=>'cekList', 'onkeypress'=>"return $(this).focusNextInputField(event);"));
                        $tr .= "</td><td>";
                        $tr .= $modMenuDiet->menudiet_nama;
                        $tr .= CHtml::hiddenField('menudiet_id[]',$modMenuDiet->menudiet_id);
                        $tr .= CHtml::hiddenField('bahanmakanan_id[]',$modBahanMakanan->bahanmakanan_id);
                        $tr .= "</td><td>";
                        $tr .= $modBahanMakanan->namabahanmakanan;
                        $tr .= "</td><td>";
                        $tr .= CHtml::textField('jmlbahan[]',$jmlbahan, array('onkeypress'=>"return $(this).focusNextInputField(event);"));
                        $tr .="</td><td>";
                        $tr .= $satuan;
                        $tr .="</td>";
                        $tr .= "</tr>";   
                    $return .= $tr;
                   $data['return']=$return;
                   echo json_encode($data);
                 Yii::app()->end();
            }    
        } 
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new BahanMenuDietM;

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['menudiet_id']))
		{
			// $model->attributes=$_POST['BahanMenuDietM'];
	            for($i=0;$i<COUNT($_POST['menudiet_id']);$i++)
	            {
	                $model=new BahanMenuDietM;
	                $menu = $_POST['menudiet_id'][$i];
	                $model->menudiet_id=$menu;
	                $model->bahanmakanan_id=$_POST['bahanmakanan_id'][$i];
	                $model->jmlbahan=$_POST['jmlbahan'][$i];
	                if($model->save()){
		                Yii::app()->user->setFlash('success','<strong>Berhasil</strong> Data berhasil disimpan');
						$this->redirect(array('admin'));
					} else {
						Yii::app()->user->setFlash('error','<strong>Gagal</strong> Data gagal disimpan');
					}
	            }
			$this->redirect(array('admin','id'=>$model->bahanmenudiet_id));
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
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['bahanmenudiet_id']))
		{
                                                for($i=0;$i<COUNT($_POST['bahanmenudiet_id']);$i++)
                                                {
                                                     $id = $_POST['bahanmenudiet_id'][$i];
                                                     $model = $this->loadModel($id);
                                                     $model->jmlbahan = $_POST['jmlbahan'][$id];
                                                     $model->save();
                                                }
			$this->redirect(array('admin','id'=>$model->bahanmenudiet_id));
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
		$dataProvider=new CActiveDataProvider('BahanMenuDietM');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new BahanMenuDietM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['BahanMenuDietM']))
			$model->attributes=$_GET['BahanMenuDietM'];

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
		$model=BahanMenuDietM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='bahan-menu-diet-m-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
                public function actionPrint()
                {
                     
                    $model= new GZBahanMenuDietM;
                    if(isset($_GET['BahanMenuDietM']))
			$model->attributes=$_GET['BahanMenuDietM'];
                    $judulLaporan='Data Bahan Menu Diet';
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
