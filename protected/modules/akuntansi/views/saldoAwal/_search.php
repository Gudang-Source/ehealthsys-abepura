<fieldset class="box">
    <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'aksaldoawal-t-search',
        'type'=>'horizontal',
)); ?>

<?php echo $form->textFieldRow($model,'kdrekening5',array('class'=>'span3')); ?>
<?php echo $form->textFieldRow($model,'nmrekening5',array('class'=>'span3')); ?>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
        Yii::app()->createUrl($this->module->id.'/SaldoAwal/informasi'), 
        array('class'=>'btn btn-danger',
           	  'onclick'=>'if(!confirm("'.Yii::t('mds','Do You want to cancel?').'")) return false;')); ?>
  	<?php
                $tips = array(
                    '0' => 'cari',
                    '1' => 'ulang2'
                );
		$content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	?>
</div>
<?php $this->endWidget(); ?>
</fieldset>