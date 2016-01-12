<?php
class PemeriksaanGiziController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
        public $defaultAction = 'index';
        public $path_view = 'gizi.views.pemeriksaanGizi.';
	/**
	 * Lists all models.
	 */
	public function actionIndex($pendaftaran_id,$pasien_id,$pasienadmisi_id)
	{
            $modPendaftaran = GZPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
            $modPasien = GZPasienM::model()->findByPk($modPendaftaran->pasien_id);
            $this->render('index',array(
                'modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien,
            ));
	}
}
