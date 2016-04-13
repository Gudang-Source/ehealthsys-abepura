
<?php $modPendaftaran = new RJPendaftaranT; ?>
       <?php $this->widget('bootstrap.widgets.BootPager', array(
                'pages' => $pages,    
                'header'=>'<div class="pagination" id="pagin">',
                'footer'=>'</div>',
       )); ?>      
       <table class="items table table-striped table-bordered table-condensed" >
        <thead>
            <tr>
                <th rowspan="2">Tgl. Kunjungan/<br/>No.Pendaftaran</th>
                <th colspan ="2"><center>Persalinan</center></th>  
                <th colspan ="2"><center>Kelahiran</center></th>  
                <th colspan ="2"><center>Anamnesis</center></th>  
                <th rowspan ="2"><center>Pemeriksaan Fisik</center></th>  
                <th colspan ="2"><center>Pemeriksaan Penunjang</center></th>  
                <th valign='middle' rowspan="2"><center>Konsul Poliklinik</center></th>  
                <th colspan ="3"><center>Pelayanan</center></th>  
                <th valign='middle' rowspan="2"><center>Diagnosis</center></th>  
                <th valign='middle' rowspan="2"><center>Operasi</center></th>  
                <th valign='middle' rowspan="2"><center>Dokter Pemeriksa</center></th>  
                <th valign='middle' rowspan="2"><center>Dirujuk Keluar</center></th>  
            </tr>
            <tr>
                <th colspan="2"><center>&nbsp;</center></th>  
                <th colspan="4"><center>&nbsp;</center></th>  
                <th><center>Ke penunjang</center></th>  
                <th><center>Hasil</center></th>  
                <th><center>Tindakan</center></th>  
                <th><center>Terapi</center></th>  
                <th><center>Pemakaian Bahan</center></th>  
                <!--<th colspan="5"><center>&nbsp;</center></th>-->  
                
            </tr>
            
        </thead>
        <tbody>
            <?php foreach($modKunjungan as $modKunjungan) { ?>
            <tr>
                <td><?php echo $modKunjungan->no_pendaftaran; ?><br/><?php echo MyFormatter::formatDateTimeForUser($modKunjungan->tgl_pendaftaran); ?></td>
                <td colspan="2">
                    <?php
                    echo CHtml::link("<i class='icon-form-persalinan'></i> ",  Yii::app()->controller->createUrl("daftarPasien/detailPersalinan",
                            array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Persalinan", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Riwayat Pelayanan/Persalinan")); 
                    
                    ?>
                </td>
                <td colspan="2">
		    <?php
                    echo CHtml::link("<i class='icon-form-kelahiran'></i> ",  Yii::app()->controller->createUrl("daftarPasien/detailKelahiran",
                            array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Kelahiran", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Riwayat Pelayanan/Kelahiran")); 
                    
                    ?>
                </td>
                <td colspan="2">
                    <?php
                    echo CHtml::link("<i class='icon-form-anamnesa'></i> ",  Yii::app()->controller->createUrl("daftarPasien/detailAnamnesa",
                            array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Anamnesis", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Riwayat Pelayanan/Anamnesis")); 
                    
                    ?>
                </td>
                <td>
                    <?php
                    echo CHtml::link("<i class='icon-form-periksa'></i> ",  Yii::app()->controller->createUrl("daftarPasien/detailPeriksaFisik",
                            array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Periksa Fisik", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Riwayat Pelayanan/Periksa Fisik")); 
                    
                    ?>
                </td>
               
                <td><ul><?php $this->renderPartial('/_periksaDataPasien/_kepenunjang', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id)); ?></ul></td>
                <td>
                    <?php 
