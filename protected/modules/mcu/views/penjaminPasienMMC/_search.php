<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal',
	'id'=>'sapenjamin-pasien-m-search',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model, 'carabayar_id', CHtml::listData($model->CaraBayarItems, 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'penjamin_nama',array('class'=>'span3','maxlength'=>30)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'penjamin_aktif',array('checked'=>'penjamin_aktif')); ?>
        </td>
    </tr>
</table>
	

	

	

	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
