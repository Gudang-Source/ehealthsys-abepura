<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>


<div class="white-container">
    <legend class="rim2">Pembayaran Supplier</legend>
    <?php if (isset($_GET['id'])) {
        Yii::app()->user->setFlash("success", "Pembayaran berhasil disimpan.");
    }
    ?>
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
    'id'=>'bayarkesupplier-t-form',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)',
                             'onsubmit'=>'return cekInputan();'),
)); ?>
<?php $this->renderPartial($this->path_view.'_dataFakturBeli',array('modFakturBeli'=>$modFakturBeli)); ?>

<?php echo $form->errorSummary(array($modelBayar,$modBuktiKeluar,$modUangMuka)); ?>

    <div class="block-tabel">
        <h6>Pembayaran Obat Alkes</h6>
        <table id="tblBayarOA" class="table table-condensed table-bordered">
            <thead>
                <tr>
                    <th>Nama Obat Alkes</th>
                    <th>Jml Terima</th>
                    <th>Harga Netto</th>
                    <th>Harga Satuan</th>
                    <th>Harga PPN</th>
                    <th>Harga PPH</th>
                    <th>% Discount</th>
                    <th>Jml Discount</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $this->renderPartial($this->path_view.'_rowFaktur', array('modDetailBeli'=>$modDetailBeli), true); ?>
            </tbody>
        </table>
    </div>
    <fieldset class="box">
        <legend class="rim">Pembayaran</legend>
    
        <table width="100%">
            <tr>
                <td width="50%">
                        <?php // echo $modBuktiKeluar->bayarkesupplier_id;?>
                <?php //echo $form->textFieldRow($modelBayar,'uangmukabeli_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->hiddenField($modelBayar,'fakturpembelian_id',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textFieldRow($modelBayar,'tandabuktikeluar_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textFieldRow($modelBayar,'batalbayarsupplier_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textFieldRow($modelBayar,'tglbayarkesupplier',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <div class="control-group ">
                    <?php $modelBayar->tglbayarkesupplier = MyFormatter::formatDateTimeForUser($modelBayar->tglbayarkesupplier); ?>
                    <?php echo $form->labelEx($modelBayar,'tglbayarkesupplier', array('class'=>'control-label inline')) ?>
                    <div class="controls">
                        <?php   
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$modelBayar,
                                                'attribute'=>'tglbayarkesupplier',
                                                'mode'=>'datetime',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                    'maxDate' => 'd',
                                                ),
                                                'htmlOptions'=>array('readonly'=>true, 'class'=>'dtPicker2-5 realtime', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                ),
                        )); ?>

                    </div>
                </div>
                <?php echo $form->textFieldRow($modelBayar,'totaltagihan',array('readonly'=>true,'class'=>'inputFormTabel integer2 span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textFieldRow($modUangMuka,'jumlahuang',array('readonly'=>true,'class'=>'inputFormTabel integer2 span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <div class="control-group ">
                        <label class='control-label required'>Uang Muka <span class="required">*</span></label>
                        <div class="controls">
                            <?php echo $form->textField($modUangMuka,'jumlahuang',array('readonly'=>true,'class'=>'inputFormTabel integer2 span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>

                        </div>
                    </div>
                <?php echo $form->textFieldRow($modelBayar,'jmldibayarkan',array('class'=>'inputFormTabel integer2 span3', 'onblur'=>'hitungKasKeluar();', 'onkeyup'=>'hitungKasKeluar()', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'onfocus'=>'$(this).select();')); ?>

                    <div class="control-group ">
                        <?php $modBuktiKeluar->tglkaskeluar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modBuktiKeluar->tglkaskeluar, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
                        <?php echo $form->labelEx($modBuktiKeluar,'tglkaskeluar', array('class'=>'control-label inline')) ?>
                        <div class="controls">
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$modBuktiKeluar,
                                                    'attribute'=>'tglkaskeluar',
                                                    'mode'=>'datetime',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'maxDate' => 'd',
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true, 'class'=>'dtPicker2-5 realtime', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                    ),
                            )); ?>

                        </div>
                    </div>
                    <?php //echo $form->dropDownListRow($modBuktiKeluar,'tahun', CustomFunction::getTahun(null,null),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>4)); ?>
                    <?php $modBuktiKeluar->tglkaskeluar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modBuktiKeluar->tglkaskeluar, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
                    <?php echo $form->textFieldRow($modBuktiKeluar,'nokaskeluar',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                    <?php echo $form->textFieldRow($modBuktiKeluar,'biayaadministrasi',array('onkeyup'=>'hitungKasKeluar();','class'=>'inputFormTabel integer2 span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'onfocus'=>'$(this).select();')); ?>
                    <?php echo $form->textFieldRow($modBuktiKeluar,'jmlkaskeluar',array('readonly'=>true,'class'=>'inputFormTabel integer2 span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>

                </td>
                <td width="50%">
                    <?php echo $form->dropDownListRow($modBuktiKeluar,'carabayarkeluar', LookupM::getItems('carabayarkeluar'),array('onchange'=>'formCarabayar(this.value)','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                    <div id="divCaraBayarTransfer" class="hide">
                        <?php echo $form->textFieldRow($modBuktiKeluar,'melalubank',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                        <?php echo $form->textFieldRow($modBuktiKeluar,'denganrekening',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                        <?php echo $form->textFieldRow($modBuktiKeluar,'atasnamarekening',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                    </div>

                    <?php echo $form->textFieldRow($modBuktiKeluar,'namapenerima',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                    <?php echo $form->textAreaRow($modBuktiKeluar,'alamatpenerima',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textFieldRow($modBuktiKeluar,'untukpembayaran',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                </td>
            </tr>
        </table>  
    </fieldset>
            <div class="form-actions">
                    <?php 
                        $disabled = ((isset($modFakturBeli->bayarkesupplier_id)) ? true : null);
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                            array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)', 'disabled'=>$disabled)); 
                        //echo "&nbsp;&nbsp;";
                        //echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), '#', array('class'=>'btn btn-info','onclick'=>"printKasir($modTandaBukti->tandabuktibayar_id);return false",'disabled'=>false)); 
                    ?>
                    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        $this->createUrl($this->id.'/index'), 
                                array('class'=>'btn btn-danger',
//                                      'onclick'=>'if(!confirm("Apakah anda ingin mengulang ini ?")) return false;'));
                                      'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "'.$this->createUrl($this->id.'/index').'";}); return false;')); ?>
                                     <?php
                                            if(isset($_GET['id'])){
                                                    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print();return false",'disabled'=>FALSE  ));
                                            }else{
                                                    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','disabled'=>TRUE  ));
                                            }
                                     ?>
            </div>

    <?php $this->endWidget(); ?>
</div>

<script type="text/javascript">
    $(document).ready(function()
    {
        $('.integer2').each(function(){this.value = formatNumber(this.value)});
    });
function cekInputan()
{
    $('.integer2').each(function(){this.value = unformatNumber(this.value)});
    return true;
}

function hitungKasKeluar()
{
    var jmlBayar = parseFloat(unformatNumber($('#BKBayarkeSupplierT_jmldibayarkan').val()));
    var biayaAdmin = parseFloat(unformatNumber($('#BKTandabuktikeluarT_biayaadministrasi').val()));
    var kasKeluar = jmlBayar + biayaAdmin;
    
    $('#BKTandabuktikeluarT_jmlkaskeluar').val(formatNumber(kasKeluar));
}

function formCarabayar(carabayar)
{
    if(carabayar == 'TRANSFER'){
        $('#divCaraBayarTransfer').slideDown();
    } else {
        $('#divCaraBayarTransfer').slideUp();
    }
}

function loadFakturPembelian(id) {
    console.log(id);
    $.post('<?php echo $this->createUrl('loadFakturFarmasi'); ?>', {
        id: id
    }, function(data) {
        $("#tblBayarOA tbody").html(data.tabFaktur);
        $("#FAPendaftaranT_tglfaktur").val(data.fakturBeli.tglfaktur);
        $("#FAPendaftaranT_tgljatuhtempo").val(data.fakturBeli.tgljatuhtempo);
        $("#FAPendaftaranT_totalhargabruto").val(data.fakturBeli.totalhargabruto);
        $("#FAPendaftaranT_supplier_id").val((data.supplier == '')?data.supplier:data.supplier.supplier_nama);
        $("#FAPasienM_keteranganfaktur").val(data.fakturBeli.keteranganfaktur);
        
        $("#nopermintaan").val(data.nopermintaan);
        $("#nopenerimaan").val(data.penerimaan.noterima);
        
        $("#BKFakturPembelianT_nofaktur").val(data.fakturBeli.nofaktur);
        $("#BKBayarkeSupplierT_fakturpembelian_id").val(data.fakturBeli.fakturpembelian_id);
        $("#BKBayarkeSupplierT_totaltagihan").val(data.modelBayar.totaltagihan);
        $("#BKUangMukaBeliT_jumlahuang").val(data.uangMuka);
        $("#BKBayarkeSupplierT_jmldibayarkan").val(data.modelBayar.jmldibayarkan);
        $("#BKTandabuktikeluarT_nokaskeluar").val(data.buktiKeluar.nokaskeluar);
        $("#BKTandabuktikeluarT_biayaadministrasi").val(data.buktiKeluar.biayaadministrasi);
        $("#BKTandabuktikeluarT_jmlkaskeluar").val(data.buktiKeluar.jmlkaskeluar);
        $("#BKTandabuktikeluarT_namapenerima").val(data.buktiKeluar.namapenerima);
        $("#BKTandabuktikeluarT_alamatpenerima").val(data.buktiKeluar.alamatpenerima);
        $("#BKTandabuktikeluarT_untukpembayaran").val(data.buktiKeluar.untukpembayaran);
        
        
        
        console.log("Kicker");
    }, 'json');
}

function print()
{
    var fakturpembelian_id = "<?php echo isset($modFakturBeli->bayarkesupplier_id)?$modFakturBeli->bayarkesupplier_id:null; ?>";
    window.open("<?php echo $this->createUrl('print') ?>&id="+fakturpembelian_id+"&caraPrint=PRINT","",'location=_new, width=1024px');
}
</script>