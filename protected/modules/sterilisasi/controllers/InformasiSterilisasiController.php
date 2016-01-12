<?php
class InformasiSterilisasiController extends MyAuthController {
	public $path_view = 'sterilisasi.views.informasiSterilisasi.';
	
	public function actionIndex()
	{
		$format = new MyFormatter();
		$modSterilisasi = new STSterilisasiT('searchInformasi');
		$modSterilisasi->tgl_awal=date("Y-m-d");
		$modSterilisasi->tgl_akhir=date("Y-m-d");
		
		if(isset($_GET['STSterilisasiT']))
		{
			$modSterilisasi->attributes=$_GET['STSterilisasiT'];
			$modSterilisasi->tgl_awal = $format->formatDateTimeForDb($_GET['STSterilisasiT']['tgl_awal']);
			$modSterilisasi->tgl_akhir = $format->formatDateTimeForDb($_GET['STSterilisasiT']['tgl_akhir']);
			$modSterilisasi->ruangan_id = $_GET['STSterilisasiT']['ruangan_id'];
		}
		
		$this->render($this->path_view.'index',array(
			'format'=>$format,
			'model'=>$modSterilisasi
		));
	}
	
	
	public function actionDetail($id = null){
		$this->layout = 'iframe';
		
		$model = STSterilisasiT::model()->findByPk($id);     
        $modDetail = STSterilisasidetailT::model()->findAllByAttributes(array('sterilisasi_id'=>$id));

        
        $this->render($this->path_view.'_detailSterilisasi', array(
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
}