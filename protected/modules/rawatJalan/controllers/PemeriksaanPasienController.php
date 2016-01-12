<?php
class PemeriksaanPasienController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
        public $defaultAction = 'index';
        public $path_view = 'rawatJalan.views.pemeriksaanPasien.';
	/**
	 * Lists all models.
	 */
	public function actionIndex($pendaftaran_id)
	{
            $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
            $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
            $this->render('index',array(
                'modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien,
            ));
	}
	
	public function actionLoadFormDiagnosis()
    {
        if (Yii::app()->request->isAjaxRequest)
        {
            $idDiagnosa = (isset($_POST['idDiagnosa']) ? $_POST['idDiagnosa'] : null);
            $idKelDiagnosa = (isset($_POST['idKelDiagnosa']) ? $_POST['idKelDiagnosa'] : null);
            $tglDiagnosa = (isset($_POST['tglDiagnosa']) ? $_POST['tglDiagnosa'] : null);
            
			if(!empty($idKelDiagnosa)){
				$modDiagnosaicdixM = DiagnosaicdixM::model()->findAll();
				$modSebabDiagnosa = SebabdiagnosaM::model()->findAll();
				$modDiagnosa = DiagnosaM::model()->findByPk($idDiagnosa);

				echo CJSON::encode(array(
					'status'=>'create_form', 
					'form'=>$this->renderPartial('/diagnosa/_formLoadDiagnosis', array('modDiagnosa'=>$modDiagnosa,
							'idKelDiagnosa'=>$idKelDiagnosa,
							'modDiagnosaicdixM'=>$modDiagnosaicdixM,
							'modSebabDiagnosa'=>$modSebabDiagnosa,
				   'tglDiagnosa'=>$tglDiagnosa), true)));
				exit;
			}else{
				echo CJSON::encode(array('status'=>'fail','pesan'=>'Pilih terlebih dahulu kelompok diagnosa!'));
				exit;
			}
			
                           
        }
    }

    public function actionSaveDiagnosis()
    {    
        if (Yii::app()->request->isAjaxRequest)
        {
            $IdPendaftaran = $_POST['IdPendaftaran'];
            $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByAttributes(array('pendaftaran_id'=>$IdPendaftaran));
            
            $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
            $morbiditas = new RJPasienMorbiditasT;
            $morbiditas->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            $morbiditas->pasien_id = $modPendaftaran->pasien_id;
            $morbiditas->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $morbiditas->kelompokumur_id = $modPasien->kelompokumur_id;
            $morbiditas->golonganumur_id = $modPendaftaran->golonganumur_id;
            $morbiditas->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
            $morbiditas->pegawai_id = $modPendaftaran->pegawai_id;
            $morbiditas->diagnosa_id = $_POST['idDiagnosa'];
            $morbiditas->kelompokdiagnosa_id = $_POST['kelompokDiagnosa'];
            $morbiditas->infeksinosokomial = '0';
            $morbiditas->tglmorbiditas = (isset($_POST['tglDiagnosa']) ? $_POST['tglDiagnosa'] : null);

            $modMorbiditas = PasienmorbiditasT::model()->findByAttributes(array('pasien_id'=>$modPendaftaran->pasien_id,'diagnosa_id'=>$morbiditas->diagnosa_id));
            if(!empty($modMorbiditas))
                $morbiditas->kasusdiagnosa = Params::KASUSDIAGNOSA_KASUS_LAMA;
            else 
                $morbiditas->kasusdiagnosa = Params::KASUSDIAGNOSA_KASUS_BARU;

            $valid = $morbiditas->validate();
            if($valid){
                $morbiditas->save();
            }
            
        }
    }

    public function actionHapusDiagnosis()
    {    
        if (Yii::app()->request->isAjaxRequest)
        {
            $IdPendaftaran = $_POST['IdPendaftaran'];
            $idDiagnosa    = $_POST['idDiagnosa'];

            $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByAttributes(array('pendaftaran_id'=>$IdPendaftaran));

            PasienmorbiditasT::model()->deleteAllByAttributes(array('diagnosa_id'=>$idDiagnosa,'pendaftaran_id'=>$modPendaftaran->pendaftaran_id));
        }
    }
}
