	<div class="row-fluid">
	<div class="span4">
		<div class="control-group ">
			<label class="control-label">
				<?php
					echo CHtml::radioButton('radio_nomorkartu', false, array(
						'value'=>'radio_nomorkartu',
						'onclick'=>'setPencarian(this);',
						'id'=>'radio_nomorkartu',
						'uncheckValue'=>null
					))." Nomor Kartu Peserta"; 
				?>
			</label>
			<div class="controls">
				<?php echo CHtml::textField('nomorkartupeserta','',array('disabled'=>true,'class'=>'span3')); ?>
				<?php echo CHtml::htmlButton('<i class="icon-search icon-white"></i>',
						array('onclick'=>'cariPesertaBpjsNoKartu();return false;',
							  'class'=>'btn btn-mini btn-primary btn-nomorkartu',
							  'onkeypress'=>"cariPesertaBpjs(this);return false;",
							  'rel'=>"tooltip",
							  'title'=>"Klik untuk mencari data peserta BPJS berdasarkan Nomor Kartu Peserta BPJS",)); ?>
			</div>
		</div>
		<div class="control-group ">
			<label class="control-label">
				<?php
					echo CHtml::radioButton('radio_nik', false, array(
						'value'=>'radio_nik',
						'onclick'=>'setPencarian(this);',
						'id'=>'radio_nik',
						'uncheckValue'=>null
					))." NIK"; 
				?>
			</label>
			<div class="controls">
				<?php echo CHtml::textField('nik','',array('disabled'=>true,'class'=>'span3')); ?>
				<?php echo CHtml::htmlButton('<i class="icon-search icon-white"></i>',
						array('onclick'=>'cariPesertaBpjsNIK();return false;',
							  'class'=>'btn btn-mini btn-primary btn-nik',
							  'onkeypress'=>"cariPesertaBpjs(this);return false;",
							  'rel'=>"tooltip",
							  'title'=>"Klik untuk mencari data peserta BPJS berdasarkan Nomor Induk Kependudukan (NIK)",)); ?>
			</div>
		</div>
	</div>
	<div class="span4">
		
	</div>
	<div class="span4">
		
	</div>
</div>