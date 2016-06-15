<table class="table table-striped table-condensed">
    <thead>
        <th>Pilih <?php echo CHtml::checkBox('is_pilihsemuaoa',true,array('onchange'=>'setPilihOaChecked();','rel'=>'tooltip','title'=>'Centang untuk pilih semua obat dan alkes','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></th>
        <th>Tanggal</th>
        <th width="50%">Deskripsi Obat & Alkes</th>
        <th>Jumlah</th>
        <th>Harga Satuan <br>(Rp.)</th>
        <th>Tarif Cyto <br>(Rp.)</th>
        <th>Diskon <br>(Rp.)</th>
        <th>Biaya Admin <br>(Rp.)</th>
        <th>Subsidi Asuransi <br>(Rp.)</th>
        <th>Subsidi Rumah Sakit <br>(Rp.)</th>
        <th>Subsidi Pemerintah <br>(Rp.)</th>
        <th>Tanggungan Pasien <br>(Rp.)</th><!-- Tanggungan Pasien = Iur Biaya -->
        <th>Subtotal <br>(Rp.)</th>
    </thead>
    <tbody>
        <?php
        $format = new MyFormatter();
        $tot_hargajual_oa = 0;
        $tot_tarifcyto = 0;
        $tot_discount = 0;
        $tot_biayalain = 0;
        $tot_subsidiasuransi = 0;
        $tot_subsidipemerintah = 0;
        $tot_subsidirs = 0;
        $tot_iurbiaya = 0;
        $total_oa = 0;
        $subtotaloa = 0;
        if(count($dataOas) > 0){
            foreach($dataOas AS $i =>$obatalkes){
                $obatalkes->is_pilihoa = true;
                $obatalkes->tglpelayanan = $format->formatDateTimeForUser($obatalkes->tglpelayanan);
                $obatalkes->biayalain = $obatalkes->biayaservice + $obatalkes->biayakonseling + $obatalkes->biayakemasan + $obatalkes->biayaadministrasi;
                $subsidi = $obatalkes->subsidiasuransi+$obatalkes->subsidirs;
                $obatalkes->subtotaloa = ($obatalkes->qty_oa*$obatalkes->hargasatuan_oa)+$obatalkes->tarifcyto-$obatalkes->discount+$obatalkes->biayalain-$subsidi;
                $obatalkes->subsidirs = $obatalkes->getSubsidiPenjamin('subsidirumahsakitoa');//($obatalkes->qty_oa*$obatalkes->hargasatuan_oa);
                $obatalkes->subsidipemerintah = $obatalkes->getSubsidiPenjamin('subsidipemerintahoa');//($obatalkes->qty_oa*$obatalkes->hargasatuan_oa);
                $tot_hargajual_oa += ($obatalkes->qty_oa*$obatalkes->hargasatuan_oa);
                $tot_tarifcyto += $obatalkes->tarifcyto;
                $tot_discount += $obatalkes->discount;
                $tot_biayalain += $obatalkes->biayalain;
                $tot_subsidiasuransi += $obatalkes->subsidiasuransi;
                $tot_subsidipemerintah += $obatalkes->subsidipemerintah;
                $tot_subsidirs += $obatalkes->subsidirs;
                $tot_iurbiaya += $obatalkes->subtotaloa - ($obatalkes->subsidiasuransi + $obatalkes->subsidipemerintah + $obatalkes->subsidirs);
                
                $total_oa += $obatalkes->subtotaloa;
                $obatalkes->qty_oa = $format->formatNumberForPrint($obatalkes->qty_oa);
                $obatalkes->hargasatuan_oa = $format->formatNumberForPrint($obatalkes->hargasatuan_oa);
                $obatalkes->tarifcyto = $format->formatNumberForPrint($obatalkes->tarifcyto);
                $obatalkes->discount = $format->formatNumberForPrint($obatalkes->discount);
                $obatalkes->biayalain = $format->formatNumberForPrint($obatalkes->biayalain);
                $obatalkes->subsidiasuransi = $format->formatNumberForPrint($obatalkes->subsidiasuransi);
                // $obatalkes->subsidipemerintah = $format->formatNumberForPrint($obatalkes->subsidipemerintah);
                $obatalkes->subsidirs = $format->formatNumberForPrint($obatalkes->subsidirs);
////                  DISAMAKAN DENGAN subtotaloa >>  $obatalkes->iurbiaya = $format->formatNumberForPrint($obatalkes->iurbiaya);
                $obatalkes->iurbiaya = $format->formatNumberForPrint($obatalkes->subtotaloa - ($obatalkes->subsidiasuransi + $obatalkes->subsidipemerintah + $obatalkes->subsidirs));
                $obatalkes->subtotaloa = $format->formatNumberForPrint($obatalkes->subtotaloa);
                echo '<tr>'
                        .'<td>'.CHtml::activeCheckBox($obatalkes, '['.$i.']is_pilihoa',array('onchange'=>'hitungTotalOa();','onkeyup'=>"return $(this).focusNextInputField(event);"))  
                        .CHtml::activeHiddenField($obatalkes, '['.$i.']obatalkespasien_id',array('readonly'=>true, 'class'=>'span1'))  
                        .CHtml::activeHiddenField($obatalkes, '['.$i.']obatalkes_id',array('readonly'=>true, 'class'=>'span1'))  
                        .'</td>'
                        .'<td>'.CHtml::activeTextField($obatalkes, '['.$i.']tglpelayanan',array('readonly'=>true,'class'=>'inputFormTabel lebar4', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                        .'<td>'.$obatalkes->obatalkes->obatalkes_kode.'-'.$obatalkes->obatalkes->obatalkes_nama.'</td>'
                        .'<td>'.CHtml::activeTextField($obatalkes, '['.$i.']qty_oa',array('readonly'=>true,'class'=>'inputFormTabel lebar1 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                        .'<td>'.CHtml::activeTextField($obatalkes, '['.$i.']hargasatuan_oa',array('readonly'=>true,'class'=>'inputFormTabel lebar3 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                        .'<td>'.CHtml::activeTextField($obatalkes, '['.$i.']tarifcyto',array('readonly'=>true,'class'=>'inputFormTabel lebar3 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                        .'<td>'.CHtml::activeTextField($obatalkes, '['.$i.']discount',array('onblur'=>'hitungTotalOa();','class'=>'inputFormTabel lebar3 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                        .'<td>'.CHtml::activeTextField($obatalkes, '['.$i.']biayalain',array('onblur'=>'hitungTotalOa();','class'=>'inputFormTabel lebar3 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                        .'<td>'.CHtml::activeTextField($obatalkes, '['.$i.']subsidiasuransi',array('onblur'=>'hitungTotalOa();','class'=>'inputFormTabel lebar3 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                        .'<td>'.CHtml::activeTextField($obatalkes, '['.$i.']subsidirs',array('onblur'=>'hitungTotalOa();','class'=>'inputFormTabel lebar3 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                        .'<td>'.CHtml::activeTextField($obatalkes, '['.$i.']subsidipemerintah',array('onblur'=>'hitungTotalOa();','class'=>'inputFormTabel lebar3 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                        .'<td>'.CHtml::activeTextField($obatalkes, '['.$i.']iurbiaya',array('readonly'=>true,'class'=>'inputFormTabel lebar3 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                        .'<td>'.CHtml::activeTextField($obatalkes, '['.$i.']subtotaloa',array('readonly'=>true,'class'=>'inputFormTabel lebar3 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                    .'</tr>';
            }
        }
        ?>
    </tbody>
    <tfoot>
        <?php
        //formatting total
        $tot_hargajual_oa = $format->formatNumberForPrint($tot_hargajual_oa);
        $tot_tarifcyto = $format->formatNumberForPrint($tot_tarifcyto);
        $tot_discount = $format->formatNumberForPrint($tot_discount);
        $tot_biayalain = $format->formatNumberForPrint($tot_biayalain);
        $tot_subsidiasuransi = $format->formatNumberForPrint($tot_subsidiasuransi);
        $tot_subsidipemerintah = $format->formatNumberForPrint($tot_subsidipemerintah);
        $tot_subsidirs = $format->formatNumberForPrint($tot_subsidirs);
        $tot_iurbiaya = $format->formatNumberForPrint($tot_iurbiaya);
        $total_oa = $format->formatNumberForPrint($total_oa);
        
        //var_dump($tot_subsidipemerintah); die;
        
        ?>
        <td colspan="4" style="text-align: right; font-weight: bold;"><?php echo CHtml::checkBox('is_proporsioa',false,array('onchange'=>'setProporsiOa();','rel'=>'tooltip','title'=>'Centang untuk masukan proporsi dari total obat alkes','onkeyup'=>"return $(this).focusNextInputField(event);")) ?> Total Tagihan Obat & Alkes</td>
        <td><?php echo CHtml::textField('tot_hargajual_oa',$tot_hargajual_oa,array('readonly'=>true,'class'=>'inputFormTabel lebar3 integer2','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
        <td><?php echo CHtml::textField('tot_tarifcyto',$tot_tarifcyto,array('readonly'=>true,'class'=>'inputFormTabel lebar3 integer2','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
        <td><?php echo CHtml::textField('tot_discount',$tot_discount,array('onblur'=>'proporsiDiskonOa();','readonly'=>true,'class'=>'inputFormTabel lebar3 integer2','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
        <td><?php echo CHtml::textField('tot_biayalain',$tot_biayalain,array('onblur'=>'proporsiBiayaAdminOa();','readonly'=>true,'class'=>'inputFormTabel lebar3 integer2','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
        <td><?php echo CHtml::textField('tot_subsidiasuransi',$tot_subsidiasuransi,array('onblur'=>'proporsiSubsidiAsuransiOa();','readonly'=>true,'class'=>'inputFormTabel lebar3 integer2','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
        <td><?php echo CHtml::textField('tot_subsidirs',$tot_subsidirs,array('onblur'=>'proporsiSubsidiRsOa();','readonly'=>true,'class'=>'inputFormTabel lebar3 integer2','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
        <td><?php echo CHtml::textField('tot_subsidipemerintah',$tot_subsidipemerintah,array('onblur'=>'proporsiSubsidiPemerintahOa();','readonly'=>true,'class'=>'inputFormTabel lebar3 integer2','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
        <td><?php echo CHtml::textField('tot_iurbiaya',$tot_iurbiaya,array('readonly'=>true,'class'=>'inputFormTabel lebar3 integer2','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
        <td><?php echo CHtml::textField('total_oa',$total_oa,array('readonly'=>true,'class'=>'inputFormTabel lebar3 integer2','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
    </tfoot>
</table>


