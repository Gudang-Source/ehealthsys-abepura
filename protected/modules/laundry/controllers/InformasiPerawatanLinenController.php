<?php
class InformasiPerawatanLinenController extends MyAuthController {
	public $path_view = 'laundry.views.informasiPerawatanLinen.';
	
	public function actionIndex()
	{
		$format = new MyFormatter();
		$modPerawatanLinen = new LAPerawatanlinenT('searchInformasi');
		$modPerawatanLinen->tgl_awal=date("Y-m-d");
		$modPerawatanLinen->tgl_akhir=date("Y-m-d");
		
		if(isset($_GET['LAPerawatanlinenT']))
		{
			$modPerawatanLinen->attributes=$_GET['LAPerawatanlinenT'];
			$modPerawatanLinen->tgl_awal = $format->formatDateTimeForDb($_GET['LAPerawatanlinenT']['tgl_awal']);
			$modPerawatanLinen->tgl_akhir = $format->formatDateTimeForDb($_GET['LAPerawatanlinenT']['tgl_akhir']);
		}
		
		$this->render($this->path_view.'index',array(
			'format'=>$format,
			'model'=>$modPerawatanLinen
		));
	}
	
	
	public function actionDetail($id = null){
		$this->layout = 'iframe';
		
		$model = LAPerawatanlinenT::model()->findByPk($id);     
        $modDetail = LAPerawatanlinendetailT::model()->findAllByAttributes(array('perawatanlinen_id'=>$id));

        
        $this->render($this->path_view.'_detailPerawatan', array(
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