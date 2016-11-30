<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>


<?php
if(isset($_GET['sukses'])){
	Yii::app()->user->setFlash('success', "Transaksi berhasil disimpan !");
}?>
<div class="white-container">
    <?php
    $this->breadcrumbs=array(
            'Bayar Uang Muka Beli',
    );?>

    <?php
    // $this->widget('application.extensions.moneymask.MMask',array(
    //     'element'=>'.currency',
    //     'currency'=>'PHP',
    //     'config'=>array(
    //         'symbol'=>'Rp. ',
    // //        'showSymbol'=>true,
    // //        'symbolStay'=>true,
    //         'defaultZero'=>true,
    //         'allowZero'=>true,
    //         'precision'=>0,
    //     )
    // ));
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
    <?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'pembayaran-uangmukabeli-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#KUSupplierM_supplier_nama',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)',
                                 // 'onsubmit'=>'return cekInput();'
                                 'onsubmit'=>'return requiredCheck(this);'
                                 ),
    ));?>
    <legend class="rim2">Transaksi Bayar <b>Uang Muka Pembelian</b></legend>
    <?php $this->renderPartial($this->path_view.'_ringkasDataSupplier',array('modSupplier'=>$modSupplier));?>
    <?php echo $form->errorSummary(array($modUangMuka,$modBuktiKeluar)); ?>
    <fieldset class="box">
       <legend class="rim">Data Pengeluaran</legend>
        <table width="100%">
            <tr>
                <td>
                    <?php //echo $form->textFieldRow($modBuktiKeluar,'tglkaskeluar',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <div class="control-group ">
                        <?php $modBuktiKeluar->tglkaskeluar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modBuktiKeluar->tglkaskeluar, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
                        <?php echo $form->labelEx($modBuktiKeluar,'tglkaskeluar', array('class'=>'control-label')) ?>
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
                                                'htmlOptions'=>array('class'=>'dtPicker2-5', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                ),
                            )); ?>
                        </div>
                    </div>
                    <?php echo $form->textFieldRow($modBuktiKeluar,'jmlkaskeluar',array('class'=>'span3 integer2','onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textFieldRow($modBuktiKeluar,'biayaadministrasi',array('class'=>'span3 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textAreaRow($modBuktiKeluar,'keterangan_pengeluaran',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </td>
                <td>
                    <?php echo $form->dropDownListRow($modBuktiKeluar,'tahun', CustomFunction::getTahun(null,null),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>4)); ?>
                    <?php $modBuktiKeluar->tglkaskeluar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modBuktiKeluar->tglkaskeluar, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
                    <?php echo $form->textFieldRow($modBuktiKeluar,'nokaskeluar',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                    <?php echo $form->dropDownListRow($modBuktiKeluar,'carabayarkeluar', LookupM::getItems('carabayarkeluar'),array('onchange'=>'formCarabayar(this.value)','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                </td>
                <td>
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
                    if(!isset($_GET['sukses'])){
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                    array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)'))."&nbsp; ";
						echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),$this->createUrl($this->id.'/index'),
									array('class'=>'btn btn-danger','onclick'=>'return refreshForm(this);'))."&nbsp; ";
						echo CHtml::link(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),'javascript:void(0);',
									array('class'=>'btn btn-info','disabled'=>true))."&nbsp; ";
                    }else{
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'return false', 'onkeypress'=>'return false', 'disabled'=>true, 'style'=>'cursor:not-allowed;'))." &nbsp; ";
						echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),$this->createUrl($this->id.'/index'),
									array('class'=>'btn btn-danger','onclick'=>'return refreshForm(this);'))."&nbsp; ";
						echo CHtml::link(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),'javascript:void(0);',
										array('class'=>'btn btn-info','onClick'=>'print("PRINT")'))." &nbsp; ";
            
                    }
                ?>
            
										  						  			<?php  
    $content = $this->renderPartial($this->path_view.'tips/transaksi',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
<?php
$urlPrint = $this->createUrl('Print&tandabuktikeluar_id='.$modBuktiKeluar->tandabuktikeluar_id);
$js = <<< JSCRIPT
function print(caraPrint){
	window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=890px');
}
JSCRIPT;
	Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);
?>
<script type="text/javascript">
$('.currency').each(function(){this.value = formatNumber(this.value)});

function formCarabayar(carabayar)
{
    if(carabayar == 'TRANSFER'){
        $('#divCaraBayarTransfer').slideDown();
    } else {
        $('#divCaraBayarTransfer').slideUp();
        $('#divCaraBayarTransfer input').each(function(){this.value = ''});
    }
}

function cekInput(){
    $('.currency').each(function(){this.value = unformatNumber(this.value)})
    if($('#KUTandabuktikeluarT_jmlkaskeluar').val()==0)
        return false;
    
    return true;
}
</script>