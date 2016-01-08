<?php
Yii::import('rawatJalan.models.*');
class InformasiDaftarPasienRujukanKeluarController extends MyAuthController
{
	public $defaultAction = 'index';
    public $path_view = 'mcu.views.informasiDaftarPasienRujukanKeluar.';    
	
	public function actionIndex()
	{
		$model = new MCPasiendirujukkeluarT('searchDaftarPasienRujukan');
		$model->unsetAttributes();
		$model->tgl_awal = date('Y-m-d');
		$model->tgl_akhir = date('Y-m-d');
		if(isset($_GET['MCPasiendirujukkeluarT'])){
			$model->attributes = $_GET['MCPasiendirujukkeluarT'];
			$format = new MyFormatter();
			$model->tgl_awal  = $format->formatDateTimeForDb($_REQUEST['MCPasiendirujukkeluarT']['tgl_awal']);
			$model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['MCPasiendirujukkeluarT']['tgl_akhir']);
			$model->no_pendaftaran = $_REQUEST['MCPasiendirujukkeluarT']['no_pendaftaran'];
			$model->no_rekam_medik = $_REQUEST['MCPasiendirujukkeluarT']['no_rekam_medik'];
			$model->nama_pasien = $_REQUEST['MCPasiendirujukkeluarT']['nama_pasien'];
			$model->statusperiksa = $_REQUEST['MCPasiendirujukkeluarT']['statusperiksa'];
			$model->nama_pegawai = $_REQUEST['MCPasiendirujukkeluarT']['nama_pegawai'];
		}

		if (Yii::app()->request->isAjaxRequest) {
			echo $this->renderPartial('_tablePasien', array('model'=>$model));
		}else{
			$this->render('index',array('model'=>$model));
		}
	}
	
	/**
	* untuk Ubah Dokter
	*/
   public function actionUbahDokterPeriksa($pendaftaran_id = null, $pasiendirujukkeluar_id = null)
   {	   
		$this->layout='//layouts/iframe';
		$format = new MyFormatter();
		$modPendaftaran = MCPendaftaranT::model()->findByPk($pendaftaran_id);
		$modPasien = MCPasienM::model()->findByPk($modPendaftaran->pasien_id);
		$pasiendirujukkeluar_id  = isset($pasiendirujukkeluar_id) ? $pasiendirujukkeluar_id : null;
		$model = MCPasiendirujukkeluarT::model()->findByPk($pasiendirujukkeluar_id);
		$model->rumahsakitrujukan = $model->rujukankeluar->rumahsakitrujukan;
		$model->tgldirujuk = $format->formatDateTimeForUser($model->tgldirujuk);
		if(count($model) <= 0){
			$model = new MCPasiendirujukkeluarT();
		}
		if(isset($_POST['MCPasiendirujukkeluarT']))
		{
			$model->attributes = $_POST['MCPasiendirujukkeluarT'];
			$format = new MyFormatter();
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$attributes = array(
						'dokterpemeriksa'=>$_POST['MCPasiendirujukkeluarT']['dokterpemeriksa']
				  );

				$save = MCPasiendirujukkeluarT::model()->updateByPk($_POST['MCPasiendirujukkeluarT']['pasiendirujukkeluar_id'],$attributes);

				if($save)
				{
					$transaction->commit();
					Yii::app()->user->setFlash('success',"Data Dokter Pemeriksa berhasil diubah");              
					$this->redirect(array('UbahDokterPeriksa','pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'pasiendirujukkeluar_id'=>$model->pasiendirujukkeluar_id,'sukses'=>1));
				}else{
					$transaction->rollback();
					Yii::app()->user->setFlash('error',"Data gagal disimpan");               
				}

			}catch(Exception $exc) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error',"Data gagal disimpan");
			}

		}
		$this->render('_formUbahDokterPeriksa',array('modPasien'=>$modPasien,'modPendaftaran'=>$modPendaftaran,'model'=>$model));
   }
   
	/**
     * actionPrintDetailRincianBelumBayar 
     * @params $instalasi_id = RJ / RD / RI
     * @params $pendaftaran_id
     * @params $pasienadmisi_id (RI saja)
     */
    public function actionPrintDetailRincianBelumBayar($instalasi_id,$pendaftaran_id,$pasienadmisi_id=null){
        $this->layout='//layouts/printWindows';
        if (isset($_GET['frame'])){
            $this->layout='//layouts/iframe';
        }
		$model = new MCTindakanPelayananT();
		$modPendaftaran=PendaftaranT::model()->findByPk($pendaftaran_id);
        $modRincians = null;
        if($instalasi_id == Params::INSTALASI_ID_RJ){
            $criteria = new CDbCriteria();
            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
            $criteria->order = 'unitlayanan_nama, tgl_tindakan';
            $modRincians = MCRincianbelumbayarrjV::model()->findAll($criteria);
        }else if($instalasi_id == Params::INSTALASI_ID_RD){
            $criteria = new CDbCriteria();
            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
            $criteria->order = 'ruangantindakan_id';
            $modRincians = MCRincianbelumbayarrdV::model()->findAll($criteria);            
        }else if($instalasi_id == Params::INSTALASI_ID_RI){
            $criteria = new CDbCriteria();
            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
            $criteria->addCondition('pasienadmisi_id = '.$pasienadmisi_id);
            $criteria->order = 'ruangantindakan_id';
            $modRincians = MCRincianbelumbayarrawatinapV::model()->findAll($criteria);
        }
		
		if(isset($_POST['MCRincianbelumbayarrjV'])){
			$transaction = Yii::app()->db->beginTransaction();
			try {
				foreach($_POST['MCRincianbelumbayarrjV'] as $i=>$tindakan){
					$attributes = array(
						'qty_tindakan'=>$tindakan['qty_tindakan'],
						'tarif_satuan'=>$tindakan['tarif_satuan'],
						'tarif_tindakan'=>($tindakan['qty_tindakan'] * $tindakan['tarif_satuan'])
					);

					$save = MCTindakanPelayananT::model()->updateByPk($tindakan['tindakanpelayanan_id'],$attributes);

					
				}
				if($save)
				{
					$transaction->commit();
					Yii::app()->user->setFlash('success',"Data rincian tindakan berhasil diubah");              
					$this->redirect(array('PrintDetailRincianBelumBayar','instalasi_id'=>$modPendaftaran->instalasi_id,'pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'pasienadmisi_id'=>$modPendaftaran->pasienadmisi_id,'sukses'=>1));
				}else{
					$transaction->rollback();
					Yii::app()->user->setFlash('error',"Data gagal disimpan");               
				}
			}catch(Exception $exc) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error',"Data gagal disimpan");
			}
		}
		
		$modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $this->render($this->path_view.'printDetailRincianBelumBayar', array('modRincians'=>$modRincians,'modPendaftaran'=>$modPendaftaran,'model'=>$model));
    }

}
?>