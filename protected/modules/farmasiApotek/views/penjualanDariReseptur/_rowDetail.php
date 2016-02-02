<?php

$satuan = !empty($modResepturDetail->obatalkes->satuankecil_id) ? $modResepturDetail->obatalkes->satuankecil->satuankecil_nama : "";

?>
        <tr>
		<td>
			<span id="isi-r" name="[ii][isi_r]">R/</span>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]rke',array('readonly'=>true,'style'=>'width:20px;')); ?>
		</td>
		<td>
			<span name="[ii][obatalkes_kode]"><?php echo (!empty($modResepturDetail->obatalkes_id) ? $modResepturDetail->obatalkes->obatalkes_kode : "") ?></span> /<br>
			<span name="[ii][obatalkes_nama_label]"><?php echo (!empty($modResepturDetail->obatalkes_id) ? $modResepturDetail->obatalkes->obatalkes_nama : "") ?></span>
		</td>
		<td>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]obatalkes_id',array('readonly'=>true,'style'=>'width:110px;','class'=>'required')); ?>
			<?php $this->widget('MyJuiAutoComplete',array(
						'model'=>$modResepturDetail,
						'attribute'=>'[ii]obatalkes_nama',
						'tombolDialog'=>array('idDialog'=>'dialogOa','jsFunction'=>"setDialogOA(this,0);"),
						'htmlOptions'=>array('placeholder'=>'Ketik nama tindakan','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span2','value'=>$modResepturDetail->ObatAlkesNama),
			)); ?>
		</td>
		<td nowrap>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]qty_reseptur',array('readonly'=>true,'style'=>'width:50px; text-align: right;')); //,'onblur'=>'hitungSubTotal(this)'?>
                        <?php echo $satuan; ?>
		</td>
		<?php if(!isset($takaranresep)){?>
			<td nowrap>
				<?php echo CHtml::activeTextField($modResepturDetail, '[ii]qty_dilayani',array('readonly'=>false,'style'=>'width:50px; text-align: right;','value'=>$modResepturDetail->qty_reseptur,'onblur'=>'hitungSubTotal(this);')); ?>
                                <?php echo $satuan; ?>
			</td>
		<?php }else{ ?>
			<td nowrap>
				<?php echo CHtml::activeTextField($modResepturDetail, '[ii]qty_dilayani',array('readonly'=>false,'style'=>'width:50px; text-align: right;','onblur'=>'hitungSubTotal(this);')); ?>
                                <?php echo $satuan; ?>
			</td>
		<?php } ?>
		<td>
			<span name="[ii][sumberdana_nama]"><?php echo (!empty($modResepturDetail->sumberdana_id) ? $modResepturDetail->obatalkes->sumberdana->sumberdana_nama : "") ?></span>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]sumberdana_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
                        <?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]satuankecil_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
		</td>
		<!--td>
			<span name="[ii][satuankecil_nama]"><?php echo (!empty($modResepturDetail->obatalkes->satuankecil_id) ? $modResepturDetail->obatalkes->satuankecil->satuankecil_nama : "") ?></span>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]jmlstok',array('readonly'=>true,'style'=>'width:50px;','class'=>'integer')); ?>
		</td-->
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]hargajual_reseptur',array('readonly'=>true,'style'=>'width:60px;', 'class'=>'integer')); ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]subtotal',array('readonly'=>true,'style'=>'width:60px;', 'class'=>'integer','value'=>$modResepturDetail->qty_reseptur*$modResepturDetail->hargajual_reseptur)); ?>
		</td>
		
		<td>
			<?php echo CHtml::activeDropDownList($modResepturDetail, '[ii]signa_reseptur', LookupM::getItems('signa_oa'),array('readonly'=>false,'class'=>'inputFormTabel span3','style'=>'width:100px;','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
		</td>
		<td>
			<?php echo CHtml::activeDropDownList($modResepturDetail, '[ii]etiket', LookupM::getItems('etiket'),array('readonly'=>false,'class'=>'span2')); ?>
		</td>
		<td>
			<span name="[ii][racikan_nama]"><?php echo (!empty($modResepturDetail->racikan_id) ? $modResepturDetail->racikan->racikan_nama : "") ?></span>
		</td>
		<?php
			if(!empty($modResepturDetail->satuansediaan)){ ?>
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
				if($modResepturDetail->racikan_id == Params::RACIKAN_ID_RACIKAN){
					echo CHtml::link('<i class="icon-form-plus"></i>', 'javascript:void(0);', array('onclick'=>'tambahObatalkesRacikan(this,0);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah Obat Alkes dengan R = '.$modResepturDetail->rke));
				}
			?>
		</td>
		<td style="text-align: center;">
			<a onclick="batalObatAlkesPasienDetail(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan penjualan obat alkes ini"><i class="icon-form-silang"></i></a>
		</td>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]resepturdetail_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]racikan_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]hargasatuan_reseptur',array('readonly'=>true,'style'=>'width:110px;')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]harganetto_reseptur',array('readonly'=>true,'style'=>'width:110px;')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]hargajual_reseptur',array('readonly'=>true,'style'=>'width:110px;')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]stokobatalkes_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
	</tr>