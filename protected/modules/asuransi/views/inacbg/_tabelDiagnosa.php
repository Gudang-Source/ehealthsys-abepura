<div class="block-tabel">
	<h6>Tabel <b>Diagnosa</b>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'refreshDiagnosa();', 'onkeypress'=>'refreshDiagnosa();','rel'=>'tooltip','title'=>'Klik untuk refresh diagnosa dan pengecekan ulang ke server BPJS')); ?>
	</h6>
	<table class="items table table-striped table-condensed" id="table-diagnosa">
		<thead>
			<tr>
				<th>Pilih
					<?php echo CHtml::checkBox('check_semua',true, array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'checkbox-column','onclick'=>'checkAll()','checked'=>'checked')) ?>
				</th>
				<th>Kode Diagnosa</th>
				<th>Nama Diagnosa</th>
				<th>Keterangan</th>
				<th>Level</th>
				<th>INASIS 4.1</th>
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>
</div>	