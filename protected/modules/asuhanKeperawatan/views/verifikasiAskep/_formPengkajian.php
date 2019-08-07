<div class="white-container">
	<div class="row-fluid">
		<fieldset class="box">
			<legend class="rim">Pola Kebiasaan</legend>
			<?php $this->renderPartial('_formKebiasaan', array('modPengkajian' => $modPengkajian)); ?>
		</fieldset>
	</div>
	<div class="row-fluid">
		<fieldset class="box">
			<legend class="rim">Sistem - Sistem Tubuh</legend>
			<?php $this->renderPartial('_formSistemTubuh', array('modPengkajian' => $modPengkajian)); ?>
		</fieldset>
	</div>
</div>
