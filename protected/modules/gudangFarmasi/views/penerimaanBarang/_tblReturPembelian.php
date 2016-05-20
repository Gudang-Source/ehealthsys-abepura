<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<table id="tblReturPembelian" class="table table-striped table-condensed">
    <thead>
        <tr>
            <th>Retur</th>
            <th>No</th>
            <th>Obat Alkes</th>
            <th>Harga Satuan Retur</th>
            <th>Jumlah Terima</th>
            <th>Jumlah Retur</th>
            <th>Satuan</th>
            <th>Sub Total Retur</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $subTotal = 0;
        $totalSubTotal = 0;
            foreach ($modPenerimaanDet as $i => $mod) {
                if (!empty($mod->satuanbesar_id)) {
                    $mod->jmlterima *= $mod->kemasanbesar;
                }
                
                ?>
                <tr>
                    <td><?php echo CHtml::checkBox('GFReturDetailT['.$i.'][isRetur]', true, array('class'=>'isRetur','onclick'=>'setNullQty(this);hitungTabel();','onKeypress'=>'return formSubmit(this,event)')) ?></td>
                    <td>
                        <?php echo ($i+1);?>
                        <?php echo CHtml::hiddenField('GFReturDetailT['.$i.'][penerimaandetail_id]', $mod->penerimaandetail_id);?>
                        <?php echo CHtml::hiddenField('GFReturDetailT['.$i.'][obatalkes_id]', $mod->obatalkes_id);?>
                        <?php echo CHtml::hiddenField('GFReturDetailT['.$i.'][satuanbesar_id]', $mod->satuanbesar_id);?>
                        <?php echo CHtml::hiddenField('GFReturDetailT['.$i.'][fakturdetail_id]', $mod->fakturdetail_id);?>
                        <?php echo CHtml::hiddenField('GFReturDetailT['.$i.'][sumberdana_id]', $mod->sumberdana_id);?>
                        <?php echo CHtml::hiddenField('GFReturDetailT['.$i.'][satuankecil_id]', $mod->satuankecil_id);?>
                    </td>
                    <td><?php echo $mod->obatalkes->obatalkes_kode." - ".$mod->obatalkes->obatalkes_nama; ?>
                    </td>
                    <td>
                        <?php echo CHtml::hiddenField('GFReturDetailT['.$i.'][harganettoretur]', $mod->harganettoper);?>
                        <?php echo CHtml::hiddenField('GFReturDetailT['.$i.'][hargappnretur]', $mod->persenppn);?>
                        <?php echo CHtml::hiddenField('GFReturDetailT['.$i.'][hargapphretur]', $mod->persenpph);?>
                        <?php echo CHtml::hiddenField('GFReturDetailT['.$i.'][jmldiscount]', $mod->jmldiscount);?>
						<?php echo CHtml::textField('GFReturDetailT['.$i.'][hargasatuanretur]', MyFormatter::formatNumberForPrint($mod->hargasatuanper), array('class'=>'span2 harga', 'style'=>'text-align:right;', 'readonly'=>true));?></td>
					<td><?php echo CHtml::textField('jmlterima', $mod->jmlterima, array('class'=>'span1 integer2', 'style'=>'text-align:right;', 'readonly'=>true));?></td>
                    <td><?php echo CHtml::textField('GFReturDetailT['.$i.'][jmlretur]', $mod->jmlterima, array('class'=>'span1 integer2 qty', 'style'=>'text-align:right;', 'onkeyup'=>'validasiQty(this); hitungTabel();', 'onKeypress'=>'return formSubmit(this,event)'));?></td>
                    <td><?php echo $mod->obatalkes->satuankecil->satuankecil_nama;?></td>
                    <td>
                        <?php
                            $subTotal = number_format($mod->jmlterima,0,'','') * number_format($mod->hargasatuanper,0,'','');
                            $totalSubTotal += $subTotal;
                            echo CHtml::textField('subtotal', MyFormatter::formatNumberForPrint($subTotal), array('class'=>'span2 integer2 subtotal', 'style'=>'text-align:right;', 'readonly'=>true));
                        ?>
                    </td>
                </tr>
        <?php } ?> 
        <tr>
            <td colspan="7" style="text-align: right;"><b>Total Retur</b></td>
            <td><?php 
                $totalRetur = $totalSubTotal;
                echo CHtml::textField('GFReturPembelianT[totalretur]', number_format($totalRetur), array('class'=>'span2 integer2 totalRetur', 'style'=>'text-align:right;', 'readonly'=>true));
                ?>
            </td>
        </tr>
    </tbody>
</table>


<script>
    function hitungTabel(){
        var total = 0;
        var totalRetur = 0;
        var harga = 0;
        var qty = 0;
        $('#tblReturPembelian tbody').find('tr').each(
            function(){
                if($(this).find('.isRetur').is(':checked') == true){
                    var harga = unformatNumber($(this).find('.harga').val());
                    var qty = unformatNumber($(this).find('.qty').val());
                }
                var subtotal = harga * qty;
                total += unformatNumber(subtotal);
                $(this).find('.subtotal').val(formatNumber(subtotal).replace('.0', ""));
                $(this).find('.totalRetur').val(formatNumber(total).replace('.0', ""));
            }
        );
    }
	
    function validasiQty(obj){
        var jmlterima = 0;
        jmlterima = unformatNumber($(obj).parent().parent().find('#jmlterima').val());
        if(unformatNumber($(obj).val()) > jmlterima){
            myAlert("Jumlah Retur Tidak boleh lebih besar dari Jumlah Terima "+jmlterima+" !");
            $(obj).val(jmlterima);
        }
    }
    function setNullQty(obj){
        if($(obj).is(':checked') == false){
            $(obj).parent().parent().find('.qty').val(0);
        }else{
            var jmlterima = $(obj).parent().parent().find('#jmlterima').val();
            $(obj).parent().parent().find('.qty').val(jmlterima);
        }
    }
</script>