<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array( 
    'action'=>Yii::app()->createUrl($this->route), 
    'method'=>'get', 
    'id'=>'satipe-paket-m-search', 
        'type'=>'horizontal', 
)); ?>

    <?php echo $form->textFieldRow($model,'tipepaketNama',array('class'=>'span3','maxlength'=>50)); ?>

    <div class="form-actions"> 
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    </div> 

<?php $this->endWidget(); ?>