<table id="tblReturResepDetail" class="table table-striped table-bordered table-condensed">
    <thead>
        <tr>
            <th>Retur</th>
            <th>No</th>
            <th>Obat</th>
            <th>Harga Satuan</th>
            <th>Jumlah Jual</th>
            <th>Jumlah Retur</th>
            <?php echo !empty($modReturDetail[0]->returresepdet_id) ?  "<th>Jumlah Setelah Retur</th>" : "";?>
            <th>Satuan</th>
            <th>Kondisi Obat</th>
            <th>Sub Total Retur</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $subTotal = 0;
        $totalSubTotal = 0;
        if (empty($modReturDetail[0]->returresepdet_id)){
            foreach ($modObatAlkesPasien as $i => $mod) {?>
                <tr>
                    <td><?php echo CHtml::checkBox('FAReturresepdetT['.$i.'][isRetur]', true, array('class'=>'isRetur','onclick'=>'setNullQty(this);hitungTabel();','onKeypress'=>'return formSubmit(this,event)')) ?></td>
                    <td>
                        <?php echo ($i+1);?>
                        <?php echo CHtml::hiddenField('FAReturresepdetT['.$i.'][obatalkespasien_id]', $mod->obatalkespasien_id);?>
                        <?php echo CHtml::hiddenField('FAReturresepdetT['.$i.'][obatalkes_id]', $mod->obatalkes_id);?>
                        <?php echo CHtml::hiddenField('FAReturresepdetT['.$i.'][satuankecil_id]', $mod->satuankecil_id);?>
                    </td>
                    <td><?php echo $mod->obatalkes->obatalkes_kode." - ".$mod->obatalkes->obatalkes_nama; ?>
                    </td>
                    <td><?php echo CHtml::textField('FAReturresepdetT['.$i.'][hargasatuan]', number_format($mod->hargasatuan_oa), array('class'=>'span1 integer harga', 'style'=>'text-align:right;', 'readonly'=>true));?></td>
                    <td><?php echo CHtml::textField('qty_oa', $mod->qty_oa, array('class'=>'span1 integer', 'style'=>'text-align:right;', 'readonly'=>true));?></td>
                    <td><?php echo CHtml::textField('FAReturresepdetT['.$i.'][qty_retur]', $mod->qty_oa, array('class'=>'span1 integer qty', 'style'=>'text-align:right;', 'onkeyup'=>'validasiQty(this); hitungTabel();', 'onKeypress'=>'return formSubmit(this,event)'));?></td>
                    <td><?php echo $mod->satuankecil->satuankecil_nama;?></td>
                    <td><?php echo CHtml::textField('FAReturresepdetT['.$i.'][kondisibrg]', '', array('class'=>'span2', 'onKeypress'=>'return formSubmit(this,event)'));?></td>
                    <td>
                        <?php
                            $subTotal = number_format($mod->qty_oa,0,'','') * number_format($mod->hargasatuan_oa,0,'','');
                            $totalSubTotal += $subTotal;
                            echo CHtml::textField('subtotal', number_format($subTotal), array('class'=>'span1 integer subtotal', 'style'=>'text-align:right;', 'readonly'=>true));
                        ?>
                    </td>
                </tr>
        <?php } ?> 
        <tr>
            <td colspan="8" style="text-align: right;"><b>Total</b></td>
            <td><?php echo CHtml::textField('total', number_format($totalSubTotal), array('class'=>'span1 integer total', 'style'=>'text-align:right;', 'readonly'=>true));?></td>
        </tr>
        <tr>
            <td colspan="8" style="text-align: right;"><b>Biaya Administrasi + Tarif Service + Konseling + Jasa Dokter</b></td>
            <td><?php 
                $biayaAdmin = $modPenjualanResep->totaltarifservice + $modPenjualanResep->biayaadministrasi + $modPenjualanResep->biayakonseling ;//+ $modPenjualanResep->jasadokterresep <<< SDH TERMASUK DLM HARGA OBAT
                echo CHtml::textField('biayaAdministrasi', number_format($biayaAdmin), array('class'=>'span1 integer totalAdmin', 'style'=>'text-align:right;', 'readonly'=>true));
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="8" style="text-align: right;"><b>Total Retur</b></td>
            <td><?php 
                $totalRetur = $totalSubTotal + $biayaAdmin;
                echo CHtml::textField('FAReturresepT[totalretur]', number_format($totalRetur), array('class'=>'span1 integer totalRetur', 'style'=>'text-align:right;', 'readonly'=>true));
                ?>
            </td>
        </tr>
        <?php }
        else if(!empty($modReturDetail[0]->returresepdet_id)){
            foreach ($modReturDetail as $i => $mod) {
            ?>
            <tr>
                <td><?php echo CHtml::checkBox('FAReturresepdetT['.$i.'][isRetur]', true, array('readonly'=>true)) ?></td>
                <td><?php echo ($i+1);?></td>
                <td><?php echo $mod->obatpasien->obatalkes->obatalkes_kode." - ".$mod->obatpasien->obatalkes->obatalkes_nama; ?></td>
                <td><?php echo number_format($mod->hargasatuan,0,'','.');?></td>
                <td style="text-align: right;"><?php echo number_format($mod->obatpasien->qty_oa + $mod->qty_retur); //Ditambah karena kuantiti di obatalkespasie berkurang saat proses retur?></td>
                <td style="text-align: right;"><?php echo number_format($mod->qty_retur); ?></td>
                <td style="text-align: right;"><?php echo number_format($mod->obatpasien->qty_oa); ?></td>
                <td><?php echo $mod->obatpasien->satuankecil->satuankecil_nama;?></td>
                <td><?php echo $mod->kondisibrg;?></td>
                <td>
                    <?php
                        $subTotal = number_format($mod->qty_retur,0,'','') * number_format($mod->hargasatuan,0,'','');
                        $totalSubTotal += $subTotal;
                        echo number_format($subTotal,0,'','.');
                    ?>
                </td>
            </tr>
            
        <?php
            } ?>
            <tr>
                <td colspan="9" style="text-align: right;"><b>Biaya Administrasi, dll</b></td>
                <td><?php 
                    echo number_format($modRetur->totalretur - $totalSubTotal); 
                ?></td>
            </tr>
            <tr>
                <td colspan="9" style="text-align: right;"><b>Total Retur</b></td>
                <td><?php echo number_format($modRetur->totalretur,0,'','.'); ?></td>
            </tr>
        <?php }
        else{
            echo '<tr><td colspan=9><i>Data Obat Alkes tidak ditemukan</></td></tr>';
        }
        ?>
    </tbody>
