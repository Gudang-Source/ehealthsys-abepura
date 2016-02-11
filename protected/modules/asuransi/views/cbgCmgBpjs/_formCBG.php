<div class="row-fluid" id="cbg">
	<!--<fieldset class="box" id="pencarian-cbg">-->
		<!--<legend class="rim">Data Pencarian</legend>-->
		<?php $this->renderPartial($this->path_view.'_formPencarianCBG',array('form'=>$form)); ?>
	<!--</fieldset>-->
	<div class="block-tabel">
        <table class="items table table-striped table-condensed" id="table-cbg">
			<thead>
				<tr>
					<th>Kode Prosedur</th>
					<th>Nama Prosedur</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td id="kodeProsedur"></td>
					<td id="namaProsedur"></td>
				</tr>
			</tbody>
		</table>
	</div>
<!--	<fieldset class="box" id="data-cbg">
		<legend class="rim">Data CBG</legend>
		<div class="span6">
			<div class="control-group">
				<label class="control-label">Kode Prosedur</label>
				<div class="controls" id="kodeProsedur">

				</div>
			</div>		
			<div class="control-group">
				<label class="control-label">Nama Prosedur</label>
				<div class="controls" id="namaProsedur">

				</div>
			</div>
		</div>
	</fieldset>-->
</div>
