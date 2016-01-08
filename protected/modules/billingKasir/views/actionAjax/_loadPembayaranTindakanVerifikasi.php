<?php $totQty = 0; $totTarif = 0; $totCyto = 0; $totSubAsuransi = 0; $totSubPemerintah = 0; $totSubRs = 0; $totIur = 0; 
      $totPembebasanTarif = 0; $totDiscount_tindakan = 0; $totalbayartindakan = 0; ?>
<?php foreach($modTindakan as $i=>$tindakan) { ?>
    <tr>
        <td style="display:none;">
            <?php echo CHtml::checkBox("pembayaran[$i][tindakanpelayanan_id]", false, array('onchange'=>'hitungTotalSemuaTind();','value'=>$tindakan->tindakanpelayanan_id,'uncheckValue'=>'0', 'class'=>'pilihan')) ?>
            <?php $subsidi = $this->cekSubsidi($tindakan);?>
        </td>
        <td>
            <?php echo $tindakan->tgl_tindakan ?>
            <?php 
                  $pembebasanTarif = PembebasantarifT::model()->findAllByAttributes(array('tindakanpelayanan_id'=>$tindakan->tindakanpelayanan_id));
                  $tarifBebas = 0; 
                  foreach ($pembebasanTarif as $i => $pembebasan) {
                      $tarifBebas = $tarifBebas + $pembebasan->jmlpembebasan;
                  }
                  $totPembebasanTarif = $totPembebasanTarif + $tarifBebas;
                  $disc = ($tindakan->discount_tindakan > 0) ? $tindakan->discount_tindakan/100 : 0;
                  $discountTindakan = ($disc*$tindakan->tarif_satuan*$tindakan->qty_tindakan);
                  $totDiscount_tindakan += $discountTindakan ;
                  $diskon = $tindakan->discount_tindakan/100 * $tindakan->tarif_tindakan;
                  $subsidiasuransi_tindakan = $tindakan->subsidiasuransi_tindakan;
                  $subsidirs_tindakan = $tindakan->subsisidirumahsakit_tindakan;
            
                  $qtyTindakan = $tindakan->qty_tindakan; $totQty = $totQty + $qtyTindakan; 
                  $tarifSatuan = $tindakan->tarif_satuan;
                  $tarifTindakan = $tindakan->tarif_tindakan; $totTarif = $totTarif + $tarifTindakan; 
                  $tarifCyto = $tindakan->tarifcyto_tindakan; $totCyto = $totCyto + $tarifCyto; 
                  if(!empty($subsidi['max'])){
                      $subsidiAsuransi = round($tarifTindakan/$totalPembagi * $subsidi['max']); 
                      $subsidiPemerintah = 0; 
                      $subsidiRumahSakit = 0; 

                      $totSubAsuransi = $totSubAsuransi + $subsidiAsuransi;
                      $totSubPemerintah = $totSubPemerintah + $subsidiPemerintah; 
                      $totSubRs = $totSubRs + $subsidiRumahSakit; 
                      $iurBiaya = round(($tarifSatuan + $tarifCyto));
                      $totIur = $totIur + $iurBiaya; 
                      $subTotal = round($iurBiaya * $qtyTindakan) - $subsidiAsuransi; 
                      $subTotal = ($subTotal > 0) ? $subTotal : 0;
                      $totalbayartindakan = $totalbayartindakan + $subTotal; 
                  } else {
                      $subsidiAsuransi = $subsidi['asuransi'];  
                      $subsidiPemerintah = $subsidi['pemerintah']; 
                      $subsidiRumahSakit = $subsidi['rumahsakit']; 

                      $totSubAsuransi = $totSubAsuransi + $subsidiAsuransi;
                      $totSubPemerintah = $totSubPemerintah + $subsidiPemerintah; 
                      $totSubRs = $totSubRs + $subsidiRumahSakit; 
                      $iurBiaya = round(($tarifSatuan + $tarifCyto) - ($subsidiAsuransi + $subsidiPemerintah + $subsidiRumahSakit)); 
                      $totIur = $totIur + $iurBiaya; 
                      $subTotal = ($iurBiaya * $qtyTindakan); 
                      $totalbayartindakan = $totalbayartindakan + $subTotal; 
                  }
            ?>
            
            <?php echo CHtml::hiddenField("pembayaran[$i][tgl_tindakan]",$tindakan->tgl_tindakan, array('readonly'=>true,'class'=>'inputFormTabel span2')); ?>
            <?php echo CHtml::hiddenField("pembayaran[$i][carabayar_id]",$tindakan->carabayar_id, array('readonly'=>true)); ?>
            <?php echo CHtml::hiddenField("pembayaran[$i][penjamin_id]",$tindakan->penjamin_id, array('readonly'=>true)); ?>
            <?php //echo CHtml::hiddenField("pembayaran[$i][discount_tindakan]",$tindakan->discount_tindakan, array('readonly'=>true)); ?>
            <?php echo CHtml::hiddenField("pembayaran[$i][pembebasan_tarif]",$tarifBebas, array('readonly'=>true)); ?>
        </td>
        <td>
            <?php echo (isset($tindakan->tipepaket->tipepaket_nama) ? $tindakan->tipepaket->tipepaket_nama : '') .' - ' . (isset($tindakan->daftartindakan->daftartindakan_nama) ? $tindakan->daftartindakan->daftartindakan_nama : '') ; ?>
            <?php echo CHtml::hiddenField("pembayaran[$i][daftartindakan_id]", $tindakan->daftartindakan_id, array('readonly'=>true,'class'=>'inputFormTabel lebar2')); ?>
        </td>
        <td>
            <?php echo CHtml::textField("pembayaran[$i][qty_tindakan]", $tindakan->qty_tindakan, array('readonly'=>false,'onblur'=>'hitungTotalSemuaTind(), hitungTarifTindakan(this,'.$tindakan->tindakanpelayanan_id.');','class'=>'inputFormTabel number lebar2')); ?>
            <br>
            <?php
              $modTindakanKomp = TindakankomponenT::model()->findAllByAttributes(array('tindakanpelayanan_id'=>$tindakan->tindakanpelayanan_id));
              foreach ($modTindakanKomp as $key => $komp) {
                echo $komp->komponentarif->komponentarif_nama.":<br>";
              }
            ?>
        </td>
        <td>
            <?php echo CHtml::textField("pembayaran[$i][tarif_satuan]", $tindakan->tarif_satuan, array('readonly'=>true,'onblur'=>'hitungTotalSemuaTind();','class'=>'inputFormTabel integer lebar3')); ?>
            <?php echo CHtml::hiddenField("pembayaran[$i][tarif_tindakan]", $tindakan->tarif_tindakan, array('readonly'=>true,'class'=>'inputFormTabel integer lebar3')); ?>
            <br>
            <?php
              $modTindakanKomp = TindakankomponenT::model()->findAllByAttributes(array('tindakanpelayanan_id'=>$tindakan->tindakanpelayanan_id));
              foreach ($modTindakanKomp as $key => $komp) {
                $tindakanpelayananId = $komp->tindakanpelayanan_id;
                echo CHtml::textField("komponen[$key][$tindakanpelayananId]", $komp->tarif_tindakankomp, array('readonly'=>false,'onblur'=>'hitungTarifTindakan(this,'.$tindakanpelayananId.');','class'=>'inputFormTabel integer lebar3 tarif '.$tindakanpelayananId.''));
              }
            ?>

        </td>
        <td>
            <?php echo CHtml::textField("pembayaran[$i][tarifcyto_tindakan]", $tindakan->tarifcyto_tindakan, array('readonly'=>false,'class'=>'inputFormTabel integer lebar3','onblur'=>'hitungTotalSemuaTind();','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        </td>
        <td>
            <?php echo CHtml::textField("pembayaran[$i][discount_tindakan]",$diskon, array('readonly'=>false, 'onblur'=>'hitungTotalSemuaTind();','class'=>'inputFormTabel integer lebar3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        </td>
        <td>
            <?php echo CHtml::textField("pembayaran[$i][subsidiasuransi_tindakan]", $subsidiasuransi_tindakan, array('readonly'=>false,'onblur'=>'hitungTotalSemuaTind();','class'=>'inputFormTabel integer lebar3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        </td>
        <!--DI JK INI DIHIDE--> 
        <td style="display:none;">
            <?php echo CHtml::textField("pembayaran[$i][subsidipemerintah_tindakan]", $subsidiPemerintah, array('readonly'=>false,'class'=>'inputFormTabel integer lebar3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        </td> 
        <td>
            <?php echo CHtml::textField("pembayaran[$i][subsisidirumahsakit_tindakan]", $subsidirs_tindakan, array('readonly'=>false,'onblur'=>'hitungTotalSemuaTind();','class'=>'inputFormTabel integer lebar3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        </td>
        <td>
            <?php echo CHtml::textField("pembayaran[$i][iurbiaya_tindakan]", $iurBiaya, array('readonly'=>false,'class'=>'inputFormTabel integer lebar3')); ?>
        </td>
        <td>
            <?php echo CHtml::textField("pembayaran[$i][sub_total]", $subTotal, array('readonly'=>true,'class'=>'inputFormTabel integer lebar3')); ?>
        </td>
    </tr>
<?php } ?>
    <tr class="trfooter">
        <td style="display:none;">
            <?php echo CHtml::checkBox('inputTotalTind',false, array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'checkbox-column','onclick'=>'cekInputTotal(this)')) ?>
        </td>
        <td colspan="2">Input Total</td>
        <td>
            <?php echo CHtml::textField("totalqtytindakan", $totQty, array('readonly'=>true,'class'=>'inputFormTabel number lebar2')); ?>
        </td>
        <td>
            <?php echo CHtml::textField("totalbiayatindakan", $totTarif, array('readonly'=>true,'class'=>'inputFormTabel integer lebar3')); ?>
        </td>
        <td>
            <?php echo CHtml::textField("totalcyto", $totCyto, array('readonly'=>true,'class'=>'inputFormTabel integer lebar3')); ?>
        </td>
        <td>
            <?php echo CHtml::textField("totaldiscount_tindakan", $totDiscount_tindakan, array('readonly'=>true,'class'=>'inputFormTabel integer lebar3')); ?>
        </td>
        <td>
            <?php echo CHtml::textField("totalsubsidiasuransi", $totSubAsuransi, array('readonly'=>true,'onblur'=>'proporsiSubAsuransiTind();','class'=>'inputFormTabel integer lebar3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        </td>
        <!--DI JK INI DIHIDE-->
        <td style="display: none;">
            <?php echo CHtml::textField("totalsubsidipemerintah", $totSubPemerintah, array('readonly'=>true,'class'=>'inputFormTabel integer lebar3')); ?>
        </td>
        <td>
            <?php echo CHtml::textField("totalsubsidirs", $totSubRs, array('readonly'=>true,'onblur'=>'proporsiSubRsTind();','class'=>'inputFormTabel integer lebar3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        </td>
        <td>
            <?php echo CHtml::textField("totaliurbiaya", $totIur, array('readonly'=>true,'class'=>'inputFormTabel integer lebar3')); ?>
        </td>
        <td>
            <?php echo CHtml::textField("totalbayartindakan", $totalbayartindakan, array('readonly'=>true,'class'=>'inputFormTabel integer lebar3')); ?>
            <?php echo CHtml::hiddenField("totalpembebasan", $totPembebasanTarif, array('readonly'=>true,'class'=>'inputFormTabel integer lebar3')); ?>
        </td>
    </tr>
    