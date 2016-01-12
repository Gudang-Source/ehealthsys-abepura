<div class="row-fluid biru" id="fktp">
    <div class="white">
	<fieldset class="box" id="pencarian-fktp">
		<legend class="rim">Data Pencarian</legend>
		<?php $this->renderPartial($this->path_view.'_formPencarianFktp',array('form'=>$form)); ?>
	</fieldset>

	<fieldset class="box" id="data-fktp">
		<legend class="rim">Data Rujukan Fasilitas Tingkat Pertama</legend>
		<?php $this->renderPartial($this->path_view.'_formRujukanTP',array('form'=>$form)); ?>
	</fieldset>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue','type'=>'button','disabled'=>true,'onclick'=>'printRujukanFktp(\'PRINT\')')); ?>
	</div>
    </div>
</div>