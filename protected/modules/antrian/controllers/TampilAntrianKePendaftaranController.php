<?php
class TampilAntrianKePendaftaranController extends Controller
{
    public $layout='//layouts/antrian';
    public $defaultAction = 'index';
    
    public function actionIndex()
    {
        $format = new MyFormatter();
        $model = new ANAntrianT();
        $konfig = KonfigsystemK::model()->find();
        $criteria = new CdbCriteria;
        $criteria->addCondition("loket_aktif = true AND ispendaftaran = TRUE");
        $criteria->order = "loket_nourut ASC";
        $modLokets = ANLoketM::model()->findAll($criteria);
        $this->render('index',array(
            'format'=>$format,
            'model'=>$model,
            'modLokets'=>$modLokets,
            'konfig'=>$konfig,
        ));
    }
    
    /**
     * get nilai antrian
     * @throws CHttpException
     */
    public function actionGetAntrians(){
        if(Yii::app()->request->isAjaxRequest)
        {
            $format = new MyFormatter();
            $data = array();

			$modLokets = ANLoketM::model()->findAll('ispendaftaran = TRUE AND loket_aktif = TRUE');
			if(count($modLokets) > 0){
				foreach($modLokets AS $i => $loket){					
					$modAntrian = $this->loadModelAntrian($loket->loket_id);
					$modJumlah = $this->loadDataStatistik($loket->loket_id);
					if($modAntrian){
						if(isset($_POST['antrian_id']) && $_POST['antrian_id'] != ''){
							$modAntrian = $this->loadModelAntrianById($loket->loket_id,$_POST['antrian_id']);
							$modJumlah = $this->loadDataStatistik($loket->loket_id);
						}
						$data["an_".$i] = $modAntrian->attributes;
						$data["an_".$i] += $loket->attributes;
						$data["an_".$i] += $modJumlah;
					}
				}
			}
            
            echo CJSON::encode($data);
            Yii::app()->end();
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
	
	protected function loadDataStatistik($loket_id) {
		$default = '000';
		$data['jmlpasien'] = 0;
		$data['jmlmenunggu'] = 0;
		$data['jmlterdaftar'] = 0;
		
		$criteria = new CDbCriteria();
        $criteria->compare("DATE(tglantrian)",date("Y-m-d"));
        $criteria->addCondition("loket_id = ".$loket_id);
        $criteria->order = "loket_id DESC, noantrian DESC"; //panggil terakhir
        $models =  ANAntrianT::model()->findAll($criteria);
		
		if(count($models) > 0){
			foreach($models as $i=>$model){
				$data['jmlpasien'] += 1;
				if(!empty($model->pendaftaran_id)){
					$data['jmlterdaftar'] += 1;
				}
			}
		}
		
		$jmlmenunggu = $data['jmlpasien'] - $data['jmlterdaftar'];
		$data['jmlpasien'] = (isset($data['jmlpasien']) ? (str_pad($data['jmlpasien'], strlen($default), 0,STR_PAD_LEFT)) : $default);
		$data['jmlterdaftar'] = (isset($data['jmlterdaftar']) ? (str_pad($data['jmlterdaftar'], strlen($default), 0,STR_PAD_LEFT)) : $default);
		$data['jmlmenunggu'] = (isset($jmlmenunggu) ? (str_pad($jmlmenunggu, strlen($default), 0,STR_PAD_LEFT)) : $default);
		return $data;
	}
    /**
     * cari antrian berdasarkan loket_id
     * @return \ANAntrianT
     */
    protected function loadModelAntrian($loket_id){
        $criteria = new CDbCriteria();
        $criteria->compare("DATE(tglantrian)",date("Y-m-d"));
        $criteria->addCondition("pendaftaran_id IS NULL");
        $criteria->addCondition("panggil_flaq = TRUE");
        $criteria->addCondition("loket_id = ".$loket_id);
        $criteria->order = "loket_id DESC, noantrian DESC"; //panggil terakhir
        $model =  ANAntrianT::model()->find($criteria);
        return $model;
    }
    
    /**
     * cari antrian berdasarkan loket_id
     * @return \ANAntrianT
     */
    protected function loadModelAntrianById($loket_id,$antrian_id){
        $criteria = new CDbCriteria();
        $criteria->compare("DATE(tglantrian)",date("Y-m-d"));
        $criteria->addCondition("pendaftaran_id IS NULL");
        $criteria->compare("loket_id",$loket_id);
        $criteria->compare("antrian_id",$antrian_id);
        $criteria->order = "loket_id DESC, noantrian DESC"; //panggil terakhir
        $model =  ANAntrianT::model()->find($criteria);
        return $model;
    }

    /**
     * suara panggilan MULTI no antrian (array) dan loket (array)
     * akses dengan ajax
     */
    public function actionSuaraPanggilan(){
        if(Yii::app()->request->isAjaxRequest)
        {
            $this->layout = "//layouts/iframe";
            $noantrians = $_POST["noantrians"];
            $loket_ids = $_POST["loket_ids"];
            $modLokets = array();
            if(count($loket_ids) >  0){
                foreach($loket_ids AS $i => $loket_id){
                    $modLokets[$i] = ANLoketM::model()->findByPk($loket_id);
                }
            }
            $data["suarapanggilan"] = $this->renderPartial('suaraPanggilan',array('noantrians'=>$noantrians, 'modLokets'=>$modLokets),true);
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }
    
    /**
     * suara panggilan SATU no antrian dal loket
     * akses dengan iframe
     */
    public function actionSuaraPanggilanSingle($noantrian, $loket_id){
        $this->layout='//layouts/antrian';
        $modLoket = LoketM::model()->findByPk($loket_id);
        $noantrian_split = str_split($noantrian);
        $this->render("suaraPanggilan",array("noantrian"=>$noantrian, "modLoket"=>$modLoket,"noantrian_split"=>$noantrian_split));
    }
}
