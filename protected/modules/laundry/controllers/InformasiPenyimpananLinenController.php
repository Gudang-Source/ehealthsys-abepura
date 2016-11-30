<?php
class InformasiPenyimpananLinenController extends MyAuthController {
	public $path_view = 'laundry.views.informasiPenyimpananLinen.';
	
	public function actionIndex()
	{
		$format = new MyFormatter();
		$modPenyimpananLinen = new LAPenyimpananlinenT('searchInformasi');
		$modPenyimpananLinen->tgl_awal=date("Y-m-d");
		$modPenyimpananLinen->tgl_akhir=date("Y-m-d");
		
		if(isset($_GET['LAPenyimpananlinenT']))
		{
			$modPenyimpananLinen->attributes=$_GET['LAPenyimpananlinenT'];
			$modPenyimpananLinen->tgl_awal = $format->formatDateTimeForDb($_GET['LAPenyimpananlinenT']['tgl_awal']);
			$modPenyimpananLinen->tgl_akhir = $format->formatDateTimeForDb($_GET['LAPenyimpananlinenT']['tgl_akhir']);
		}
		
		$this->render($this->path_view.'index',array(
			'format'=>$format,
			'model'=>$modPenyimpananLinen
		));
	}
	
	
	public function actionDetail($id = null,$caraPrint = null){
	$this->layout = 'iframe';
         if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';            
        }  
		$format = new MyFormatter();
		$model = LAPenyimpananlinenT::model()->findByPk($id);     
        $modDetail = LAPenyimpananlinendetT::model()->findAllByAttributes(array('penyimpananlinen_id'=>$id));
        $judulLaporan = 'Penyimpanan Linen';
        $deskripsi = $format->formatDateTimeForUser($model->tglpenyimpananlinen);
        
        $this->render($this->path_view.'_detailPenyimpanan', array(
			'model'=>$model,
			'modDetail'=>$modDetail,
                        'judulLaporan'=>$judulLaporan,
                        'deskripsi'=>$deskripsi
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
            $models = CHtml::listData(LARuanganM::getRuanganByInstalasi($instalasi_id),'ruangan_id','ruangan_nama');

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
}