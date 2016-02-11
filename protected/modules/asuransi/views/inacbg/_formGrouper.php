<?php echo CHtml::htmlButton(Yii::t('mds','Group',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'grouping();', 'onkeypress'=>'grouping();','rel'=>'tooltip','title'=>'Klik untuk melakukan grouping')); ?>
<div class="row-fluid">
	<div class="span6">
		<div class="control-group">
			<?php echo CHtml::label('Deskripsi','',array('class'=>'control-label')); ?>
			<div class="controls" id="group_deskripsi">
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Kode INA-CBG','',array('class'=>'control-label')); ?>
			<div class="controls" id="group_kode_inacbg">
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('No. SEP','',array('class'=>'control-label')); ?>
			<div class="controls" id="group_no_sep">
			</div>
		</div>
	</div>
	<div class="span6">
		<div class="control-group">
			<?php echo CHtml::label('Total Grouper','',array('class'=>'control-label')); ?>
			<div class="controls" id="group_total_grouper">
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Total Tarif','',array('class'=>'control-label')); ?>
			<div class="controls" id="group_total_tarif">
			</div>
		</div>
	</div>
	<div class="span12">
		<div class="block-tabel">
			<table class="items table table-striped table-condensed" id="table-grouper">
				<thead>
					<tr>
						<th>No.</th>
						<th>Group</th>
						<th>Deskripsi</th>
						<th>Kode</th>
						<th>Total Tarif</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td id="no"></td>
						<td id="group"></td>
						<td id="deskripsi"></td>
						<td id="kode"></td>
						<td id="total_tarif"></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>