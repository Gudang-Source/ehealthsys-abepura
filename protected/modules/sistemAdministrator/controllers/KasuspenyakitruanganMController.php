<?php

class KasuspenyakitruanganMController extends MyAuthController
{
    
	public $layout = '//layouts/column1';
	public $defaultAction = 'admin';
	public $path_view = 'sistemAdministrator.views.kasuspenyakitruanganM.';

	public function actionIndex()
	{
		$this->render('index');
	}
        
	public function actionAdmin()
	{
		$model = new SAKasuspenyakitruanganM('search');
		$model->unsetAttributes();
		if (isset($_GET['SAKasuspenyakitruanganM']))
			$model->attributes = $_GET['SAKasuspenyakitruanganM'];
		
		$this->render($this->path_view.'admin',array('model'=>$model));
	}
        
	public function actionCreate()
	{
		$model = new SAKasuspenyakitruanganM;
		$ruangansession = Yii::app()->user->ruangan_id;
		$modDetails = array();
		
		if(isset($_POST['jeniskasuspenyakit_id']))
		{
			$modDetails = $this->validasiTabular($_POST['jeniskasuspenyakit_id']);
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$jumlah = 0;
				for($i=0;$i<COUNT($_POST['jeniskasuspenyakit_id']);$i++)
				{
					$model = new SAKasuspenyakitruanganM;
					$model->ruangan_id = $_POST['ruangan_id'][$i];
					$model->jeniskasuspenyakit_id = $_POST['jeniskasuspenyakit_id'][$i];
					if ($model->save()){
						$jumlah++;
					}else{
					}
				}

				if ($jumlah == count($_POST['jeniskasuspenyakit_id'])){
					$transaction->commit();
					Yii::app()->user->setFlash('success','<strong>Berhasil</strong>Data Berhasil disimpan');
					$this->redirect(array('admin','sukses'=>1));
				}
				else{
					$transaction->rollback();
				}
			}
			catch(Exception $ex){
				$transaction->rollback();
				Yii::app()->user->setFlash('error', '<strong>Gagal</strong>Data Gagal disimpan'.MyExceptionMessage::getMessage($ex));
			}                     
		}

		$this->render($this->path_view.'create',array('model'=>$model, 'modDetails'=>$modDetails));
	}

	protected function validasiTabular($data){
		foreach ($data as $i=>$row){
			$modDetails[$i] = new SAKasuspenyakitruanganM();
			$modDetails[$i]->ruangan_id = Yii::app()->user->getState('ruangan_id');
			$modDetails[$i]->jeniskasuspenyakit_id = $row;
			$modDetails[$i]->validate();
		}

		return $modDetails;
	}

	public function actionUpdate()
	{
		$model = new SAKasuspenyakitruanganM;
		$ruangansession = Yii::app()->user->ruangan_id;
		$modDetails = array();
		
		if(isset($_POST['jeniskasuspenyakit_id']))
		{
			$modDetails = $this->validasiTabular($_POST['jeniskasuspenyakit_id']);
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$jumlah = 0;
				for($i=0;$i<COUNT($_POST['jeniskasuspenyakit_id']);$i++)
				{
					$model = new SAKasuspenyakitruanganM;
					$model->ruangan_id = $_POST['ruangan_id'][$i];
					$model->jeniskasuspenyakit_id = $_POST['jeniskasuspenyakit_id'][$i];
					if ($model->save()){
						$jumlah++;
					}
				}

				if ($jumlah == count($_POST['jeniskasuspenyakit_id'])){
					$transaction->commit();
					Yii::app()->user->setFlash('success','<strong>Berhasil</strong>Data Berhasil disimpan');
					$this->redirect(array('admin','sukses'=>1));
				}
				else{
					$transaction->rollback();
				}
			}
			catch(Exception $ex){
				$transaction->rollback();
				Yii::app()->user->setFlash('error', '<strong>Gagal</strong>Data Gagal disimpan'.MyExceptionMessage::getMessage($ex));
			}                       
		}

		$this->render($this->path_view.'update',array('model'=>$model, 'modDetails'=>$modDetails));
	}

	public function actionDelete($ruangan_id, $jeniskasuspenyakit_id)
	{
		$this->loadModel($ruangan_id,$jeniskasuspenyakit_id)->delete();
		if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
                
	public function actionView($id)
	{
		$this->render($this->path_view.'view',array(
			'model'=>$this->loadModel($id),
		));
	}
        
	public function loadModel($id, $jeniskasus = null)
	{
		if (!empty($jeniskasus)){
			$model=SAKasuspenyakitruanganM::model()->findByAttributes(array('ruangan_id'=>$id, 'jeniskasuspenyakit_id'=>$jeniskasus));
		}
		else{
			$model=SAKasuspenyakitruanganM::model()->findByAttributes(array('ruangan_id'=>$id));
		}
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
                
	public function actionPrint()
	{
		$model= new SAKasuspenyakitruanganM;
		$model->unsetAttributes();
		if(isset($_REQUEST['SAKasuspenyakitruanganM'])){
			$model->attributes=$_REQUEST['SAKasuspenyakitruanganM'];
		}
		$judulLaporan='Data Kasus Penyakit Ruangan';
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
			$mpdf->Output($judulLaporan.'-'.date("Y/m/d").'.pdf', 'I');
		}
	}
	
	public function actionJeniskasuspenyakitruangan()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $instalasi_id = isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null;
            $ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null;
            $jeniskasuspenyakit_id = isset($_POST['jeniskasuspenyakit_id']) ? $_POST['jeniskasuspenyakit_id'] : null;
            
            $modInstalasi = InstalasiM::model()->findByPK($instalasi_id);
            $modRuangan = RuanganM::model()->findByPK($ruangan_id);
            
            $modJeniskasuspenyakitruangan = new SAKasuspenyakitruanganM();
            $modJeniskasuspenyakit = JeniskasuspenyakitM::model()->findByPk($jeniskasuspenyakit_id);
                $tr = "<tr>";
                $tr .= "<td>"
						.$modInstalasi->instalasi_nama
						.CHtml::hiddenField('ruangan_id[]',$ruangan_id,array('readonly'=>true))
						.CHtml::hiddenField('jeniskasuspenyakit_id[]',$jeniskasuspenyakit_id,array('readonly'=>true))."</td>";
                $tr .= "<td>".$modRuangan->ruangan_nama."</td>";
                $tr .= "<td>".$modJeniskasuspenyakit->jeniskasuspenyakit_nama."</td>";
                $tr .= "<td>".$modJeniskasuspenyakit->jeniskasuspenyakit_namalainnya."</td>";
                $tr .= "<td>".CHtml::link("<i class='icon-form-silang'></i>", '#', array('onclick'=>'hapusBaris(this); return false;'))."</td>";
                $tr .= "</tr>";

           $data['tr']=$tr;
           echo json_encode($data);
         Yii::app()->end();
        }
    }
}