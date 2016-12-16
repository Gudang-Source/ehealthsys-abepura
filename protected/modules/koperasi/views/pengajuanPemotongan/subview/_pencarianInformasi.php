<?php
$pengajuan = clone $pengajuanPemotongan;
$pengajuan->tglAwal = date('d/m/Y', strtotime($pengajuan->tglAwal));
$pengajuan->tglAkhir = date('d/m/Y', strtotime($pengajuan->tglAkhir));
?>
<div class="panel panel-primary col-sm-12" id="panel-pencarian">
	<div class="panel-heading panel-heading2">
		<div class="panel-title">Pencarian</div>
	</div>
	<div class="panel-body col-sm-12">
		<div class="panel-body col-sm-6">
			<div class="form-group">
				<?php echo $form->label($pengajuanPemotongan, 'tglpengajuanpemb', array('class'=>'control-label col-sm-4')); ?>
				<div class="col-sm-8">
					<div class="input-group">
					<?php
					$this->widget('bootstrap.widgets.TbDatePicker', array(
						'model'=>$pengajuan, 'attribute'=>'tglAwal', 'htmlOptions'=>array('class'=>'form-control'), 'options'=>array('format'=>'dd/mm/yyyy'),
					));
					?>
					<div class='input-group-addon' onclick="$('#InfopengajuanpemotonganV_tglAwal').focus();">
        					<a href='#'>
            			<i class='entypo-calendar'></i>
        					</a>
    					</div>
    					</div>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->label($pengajuanPemotongan, 'tglAkhir', array('class'=>'control-label col-sm-4')); ?>
				<div class="col-sm-8">
					<div class="input-group">
					<?php
					$this->widget('bootstrap.widgets.TbDatePicker', array(
						'model'=>$pengajuan, 'attribute'=>'tglAkhir', 'htmlOptions'=>array('class'=>'form-control'), 'options'=>array('format'=>'dd/mm/yyyy'),
					));
					?>
					<div class='input-group-addon' onclick="$('#InfopengajuanpemotonganV_tglAkhir').focus();">
        					<a href='#'>
            			<i class='entypo-calendar'></i>
        					</a>
    					</div>
    					</div>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->label($pengajuanPemotongan, 'nopengajuan', array('class'=>'control-label col-sm-4')); ?>
				<div class="col-sm-8">
				<?php echo $form->textField($pengajuanPemotongan,'nopengajuan',array('class'=>'form-control','maxlength'=>100, 'placeholder'=>'Cari Berdasarkan '.$pengajuanPemotongan->getAttributeLabel('nopengajuan'),)); ?>
				</div>
			</div>
		</div>
		<div class="panel-body col-sm-6">
			<div class="form-group">
				<?php echo $form->label($pengajuanPemotongan, 'nokeanggotaan', array('class'=>'control-label col-sm-4')); ?>
				<div class="col-sm-8">
				<?php echo $form->textField($pengajuanPemotongan,'nokeanggotaan',array('class'=>'form-control','maxlength'=>100, 'placeholder'=>'Cari Berdasarkan '.$pengajuanPemotongan->getAttributeLabel('nokeanggotaan'),)); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->label($pengajuanPemotongan, 'nama_pegawai', array('class'=>'control-label col-sm-4')); ?>
				<div class="col-sm-8">
				<?php echo $form->textField($pengajuanPemotongan,'nama_pegawai',array('class'=>'form-control','maxlength'=>100, 'placeholder'=>'Cari Berdasarkan '.$pengajuanPemotongan->getAttributeLabel('nama_pegawai'),)); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->label($pengajuanPemotongan, 'unit_id', array('class'=>'control-label col-sm-4')); ?>
				<div class="col-sm-8">
				<?php echo $form->dropDownList($pengajuanPemotongan,'unit_id',CHtml::listData(UnitM::model()->findAll(array('order'=>'namaunit', 'condition'=>'unit_aktif = true')), 'unit_id', 'namaunit'), array('empty'=>'-- Pilih --', 'class'=>'form-control','maxlength'=>100, 'placeholder'=>$pengajuanPemotongan->getAttributeLabel('nopengajuan'),)); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->label($pengajuanPemotongan, 'potongansumber_id', array('class'=>'control-label col-sm-4')); ?>
				<div class="col-sm-8">
				<?php echo $form->dropDownList($pengajuanPemotongan,'potongansumber_id',CHtml::listData(PotongansumberM::model()->findAll(array('order'=>'namapotongan', 'condition'=>'potongansumber_aktif = true')), 'potongansumber_id', 'namapotongan'), array('empty'=>'-- Pilih --', 'class'=>'form-control','maxlength'=>100, 'placeholder'=>$pengajuanPemotongan->getAttributeLabel('nopengajuan'),)); ?>
				</div>
			</div>
		</div>
		<div class="panel-body col-sm-12">
			<?php echo CHtml::button('Cari', array('class'=>'btn btn-blue', 'id'=>'btn-cari')); ?>
		</div>
	</div>
</div>
