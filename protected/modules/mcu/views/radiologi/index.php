<?php
$this->breadcrumbs = array(
    'Radiologi',
);
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'radiologi-mcu-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this);'),
        ));
?>
<!--<div class="block-tabel">-->
    <!--<h6>Tabel <b>Pemeriksaan Radiologi</b></h6>-->
	<div class="formInputTab">
		<?php echo $form->errorSummary($modKirimKeUnitLain); ?>
		<!--<div class="block-tabel">-->
			<!--<h6>Tabel <b>Pemeriksaan Radiologi</b></h6>-->
			<table id="form-pemeriksaan-mcu" class="table table-bordered table-condensed">
				<thead>
					<tr>
						<th>NAMA PEMERIKSAAN</th>
						<th>HASIL EKSPERTISE</th>
						<th>KESAN</th>
						<th>KESIMPULAN</th>
						<th>HASIL RADIOLOGI</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		<!--</div>-->
		<div class="form-actions">
			<?php //JIKA TANPA VERIFIKASI >> echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onkeypress'=>'formSubmit(this,event)')); ?>
			<?php
			if ($modHasilPemeriksaanRad->isNewRecord) {
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'type' => 'submit', 'onkeypress' => 'formSubmit(this,event)')); //formSubmit(this,event)
			} else {
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'return false', 'onkeypress' => 'return false', 'disabled' => true, 'style' => 'cursor:not-allowed;'));
			}
			?>
		</div>
		<br><br><br><br><br>
	</div>
<!--</div>-->

<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('modPendaftaran' => $modPendaftaran, 'modKirimKeUnitLain' => $modKirimKeUnitLain)); ?>