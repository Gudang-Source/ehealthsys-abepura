<div class="row-fluid" id="diagnosa">
	<!--<fieldset class="box" id="pencarian-diagnosa">-->
		<!--<legend class="rim">Data Pencarian</legend>-->
		<?php $this->renderPartial($this->path_view.'_formPencarianDiagnosa',array('form'=>$form)); ?>
	<!--</fieldset>-->
		<?php $this->renderPartial($this->path_view.'_tabelDiagnosa',array()); ?>
	
<!--	<fieldset class="box" id="data-diagnosa">
		<legend class="rim">Data Diagnosa</legend>
		<div class="span6">
			<div class="control-group">
				<label class="control-label">Kode Diagnosa</label>
				<div class="controls" id="kodeDiagnosa">

				</div>
			</div>		
			<div class="control-group">
				<label class="control-label">Nama Diagnosa</label>
				<div class="controls" id="namaDiagnosa">

				</div>
			</div>
		</div>
	</fieldset>-->
</div>
