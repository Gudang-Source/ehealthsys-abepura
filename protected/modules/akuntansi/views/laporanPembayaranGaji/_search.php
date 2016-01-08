<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'searchLaporan',
	'type'=>'horizontal',
)); ?>
<table width="100%"><tr>
    <td width="50%">
        <div class="control-group">
            <label class="control-label">Periode Penggajian</label>
            <div class="controls">
                <?php   
                    $this->widget('MyDateTimePicker',array(
							'model'=>$model,
							'attribute'=>'tgl_awal',
							'mode'=>'date',
							'options'=> array(
								'dateFormat'=>Params::DATE_FORMAT,
							),
							'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:140px;',
						),
                    )); 
                ?>
            </div>
        </div>        
    </td>
    <td>
        <div class="control-group">
            <label class="control-label">Sampai dengan</label>
            <div class="controls">
                <?php  
                    $this->widget('MyDateTimePicker',array(
							'model'=>$model,
							'attribute'=>'tgl_akhir',
							'mode'=>'date',
							'options'=> array(
								'dateFormat'=>Params::DATE_FORMAT,
							),
							'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:140px;',
						),
                    )); 
                ?>
            </div>
        </div>
    </td>
</tr></table>
	<div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                Yii::app()->createUrl($this->route), 
                array('class'=>'btn btn-danger')); ?>
	</div>
<?php $this->endWidget(); ?>
