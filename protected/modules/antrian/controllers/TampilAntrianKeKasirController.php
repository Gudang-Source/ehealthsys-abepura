<?php
class TampilAntrianKeKasirController extends Controller
{
    public $layout='//layouts/antrian';
    public $defaultAction = 'index';
    
    public function actionIndex($layarantrian_id = null)
    {
        $format = new MyFormatter();
        $modLayar = ANLayarantrianM::model()->findByPk($layarantrian_id);
        $modRuangans = new ANLayarruanganM;
        $modRuangans = $modRuangans->getRuanganAntrian($modLayar);
        $model = new ANInfokunjunganrjV();
        $konfig = KonfigsystemK::model()->find();
//        $modRuangans = ANRuanganM::getRuanganAntrian($modLayar->layarantrian_maksitem,Params::INSTALASI_ID_RJ);

        $this->render('index',array(
            'format'=>$format,
            'model'=>$model,
            'konfig'=>$konfig,
            'modLayar'=>$modLayar,
            'modRuangans'=>$modRuangans,
        ));
    }
    
    public function actionGetAntrians(){
        if(Yii::app()->request->isAjaxRequest)
        {
            $format = new MyFormatter();
            $data = array();
            $ruangan_id = isset($_POST['ruangan_id'])?$_POST['ruangan_id']:null;
            $modAntrianBaru = $this->loadModelAntrian($ruangan_id);
            if(isset($_POST['antrian_id'])&&$_POST['antrian_id']!=''){
              $modAntrianBaru = $this->loadModelAntrianById($_POST['antrian_id'],$ruangan_id);
            }
            
            $attributes = $modAntrianBaru->attributeNames();
            foreach($attributes as $i=>$attribute) {
                $data["a"]["$attribute"] = $modAntrianBaru->$attribute;
                
            }
            $data["a"]["loket_singkatan"] = isset($modAntrianBaru->loket->loket_singkatan)?$modAntrianBaru->loket->loket_singkatan:'';
            $data["a"]["loket_nama"] = isset($modAntrianBaru->loket->loket_nama)? strtoupper($modAntrianBaru->loket->loket_nama) : '';
            $data["a"]["ruangan_singkatan"] = isset($modAntrianBaru->ruangan->ruangan_singkatan)? strtoupper($modAntrianBaru->ruangan->ruangan_singkatan):'';
            $data["a"]["nama_pasien"] = isset($modAntrianBaru->pendaftaran->pasien->nama_pasien)? strtoupper($modAntrianBaru->pendaftaran->pasien->nama_pasien):'';
            $data["a"]["statuspasien"] = $modAntrianBaru->statuspasien;
            $data["a"]['jmlpasien'] = $modAntrianBaru->JumlahPasien;
            $data["a"]['jmlmenunggu'] = (!empty($modAntrianBaru->antrian_id) ? $modAntrianBaru->JumlahMenunggu : 0);
            $data["a"]['jmlterdaftar'] = $modAntrianBaru->JumlahTerdaftar;
            
            echo CJSON::encode($data);
            Yii::app()->end();
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
    /**
     * cari antrian berdasarkan loket_id
     * @return \ANAntrianT
     */
    protected function loadModelAntrian($ruangan_id){
        $criteria = new CDbCriteria();
        $criteria->compare("DATE(tglantrian)",date("Y-m-d"));
        $criteria->addCondition("pendaftaran_id IS NOT NULL");
        $criteria->addCondition("panggil_flaq = TRUE");
        if(!empty($ruangan_id))
            $criteria->addCondition("ruangan_id =".$ruangan_id);
        $criteria->order = "loket_id DESC, noantrian DESC"; //panggil terakhir
        $model =  ANAntrianT::model()->find($criteria);
        if(!isset($model)){
            $model = new ANAntrianT;
        }
        return $model;
    }

    /**
     * cari antrian berdasarkan antrian_id
     * @return \ANAntrianT
     */
    protected function loadModelAntrianById($antrian_id,$ruangan_id){
        $criteria = new CDbCriteria();
        $criteria->addCondition("antrian_id =".$antrian_id);
        if(!empty($ruangan_id))
            $criteria->addCondition("ruangan_id =".$ruangan_id);
        $model =  ANAntrianT::model()->find($criteria);
        if(!isset($model)){
            $model = new ANAntrianT;
        }
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
            $antrian_ids = $_POST["antrian_ids"];
            $modLokets = array();
            if(count($loket_ids) >  0){
                foreach($antrian_ids AS $i => $antrian_id){
                    $modAntrians[$i] = ANAntrianT::model()->findByPk($antrian_id);
                }
            }
            $modLokets = array();
            if(count($loket_ids) >  0){
                foreach($loket_ids AS $i => $loket_id){
                    $modLokets[$i] = ANLoketM::model()->findByPk($loket_id);
                }
            }
            $data["suarapanggilan"] = $this->renderPartial('suaraPanggilan',array('noantrians'=>$noantrians, 'modLokets'=>$modLokets, 'modAntrians'=>$modAntrians),true);
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }
}
