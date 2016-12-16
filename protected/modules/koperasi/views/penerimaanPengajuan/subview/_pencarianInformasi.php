<?php
$penerimaan = clone $penerimaanPemotongan;
$penerimaan->tglAwal = date('d/m/Y', strtotime($penerimaan->tglAwal));
$penerimaan->tglAkhir = date('d/m/Y', strtotime($penerimaan->tglAkhir));
 ?>

<div class="panel panel-primary col-sm-12" id="panel-pencarian">
	<div class="panel-heading panel-heading2">
		<div class="panel-title">Pencarian</div>
	</div>
	<div class="panel-body col-sm-12">
		<div class="panel-body col-sm-6">
			<div class="form-group">
				<?php echo $form->label($penerimaanPemotongan, 'Tgl BKM', array('class'=>'control-label col-sm-4')); ?>
				<div class="col-sm-8">
					<div class="input-group">
					<?php
					$this->widget('bootstrap.widgets.TbDatePicker', array(
						'model'=>$penerimaan, 'attribute'=>'tglAwal', 'htmlOptions'=>array('class'=>'form-control'), 'options'=>array('format'=>'dd/mm/yyyy'),
					));
					?>
					<div class='input-group-addon' onclick="$('#InfopenerimaanpemotonganV_tglAwal').focus();">
        					<a>
            			<i class='entypo-calendar'></i>
        					</a>
    					</div>
    					</div>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->label($penerimaanPemotongan, 'tglAkhir', array('class'=>'control-label col-sm-4')); ?>
				<div class="col-sm-8">
					<div class="input-group">
					<?php
					$this->widget('bootstrap.widgets.TbDatePicker', array(
						'model'=>$penerimaan, 'attribute'=>'tglAkhir', 'htmlOptions'=>array('class'=>'form-control'), 'options'=>array('format'=>'dd/mm/yyyy'),
					));
					?>
					<div class='input-group-addon' onclick="$('#InfopenerimaanpemotonganV_tglAkhir').focus();">
        					<a>
            			<i class='entypo-calendar'></i>
        					</a>
    					</div>
    					</div>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->label($penerimaanPemotongan, 'nobuktimasuk', array('class'=>'control-label col-sm-4')); ?>
				<div class="col-sm-8">
				<?php echo $form->textField($penerimaanPemotongan,'nobuktimasuk',array('class'=>'form-control','maxlength'=>100, 'placeholder'=>'Cari Berdasarkan '.$penerimaanPemotongan->getAttributeLabel('nobuktimasuk'),)); ?>
				</div>
			</div>
		</div>
		<div class="panel-body col-sm-6">
			<div class="form-group">
				<?php echo $form->label($penerimaanPemotongan, 'nokeanggotaan', array('class'=>'control-label col-sm-4')); ?>
				<div class="col-sm-8">
				<?php echo $form->textField($penerimaanPemotongan,'nokeanggotaan',array('class'=>'form-control','maxlength'=>100, 'placeholder'=>'Cari Berdasarkan '.$penerimaanPemotongan->getAttributeLabel('nokeanggotaan'),)); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->label($penerimaanPemotongan, 'nama_anggota', array('class'=>'control-label col-sm-4')); ?>
				<div class="col-sm-8">
				<?php echo $form->textField($penerimaanPemotongan,'nama_pegawai',array('class'=>'form-control','maxlength'=>100, 'placeholder'=>'Cari Berdasarkan '.$penerimaanPemotongan->getAttributeLabel('nama_anggota'),)); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->label($penerimaanPemotongan, 'unit_id', array('class'=>'control-label col-sm-4')); ?>
				<div class="col-sm-8">
				<?php echo $form->dropDownList($penerimaanPemotongan,'unit_id', CHtml::listData(UnitM::model()->findAll(array('order'=>'namaunit', 'condition'=>'unit_aktif = true')), 'unit_id', 'namaunit'), array('empty'=>'-- Pilih -- ', 'class'=>'form-control','maxlength'=>100, 'placeholder'=>$penerimaanPemotongan->getAttributeLabel('nokeanggotaan'),)); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->label($penerimaanPemotongan, 'potongansumber_id', array('class'=>'control-label col-sm-4')); ?>
				<div class="col-sm-8">
				<?php echo $form->dropDownList($penerimaanPemotongan,'potongansumber_id', CHtml::listData(PotongansumberM::model()->findAll(array('order'=>'namapotongan', 'condition'=>'potongansumber_aktif = true')), 'potongansumber_id', 'namapotongan'), array('empty'=>'-- Pilih -- ', 'class'=>'form-control','maxlength'=>100, 'placeholder'=>$penerimaanPemotongan->getAttributeLabel('nokeanggotaan'),)); ?>
				</div>
			</div>
		</div>
		<div class="panel-body col-sm-12">
			<?php echo CHtml::button('Cari', array('class'=>'btn btn-blue', 'id'=>'btn-cari')); ?>
		</div>
	</div>
</div>
