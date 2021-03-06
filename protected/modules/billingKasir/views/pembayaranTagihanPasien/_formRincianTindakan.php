<table style="width:100%" class="table table-striped table-condensed">
    <thead>
        <th>Pilih <?php echo CHtml::checkBox('is_pilihsemuatindakan',true,array('onchange'=>'setPilihTindakanChecked();','rel'=>'tooltip','title'=>'Centang untuk pilih semua tindakan','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></th>
        <th>Tanggal</th>
        <th width="50%">Deskripsi Tindakan</th>
        <th>Jumlah</th>
        <th>Tarif Satuan <br>(Rp.)</th>
        <th>Tarif Cyto <br>(Rp.)</th>
        <th>Diskon <br>(Rp.)</th>
        <th>Pembebasan <br>(Rp.)</th>
        <th>Subsidi Asuransi <br>(Rp.)</th>
        <th>Subsidi Rumah Sakit <br>(Rp.)</th>
        <th>Subsidi Pemerintah <br>(Rp.)</th>
        <th>Tanggungan Pasien <br>(Rp.)</th><!-- Tanggungan Pasien = Iur Biaya -->
        <th>Subtotal <br>(Rp.)</th>
    </thead>
    <tbody>
        <?php
        $format = new MyFormatter();
        $tot_tarif_tindakan = 0;
        $tot_tarifcyto_tindakan = 0;
        $tot_discount_tindakan = 0;
        $tot_pembebasan_tindakan = 0;
        $tot_subsidiasuransi_tindakan = 0;
        $tot_subsisidirumahsakit_tindakan = 0;
        $tot_subsidipemerintah_tindakan = 0;
        $tot_iurbiaya_tindakan = 0;
        $total_tindakan = 0;
        $subtotal = 0;
        $subsidiasuransitind = 0;
        $subsidipemerintahtind = 0;
        if(isset($modTanggungan)){
            $subsidiasuransitind = $modTanggungan->subsidiasuransitind;
            $subsidipemerintahtind = $modTanggungan->subsidipemerintahtind;
        }
        if(count($dataTindakans) > 0){
            foreach($dataTindakans AS $i =>$tindakan){
                $tindakan->is_pilihtindakan = true;
                $tindakan->tgl_tindakan = $format->formatDateTimeForUser($tindakan->tgl_tindakan);
                $subsidi = $tindakan->subsidiasuransi_tindakan+$tindakan->subsisidirumahsakit_tindakan;
                $tindakan->subtotal = ($tindakan->qty_tindakan*$tindakan->tarif_satuan)+$tindakan->tarifcyto_tindakan-$tindakan->discount_tindakan-$tindakan->pembebasan_tindakan-$subsidi;
                $tindakan->subsidiasuransi_tindakan= $tindakan->getSubsidiPenjamin('subsidiasuransitind');
                $tindakan->subsidipemerintah_tindakan = $tindakan->getSubsidiPenjamin('subsidipemerintahtind');
                $tindakan->subsisidirumahsakit_tindakan = $this->periksaTanggunganPasien($tindakan);
                $tindakan->subtotal = $tindakan->subtotal - $tindakan->subsidiasuransi_tindakan;
                $tot_tarif_tindakan += ($tindakan->qty_tindakan*$tindakan->tarif_satuan);
                $tot_tarifcyto_tindakan += $tindakan->tarifcyto_tindakan;
                $tot_discount_tindakan += $tindakan->discount_tindakan;
                $tot_pembebasan_tindakan += $tindakan->pembebasan_tindakan;
                $tot_subsidiasuransi_tindakan += $tindakan->subsidiasuransi_tindakan;
                $tot_subsisidirumahsakit_tindakan += $tindakan->subsisidirumahsakit_tindakan;
                $tot_subsidipemerintah_tindakan += $tindakan->subsidipemerintah_tindakan;
                $tot_iurbiaya_tindakan += $tindakan->iurbiaya_tindakan;
                $total_tindakan += $tindakan->subtotal;
                $tindakan->qty_tindakan = $format->formatNumberForPrint($tindakan->qty_tindakan);
                $tindakan->tarif_satuan = $format->formatNumberForPrint($tindakan->tarif_satuan);
                $tindakan->tarifcyto_tindakan = $format->formatNumberForPrint($tindakan->tarifcyto_tindakan);
                $tindakan->discount_tindakan = $format->formatNumberForPrint($tindakan->discount_tindakan);
                $tindakan->pembebasan_tindakan = $format->formatNumberForPrint($tindakan->pembebasan_tindakan);
                $tindakan->subsidiasuransi_tindakan = $format->formatNumberForPrint($tindakan->subsidiasuransi_tindakan);
                $tindakan->subsisidirumahsakit_tindakan = $format->formatNumberForPrint($tindakan->subsisidirumahsakit_tindakan);
//                      DISAMAKAN DENGAN subtotal >>  $tindakan->iurbiaya_tindakan = $format->formatNumberForPrint($tindakan->iurbiaya_tindakan);
                $tindakan->iurbiaya_tindakan = $format->formatNumberForPrint($tindakan->subtotal);
                $tindakan->subtotal = $format->formatNumberForPrint($tindakan->subtotal);
                echo '<tr>'
                        .'<td>'.CHtml::activeCheckBox($tindakan, '['.$i.']is_pilihtindakan',array('onchange'=>'hitungTotalTindakan();','onkeyup'=>"return $(this).focusNextInputField(event);"))  
                        .CHtml::activeHiddenField($tindakan, '['.$i.']tindakanpelayanan_id',array('readonly'=>true, 'class'=>'span1'))  
                        .CHtml::activeHiddenField($tindakan, '['.$i.']daftartindakan_id',array('readonly'=>true, 'class'=>'span1'))  
                        .'</td>'
                        .'<td>'.CHtml::activeTextField($tindakan, '['.$i.']tgl_tindakan',array('readonly'=>true,'class'=>'inputFormTabel lebar4', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                        .'<td>'.$tindakan->daftartindakan->daftartindakan_kode.'-'.$tindakan->daftartindakan->daftartindakan_nama.'</td>'
                        .'<td>'.CHtml::activeTextField($tindakan, '['.$i.']qty_tindakan',array('readonly'=>true,'class'=>'inputFormTabel lebar1 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                        .'<td>'.CHtml::activeTextField($tindakan, '['.$i.']tarif_satuan',array('readonly'=>true,'class'=>'inputFormTabel lebar3 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                        .'<td>'.CHtml::activeTextField($tindakan, '['.$i.']tarifcyto_tindakan',array('readonly'=>true,'class'=>'inputFormTabel lebar3 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                        .'<td>'.CHtml::activeTextField($tindakan, '['.$i.']discount_tindakan',array('onblur'=>'hitungTotalTindakan();','class'=>'inputFormTabel lebar3 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                        .'<td>'.CHtml::activeTextField($tindakan, '['.$i.']pembebasan_tindakan',array('onblur'=>'hitungTotalTindakan();','class'=>'inputFormTabel lebar3 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                        .'<td>'.CHtml::activeTextField($tindakan, '['.$i.']subsidiasuransi_tindakan',array('onblur'=>'hitungTotalTindakan();','class'=>'inputFormTabel lebar3 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                        .'<td>'.CHtml::activeTextField($tindakan, '['.$i.']subsisidirumahsakit_tindakan',array('onblur'=>'hitungTotalTindakan();','class'=>'inputFormTabel lebar3 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                        .'<td>'.CHtml::activeTextField($tindakan, '['.$i.']subsidipemerintah_tindakan',array('onblur'=>'hitungTotalTindakan();','class'=>'inputFormTabel lebar3 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                        .'<td>'.CHtml::activeTextField($tindakan, '['.$i.']iurbiaya_tindakan',array('readonly'=>true,'class'=>'inputFormTabel lebar3 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                        .'<td>'.CHtml::activeTextField($tindakan, '['.$i.']subtotal',array('readonly'=>true,'class'=>'inputFormTabel lebar3 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                    .'</tr>';
            }
        }
        ?>
    </tbody>
    <tfoot>
        <?php
        //formatting total
        $tot_tarif_tindakan = $format->formatNumberForPrint($tot_tarif_tindakan);
        $tot_tarifcyto_tindakan = $format->formatNumberForPrint($tot_tarifcyto_tindakan);
        $tot_discount_tindakan = $format->formatNumberForPrint($tot_discount_tindakan);
        $tot_pembebasan_tindakan = $format->formatNumberForPrint($tot_pembebasan_tindakan);
        $tot_subsidiasuransi_tindakan = $format->formatNumberForPrint($tot_subsidiasuransi_tindakan);
        $tot_subsidipemerintah_tindakan = $format->formatNumberForPrint($tot_subsidipemerintah_tindakan);
        $tot_subsisidirumahsakit_tindakan = $format->formatNumberForPrint($tot_subsisidirumahsakit_tindakan);
        $tot_iurbiaya_tindakan = $format->formatNumberForPrint($total_tindakan);
        $total_tindakan = $format->formatNumberForPrint($total_tindakan);
        ?>
        <td colspan="4" style="text-align: right; font-weight: bold;"><?php echo CHtml::checkBox('is_proporsitindakan',false,array('onchange'=>'setProporsiTindakan();','rel'=>'tooltip','title'=>'Centang untuk masukan proporsi dari total tindakan','onkeyup'=>"return $(this).focusNextInputField(event);")) ?> Total Tagihan Tindakan</td>
        <td><?php echo CHtml::textField('tot_tarif_tindakan',$tot_tarif_tindakan,array('readonly'=>true,'class'=>'inputFormTabel lebar3 integer2','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
        <td><?php echo CHtml::textField('tot_tarifcyto_tindakan',$tot_tarifcyto_tindakan,array('readonly'=>true,'class'=>'inputFormTabel lebar3 integer2','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
        <td><?php echo CHtml::textField('tot_discount_tindakan',$tot_discount_tindakan,array('onblur'=>'proporsiDiskonTindakan();','readonly'=>true,'class'=>'inputFormTabel lebar3 integer2','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
        <td><?php echo CHtml::textField('tot_pembebasan_tindakan',$tot_pembebasan_tindakan,array('onblur'=>'proporsiPembebasanTindakan();','readonly'=>true,'class'=>'inputFormTabel lebar3 integer2','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
        <td><?php echo CHtml::textField('tot_subsidiasuransi_tindakan',$tot_subsidiasuransi_tindakan,array('onblur'=>'proporsiSubsidiAsuransiTindakan();','readonly'=>true,'class'=>'inputFormTabel lebar3 integer2','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
        <td><?php echo CHtml::textField('tot_subsisidirumahsakit_tindakan',$tot_subsisidirumahsakit_tindakan,array('onblur'=>'proporsiSubsidiRsTindakan();','readonly'=>true,'class'=>'inputFormTabel lebar3 integer2','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
        <td><?php echo CHtml::textField('tot_subsidipemerintah_tindakan',$tot_subsidipemerintah_tindakan,array('onblur'=>'proporsiSubsidiPemerintahTindakan();','readonly'=>true,'class'=>'inputFormTabel lebar3 integer2','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
        <td><?php echo CHtml::textField('tot_iurbiaya_tindakan',$tot_iurbiaya_tindakan,array('readonly'=>true,'class'=>'inputFormTabel lebar3 integer2','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
        <td><?php echo CHtml::textField('total_tindakan',$total_tindakan,array('readonly'=>true,'class'=>'inputFormTabel lebar3 integer2','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
    </tfoot>
</table>


