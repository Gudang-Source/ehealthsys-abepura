<?php

    // $this->widget('application.extensions.moneymask.MMask', array(
    //     'element' => '.numbersOnly',
    //     'config' => array(
    //         'defaultZero' => true,
    //         'allowZero' => true,
    //         'decimal' => '.',
    //         'thousands' => '',
    //         'precision' =>0,
    //     )
    // ));
    
    // $this->widget('application.extensions.moneymask.MMask',array(
    //     'element'=>'.currency',
    //     'currency'=>'PHP',
    //     'config'=>array(
    //         'symbol'=>'Rp ',
    //         'defaultZero'=>true,
    //         'allowZero'=>true,
    //         'precision'=>0,
    //     )
    // ));

?>

<table width="100%" id="tblClosing">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'jmltransaksi',array('readOnly'=>true,'class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->hiddenField($model,'closingdari'); ?>
            <?php echo $form->hiddenField($model,'sampaidengan'); ?>
            <?php echo $form->hiddenField($model,'pegawai_id'); ?>
            <?php echo $form->hiddenField($model,'create_loginpemakai_id'); ?>
            <?php echo $form->hiddenField($model,'create_ruangan'); ?>
            <?php echo $form->hiddenField($model,'shift_id'); ?>
            
            <div class="control-group">
                <div class='control-label'>Tanggal Tutup Kasir</div>
                <div class="controls">  
                    <?php $model->tglclosingkasir = $format->formatDateTimeForUser($model->tglclosingkasir); ?>
                    <?php
                        $this->widget('MyDateTimePicker',
                            array(
                                'model'=>$model,
                                'attribute'=>'tglclosingkasir',
                                'mode'=>'datetime',
                                'options'=>array(
                                    'dateFormat'=>Params::DATE_FORMAT,
                                ),
                                'htmlOptions'=>array('readonly' => true,
                                'onkeypress'=>"return $(this).focusNextInputField(event)"),
                            )
                        );
                    ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($model,'closingsaldoawal',array('class'=>'span3 integer','onkeyup'=>'hitungTotalSetoran()','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($model,'terimauangpelayanan',array('readOnly'=>true,'class'=>'span3 integer','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($model,'terimauangmuka',array('class'=>'span3 integer','onkeypress'=>"return $(this).focusNextInputField(event)",'onkeyup'=>'hitungPiutang(this)')); ?>            
            <div class="control-group">
                <div class='control-label'>Jumlah Penerimaan Umum</div>
                <div class="controls">
                    <?php
                        echo(CHtml::textField("jum_penerimaan_umum", $informasi['total_penerimaan_umum'], array('readOnly'=>true,'size'=>20, 'class'=>'span3 integer'))); 
                        echo CHtml::htmlButton('List',
                            array(
                                'onclick' => 'listPenerimaanUmum()',
                                'class' => 'btn btn-primary',
                                'rel' => "tooltip",
                                'id' => 'penerimaanUmum',
                                'title' => "Klik Untuk Melihat Penerimaan Umum"
                            )
                        );
                    ?>
                    <?php
                        echo CHtml::checkBox('isPenerimaanUmum',false,
                            array(
                                'rel' => "tooltip",
                                'id' => 'isPenerimaanUmum',
                                'title' => "Check Untuk Tidak Menyimpan Penerimaan Umum"
                            )
                        );
                    ?>                    
                </div>
            </div>
            <div class="control-group">
                <div class='control-label'>
                    Jumlah Pengeluaran Umum
                </div>
                <div class="controls">
                    <?php
                        echo(CHtml::textField("jum_pengeluaran_umum", $informasi['total_pengeluaran_umum'], array('readOnly'=>true,'size'=>20, 'class'=>'span3 integer'))); 
                        echo CHtml::htmlButton('List',
                            array(
                                'onclick' => 'listPengeluaranUmum()',
                                'class' => 'btn btn-primary',
                                'rel' => "tooltip",
                                'id' => 'pengeluaranUmum',
                                'title' => "Klik Untuk Melihat Pengeluaran Umum"
                            )
                        );
                    ?>
                    <?php
                        echo CHtml::checkBox('isPengeluaranUmum',false,
                            array(
                                'rel' => "tooltip",
                                'id' => 'isPengeluaranUmum',
                                'title' => "Check Untuk Tidak Menyimpan Pengeluaran Umum"
                            )
                        );
                    ?>
                </div>
            </div>
            <div class="control-group">
                <div class='control-label'>Jumlah Penerimaan Tunai</div>
                <div class="controls">
                    <?php
                        echo(CHtml::textField("jum_penerimaan_tunai", 0, array('readOnly'=>true, 'size'=>20, 'class'=>'span3 integer'))); 
                    ?>
                </div>
            </div>
            <div class="control-group">
                <div class='control-label'>Total Tutup Kasir </div>
                <div class="controls">
                    <?php
                        echo $form->textField($model,'nilaiclosingtrans',array('readOnly'=>true,'class'=>'span3 integer','onkeypress'=>"return $(this).focusNextInputField(event)"));
                    ?>
                    <div style="margin-top:5px;font-size:11px;color:red;width:200px;padding:5px;border:1px solid;">Total Tutup Kasir = Total Penerimaan Tunai + Total Administrasi</div>
                </div>
            </div>
                <?php
    //                echo $form->textFieldRow($model,'nilaiclosingtrans',array('readOnly'=>true,'class'=>'span3 integer','onkeypress'=>"return $(this).focusNextInputField(event)"));
                ?>
                <?php echo $form->textFieldRow($model,'totalsetoran',array('readonly'=>true,'class'=>'span3 integer','onkeypress'=>"return $(this).focusNextInputField(event)"));?>            
                <div class="controls">
                    <div style="margin-left:125px;margin-top:5px;font-size:11px;color:red;width:200px;padding:5px;border:1px solid;">Total Setoran = Total Tutup Kasir + Saldo Awal</div>
                </div>
        </td>
        <td>
<!--            <div class="control-group ">
                <?php // echo CHtml::label('Langsung Setor ke Bank','setorBank', array('class'=>'control-label inline')) ?> 
                <div class="controls">
                    <?php // echo CHtml::checkBox('setorBank',false,array('onchange'=>"setorBankEnable(this);")) ?>
                    <i class="icon-chevron-down"></i>
                </div>
            </div>-->
            <!--<div id="setor_bank" style="display:none">-->
                <?php // $this->renderPartial('_formSetorBank', array('form'=>$form, 'modSetor'=>$mSetorBank)); ?>
            <!--</div>-->
            <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                'id'=>'setor_bank',
                'content'=>array(
                    'content-setorbank'=>array(
                        'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan form setoran bank')).'<b>Langsung Setor ke Bank</b>',
                        'isi'=>$this->renderPartial('_formSetorBank',array(
                                'form'=>$form, 
                                'modSetor'=>$mSetorBank
                                ),true),
                        'active'=>false,
                        ),   
                    ),
                )); ?>
            <?php echo $form->textFieldRow($model,'piutang',array('class'=>'span3 integer','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textAreaRow($model,'keterangan_closing',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->hiddenField($model,'jmluanglogam', array('value'=>0)); ?>
            <?php echo $form->hiddenField($model,'jmluangkertas', array('value'=>0)); ?>
            
            
        </td>
        <td>
            <?php
                foreach($rPecahanUang as $value)
                {
            ?>
                <div class="control-group">
                    <div class='control-label'><?php echo $value['lookup_name'];?></div>
                    <div class="controls">
                        <?php
                            echo(CHtml::textField("jum_recehan[". $value['lookup_value'] ."]", 0, array('onkeypress'=>"return $(this).focusNextInputField(event)", 'onKeyup'=>'hitungRecehan()', 'is_receh'=>($value['lookup_value'] < 500 ? 1 : 0), 'recehan_val'=>$value['lookup_value'],'size'=>20, 'class'=>'span3  integer'))); 
                            echo(CHtml::hiddenField("val_recehan[". $value['lookup_value'] ."]", $value['lookup_value'], array('size'=>20, 'class'=>'span3 numbersOnly recehan'))); 
                        ?>
                    </div>
                </div>
            <?php
                }
            ?>
            <div class="control-group">
                <div class='control-label'>Total Recehan</div>
                <div class="controls">
                    <?php
                        echo(CHtml::textField("total_recehan", 0, array('readonly'=>true,'onkeypress'=>"return $(this).focusNextInputField(event)",'size'=>20, 'class'=>'span3 numericOnly recehan'))); 
                    ?>
                </div>
            </div>            
        </td>
    </tr>
</table>
<div class="form-actions">
<?php
    if($model->isNewRecord){
        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
        array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); 
        //array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'setVerifikasi();', 'onkeypress'=>'setVerifikasi();')); 
        echo "&nbsp;";
    }else{
        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
        array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)', 'disabled'=>true)); 
        echo "&nbsp;";
    }
    echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), $this->createUrl('ClosingKasir/Index'), array('class'=>'btn btn-danger','onclick'=>'return true;'));
    echo "&nbsp;";
    $content = $this->renderPartial('tips/transaksi',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
</div>
<?php
    $this->endWidget();
?>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',
    array(
    'id' => 'dialogPenerimaanUmum',
    'options' => array(
            'title' => 'List Penerimaan Umum',
            'autoOpen' => false,
            'modal' => true,
            'width' => 700,
            'height' => 400,
            'resizable' => false,
        ),
    )
);
?>
<table id="tblDialogUmum" class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>No</th>
            <th>Tgl. Penerimaan</th>
            <th>No. Kas Bayar</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
