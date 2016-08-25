<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<?php
$this->breadcrumbs=array(
	'Pembayaran Ke Supplier Umum',
);?>
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
<?php $this->renderPartial('_dataFakturBeli',array('modTerimaPersediaan'=>$modTerimaPersediaan)); ?>

<?php echo $form->errorSummary(array($modelBayar,$modBuktiKeluar)); ?>

<fieldset class="box">
    <legend class="rim">Pembayaran Ke Supplier Umum</legend>
    
    <table id="tblBayarOA" class="table table-condensed table-striped">
        <thead>
            <tr>
                <th>Nama Barang</th>
			<!--	<th>Satuan Beli</th>-->
                <th>Jumlah Terima</th>
                <th>Harga Beli</th>
                <th>Harga Satuan</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($modDetailPersediaan as $i => $detail) { ?>
            <tr>
                <td>
                    <?php echo $detail->barang->barang_nama; ?>
                </td>
                <!--<td>
                    <?php //echo ; ?>
                </td>-->
                <td style = "text-align:right;">
                    <?php echo number_format($detail->jmlterima,0,"",".").' '.$detail->satuanbeli; ?>
                </td>
                <td style = "text-align:right;">
                    <?php echo number_format($detail->hargabeli,0,"","."); ?>
                </td>
                <td style = "text-align:right;">
                    <?php echo number_format($detail->hargasatuan,0,"","."); ?>
                </td>
                <td style = "text-align:right;">
                    <?php echo number_format($detail->jmlterima * $detail->hargasatuan,0,"","."); ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</fieldset>

<div class='row-fluid'>
	<div class='span4'>		
        <?php echo $form->hiddenField($modelBayar,'terimapersediaan_id',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
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
            <?php
                
            ?>
        <?php echo $form->textFieldRow($modelBayar,'totaltagihan',array('readonly'=>true,'class'=>'inputFormTabel integer2 span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
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
                                            'htmlOptions'=>array('readonly'=>true, 'class'=>'dtPicker2-5', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                            ),
                    )); ?>

                </div>
            </div>
            <?php $modBuktiKeluar->tglkaskeluar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modBuktiKeluar->tglkaskeluar, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
	</div>
	<div class='span4'>
		<?php echo $form->textFieldRow($modBuktiKeluar,'nokaskeluar',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,'readonly'=>true)); ?>
		<?php echo $form->textFieldRow($modBuktiKeluar,'biayaadministrasi',array('onkeyup'=>'hitungKasKeluar();','class'=>'inputFormTabel integer2 span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'onfocus'=>'$(this).select();')); ?>
		<?php echo $form->textFieldRow($modBuktiKeluar,'jmlkaskeluar',array('readonly'=>true,'class'=>'inputFormTabel integer2 span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
		<?php echo $form->dropDownListRow($modBuktiKeluar,'carabayarkeluar', LookupM::getItems('carabayarkeluar'),array('onchange'=>'formCarabayar(this.value)','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
	</div>
	<div class='span4'>		
		<div id="divCaraBayarTransfer" class="hide">
			<?php echo $form->textFieldRow($modBuktiKeluar,'melalubank',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
			<?php echo $form->textFieldRow($modBuktiKeluar,'denganrekening',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
			<?php echo $form->textFieldRow($modBuktiKeluar,'atasnamarekening',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
		</div>

		<?php echo $form->textFieldRow($modBuktiKeluar,'namapenerima',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
		<?php echo $form->textAreaRow($modBuktiKeluar,'alamatpenerima',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
		<?php echo $form->textFieldRow($modBuktiKeluar,'untukpembayaran',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
	</div>
</div>    
<div class="form-actions">
	<?php 
		$disabled = ((isset($_GET['bayarkesupplier_id'])) ? true : false);
		echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
				array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)', 'disabled'=>$disabled)); 
	?>
	 <?php
		if(isset($_GET['terimapersediaan_id'])){
			echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print();return false",'disabled'=>FALSE  ));
		}else{
			echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','disabled'=>TRUE  ));
		}
	 ?>
</div>

<?php $this->endWidget(); ?>

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
    var terimapersediaan_id = "<?php echo isset($modTerimaPersediaan->terimapersediaan_id)?$modTerimaPersediaan->terimapersediaan_id:null; ?>";
    window.open("<?php echo $this->createUrl('print') ?>&terimapersediaan_id="+terimapersediaan_id+"&caraPrint=PRINT","",'location=_new, width=1024px');
}
</script>