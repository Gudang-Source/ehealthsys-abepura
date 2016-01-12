<div class="row-fluid">
	<div class="span4">
		<div class="control-group ">
			<label class="control-label">
				<?php
					echo CHtml::radioButton('radio_nomorrujukan_fktp', false, array(
						'value'=>'radio_nomorrujukan_fktp',
						'onclick'=>'setPencarianFktp(this);',
						'id'=>'radio_nomorrujukan_fktp',
						'uncheckValue'=>null
					))." Nomor Rujukan"; 
				?>
			</label>
			<div class="controls">
				<?php echo CHtml::textField('nomorrujukan_fktp','',array('disabled'=>true,'class'=>'span3')); ?>
				<?php echo CHtml::htmlButton('<i class="icon-search icon-white"></i>',
						array('onclick'=>'cariDataRujukanBpjsFktp();return false;',
							  'class'=>'btn btn-mini btn-primary btn-nomorrujukan_fktp',
							  'onkeypress'=>"cariDataRujukanBpjsFktp(this);return false;",
							  'rel'=>"tooltip",
							  'title'=>"Klik untuk mencari data Rujukan BPJS berdasarkan Nomor Rujukan",)); ?>
			</div>
		</div>
		<div class="control-group ">
			<label class="control-label">
				<?php
					echo CHtml::radioButton('radio_nomorkartu_fktp', false, array(
						'value'=>'radio_nomorkartu_fktp',
						'onclick'=>'setPencarianFktp(this);',
						'id'=>'radio_nomorkartu_fktp',
						'uncheckValue'=>null
					))." Nomor Kartu Peserta"; 
				?>
			</label>
			<div class="controls">
				<?php echo CHtml::textField('nomorkartupeserta_fktp','',array('disabled'=>true,'class'=>'span3')); ?>
				<?php echo CHtml::htmlButton('<i class="icon-search icon-white"></i>',
						array('onclick'=>'cariDataRujukanBpjsFktp();return false;',
							  'class'=>'btn btn-mini btn-primary btn-nomorkartu_fktp',
							  'onkeypress'=>"cariDataRujukanBpjsFktp(this);return false;",
							  'rel'=>"tooltip",
							  'title'=>"Klik untuk mencari data Rujukan BPJS berdasarkan Nomor Kartu Peserta",)); ?>
			</div>
		</div>
		<div class="control-group ">
			<label class="control-label">
				<?php
					echo CHtml::radioButton('radio_tglrujukan_fktp', false, array(
						'value'=>'radio_tglrujukan_fktp',
						'onclick'=>'setPencarianFktp(this);',
						'id'=>'radio_tglrujukan_fktp',
						'uncheckValue'=>null
					))." Tanggal Rujukan"; 
				?>
			</label>
			<div class="controls">
				<?php   
					$this->widget('MyDateTimePicker',array(
						'name'=>'tglrujukan_fktp',
						'mode'=>'date',
						'options'=> array(
//							'maxDate' => 'd',
						),
							'htmlOptions'=>array('class'=>'dtPicker2 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
						),
					)); 
				?>
				<?php echo CHtml::htmlButton('<i class="icon-search icon-white"></i>',
						array('onclick'=>'cariDataRujukanBpjsFktp();return false;',
							  'class'=>'btn btn-mini btn-primary btn-tglrujukan_fktp',
							  'onkeypress'=>"cariDataRujukanBpjsFktp(this);return false;",
							  'rel'=>"tooltip",
							  'title'=>"Klik untuk mencari data Rujukan BPJS berdasarkan Tanggal Rujukan",)); ?>
			</div>
		</div>
	</div>
	<div class="span4"></div>
	<div class="span4"></div>
</div>