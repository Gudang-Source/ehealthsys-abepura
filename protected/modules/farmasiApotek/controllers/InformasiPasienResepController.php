<?php

class InformasiPasienResepController extends MyAuthController
{
    public function actionIndex()
    {
        $model = new FAInformasiresepturV('searchInformasiPasienResep');
        $model->unsetAttributes();
        $model->tgl_awal = date("d M Y");
        $model->tgl_akhir = date("d M Y");
        if(isset($_GET['FAInformasiresepturV'])){
            $format = new MyFormatter();
            $model->attributes = $_GET['FAInformasiresepturV'];
            $model->statusJual = $_GET['FAInformasiresepturV']['statusJual'];
            $model->statusperiksa = $_GET['FAInformasiresepturV']['statusperiksa'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['FAInformasiresepturV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FAInformasiresepturV']['tgl_akhir']);
        }
    
        $this->render('index',array('model'=>$model));
    }
	
	public function actionPrintResepDokter()
	{
		if (isset($_GET['frame'])){
            $this->layout='//layouts/iframe';
        }else{
			$this->layout='//layouts/printWindows';
		}
		
		$reseptur_id = $_GET['id'];
		$modReseptur = FAResepturT::model()->findByPk($reseptur_id);
		$pendaftaran_id = $modReseptur->pendaftaran_id;
		$criteria=new CDbCriteria;
		$criteria->addCondition("create_time=(select max(create_time) from reseptur_t)");
		$maxtime = FAResepturT::model()->find($criteria);
		$modDetailResep = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id'=>$maxtime->reseptur_id));
		$modPendaftaran = FAPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
		
		$judulLaporan='';
		
		$criteriakl=new CDbCriteria;
		$criteriakl->addCondition("reseptur_id = ". $reseptur_id);
		$criteriakl->select = 'racikan_id, rke, iter, reseptur_id';
		$criteriakl->group = 'racikan_id, rke, iter, reseptur_id';
		$criteriakl->order = 'rke';
		$kerangkaLooping = ResepturdetailT::model()->findAll($criteriakl);
		
		$this->render('Print',array(
							'modPendaftaran'=>$modPendaftaran,
							'judulLaporan'=>$judulLaporan,
							"modDetailResep"=>$modDetailResep,
							'modReseptur'=>$modReseptur,
							'kerangkaLooping'=>$kerangkaLooping
								));
	}
}