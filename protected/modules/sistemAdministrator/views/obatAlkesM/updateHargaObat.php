<?php
$this->widget('application.extensions.moneymask.MMask',array(
    'element'=>'.currency',
    'currency'=>'PHP',
    'config'=>array(
        'defaultZero'=>true,
        'allowZero'=>true,
        'decimal'=>'.',
        'thousands'=>',',
        'precision'=>0,
        'symbol'=>'',
    )
));

$this->widget('application.extensions.moneymask.MMask',array(
    'element'=>'.number',
    'config'=>array(
        'defaultZero'=>true,
        'allowZero'=>true,
        'precision'=>2,
    )
));

?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'gfobat-alkes-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onSubmit'=>'return cekInput();'),
        'focus'=>'#',
)); 
$this->widget('bootstrap.widgets.BootAlert'); ?>
	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
        
        <table width="100%">
            <tr>
                <td>

                     <?php echo $form->textFieldRow($model,'obatalkes_nama',array('class'=>'span4', 'readonly'=>true)); ?>
                     <?php //echo $form->textFieldRow($model,'satuankecilNama',array('class'=>'span2', 'readonly'=>true)); ?>
                     <?php //echo $form->textFieldRow($model,'obatAlkes',array('class'=>'span3', 'readonly'=>true));  ?>
                     <?php echo $form->textFieldRow($model,'obatalkes_kategori',array('class'=>'span2', 'readonly'=>true)); ?>
                    
                    <?php $a = $_GET['status']; if( $a == "hargajual"){ ?>
                    <?php echo $form->textFieldRow($model,'hpp',array('class'=>'span1 integer', 'readonly'=>true )); ?>
                    <fieldset id="fieldsetHargaJualApotek">
                            <legend class="rim">Harga Jual Apotek</legend>
                            <div class="row-fluid">
                                <div class="span6">

                                    <div class="control-group" style="margin-left:-30px;">
                                        <?php echo $form->labelEx($model,'margin',array('class'=>'control-label'));?>
                                        <div class="controls">
                                           <?php echo $form->textField($model,'margin',array('class'=>'span1 float',
                                                            'onkeypress'=>"return $(this).focusNextInputField(event);",'onkeyup'=>'hitung_hargajual()')); ?> %
                                        </div>
                                    </div> 
                                    <div class="control-group" style="margin-left:-30px;">
                                        <?php echo $form->labelEx($model,'hargajual',array('class'=>'control-label'));?>
                                        <div class="controls">
                                           <?php echo $form->textField($model,'hargajual',array('class'=>'span2 integer',
                                                            'onkeypress'=>"return $(this).focusNextInputField(event);",'onkeyup'=>'hitung_margin()')); ?> <font size="1px">Rupiah</font>
                                        </div>
                                    </div> 
                                    <div class="control-group" style="margin-left:-30px;">
                                        <?php echo $form->labelEx($model,'marginnonresep',array('class'=>'control-label'));?>
                                        <div class="controls">
                                           <?php echo $form->textField($model,'marginnonresep',array('class'=>'span1 float',
                                                            'onkeypress'=>"return $(this).focusNextInputField(event);",'onkeyup'=>'hitung_hjanonresep()')); ?> %
                                        </div>
                                    </div> 
                                    <div class="control-group" style="margin-left:-30px;">
                                        <?php echo $form->labelEx($model,'hjanonresep',array('class'=>'control-label'));?>
                                        <div class="controls">
                                           <?php echo $form->textField($model,'hjanonresep',array('class'=>'span2 integer',
                                                            'onkeypress'=>"return $(this).focusNextInputField(event);",'onkeyup'=>'hitung_margin_hjanonresep()')); ?> <font size="1px">Rupiah</font>
                                        </div>
                                    </div> 
                                    <div class="control-group" style="margin-left:-30px;">
                                        <?php echo $form->labelEx($model,'marginresep',array('class'=>'control-label'));?>
                                        <div class="controls">
                                           <?php echo $form->textField($model,'marginresep',array('class'=>'span1 float',
                                                            'onkeypress'=>"return $(this).focusNextInputField(event);",'onkeyup'=>'hitung_hjaresep()')); ?> %
                                        </div>
                                    </div> 
                                    <div class="control-group" style="margin-left:-30px;">
                                        <?php echo $form->labelEx($model,'jasadokter',array('class'=>'control-label'));?>
                                        <div class="controls">
                                           <?php echo $form->textField($model,'jasadokter',array('class'=>'span2 integer',
                                                            'onkeypress'=>"return $(this).focusNextInputField(event);",'onkeyup'=>'hitung_hjaresep()')); ?> <font size="1px">Rupiah</font>
                                        </div>
                                    </div> 
                                    <div class="control-group" style="margin-left:-30px;">
                                        <?php echo $form->labelEx($model,'hjaresep',array('class'=>'control-label'));?>
                                        <div class="controls">
                                           <?php echo $form->textField($model,'hjaresep',array('class'=>'span2 integer',
                                                            'onkeypress'=>"return $(this).focusNextInputField(event);",'onkeyup'=>'hitung_margin_hjaresep()')); ?> <font size="1px">Rupiah</font>
                                        </div>
                                    </div> 
                                </div>
                                <div class="span6">
                                    <div class="control-group" style="margin-left:-30px;">
                                        <?php echo $form->labelEx($model,'hargamaksimum',array('class'=>'control-label'));?>
                                        <div class="controls">
                                           <?php echo $form->textField($model,'hargamaksimum',array('class'=>'span2 integer',
                                                            'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true)); ?> <font size="1px">Rupiah</font>
                                        </div>
                                    </div> 
                                    <div class="control-group" style="margin-left:-30px;">
                                        <?php echo $form->labelEx($model,'hargaminimum',array('class'=>'control-label'));?>
                                        <div class="controls">
                                           <?php echo $form->textField($model,'hargaminimum',array('class'=>'span2 integer',
                                                            'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true)); ?> <font size="1px">Rupiah</font>
                                        </div>
                                    </div> 
                                    <div class="control-group" style="margin-left:-30px;">
                                        <?php echo $form->labelEx($model,'hargaaverage',array('class'=>'control-label'));?>
                                        <div class="controls">
                                           <?php echo $form->textField($model,'hargaaverage',array('class'=>'span2 integer',
                                                            'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true)); ?> <font size="1px">Rupiah</font>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                    </fieldset>
                    <?php } ?>
                    
                    <?php if($a == "harganetto"){ ?>
                        <fieldset id="fieldsetHargaNetto">
                            <legend class="rim">HPP</legend>
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <?php echo CHtml::label('Harga Beli','hargabeli', array('class'=>'control-label')); ?>
                                        <div class="controls">
                                            <?php echo CHtml::textField('hargabeli','', array('class'=>'control-label integer','onkeyup'=>'hitung_harganetto()')); ?>
                                        </div>
                                    </div>
                                    
                                    <div class="control-group">
                                        <?php echo $form->labelEx($model,'satuanbesar_id',array('class'=>'control-label'));?>
                                        <div class="controls">
                                            <?php echo $form->dropDownList($model,'satuanbesar_id',
                                                    CHtml::listData($model->SatuanBesarItems, 'satuanbesar_id', 'satuanbesar_nama'),
                                                    array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                    'empty'=>'-- Pilih --','style'=>'width:130px;')); ?>
                                        </div>
                                    </div> 
                                    
                                    <div class="control-group">
                                        <?php echo CHtml::label('Isi Netto','kemasanbesar',array('class'=>'control-label'));?>
                                        <div class="controls">
                                            <?php echo $form->textField($model,'kemasanbesar',array('class'=>'span1 integer', 
                                                    'onkeypress'=>"return $(this).focusNextInputField(event);",'onkeyup'=>'hitung_harganetto()' )); ?>
                                        </div>
                                    </div> 
                                    
                                    <div class="control-group">
                                        <?php echo $form->labelEx($model,'satuankecil_id',array('class'=>'control-label'));?>
                                        <div class="controls">
                                            <?php echo $form->dropDownList($model,'satuankecil_id',
                                                    CHtml::listData($model->SatuanKecilItems, 'satuankecil_id', 'satuankecil_nama'),
                                                    array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                    'empty'=>'-- Pilih --',)); ?>
                                        </div>
                                    </div> 
                                </div>
                                <div class="span6">
                                    <div class="control-group">
                                        <?php echo $form->labelEx($model,'harganetto',array('class'=>'control-label'));?>
                                        <div class="controls">
                                            <?php echo $form->textField($model,'harganetto',array('class'=>'span2 integer', 
                                                    'onkeypress'=>"return $(this).focusNextInputField(event);",'onkeyup'=>'hitung_hargabeli();')); ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <?php echo $form->labelEx($model,'discount',array('class'=>'control-label'));?>
                                        <div class="controls">
                                            <?php echo $form->textField($model,'discount',array('class'=>'span1 float', 
                                                    'onkeypress'=>"return $(this).focusNextInputField(event);",'onkeyup'=>'hitungHpp();')); ?> %
                                        </div>
                                    </div> 
                                    
                                    <div class="control-group">
                                        <?php echo $form->labelEx($model,'ppn_persen',array('class'=>'control-label'));?>
                                        <div class="controls">
                                            <?php echo $form->textField($model,'ppn_persen',array('class'=>'span1 float', 
                                                    'onkeypress'=>"return $(this).focusNextInputField(event);",'onkeyup'=>'hitungHpp();')); ?> %
                                        </div>
                                    </div>  
                                    
                                    <div class="control-group">
                                        <?php echo Chtml::label('HPP','hpp',array('class'=>'control-label'));?>
                                        <div class="controls">
                                            <?php echo $form->textField($model,'hpp',array('class'=>'span1 integer', 'onkeyup'=>'marginResep();', 
                                                    'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> <font size="1px">(Harga Netto - (Discount + Ppn))</font>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                    </fieldset>
                    <?php } ?>
                </td> 
            </tr>
        </table>
        
           <div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        '#',
                        array('class'=>'btn btn-danger',
                                'onclick'=>'myConfirm("'.Yii::t('mds','Do You want to cancel?').'","Perhatian!",function(r){if(r) window.parent.$("#doalogUpdateHarga").dialog("close");}); return false;'));
                              ?>
           </div>

<?php $this->endWidget(); ?>
<?php
//===============Dialog buat pegawai
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'dialogDisetujui',
    'options'=>array(
        'title'=>'Pencarian Pegawai',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawai = new PegawaiM('search');
$modPegawai->unsetAttributes();
if(isset($_GET['PegawaiM'])){
    $modPegawai->attributes = $_GET['PegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawaiYangMengajukan-m-grid',
    'dataProvider'=>$modPegawai->search(),
    'filter'=>$modPegawai,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","",array("class"=>"btn_small",
                "id"=>"selectPegawai",
                "onClick"=>"$(\"#UbahhargaobatR_disetujuioleh\").val(\"$data->nama_pegawai\");
//                            $(\"#'.CHtml::activeId($model,'yangmengajukan').'\").val(\"$data->gelardepan $data->nama_pegawai\");
                            $(\"#dialogDisetujui\").dialog(\"close\");
                            return false;"
                ))'
        ),
        
        'nama_pegawai',
        'jeniskelamin',
        'nomorindukpegawai',
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
        
$this->endWidget();
if($tersimpan=='Ya'){ ?>
    <script type="text/javascript">
       parent.location.reload();
    </script>
<?php } ?>
<script type="text/javascript">
function hitungHpp()
{
    var harganetto = unformatNumber($('#SAObatalkesM_harganetto').val());
    var discount = unformatNumber($('#SAObatalkesM_discount').val());
    var ppn = unformatNumber($('#SAObatalkesM_ppn_persen').val());
    
    jumlahDiskon = (harganetto - (harganetto * (discount/100)))
    jumlahPpn = (jumlahDiskon * (ppn / 100));
    hpp = jumlahDiskon + jumlahPpn;
    
    console.log(hpp);
    
    $('#SAObatalkesM_hpp').val(formatInteger(hpp));
}

function cekInput()
{
    $('.integer').each(function(){this.value = unformatNumber(this.value)});
    $('.number').each(function(){this.value = unformatNumber(this.value)});
    return true;
}

function hitung_hargabeli(){
    var harganetto  = unformatNumber($('#SAObatAlkesM_harganetto').val());
    var isinetto = unformatNumber($('#SAObatAlkesM_kemasanbesar').val());
    total_hargabeli = harganetto * isinetto;
    $('#hargabeli').val(formatNumber(total_hargabeli));
    hitungHpp();
}

function hitung_harganetto(){
    var hargabeli = unformatNumber($('#hargabeli').val());
    var isinetto  = unformatNumber($('#SAObatalkesM_kemasanbesar').val());
    total_harganetto = hargabeli / isinetto;
    $('#SAObatalkesM_harganetto').val(formatNumber(total_harganetto));
    hitungHpp();
}

function cekInput()
{
    $('.integer').each(function(){this.value = unformatNumber(this.value)});
    $('.number').each(function(){this.value = unformatNumber(this.value)});
    return true;
}

function hitung_hargabeli(){
    var harganetto  = unformatNumber($('#SAObatAlkesM_harganetto').val());
    var isinetto = unformatNumber($('#SAObatAlkesM_kemasanbesar').val());
    total_hargabeli = harganetto * isinetto;
    $('#hargabeli').val(formatNumber(total_hargabeli));
    hitungHpp();
}

function hitung_margin(){
    hargajual = unformatNumber($('#<?php echo CHtml::activeId($model,"hargajual"); ?>').val());
    hpp = unformatNumber($('#<?php echo CHtml::activeId($model,"hpp"); ?>').val());
    margin = ((hargajual - hpp)/hpp)*100;
    $('#<?php echo CHtml::activeId($model,"margin"); ?>').val(margin);
}

function hitung_hargajual(){
    margin = unformatNumber($('#<?php echo CHtml::activeId($model,"margin"); ?>').val());
    hpp = unformatNumber($('#<?php echo CHtml::activeId($model,"hpp"); ?>').val());
    hargajual = hpp + ((hpp/100)*margin);
    $('#<?php echo CHtml::activeId($model,"hargajual"); ?>').val(hargajual);
}

function hitung_margin_hjanonresep(){
    hjanonresep = unformatNumber($('#<?php echo CHtml::activeId($model,"hjanonresep"); ?>').val());
    hpp = unformatNumber($('#<?php echo CHtml::activeId($model,"hpp"); ?>').val());
    marginnonresep = ((hjanonresep - hpp)/hpp)*100;
    $('#<?php echo CHtml::activeId($model,"marginnonresep"); ?>').val(marginnonresep);
}

function hitung_hjanonresep(){
    marginnonresep = unformatNumber($('#<?php echo CHtml::activeId($model,"marginnonresep"); ?>').val());
    hpp = unformatNumber($('#<?php echo CHtml::activeId($model,"hpp"); ?>').val());
    hjanonresep = hpp + ((hpp/100)*marginnonresep);
    $('#<?php echo CHtml::activeId($model,"hjanonresep"); ?>').val(hjanonresep);
}

function hitung_margin_hjaresep(){
    hjaresep = unformatNumber($('#<?php echo CHtml::activeId($model,"hjaresep"); ?>').val());
    jasadokter = unformatNumber($('#<?php echo CHtml::activeId($model,"jasadokter"); ?>').val());
    hpp = unformatNumber($('#<?php echo CHtml::activeId($model,"hpp"); ?>').val());
    marginresep = (((hjaresep - hpp - jasadokter)/hpp)*100);
    $('#<?php echo CHtml::activeId($model,"marginresep"); ?>').val(marginresep);
}

function hitung_hjaresep(){
    marginresep = unformatNumber($('#<?php echo CHtml::activeId($model,"marginresep"); ?>').val());
    jasadokter = unformatNumber($('#<?php echo CHtml::activeId($model,"jasadokter"); ?>').val());
    hpp = unformatNumber($('#<?php echo CHtml::activeId($model,"hpp"); ?>').val());
    hjaresep = hpp + ((hpp/100)*marginresep) + jasadokter;
    $('#<?php echo CHtml::activeId($model,"hjaresep"); ?>').val(hjaresep);
}

</script>