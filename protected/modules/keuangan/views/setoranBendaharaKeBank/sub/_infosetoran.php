<fieldset class="box">
    <legend class="rim">Data Setoran</legend>
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<?php echo $form->label($model, 'tgl_awal', array('class'=>'control-label')); ?>
				<div class="controls">
					<?php   
							$this->widget('MyDateTimePicker',array(
											'model'=>$model,
											'attribute'=>'tgl_awal',
											'mode'=>'date',
											'options'=> array(
												'dateFormat'=>Params::DATE_FORMAT,
	//                                                    'minDate' => 'd',
											),
											'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
											),
					)); ?>

				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<?php echo $form->label($model, 'tgl_akhir', array('class'=>'control-label')); ?>
				<div class="controls">
					<?php   
					$this->widget('MyDateTimePicker',array(
											'model'=>$model,
											'attribute'=>'tgl_akhir',
											'mode'=>'date',
											'options'=> array(
												'dateFormat'=>Params::DATE_FORMAT,
	//                                                    'minDate' => 'd',
											),
											'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
											),
					)); ?>

				</div>
			</div>
		</div>
	</div>
	<div class="form-actions">
                <?php
                    echo CHtml::link(Yii::t('mds','{icon} Cari',array('{icon}'=>'<i class="icon-search icon-white"></i>')), 
                        '#', 
                        array(
                            'class'=>'btn btn-primary',
                            'onclick'=>'loadSetoranKasir(); return false;'
                    ));
				?>
    </div>
</fieldset>