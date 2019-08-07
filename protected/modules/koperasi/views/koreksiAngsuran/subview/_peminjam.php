<?php
	$pinjaman2 = clone $pinjaman;
	$pinjaman2->tglAwal = date('d/m/Y', strtotime($pinjaman2->tglAwal));
	$pinjaman2->tglAkhir = date('d/m/Y', strtotime($pinjaman2->tglAkhir));
?>
<div class="row">
		<div class="span6">
			<div class="control-group">
				<?php echo $form->label($pinjaman, 'tglAwal', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php 
					//	$this->widget('bootstrap.widgets.TbDatePicker', array(
					//		'model'=>$pinjaman2, 'attribute'=>'tglAwal', 'htmlOptions'=>array('class'=>'form-control'), 'options'=>array('format'=>'dd/mm/yyyy'),
					//	));
					?>
                                         <?php   
                                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$pinjaman2,
                                                'attribute'=>'tglAwal',
                                                'mode'=>'date',
                                                'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'maxDate' => 'd',
                                                ),
                                                'htmlOptions'=>array('class'=>'dtPicker3', 'onkeyup'=>"return $(this).focusNextInputField(event)"),
                                        )); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->label($pinjaman, 'tglAkhir', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php 
						//$this->widget('bootstrap.widgets.TbDatePicker', array(
					//		'model'=>$pinjaman2, 'attribute'=>'tglAkhir', 'htmlOptions'=>array('class'=>'form-control'), 'options'=>array('format'=>'dd/mm/yyyy'),
					//	));
					?>
                                        <?php   
                                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$pinjaman2,
                                                'attribute'=>'tglAkhir',
                                                'mode'=>'date',
                                                'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'maxDate' => 'd',
                                                ),
                                                'htmlOptions'=>array('class'=>'dtPicker3', 'onkeyup'=>"return $(this).focusNextInputField(event)"),
                                        )); ?>
				</div>
			</div>
		</div>
		<div class="span6">
                    <?php /*
			<div class="form-group">
				<?php echo $form->label($pinjaman, 'unit_id', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-9">
					<?php echo $form->dropDownList($pinjaman,'unit_id', CHtml::listData(UnitM::model()->findAll(array('condition'=>'unit_aktif = true','order' => 'namaunit ASC')), 'unit_id', 'namaunit'), array('empty'=>'-- Pilih --', 'class'=>'form-control','maxlength'=>10)); ?>
				</div>
			</div>
                     * 
                     */ ?>
			<div class="control-group">
				<?php echo $form->label($pinjaman, 'golonganpegawai_id', array('class'=>'control-label col-sm-3')); ?>
				<div class="controls">
					<?php echo $form->dropDownList($pinjaman,'golonganpegawai_id',CHtml::listData(GolonganpegawaiM::model()->findAll('golonganpegawai_aktif = true'), 'golonganpegawai_id', 'golonganpegawai_nama'),
					array('empty'=>'-- Pilih --', 'class'=>'form-control', 'onchange'=>'cekSimpananGolongan()')); ?>
				</div>
			</div>
		</div>
</div>
		<div class="span12">
			<?php //echo CHtml::button('Cari', array('class'=>'btn btn-blue', 'id'=>'btn-cari')); ?>
                         <div class="form-actions">
                            <?php  echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
                        </div>
		</div>
	