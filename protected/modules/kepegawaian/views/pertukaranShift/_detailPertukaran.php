<div style="overflow-x:scroll;max-width:100%;">
	<table class="items table table-striped table-condensed" id="tabel-pertukaran">
		<thead>
			<tr>
				<th>No.</th>
				<th>Tanggal</th>
				<th>No. Induk Pegawai</th>
				<th>Nama Pegawai</th>
				<th>Asal Shift</th>
				<th>Perubahan Shift</th>
				<th>Alasan</th>
				<th>Keterangan</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>1.
					<?php echo CHtml::hiddenField('row',0,array('class'=>'span1','style'=>'width:30px','readonly'=>true)); ?>
				</td>
				<td><div class="input-append"><?php echo CHtml::activeTextField($modDetail, '[ii]tglpertukaranjadwal', array('class'=>'datetimemask', 'style'=>'float:left;width:100px;','value'=>date('d/m/Y H:i:s'),'onkeyup'=>"return $(this).focusNextInputField(event)",)); ?><span class="add-on"><i class="icon-calendar"></i><i class="icon-time"></i></span></div></td>
				<td>
					<?php echo CHtml::activeHiddenField($modDetail, '[ii]pegawai_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
					<?php echo CHtml::activeHiddenField($modDetail, '[ii]penjadwalan_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
					<?php $this->widget('MyJuiAutoComplete',array(
                                'model'=>$modDetail,
                                'attribute'=>'[ii]nomorindukpegawai',
                                'tombolDialog'=>array('idDialog'=>'dialog_pegawai','jsFunction'=>"setDialogPegawai(this,'NIP');"),
                                'htmlOptions'=>array('placeholder'=>'Ketik Nomor Induk Pegawai','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3 autocomplete-pegawai','style'=>'float:left;',
                                    'onblur'=>'if($(this).val() == ""){$(this).parents("td").find("input[name$=\"[pegawai_id]\"]").val("");}',
                                    ),
                    )); ?>
				</td>
				<td>
					<?php $this->widget('MyJuiAutoComplete',array(
                                'model'=>$modDetail,
                                'attribute'=>'[ii]nama_pegawai',
                                'tombolDialog'=>array('idDialog'=>'dialog_pegawai','jsFunction'=>"setDialogPegawai(this,'Nama');"),
                                'htmlOptions'=>array('placeholder'=>'Ketik Nama Pegawai','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3 autocomplete-pegawai','style'=>'float:left;',
                                    'onblur'=>'if($(this).val() == ""){$(this).parents("td").find("input[name$=\"[pegawai_id]\"]").val("");}',
                                    ),
                    )); ?>
				</td>
				<td><?php echo CHtml::activeDropDownList($modDetail, '[ii]shiftasal_id', CHtml::listData(KPShiftM::model()->findAll(),'shift_id','shift_kode'),array('empty'=>'--Pilih--','class'=>'span2','style'=>'width:60px;')); ?></td>
				<td><?php echo CHtml::activeDropDownList($modDetail, '[ii]shift_id', CHtml::listData(KPShiftM::model()->findAll(),'shift_id','shift_kode'),array('empty'=>'--Pilih--','class'=>'span2','style'=>'width:60px;')); ?></td>
				<td><?php echo CHtml::activeTextArea($modDetail, '[ii]alasanpertukaran',array('class'=>'span2','rows'=>1,'cols'=>5)); ?></td>
				<td><?php echo CHtml::activeDropDownList($modDetail,'[ii]ketranganpertukaran', LookupM::getItems('tukarshift'), array('empty'=>'-Pilih-','class'=>'span2','style'=>'width:60px;'))?></td>
			</tr>			
			<tr>
				<td>2.
					<?php echo CHtml::hiddenField('row',0,array('class'=>'span1','style'=>'width:30px','readonly'=>true)); ?>
				</td>
				<td><div class="input-append"><?php echo CHtml::activeTextField($modDetail, '[ii]tglpertukaranjadwal', array('class'=>'datetimemask', 'style'=>'float:left;width:100px;','value'=>date('d/m/Y H:i:s'),'onkeyup'=>"return $(this).focusNextInputField(event)",)); ?><span class="add-on"><i class="icon-calendar"></i><i class="icon-time"></i></span></div></td>
				<td>
					<?php echo CHtml::activeHiddenField($modDetail, '[ii]pegawai_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
					<?php echo CHtml::activeHiddenField($modDetail, '[ii]penjadwalan_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
					<?php $this->widget('MyJuiAutoComplete',array(
                                'model'=>$modDetail,
                                'attribute'=>'[ii]nomorindukpegawai',
                                'tombolDialog'=>array('idDialog'=>'dialog_pegawai','jsFunction'=>"setDialogPegawai(this,'NIP');"),
                                'htmlOptions'=>array('placeholder'=>'Ketik Nomor Induk Pegawai','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3 autocomplete-pegawai','style'=>'float:left;',
                                    'onblur'=>'if($(this).val() == ""){$(this).parents("td").find("input[name$=\"[pegawai_id]\"]").val("");}',
                                    ),
                    )); ?>
				</td>
				<td>
					<?php $this->widget('MyJuiAutoComplete',array(
                                'model'=>$modDetail,
                                'attribute'=>'[ii]nama_pegawai',
                                'tombolDialog'=>array('idDialog'=>'dialog_pegawai','jsFunction'=>"setDialogPegawai(this,'Nama');"),
                                'htmlOptions'=>array('placeholder'=>'Ketik Nama Pegawai','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3 autocomplete-pegawai','style'=>'float:left;',
                                    'onblur'=>'if($(this).val() == ""){$(this).parents("td").find("input[name$=\"[pegawai_id]\"]").val("");}',
                                    ),
                    )); ?>
				</td>
				<td><?php echo CHtml::activeDropDownList($modDetail, '[ii]shiftasal_id', CHtml::listData(KPShiftM::model()->findAll(),'shift_id','shift_kode'),array('empty'=>'--Pilih--','class'=>'span2','style'=>'width:60px;')); ?></td>
				<td><?php echo CHtml::activeDropDownList($modDetail, '[ii]shift_id', CHtml::listData(KPShiftM::model()->findAll(),'shift_id','shift_kode'),array('empty'=>'--Pilih--','class'=>'span2','style'=>'width:60px;')); ?></td>
				<td><?php echo CHtml::activeTextArea($modDetail, '[ii]alasanpertukaran',array('class'=>'span2','rows'=>1,'cols'=>5)); ?></td>
				<td><?php echo CHtml::activeDropDownList($modDetail,'[ii]ketranganpertukaran', LookupM::getItems('tukarshift'), array('empty'=>'-Pilih-','class'=>'span2','style'=>'width:60px;'))?></td>
			</tr>			
		</tbody>
	</table>
</div>