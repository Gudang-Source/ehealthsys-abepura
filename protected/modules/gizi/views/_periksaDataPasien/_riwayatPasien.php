
<?php $modPendaftaran = new GZPendaftaranT; ?>
       <?php $this->widget('bootstrap.widgets.BootPager', array(
                'pages' => $pages,    
                'header'=>'<div class="pagination" id="pagin">',
                'footer'=>'</div>',
       )); ?>      
       <table class="items table table-striped table-condensed" >
        <thead>
            <tr>
                <th rowspan="2">Tanggal Kunjungan/<br/>No. Pendaftaran</th>
                <th rowspan ="2"><center>Anamnesis Diet</center></th>  
                <th colspan ="9"><center>Pemeriksaan Fisik</center></th>  
                <th rowspan ="2"><center>Konsultasi Gizi</center></th>  
                <th rowspan ="2"><center>Pemeriksaan Fisik Perawatan</center></th>  
                <th rowspan ="2"><center>Anamnesis Perawatan</center></th>  
                <th colspan ="2"><center>Pemeriksaan Penunjang</center></th>  
                <th rowspan ="2"><center>Diagnosis</center></th>  
            </tr>
            <tr>
                <th><center>Tekanan Darah</center></th>  
                <th><center>Detak Nadi</center></th>  
                <th><center>Suhu Tubuh</center></th>  
                <th><center>Tinggi Badan / Berat Badan</center></th>  
                <th><center>Lila <br/> (Untuk Pasien Hamil)</center></th>  
                <th><center>Lingkar Pinggang <br/> (Untuk Pasien <br/> Obgyn)</center></th>  
                <th><center>LIngkar Pinggul <br/> (Untuk Pasien <br/> Obesitas)</center></th>  
                <th><center>Tebal Lema <br/> (Untuk Pasien <br/> Obesitas)</center></th>  
                <th><center>Tinggi Lutut <br/> (Untuk Pasien <br/> Usia Lanjut / Bongkok)</center></th>  
                <th><center>Ke Penunjang</center></th>  
                <th><center>Hasil</center></th>  
            </tr>
            
        </thead>
        <tbody>
            <?php foreach($modKunjungan as $modKunjungan) { ?>
            <tr>
                <td><?php echo $modKunjungan->no_pendaftaran; ?><br/><?php echo $modKunjungan->tgl_pendaftaran; ?></td>
                <td><?php //if (count($modKunjungan->tindakanpelayanan->daftartindakan_id) != 0){
                    echo CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl("daftarPasien/DetailAnamnesaDiet",
                            array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialogAnamnesa","rel"=>"tooltip","title"=>"Klik untuk Detail Anamnesa Diet", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailAnamnesa').text(text);window.parent.$('#dialogDetailAnamnesa').dialog('open');", "dialog-text"=>"Detail Anamnesa Diet")); 
                    
                //}?>
                </td>
                <td><?php //if (isset($modKunjungan->pemeriksaanfisik)){ 
                    echo (isset($modKunjungan->pemeriksaanfisik) ? $modKunjungan->pemeriksaanfisik->tekanandarah : ""); ?></td>
                <td><?php echo (isset($modKunjungan->pemeriksaanfisik) ? $modKunjungan->pemeriksaanfisik->detaknadi : ""); ?></td>
                <td><?php echo (isset($modKunjungan->pemeriksaanfisik) ? $modKunjungan->pemeriksaanfisik->suhutubuh : ""); ?></td>
                <td>
                <?php 
                    echo (isset($modKunjungan->pemeriksaanfisik) ? $modKunjungan->pemeriksaanfisik->tinggibadan_cm : ""); 
                ?>
                    <?php if((empty($modKunjungan->pemeriksaanfisik->tinggibadan_cm))&&(empty($modKunjungan->pemeriksaanfisik->beratbadan_kg))){
                        
                    } else { ;?>
                    <?php } ?><br/>
                <?php 
                    echo (isset($modKunjungan->pemeriksaanfisik) ? $modKunjungan->pemeriksaanfisik->beratbadan_kg : ""); 
                ?></td>
                <td><?php echo (!empty($modKunjungan->pemeriksaanfisik->Lila) ? $modKunjungan->pemeriksaanfisik->Lila." cm" : ""); ?></td>
                <td><?php echo (!empty($modKunjungan->pemeriksaanfisik->LingkarPinggang) ? $modKunjungan->pemeriksaanfisik->LingkarPinggang." cm" : ""); ?></td>
                <td><?php echo (!empty($modKunjungan->pemeriksaanfisik->LingkarPinggul) ? $modKunjungan->pemeriksaanfisik->LingkarPinggul." cm" : ""); ?></td>
                <td><?php echo (!empty($modKunjungan->pemeriksaanfisik->TebalLemak) ? $modKunjungan->pemeriksaanfisik->TebalLemak." cm" : ""); ?></td>
                <td><?php echo (!empty($modKunjungan->pemeriksaanfisik->TinggiLutut) ? $modKunjungan->pemeriksaanfisik->TinggiLutut." cm" : ""); 
                //} ?></td>
                <td><?php if (count($modKunjungan->tindakanpelayanan) > 0){
                    echo CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl("daftarPasien/detailKonsulGizi",
                            array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialogGizi","rel"=>"tooltip","title"=>"Klik untuk Detail Konsultasi Gizi", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailGizi').text(text);window.parent.$('#dialogDetailGizi').dialog('open');", "dialog-text"=>"Detail Pelayanan Konsultasi Gizi")); 
                    
                }?>
                </td>
				<td><center>
					<?php
						echo CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl("daftarPasien/detailPeriksaFisik",
										array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"dialogPeriksaFisik","rel"=>"tooltip","title"=>"Klik untuk Detail Periksa Fisik", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogPeriksaFisik').text(text);window.parent.$('#dialogPeriksaFisik').dialog('open');", "dialog-text"=>"Riwayat Pelayanan/Periksa Fisik"));
						?>
					</center>
				</td>
				<td><center>
					<?php
                    echo CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl("daftarPasien/detailAnamnesa",
                            array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailAnamnesisPerawatan","rel"=>"tooltip","title"=>"Klik untuk Detail Anamnesis", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-detailAnamnesisPerawatan').text(text);window.parent.$('#detailAnamnesisPerawatan').dialog('open');", "dialog-text"=>"Riwayat Pelayanan/Anamnesis")); 
                    
                    ?>
					</center>
				</td>
				<td><ul><?php $this->renderPartial('/_periksaDataPasien/_kepenunjang', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id)); ?></ul></td>
				<td><ul>
                    <?php 
                        $modMasukPenunjang = GZPasienMasukPenunjangT::model()->with('ruangan')->findAllByAttributes(array('pendaftaran_id'=>$modKunjungan->pendaftaran_id));
                        $jumlah = count($modMasukPenunjang);
                        $result = "";
                        foreach($modMasukPenunjang as $row){
                            $modHasilLab = GZHasilpemeriksaanlabT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$row->pasienmasukpenunjang_id));
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
                    ?></ul>
				</td>
				<td><?php $this->renderPartial('/_periksaDataPasien/_diagnosa', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id)); ?></td>
            </tr>
            <?php } ?>
        </tbody>
        <tfoot><tr>
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
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr></tfoot>
    </table>

   
