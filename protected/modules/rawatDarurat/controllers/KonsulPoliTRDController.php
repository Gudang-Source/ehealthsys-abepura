<?php
Yii::import('rawatJalan.controllers.KonsulPoliController');
Yii::import('rawatJalan.models.*');
class KonsulPoliTRDController extends KonsulPoliController
{
        
}
//class KonsulPoliController extends MyAuthController
//{
//	public function actionIndex($pendaftaran_id)
//	{
//            $modPendaftaran = RDPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
//            $modPasien = RDPasienM::model()->findByPk($modPendaftaran->pasien_id);
//            $karcisTindakan = DaftartindakanM::model()->findAllByAttributes(array('daftartindakan_karcis'=>true));
//            
//            $modKonsul = new RDKonsulPoliT;
//            $modKonsul->pasien_id = $modPendaftaran->pasien_id;
//            $modKonsul->pendaftaran_id = $pendaftaran_id;
//            $modKonsul->pegawai_id = $modPendaftaran->pegawai_id;
//            $modKonsul->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
//            $modKonsul->asalpoliklinikkonsul_id = Yii::app()->user->getState('ruangan_id');
//            
//            if(isset($_POST['RDKonsulPoliT'])) {
//                $modKonsul->attributes = $_POST['RDKonsulPoliT'];
//                if($modKonsul->validate()){
//                    $modKonsul->save();
//                    Yii::app()->user->setFlash('success',"Data berhasil disimpan");
//                }
//            }
//            
//            $modRiwayatKonsul = RDKonsulPoliT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
//		
//            $this->render('index',array('modPendaftaran'=>$modPendaftaran,
//                                        'modPasien'=>$modPasien,
//                                        'modKonsul'=>$modKonsul,
//                                        'karcisTindakan'=>$karcisTindakan,
//                                        'modRiwayatKonsul'=>$modRiwayatKonsul));
//	}
//        
//        public function actionAjaxDetailKonsul()
//        {
//            if(Yii::app()->request->isAjaxRequest) {
//            $idKonsulAntarPoli = $_POST['idKonsulAntarPoli'];
//            $modKonsulPoli = RDKonsulPoliT::model()->findByPk($idKonsulAntarPoli);
//            $data['result'] = $this->renderPartial('_viewKonsulPoli', array('modKonsul'=>$modKonsulPoli), true);
//
//            echo json_encode($data);
//             Yii::app()->end();
//            }
//        }
//        
//        public function actionAjaxBatalKonsul()
//        {
//            if(Yii::app()->request->isAjaxRequest) {
//            $idKonsulAntarPoli = $_POST['idKonsulAntarPoli'];
//            $pendaftaran_id = $_POST['pendaftaran_id'];
//            
//            RDKonsulPoliT::model()->deleteByPk($idKonsulAntarPoli);
//            $modRiwayatKonsul = RDKonsulPoliT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
//            
//            $data['result'] = $this->renderPartial('_listKonsulPoli', array('modRiwayatKonsul'=>$modRiwayatKonsul), true);
//
//            echo json_encode($data);
//             Yii::app()->end();
//            }
//        }
//
//	// Uncomment the following methods and override them if needed
//	/*
//	public function filters()
//	{
//		// return the filter configuration for this controller, e.g.:
//		return array(
//			'inlineFilterName',
//			array(
//				'class'=>'path.to.FilterClass',
//				'propertyName'=>'propertyValue',
//			),
//		);
//	}
//
//	public function actions()
//	{
//		// return external action classes, e.g.:
//		return array(
//			'action1'=>'path.to.ActionClass',
//			'action2'=>array(
//				'class'=>'path.to.AnotherActionClass',
//				'propertyName'=>'propertyValue',
//			),
//		);
//	}
//	*/
//}