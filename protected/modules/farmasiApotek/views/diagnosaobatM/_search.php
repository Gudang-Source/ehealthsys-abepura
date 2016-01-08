<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
        'id'=>'fadiagnosaobat-m-search',
        'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model,'diagnosa_id',CHtml::listData($model->getDiagnosaItems(),'diagnosa_id','diagnosa_nama'),array('empty'=>'-- Pilih --',)); ?>
        </td>
        <td>
            <?php echo $form->dropDownListRow($model,'obatalkes_id',CHtml::listData($model->getObatalkesItems(),'obatalkes_id','obatalkes_nama'),array('empty'=>'-- Pilih --')); ?>
        </td>
    </tr>
</table>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary','type'=>'submit')); ?>
</div>

<?php $this->endWidget(); ?>