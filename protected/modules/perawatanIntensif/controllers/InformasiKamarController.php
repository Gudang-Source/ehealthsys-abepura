<?php

class InformasiKamarController extends MyAuthController
{
	public function actionIndex()
	{
                $modKamarRuangan = new RIKamarRuanganM;
                $trInformasiHarga='';
                $jumlahTempatTidur=0;
                $dataTempatTidur=array();
                $fotoKamar='';
                $formKasur='';
                $noKamar='';
                $kelasPelayanan='';
                $idKelasPelayanan='';
                $sqlKelas='';
                $sqlKamar='';
                $fotoTampil='';
                
                $idRuangan=Yii::app()->user->getState('ruangan_id');
                $modRuangan=RIRuanganM::model()->findByPk($idRuangan);
                
                if(isset ($_POST['RIKamarRuanganM']['kelaspelayanan_id'])){
                    $idKelasPelayanan=$_POST['RIKamarRuanganM']['kelaspelayanan_id'];
                }
                
                if(isset ($_POST['RIKamarRuanganM']['kamarruangan_nokamar'])){
                    $noKamar=$_POST['RIKamarRuanganM']['kamarruangan_nokamar'];
                }
                
                if($idKelasPelayanan!=''){
                    $sqlKelas=" AND kelaspelayanan_id=".$idKelasPelayanan."";
                }
                
                if($noKamar!=''){
                    $sqlKamar=" AND kamarruangan_nokamar='".$noKamar."'";
                }
                if (isset ($_POST['RIKamarRuanganM'])) {
                 
                    $sqlKamar="SELECT DISTINCT(kamarruangan_nokamar),kelaspelayanan_id,ruangan_id
                               FROM kamarruangan_m
                               WHERE ruangan_id=".$idRuangan."".$sqlKelas."".$sqlKamar."
                               ORDER BY kamarruangan_nokamar ASC";
                    
                    $dataNoKamar= Yii::app()->db->createCommand($sqlKamar)->query();
                      
                    foreach ($dataNoKamar AS $tampilDataNoKamar):
                        $trInformasiHarga='';
                        $trTotal='';
                        $idKelasPelayanan=$tampilDataNoKamar['kelaspelayanan_id'];
                        $noKomar=$tampilDataNoKamar['kamarruangan_nokamar'];
                        $idRuangan=$tampilDataNoKamar['ruangan_id'];
//==============================Awal Mencari Tarif Kamar    
                        $sql="SELECT 
                              tariftindakan_m.daftartindakan_id, 
                              daftartindakan_m.daftartindakan_nama, 
                              daftartindakan_m.daftartindakan_akomodasi, 
                              komponentarif_m.komponentarif_nama, 
                              kamarruangan_m.kamarruangan_nokamar,
                              kamarruangan_m.kelaspelayanan_id,
                              tariftindakan_m.harga_tariftindakan,
                              komponentarif_m.komponentarif_id,
                              kamarruangan_m.kamarruangan_jmlbed,
                              kamarruangan_m.kamarruangan_image
                            FROM 
                              public.daftartindakan_m, 
                              public.tindakanruangan_m, 
                              public.tariftindakan_m, 
                              public.komponentarif_m, 
                              public.kamarruangan_m
                            WHERE 
                              tindakanruangan_m.daftartindakan_id = daftartindakan_m.daftartindakan_id AND
                              tindakanruangan_m.ruangan_id = kamarruangan_m.ruangan_id AND
                              tariftindakan_m.daftartindakan_id = daftartindakan_m.daftartindakan_id AND
                              komponentarif_m.komponentarif_id = tariftindakan_m.komponentarif_id AND
                              daftartindakan_m.daftartindakan_akomodasi=TRUE AND
                              kamarruangan_m.kelaspelayanan_id=".$idKelasPelayanan." AND
                              kamarruangan_m.kamarruangan_nokamar='".$noKomar."' AND   
                              kamarruangan_m.ruangan_id=".$idRuangan."    
                              GROUP BY kamarruangan_m.kelaspelayanan_id,kamarruangan_m.kamarruangan_nokamar,
                                       komponentarif_m.komponentarif_nama,daftartindakan_m.daftartindakan_akomodasi,
                                       daftartindakan_m.daftartindakan_nama, komponentarif_m.komponentarif_id,
                                       tariftindakan_m.daftartindakan_id,daftartindakan_m.daftartindakan_id,
                                       harga_tariftindakan,kamarruangan_jmlbed,kamarruangan_m.kamarruangan_image
                              ORDER BY komponentarif_m.komponentarif_id ASC";
                        $dataTarif= Yii::app()->db->createCommand($sql)->query();
                        foreach($dataTarif AS $tampiltarif):
                            if($tampiltarif['komponentarif_id']!=Params::KOMPONENTARIF_ID_TOTAL){
                            $trInformasiHarga .="<tr>
                                                    <td width=\"200px\">".$tampiltarif['komponentarif_nama']."</td>
                                                    <td>".$tampiltarif['harga_tariftindakan']."</td>    
                                                  </tr>";
                            }else{
                                 $trTotal .="<tr>
                                                    <td>".$tampiltarif['komponentarif_nama']."</td>
                                                    <td>".$tampiltarif['harga_tariftindakan']."</td>    
                                                  </tr>";
                            }
                        $fotoKamar=$tampiltarif['kamarruangan_image'];    
                        $jumlahTempatTidur= $tampiltarif['kamarruangan_jmlbed'];
                        $kelasPelayanan=  RIKelasPelayananM::model()->findBYPk($tampiltarif['kelaspelayanan_id'])->kelaspelayanan_nama;
                        $noKamar=$tampiltarif['kamarruangan_nokamar'];
                        if($fotoKamar!=''){
                            $fotoTampil=$fotoKamar;
                        }else{
                             $fotoTampil='no_photo.jpeg';
                        }
                            
                        endforeach;
                        $trInformasiHarga ='<table>'.$trInformasiHarga.$trTotal.'</table>';
                        
                        $dataTempatTidur=RIKamarRuanganM::model()->findAll('ruangan_id='.$idRuangan.' 
                                                                    AND kelaspelayanan_id='.$idKelasPelayanan.'
                                                                    AND kamarruangan_nokamar=\''.$noKomar.'\' 
                                                                    ORDER BY kamarruangan_nobed ASC');
                
                
                     $col = 3;
                     $cnt =0;
                     $batas   = 999999999;
                     $formKasur .='<div class="boxInformasi">
                                    <fieldset>
                                    <legend>Data No. Kamar :'.$tampilDataNoKamar['kamarruangan_nokamar'].'</legend>
                                      <table align="center" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td colspan='.$col.'>
                                            <table>
                                                <tr>
                                                    <td>
                                                        <fieldset>
                                                            <legend>Informasi Harga</legend>
                                                            '.$trInformasiHarga.'
                                                        </fieldset>
                                                   </td>
                                                   <td>
                                                        <fieldset>
                                                            <legend>Informasi Kamar</legend>
                                                            Jumlah Tempat Tidur :'.$jumlahTempatTidur.'<br/>
                                                            Kelas Pelayanan :'.$kelasPelayanan.'<br/>
    
                                                        </fieldset>
                                                   </td>
                                                   <td>
                                                        <fieldset>
                                                            <legend>Foto Kamar</legend>
                                                        <img src="'.Params::urlKamarRuanganTumbsDirectory().'kecil_'.$fotoTampil.'">
                                                          </fieldset>  
                                                    </td>
                                               </tr>
                                            </table>   
                                        </td>
                                     </tr>   
                                        ';
                     foreach ($dataTempatTidur as $tampilTempatTidur) :
                           if ($cnt >= $col) 
                            {
                               $formKasur .='<tr>';
                               $cnt = 0;
                            }
                            $cnt++;

                            if($tampilTempatTidur['kamarruangan_status'] == false){//Jika Terisi
                                $modMasukKamar=  RIMasukKamarT::model()->find('kamarruangan_id='.$tampilTempatTidur['kamarruangan_id'].' AND
                                                                               tglkeluarkamar isNUll AND
                                                                               jamkeluarkamar isNULL ORDER BY
                                                                               tglmasukkamar DESC');

                               if(isset($modMasukKamar->pasienadmisi_id)){
                                    $modPasienAdmisi= RIPasienAdmisiT::model()->findByPk($modMasukKamar->pasienadmisi_id);
                                    $modPasien=RIPasienM::model()->findByPk($modPasienAdmisi->pasien_id);
                                    $modPendaftaran=RIPendaftaranT::model()->findByPk($modPasienAdmisi->pendaftaran_id);
                               }
                                $formKasur .='<td>
                                            <div class="boxrepeat ranjangIsi">
                                                <table cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td>NO RM : <b>'.(isset($modPasien->no_rekam_medik) ? $modPasien->no_rekam_medik : "").'</b><br/>
                                                        No. Pendaftaran : <b>'.(isset($modPendaftaran->no_pendaftaran) ? $modPendaftaran->no_pendaftaran : "").'</b><br/>
                                                        No. Kasur :<b>'.(isset($tampilTempatTidur['kamarruangan_nobed']) ? $tampilTempatTidur['kamarruangan_nobed'] : "").'</b><br/>
                                                        Nama : <b>'.(isset($modPasien->nama_pasien) ? $modPasien->nama_pasien : "").'</b><br/>
                                                        Status : <b>Terisi<b><br/>
                                                        Jenis Kelamin : <b>'.(isset($modPasien->jeniskelamin) ? $modPasien->jeniskelamin : "").'</b></td>
                                                    </tr>
                                                </table>    
                                            </div>                
                                         </td>';
                            }else{
                            
                                $formKasur .='<td>
                                            <div class="boxrepeat ranjangKosong">
                                            No. Kasur : 
                                                '.$tampilTempatTidur['kamarruangan_nobed'].'<br/>'.
                                                    CHtml::htmlButton(Yii::t('mds','{icon} Kosong',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')),
                                                            array('class'=>'btn btn-danger', 'type'=>'button','id'=>'btn_simpan')).'
                                            <br/><br/><br/><br/><br/>
                                            </div>                
                                         </td>';
                            }
                        endforeach;

                        $formKasur .='</tr></table>
                            </fieldset>
                            </div>
                           <hr style="color: #00F"> '; 
                    endforeach;
//==============================Akhir Mencari Tarif Kamar   

                }

                $this->render('index',array('modKamarRuangan'=>$modKamarRuangan,
                                            'modRuangan'=>$modRuangan,
                                            'trInformasiHarga'=>$trInformasiHarga,
                                            'jumlahTempatTidur'=>$jumlahTempatTidur,
                                            'dataTempatTidur'=>$dataTempatTidur,
                                            'formKasur'=>$formKasur,
                                            'fotoKamar'=>$fotoKamar,
                                            'idRuangan'=>$idRuangan,
                                            'noKamar'=>$noKamar,
                                            'kelasPelayanan'=>$kelasPelayanan));
				
		
                
	}

	 /*
	* Mencari kamarruangan berdasarkan ruangan berdasarkan Kelaspelayanan_id di tabel kelas Ruangan M
	* and open the template in the editor.
	*/
	   public function actionGetRuanganNoKamarRuangan($encode=false,$namaModel='')
	   {
		   if(Yii::app()->request->isAjaxRequest) {
			   $idKelasPelayanan= $_POST["$namaModel"]['kelaspelayanan_id'];
			   $noKamar= KamarruanganM::model()->findAll('kelaspelayanan_id='.$idKelasPelayanan.'');

			   $noKamar=CHtml::listData($noKamar,'kamarruangan_nokamar','kamarruangan_nokamar');

			   if(empty($noKamar)){
				   echo CHtml::tag('option', array('value'=>''),CHtml::encode('-Pilih-'),true);
			   }else{
				   echo CHtml::tag('option', array('value'=>''),CHtml::encode('-Pilih-'),true);
				   foreach($noKamar as $value=>$name)
				   {
					   echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
				   }
			   }
		   }
		   Yii::app()->end();
	   }    
}