<?php
class InformasiStrukturOrganisasiController extends MyAuthController
{
    public $layout='//layouts/column1';
    public $defaultAction = 'index';

    public function actionIndex(){
		
        $model = new KPOrganigramM;
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        
        if (isset($_GET['KPOrganigramM'])){
            $model->attributes = $_GET['KPOrganigramM'];            
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['KPOrganigramM']['tgl_awal']); 
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['KPOrganigramM']['tgl_akhir']);             
            $model->nama_pegawai = $_GET['KPOrganigramM']['nama_pegawai'];             
            $model->nomorindukpegawai = $_GET['KPOrganigramM']['nomorindukpegawai'];                         
        }
        
        $this->render('index',array('model'=>$model));
    }
    
    public function actionPrint() {
        $this->layout = '//layouts/iframe';
                if(isset($_GET['caraPrint'])){
			$this->layout = '//layouts/printWindows';
		}else{
			$this->layout = '//layouts/iframePolos';
		}
		$criteria = new CDbCriteria();
		$criteria->addCondition("organigram_aktif = TRUE");
		$criteria->order = "organigram_id ASC";
		$modOrganigrams = KPOrganigramM::model()->findAll($criteria);
		
		$this->render('organigram',array(
				'modOrganigrams'=>$modOrganigrams,
		));
    }

    
    
  
}