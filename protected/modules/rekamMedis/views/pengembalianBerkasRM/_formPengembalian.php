<div class="row-fluid">
	<div class="span4">
		<?php 
			$model->tglkembali = MyFormatter::formatDateTimeForUser($model->tglkembali);
			echo $form->textFieldRow($model,'tglkembali',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
		?>
		<div class="control-group ">
			<?php echo CHtml::activeLabel($model, 'petugaspenerima', array('class' => 'control-label')); ?>
		<div class="controls">
			<?php
				$this->widget('MyJuiAutoComplete', array(
					'model' => $model,
					'attribute' => 'petugaspenerima',
					'value' => '',
					'sourceUrl' => $this->createUrl('GetPetugasPenerima'),
					'options' => array(
					'showAnim' => 'fold',
					'minLength' => 2,
					'focus' => 'js:function( event, ui ) {
							$(this).val(ui.item.petugaspenerima);
							return false;
						}',
					'select' => 'js:function( event, ui ) {
							$("#'.CHtml::activeId($model, 'petugaspenerima') . '").val(ui.item.nama_pegawai);
							return false; }',
					),
					'htmlOptions'=>array(
					'onkeypress'=>'return $(this).focusNextInputField(event)',
					'disabled'=>($model->isNewRecord)?'':'disabled', 
					'class'=>'span2', 
					),
					'tombolDialog'=>array('idDialog'=>'dialogPetugasPenerima'),

				));
			?>
			</div>
		</div>
	</div>	
	<div class="span4">
		<?php echo $form->textAreaRow($model,'keterangan_pengembalian',array('class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	</div>
	<div class="span4"></div>
</div>