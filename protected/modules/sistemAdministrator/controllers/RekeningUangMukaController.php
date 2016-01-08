<?php
class RekeningUangMukaController extends MyAuthController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column1';
	public $defaultAction = 'admin';
	public $path_view = 'sistemAdministrator.views.rekeningUangMuka.';

	public function actionCreate()
    {
		$model=new SARekeninguangmukaM; 
		$modTindakanRuangan = new SARekeninguangmukaM('search');
		$modTindakanRuangan->unsetAttributes();  
		$modTindakanRuangan->instalasi_id = 0; //default tidak muncul data
		if(Yii::app()->session['modul_id'] != Params::MODUL_ID_SISADMIN){
			$model->instalasi_id = Yii::app()->user->getState('instalasi_id');
			$model->instalasi_nama = Yii::app()->user->getState('instalasi_nama');
			$modTindakanRuangan->instalasi_id = Yii::app()->user->getState('instalasi_id');
		}
		if(isset($_GET['SARekeninguangmukaM'])){
            $modTindakanRuangan->attributes=$_GET['SARekeninguangmukaM'];
            $modTindakanRuangan->instalasi_id=$_GET['SARekeninguangmukaM']['instalasi_id'];
			$modTindakanRuangan->instalasi_nama=(isset($_GET['SARekeninguangmukaM']['instalasi_nama'])?$_GET['SARekeninguangmukaM']['instalasi_nama']:NULL);
			$modTindakanRuangan->nmrekening5=(isset($_GET['SARekeninguangmukaM']['nmrekening5'])?$_GET['SARekeninguangmukaM']['nmrekening5']:NULL);

        }
		
		if(Yii::app()->request->isPostRequest) { //submit by ajax
			$data['sukses']=0;
			$data['pesan']="";
			
			if(isset($_POST['SARekeninguangmukaM']))
			{
				$transaction = Yii::app()->db->beginTransaction();
				try {
					$loadTindakanRuangan = SARekeninguangmukaM::model()->findByAttributes(array('rekening5_id'=>$_POST['SARekeninguangmukaM']['rekening5_id'],'instalasi_id'=>$_POST['SARekeninguangmukaM']['instalasi_id']));
					if($loadTindakanRuangan){
						$data['sukses']=0;
						$data['pesan']="Tindakan ".$loadTindakanRuangan->rekening5->nmrekening5."sudah ada di ".$loadTindakanRuangan->instalasi->instalasi_nama."!";
					}else{
						$model = new SARekeninguangmukaM;
						$model->instalasi_id=$_POST['SARekeninguangmukaM']['instalasi_id'];
						$model->rekening5_id=$_POST['SARekeninguangmukaM']['rekening5_id'];
						if($model->save()){
							$transaction->commit();
							$data['sukses']=1;
							$data['pesan']="Tindakan ".$model->rekening5->rekening5_nama." di ".$model->instalasi->instalasi_nama." berhasil disimpan!";
						}else{
							$transaction->rollback();
							$data['sukses']=0;
							$data['pesan']="Data gagal disimpan! <br>".CHtml::errorSummary($model);
						}
					}
					
				}catch (Exception $exc){
					$transaction->rollback();
					$data['sukses']=0;
					$data['pesan'] = 'Data gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
				}

			}
			echo CJSON::encode($data);
			Yii::app()->end();
		}
		
		$this->render($this->path_view.'create',array(
			   'model'=>$model,
			   'modTindakanRuangan'=>$modTindakanRuangan,
        ));
    }
	
	
	public function actionAutocompleteTindakan(){
		if(Yii::app()->request->isAjaxRequest) {
			$returnVal = array();
			$term = isset($_GET['term']) ? $_GET['term'] : null;
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(nmrekening5)', strtolower($term), true);
			$criteria->compare('LOWER(kdrekening5)', strtolower($term), true, 'OR');
			$criteria->order = 'nmrekening5';
			$criteria->limit = 5;

			$models = Rekening5M::model()->findAll($criteria);
			foreach($models as $i=>$model)
			{
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->kdrekening5." ".$model->nmrekening5;
				$returnVal[$i]['value'] = $model->nmrekening5;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}
    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($idRuangan,$idTindakan)
    {
        $modKasusPenyakitRuangan=array();
        $this->render($this->path_view.'view',array(
            'model'=>InstalasiM::model()->findByPk($idRuangan),
            'modKasusPenyakitRuangan'=>$modKasusPenyakitRuangan,
        ));
    }
    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            // we only allow deletion via POST request
			$transaction = Yii::app()->db->beginTransaction();
			try {
			   SARekeninguangmukaM::model()->deleteAllByAttributes(array('instalasi_id'=>$_GET['instalasi_id'], 'rekening5_id'=>$_GET['rekening5_id']));
			   $transaction->commit();
			}   
			catch (Exception $e)
				{
					$transaction->rollback();
					Yii::app()->user->setFlash('error', "Data Ruangan Dan Jenis Kasus Penyakit Gagal Disimpan");
				}   
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new SARekeninguangmukaM('search');
		$model->unsetAttributes();  // clear any default values
		if(Yii::app()->session['modul_id'] != Params::MODUL_ID_SISADMIN){
			$model->instalasi_id = Yii::app()->user->getState('instalasi_id');
		}
        if(isset($_GET['SARekeninguangmukaM'])){
            $model->attributes=$_GET['SARekeninguangmukaM'];
			$model->instalasi_nama=$_GET['SARekeninguangmukaM']['instalasi_nama'];
            $model->nmrekening5=$_GET['SARekeninguangmukaM']['nmrekening5'];
        }
            
        $this->render($this->path_view.'admin',array(
            'model'=>$model,
        ));
    }
}