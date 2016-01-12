<?php if($modKirim->jenispesanmenu == Params::JENISPESANMENU_PASIEN){ ?>
<div style="max-width:1380px;overflow:auto;">
<table class="table table-striped table-condensed" id="tableMenuDiet" >
    <thead>
        <tr>
            <th rowspan="2"><center><input type="checkbox" id="checkListUtama" name="checkListUtama" value="1" checked="checked" onclick="checkAll('cekList',this);hitungSemua();"></center></th>
            <th rowspan="2"><center>Instalasi/<br/>Ruangan</center></th>
            <th rowspan="2"><center>No. Pendaftaran/<br/>No. Rekam Medik</center></th>
            <th rowspan="2"><center>Nama Pasien</center></th>
            <th rowspan="2"><center>Umur</center></th>
            <th rowspan="2"><center>Jenis Kelamin</center></th>
            <th colspan="<?php echo count(JeniswaktuM::getJenisWaktu()); ?>"><center>Menu Diet</center></th>
            <th rowspan="2"><center>Jumlah</center></th>
            <th rowspan="2"><center>Satuan/URT</center></th>
            <th rowspan="2"><center>Jenis Makanan</center></th>
        </tr>
        <tr>
            <?php
            foreach (JeniswaktuM::getJenisWaktu() as $row) {
                echo '<th><center>' . $row->jeniswaktu_nama . '</center></th>';
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php if ($modDetailKirim > 0){
            foreach ($modDetailKirim AS $i=>$tampilData){
                echo "<tr>
                <td>" 
                .CHtml::checkBox('KirimmenupasienT['.$i.'][checkList]',true,array('class'=>'cekList','onclick'=>'hitungSemua()')) 
                .CHtml::hiddenField('KirimmenupasienT['.$i.'][ruangan_id]',$modKirim->kirimmenupasien->ruangan_id) 
                .CHtml::hiddenField('KirimmenupasienT['.$i.'][pendaftaran_id]',$tampilData->pendaftaran_id) 
                .CHtml::hiddenField('KirimmenupasienT['.$i.'][pasienadmisi_id]',$tampilData->pasienadmisi_id) 
                .CHtml::hiddenField('KirimmenupasienT['.$i.'][pasien_id]',$tampilData->pasien_id) 
                .CHtml::hiddenField('KirimmenupasienT['.$i.'][satuanjml_urt]',$tampilData->satuanjml_urt) 
                .CHtml::hiddenField('KirimmenupasienT['.$i.'][penjamin_id]', $tampilData->pendaftaran->penjamin_id)
                .CHtml::hiddenField('KirimmenupasienT['.$i.'][jeniskasuspenyakit_id]', $tampilData->pendaftaran->jeniskasuspenyakit_id)
                . "</td>
                <td>" .(isset($modKirim->kirimmenupasien->kirimmenupasien_id) ? $modKirim->kirimmenupasien->ruangan->instalasi->instalasi_nama . "/<br/>" .$modKirim->kirimmenupasien->ruangan->ruangan_nama : "")."</td>
                <td>" .$tampilData->pendaftaran->no_pendaftaran . "/<br/>" .$tampilData->pasien->no_rekam_medik . "</td>   
                <td>" .$tampilData->pasien->nama_pasien . "</td>   
                <td>" .$tampilData->pendaftaran->umur . "</td>   
                <td>" .$tampilData->pasien->jeniskelamin . "</td>";

                foreach (JeniswaktuM::getJenisWaktu() as $row) {
                    $detail = KirimmenupasienT::model()->with('menudiet')->findByAttributes(array('pendaftaran_id' => $tampilData->pendaftaran_id, 'pasienadmisi_id' => $tampilData->pasienadmisi_id, 'kirimmenudiet_id' => $tampilData->kirimmenudiet_id, 'jeniswaktu_id' => $row->jeniswaktu_id,'menudiet_id'=>$tampilData->menudiet_id));
                    if(empty($detail->pasienadmisi_id)){
                        $kelaspelayanan_id = isset($detail->pendaftaran->kelaspelayanan_id) ? $detail->pendaftaran->kelaspelayanan_id : null;
                    }else{
                        $kelaspelayanan_id = isset($detail->pasienadmisi->kelaspelayanan_id) ? $detail->pasienadmisi->kelaspelayanan_id : null;
                    }
					if(!empty($kelaspelayanan_id)){
						$modTarif = TariftindakanM::model()->findByAttributes(array('daftartindakan_id'=>$detail->menudiet->daftartindakan_id,'kelaspelayanan_id'=>$kelaspelayanan_id,'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL),array('order'=>'tariftindakan_id asc','limit'=>1));
						if(count($modTarif) <= 0){
							   $modTarif = TariftindakanM::model()->findAllByAttributes(array('daftartindakan_id'=>$detail->menudiet->daftartindakan_id,'kelaspelayanan_id'=>Params::KELASPELAYANAN_ID_TANPA_KELAS,'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL),array('order'=>'tariftindakan_id asc','limit'=>1));
						} 
					}
                                      
                    if (empty($detail->menudiet_id)) {
                        echo "<td><center>-</center></td>";
                    } else {
                        echo "<td>" .CHtml::hiddenField('KirimmenupasienT['.$i.'][jeniswaktu_id]['.$row->jeniswaktu_id.']',$row->jeniswaktu_id)
                                    .CHtml::hiddenField('KirimmenupasienT['.$i.'][pesanmenudetail_id]['.$row->jeniswaktu_id.']',$detail->pesanmenudetail_id)
                                    .CHtml::hiddenField('KirimmenupasienT['.$i.'][kirimmenudiet_id]['.$row->jeniswaktu_id.']', $detail->kirimmenudiet_id)
                                    .CHtml::hiddenField('KirimmenupasienT['.$i.'][kirimmenupasien_id]['.$row->jeniswaktu_id.']', $detail->kirimmenupasien_id)
                                    .CHtml::hiddenField('KirimmenupasienT['.$i.'][pesanmenudetail_id]['.$row->jeniswaktu_id.']', $detail->pesanmenudetail_id)
                                    .CHtml::hiddenField('KirimmenupasienT['.$i.'][menudiet_id]['.$row->jeniswaktu_id.']',$detail->menudiet_id) . $detail->menudiet->menudiet_nama
                                    .CHtml::hiddenField('KirimmenupasienT['.$i.'][daftartindakan_id]['.$row->jeniswaktu_id.']', $detail->menudiet->daftartindakan_id)                                
                                    .CHtml::hiddenField('KirimmenupasienT['.$i.'][carabayar_id]['.$row->jeniswaktu_id.']', $detail->pendaftaran->carabayar_id)
                                    .CHtml::hiddenField('KirimmenupasienT['.$i.'][kelaspelayanan_id]['.$row->jeniswaktu_id.']', $detail->pendaftaran->kelaspelayanan_id)
                                    .'<br/>'.CHtml::textField('KirimmenupasienT['.$i.'][satuanTarif]['.$row->jeniswaktu_id.']', (!empty($modTarif->harga_tariftindakan)) ? $modTarif->harga_tariftindakan : 0,array('class'=>'span2','style'=>'width:80px;')).
                                "</td>";
                    }
                };

                echo "<td>" 
                        .CHtml::textField('KirimmenupasienT['.$i.'][jml_kirim]',$tampilData->jml_kirim, array('class'=>'span1 numbersOnly')) 
                        .CHtml::hiddenField('KirimmenupasienT['.$i.'][jml_kirim_awal]', $tampilData->jml_kirim, array('class' => 'span1 numbersOnly')). "</td>
                <td>" . $tampilData->satuanjml_urt . "</td>";
                echo "<td>".CHtml::dropDownList('KirimmenupasienT['.$i.'][status_menu]', '', LookupM::getItems('statusmakanan'),array('class'=>'inputFormTabel span2','empty'=>'--Pilih--'))."</td>";
                "</tr>";
            }
        }?>
    </tbody>
</table>
</div>
<?php }else{ ?>
<table class="table table-bordered table-condensed" id="tableMenuDiet">
        <thead>
            <tr>
                <th rowspan="2"><center><input type="checkbox" id="checkListUtama" name="checkListUtama" value="1" checked="checked" onclick="checkAll('cekList',this);hitungSemua();"></center></th>
                <th rowspan="2"><center>Instalasi/<br/>Ruangan</center></th>
                <th rowspan="2"><center>Nama Pegawai/Tamu</center></th>
                <th rowspan="2"><center>Jenis Kelamin</center></th>
                <th colspan="<?php echo count(JeniswaktuM::getJenisWaktu()); ?>"><center>Menu Diet</center></th>
                <th rowspan="2"><center>Jumlah</center></th>
                <th rowspan="2"><center>Satuan/URT</center></th>
                <th rowspan="2"><center>Jenis Makanan</center></th>
        </tr>
        <tr>
            <?php
            foreach (JeniswaktuM::getJenisWaktu() as $row) {
                echo '<th><center>' . $row->jeniswaktu_nama . '</center></th>';
            }
            ?>
        </tr>
        </thead>
        <tbody>
            <?php
            if ($modDetailKirim > 0) {
                foreach ($modDetailKirim AS $i=>$tampilData){
                    echo "<tr>
                <td>"
                    .CHtml::checkBox('KirimmenupegawaiT['.$i.'][checkList]', true, array('class' => 'cekList', 'onclick' => 'hitungSemua()'))
                    .CHtml::hiddenField('KirimmenupegawaiT['.$i.'][ruangan_id]', $modKirim->kirimmenupegawai->ruangan_id)
                    .CHtml::hiddenField('KirimmenupegawaiT['.$i.'][pegawai_id]', $tampilData->pegawai_id)
                    .CHtml::hiddenField('KirimmenupegawaiT['.$i.'][satuanjml_urt]', $tampilData->satuanjml_urt)
                    . "</td>
                <td>" .$modKirim->kirimmenupegawai->ruangan->instalasi->instalasi_nama . "/<br/>" . $modKirim->kirimmenupegawai->ruangan->ruangan_nama . "</td>";
                    if (!empty($tampilData->pegawai->nama_pegawai)) {
                        echo "<td>" . $tampilData->pegawai->nama_pegawai . "</td>   
                <td>" .$tampilData->pegawai->jeniskelamin . "</td>";
                    } else {
                        echo "<td>Tamu " . $no . "</td>   
                <td><center>-</center></td>";
                    }
                    foreach (JeniswaktuM::getJenisWaktu() as $row) {
                        $detail = KirimmenupegawaiT::model()->with('menudiet')->findByAttributes(array('pegawai_id' => $tampilData->pegawai_id, 'kirimmenudiet_id' => $tampilData->kirimmenudiet_id, 'jeniswaktu_id' => $row->jeniswaktu_id,));
                        if (empty($detail->menudiet_id)) {
                            echo "<td><center>-</center></td>";
                        } else {
                            echo "<td>" .CHtml::hiddenField('KirimmenupegawaiT['.$i.'][jeniswaktu_id]['.$row->jeniswaktu_id.']', $row->jeniswaktu_id)                                  
                            .CHtml::hiddenField('KirimmenupegawaiT['.$i.'][kirimmenudiet_id]['.$row->jeniswaktu_id.']', $detail->kirimmenudiet_id)
                            .CHtml::hiddenField('KirimmenupegawaiT['.$i.'][pesanmenupegawai_id]['.$row->jeniswaktu_id.']', $detail->pesanmenupegawai_id)
                            .CHtml::hiddenField('KirimmenupegawaiT['.$i.'][kirimmenupegawai_id]['.$row->jeniswaktu_id.']', $detail->kirimmenupegawai_id)
                            .CHtml::hiddenField('KirimmenupegawaiT['.$i.'][menudiet_id]['.$row->jeniswaktu_id . ']', $detail->menudiet_id, array('class'=>'menudiet')) . $detail->menudiet->menudiet_nama . "</td>";
                        }
                    };
                    echo "<td>" .CHtml::textField('KirimmenupegawaiT['.$i.'][jml_kirim]', $tampilData->jml_kirim, array('class' => 'span1 numbersOnly jmlKirim'))
                                .CHtml::hiddenField('KirimmenupegawaiT['.$i.'][jml_kirim_awal]', $tampilData->jml_kirim, array('class' => 'span1 numbersOnly')) . "</td>
                <td>" . $tampilData->satuanjml_urt . "</td>";
                echo "<td>" .CHtml::dropDownList('KirimmenupegawaiT['.$i.'][status_menu]','',LookupM::getItems('statusmakanan'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')). "</td>";
            "</tr>";
            }
            }
            ?>
        </tbody>
    </table>
<?php } ?>
