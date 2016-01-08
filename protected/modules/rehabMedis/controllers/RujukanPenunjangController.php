<?php

class RujukanPenunjangController extends MyAuthController
{
 
	public function actionIndex()
	{
            $this->pageTitle = Yii::app()->name." - Pasien Rujukan";
            $criteria = new CDbCriteria;
            if(isset($_GET['ajax']) && $_GET['ajax']=='pasienpenunjangrujukan-m-grid') {
                $format = new MyFormatter;
                $criteria->compare('LOWER(no_pendaftaran)', strtolower($_GET['noPendaftaran']),true);
                $criteria->compare('LOWER(nama_pasien)', strtolower($_GET['namaPasien']),true);
                $criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['noRekamMedik']),true);
                if($_GET['cbTglMasuk'])
                    $criteria->addBetweenCondition('tgl_kirimpasien', "'".$format->formatDateTimeForDb($_GET['tgl_awal'])."'", "'".$format->formatDateTimeForDb($_GET['tgl_akhir'])."'");
            } else {
                //$criteria->addBetweenCondition('tgl_pendaftaran', date('Y-m-d').' 00:00:00', date('Y-m-d').' 23:59:59');
            }
            $criteria->addCondition('instalasi_id ='.Yii::app()->user->getState('instalasi_id'));
            
            $dataProvider = new CActiveDataProvider(PasienkirimkeunitlainV::model(), array(
			'criteria'=>$criteria,
		));
            $this->render('index',array('dataProvider'=>$dataProvider));
	}
        /**
         * Fungsi untuk mengupadte hasil pemeriksaan rehab medis menset tindakanpelayanan id
         * @param type $modTindPelayanan model object
         */
        protected function upadateHasilTindakan($modTindPelayanan)
        {
            $modHasil = $this->loadById($modTindPelayanan->hasilpemeriksaanrm_id);
            $modHasil->tindakanpelayanan_id = $modTindPelayanan->tindakanpelayanan_id;
            $modHasil->save();
        }
        
        /**
         * Fungsi untuk mengembalikan object $model dengan method findByPk yang nanti digunakan untuk menyimpan data-data hasil pemeriksaan
         * @param type $id
         * @return type 
         */
        protected function loadById($id)
        {       $model= HasilpemeriksaanrmT::model()->findByPk($id);
		if($model===null)
                    throw new CHttpException(404,'The requested page does not exist.');
		return $model;
        }
        
        
        protected function updatePasienKirimKeUnitLain($modPasienPenunjang) {
            
            if(!empty($_POST['permintaanPenunjang'])){
                foreach($_POST['permintaanPenunjang'] as $i => $item) {
                    PasienkirimkeunitlainT::model()->updateByPk($item['idPasienKirimKeUnitLain'], 
                                                                array('pasienmasukpenunjang_id'=>$modPasienPenunjang->pasienmasukpenunjang_id));
                }
            }
        }
		
		public function actionLoadFormPemeriksaanRMPendRM()
		{
			if (Yii::app()->request->isAjaxRequest)
			{
				$idPemeriksaanRM = $_POST['idPemeriksaanRM'];
				$idKelasPelayanan = $_POST['kelasPelayan_id'];
				$modPeriksaRM = TindakanrmM::model()->with('jenistindakanrm')->findByPk($idPemeriksaanRM);
				$modTarif = TariftindakanM::model()->findByAttributes(array('daftartindakan_id'=>$modPeriksaRM->daftartindakan_id,
																			'kelaspelayanan_id'=>$idKelasPelayanan,
																			'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));

				echo CJSON::encode(array(
					'status'=>'create_form', 
					'form'=>$this->renderPartial('_formLoadPemeriksaanRMPendRM', array('modPeriksaRM'=>$modPeriksaRM,
																				  'modTarif'=>$modTarif,
																				  'idKelasPelayanan'=>$idKelasPelayanan  ), true)));
				exit;               
			}
		}
		
		public function actionLoadFormRehabMedisMasuk()
		{
			if (Yii::app()->request->isAjaxRequest)
			{
				$idPemeriksaanRM = $_POST['idPemeriksaanRM'];
				$idKelasPelayanan = $_POST['kelasPelayanan_id'];


				$modTindakan = TindakanrmM::model()->with('jenistindakanrm')->findByPk($idPemeriksaanRM);
				$modTarif = TariftindakanM::model()->findByAttributes(array('daftartindakan_id'=>$modTindakan->daftartindakan_id,
																			'kelaspelayanan_id'=>$idKelasPelayanan,
																			'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));
				echo CJSON::encode(array(
					'status'=>'create_form', 
					'form'=>$this->renderPartial('_formLoadRehabMedisMasuk', array('modTindakan'=>$modTindakan,
																				  'modTarif'=>$modTarif,
																				  'idKelasPelayanan'=>$idKelasPelayanan), true)));
				exit;               
			}
		}
        
        

	
}