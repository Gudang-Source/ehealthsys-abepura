<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'kujenis-penerimaan-m-search',
        'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'jenispenerimaan_kode',array('class'=>'span3 angkahuruf-only','maxlength'=>25)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'jenispenerimaan_nama',array('class'=>'span3 hurufs-only','maxlength'=>25)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'jenispenerimaan_namalain',array('class hurufs-only'=>'span3','maxlength'=>25)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'jenispenerimaan_aktif',array('checked'=>'jenispenerimaan_aktif')); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'jenispenerimaan_id',array('class'=>'span5')); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
</div>

<?php $this->endWidget(); ?>
