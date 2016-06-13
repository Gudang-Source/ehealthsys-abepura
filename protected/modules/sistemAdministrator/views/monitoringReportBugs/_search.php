<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sareportbugs-r-search',
	'type'=>'horizontal',
)); 
$format = new MyFormatter();
?>
<table>
    <tr>
        <td>
            <div class='control-group hari'>
                 <?php echo CHtml::label('Dari Tanggal', 'dari_tanggal', array('class' => 'control-label')) ?>
                 <div class="controls">  
                     <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>                     
                    <?php
                     $this->widget('MyDateTimePicker', array(
                         'model' => $model,
                         'attribute' => 'tgl_awal',
                         'mode' => 'date',
                         'options' => array(
                             'dateFormat' => Params::DATE_FORMAT,
                             'maxDate'=>'d',
                         ),
                         'htmlOptions' => array('readonly' => true, 'class' => "span2",
                             'onkeypress' => "return $(this).focusNextInputField(event)"),
                     ));
                     ?>
                     <?php //$model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>                     
                 </div> 

             </div>
            
            <div class='control-group hari'>
                 <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                 <div class="controls">  
                     <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
                     <?php
                     $this->widget('MyDateTimePicker', array(
                         'model' => $model,
                         'attribute' => 'tgl_akhir',
                         'mode' => 'date',
                         'options' => array(
                             'dateFormat' => Params::DATE_FORMAT,
                             'maxDate'=>'d',
                         ),
                         'htmlOptions' => array('readonly' => true,'class' => "span2",
                             'onkeypress' => "return $(this).focusNextInputField(event)"),
                     ));
                     ?>
                     <?php //$model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
                 </div> 
             </div>
        </td>
         <td>
            <?php echo $form->textFieldRow($model,'kodebugs',array('class'=>'span3','maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($model,'judul_bugs',array('class'=>'span3','maxlength'=>200)); ?>
        </td>
        <td>
            <?php echo $form->textAreaRow($model,'link_bugs',array('class'=>'span3','maxlength'=>500, 'cols'=>6,'rows'=>3)); ?>
	<?php echo $form->textFieldRow($model,'type_bugs',array('class'=>'span3','maxlength'=>100)); ?>
            <?php echo $form->checkBoxRow($model,'isajax_bugs'); ?>
        </td>
    </tr>
    
</table>
	<?php //echo $form->textFieldRow($model,'reportbugs_id',array('class'=>'span3')); ?>

            
	
	

	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
