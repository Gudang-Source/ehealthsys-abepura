<div class="search-form">
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'pencarian-form',
    'type' => 'horizontal',
    'focus'=>'#'.CHtml::activeId($modInfoPencucian,'nopencucianlinen'),
        ));
?>
	<div class="row-fluid">
		<div class="span4">
			<div class="control-group ">
				<?php echo $form->labelEx($modInfoPencucian,'Tanggal Penerimaan', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php   
							$modInfoPencucian->tgl_awal = (!empty($modInfoPencucian->tgl_awal) ? date("d/m/Y H:i:s",strtotime($modInfoPencucian->tgl_awal)) : null);
							$this->widget('MyDateTimePicker',array(
								'model'=>$modInfoPencucian,
								'attribute'=>'tgl_awal',
								'mode'=>'datetime',
								'options'=> array(
									'showOn' => false,
	//                                'maxDate' => 'd',
									'yearRange'=> "-150:+0",
								),
								'htmlOptions'=>array('placeholder'=>'00/00/0000 00:00:00','class'=>'dtPicker2 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)"
								),
						)); ?>
					</div>
			</div>
			<div class="control-group ">
				<?php echo $form->labelEx($modInfoPencucian,'Sampai Dengan', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php   
							$modInfoPencucian->tgl_akhir = (!empty($modInfoPencucian->tgl_akhir) ? date("d/m/Y H:i:s",strtotime($modInfoPencucian->tgl_akhir)) : null);
							$this->widget('MyDateTimePicker',array(
								'model'=>$modInfoPencucian,
								'attribute'=>'tgl_akhir',
								'mode'=>'datetime',
								'options'=> array(
									'showOn' => false,
	//                                'maxDate' => 'd',
									'yearRange'=> "-150:+0",
								),
								'htmlOptions'=>array('placeholder'=>'00/00/0000 00:00:00','class'=>'dtPicker2 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)"
								),
						)); ?>
					</div>
			</div>
		</div>
		<div class="span4">
			<div class="control-group">
				<?php echo CHtml::label('No. Pencucian','',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->textField($modInfoPencucian,'nopencucianlinen',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20,'readonly'=>false)); ?>
				</div>
			</div>
		</div>
		<div class="span4">
			<div class="control-group">
				<?php echo CHtml::label('Instalasi', 'instalasi_id', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->dropDownList($modInfoPencucian,'instalasi_id', $instalasiTujuans, 
							array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
									'ajax'=>array('type'=>'POST',
												'url'=>$this->createUrl('SetDropdownRuangan',array('encode'=>false,'model_nama'=>get_class($modInfoPencucian))),
												'update'=>"#".CHtml::activeId($modInfoPencucian, 'ruangan_id'),
									)));?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Ruangan','',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->dropDownList($modInfoPencucian,'ruangan_id',$ruanganTujuans,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
					$this->createUrl($this->id.'/index'), 
					array('class'=>'btn btn-danger',
						  'onclick'=>'return refreshForm(this);'));  ?>
	</div>
<?php $this->endWidget(); ?>
</div>