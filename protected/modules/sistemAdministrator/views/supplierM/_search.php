<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'gfsupplier-m-search',
        'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'supplier_kode',array('class'=>'span5','maxlength'=>10)); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'supplier_nama',array('class'=>'span5','maxlength'=>100)); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->textAreaRow($model,'supplier_alamat',array('rows'=>4, 'cols'=>50, 'class'=>'span5')); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->checkBoxRow($model,'supplier_aktif',array('checked'=>'supplier_aktif')); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'supplier_id',array('class'=>'span5')); ?>

	

	

	<?php //echo $form->textFieldRow($model,'supplier_namalain',array('class'=>'span5','maxlength'=>100)); ?>

	

	<?php //echo $form->textFieldRow($model,'supplier_propinsi',array('class'=>'span5','maxlength'=>100)); ?>

	<?php //echo $form->textFieldRow($model,'supplier_kabupaten',array('class'=>'span5','maxlength'=>100)); ?>

	<?php //echo $form->textFieldRow($model,'supplier_telp',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'supplier_fax',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'supplier_kodepos',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'supplier_npwp',array('class'=>'span5','maxlength'=>100)); ?>

	<?php //echo $form->textFieldRow($model,'supplier_website',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'supplier_email',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'supplier_cp',array('class'=>'span5','maxlength'=>100)); ?>

	

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
