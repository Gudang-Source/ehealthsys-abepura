<?php
class MutasiKerjaPegawaiController extends MyAuthController
{
	public $layout='//layouts/iframe';
    public $defaultAction = 'index';

    public function actionIndex($pegawai_id = null){
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
            $modPegmutasi->pegawai_id = $pegawai_id;
            $modPegmutasi->jenispromosi_mutasi = $_POST['KPPegmutasiR']['jenispromosi_mutasi'];
            $modPegmutasi->lokasikerja_baru = $_POST['KPPegmutasiR']['lokasikerja_baru'];
            if ($modPegmutasi->validate()) {
                if ($modPegmutasi->save()) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success','<strong>Berhasil </strong> Data berhasil disimpan');
                    $modPegmutasi->unsetAttributes();
                    $sukses=1;
                    $this->redirect(array('index','pegawai_id'=>$pegawai_id, 'sukses'=>$sukses));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error','<strong>Gagal </strong> Data gagal disimpan');
                }
            }
        }
        $this->render('index',array('model'=>$model, 'modPegmutasi'=>$modPegmutasi));
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

}