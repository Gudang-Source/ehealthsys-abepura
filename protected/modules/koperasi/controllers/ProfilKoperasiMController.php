<?php

class ProfilKoperasiMController extends MyAuthController
{
	/**
	* @var string the default layout for the views. Defaults to '//layouts/admin/default', meaning
	* using two-column layout. See 'protected/views/layouts/admin/default.php'.
	*/
	public $layout='//layouts/column1';
	public $defaultAction = 'admin';
	// $menuActive = array(index menu,index sub menu);
	// index menu dan sub menu dapat di lihat di Params.php -> function menu()
	

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
		$model = new ProfilkoperasiM;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['KOProfilkoperasiM']))
		{
			$model->attributes=$_POST['KOProfilkoperasiM'];
			$model->path_valuesimage1 = CUploadedFile::getInstance($model, 'path_valuesimage1');
			$model->path_valuesimage2 = CUploadedFile::getInstance($model, 'path_valuesimage2');
			$model->path_valuesimage3 = CUploadedFile::getInstance($model, 'path_valuesimage3');
                        if($model->save()){
                            if (isset($model->path_valuesimage1))
                                    $model->path_valuesimage1->saveAs('' .Params::pathProfilGambar().$model->path_valuesimage1);
	                            if (isset($model->path_valuesimage2))
	                                    $model->path_valuesimage2->saveAs('' .Params::pathProfilGambar().$model->path_valuesimage2);
                            if (isset($model->path_valuesimage3))
                                    $model->path_valuesimage3->saveAs('' .Params::pathProfilGambar().$model->path_valuesimage3);
                        }
                        $this->redirect(array('admin','status'=>1));
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
		$temp_path_valuesimage1 = $model->path_valuesimage1;
		$temp_path_valuesimage2 = $model->path_valuesimage2;
		$temp_path_valuesimage3 = $model->path_valuesimage3;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ADProfilS']))
		{
			$model->attributes=$_POST['ADProfilS'];
			$model->path_valuesimage1 = CUploadedFile::getInstance($model, 'path_valuesimage1');
			$model->path_valuesimage2 = CUploadedFile::getInstance($model, 'path_valuesimage2');
			$model->path_valuesimage3 = CUploadedFile::getInstance($model, 'path_valuesimage3');

                if (!isset($model->path_valuesimage1)) {
                	$model->path_valuesimage1 = $temp_path_valuesimage1;
                }
            if (!isset($model->path_valuesimage2)) {
                $model->path_valuesimage2 = $temp_path_valuesimage2;
            }
                if (!isset($model->path_valuesimage3)) {
                	$model->path_valuesimage3 = $temp_path_valuesimage3;
                }
						if($model->save()){

                            if (isset($model->path_valuesimage1) && ($model->path_valuesimage1 != $temp_path_valuesimage1)) {
                                $model->path_valuesimage1->saveAs('' .Params::pathProfilGambar(). $model->path_valuesimage1);
                            }
	                            if (isset($model->path_valuesimage2) && ($model->path_valuesimage2 != $temp_path_valuesimage2)) {
	                                $model->path_valuesimage2->saveAs('' .Params::pathProfilGambar(). $model->path_valuesimage2);
	                            }
							if (isset($model->path_valuesimage3) && ($model->path_valuesimage3 != $temp_path_valuesimage3)) {
	                        	$model->path_valuesimage3->saveAs('' .Params::pathProfilGambar(). $model->path_valuesimage3);
	                        }
                        }
                        $this->redirect(array('admin','status'=>1));
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
		$dataProvider=new CActiveDataProvider('ADProfilS');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	* Manages all models.
	*/
	public function actionAdmin()
	{
            $model = ProfilkoperasiM::model()->findByPk(Params::DEFAULT_PROFILKOPERASI);
                    if (empty($model->profilkoperasi_id)){
                        $this->redirect(array('create'));
                    }else{
                        $this->redirect(array('update','id'=>$model->profilkoperasi_id));
                    }

	}

	/**
	* Returns the data model based on the primary key given in the GET variable.
	* If the data model is not found, an HTTP exception will be raised.
	* @param integer the ID of the model to be loaded
	*/
	public function loadModel($id)
	{
		$model=ADProfilS::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='adprofil-s-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
