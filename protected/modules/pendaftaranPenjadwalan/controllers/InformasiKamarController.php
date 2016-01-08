<?php

class InformasikamarController extends MyAuthController {

    public $layout = '//layouts/column1';
    public $defaultAction = 'admin';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    
	public function actionIndex()
	{
                $modKamarRuangan = new PPKamarruanganM;
                $trInformasiHarga='';
                $jumlahTempatTidur=0;
                $dataTempatTidur=array();
                $fotoKamar='';
                $formKasur='';
                $noKamar='';
                $kelasPelayanan='';
                
                $idRuangan = Yii::app()->user->getState('ruangan_id');
//                $idRuangan = 139;
                $modRuangan = PPRuanganM::model()->findByPk($idRuangan);
                
                $idKelasPelayanan = '';
                if(isset ($_POST['PPKamarruanganM']['kelaspelayanan_id'])){
                    $idKelasPelayanan=$_POST['PPKamarruanganM']['kelaspelayanan_id'];
                }
                
                $noKamar = '';
                if(isset ($_POST['PPKamarruanganM']['kamarruangan_nokamar'])){
                    $noKamar=$_POST['PPKamarruanganM']['kamarruangan_nokamar'];
                }
                
                $sqlKelas = '';
                if($idKelasPelayanan!=''){
                    $sqlKelas=" AND kelaspelayanan_id=".$idKelasPelayanan."";
                }
                
                $sqlKamar = '';
                if($noKamar!=''){
                    $sqlKamar=" AND kamarruangan_nokamar='".$noKamar."'";
                }
                
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
                            if($tampiltarif['komponentarif_id'] != Params::KOMPONENTARIF_ID_TOTAL)
                            {
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
                            
                            $kelasPelayanan = PPKelasPelayananM::model()->findBYPk(
                                $tampiltarif['kelaspelayanan_id']
                            )->kelaspelayanan_nama;
                            $noKamar=$tampiltarif['kamarruangan_nokamar'];
                            if($fotoKamar!=''){
                                $fotoTampil=$fotoKamar;
                            }else{
                                 $fotoTampil='no_photo.jpeg';
                            }
                        endforeach;
                        
                        $trInformasiHarga ='<table>'.$trInformasiHarga.$trTotal.'</table>';
                        $dataTempatTidur=PPKamarruanganM::model()->findAll('
                            ruangan_id='.$idRuangan.'
                            AND kelaspelayanan_id='.$idKelasPelayanan.'
                            AND kamarruangan_nokamar=\''.$noKomar.'\'
                            ORDER BY kamarruangan_nobed ASC
                        ');
                
                
                     $col = 3;
                     $cnt =0;
                     $batas   = 999999999;
                     $formKasur .='<div class="boxInformasi">
                                    <fieldset>
                                    <legend>Data No. Kamar :'.$tampilDataNoKamar['kamarruangan_nokamar'].'</legend>
                                      <table width="100%" align="center" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td width="40%" colspan='.$col.'>
                                            <fieldset class="box2">
                                            <legend>Informasi Harga</legend>
                                            <table>
                                                <tr>
                                                    <td>
                                                        '.$trInformasiHarga.'
                                                   </td>
                                                   <td width="40%">
                                                        <fieldset class="box2">
                                                            <legend>Informasi Kamar</legend>
                                                            Jumlah tempat Tidur :'.$jumlahTempatTidur.'<br/>
                                                            Kelaspelayanan :'.$kelasPelayanan.'<br/>
    
                                                        </fieldset>
                                                   </td>
                                                   <td width="20%">
                                                        <fieldset class="box2">
                                                            <legend>Foto Kamar</legend>
                                                        <img src="'.Params::urlKamarRuanganTumbsDirectory().(($fotoTampil=="") ?'kecil_'.$fotoTampil:'no_photo.jpeg').'">
                                                          </fieldset>  
                                                    </td>
                                               </tr>
                                            </table>
                                            </fieldset>
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
                            
                            if($tampilTempatTidur['kamarruangan_status'] == 1)
                            {
                                ////Jika Terisi
                                $modMasukKamar = MasukkamarT::model()->find('
                                    kamarruangan_id = '.$tampilTempatTidur['kamarruangan_id'].' AND
                                    tglkeluarkamar IS NUll AND
                                    jamkeluarkamar IS NULL ORDER BY tglmasukkamar DESC
                                ');
                                
                                
                                $modPasienAdmisi= PasienadmisiT::model()->findByPk($modMasukKamar->pasienadmisi_id);
                                $modPasien=PPPasienM::model()->findByPk($modPasienAdmisi->pasien_id);
                                $modPendaftaran=PPPendaftaranT::model()->find('pasien_id='.$modPasien->pasien_id.'');
                                $formKasur .='<td>
                                            <div class="boxrepeat ranjangIsi">
                                                <table width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td>NO RM : <b>'.$modPasien->no_rekam_medik.'</b><br/>
                                                        No. Pendaftaran : <b>'.$modPendaftaran->no_pendaftaran.'</b><br/>
                                                        No. Kasur :<b>'.$tampilTempatTidur['kamarruangan_nobed'].'</b><br/>
                                                        Nama : <b>'.$modPasien->nama_pasien.'</b><br/>
                                                        Status : <b>Terisi<b><br/>
                                                        Jenis Kelamin : <b>'.$modPasien->jeniskelamin.'</b></td>
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

    public function actionAdmin() {
        $detail = new PPKamarruanganM;
        $ruangan = new PPRuanganM;
        $this->render('admin', array(
            'detail' => $detail, 'ruangan' => $ruangan,
        ));
    }
    
    public function actionGetInfoKamar()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $idRuangan = $_POST['idRuangan'];
            $modRuangan = PPRuanganM::model()->findByPk($idRuangan);
            
            $data_ruangan = array(
                'nama'=>(($modRuangan->ruangan_nama == '' || is_null($modRuangan->ruangan_nama)) ? '' : $modRuangan->ruangan_nama ),
                'foto'=>(($modRuangan->ruangan_image == '' || is_null($modRuangan->ruangan_image)) ? '' : Yii::app()->baseUrl . '/data/images/ruangan/tumbs/' . $modRuangan->ruangan_image ),
                'fasilitas'=>(($modRuangan->ruangan_fasilitas == '' || is_null($modRuangan->ruangan_fasilitas)) ? '' : $modRuangan->ruangan_fasilitas )
            );
            $data = array(
                'data_ruangan'=>$data_ruangan,
            );
            echo json_encode($data);
            Yii::app()->end();            
        }
    }
    
    public function actionGetDetailKamar()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $ruangan_id = $_POST['ruangan_id'];
            $kelaspelayanan_id = $_POST['kelaspelayanan_id'];
            $kamarruangan_nokamar = $_POST['kamarruangan_nokamar'];
            $jumlahTempatTidur=0;
            $query = "
               SELECT DISTINCT(kamarruangan_nokamar),kelaspelayanan_id, ruangan_id
               FROM kamarruangan_m
               WHERE ruangan_id = '". $ruangan_id ."' AND kelaspelayanan_id = '". $kelaspelayanan_id ."' AND kamarruangan_nokamar = '". $kamarruangan_nokamar ."'
               ORDER BY kamarruangan_nokamar ASC
           ";
            $rec = Yii::app()->db->createCommand($query)->query();
            
            $trInformasiHarga = '';
            $trTotal = '';
            $trInformasiHarga = '';
            $formKasur = '';
            foreach($rec as $data_ruangan)
            {
                $sql = "
                    SELECT 
                        tariftindakan_m.daftartindakan_id, 
                        daftartindakan_m.daftartindakan_nama, 
                        daftartindakan_m.daftartindakan_akomodasi, 
                        komponentarif_m.komponentarif_nama, 
                        kamarruangan_m.kamarruangan_nokamar,
                        kamarruangan_m.kelaspelayanan_id,
                        tariftindakan_m.harga_tariftindakan,
                        komponentarif_m.komponentarif_id,
                        kamarruangan_m.kamarruangan_jmlbed,
                        kamarruangan_m.kamarruangan_image,
                        penjaminpasien_m.penjamin_nama
                    FROM 
                        public.daftartindakan_m, 
                        public.tindakanruangan_m, 
                        public.tariftindakan_m, 
                        public.komponentarif_m, 
                        public.kamarruangan_m,
                        public.jenistarifpenjamin_m,
                        public.penjaminpasien_m
                    WHERE 
                        tindakanruangan_m.daftartindakan_id = daftartindakan_m.daftartindakan_id AND
                        tindakanruangan_m.ruangan_id = kamarruangan_m.ruangan_id AND
                        tariftindakan_m.daftartindakan_id = daftartindakan_m.daftartindakan_id AND
                        komponentarif_m.komponentarif_id = tariftindakan_m.komponentarif_id AND
                        daftartindakan_m.daftartindakan_akomodasi = TRUE AND
                        kamarruangan_m.kelaspelayanan_id = '". $data_ruangan['kelaspelayanan_id'] ."' AND
                        kamarruangan_m.kamarruangan_nokamar = '". $data_ruangan['kamarruangan_nokamar'] ."' AND   
                        kamarruangan_m.ruangan_id = '". $data_ruangan['ruangan_id'] ."' AND 
                        tariftindakan_m.jenistarif_id = jenistarifpenjamin_m.jenistarif_id AND 
                        jenistarifpenjamin_m.penjamin_id = penjaminpasien_m.penjamin_id AND jenistarifpenjamin_m.penjamin_id = 1
                    GROUP BY kamarruangan_m.kelaspelayanan_id,kamarruangan_m.kamarruangan_nokamar,
                        komponentarif_m.komponentarif_nama,daftartindakan_m.daftartindakan_akomodasi,
                        daftartindakan_m.daftartindakan_nama, komponentarif_m.komponentarif_id,
                        tariftindakan_m.daftartindakan_id,daftartindakan_m.daftartindakan_id,
                        harga_tariftindakan,kamarruangan_jmlbed,kamarruangan_m.kamarruangan_image, penjaminpasien_m.penjamin_nama
                    ORDER BY komponentarif_m.komponentarif_id ASC
                ";
                $dataTarif= Yii::app()->db->createCommand($sql)->query();
                foreach($dataTarif AS $tampiltarif)
                {
                    if($tampiltarif['komponentarif_id'] != Params::KOMPONENTARIF_ID_TOTAL)
                    {
                        $trInformasiHarga .= "<tr>
                            <td width=\"200px\">".$tampiltarif['penjamin_nama']."</td>
                            <td width=\"200px\">".$tampiltarif['komponentarif_nama']."</td>
                            <td>".$tampiltarif['harga_tariftindakan']."</td>    
                        </tr>";
                    }else{
                        $trTotal .="<tr>
                            <td>".$tampiltarif['penjamin_nama']."</td>
                            <td>".$tampiltarif['daftartindakan_nama']."</td>
                            <td>".$tampiltarif['harga_tariftindakan']."</td>    
                        </tr>";
                    }
                    
                    $fotoKamar = $tampiltarif['kamarruangan_image'];                            
                    $jumlahTempatTidur = $tampiltarif['kamarruangan_jmlbed'];

                    $kelasPelayanan = PPKelasPelayananM::model()->findBYPk(
                        $tampiltarif['kelaspelayanan_id']
                    )->kelaspelayanan_nama;
                    
                    $noKamar = $tampiltarif['kamarruangan_nokamar'];
                    if($fotoKamar != ''){
                        $fotoTampil = $fotoKamar;
                    }else{
                         $fotoTampil = 'no_photo.jpeg';
                    }
                }
                
                $col = 3;
                $cnt =0;
                $batas   = 999999999;                
                $trInformasiHarga .='<table>'.$trInformasiHarga.$trTotal.'</table>';
                $dataTempatTidur = PPKamarruanganM::model()->findAll('
                    ruangan_id = '. $data_ruangan['ruangan_id'] .' AND kelaspelayanan_id = '. $data_ruangan['kelaspelayanan_id'] .' AND kamarruangan_nokamar = \''. $data_ruangan['kamarruangan_nokamar'] .'\' ORDER BY kamarruangan_nobed ASC
                ');                
                $formKasur .='<div class="block-tabel">
                        <h6>Data No. Kamar :'.$data_ruangan['kamarruangan_nokamar'].'</h6>
                        <table width="100%" align="center" cellspacing="0" cellpadding="0">
                        <tr>
                        <td width="40%" colspan='. $col .'>
                            <fieldset class="box2">
                            <legend class="rim">Informasi Harga</legend>
                            <table>
                                <tr>
                                    <td>
                                        '.$trInformasiHarga.'
                                   </td>
                                   <td width="40%">
                                        <fieldset class="box2">
                                            <legend class="rim">Informasi Kamar</legend>
                                            Jumlah tempat Tidur :'.$jumlahTempatTidur.'<br/>
                                            Kelaspelayanan :'.$kelasPelayanan.'<br/>

                                        </fieldset>
                                   </td>
                                   <td width="20%">
                                        <fieldset class="box2">
                                            <legend class="rim">Foto Kamar</legend>
                                        <img src="'.Params::urlKamarRuanganTumbsDirectory().(($fotoTampil=="") ?'kecil_'.$fotoTampil:'no_photo.jpeg').'">
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

                    if($tampilTempatTidur['kamarruangan_status'] == 1)
                    {
                        ////Jika Terisi
                        $modMasukKamar = MasukkamarT::model()->find('
                            kamarruangan_id = '. $tampilTempatTidur['kamarruangan_id'] .' AND
                            tglkeluarkamar IS NUll AND
                            jamkeluarkamar IS NULL ORDER BY tglmasukkamar DESC
                        ');
                        if($modMasukKamar)
                        {
                            $modPasienAdmisi = PasienadmisiT::model()->findByPk($modMasukKamar->pasienadmisi_id);
                            $modPasien=PPPasienM::model()->findByPk($modPasienAdmisi->pasien_id);
                            $modPendaftaran=  PPPendaftaranT::model()->find('pasien_id='.$modPasien->pasien_id.'');
                            $formKasur .='<td>
                                        <div class="boxrepeat ranjangIsi">
                                            <table cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>NO RM : <b>'.$modPasien->no_rekam_medik.'</b><br/>
                                                    No. Pendaftaran : <b>'.$modPendaftaran->no_pendaftaran.'</b><br/>
                                                    No. Kasur :<b>'.$tampilTempatTidur['kamarruangan_nobed'].'</b><br/>
                                                    Nama : <b>'.$modPasien->nama_pasien.'</b><br/>
                                                    Status : <b>Terisi<b><br/>
                                                    Jenis Kelamin : <b>'.$modPasien->jeniskelamin.'</b></td>
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
            }
            
            $data_ruangan = array(
                'form'=>$formKasur
            );
            echo json_encode($data_ruangan);
            Yii::app()->end();            
        }
    }    

    public function actionAjaxKamarRuangan(){
        $data = PPKamarruanganM::model()->findAll('ruangan_id=:ruangan_id', array(':ruangan_id' => (int) $_POST['ruangan_id'],), array('order' => 'kamarruangan_nokamar'));
        $data = CHtml::listData($data, 'kamarruangan_nokamar', 'kamarruangan_nokamar');

        if (empty($data)) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-Pilih Kamar-'), true);
        } else {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-Pilih Kamar-'), true);
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        }
    }
	
	/*
	* Mencari kamarruangan berdasarkan ruangan berdasarkan Kelaspelayanan_id di tabel kelas Ruangan M
	* and open the template in the editor.
	*/
    public function actionGetRuanganKamarRuangan($encode=false,$namaModel='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            $idRuangan= $_POST["$namaModel"]['ruangan_id'];
            $kelasPelayanan = KamarruanganM::model()->with('kelaspelayanan')->findAll('ruangan_id='.$idRuangan.'');
            
            $kelasPelayanan=CHtml::listData($kelasPelayanan,'kelaspelayanan_id','kelaspelayanan.kelaspelayanan_nama');
            
            if(empty($kelasPelayanan)){
                echo CHtml::tag('option', array('value'=>''),CHtml::encode('-Pilih-'),true);
            }else{
                echo CHtml::tag('option', array('value'=>''),CHtml::encode('-Pilih-'),true);
                foreach($kelasPelayanan as $value=>$name)
                {
                    echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                }
            }
        }
        Yii::app()->end();
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
    
    public function actionAjaxKelasPelayanan(){
        $data = PPKelasruanganM::model()->with('kelaspelayanan')->findAll('ruangan_id=:ruangan_id', array(':ruangan_id' => (int) $_POST['ruangan_id'],), array('order' => 'kelaspelayanan_id'));
        $data = CHtml::listData($data, 'kelaspelayanan.kelaspelayanan_nama', 'kelaspelayanan.kelaspelayanan_nama');

        if (empty($data)) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-Pilih Kelas-'), true);
        } else {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-Pilih Kelas-'), true);
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        }
    }

}

?>
