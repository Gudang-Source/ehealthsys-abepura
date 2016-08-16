<?php

class InformasiPengajuanPerawatanLinenController extends MyAuthController {
	public $layout='//layouts/column1';
	public $path_view = 'laundry.views.informasiPengajuanPerawatanLinen.';
	public function actionIndex()
	{
		$format = new MyFormatter();
		$modPengperawatanlinen = new LAPengperawatanlinenT;
		$modPengperawatanlinen->tgl_awal=date("Y-m-d");
		$modPengperawatanlinen->tgl_akhir=date("Y-m-d");
			if(isset($_GET['LAPengperawatanlinenT']))
			{
				$modPengperawatanlinen->attributes=$_GET['LAPengperawatanlinenT'];
				$modPengperawatanlinen->tgl_awal = $format->formatDateTimeForDb($_GET['LAPengperawatanlinenT']['tgl_awal']);
				$modPengperawatanlinen->tgl_akhir = $format->formatDateTimeForDb($_GET['LAPengperawatanlinenT']['tgl_akhir']);
                                $modPengperawatanlinen->instalasi_id = $_GET['LAPengperawatanlinenT']['instalasi_id'];
                                $modPengperawatanlinen->ruanganpengirim_id = $_GET['LAPengperawatanlinenT']['ruanganpengirim_id'];
			}
		$this->render($this->path_view.'index',array(
			'format'=>$format,
			'model'=>$modPengperawatanlinen
		));
	}
	
    public function actionBatalPengajuan($id){
		if(Yii::app()->request->isAjaxRequest)
		{
			$data['sukses']=0;
			$deleteDetail = PengperawatanlinendetT::model()->deleteAllByAttributes(array('pengperawatanlinen_id'=>$id));
			$deletePengperawatan = PengperawatanlinenT::model()->deleteByPk($id);			
			 if( ($deleteDetail==TRUE) && ($deletePengperawatan==TRUE)){
				$data['sukses'] = 1;
			 }
			echo CJSON::encode($data); 
		}
    }
	
	public function actionDetail($pengperawatanlinen_id)
	{
		$this->layout='//layouts/iframe';
		$format = new MyFormatter();
		$model = LAPengperawatanlinenT::model()->findByPk($pengperawatanlinen_id);  
		$modDetail = LAPengperawatanlinendetT::model()->findAllByAttributes(array('pengperawatanlinen_id'=>$model->pengperawatanlinen_id));
        $judulLaporan = 'Pengajuan Perawatan Linen';
		$deskripsi = $format->formatDateTimeForUser($model->tglpengperawatanlinen);
        $this->render('_detail', array(
				'format'=>$format,
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
             if (!empty($instalasi_id)){
            $models = CHtml::listData(RuanganM::model()->findAllByAttributes(array("instalasi_id"=>$instalasi_id), "ruangan_aktif = true"),'ruangan_id','ruangan_nama');
             }
            if($encode){
                echo CJSON::encode($models);
            } else {
               // if (count($models)>1){
               //     echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
              //  }elseif (count($models)==0){
               //     echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
               // }
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