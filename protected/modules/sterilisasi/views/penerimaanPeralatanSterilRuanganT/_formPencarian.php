<div class="row-fluid">
	<div class ="span4">
		<div class="control-group ">
			<label class='control-label'>Tanggal Pengajuan</label>
			<div class="controls">
				<?php
				$this->widget('MyDateTimePicker', array(
					'model' => $modCari,
					'attribute' => 'tgl_awal',
					'mode' => 'date',
					'options' => array(
						'dateFormat' => Params::DATE_FORMAT,
						'maxDate' => 'd',
					),
					'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3'),
				));
				?>
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="control-group ">
			<label class='control-label'>Sampai Dengan</label>
			<div class="controls">
				<?php
				$this->widget('MyDateTimePicker', array(
					'model' => $modCari,
					'attribute' => 'tgl_akhir',
					'mode' => 'date',
					'options' => array(
						'dateFormat' => Params::DATE_FORMAT,
						'maxDate' => 'd',
					),
					'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3'),
				));
				?>    
			</div>
		</div>
	</div>
	<div class="span4">
		<?php echo $form->textFieldRow($modCari, 'kirimperlinensteril_no', array('placeholder' => 'Ketik No. Pengajuan', 'style' => 'width:199px;', 'maxlength' => 20)); ?>
	</div>
</div>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button','id'=>'pencarian','onclick'=>'cekNoPengiriman()','onkeypress'=>'cekNoPengiriman()'));
    ?>
   <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('index'),array('class'=>'btn btn-danger','onclick'=>'if(!confirm("'.Yii::t('mds','Apakah anda akan mengulang input data ?').'")) return false;')); ?>
		
</div>