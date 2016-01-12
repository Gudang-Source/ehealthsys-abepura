<?php
$namaModel = "AKRincianpiutangrekeningpasienV";
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
                        $value->namadepan." ".$value->nama_pasien.
                        CHtml::hiddenField($namaModel."[$key][pasien_id]", $value->pasien_id,array('readonly'=>true, 'class'=>'span2')).
                    "</td>";
                echo "<td>".
                        $value->no_rekam_medik."<br>/ ".$value->no_pendaftaran.
                        CHtml::hiddenField($namaModel."[$key][pendaftaran_id]", $value->pendaftaran_id,array('readonly'=>true, 'class'=>'span2')).
                    "</td>";
                echo "<td>".
                        $value->instalasi_nama."<br>/ ".$value->ruangan_nama.
                        CHtml::hiddenField($namaModel."[$key][instalasi_id]", $value->instalasi_id,array('readonly'=>true, 'class'=>'span2')).
                        CHtml::hiddenField($namaModel."[$key][ruangan_id]", $value->ruangan_id,array('readonly'=>true, 'class'=>'span2')).
                    "</td>";
                echo "<td>".
                        $value->carabayar_nama."<br>/ ".$value->penjamin_nama.
                        CHtml::hiddenField($namaModel."[$key][carabayar_id]", $value->carabayar_id,array('readonly'=>true, 'class'=>'span2')).
                        CHtml::hiddenField($namaModel."[$key][penjamin_id]", $value->penjamin_id,array('readonly'=>true, 'class'=>'span2')).
                    "</td>";
                echo "<td>".//uraian transaksi belum ada kolom nya
                        (isset($value->daftartindakan_kode) ? $value->daftartindakan_kode." - " : "").
                        $value->daftartindakan_nama.
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
//                echo CHtml::hiddenField($namaModel."[$key][nama_rekening]", $value->nmrincianobyek,array('readonly'=>true));
                echo CHtml::hiddenField($namaModel."[$key][nama_rekening]", $value->daftartindakan_nama,array('readonly'=>true));
                echo CHtml::hiddenField($namaModel."[$key][jnspelayanan]", $value->jnspelayanan,array('readonly'=>true));
                echo CHtml::hiddenField($namaModel."[$key][tm]", $value->tm,array('readonly'=>true));
                echo CHtml::hiddenField($namaModel."[$key][daftartindakan_id]", $value->daftartindakan_id,array('readonly'=>true));
                echo CHtml::hiddenField($namaModel."[$key][tindakanpelayanan_id]", $value->tindakanpelayanan_id,array('readonly'=>true));
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
                        'onkeyup' => "hitungSemua();",
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                    )
                );
            echo '</td>';
            echo '<td>';
                echo CHtml::textField($namaModel."[$key][saldokredit]",
                    number_format($value->saldokredit),
                    array(
                        'class'=>'inputFormTabel uncurrency',
                        //'disabled'=>($status == 'kredit' ? "" : "disabled"),
                        'onkeyup' => "hitungSemua();",
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                    )
                );
            echo '</td>';
        echo('</tr>');
    }
}
?>