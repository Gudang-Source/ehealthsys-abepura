<?php
class InformasiPemakaianAmbulansController extends MyAuthController
{
    public $layout='//layouts/column1';
    public function actionIndex(){
		$model = new AMInformasipemakaianambulansV;
		$format = new MyFormatter;
	    $model->tgl_awal  = date('Y-m-d');
	    $model->tgl_akhir  = date('Y-m-d');
		if(isset($_GET['AMInformasipemakaianambulansV'])){
			$model->unsetAttributes();
			$model->attributes=$_GET['AMInformasipemakaianambulansV'];
			$model->tgl_awal = $format->formatDateTimeForDb($_GET['AMInformasipemakaianambulansV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AMInformasipemakaianambulansV']['tgl_akhir']);
		}
		$this->render('index',array('model'=>$model,'format'=>$format));
	}

    public function actionView($pemakaianambulans_id){
        $this->layout='//layouts/iframe';
        $model = AMInformasipemakaianambulansV::model()->findByAttributes(array('pemakaianambulans_id'=>$pemakaianambulans_id));
        $format = new MyFormatter;
        $this->render('view',array('model'=>$model,'format'=>$format));
    }

	public function actionBatalPakai(){
        if(Yii::app()->request->isAjaxRequest){
            $result=array();
            $status = 'gagal';
            $pemakaian_id = isset($_POST['pemakaian_id']) ? $_POST['pemakaian_id'] : null;
            $pemesanan_id = isset($_POST['pemesanan_id']) ? $_POST['pemesanan_id'] : null;
            $modPemakaiAmbulans = AMPemakaianambulansT::model()->findByPk($pemakaian_id);
            $modPemesananambulans = AMPesanambulansT::model()->findByAttributes(array('pemakaianambulans_id'=>$pemakaian_id));
            
            if(!empty($pemesanan_id)){
                $updatePemakaian = PemakaianambulansT::model()->updateByPk($pemakaian_id,array('pesanambulans_t'=>null));
                $updatePemesanan = PesanambulansT::model()->updateByPk($pemesanan_id,array('pemakaianambulans_id'=>null));
                if($updatePemakaian && $updatePemesanan){
                    $deletePemakaian = AMPemakaianambulansT::model()->deleteByPk($pemakaian_id);
                    $status = 'berhasil';
                }else{
                    $status = 'gagal';
                } 
            }else{
                $deletePemakaian = AMPemakaianambulansT::model()->deleteByPk($pemakaian_id);                    
                $status = 'berhasil';
            }
            
             $result['status'] = $status;
            echo CJSON::encode($result);
        }
        Yii::app()->end();
    }

    public function actionPrintDetail($pemakaianambulans_id) 
    {
        $this->layout='//layouts/printWindows';
        $model = AMInformasipemakaianambulansV::model()->findByAttributes(array('pemakaianambulans_id'=>$pemakaianambulans_id));
        $format = new MyFormatter;

        $judul_print = 'Detail Pemakaian Ambulance Pasien';
        $this->render('print', array(
                            'format'=>$format,
                            'model'=>$model,
                            'judul_print'=>$judul_print,
        ));
    } 

}