<?php
Yii::import('laboratorium.controllers.PemakaianBmhpController');
class PemakaianBahanController extends PemakaianBmhpController
{
    public $path_view = "laboratorium.views.pemakaianBahan.";
    public $path_view_bmhp = "laboratorium.views.pemakaianBmhp.";
    public $obatalkespasientersimpan = true; //dilooping
    
    public function actionPrint($pasienmasukpenunjang_id) 
    {
        $this->layout='//layouts/printWindows';
        $format = new MyFormatter;    
        $modPasienMasukPenunjang = LBPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id));     
        $modObatAlkesPasien = LBObatalkespasienT::model()->findAllByAttributes(array('pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id));

        $judul_print = 'Pemakaian Bahan '.$modPasienMasukPenunjang->ruangan_nama;
        $this->render($this->path_view.'printPemakaianBahan', array(
                            'format'=>$format,
                            'judul_print'=>$judul_print,
                            'modPasienMasukPenunjang'=>$modPasienMasukPenunjang,
                            'modObatAlkesPasien'=>$modObatAlkesPasien,
        ));
    }
	
	public function actionAddFormPemakaianBahan()
    {
        if (Yii::app()->request->isAjaxRequest)
        {
            $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
            $idObatAlkes = (isset($_POST['idObatAlkes']) ? $_POST['idObatAlkes'] : null);
            $idDaftartindakan = (isset($_POST['idDaftartindakan']) ? $_POST['idDaftartindakan'] : "");
            $modObatAlkes = ObatalkesM::model()->findByPk($idObatAlkes);
            $modDaftartindakan = DaftartindakanM::model()->findByPk($idDaftartindakan);
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $persenjual = $this->persenJualRuangan();
            $modObatAlkes->hargajual = floor(($persenjual + 100 ) / 100 * $modObatAlkes->hargajual);
            
            echo CJSON::encode(array(
                'pendaftaran_id'=>$pendaftaran_id,
                'namaObat'=>$modObatAlkes->obatalkes_nama,
                'form'=>$this->renderPartial('_formAddPemakaianBahan', array('modObatAlkes'=>$modObatAlkes,'modDaftartindakan'=>$modDaftartindakan,
                    'modPendaftaran'=>$modPendaftaran,
                    ), true),
                ));
            exit;               
        }
    }
    
    public function actionInformasi() {
        $model = new LBObatalkespasienT;
        $model->unsetAttributes();
        $model->tglAwal = date('Y-m-d H:i:s', time() - (3600 * 24 * 10));
        $model->tglAkhir = date('Y-m-d H:i:s');
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        if (isset($_GET['LBObatalkespasienT'])) {
            $model->attributes = $_GET['LBObatalkespasienT'];
            $model->tglAwal = MyFormatter::formatDateTimeForDb($_GET['LBObatalkespasienT']['tglAwal']);
            $model->tglAkhir = MyFormatter::formatDateTimeForDb($_GET['LBObatalkespasienT']['tglAkhir']);
            
            $model->no_pendaftaran = $_GET['LBObatalkespasienT']['no_pendaftaran'];
            $model->no_rekam_medik = $_GET['LBObatalkespasienT']['no_rekam_medik'];
            $model->nama_pasien = $_GET['LBObatalkespasienT']['nama_pasien'];
            $model->carabayar_id = $_GET['LBObatalkespasienT']['carabayar_id'];
            $model->penjamin_id = $_GET['LBObatalkespasienT']['penjamin_id'];
            
            $model->jenisobatalkes_id = $_GET['LBObatalkespasienT']['jenisobatalkes_id'];
            $model->obatalkes_kategori = $_GET['LBObatalkespasienT']['obatalkes_kategori'];
            $model->obatalkes_golongan = $_GET['LBObatalkespasienT']['obatalkes_golongan'];
            $model->obatalkes_nama = $_GET['LBObatalkespasienT']['obatalkes_nama'];
        }
        $this->render('laboratorium.views.pemakaianBahan.informasi', array('model' => $model));
    }

 
}