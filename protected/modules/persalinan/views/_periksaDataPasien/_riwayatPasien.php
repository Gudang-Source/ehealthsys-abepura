
<?php $modPendaftaran = new PSPendaftaranT; ?>
       <?php $this->widget('bootstrap.widgets.BootPager', array(
                'pages' => $pages,    
                'header'=>'<div class="pagination" id="pagin">',
                'footer'=>'</div>',
       )); ?>      
       <table class="items table table-striped table-bordered table-condensed" >
        <thead>
            <tr>
                <th rowspan="2">Tgl. Kunjungan/<br/>No.Pendaftaran</th>
                <th colspan ="2"><center>Anamnesis</center></th>  
                <th colspan ="4"><center>Pemeriksaan Fisik</center></th>  
                <th colspan ="2"><center>Pemeriksaan Penunjang</center></th>  
                <th valign='middle' rowspan="2"><center>Konsul Poliklinik</center></th>  
                <th colspan ="3"><center>Pelayanan</center></th>  
                <th valign='middle' rowspan="2"><center>Diagnosis</center></th>  
                <th valign='middle' rowspan="2"><center>Operasi</center></th>  
                <th valign='middle' rowspan="2"><center>Dokter Pemeriksa</center></th>  
                <th valign='middle' rowspan="2"><center>Dirujuk Keluar</center></th>  
            </tr>
            <tr>
                <th><center>Keluhan Utama</center></th>  
                <th><center>Riwayat Penyakit</center></th>  
                <th><center>TD</center></th>  
                <th><center>DN</center></th>  
                <th><center>ST</center></th>  
                <th><center>TB/BB</center></th>  
                <th><center>Ke penunjang</center></th>  
                <th><center>Hasil</center></th>  
                <th><center>Tindakan</center></th>  
                <th><center>Terapi</center></th>  
                <th><center>Pemakaian Bahan</center></th>  
                
            </tr>
            
        </thead>
        <tbody>
            <?php foreach($modKunjungan as $modKunjungan) { ?>
            <tr>
                <td><?php echo $modKunjungan->no_pendaftaran; ?><br/><?php echo $modKunjungan->tgl_pendaftaran; ?></td>
                <td><?php echo (isset($modKunjungan->anamnesa->keluhanutama) ? $modKunjungan->anamnesa->keluhanutama : ""); ?></td>
                <td><?php echo (isset($modKunjungan->anamnesa->riwayatpenyakitterdahulu) ? $modKunjungan->anamnesa->riwayatpenyakitterdahulu : ""); ?></td>
                <td><?php echo (isset($modKunjungan->pemeriksaanfisik->tekanandarah) ? $modKunjungan->pemeriksaanfisik->tekanandarah : ""); ?></td>
                <td><?php echo (isset($modKunjungan->pemeriksaanfisik->detaknadi) ? $modKunjungan->pemeriksaanfisik->detaknadi : ""); ?></td>
                <td><?php echo (isset($modKunjungan->pemeriksaanfisik->suhutubuh) ? $modKunjungan->pemeriksaanfisik->suhutubuh : ""); ?></td>
                <td>
                <?php 
                    echo (isset($modKunjungan->pemeriksaanfisik->tinggibadan_cm) ? $modKunjungan->pemeriksaanfisik->tinggibadan_cm : ""); 
                ?>
                    <?php if((empty($modKunjungan->pemeriksaanfisik->tinggibadan_cm))&&(empty($modKunjungan->pemeriksaanfisik->beratbadan_kg))){
                        
                    } else { ;?>/
                    <?php } ?><br/>
                <?php 
                    echo (isset($modKunjungan->pemeriksaanfisik->beratbadan_kg) ? $modKunjungan->pemeriksaanfisik->beratbadan_kg : ""); 
                ?></td>
                <td><ul><?php $this->renderPartial('/_periksaDataPasien/_kepenunjang', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id)); ?></ul></td>
                <td>
                    <?php 
                        if(count($modKunjungan->hasilpemeriksaanlab) != 0){
                            echo CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl("daftarPasien/detailHasilLab",array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"pesan","rel"=>"tooltip","title"=>"Klik untuk Detail Hasil Pemeriksaan Lab", "onclick"=>"window.parent.$('#dialogDetailHasilLab').dialog('open');"));
                        }
                    ?>
                </td>
                <td><?php $this->renderPartial('/_periksaDataPasien/_konsulpoli', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id)); ?></td>
                <td><?php //$this->renderPartial('/_periksaDataPasien/_tindakan', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id, 'pasien_id'=>$modKunjungan->pasien_id)); ?>
                    <?php //if (count($modKunjungan->tindakanpelayanan->daftartindakan_id) != 0){
                    echo CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl("daftarPasien/detailTindakan",
                            array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Tindakan", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Detail Pelayanan Tindakan")); 
                    
                    //        }?>
                </td>
                <td><?php //$this->renderPartial('/_periksaDataPasien/_terapi', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id, 'pasien_id'=>$modKunjungan->pasien_id)); ?>
                        <?php echo CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl("daftarPasien/detailTerapi",
                            array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Terapi", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Detail Pelayanan Obat dan Alat Kesehatan")) ?>
                </td>
                <td><?php //$this->renderPartial('/_periksaDataPasien/_pemakaianBahan', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id, 'pasien_id'=>$modKunjungan->pasien_id)); ?>
                    <?php echo CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl("daftarPasien/detailPemakaianBahan",
                            array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Terapi", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Data Detail Pemakaian Bahan")) ?>
                </td>
                <td><?php $this->renderPartial('/_periksaDataPasien/_diagnosa', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id)); ?></td>
                <td><?php $this->renderPartial('/_periksaDataPasien/_operasi', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id, 'pasien_id'=>$modKunjungan->pasien_id)); ?></td>
                <td><?php echo $modKunjungan->pegawai->nama_pegawai; ?></td>
                <td><?php $this->renderPartial('/_periksaDataPasien/_rujukKeluar', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id, 'pasien_id'=>$modKunjungan->pasien_id)); ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

   