//                        if(count($modKunjungan->hasilpemeriksaanlab) != 0){
//                            echo CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl("daftarPasien/detailHasilLab",array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"pesan","rel"=>"tooltip","title"=>"Klik untuk Detail Hasil Pemeriksaan Lab", "onclick"=>"window.parent.$('#dialogDetailHasilLab').dialog('open');"));
//                        }
                    ?>
                    <?php 
                        $modMasukPenunjang = RJPasienMasukPenunjangT::model()->with('ruangan')->findAllByAttributes(array('pendaftaran_id'=>$modKunjungan->pendaftaran_id));
                        $jumlah = count($modMasukPenunjang);
                        $result = "";
                        foreach($modMasukPenunjang as $row){
                            $modHasilLab = RJHasilpemeriksaanlabT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$row->pasienmasukpenunjang_id));
                            $modHasilRad = HasilpemeriksaanradT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$row->pasienmasukpenunjang_id));

                            if($modHasilLab){ //cek jika sudah ada hasil lab
                                $result .= "".CHtml::link("<i class='icon-list-alt'></i> ",Yii::app()->controller->createUrl("daftarPasien/detailHasilLab",array("pendaftaran_id"=>$modKunjungan->pendaftaran_id, "pasien_id"=>$modKunjungan->pasien_id,"pasienmasukpenunjang_id"=>$row->pasienmasukpenunjang_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"pesan","rel"=>"tooltip","title"=>"Klik untuk Detail Hasil Pemeriksaan '".$row->ruangan->ruangan_nama."'", "onclick"=>"window.parent.$('#dialogDetailHasilLab').dialog('open');"))."<br>";
                            }
                            elseif($modHasilRad){ //jika radiologi
                                $result .= "".CHtml::link("<i class='icon-list-alt'></i> ",Yii::app()->controller->createUrl("daftarPasien/detailHasilRad",array("pendaftaran_id"=>$modKunjungan->pendaftaran_id, "pasien_id"=>$modKunjungan->pasien_id,"pasienmasukpenunjang_id"=>$row->pasienmasukpenunjang_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"pesan","rel"=>"tooltip","title"=>"Klik untuk Detail Hasil Pemeriksaan '".$row->ruangan->ruangan_nama."'", "onclick"=>"window.parent.$('#dialogDetailHasilLab').dialog('open');"))."<br>";
                            }else{
                                $result .= "<br>";
                            }
                        }                        
                        echo $result;
                    ?></ul></td>
                </td>
                <td><?php $this->renderPartial('/_periksaDataPasien/_konsulpoli', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id)); echo"&nbsp &nbsp";
							echo CHtml::link("<i class='icon-form-poliklinik'></i> ",  Yii::app()->controller->createUrl("daftarPasien/detailKonsul",
							array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Konsul", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Riwayat Konsul Poliklinik")); 
						?>
					</td>
                <td><?php //$this->renderPartial('/_periksaDataPasien/_tindakan', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id, 'pasien_id'=>$modKunjungan->pasien_id)); ?>
                    <?php //if (count($modKunjungan->tindakanpelayanan->daftartindakan_id) != 0){
                    echo CHtml::link("<i class='icon-form-tindakan'></i> ",  Yii::app()->controller->createUrl("daftarPasien/detailTindakan",
                            array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Tindakan", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Riwayat Pelayanan/Tindakan")); 
                    
                    //        }?>
                </td>
                <td><?php //$this->renderPartial('/_periksaDataPasien/_terapi', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id, 'pasien_id'=>$modKunjungan->pasien_id)); ?>
                        <?php 
                        
                            echo CHtml::link("<i class='icon-form-terapi'></i> ",  Yii::app()->controller->createUrl("daftarPasien/detailTerapi",
                            array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Terapi", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Riwayat Resep Dokter/Terapi")) ?>
                </td>
                <td><?php //$this->renderPartial('/_periksaDataPasien/_pemakaianBahan', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id, 'pasien_id'=>$modKunjungan->pasien_id)); ?>
                    <?php echo CHtml::link("<i class='icon-form-pakaibahan'></i> ",  Yii::app()->controller->createUrl("daftarPasien/detailPemakaianBahan",
                            array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Pemakaian Bahan", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Riwayat Pemakaian Bahan")) ?>
                </td>
                <td><?php $this->renderPartial('/_periksaDataPasien/_diagnosa', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id)); ?></td>
                <td><?php $this->renderPartial('/_periksaDataPasien/_operasi', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id, 'pasien_id'=>$modKunjungan->pasien_id)); ?></td>
                <td><?php echo isset($modKunjungan->pegawai_id)?$modKunjungan->pegawai->namaLengkap:' - '; ?></td>
                <td><?php $this->renderPartial('/_periksaDataPasien/_rujukKeluar', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id, 'pasien_id'=>$modKunjungan->pasien_id)); ?></td>
            </tr>
            <?php } ?>
        </tbody>
        <tfoot><tr>
                <td></td>
                <td colspan="2"></td>                
                <td colspan="4"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr></tfoot>
    </table>

   
