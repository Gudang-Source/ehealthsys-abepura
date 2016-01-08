<?php
class PemeriksaanFisikAnamnesaRJController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
        public $defaultAction = 'index';
        public $path_view = 'pendaftaranPenjadwalan.views.pemeriksaanFisikAnamnesaRJ.';
	/**
	 * Lists all models.
	 */
	public function actionIndex($pendaftaran_id)
	{
            $modPendaftaran = PPPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
            $modPasien = PPPasienM::model()->findByPk($modPendaftaran->pasien_id);
            $this->render('index',array(
                'modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien,
            ));
	}
}
