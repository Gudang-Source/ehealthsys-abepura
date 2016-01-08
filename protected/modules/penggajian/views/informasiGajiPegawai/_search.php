<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>

<div class="row-fluid">
	<div class="span4">
			<?php echo $form->labelEx($model,'tglpenggajian', array('class'=>'control-label')) ?>
		<div class="controls">  
			<?php $model->tgl_awal=$format->formatDateTimeForUser($model->tgl_awal); ?>
			<?php $this->widget('MyDateTimePicker',array(
								   'model'=>$model,
								   'attribute'=>'tgl_awal',
								   'mode'=>'date',
//                                          'maxDate'=>'d',
								   'options'=> array(
								   'dateFormat'=>Params::DATE_FORMAT,
								  ),
								   'htmlOptions'=>array('readonly'=>true,
								   'class'=>'dtPicker2',
								   'onkeypress'=>"return $(this).focusNextInputField(event)"),
			  )); ?>
                  <?php  $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>
		</div>
	</div>
	<div class="span4">
			<?php echo CHtml::label(' Sampai Dengan',' Sampai Dengan', array('class'=>'control-label')) ?>
		<div class="controls">  
		<?php $model->tgl_akhir=$format->formatDateTimeForUser($model->tgl_akhir); ?>
		<?php $this->widget('MyDateTimePicker',array(
							 'model'=>$model,
							 'attribute'=>'tgl_akhir',
							 'mode'=>'date',
//                                         'maxdate'=>'d',
							 'options'=> array(
							 'dateFormat'=>Params::DATE_FORMAT,
							),
							 'htmlOptions'=>array('readonly'=>true,
							 'class'=>'dtPicker2',
							 'onkeypress'=>"return $(this).focusNextInputField(event)"),
						)); ?>
                  <?php  $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
	    </div> 
	</div>
	<div class="span4">
        <?php echo $form->textFieldRow($model,'nopenggajian',array('class'=>'span3')); ?>
	</div>
</div>

	<div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
				<?php
					$content = $this->renderPartial('penggajian.views/tips/informasi_penggajianKaryawan',array(),true);
					$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
				?>
        </div>
