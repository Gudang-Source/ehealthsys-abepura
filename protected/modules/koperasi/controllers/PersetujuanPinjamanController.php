<?php

class PersetujuanPinjamanController extends MyAuthController
{
	public $layout='//layouts/column1';
	
	public function actionIndex()
	{
            $insert_notifikasi = new CustomFunction();
            $permintaan = new InformasipermohonanpinjamanV;
            $approval = new ApprovalT;
                                                                                                            

            $konfig = KonfigkoperasiK::model()->find(array('condition'=>'status_aktif = true', 'order'=>'konfigkoperasi_id asc'));
            
            $ok = true;
            if (isset($_POST['ApprovalT'])) {
                    $trans = Yii::app()->db->beginTransaction();
                    $idPermintaan = $_POST['InformasipermohonanpinjamanV']['permohonanpinjaman_id'];
                    // var_dump($_POST); die;
                    $approval->attributes = $_POST['ApprovalT'];
                    $approval->tglapproval = MyFormatter::formatDateTimeForDb($approval->tglapproval).":00";
                    $approval->appr_tgldiperiksa = MyFormatter::formatDateTimeForDb($approval->appr_tgldiperiksa).":00";
                    $approval->appr_tgldisetujui = MyFormatter::formatDateTimeForDb($approval->appr_tgldisetujui).":00";
                    $approval->appr_create_time = date('Y-m-d H:i:s');
                    $approval->appr_create_login = Yii::app()->user->name;

                    $persetujuan = InformasipermohonanpinjamanV::model()->findByAttributes(array('approval_id'=>$approval->approval_id));
                    if (isset($persetujuan))
                            {
                                    if($persetujuan->status_disetujui == true)
                                    {
                                            $status = "DiSetujui";
                                    }
                                    else {
                                            $status = "Tidak Disetujui";
                                    }
                            }
                    $approved = PegawaiM::model()->findByPk($approval->appr_disetujuioleh_id);
                    //insert notifikasi
                    $params['tglnotifikasi'] = date( 'Y-m-d H:i:s');
                    $params['create_time'] = date( 'Y-m-d H:i:s');
                    $params['create_loginpemakai_id'] = Yii::app()->user->id;
                    $params['isinotifikasi'] = $status . ', Rp' . MyFormatter::formatNumberForPrint($persetujuan->jmlpinjaman) . '<br/>' . $persetujuan->nopermohonan . ', ' . MyFormatter::formatDateTimeId($persetujuan->tglpermohonanpinjaman) . '<br/> Disetujui Oleh : ' . $approved->nama_pegawai;
                    $params['judulnotifikasi'] = 'Persetujuan Pinjaman';
                    $nofitikasi = $insert_notifikasi->insertNotifikasi($params);

                    if ($approval->validate()){
                        $ok = $ok && $approval->save();
                        $ok = $ok && PermohonanpinjamanT::model()->updateByPk($idPermintaan, array('approval_id'=>$approval->approval_id, 'per_update_time'=>date('Y-m-d H:i:s'), 'per_update_login'=>Yii::app()->user->id));
                    }
                    
                    if ($ok) {
				$res['ok'] = 1;
				$trans->commit();
			} else {
				$res['ok'] = 0;
				$trans->rollback();
			}
                   
            }



            $this->render('index', array(
                    'permintaan'=>$permintaan,
                    'approval'=>$approval,                
            ));
	}
	
}
