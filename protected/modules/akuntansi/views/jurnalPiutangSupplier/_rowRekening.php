<?php
$namaModel = "AKRincianfakturhutangsupplierV";
$noUrut = 1;
if(count($modRekenings) > 0){
    foreach($modRekenings as $key=>$value)
    {
        echo('<tr>');
                echo "<td>".
                        CHtml::checkBox($namaModel."[$key][pilihRekening]",true).
                    "</td>";
                echo "<td>".
                        CHtml::textField("noUrut", ($noUrut),array('readonly'=>true, 'style'=>'width:20px; text-align:right;')).
                    "</td>"; $noUrut++;
                echo "<td>".
                        $value->tglfaktur.
                        CHtml::hiddenField($namaModel."[$key][fakturpembelian_id]", $value->fakturpembelian_id,array('readonly'=>true, 'class'=>'span2')).
                    "</td>";
                echo "<td>".
                        $value->nofaktur.
                    "</td>";
                echo "<td>".
                        $value->supplier_nama.
                        CHtml::hiddenField($namaModel."[$key][supplier_id]", $value->supplier_id,array('readonly'=>true, 'class'=>'span2')).
                    "</td>";
                echo "<td>".
                        CHtml::hiddenField("row", $key,array('readonly'=>true, 'class'=>'span1')).
                        CHtml::textField($namaModel."[$key][kdstruktur]", $value->kdstruktur,array('readonly'=>true, 'class'=>'span1', 'style'=>'width:20px')).
                        CHtml::hiddenField($namaModel."[$key][struktur_id]", $value->struktur_id,array('readonly'=>true, 'class'=>'span1')).
                        CHtml::textField($namaModel."[$key][kdkelompok]", $value->kdkelompok,array('readonly'=>true, 'class'=>'span1', 'style'=>'width:20px')).
                        CHtml::hiddenField($namaModel."[$key][kelompok_id]", $value->kelompok_id,array('readonly'=>true, 'class'=>'span1')).
                        CHtml::textField($namaModel."[$key][kdjenis]", $value->kdjenis,array('readonly'=>true, 'class'=>'span1', 'style'=>'width:20px')).
                        CHtml::hiddenField($namaModel."[$key][jenis_id]", $value->jenis_id,array('readonly'=>true, 'class'=>'span1')).
                        CHtml::textField($namaModel."[$key][kdobyek]", $value->kdobyek,array('readonly'=>true, 'class'=>'span1', 'style'=>'width:20px')).
                        CHtml::hiddenField($namaModel."[$key][obyek_id]", $value->obyek_id,array('readonly'=>true, 'class'=>'span1')).
                        CHtml::textField($namaModel."[$key][kdrincianobyek]", $value->kdrincianobyek,array('readonly'=>true, 'class'=>'span1')).
                        CHtml::hiddenField($namaModel."[$key][rincianobyek_id]", $value->rincianobyek_id,array('readonly'=>true, 'class'=>'span1')).
                    "</td>";
                echo('<td>');
                echo CHtml::hiddenField($namaModel."[$key][nama_rekening]", $value->nmrincianobyek,array('readonly'=>true));
                $this->widget('MyJuiAutoComplete',
                    array(
                        'value'=>$value->nmrincianobyek,
                        'name' => $namaModel."[$key][rekDebitKredit]",
                        'id' => $namaModel."_".$key."_rekDebitKredit",
                        'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi', array('id_jenis_rek'=>null)),
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 2,
                            'focus' => 'js:function( event, ui ){
                                return false;
                            }',
                            'select' => 'js:function( event, ui ){
                                $(this).val(ui.item.value);
                                var data = {
                                    //DATA DI TAMBAHKAN MELAUI FUNGSI .autocomplete di renameRowRekening()
                                };
                                editDataRekeningFromGrid(data, row);                            
                                return false;
                            }'
                        ),
                        'htmlOptions' => array(
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                            'placeholder'=>'Ketikan Nama Rekening',
                            'style'=>'width:200px;',
                        ),
                        'tombolDialog' => array(
                            'idDialog' => 'dialogRekDebitKredit',
                            'jsFunction'=>"setDialogRekening(this);",
                        ),
                    )
                );
            echo('</td>');
            
            echo '<td>';
                echo CHtml::textField($namaModel."[$key][saldodebit]", 
                    number_format($value->saldodebit),
                    array(
                        'class'=>'inputFormTabel uncurrency',
                        //'disabled'=>($status == 'debit' ? "" : "disabled"),
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'onkeyup'=>'hitungSaldo(this)',
                    )
                );
            echo '</td>';
            echo '<td>';
                echo CHtml::textField($namaModel."[$key][saldokredit]",
                    number_format($value->saldokredit),
                    array(
                        'class'=>'inputFormTabel uncurrency',
                        //'disabled'=>($status == 'kredit' ? "" : "disabled"),
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'onkeyup'=>'hitungSaldo(this)',
                    )
                );
            echo '</td>';
        echo('</tr>');
    }
}
?>