</table>
<script>
    function hitungTabel(){
        var total = 0;
        var totalRetur = 0;
        var harga = 0;
        var qty = 0;
        $('#tblReturResepDetail tbody').find('tr').each(
            function(){
                if($(this).find('.isRetur').is(':checked') == true){
                    var harga = unformatNumber($(this).find('.harga').val());
                    var qty = unformatNumber($(this).find('.qty').val());
                }
                var subtotal = harga * qty;
                total += unformatNumber(subtotal);
                $(this).find('.subtotal').val(formatNumber(subtotal).replace('.0', ""));
                $(this).find('.total').val(formatNumber(total).replace('.0', ""));
            }
        );
        hitungTotalRetur();
    }
    function hitungTotalRetur(){
        var totalRetur = unformatNumber($('#biayaAdministrasi').val()) + unformatNumber($('#total').val());
        $('#FAReturresepT_totalretur').val(formatNumber(totalRetur).replace('.0',''));
    }
    function validasiQty(obj){
        var qty_oa = 0;
        qty_oa = unformatNumber($(obj).parent().parent().find('#qty_oa').val());
        if($(obj).val() > qty_oa){
            myAlert("Jumlah Retur Tidak boleh lebih besar dari qty "+qty_oa+" !");
            $(obj).val(qty_oa);
        }
    }
    function setNullQty(obj){
        if($(obj).is(':checked') == false){
            $(obj).parent().parent().find('.qty').val(0);
        }else{
            var qty_oa = $(obj).parent().parent().find('#qty_oa').val();
            $(obj).parent().parent().find('.qty').val(qty_oa);
        }
    }
</script>