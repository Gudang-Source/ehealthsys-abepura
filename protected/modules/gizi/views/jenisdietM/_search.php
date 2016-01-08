<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
                'id'=>'gzpropinsi-m-search',
                 'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'jenisdiet_nama',array('class'=>'span3','size'=>50,'maxlength'=>50)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'jenisdiet_namalainnya',array('class'=>'span3','size'=>50,'maxlength'=>50)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'jenisdiet_aktif', array('checked'=>'jenisdiet_aktif')); ?>
        </td>
    </tr>
</table>
<?php /* echo $form->textFieldRow($model,'jenisdiet_id'); */ ?>
<?php /* echo $form->textAreaRow($model,'jenisdiet_keterangan',array('rows'=>6, 'cols'=>50)); */ ?>
<?php /* echo $form->textAreaRow($model,'jenisdiet_catatan',array('rows'=>6, 'cols'=>50)); */ ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
</div>

<?php $this->endWidget(); ?>
