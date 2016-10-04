<?php
class MutasiKerjaPegawaiController extends MyAuthController
{
	public $layout='//layouts/iframe';
    public $defaultAction = 'index';

    public function actionIndex($pegawai_id = null){
		if (empty($pegawai_id)) $this->layout = "//layouts/column1";
		
	    $model = KPPegawaiM::model()->findByPk($pegawai_id);
	    $modPegmutasi = new KPPegmutasiR;
	    $transaction = Yii::app()->db->beginTransaction();
        if (isset($_POST['submitPegmutasi'])) {
            $modPegmutasi = new KPPegmutasiR;
            $modPegmutasi->attributes = $_POST['KPPegmutasiR'];
            $modPegmutasi->tglsk = MyFormatter::formatDateTimeForDb($_POST['KPPegmutasiR']['tglsk']);
            $modPegmutasi->tmtsk = MyFormatter::formatDateTimeForDb($_POST['KPPegmutasiR']['tmtsk']);

            if (empty($_POST['KPPegmutasiR']['tglsk'])) {
                $modPegmutasi->tglsk = null;
            }
            if (empty($_POST['KPPegmutasiR']['tmtsk'])) {
                $modPegmutasi->tmtsk = null;
            }
			if (!empty($pegawai_id)) $modPegmutasi->pegawai_id = $pegawai_id;
			else $modPegmutasi->pegawai_id = $_POST['PegawaiM']['pegawai_id'];
            $modPegmutasi->jenispromosi_mutasi = $_POST['KPPegmutasiR']['jenispromosi_mutasi'];
            $modPegmutasi->lokasikerja_baru = $_POST['KPPegmutasiR']['lokasikerja_baru'];
			
			// var_dump($_POST, $modPegmutasi->attributes, $modPegmutasi->validate(), $modPegmutasi->errors); die;
			
            if ($modPegmutasi->validate()) {
                if ($modPegmutasi->save()) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success','<strong>Berhasil </strong> Data berhasil disimpan');
                    $modPegmutasi->unsetAttributes();
                    $sukses=1;
                    if (!empty($pegawai_id)) $this->redirect(array('index','pegawai_id'=>$pegawai_id, 'sukses'=>$sukses));
					else $this->redirect(array('index', 'sukses'=>$sukses));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error','<strong>Gagal </strong> Data gagal disimpan');
                }
            }
        }
		if (empty($model)) $model = new PegawaiM;
        $this->render('index',array('model'=>$model, 'modPegmutasi'=>$modPegmutasi, 'pegawai_id'=>$pegawai_id));
    }

    /**
     * menampilkan mutasi pegawai
     * @return rows table
     */
    public function actionGetPegmutasi()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $pegawai_id = $_POST['pegawai_id'];
            $modPegmutasi = PegmutasiR::model()->findAllByAttributes(array('pegawai_id'=>$pegawai_id),array('order'=>'pegmutasi_id'));
            $i=1;
            $tr = '';
            foreach ($modPegmutasi as $row)
            {
                $urlDelete = $this->createUrl('deletePegmutasi',array('pegmutasi_id'=>$row->pegmutasi_id,'pegawai_id'=>$pegawai_id));
                $tr .= '<tr>';
                    $tr .= '<td>'.$i.' </td>';
                    $tr .= '<td>'.$row->nomorsurat.'</td>';
                    $tr .= '<td>'.$row->jabatan_nama.'</td>';
//                    $tr .= '<td>'.$row->pangkat_nama.'</td>';
                    $tr .= '<td>'.$row->nosk.'</td>';
                    $tr .= '<td>'. $row->tglsk .'</td>';
                    $tr .= '<td>'. $row->tmtsk .'</td>';
                    $tr .= '<td>'.$row->jabatan_baru.'</td>';
//                    $tr .= '<td>'.$row->pangkat_baru.'</td>';
                    $tr .= '<td>'.$row->mengetahui_nama.'</td>';
                    $tr .= '<td>'.$row->pimpinan_nama.'</td>';

                    $tr .= '<td>'.CHtml::link('<i class="icon-form-sampah"></i>',$urlDelete,array('onclick'=>'hapus(this); return false')).'</td>';
                $tr .= '</tr>';
                $i++;
            }

               $data['tr']=$tr;

               echo json_encode($data);
             Yii::app()->end();
        }
    }

    public function actiondeletePegmutasi($pegmutasi_id,$pegawai_id){
        $modPegmutasi = new KPPegmutasiR;
        if ($modPegmutasi->deleteByPK($pegmutasi_id)) {
            $this->redirect(array('index','pegawai_id'=>$pegawai_id));
        }
    }
    
    public function actionInformasi(){
        $this->layout = "//layouts/column1";
        $model = new KPPegmutasiR();
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        
        if (isset($_GET['KPPegmutasiR'])){
            $model->attributes = $_GET['KPPegmutasiR'];            
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['KPPegmutasiR']['tgl_awal']); 
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['KPPegmutasiR']['tgl_akhir']); 
            $model->nama_pegawai = $_GET['KPPegmutasiR']['nama_pegawai']; 
        }
        
        $this->render('informasi',array('model'=>$model));
    }

}