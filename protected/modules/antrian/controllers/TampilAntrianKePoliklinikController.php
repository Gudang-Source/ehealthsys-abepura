<?php
class TampilAntrianKePoliklinikController extends Controller
{
    public $layout='//layouts/antrianPoli';
    public $defaultAction = 'index';
    
    public function actionIndex($layarantrian_id = null)
    {
        $format = new MyFormatter();
        $modLayar = ANLayarantrianM::model()->findByPk($layarantrian_id);
        $konfig = KonfigsystemK::model()->find();
        $modRuangans = new ANLayarruanganM;
        $modRuangans = $modRuangans->getRuanganAntrian($modLayar);
        $model = new ANInfokunjunganrjV();
//        $modRuangans = ANRuanganM::getRuanganAntrian($modLayar->layarantrian_maksitem,Params::INSTALASI_ID_RJ);

        $this->render('index',array(
            'format'=>$format,
            'model'=>$model,
            'modLayar'=>$modLayar,
            'modRuangans'=>$modRuangans,
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
            $layarantrian_id = (isset($_POST['layarantrian_id']) ? $_POST['layarantrian_id'] : null);
            $modLayar = ANLayarantrianM::model()->findByPk($layarantrian_id);
            $modRuangans = new ANLayarruanganM;
            $modRuangans = $modRuangans->getRuanganAntrian($modLayar);
            if(count($modRuangans) > 0){
                foreach ($modRuangans AS $r => $ruangan){
                    if(isset($_POST['pendaftaran_id'])&&$_POST['pendaftaran_id']!=''){
                        $modKunjungan = $this->loadModelAntrianById($ruangan->ruangan_id,$_POST['pendaftaran_id']);
                    } else {
						$modKunjungan = $this->loadModelAntrian($ruangan->ruangan_id);
					}
                    if(!empty($modKunjungan)){
                        $attributes = $modKunjungan->attributeNames();
						$r = RuanganM::model()->findByPk($ruangan->ruangan_id);
                        foreach($attributes as $i=>$attribute) {
                            $data["r_".$ruangan->ruangan_id]["$attribute"] = $modKunjungan->$attribute;
                        }
						// var_dump($r->attributes); die;
						$data["r_".$ruangan->ruangan_id]['ruangan_filesuara'] = $r->ruangan_filesuara;
						$data["r_".$ruangan->ruangan_id]['antri_terbilang'] = strtolower(MyFormatter::formatNumberTerbilang((int)$modKunjungan->no_urutantri));
                    }
                }
            }
            
            echo CJSON::encode($data);
            Yii::app()->end();
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
    /**
     * cari antrian berdasarkan statuspasien
     * @return \ANAntrianT
     */
    protected function loadModelAntrian($ruangan_id){
        $criteria = new CDbCriteria();
        $criteria->compare("DATE(tgl_pendaftaran)",date("Y-m-d"));
        $criteria->addCondition("panggilantrian = TRUE");
        $criteria->addCondition("ruangan_id = ".$ruangan_id);
        $criteria->order = "no_urutantri DESC"; //panggil terakhir
        $criteria->limit = 1;
        $model = ANInfokunjunganrjV::model()->find($criteria);
        if(!isset($model)){
            $model = new ANInfokunjunganrjV;
        }
        return $model;
    }

    /**
     * cari antrian berdasarkan statuspasien
     * @return \ANAntrianT
     */
    protected function loadModelAntrianById($ruangan_id,$pendaftaran_id){
        $criteria = new CDbCriteria();
        $criteria->compare("DATE(tgl_pendaftaran)",date("Y-m-d"));
        $criteria->addCondition("panggilantrian = TRUE");
        $criteria->addCondition("ruangan_id = ".$ruangan_id);
        $criteria->addCondition("pendaftaran_id = ".$pendaftaran_id);
        $criteria->order = "no_urutantri DESC"; //panggil terakhir
        $criteria->limit = 1;
        $model = ANInfokunjunganrjV::model()->find($criteria);
        if(!isset($model)){
            $model = new ANInfokunjunganrjV;
        }
        return $model;
    }
    /**
     * suara panggilan SINGLE no antrian (array)
     * akses dengan iframe
     */
    public function actionSuaraPanggilanSingle(){
        $this->layout = "//layouts/antrian";
        $kodeantrian = $_GET["kodeantrian"];
        $noantrian = $_GET["noantrian"];
        $ruangan_id = $_GET["ruangan_id"];
        $modRuangan = RuanganM::model()->findByPk($ruangan_id);
        $this->render('suaraPanggilanSingle',array('kodeantrian'=>$kodeantrian,'noantrian'=>$noantrian, 'modRuangan'=>$modRuangan));
    }
}
