<?php
Yii::import('rawatInap.models.*');
class ImplementasikeperawatanMController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/iframe';
	public $defaultAction = 'admin';
	public $path_view = 'sistemAdministrator.views.implementasikeperawatanM.';
	public $path_views = 'sistemAdministrator.views.';
        public $hasTab = false;
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
        
        public function init() {
            parent::init();
            if ($this->hasTab) $this->layout = '//layouts/iframe';
        }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
                 //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                                             
		if (isset($_POST['ax'])) {
                    if (isset($_POST['param'])) {
                        call_user_func(array($this, $_POST['f']), $_POST['param']);
                    } else {
                        call_user_func(array($this, $_POST['f']));
                    }
                    Yii::app()->end();
                }
                 
                $model=new ImplementasikeperawatanM;

		// Uncomment the following line if AJAX validation is needed
		

		  if(isset($_POST['ImplementasikeperawatanM']))
                    {
                        $valid=true;
                        foreach($_POST['ImplementasikeperawatanM'] as $i=>$item)
                        {
                            if(is_integer($i)) {
                                $model=new ImplementasikeperawatanM;
                                if(isset($_POST['ImplementasikeperawatanM'][$i]))
                                    
                                    $model->attributes=$_POST['ImplementasikeperawatanM'][$i];
                                    //$model->lookup_id = $_POST['LookupM']['lookup_id'];
                                    //$model->diagnosakeperawatan_kode = $_POST['DiagnosakeperawatanM']['diagnosakeperawatan_kode'];
                                    $model->diagnosakeperawatan_id = $_POST['ImplementasikeperawatanM']['diagnosakeperawatan_id'];
                                    $valid=$model->validate() && $valid;

                                if($valid) {
                                    $model->save();
                                        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                                } else {
                                        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data tidak valid.');
                                }
                            }
                        }
                        $this->redirect(array('admin'));
                      }   

		$this->render($this->path_view.'create',array(
			'model'=>$model,
		));
	}

        protected function setDropRencana($param) {
            $id = $param['id'];
            $ren = RencanakeperawatanM::model()->findAllByAttributes(array(
                'diagnosakeperawatan_id'=>$id,
            ));
            
            $res = "";
            
            $res .= '<option value="">-- Pilih --</option>';
            foreach ($ren as $item) {
                $res .= '<option value="'.$item->rencanakeperawatan_id.'">'.$item->rencana_intervensi.'</option>';
            }
            
            echo CJSON::encode(array('html'=>$res));
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
                $modImplementasiKeperawatan = ImplementasikeperawatanM::model()->findAllByAttributes(array('diagnosakeperawatan_id'=>$model->diagnosakeperawatan_id));
				$modDiagnosakeperawatan = SADiagnosakeperawatanM::model()->findByPk($model->diagnosakeperawatan_id);
		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['SAImplementasikeperawatanM']))
                    {
                        var_dump($_POST);
                        $ok = true;
                        $trans = Yii::app()->db->beginTransaction();
                        $sub = ImplementasikeperawatanM::model()->findByPk($_POST['ImplementasikeperawatanM'][0]['implementasikeperawatan_id']);
                        foreach ($_POST['ImplementasikeperawatanM'] as $item) {
                            $model = new ImplementasikeperawatanM;
                            $model->diagnosakeperawatan_id = $sub->diagnosakeperawatan_id;
                            
                            if (!empty($item['implementasikeperawatan_id'])) {
                                $model = ImplementasikeperawatanM::model()->findByPk($item['implementasikeperawatan_id']);
                            }
                            
                            $model->attributes = $item;
                            if ($model->iskolaborasiimplementasi == 1) $model->iskolaborasiimplementasi = true;
                            else $model->iskolaborasiimplementasi = false;
                            
                            //var_dump($model->validate());
                            //var_dump($model->errors);
                            
                            //var_dump($model->attributes);
                            
                            if ($model->validate()) {
                                $ok = $ok && $model->save();
                            } else $ok = false;
                        }
                        //var_dump($ok); die;
                        
                        if ($ok) {
                            $trans->commit();
                            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                        } else {
                            $trans->rollback();
                            Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data tidak valid.');
                        }
                        
                        $this->redirect(array('admin'));
                        /*
                        var_dump($_POST); die;
                        $valid=true;
                        foreach($_POST['ImplementasikeperawatanM'] as $i=>$item)
                        {
                            if(is_integer($i)) {

                                if(!empty($_POST['ImplementasikeperawatanM'][$i]['implementasikeperawatan_id'])){
                                        $model = ImplementasikeperawatanM::model()->findByPk($_POST['ImplementasikeperawatanM'][$i]['implementasikeperawatan_id']);
                                        $model->implementasikeperawatan_id = $_POST['ImplementasikeperawatanM'][$i]['implementasikeperawatan_id'];
                                }else{
                                    $model=new ImplementasikeperawatanM;
                                }
                                if(isset($_POST['ImplementasikeperawatanM'][$i]))
                                    // if ($_POST['RIImplementasikeperawatanM']['diagnosakeperawatan_id'] == 0){
                                    //     $_POST['RIImplementasikeperawatanM']['diagnosakeperawatan_id'] = null;
                                    // }
                                    $model->attributes=$_POST['ImplementasikeperawatanM'][$i];
                                    
                                    if (!empty($model->diagnosakeperawatan_id)){
                                        ImplementasikeperawatanM::model()->deleteByPk($model->diagnosakeperawatan_id);
                                        $model->diagnosakeperawatan_id = $model->diagnosakeperawatan_id;
                                    }
                                    if(!empty($_POST['ImplementasikeperawatanM'][$i]['rencanakeperawatan_id'])){
                                        $model->rencanakeperawatan_id = $_POST['ImplementasikeperawatanM'][$i]['rencanakeperawatan_id'];
                                    }
                                    
                                   	// echo $_POST['RIImplementasikeperawatanM'][$i]['implementasikeperawatan_kode'];exit();
                                    //$model->lookup_id = $_POST['LookupM']['lookup_id'];
                                    $model->implementasikeperawatan_kode = $_POST['ImplementasikeperawatanM'][$i]['implementasikeperawatan_kode'];
                                    $model->iskolaborasiimplementasi = $_POST['ImplementasikeperawatanM'][$i]['iskolaborasiimplementasi'];
                                   // $model->lookup_aktif = true;
                                    $valid=$model->validate() && $valid;

                                if($valid) {
                                    
                                    $model->save();
                                        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                                } else {
                                        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data tidak valid. hahaha');
                                }
                            } else {
                            	Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data tidak valid.');
                            }
                        }
                         * 
                         */

                        
                      }   

		$this->render($this->path_view.'update',array(
			'model'=>$model,
                        'modImplementasiKeperawatan'=>$modImplementasiKeperawatan,
                        'modDiagnosakeperawatan'=>$modDiagnosakeperawatan,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('SAImplementasikeperawatanM');
		$this->render($this->path_view.'index',array(
			'dataProvider'=>$dataProvider,
                        
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                
		$model=new SAImplementasikeperawatanM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SAImplementasikeperawatanM']))
			$model->attributes=$_GET['SAImplementasikeperawatanM'];

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
		$model=SAImplementasikeperawatanM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='saimplementasikeperawatan-m-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionDelete()
	{
		//if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		if(Yii::app()->request->isPostRequest)
		{
			$id = $_POST['id'];
            $this->loadModel($id)->delete();
            if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'proses_form', 
                        'div'=>"<div class='flash-success'>Data berhasil dihapus.</div>",
                        ));
                    exit;
                }
	                    
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

     /**
     *Mengubah status aktif
     * @param type $id 
     */
    public function actionRemoveTemporary()
    {
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
//                    SAPropinsiM::model()->updateByPk($id, array('propinsi_aktif'=>false));
//                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
              
        
        $id = $_POST['id'];   
        if(isset($_POST['id']))
        {
           $update = ImplementasikeperawatanM::model()->updateByPk($id,array('iskolaborasiimplementasi'=>false));
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
        
       public function actionPrint()
                {
                    
                    $model= new SAImplementasikeperawatanM;
                    $model->attributes=$_REQUEST['SAImplementasikeperawatanM'];
                    $judulLaporan='Data Implementasi Keperawatan';
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
                }}
