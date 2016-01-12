
<?php

class MasterOrganigramController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $path_view = 'sistemAdministrator.views.masterOrganigram.';

	/**
	 * Menampilkan detail data.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->layout = "//layouts/iframe";
		$model = $this->loadModel($id);
		$this->render($this->path_view.'view',array(
				'model'=>$model,
		));
	}

	/**
	 * Membuat dan menyimpan data baru.
	 */
	public function actionIndex($id = null)
	{
		$format = new MyFormatter();
		$model=new SAOrganigramM;
		if(!empty($id)){
			$model=SAOrganigramM::model()->findByPk($id);
		}
		
		if(isset($_POST['SAOrganigramM']))
		{
			$model->attributes = $_POST['SAOrganigramM'];
			$model->organigram_periode = empty($model->organigram_periode) ? null : $format->formatDateTimeForDb($model->organigram_periode);
			$model->organigram_sampaidengan = empty($model->organigram_sampaidengan) ? null : $format->formatDateTimeForDb($model->organigram_sampaidengan);
			
			$model->create_time = date("Y-m-d H:i:s");
			$model->create_ruangan = Yii::app()->user->getState('ruangan_id');
			$model->create_loginpemakai_id = Yii::app()->user->id;
			
			if($model->save()){
				$this->redirect(array('index','sukses'=>1));
			}
		}

		$this->render($this->path_view.'index',array(
			'model'=>$model,
		));
	}

	    /*
		 * get data pegawai jabatan berdasarkan 
		 */
		public function actionGetDataPegawaiJabatan()
	    {
	        if(Yii::app()->request->isAjaxRequest){
	            $data = SAPegawaijabatanR::model()->findByAttributes(array('pegawai_id'=>$_POST['idPegawai']));
	            $post = array(
	                'nomorkeputusanjabatan'=>$data->nomorkeputusanjabatan,
	            );
	            echo CJSON::encode($post);
	            Yii::app()->end();
	        }
	    }
	
	/**
	 * menampilkan data pegawai
	 */
	public function actionAutocompletePegawai()
    {
            if(Yii::app()->request->isAjaxRequest) {
                $format = new MyFormatter();
                $returnVal = array();
                $term = isset($_GET['term']) ? $_GET['term'] : null;
                
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(nama_pegawai)', strtolower($term), true);
                $criteria->compare('LOWER(nomorindukpegawai)', strtolower($term), true, "OR");
                $criteria->compare('LOWER(gelardepan)', strtolower($term), true, "OR");
				if(isset($_GET['jabatan_id'])){
					if(!empty($_GET['jabatan_id'])){
						$criteria->addCondition("jabatan_id = ".$_GET['jabatan_id']);
					}
				}
                $criteria->addCondition('pegawai_aktif = TRUE');
                $criteria->limit = 5;
                $models = SAPegawaiM::model()->findAll($criteria);
                foreach($models as $i=>$model){
                    $returnVal[$i] = $model->attributes;
                    if(isset($model->jabatan)){
						$returnVal[$i] = $model->jabatan->attributes;
					}
                    $returnVal[$i]['label'] = $model->gelardepan.' '.$model->nama_pegawai.' '.(isset($model->gelarbelakang->gelarbelakang_nama) ? $model->gelarbelakang->gelarbelakang_nama : "")."-".$model->nomorindukpegawai;
                    $returnVal[$i]['value'] = $model->pegawai_id;
                }

                echo CJSON::encode($returnVal);
            }else
                throw new CHttpException(403,'Tidak dapat mengurai data');
            Yii::app()->end();
    }
	
	/**
	 * menampilkan data organigram untuk dipilih atasannya
	 */
	public function actionAutocompleteAtasan()
    {
            if(Yii::app()->request->isAjaxRequest) {
                $format = new MyFormatter();
                $returnVal = array();
                $term = isset($_GET['term']) ? $_GET['term'] : null;
                
                $criteria = new CDbCriteria();
				$criteria->with=array('pegawai');
                $criteria->compare('LOWER(pegawai.nama_pegawai)', strtolower($term), true);
                $criteria->compare('LOWER(pegawai.nomorindukpegawai)', strtolower($term), true, "OR");
                $criteria->compare('LOWER(pegawai.gelardepan)', strtolower($term), true, "OR");
                $criteria->compare('LOWER(t.organigram_unitkerja)', strtolower($term), true, "OR");
				if(isset($_GET['organigram_id'])){
					if(!empty($_GET['organigram_id'])){
						$criteria->addCondition("t.organigram_id <> ".$_GET['organigram_id']);
					}
				}
                $criteria->limit = 5;
                $models = SAOrganigramM::model()->findAll($criteria);
                foreach($models as $i=>$model){
                    $returnVal[$i] = $model->attributes;
					if(isset($model->pegawai)){
						$returnVal[$i] = $model->pegawai->attributes;
					}
                    
					if(isset($model->pegawai)){
						$returnVal[$i]['label'] = $model->pegawai->gelardepan.' '.$model->pegawai->nama_pegawai.' '.(isset($model->pegawai->gelarbelakang->gelarbelakang_nama) ? $model->pegawai->gelarbelakang->gelarbelakang_nama : "")."-".$model->pegawai->nomorindukpegawai;
					}else{
						$returnVal[$i]['label'] = $returnVal[$i]['organigram_unitkerja'];
					}
					$returnVal[$i]['value'] = $model->organigram_id;
                }

                echo CJSON::encode($returnVal);
            }else
                throw new CHttpException(403,'Tidak dapat mengurai data');
            Yii::app()->end();
    }

	/**
	 * Memanggil dan Mengubah sebagian data.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$format = new MyFormatter;
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['SAOrganigramM']))
		{
			$model->attributes=$_POST['SAOrganigramM'];
			
			$model->organigram_periode = empty($model->organigram_periode) ? null : $format->formatDateTimeForDb($model->organigram_periode);
			$model->organigram_sampaidengan = empty($model->organigram_sampaidengan) ? null : $format->formatDateTimeForDb($model->organigram_sampaidengan);
			
			$model->update_time = date("Y-m-d H:i:s");
			$model->update_loginpemakai_id = Yii::app()->user->id;
			
			if($model->save()){
				$this->redirect(array('index','sukses'=>1));
			}
		}

		$this->render($this->path_view.'update',array(
				'model'=>$model,
		));
	}

	/**
	 * Memanggil dan Menghapus data.
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
	 * Memanggil dan menonaktifkan status 
	 */
	public function actionNonActive($id)
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			$data['sukses']=0;
			$model = $this->loadModel($id);
			if($model->organigram_aktif)
				$model->organigram_aktif = false;
			else
				$model->organigram_aktif = true;
			
			if($model->save()){
			   $data['sukses'] = 1;
			}
			echo CJSON::encode($data); 
		}
	}

	/**
	 * Pengaturan data.
	 */
	public function actionAdmin()
	{
		$this->layout = "//layouts/iframe";
		$model=new SAOrganigramM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SAOrganigramM'])){
			$model->attributes=$_GET['SAOrganigramM'];
			$model->atasan=$_GET['SAOrganigramM']['atasan'];
			$model->nama_pegawai=$_GET['SAOrganigramM']['nama_pegawai'];
			$model->jabatan_nama=$_GET['SAOrganigramM']['jabatan_nama'];
		}
		$this->render($this->path_view.'admin',array(
				'model'=>$model,
		));
	}

	/**
	 * menampilkan organigram
	 */
	public function actionOrganigram()
	{
		if(isset($_GET['caraPrint'])){
			$this->layout = '//layouts/printWindows';
		}else{
			$this->layout = '//layouts/iframePolos';
		}
		$criteria = new CDbCriteria();
		$criteria->addCondition("organigram_aktif = TRUE");
		$criteria->order = "organigram_id ASC";
		$modOrganigrams = SAOrganigramM::model()->findAll($criteria);
		
		$this->render($this->path_view.'organigram',array(
				'modOrganigrams'=>$modOrganigrams,
		));
	}
	/**
	 * menampilkan list
	 */
	public function actionList()
	{
		$this->layout = "//layouts/iframe";
		$model=new SAOrganigramM('search');
		
		$this->render($this->path_view.'list',array(
				'model'=>$model,
		));
	}
	
	/**
	 * Memanggil data dari model.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=SAOrganigramM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='kporganigram-m-form')
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
		$model= new SAOrganigramM;
		$model->attributes=$_REQUEST['SAOrganigramM'];
		$judulLaporan='Data SAOrganigramM';
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
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('',$ukuranKertasPDF); 
			$mpdf->useOddEven = 2;  
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);  
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}
	}
}
