	<tr>
		<td>
			<span id="isi-r" name="[ii][isi_r]">R/</span>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]rke',array('readonly'=>false,'style'=>'width:20px;')); ?>
		</td>
		<td>
			<span name="[ii][obatalkes_kode]"></span><br>
			<span name="[ii][obatalkes_nama_label]"></span>
		</td>
		<td>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]obatalkes_id',array('readonly'=>true,'style'=>'width:110px;','class'=>'required')); ?>
			<?php $this->widget('MyJuiAutoComplete',array(
						'model'=>$modResepturDetail,
						'attribute'=>'[ii]obatalkes_nama',
						'tombolDialog'=>array('idDialog'=>'dialogOa','jsFunction'=>"setDialogOA(this,1);"),
						'htmlOptions'=>array('placeholder'=>'Ketik nama tindakan','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span2','value'=>''),
			)); ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]qty_reseptur',array('readonly'=>true,'style'=>'width:50px; text-align: right;')); //,'onblur'=>'hitungSubTotal(this)'?><span class="satuan"></span>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]qty_dilayani',array('readonly'=>false,'style'=>'width:50px; text-align: right;','value'=>$modResepturDetail->qty_reseptur,'onblur'=>'hitungSubTotal(this);')); ?><span class="satuan"></span>
		</td>
		<td hidden>
			<span name="[ii][sumberdana_nama]"><?php echo (!empty($modResepturDetail->sumberdana_id) ? $modResepturDetail->obatalkes->sumberdana->sumberdana_nama : "") ?></span>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]sumberdana_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
		</td>
		<td hidden>
			<span name="[ii][satuankecil_nama]"><?php echo (!empty($modResepturDetail->obatalkes->satuankecil_id) ? $modResepturDetail->obatalkes->satuankecil->satuankecil_nama : "") ?></span>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]satuankecil_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
		</td>
		<td hidden>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]jmlstok',array('readonly'=>true,'style'=>'width:50px;','class'=>'integer2')); ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]hargajual_reseptur',array('readonly'=>true,'style'=>'width:60px;', 'class'=>'integer2')); ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]subtotal',array('readonly'=>true,'style'=>'width:60px;', 'class'=>'integer2','value'=>$modResepturDetail->qty_reseptur*$modResepturDetail->hargajual_reseptur)); ?>
		</td>
		
		<td>
			<?php echo CHtml::activeDropDownList($modResepturDetail, '[ii]signa_reseptur', LookupM::getItems('signa_oa'),array('readonly'=>false,'class'=>'inputFormTabel span3','style'=>'width:100px;','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
		</td>
		<td>
			<?php echo CHtml::activeDropDownList($modResepturDetail, '[ii]etiket', LookupM::getItems('etiket'),array('readonly'=>false,'class'=>'span2')); ?>
		</td>
		<?php
			if(!empty($this->is_trracikan)){ ?>
				<td>
					<span name="[ii][racikan_nama]">Obat Racikan</span>
				</td>
			<?php }else{ ?>
				<td>
					<span name="[ii][racikan_nama]">Non Racikan</span>
				</td>
		<?php } ?>
		<?php
			if(!empty($this->is_trracikan)){ ?>
				<td>
					<?php echo CHtml::activeDropDownList($modResepturDetail, '[ii]satuansediaan', LookupM::getItems('sediaanobatracikan'),array('readonly'=>false,'class'=>'span2')); ?>
				</td>
			<?php }else{ ?>
				<td>
					<span name="[ii][satuansediaan]"> - </span>
				</td>
		<?php } ?>
		<td style="text-align: center;">
			<?php
				if($this->is_trracikan){
					echo CHtml::link('<i class="icon-form-plus"></i>', 'javascript:void(0);', array('onclick'=>'tambahObatalkesRacikan(this,0);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah Obat Alkes dengan R = '.$modResepturDetail->rke));
				}
			?>
		</td>
		<td style="text-align: center;">
			<a onclick="batalObatAlkesPasienDetail(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan penjualan obat alkes ini"><i class="icon-form-silang"></i></a>
		</td>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]resepturdetail_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]racikan_id',array('readonly'=>false,'style'=>'width:110px;')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]hargasatuan_reseptur',array('readonly'=>true,'style'=>'width:110px;')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]harganetto_reseptur',array('readonly'=>true,'style'=>'width:110px;')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]hargajual_reseptur',array('readonly'=>true,'style'=>'width:110px;')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]stokobatalkes_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
	</tr>