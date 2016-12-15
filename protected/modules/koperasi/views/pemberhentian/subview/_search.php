<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'id'=>'informasi-anggota-form',
	'method'=>'get',
	'type'=>'horizontal',
	'htmlOptions'=>array('class'=>'form-groups-bordered'),
));

$model2 = clone $model;
$model2->tglAwal = date('d/m/Y H:i', strtotime($model2->tglAwal));
$model2->tglAkhir = date('d/m/Y H:i', strtotime($model2->tglAkhir));

?>
<div class="form-group">
				<?php echo $form->label($model, 'tglAwal', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-5">
					<div class="input-group">
					<?php
					$this->widget('bootstrap.widgets.TbDateTimePicker', array(
							'model'=>$model2, 'attribute'=>'tglAwal', 'htmlOptions'=>array('class'=>'form-control'), 'options'=>array('format'=>'dd/mm/yyyy H:i'),
					));
					?>
					<div class='input-group-addon' onclick="$('#KartusimpanananggotaV_tglAwal').focus()">
        					<a>
            			<i class='entypo-calendar'></i>
        					</a>
    					</div>
    					</div>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->label($model, 'tglAkhir', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-5">
					<div class="input-group">
					<?php
					$this->widget('bootstrap.widgets.TbDateTimePicker', array(
						'model'=>$model2, 'attribute'=>'tglAkhir', 'htmlOptions'=>array('class'=>'form-control'), 'options'=>array('format'=>'dd/mm/yyyy H:i'),
						));
					?>
					<div class='input-group-addon' onclick="$('#KartusimpanananggotaV_tglAkhir').focus()">
        					<a>
            			<i class='entypo-calendar'></i>
        					</a>
    					</div>
    					</div>
				</div>
			</div>
		<?php echo $form->textFieldRow($model,'nokeanggotaan',array('class'=>'form-control', 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('nokeanggotaan'),)); ?>
		<div class="form-group">
            <?php echo $form->labelEx($model, 'Nama_Anggota',array('class'=>'control-label col-sm-3')); ?>
			<div class="col-sm-5">
				<?php echo $form->textField($model,'nama_pegawai',array('class'=>'form-control', 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('nama_anggota'),)); ?>
			</div>
		</div>
		<div class="form-group">
            <?php echo $form->labelEx($model, 'Unit',array('class'=>'control-label col-sm-3')); ?>
            <div class="col-sm-5">
                <?php echo $form->dropDownList($model, 'unit_id', CHtml::listData(UnitM::model()->findAll(array('condition'=>'unit_aktif = true','order'=>'namaunit')), 'unit_id', 'namaunit'), array("class"=>"form-control", "empty" => "-- Pilih --")); ?>
            </div>
      </div>
		<div class="form-group">
            <?php echo $form->labelEx($model, 'Golongan',array('class'=>'control-label col-sm-3')); ?>
            <div class="col-sm-5">
                <?php echo $form->dropDownList($model, 'golonganpegawai_id', CHtml::listData(GolonganpegawaiM::model()->findAll(array('condition'=>'golonganpegawai_aktif = true','order'=>'golonganpegawai_nama')), 'golonganpegawai_id', 'golonganpegawai_nama'), array("class"=>"form-control", "empty" => "-- Pilih --")); ?>
            </div>
      </div>
		
	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-5">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Cari',
			'htmlOptions'=>array('class'=>'btn-primary'),
		)); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>
