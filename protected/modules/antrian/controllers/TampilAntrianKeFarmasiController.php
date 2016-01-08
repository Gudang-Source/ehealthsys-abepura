<?php
class TampilAntrianKeFarmasiController extends Controller
{
    public $layout='//layouts/antrian';
    public $defaultAction = 'index';
    
    public function actionIndex()
    {
        $format = new MyFormatter();
        $model = new ANAntrianfarmasiT();
        $konfig = KonfigsystemK::model()->find();
        $criteria = new CdbCriteria;
        $criteria->addCondition("racikan_aktif = true");
        $criteria->order = "racikan_id ASC";
        $modLokets = ANRacikanM::model()->findAll($criteria);

        $this->render('index',array(
            'format'=>$format,
            'model'=>$model,
            'modLokets'=>$modLokets,
            'konfig'=>$konfig,
        ));
    }
    
    /**
     * get nilai antrian (or dan nr)
     * @throws CHttpException
     */
    public function actionGetAntrians(){
        if(Yii::app()->request->isAjaxRequest)
        {
            $format = new MyFormatter();
            $data = array();
            //antrian racikan
            $modAntrianRacikan = $this->loadModelAntrian(Params::RACIKAN_ID_RACIKAN);
            if(isset($_POST['antrianfarmasi_id'])&&$_POST['antrianfarmasi_id']!=''){
              $modAntrianRacikan = $this->loadModelAntrianById(Params::RACIKAN_ID_RACIKAN,$_POST['antrianfarmasi_id']);
            }
            $attributes = $modAntrianRacikan->attributeNames();
            foreach($attributes as $i=>$attribute) {
                $data['racikan']["$attribute"] = $modAntrianRacikan->$attribute;
                $modAntrianRacikan->racikan_id = Params::RACIKAN_ID_RACIKAN;//UNTUK DAFTAR ANTRIAN
                $data['racikan']["kodeantrian"] = $modAntrianRacikan->racikan->racikan_singkatan;
                //untuk daftar antrian racikan
                $data['racikan']['daftarantrian'] = $this->renderPartial('_daftarAntrian',array('data'=>$this->loadDaftarAntrians($modAntrianRacikan->racikan_id)),true);
                
            }
            
            //antrian nonracikan
            $modAntrianNonracikan = $this->loadModelAntrian(Params::RACIKAN_ID_NONRACIKAN);
            if(isset($_POST['antrianfarmasi_id'])&&$_POST['antrianfarmasi_id']!=''){
              $modAntrianNonracikan = $this->loadModelAntrianById(Params::RACIKAN_ID_NONRACIKAN,$_POST['antrianfarmasi_id']);
            }
            $attributes = $modAntrianNonracikan->attributeNames();
            foreach($attributes as $i=>$attribute) {
                $data['nonracikan']["$attribute"] = $modAntrianNonracikan->$attribute;
                $modAntrianNonracikan->racikan_id = Params::RACIKAN_ID_NONRACIKAN;//UNTUK DAFTAR ANTRIAN
                $data['nonracikan']["kodeantrian"] = $modAntrianNonracikan->racikan->racikan_singkatan;
                //untuk daftar antrian nonracikan
                $data['nonracikan']['daftarantrian'] = $this->renderPartial('_daftarAntrian',array('data'=>$this->loadDaftarAntrians($modAntrianNonracikan->racikan_id)),true);
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
    /**
     * cari antrian berdasarkan statuspasien
     * @return \ANAntrianfarmasiT
     */
    protected function loadModelAntrian($racikan_id){
        $criteria = new CDbCriteria();
        $criteria->compare("DATE(tglambilantrian)",date("Y-m-d"));
        $criteria->addCondition("racikan_id = ".$racikan_id);
        $criteria->addCondition("panggilantrian = TRUE");
        $criteria->order = "noantrian DESC"; //panggil terakhir
        $model =  ANAntrianfarmasiT::model()->find($criteria);
        if(!isset($model)){
            $model = new ANAntrianfarmasiT;
        }
        return $model;
    }

    protected function loadModelAntrianById($racikan_id,$antrianfarmasi_id){
        $criteria = new CDbCriteria();
        $criteria->compare("DATE(tglambilantrian)",date("Y-m-d"));
        $criteria->addCondition("racikan_id = ".$racikan_id);
        $criteria->addCondition("antrianfarmasi_id = ".$antrianfarmasi_id);
        $criteria->addCondition("panggilantrian = TRUE");
        $criteria->order = "noantrian DESC"; //panggil terakhir
        $model =  ANAntrianfarmasiT::model()->find($criteria);
        if(!isset($model)){
            $model = new ANAntrianfarmasiT;
        }
        return $model;
    }

    /**
     * load daftar racikan
     * @param type $racikan_id
     * @return $data array()
     */
    protected function loadDaftarAntrians($racikan_id){
        $data = array();
        $criteria = new CdbCriteria();
        $criteria->compare('DATE(tglresep)', date("Y-m-d"));
        $criteria->addCondition("racikanantrian_id = ".$racikan_id);
        $criteria->addCondition("noantrian IS NOT NULL");
        $criteria->addCondition("panggilantrian = FALSE");
        $criteria->order = "tglresep ASC";
        $criteria->group = "tglresep, noresep, namadepan, nama_pasien, noantrian, racikanantrian_singkatan";
        $criteria->select = $criteria->group.", count(obatalkes_id) AS jumlahoa";
        $criteria->limit=5;
        $modInfoPenjualanResep = ANInformasipenjualanaresepV::model()->findAll($criteria);
        if(count($modInfoPenjualanResep) > 0){
            foreach($modInfoPenjualanResep AS $i => $penjualan){
                $data[$i]["racikanantrian_singkatan"] = $penjualan->racikanantrian_singkatan;
                $data[$i]["noantrian"] = $penjualan->noantrian;
                $data[$i]["noresep"] = $penjualan->noresep;
                $data[$i]["namadepan"] = $penjualan->namadepan;
                $data[$i]["nama_pasien"] = $penjualan->nama_pasien;
                $data[$i]["jumlahoa"] = $penjualan->jumlahoa;
            }
        }
        return $data;
    }
    /**
     * suara panggilan MULTI no antrian (array) dan loket (array)
     * akses dengan ajax
     */
    public function actionSuaraPanggilan(){
        if(Yii::app()->request->isAjaxRequest)
        {
            $this->layout = "//layouts/iframe";
            $kodeantrians = $_POST["kodeantrians"];
            $noantrians = $_POST["noantrians"];
            $loket_ids = $_POST["loket_ids"];
            $modLokets = array();
            if(count($loket_ids) >  0){
                foreach($loket_ids AS $i => $loket_id){
                    $modLokets[$i] = RacikanM::model()->findByPk($loket_id);
                }
            }
            $data["suarapanggilan"] = $this->renderPartial('suaraPanggilan',array('kodeantrians'=>$kodeantrians, 'noantrians'=>$noantrians, 'modLokets'=>$modLokets),true);
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }
}
