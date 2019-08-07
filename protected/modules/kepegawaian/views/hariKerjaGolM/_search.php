
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'golongan-gaji-m-search',
    'type'=>'horizontal',
)); ?>

	  <?php  echo $form->dropDownListRow($model,'kelompokpegawai_id', CHtml::listData(KPKelompokpegawaiM::model()->findAll('kelompokpegawai_aktif = true'), 'kelompokpegawai_id', 'kelompokpegawai_nama'), array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", "empty"=>'-- Pilih --')); ?>
  <?php //echo $form->textFieldRow($model,'tglpresensi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
<table>
    <tr>
        <td>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'periodeharikerjaawl', array('class' => 'control-label')); ?>
                <div class="controls">
                <?php $this->widget('MyDateTimePicker',array(
                                        'model'=>$model,
                                        'attribute'=>'periodeharikerjaawl',
                                        'mode'=>'date',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,
                                                              'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                              'class'=>'dtPicker3',
                                         ),
                )); ?> 
                </div>
            </div>
        </td>
    </tr>
    <?php //echo $form->textFieldRow($model,'tglpresensi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
     <tr>
        <td>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'periodehariakhir', array('class' => 'control-label')); ?>
                <div class="controls">
                <?php $this->widget('MyDateTimePicker',array(
                                        'model'=>$model,
                                        'attribute'=>'periodehariakhir',
                                        'mode'=>'date',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,
                                                              'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                              'class'=>'dtPicker3',
                                         ),
                )); ?> 
                </div>
            </div>
     </td>
    </tr>   
    <tr>
        <td>
          <?php //echo $form->textFieldRow($model,'tglpresensi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'periodeharikerjaakhir', array('class' => 'control-label')); ?>
                <div class="controls">
                <?php $this->widget('MyDateTimePicker',array(
                                        'model'=>$model,
                                        'attribute'=>'periodeharikerjaakhir',
                                        'mode'=>'date',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,
                                                              'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                              'class'=>'dtPicker3',
                                         ),
                )); ?> 
                </div>
            </div>
        </td>
    </tr>  
    <tr>
        <td>
        <?php echo $form->textFieldRow($model,'jmlharibln',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        </td>
    </tr>
    <tr>
        <td><?php echo $form->checkBoxRow($model,'harikerjagol_aktif',array('checked'=>'harikerjagol_aktif')); ?></td>
    </tr>
	
</table>
<div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>
<?php $this->endWidget(); ?>
