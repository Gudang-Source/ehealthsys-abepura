<?php

class InfoPemakaianBarangController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $path_view = 'gudangUmum.views.infoPemakaianBarang.';

	/**
	 * Melihat daftar data.
	 */
	public function actionIndex()
	{
		$format = new MyFormatter; 
		$model	= new GUInformasipemakaianbarangV('search');
		$model->unsetAttributes();  // clear any default values
                $disabled = false;
                if (Yii::app()->user->getState('ruangan_id') != Params::RUANGAN_ID_GUDANG_UMUM){
                    $disabled=true;
                }
		$model->instalasi_id = Yii::app()->user->getState('instalasi_id');
		$model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->tgl_awal = date('Y-m-d');
                $model->tgl_akhir = date('Y-m-d');
		if(isset($_GET['GUInformasipemakaianbarangV'])){
			$model->attributes=$_GET['GUInformasipemakaianbarangV'];
            $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
            $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
            if($model->ruangan_id == ""){
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
            }
		}
		$this->render($this->path_view.'index',array(
				'model'=>$model, 'format'=>$format ,'disabled' => $disabled
		));
	}
	
	public function actionDetail($id)
	{
		$this->layout = '//layouts/frameDialog';
        $modPemakaianbarang = GUPemakaianbarangT::model()->findByPk($id);
		if(count($modPemakaianbarang)>0){
			$modDetailPemakaian = GUPemakaianbrgdetailT::model()->findAllByAttributes(array('pemakaianbarang_id'=>$id));
			$this->render($this->path_view.'detailInformasi', array(
                'modPemakaianbarang' => $modPemakaianbarang,
                'modDetailPemakaian' => $modDetailPemakaian,
            ));
		}
	}
	
	/**
     * untuk print data pemakaian barang
     */
    public function actionPrint($pemakaianbarang_id,$caraPrint = null) 
    {
        $format = new MyFormatter;    
        $modPemakaianBarang = GUPemakaianbarangT::model()->findByPk($pemakaianbarang_id);     
        $modPemakaianBarangDetail = GUPemakaianbrgdetailT::model()->findAllByAttributes(array('pemakaianbarang_id'=>$pemakaianbarang_id));

        $judul_print = 'PEMAKAIAN BARANG';
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
			'modPemakaianBarang'=>$modPemakaianBarang,
			'modPemakaianBarangDetail'=>$modPemakaianBarangDetail,
			'caraPrint'=>$caraPrint
        ));
    } 
    
    public function actionBatalPemakaianBarang($id){
		if(Yii::app()->request->isAjaxRequest)
		{
			$data['sukses']=0;
			$deleteDetail = PemakaianbrgdetailT::model()->deleteAllByAttributes(array('pemakaianbarang_id'=>$id));
			$deletePemakaianBarang = PemakaianbarangT::model()->deleteByPk($id);			
			 if($deleteDetail && $deletePemakaianBarang){
				$data['sukses'] = 1;
			 }
			echo CJSON::encode($data); 
		}
    }
}
