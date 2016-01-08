<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'gfsupplier-m-search',
        'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'supplier_kode',array('class'=>'span3','maxlength'=>10)); ?>
            <?php echo $form->textFieldRow($model,'supplier_nama',array('class'=>'span3','maxlength'=>100)); ?>
            <?php echo $form->checkBoxRow($model,'supplier_aktif',array('checked'=>'checked')); ?>
        </td>
        <td>
            <?php echo $form->textAreaRow($model,'supplier_alamat',array('rows'=>4, 'cols'=>20, 'class'=>'span3')); ?>
        </td>
    </tr>    
</table>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
</div>
<?php //echo $form->textFieldRow($model,'supplier_id',array('class'=>'span5')); ?>

<?php //echo $form->textFieldRow($model,'supplier_namalain',array('class'=>'span5','maxlength'=>100)); ?>

<!-- 
<?php echo $form->dropDownListRow($model,'supplier_propinsi',
       CHtml::listData($model->PropinsiItems, 'propinsi_nama', 'propinsi_nama'),
       array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",
       'empty'=>'-- Pilih --',)); ?>
<?php echo $form->dropDownListRow($model,'supplier_kabupaten',
       CHtml::listData($model->KabupatenItems, 'kabupaten_nama', 'kabupaten_nama'),
       array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",
       'empty'=>'-- Pilih --',)); ?>  
-->
<?php //echo $form->textFieldRow($model,'supplier_telp',array('class'=>'span5','maxlength'=>50)); ?>

<?php //echo $form->textFieldRow($model,'supplier_fax',array('class'=>'span5','maxlength'=>50)); ?>

<?php //echo $form->textFieldRow($model,'supplier_kodepos',array('class'=>'span5','maxlength'=>50)); ?>

<?php //echo $form->textFieldRow($model,'supplier_npwp',array('class'=>'span5','maxlength'=>100)); ?>

<?php //echo $form->textFieldRow($model,'supplier_website',array('class'=>'span5','maxlength'=>50)); ?>

<?php //echo $form->textFieldRow($model,'supplier_email',array('class'=>'span5','maxlength'=>50)); ?>

<?php //echo $form->textFieldRow($model,'supplier_cp',array('class'=>'span5','maxlength'=>100)); ?>
<?php $this->endWidget(); ?>
