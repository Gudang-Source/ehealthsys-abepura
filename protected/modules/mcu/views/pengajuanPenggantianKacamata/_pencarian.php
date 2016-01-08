<div class="search-form">
<?php
	$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
		'action' => Yii::app()->createUrl($this->route),
		'method' => 'get',
		'id' => 'pencariankacamata-form',
		'type' => 'horizontal',
	));
?>
<div class="row-fluid">
    <div class="span6">
        <div class="control-group ">
			<label class='control-label'>Tgl. Ganti Kacamata</label>
			<div class="controls">
				<?php   
					$modGantiKacamata->tgl_awal = isset($modGantiKacamata->tgl_awal) ? MyFormatter::formatDateTimeForUser($modGantiKacamata->tgl_awal) : date('d M Y');
					$this->widget('MyDateTimePicker',array(
						'model'=>$modGantiKacamata,
						'attribute'=>'tgl_awal',
						'mode'=>'date',
						'options'=> array(
							'dateFormat'=>Params::DATE_FORMAT,
							'maxDate' => 'd',
						),
						'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
					)); 
				?>
			</div>
		</div>
    </div>
    <div class="span6">
		<div class="control-group ">
			<label class='control-label'>Sampai Dengan</label>
			<div class="controls">
				<?php   
					$modGantiKacamata->tgl_akhir = isset($modGantiKacamata->tgl_akhir) ? MyFormatter::formatDateTimeForUser($modGantiKacamata->tgl_akhir) : date('d M Y');
					$this->widget('MyDateTimePicker',array(
						'model'=>$modGantiKacamata,
						'attribute'=>'tgl_akhir',
						'mode'=>'date',
						'options'=> array(
							'dateFormat'=>Params::DATE_FORMAT,
							'maxDate' => 'd',
						),
						'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
					)); 
				?>
			</div>
		</div>
    </div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
</div>
<?php $this->endWidget(); ?>
</div>