<?php
$this->breadcrumbs=array(
	'Bayar Angsuran',
);?>
<?php
$this->widget('application.extensions.moneymask.MMask',array(
    'element'=>'.currency',
    'currency'=>'PHP',
    'config'=>array(
        'symbol'=>'Rp. ',
//        'showSymbol'=>true,
//        'symbolStay'=>true,
        'defaultZero'=>true,
        'allowZero'=>true,
        'decimal'=>'.',
        'thousands'=>',',
        'precision'=>0,
    )
));
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'bayarangsuranpelayanan-t-form',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#BKBayarAngsuranPelayananT_jmlbayarangsuran',
        'htmlOptions'=>array(
            'onKeyPress'=>'return disableKeyPress(event)',
            'onSubmit'=>'return cekAngsuran();'
        ),
)); ?>

<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

    <?php echo $form->errorSummary($modAngsuran); ?>

            <?php echo $form->hiddenField($modAngsuran,'tandabuktibayar_id',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->hiddenField($modAngsuran,'pembayaranpelayanan_id',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($modAngsuran,'tglbayarangsuran',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <div class="control-group ">
                <?php $modAngsuran->tglbayarangsuran = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modAngsuran->tglbayarangsuran, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
                <?php echo $form->labelEx($modAngsuran,'tglbayarangsuran', array('class'=>'control-label inline')) ?>
                <div class="controls">
                    <?php   
                            $this->widget('MyDateTimePicker',array(
                                            'model'=>$modAngsuran,
                                            'attribute'=>'tglbayarangsuran',
                                            'mode'=>'datetime',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions'=>array('class'=>'dtPicker2-5', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                            ),
                    )); ?>

                </div>
            </div>
            <?php echo $form->textFieldRow($modAngsuran,'bayarke',array('readonly'=>true,'class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($modAngsuran,'jmlbayarangsuran',array('class'=>'inputFormTabel span3 currency', 'onkeyup'=>'hitungSisaAngsuran();', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($modAngsuran,'sisaangsuran',array('readonly'=>true,'class'=>'inputFormTabel span3 currency', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::hiddenField('sisaangsuran', $modAngsuran->sisaangsuran,array('readonly'=>true)); ?>
    
<fieldset>
    <legend>Data Pembayaran</legend>
    <table>
        <tr>
            <td>
                <div class="control-group ">
                    <?php echo CHtml::label('Total Biaya Pelayanan','totTagihan', array('class'=>'control-label inline')) ?>
                    <div class="controls">
                        <?php echo CHtml::textField('totTagihan',$modPembayaran->totalbiayapelayanan,array('readonly'=>true,'class'=>'inputFormTabel currency span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Deposit','deposit', array('class'=>'control-label inline')) ?>
                    <div class="controls">
                        <?php echo CHtml::textField('deposit',isset($totDeposit)?$totDeposit:null,array('readonly'=>true,'class'=>'inputFormTabel currency span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Total Pembebasan','totPembebasan', array('class'=>'control-label inline')) ?>
                    <div class="controls">
                        <?php echo CHtml::textField('totPembebasan',isset($totPembebasanTarif)?$totPembebasanTarif:null,array('readonly'=>true,'class'=>'inputFormTabel currency span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($modTandaBukti,'jmlpembulatan',array('readonly'=>true,'class'=>'inputFormTabel currency span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modTandaBukti,'biayaadministrasi',array('onkeyup'=>'hitungJmlBayar();','class'=>'inputFormTabel currency span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modTandaBukti,'biayamaterai',array('onkeyup'=>'hitungJmlBayar();','class'=>'inputFormTabel currency span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modTandaBukti,'jmlpembayaran',array('onkeyup'=>'hitungKembalian();','readonly'=>true,'class'=>'inputFormTabel currency span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modTandaBukti,'uangditerima',array('onkeyup'=>'hitungKembalian();','class'=>'inputFormTabel currency span3', 'onblur'=>'cekKembalian();', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modTandaBukti,'uangkembalian',array('readonly'=>true,'class'=>'inputFormTabel currency span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            </td>
            <td>
                <div class="control-group ">
                    <?php $modTandaBukti->tglbuktibayar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modTandaBukti->tglbuktibayar, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
                    <?php echo $form->labelEx($modTandaBukti,'tglbuktibayar', array('class'=>'control-label inline')) ?>
                    <div class="controls">
                        <?php   
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$modTandaBukti,
                                                'attribute'=>'tglbuktibayar',
                                                'mode'=>'datetime',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                    'maxDate' => 'd',
                                                ),
                                                'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                ),
                        )); ?>

                    </div>
                </div>
                <?php //echo $form->textFieldRow($modTandaBukti,'tglbuktibayar',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>

                <?php echo $form->dropDownListRow($modTandaBukti,'carapembayaran',  LookupM::getItems('carapembayaran'),array('readonly'=>true,'onchange'=>'ubahCaraPembayaran(this)','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                <div class="control-group ">
                    <?php echo CHtml::label('Menggunakan Kartu','pakeKartu', array('class'=>'control-label inline')) ?>
                    <div class="controls">
                        <?php echo CHtml::checkBox('pakeKartu',false,array('onchange'=>"enableInputKartu();", 'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
                    </div>
                </div>
                <div id="divDenganKartu" class="hide">
                    <?php echo $form->dropDownListRow($modTandaBukti,'dengankartu',  LookupM::getItems('dengankartu'),array('onchange'=>'enableInputKartu()','empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                    <?php echo $form->textFieldRow($modTandaBukti,'bankkartu',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                    <?php echo $form->textFieldRow($modTandaBukti,'nokartu',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                    <?php echo $form->textFieldRow($modTandaBukti,'nostrukkartu',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                </div>

                <?php echo $form->textFieldRow($modTandaBukti,'darinama_bkm',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                <?php echo $form->textAreaRow($modTandaBukti,'alamat_bkm',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modTandaBukti,'sebagaipembayaran_bkm',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
            </td>
        </tr>
    </table>
</fieldset>
    
    <div class="form-actions">
            <?php 
                echo CHtml::htmlButton(
                    $modAngsuran->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                    array(
                        'class'=>'btn btn-primary', 
                        'type'=>'submit', 
                        'onKeypress'=>'return formSubmit(this,event)'
                    )
                ); 
            ?>
            <?php  
            $content = $this->renderPartial('tips/transaksi',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
    </div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    
$('.currency').each(
    function()
    {
        this.value = formatInteger(this.value)
    }
);

function simpanProses()
{
    $("#bayarangsuranpelayanan-t-form").submit();
}

function formSubmit(obj,evt)
{
     evt = (evt) ? evt : event;
     var form_id = $(obj).closest('form').attr('id');
     var charCode = (evt.charCode) ? evt.charCode : ((evt.which) ? evt.which : evt.keyCode);
     
     if(charCode == 13)
     {
         if(cekAngsuran())
         {
            simpanProses();
         }
     }
     return false;
}

function cekAngsuran()
{
    $('.currency').each(
        function(){
            this.value = unformatNumber(this.value)
        }
    );
        
    if($('#BKBayarAngsuranPelayananT_jmlbayarangsuran').val() == 0)
    {
        myAlert('Jumlah angsuran tidak boleh kosong !!');
        $('#BKBayarAngsuranPelayananT_jmlbayarangsuran').focus();
        return false;
    }
    return true;
}

function hitungSisaAngsuran()
{
    var sisa = unformatNumber($('#sisaangsuran').val());
    var angsuran = unformatNumber($('#BKBayarAngsuranPelayananT_jmlbayarangsuran').val());
    var sisaAngsuran = sisa - angsuran;
    sisaAngsuran = (sisaAngsuran < 0) ? 0 : sisaAngsuran;
    
    if ((sisa - angsuran) < 0){
        myAlert("Jumlah bayar angsuran tidak boleh lebih dari sisa angsuran");
        $("#BKBayarAngsuranPelayananT_jmlbayarangsuran").val(formatInteger(sisa));
    }
    $('#BKBayarAngsuranPelayananT_sisaangsuran').val(formatInteger(sisaAngsuran));
    $('#BKTandabuktibayarT_jmlpembayaran').val(formatInteger(angsuran));
    hitungKembalian();
}

function hitungKembalian()
{
    var jmlBayar = unformatNumber($('#BKTandabuktibayarT_jmlpembayaran').val());
    var uangDiterima = unformatNumber($('#BKTandabuktibayarT_uangditerima').val());
    var uangKembalian;
    uangKembalian = uangDiterima - jmlBayar;
    uangKembalian = (uangKembalian < 0) ? 0 : uangKembalian;
    
    $('#BKTandabuktibayarT_uangditerima').val(formatInteger(uangDiterima));
    $('#BKTandabuktibayarT_uangkembalian').val(formatInteger(uangKembalian));
}

function hitungJmlBayar()
{
    var biayaAdministrasi = unformatNumber($('#BKTandabuktibayarT_biayaadministrasi').val());
    var biayaMaterai = unformatNumber($('#BKTandabuktibayarT_biayamaterai').val());
    var deposit = unformatNumber($('#deposit').val());
    var totPembebasan = unformatNumber($('#totPembebasan').val());
    var totDiscountTind = unformatNumber($('#totaldiscount_tindakan').val());
    var totBayar = 0;
    var totTagihan = unformatNumber($('#BKBayarAngsuranPelayananT_jmlbayarangsuran').val());
    var jmlPembulatan = unformatNumber($('#BKTandabuktibayarT_jmlpembulatan').val());
    
    totBayar = totTagihan + jmlPembulatan + biayaAdministrasi + biayaMaterai - totDiscountTind - totPembebasan - deposit;
    
    $('#BKTandabuktibayarT_jmlpembayaran').val(formatInteger(totBayar));
    hitungKembalian();
}

function enableInputKartu()
{
    if($('#pakeKartu').is(':checked'))
        $('#divDenganKartu').show();
    else {
        $('#divDenganKartu').hide();
        $('#BKTandabuktibayarT_dengankartu').val('');
        $('#BKTandabuktibayarT_bankkartu').val('');
        $('#BKTandabuktibayarT_nokartu').val('');
        $('#BKTandabuktibayarT_nostrukkartu').val('');
    }
    if($('#BKTandabuktibayarT_dengankartu').val() != ''){
        //myAlert('isi');
        $('#BKTandabuktibayarT_bankkartu').removeAttr('readonly');
        $('#BKTandabuktibayarT_nokartu').removeAttr('readonly');
        $('#BKTandabuktibayarT_nostrukkartu').removeAttr('readonly');
    } else {
        //myAlert('kosong');
        $('#BKTandabuktibayarT_bankkartu').attr('readonly','readonly');
        $('#BKTandabuktibayarT_nokartu').attr('readonly','readonly');
        $('#BKTandabuktibayarT_nostrukkartu').attr('readonly','readonly');
        
        $('#BKTandabuktibayarT_bankkartu').val('');
        $('#BKTandabuktibayarT_nokartu').val('');
        $('#BKTandabuktibayarT_nostrukkartu').val('');
    }
}

function ubahCaraPembayaran(obj)
{
    if(obj.value == 'CICILAN'){
        $('#BKTandabuktibayarT_jmlpembayaran').removeAttr('readonly');
    } else {
        $('#BKTandabuktibayarT_jmlpembayaran').attr('readonly', true);
        hitungJmlBayar();
    }
    
    if(obj.value == 'TUNAI'){
        hitungJmlBayar();
    } 
}

function cekKembalian(){
    
}
</script>