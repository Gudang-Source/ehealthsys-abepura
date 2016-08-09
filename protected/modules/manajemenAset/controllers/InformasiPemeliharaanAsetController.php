<?php

class InformasiPemeliharaanAsetController extends MyAuthController {
	
	public $layout='//layouts/column1';
	public $path_view = 'manajemenAset.views.informasiPemeliharaanAset.';
	
	public function actionIndex()
	{
		$format = new MyFormatter; 
		$model	= new MAInformasipemeliharaanasetV('searchInformasi');
		$model->unsetAttributes();  // clear any default values
                $model->tgl_awal = date('Y-m-d');
                $model->tgl_akhir = date('Y-m-d');
		if(isset($_GET['MAInformasipemeliharaanasetV'])){
			$model->attributes=$_GET['MAInformasipemeliharaanasetV'];
                        $model->tgl_awal = $format->formatDateTimeForDb($_GET['MAInformasipemeliharaanasetV']['tgl_awal']);
                        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['MAInformasipemeliharaanasetV']['tgl_akhir']);
                        var_dump($model->tgl_awal);
		}
		$this->render($this->path_view.'index',array(
				'model'=>$model, 'format'=>$format
		));
		
	}
	
	public function actionDetail($id)
	{
		$this->layout = '//layouts/frameDialog';
        $modPemeliharaanAset = PemeliharaanasetT::model()->findByPk($id);
		if(count($modPemeliharaanAset)>0){
			$modDetailPemeliharaan = PemeliharaanasetdetailT::model()->findAllByAttributes(array('pemeliharaanaset_id'=>$id));
			$this->render($this->path_view.'detailInformasi', array(
                'modPemeliharaanAset' => $modPemeliharaanAset,
                'modDetailPemeliharaan' => $modDetailPemeliharaan,
            ));
		}
	}
	
	/**
     * untuk print data pemakaian barang
     */
    public function actionPrint($pemeliharaanaset_id,$caraPrint = null) 
    {
        $format = new MyFormatter;    
        $modPemeliharaanAset = PemeliharaanasetT::model()->findByPk($pemeliharaanaset_id);     
        $modDetailPemeliharaan = PemeliharaanasetdetailT::model()->findAllByAttributes(array('pemeliharaanaset_id'=>$pemeliharaanaset_id));

        $judul_print = 'PEMELIHARAAN ASET';
        $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
        if (isset($_GET['frame'])){
            $this->layout='//layouts/iframe';
        }
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
        }
        else if($caraPrint=='EXCEL') {
            $this->layout='//layouts/printExcel';
        }
        
        $this->render($this->path_view.'Print', array(
			'format'=>$format,
			'judul_print'=>$judul_print,
			'modPemeliharaanAset'=>$modPemeliharaanAset,
			'modDetailPemeliharaan'=>$modDetailPemeliharaan,
			'caraPrint'=>$caraPrint
        ));
    } 
    
    public function actionBatalPemeliharaanAset($id){
		if(Yii::app()->request->isAjaxRequest)
		{
			$data['sukses']=0;
			$deleteDetail = PemeliharaanasetdetailT::model()->deleteAllByAttributes(array('pemeliharaanaset_id'=>$id));
			$deletePemeliharaanAset = PemeliharaanasetT::model()->deleteByPk($id);			
			 if($deleteDetail && $deletePemeliharaanAset){
				$data['sukses'] = 1;
			 }
			echo CJSON::encode($data); 
		}
    }	
}

