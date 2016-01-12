<?php
Yii::import('billingKasir.controllers.PembayaranTagihanPasienController');
class PembayaranObatPasienController extends PembayaranTagihanPasienController
{
    public $path_view = "billingKasir.views.pembayaranTagihanPasien.";
    
    /**
     * actionPrintRincianOABelumBayar 
     * @params $instalasi_id = RJ / RD / RI
     * @params $pendaftaran_id
     * @params $pasienadmisi_id (RI saja)
     */
    public function actionPrintRincianOABelumBayar($instalasi_id,$pendaftaran_id,$pasienadmisi_id=null){
        $this->layout='//layouts/printWindows';
        if (isset($_GET['frame'])){
            $this->layout='//layouts/iframe';
        }
        $modRincians = null;
        if($instalasi_id == Params::INSTALASI_ID_RJ){
            $criteria = new CDbCriteria();
            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
            $criteria->addCondition("LOWER(tm) <> 'tm'");
            $criteria->order = 'unitlayanan_nama, tgl_tindakan, tm';
            $modRincians = BKRincianbelumbayarrjV::model()->findAll($criteria);
			$modPendaftaran = BKPendaftaranT::model()->findByPk($pendaftaran_id);
        }
        else if($instalasi_id == Params::INSTALASI_ID_RD){
            $criteria = new CDbCriteria();
            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
            $criteria->addCondition("LOWER(tm) <> 'tm'");
            $criteria->order = 'ruangantindakan_id';
            $modRincians = BKRincianbelumbayarrdV::model()->findAll($criteria);
			$modPendaftaran = BKPendaftaranT::model()->findByPk($pendaftaran_id);
        }else if($instalasi_id == Params::INSTALASI_ID_RI){
            $criteria = new CDbCriteria();
            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
            $criteria->addCondition('pasienadmisi_id = '.$pasienadmisi_id);
            $criteria->addCondition("LOWER(tm) <> 'tm'");
            $criteria->order = 'ruangantindakan_id, tm';
            $modRincians = BKRincianbelumbayarrawatinapV::model()->findAll($criteria);
			$modPendaftaran = BKPendaftaranT::model()->findByPk($pendaftaran_id);
        }
        $this->render('printRincianOABelumBayar', array('modRincians'=>$modRincians,'modPendaftaran'=>$modPendaftaran));
    }
}
