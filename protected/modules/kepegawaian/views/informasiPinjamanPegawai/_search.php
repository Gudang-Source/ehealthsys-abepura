<legend class="rim">Pencarian</legend>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'search',
	'type'=>'horizontal',
	'focus'=>'#'.CHtml::activeId($model,'tglpinjampeg'),
)); ?>
<div class="row-fluid">
	<div class="span4">
		<div class="control-group ">
			<label class="control-label" >
				<?php echo $form->checkBox($model,'ceklistglpinjam'); ?>
			    Tanggal Pinjam Pegawai
			</label>
			<div class="controls">  
				<?php $model->tgl_awal=MyFormatter::formatDateTimeForUser($model->tgl_awal); ?>
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
				<?php $model->tgl_awal=MyFormatter::formatDateTimeForDb($model->tgl_awal); ?>
			</div>
		</div>
		
		<div class="control-group ">
			<?php echo CHtml::label(' Sampai Dengan',' Sampai Dengan', array('class'=>'control-label')) ?>
			<div class="controls">  
			<?php $model->tgl_akhir=MyFormatter::formatDateTimeForUser($model->tgl_akhir); ?>
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
			<?php $model->tgl_akhir=  MyFormatter::formatDateTimeForDb($model->tgl_akhir); ?>
		    </div> 
	    </div> 

	</div>
	<div class="span4">
		<div class="control-group ">
			<label class="control-label" >
				<?php echo $form->checkBox($model,'ceklis'); ?>
			    Tanggal Jatuh Tempo
			</label>
			<div class="controls">  
				<?php $model->tgl_awal_jatuhtempo=MyFormatter::formatDateTimeForUser($model->tgl_awal_jatuhtempo); ?>
				<?php $this->widget('MyDateTimePicker',array(
									   'model'=>$model,
									   'attribute'=>'tgl_awal_jatuhtempo',
									   'mode'=>'date',
	//                                          'maxDate'=>'d',
									   'options'=> array(
									   'dateFormat'=>Params::DATE_FORMAT,
									  ),
									   'htmlOptions'=>array('readonly'=>true,
									   'class'=>'dtPicker2',
									   'onkeypress'=>"return $(this).focusNextInputField(event)"),
				  )); ?>
				<?php $model->tgl_awal_jatuhtempo=MyFormatter::formatDateTimeForDb($model->tgl_awal_jatuhtempo); ?>
			</div>
		</div>
		
		<div class="control-group ">
			<?php echo CHtml::label(' Sampai Dengan',' Sampai Dengan', array('class'=>'control-label')) ?>
			<div class="controls">  
			<?php $model->tgl_akhir_jatuhtempo=MyFormatter::formatDateTimeForUser($model->tgl_akhir_jatuhtempo); ?>
			<?php $this->widget('MyDateTimePicker',array(
								 'model'=>$model,
								 'attribute'=>'tgl_akhir_jatuhtempo',
								 'mode'=>'date',
	//                                         'maxdate'=>'d',
								 'options'=> array(
								 'dateFormat'=>Params::DATE_FORMAT,
								),
								 'htmlOptions'=>array('readonly'=>true,
								 'class'=>'dtPicker2',
								 'onkeypress'=>"return $(this).focusNextInputField(event)"),
							)); ?>
			<?php $model->tgl_akhir=  MyFormatter::formatDateTimeForDb($model->tgl_akhir_jatuhtempo); ?>
	    </div> 
	    </div>
	</div>
	<div class="span4">
		<?php echo $form->textFieldRow($model,'nopinjam',array('class'=>'span3')); ?>
		<?php echo $form->textFieldRow($model,'nomorindukpegawai',array('class'=>'span3')); ?>
		<?php echo $form->textFieldRow($model,'nama_pegawai',array('class'=>'span3')); ?>
	</div>

</div>

	<div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
                <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), $this->createUrl('/kepegawaian/informasiPinjamanPegawai'), array('class'=>'btn btn-danger')); ?>
				<?php
					$content = $this->renderPartial('../tips/informasi_penggajianKaryawan',array(),true);
					$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
				?>
        </div>

<?php $this->endWidget(); ?>