<?php
if(count($rPenerimaanUmum) > 0)
{
    $no=1;
    foreach($rPenerimaanUmum as $value)
    {
?>
        <tr>
            <td><?php echo $no;?></td>
            <td><?php echo $value['tglpenerimaan'];?></td>
            <td><?php echo $value['nopenerimaan'];?></td>
            <td><?php echo $value['totalharga'];?></td>
        </tr>
<?php
        $no++;
    }
}else{
    ?>
        <tr><td colspan="5">Data Tidak Ditemukan</td></tr>
    <?php
}
?>
    </tbody>
</table>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',
    array(
    'id' => 'dialogPengeluaranUmum',
    'options' => array(
            'title' => 'List Pengeluaran Umum',
            'autoOpen' => false,
            'modal' => true,
            'width' => 700,
            'height' => 400,
            'resizable' => false,
        ),
    )
);
?>
<table id="tblDialogUmum" class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>No</th>
            <th>Tgl. Penerimaan</th>
            <th>No. Kas Bayar</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
<?php
if(count($rPengeluaranUmum) > 0)
{
    $no=1;
    foreach($rPengeluaranUmum as $value)
    {
?>
        <tr>
            <td><?php echo $no;?></td>
            <td><?php echo $value['tglpengeluaran'];?></td>
            <td><?php echo $value['nopengeluaran'];?></td>
            <td><?php echo $value['totalharga'];?></td>
        </tr>
<?php
        $no++;
    }
}else{
    ?>
        <tr><td colspan="5">Data Tidak Ditemukan</td></tr>
    <?php
}
?>
    </tbody>
</table>
<?php
$this->endWidget();
?>

<?php
$js = <<< JSCRIPT
function listPenerimaanUmum()
{
    $("#dialogPenerimaanUmum").dialog("open");
}
function listPengeluaranUmum()
{
    $("#dialogPengeluaranUmum").dialog("open");
}
JSCRIPT;
Yii::app()->clientScript->registerScript('dialog',$js,CClientScript::POS_HEAD);
?>
<script>
    function setTanggalClosing(){
        var tgl_awal = $('#BKTandabuktibayarT_tgl_awal').val();
        var tgl_akhir = $('#BKTandabuktibayarT_tgl_akhir').val();
        $("#BKClosingkasirT_closingdari").val(tgl_awal);
        $("#BKClosingkasirT_sampaidengan").val(tgl_akhir);
    }
    setTanggalClosing();
</script>