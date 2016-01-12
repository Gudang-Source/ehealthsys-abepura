	<tr>
		<td>
			<span id="isi-r" name="[ii][isi_r]">R/</span>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]rke',array('readonly'=>true,'style'=>'width:20px;')); ?>
		</td>
		<td>
			<?php if(isset($modDetailReseptur[$iii])){ ?>
				<span name="[ii][obatalkes_kode]"><?php echo (!empty($modObatAlkesPasien->obatalkes_id) ? $modObatAlkesPasien->obatalkes->obatalkes_kode : "") ?></span> /<br>
				<span name="[ii][obatalkes_nama_label]"><?php echo (!empty($modDetailReseptur[$iii]->obatalkes_id) ? $modDetailReseptur[$iii]->obatalkes->obatalkes_nama : "") ?></span>
			<?php }else{ ?>
				<span name="[ii][obatalkes_kode]"> - </span> /<br>
				<span name="[ii][obatalkes_nama_label]"> - </span>
			<?php } ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]obatalkes_nama',array('readonly'=>true,'class'=>'span3','value'=>$modObatAlkesPasien->ObatAlkesNama)); //,'onblur'=>'hitungSubTotal(this)'?>
		</td>
		<td>
			<?php
			if(isset($modDetailReseptur[$iii])){
				echo CHtml::activeTextField($modDetailReseptur[$iii], '[ii]qty_reseptur',array('readonly'=>true,'style'=>'width:50px;')); //,'onblur'=>'hitungSubTotal(this)'
			}else{ ?>
				<span name="[ii][obatalkes_kode]"> - </span>
			<?php } ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]qty_dilayani',array('readonly'=>true,'style'=>'width:50px;','value'=>$modObatAlkesPasien->qty_oa,'onblur'=>'hitungSubTotal(this);')); ?>
		</td>
		<td>
			<span name="[ii][sumberdana_nama]"><?php echo (!empty($modObatAlkesPasien->sumberdana_id) ? $modObatAlkesPasien->obatalkes->sumberdana->sumberdana_nama : "") ?></span>
		</td>
		<td>
			<span name="[ii][satuankecil_nama]"><?php echo (!empty($modObatAlkesPasien->obatalkes->satuankecil_id) ? $modObatAlkesPasien->obatalkes->satuankecil->satuankecil_nama : "") ?></span>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]hargajual_oa',array('readonly'=>true,'style'=>'width:60px;', 'class'=>'integer')); ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]subtotal',array('readonly'=>true,'style'=>'width:60px;', 'class'=>'integer','value'=>$modObatAlkesPasien->qty_oa*$modObatAlkesPasien->hargajual_oa)); ?>
		</td>
		
		<td>
			<?php echo CHtml::activeDropDownList($modObatAlkesPasien, '[ii]signa_oa', LookupM::getItems('signa_oa'),array('readonly'=>true,'class'=>'inputFormTabel span3','style'=>'width:100px;','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
		</td>
		<td>
			<?php echo CHtml::activeDropDownList($modObatAlkesPasien, '[ii]etiket', LookupM::getItems('etiket'),array('readonly'=>true,'class'=>'span2')); ?>
		</td>
		<td>
			<span name="[ii][racikan_nama]"><?php echo (!empty($modObatAlkesPasien->racikan_id) ? $modObatAlkesPasien->racikan->racikan_nama : "") ?></span>
		</td>
	</tr>