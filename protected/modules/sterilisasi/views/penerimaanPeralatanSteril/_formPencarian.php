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
		<?php echo $form->textFieldRow($modCari, 'pengajuansterlilisasi_no', array('placeholder' => 'Ketik No. Pengajuan', 'style' => 'width:199px;', 'maxlength' => 20)); ?>
		<div class="control-group ">
			<?php echo CHtml::label('Instalasi','Instalasi', array('class'=>'control-label')) ?>
			<div class="controls">
			<?php echo $form->dropDownList($modCari,'instalasi_id', CHtml::listData(InstalasiM::model()->findAll(),'instalasi_id','instalasi_nama'),
					array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
							'ajax'=>array('type'=>'POST',
										'url'=>$this->createUrl('SetDropdownRuangan',array('encode'=>false,'model_nama'=>get_class($modCari))),
										'update'=>"#".CHtml::activeId($modCari, 'ruangan_id'),
							)));?>
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="control-group ">
			<?php echo CHtml::label('Ruangan','Ruangan', array('class'=>'control-label inline')) ?>
			<div class="controls">
				<?php echo $form->dropDownList($modCari,'ruangan_id',CHtml::listData(RuanganM::model()->findAll(),'ruangan_id','ruangan_nama'),array('class'=>'span3','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			</div>
		</div>
	</div>
</div>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button','id'=>'pencarian','onclick'=>'cekNoPengajuan()','onkeypress'=>'cekNoPengajuan()'));
    ?>
   <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('index'),array('class'=>'btn btn-danger','onclick'=>'if(!confirm("'.Yii::t('mds','Apakah anda akan mengulang input data ?').'")) return false;')); ?>
		
</div>