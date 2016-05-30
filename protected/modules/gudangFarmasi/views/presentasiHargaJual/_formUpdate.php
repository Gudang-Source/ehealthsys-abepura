<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sakonfigfarmasi-k-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>

<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>

<div class="row-fluid">
    <div class = "span4">
        <?php // echo $form->textFieldRow($model,'tglberlaku',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <div class="control-group">
            <div class="control-label">
                <?php echo CHtml::label('Tanggal Berlaku','tgl_awal'); ?>
            </div>
            <div class="controls">
                <?php   
                        $this->widget('MyDateTimePicker',array(
                                        'model'=>$model,
                                        'attribute'=>'tglberlaku',
                                        'mode'=>'date',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                            'maxDate' => 'd',
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                )); 
                        ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model,'persenppn',array('class'=>'span3 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model,'persenpph',array('class'=>'span3 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->checkBoxRow($model,'bayarlangsung', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model,'formulajasadokter',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
        <?php echo $form->textFieldRow($model,'formulajasaparamedis',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
        <?php echo $form->dropDownListRow($model,'hargaygdigunakan', LookupM::getItems('hargaygdigunakan'),array('class'=>'span3', 'empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textFieldRow($model,'ri_persjualppn',array('class'=>'span3 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model,'rd_persjualppn',array('class'=>'span3 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model,'rj_persjualppn',array('class'=>'span3 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model,'persensubsidirspegawai',array('class'=>'span3 float2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	</div>
    <div class = "span4">
        <?php echo $form->textFieldRow($model,'pembulatanharga',array('class'=>'span3 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
		<?php // RND-7953 echo $form->textFieldRow($model,'pembulatanretail',array('class'=>'span3 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model,'administrasi',array('class'=>'span3 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model,'persjualbebas',array('class'=>'span3 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <?php // RND-7953 echo $form->textFieldRow($model,'admracikan',array('class'=>'span3 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->checkBoxRow($model,'hargajualglobal', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model,'persdiskpasien',array('class'=>'span3 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->checkBoxRow($model,'otomatismargin', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model,'persenmargin',array('class'=>'span3 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <?php // echo $form->dropDownListRow($model,'metodeantrian', LookupM::getItems('metodeantrian'),array('class'=>'span3', 'empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
		<?php echo $form->checkBoxRow($model,'konfigfarmasi_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	</div>
	<div class="span4">
		<?php echo $form->textAreaRow($model,'pesandistruk',array('rows'=>6, 'cols'=>50, 'class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textAreaRow($model,'pesandifaktur',array('rows'=>6, 'cols'=>50, 'class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        
	</div>
</div>
<fieldset class="box">
    <legend class="rim">Tanggungan Jenis Penjualan Obat Alkes</legend>
    <table width="100%" class="table" id="tabTanggungan">
        <thead>
            <tr>
                <th>Jenis Penjualan Obat Alkes</th>
                <th>Subsidi Asuransi</th>
                <th>Subsidi Pemerintah</th>
                <th>Subsidi Rumah Sakit</th>
                <th>Tambah</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $tg = TanggunganpenjualanM::model()->findAll();
            if (count($tg) == 0) :
            ?>
            <tr>
                <td><?php echo CHtml::dropDownList('tanggungan[jenis][]', null, LookupM::getItems('jenispenjualan'), array('empty'=>'-- Pilih --', 'class'=>'span2 jenis')); ?></td>
                <td><?php echo CHtml::textField('tanggungan[asuransi][]', "0,00", array('class'=>'span2 float2 asuransi')); ?></td>
                <td><?php echo CHtml::textField('tanggungan[pemerintah][]', "0,00", array('class'=>'span2 float2 pemerintah')); ?></td>
                <td><?php echo CHtml::textField('tanggungan[rs][]', "0,00", array('class'=>'span2 float2 rs')); ?></td>
                <td><?php 
                echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array(
                    'class'=>'btn btn-primary adds',
                    'onclick'=>'tambahItemTanggungan(this)',
                ))." ".CHtml::htmlButton('<i class="icon-minus icon-white"></i>', array(
                    'class'=>'btn btn-danger removes',
                    'onclick'=>'hapusItem(this)',
                    'style'=>'display: none;',
                )); 
                ?>
                </td>
            </tr>
            <?php else : ?>
                <?php 
                $cnt = 0;
                foreach ($tg as $item): ?>
                
            <tr>
                <td><?php echo CHtml::dropDownList('tanggungan[jenis][]', $item->lookup_name, LookupM::getItems('jenispenjualan'), array('empty'=>'-- Pilih --', 'class'=>'span2 jenis')); ?></td>
                <td><?php echo CHtml::textField('tanggungan[asuransi][]', str_replace(".", ",", $item->subsidiasuransi), array('class'=>'span2 float2 asuransi')); ?></td>
                <td><?php echo CHtml::textField('tanggungan[pemerintah][]', str_replace(".", ",", $item->subsidipemerintah), array('class'=>'span2 float2 pemerintah')); ?></td>
                <td><?php echo CHtml::textField('tanggungan[rs][]', str_replace(".", ",", $item->subsidirs), array('class'=>'span2 float2 rs')); ?></td>
                <td><?php 
                echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array(
                    'class'=>'btn btn-primary adds',
                    'onclick'=>'tambahItemTanggungan(this)',
                ))." ".CHtml::htmlButton('<i class="icon-minus icon-white"></i>', array(
                    'class'=>'btn btn-danger removes',
                    'onclick'=>'hapusItem(this)',
                    'style'=>($cnt == 0?'display: none;':null),
                )); ?>
                </td>
            </tr>
                    
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</fieldset>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), 
                                    array('class'=>'btn btn-danger',
                                    'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                <?php
//                    echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Konfigurasi Farmasi', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
                    $content = $this->renderPartial('../tips/tipsaddedit4b',array(),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                ?>
        </div>

<?php $this->endWidget(); ?>

<?php Yii::app()->clientScript->registerScript('angka', "
$(document).ready(function () {
        $('.numbersOnly').keypress(function(event) {
                var charCode = (event.which) ? event.which : event.keyCode
                if ((charCode >= 48 && charCode <= 57)
                        || charCode == 46
                        || charCode == 44)
                        return true;
                return false;
        });
});
", CClientScript::POS_HEAD); ?>

<script>

function tambahItemTanggungan() {
    $("#tabTanggungan tbody tr:first-child").clone().appendTo($("#tabTanggungan tbody"));
    $("#tabTanggungan tbody tr:last-child .float2").val('0,00').maskMoney(
    {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":2}
    );
    $("#tabTanggungan tbody tr:last-child select").val(null);
    $("#tabTanggungan tbody tr:last-child .removes").show();
}

function hapusItem(obj) {
    $(obj).parents("tr").remove();
}

</script>
