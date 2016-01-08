<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'aksaldoawal-t-search',
        'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'kdrekening5',array('autofocus'=>true,'class'=>'span3')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'nmrekening5',array('class'=>'span3')); ?>
        </td>
    </tr>
</table>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    $this->createUrl($this->id.'/index'), 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'return refreshForm(this);')); ?>
  	<?php
		$content = $this->renderPartial('tips',array(),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	?>
</div>
<?php $this->endWidget(); ?>