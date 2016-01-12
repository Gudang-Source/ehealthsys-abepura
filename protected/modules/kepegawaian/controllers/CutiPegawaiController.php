<?php
class CutiPegawaiController extends MyAuthController
{
	public $layout='//layouts/iframe';
    public $defaultAction = 'index';

    public function actionIndex($pegawai_id = null){
	    $model = KPPegawaiM::model()->findByPk($pegawai_id);
	    $modPegawaicuti = new KPPegawaicutiT;
	    $transaction = Yii::app()->db->beginTransaction();
        if (isset($_POST['submitPegawaicuti'])) {
            $modPegawaicuti = new KPPegawaicutiT;
            $modPegawaicuti->pegawai_id = $pegawai_id;
            $modPegawaicuti->attributes = $_POST['KPPegawaicutiT'];
            $modPegawaicuti->tglmulaicuti = MyFormatter::formatDateTimeForDb($_POST['KPPegawaicutiT']['tglmulaicuti']);
            $modPegawaicuti->tglakhircuti = MyFormatter::formatDateTimeForDb($_POST['KPPegawaicutiT']['tglakhircuti']);
            $modPegawaicuti->tglditetapkanskcuti = MyFormatter::formatDateTimeForDb($_POST['KPPegawaicutiT']['tglditetapkanskcuti']);

            if (empty($_POST['KPPegawaicutiT']['tglakhircuti'])) {
                $modPegawaicuti->tglakhircuti = null;
            }
            if ($modPegawaicuti->validate()) {
                if ($modPegawaicuti->save()) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success','<strong>Berhasil </strong> Data berhasil disimpan');
                    $modPegawaicuti->unsetAttributes();
                    $sukses=1;
                    $this->redirect(array('index','pegawai_id'=>$pegawai_id, 'sukses'=>$sukses));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error','<strong>Gagal </strong> Data gagal disimpan');
                }
            }
        }
        $this->render('index',array('model'=>$model, 'modPegawaicuti'=>$modPegawaicuti));
    }

    /**
     * menampilkan cuti pegawai
     * @return rows table
     */
    public function actionGetPegawaicuti()
    {
        if (Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter;
            $pegawai_id = $_POST['pegawai_id'];
            $modPegawaicuti = PegawaicutiT::model()->findAllByAttributes(array('pegawai_id'=>$pegawai_id),array('order'=>'tglmulaicuti'));
            $i=1;
            $tr = '';
            foreach ($modPegawaicuti as $row)
            {
                $urlDelete = $this->createUrl('deletePegawaicuti',array('pegawaicuti_id'=>$row->pegawaicuti_id,'pegawai_id'=>$pegawai_id));
                $tr .= '<tr>';
                    $tr .= '<td>'.$i.' </td>';
                    $tr .= '<td>'.$row->jeniscuti_id.'</td>';
                    $tr .= '<td>'.$format->formatDateTimeForUser($row->tglmulaicuti).' s/d '.$format->formatDateTimeForUser($row->tglakhircuti).'</td>';
                    $tr .= '<td>'.$row->lamacuti.' hari'.'</td>';
                    $tr .= '<td>'.$row->noskcuti.'</td>';
                    $tr .= '<td>'.$format->formatDateTimeForUser($row->tglditetapkanskcuti).'</td>';
                    $tr .= '<td>'.$row->keperluancuti.'</td>';
                    $tr .= '<td>'.$row->keterangan.'</td>';
                    $tr .= '<td>'.$row->pejabatmengetahui.'</td>';
                    $tr .= '<td>'.$row->pejabatmenyetujui.'</td>';
                    $tr .= '<td>'.CHtml::link('<i class="icon-form-sampah"></i>',$urlDelete,array('onclick'=>'hapus(this); return false')).'</td>';
                $tr .= '</tr>';
                $i++;
            }

               $data['tr']=$tr;

               echo json_encode($data);
             Yii::app()->end();
        }
    }

    public function actiondeletePegawaicuti($pegawaicuti_id,$pegawai_id){
        $modPegawaicuti = new KPPegawaicutiT;
        if ($modPegawaicuti->deleteByPK($pegawaicuti_id)) {
            $this->redirect(array('index','pegawai_id'=>$pegawai_id));
        }
    }

}