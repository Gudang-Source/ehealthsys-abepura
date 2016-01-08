
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
                'id'=>'gzjeniswaktu-m-search',
                 'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'jeniswaktu_nama',array('size'=>50,'maxlength'=>50)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'jeniswaktu_namalain',array('size'=>50,'maxlength'=>50)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'jeniswaktu_jam',array('size'=>20,'maxlength'=>20)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo $form->checkBoxRow($model,'jeniswaktu_aktif', array('checked'=>"jeniswaktu_aktif")); ?>
        </td>
    </tr>
</table>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
</div>

<?php $this->endWidget(); ?>