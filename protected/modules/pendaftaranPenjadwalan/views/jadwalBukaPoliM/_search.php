<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'ppjadwal-buka-poli-m-search',
        'focus'=>'#'.CHtml::activeId($model,'ruangan_id'),
        'type'=>'horizontal',        
)); ?>

	<?php //echo $form->textFieldRow($model,'jadwalbukapoli_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'ruangan_nama',array('class'=>'span3')); ?>

        <div class="control-group">
            <?php echo CHtml::activeLabel($model,'ruangan_id',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model,'ruangan_id', CHtml::listData($model->getRuanganItems(), 'ruangan_id', 'ruangan_nama') ,
                      array('empty'=>'-- Pilih --',
                            'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($model,'hari',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model,'hari',array('class'=>'span3','maxlength'=>20)); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::activeLabel($model,'jmabuka', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
                            $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'jmabuka',
                                            'mode'=>'time',

                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                                            ),
                    )); ?>
                    <?php echo $form->error($model, 'jmabuka'); ?>
                </div>
        </div>
        
        <div class="control-group ">
            <?php echo CHtml::activeLabel($model,'jammulai', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
                            $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'jammulai',
                                            'mode'=>'time',

                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                                            ),
                    )); ?>
                    <?php echo $form->error($model, 'jammulai'); ?>
                </div>
        </div>

        <div class="control-group ">
            <?php echo CHtml::activeLabel($model,'jamtutup', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
                            $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'jamtutup',
                                            'mode'=>'time',

                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                                            ),
                    )); ?>
                    <?php echo $form->error($model, 'jamtutup'); ?>
                </div>
         </div>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
