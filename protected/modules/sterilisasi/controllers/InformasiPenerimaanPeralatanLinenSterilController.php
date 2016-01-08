<?php
class InformasiPenerimaanPeralatanLinenSterilController extends MyAuthController {
	public $path_view = 'sterilisasi.views.informasiPenerimaanPeralatanLinenSteril.';
	
	public function actionIndex()
	{
		$format = new MyFormatter();
		$model = new STTerimaperlinensterilT('searchInformasi');
		$model->tgl_awal=date("Y-m-d");
		$model->tgl_akhir=date("Y-m-d");
		
		if(isset($_GET['STTerimaperlinensterilT']))
		{
			$model->attributes=$_GET['STTerimaperlinensterilT'];
			$model->tgl_awal = $format->formatDateTimeForDb($_GET['STTerimaperlinensterilT']['tgl_awal']);
			$model->tgl_akhir = $format->formatDateTimeForDb($_GET['STTerimaperlinensterilT']['tgl_akhir']);
			$model->ruangan_id = $_GET['STTerimaperlinensterilT']['ruangan_id'];
		}
		
		$this->render($this->path_view.'index',array(
			'format'=>$format,
			'model'=>$model
		));
	}
	
	
	public function actionDetail($terimaperlinensteril_id = null){
		$this->layout = 'iframe';
		
		$model = STTerimaperlinensterilT::model()->findByPk($terimaperlinensteril_id);     
        $modDetail = STTerimaperlinensterildetT::model()->findAllByAttributes(array('terimaperlinensteril_id'=>$model->terimaperlinensteril_id));
        
        $this->render($this->path_view.'_detail', array(
			'model'=>$model,
			'modDetail'=>$modDetail,
        ));
	}
	/**
     * Mengatur dropdown ruangan
     * @param type $encode jika = true maka return array jika false maka set Dropdown 
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropdownRuangan($encode=false,$model_nama='',$attr='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            $instalasi_id = null;
            if($model_nama !=='' && $attr == ''){
                $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
            }
             else if ($model_nama == '' && $attr !== '') {
                $instalasi_id = $_POST["$attr"];
            }
             else if ($model_nama !== '' && $attr !== '') {
                $instalasi_id = $_POST["$model_nama"]["$attr"];
            }
            $models = null;
            $models = CHtml::listData(STRuanganM::getRuanganByInstalasi($instalasi_id),'ruangan_id','ruangan_nama');

            if($encode){
                echo CJSON::encode($models);
            } else {
                echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                if(count($models) > 0){
                    foreach($models as $value=>$name){
                        echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
                }
            }
        }
        Yii::app()->end();
    }
	
	public function actionBatalPenerimaan($id){
		if(Yii::app()->request->isAjaxRequest)
		{
			$data['sukses']=0;
			$deleteDetail = STTerimaperlinensterildetT::model()->deleteAllByAttributes(array('terimaperlinensteril_id'=>$id));
			$deletePengiriman = STTerimaperlinensterilT::model()->deleteByPk($id);			
			 if($deleteDetail && $deletePengiriman){
				$data['sukses'] = 1;
			 }
			echo CJSON::encode($data); 
		}
    }
	
	public function actionPrintDetail($terimaperlinensteril_id)
    {
		$detail = array();
        $modPrograms = array();
		$format = new MyFormatter();
		$model = STTerimaperlinensterilT::model()->findByPk($terimaperlinensteril_id);  
		$modDetails = STTerimaperlinensterildetT::model()->findAllByAttributes(array('terimaperlinensteril_id'=>$model->terimaperlinensteril_id));
		
        $judulLaporan = 'Penerimaan Peralatan Sterilisasi';
		$deskripsi = $format->formatDateTimeForUser($model->terimaperlinensteril_tgl);
        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
		if($caraPrint=='PRINT') {
			$this->layout='//layouts/printWindows';
			$this->render('printDetail',array('format'=>$format,'model'=>$model,'modDetails'=>$modDetails,'detail'=>$detail,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($caraPrint=='EXCEL') {
			$this->layout='//layouts/printExcel';
			$this->render('printDetail',array('format'=>$format,'model'=>$model,'modDetails'=>$modDetails,'detail'=>$detail,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($_REQUEST['caraPrint']=='PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('',$ukuranKertasPDF); 
			$mpdf->useOddEven = 2;  
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);  
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial('printDetail',array('format'=>$format,'model'=>$model,'modDetails'=>$modDetails,'detail'=>$detail,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}
    }
}