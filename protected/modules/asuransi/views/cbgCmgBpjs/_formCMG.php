<div class="row-fluid" id="cmg">
	<!--<fieldset class="box" id="pencarian-cmg">-->
		<!--<legend class="rim">Data Pencarian</legend>-->
		<?php $this->renderPartial($this->path_view.'_formPencarianCMG',array('form'=>$form)); ?>
	<!--</fieldset>-->
	
	<fieldset class="box" id="data-cmg">
		<legend class="rim">Data CMG</legend>
		<div class="span6">
			<div class="control-group">
				<label class="control-label">Kode CMG</label>
				<div class="controls" id="kodeCMG">

				</div>
			</div>		
			<div class="control-group">
				<label class="control-label">Kode Grup</label>
				<div class="controls" id="kodeGrup">

				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Nama CMG</label>
				<div class="controls" id="namaCMG">

				</div>
			</div>
		</div>
	</fieldset>
</div>
