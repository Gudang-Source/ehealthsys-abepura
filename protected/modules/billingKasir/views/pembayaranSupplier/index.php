<?php
$this->breadcrumbs=array(
	'Pembayaran Supplier',
);?>
<h2><?php //echo $this->id . '/' . $this->action->id; ?></h2>
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
<?php $this->renderPartial('_dataFakturBeli',array('modFakturBeli'=>$modFakturBeli)); ?>

<?php echo $form->errorSummary(array($modelBayar,$modBuktiKeluar,$modUangMuka)); ?>

<fieldset>
    <legend>Pembayaran Obat Alkes</legend>
    <table id="tblBayarOA" class="table table-condensed table-bordered">
        <thead>
            <tr>
                <th>Nama Obat Alkes</th>
                <th>Jml Terima</th>
                <th>Harga Netto</th>
                <th>Harga PPN</th>
                <th>Harga PPH</th>
                <th>% Discount</th>
                <th>Jml Discount</th>
                <th>Harga Satuan</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $totalppn = 0;
            $totalpph = 0;
            $hargappn = 0;
            $hargappnfaktur = 0;
            $hargapph = 0;
            $hargapphfaktur = 0;
			if(count($modDetailBeli)>0){
            foreach ($modDetailBeli as $i => $detail) { 
                if($detail->persenppnfaktur <= 0){
                    $hargappnfaktur = 0;
                }else{
                    $hargappn = $detail->harganettofaktur * ($detail->persenppnfaktur / 100);
                    $hargappnfaktur = $detail->harganettofaktur + hargappn;
                }
                if($detail->persenpphfaktur <= 0){
                    $hargapphfaktur = 0;
                }else{
                    $hargapph = $detail->harganettofaktur * ($detail->persenpphfaktur / 100);
                    $hargapphfaktur = $detail->harganettofaktur + hargapph;
                }
                
            ?>
            <tr>
                <td>
                    <?php echo $detail->obatalkes->obatalkes_nama; ?>
                </td>
                <td>
                    <?php echo number_format($detail->jmlterima); ?>
                </td>
                <td>
                    <?php echo number_format($detail->harganettofaktur); ?>
                </td>
                <td>
                    <?php echo number_format($hargappnfaktur); ?>
                </td>
                <td>
                    <?php echo number_format($hargapphfaktur); ?>
                </td>
                <td>
                    <?php echo number_format($detail->persendiscount); ?>
                </td>
                <td>
                    <?php echo number_format($detail->jmldiscount); ?>
                </td>
                <td>
                    <?php echo number_format($detail->hargasatuan); ?>
                </td>
                <td>
                    <?php echo number_format($detail->jmlterima * $detail->harganettofaktur); ?>
                </td>
            </tr>
            <?php }
			}?>
        </tbody>
    </table>
</fieldset>

<table>
    <tr>
        <td width="50%">
		<?php echo $modBuktiKeluar->bayarkesupplier_id;?>
        <?php //echo $form->textFieldRow($modelBayar,'uangmukabeli_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($modelBayar,'fakturpembelian_id',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <?php //echo $form->textFieldRow($modelBayar,'tandabuktikeluar_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <?php //echo $form->textFieldRow($modelBayar,'batalbayarsupplier_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <?php //echo $form->textFieldRow($modelBayar,'tglbayarkesupplier',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <div class="control-group ">
            <?php $modelBayar->tglbayarkesupplier = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modelBayar->tglbayarkesupplier, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
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
                                        'htmlOptions'=>array('readonly'=>true, 'class'=>'dtPicker2-5', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                        ),
                )); ?>

            </div>
        </div>
        <?php echo $form->textFieldRow($modelBayar,'totaltagihan',array('readonly'=>true,'class'=>'inputFormTabel currency span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <?php //echo $form->textFieldRow($modUangMuka,'jumlahuang',array('readonly'=>true,'class'=>'inputFormTabel currency span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <div class="control-group ">
                <label class='control-label required'>Uang Muka <span class="required">*</span></label>
                <div class="controls">
                    <?php echo $form->textField($modUangMuka,'jumlahuang',array('readonly'=>true,'class'=>'inputFormTabel currency span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>

                </div>
            </div>
        <?php echo $form->textFieldRow($modelBayar,'jmldibayarkan',array('class'=>'inputFormTabel currency span3', 'onblur'=>'hitungKasKeluar();', 'onkeyup'=>'hitungKasKeluar()', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'onfocus'=>'$(this).select();')); ?>
        
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
                                            'htmlOptions'=>array('readonly'=>true, 'class'=>'dtPicker2-5', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                            ),
                    )); ?>

                </div>
            </div>
            <?php //echo $form->dropDownListRow($modBuktiKeluar,'tahun', CustomFunction::getTahun(null,null),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>4)); ?>
            <?php $modBuktiKeluar->tglkaskeluar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modBuktiKeluar->tglkaskeluar, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
            <?php echo $form->textFieldRow($modBuktiKeluar,'nokaskeluar',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($modBuktiKeluar,'biayaadministrasi',array('onkeyup'=>'hitungKasKeluar();','class'=>'inputFormTabel currency span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'onfocus'=>'$(this).select();')); ?>
            <?php echo $form->textFieldRow($modBuktiKeluar,'jmlkaskeluar',array('readonly'=>true,'class'=>'inputFormTabel currency span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            
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
        <div class="form-actions">
                <?php 
                    $disabled = ((isset($modFakturBeli->bayarkesupplier_id)) ? true : null);
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                        array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)', 'disabled'=>$disabled)); 
                    //echo "&nbsp;&nbsp;";
                    //echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), '#', array('class'=>'btn btn-info','onclick'=>"printKasir($modTandaBukti->tandabuktibayar_id);return false",'disabled'=>false)); 
                ?>
				 <?php
					if(isset($_GET['fakturpembelian_id'])){
						echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print();return false",'disabled'=>FALSE  ));
					}else{
						echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','disabled'=>TRUE  ));
					}
				 ?>
        </div>

<?php $this->endWidget(); ?>


<script type="text/javascript">
$('.currency').each(function(){this.value = formatInteger(this.value)});
function cekInputan()
{
    $('.currency').each(function(){this.value = unformatNumber(this.value)});
    return true;
}

function hitungKasKeluar()
{
    var jmlBayar = parseFloat(unformatNumber($('#BKBayarkeSupplierT_jmldibayarkan').val()));
    var biayaAdmin = parseFloat(unformatNumber($('#BKTandabuktikeluarT_biayaadministrasi').val()));
    var kasKeluar = jmlBayar + biayaAdmin;
    
    $('#BKTandabuktikeluarT_jmlkaskeluar').val(formatInteger(kasKeluar));
}

function formCarabayar(carabayar)
{
    if(carabayar == 'TRANSFER'){
        $('#divCaraBayarTransfer').slideDown();
    } else {
        $('#divCaraBayarTransfer').slideUp();
    }
}

function print()
{
    var fakturpembelian_id = "<?php echo isset($modFakturBeli->fakturpembelian_id)?$modFakturBeli->fakturpembelian_id:null; ?>";
    window.open("<?php echo $this->createUrl('print') ?>&fakturpembelian_id="+fakturpembelian_id+"&caraPrint=PRINT","",'location=_new, width=1024px');
}
</script>