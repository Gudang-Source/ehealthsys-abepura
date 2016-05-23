<fieldset class='box' id='fieldsetObyekRekening'>
    <legend class="rim">Tambah Pos</legend>
	<?php
	Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js');
	$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
		'id' => 'form-obyek-rekening',
		'enableAjaxValidation' => false,
		'type' => 'horizontal',
		'htmlOptions' => array(
			'onKeyPress' => 'return disableKeyPress(event)'
		),
		'focus' => '#',
			)
	);
	$this->widget('bootstrap.widgets.BootAlert');
	?>
	<?php echo $form->hiddenField($model, 'rekening3_id', array('class' => 'span1')); ?>
	<?php echo $form->hiddenField($model, 'rekening4_id', array('class' => 'span1')); ?>
    <div class="control-group ">
        <label class="control-label required" for="AKRekening4M_kdrekening4">Kode Akun&nbsp;<span class="required">*</span></label>
        <div class="controls">
			<?php echo $form->textField($model, 'kdrekening4', array('class' => 'span2 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 10, 'readonly' => false)); ?>
        </div>
    </div>
	<?php echo $form->textFieldRow($model, 'nmrekening4', array('class' => 'span3 reqForm', 'onkeyup' => 'autoInput();', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 300, 'readonly' => false)); ?>
	<?php echo $form->textFieldRow($model, 'nmrekeninglain4', array('class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 300, 'readonly' => false)); ?>
	<?php // echo $form->dropDownListRow($model, 'rekening4_nb', LookupM::getItems('jenis_rekening'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
	<?php echo $form->radioButtonListInlineRow($model, 'rekening4_aktif', array('Tidak', 'Aktif'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
    <div class="form-actions">
		<?php
		echo CHtml::htmlButton(Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
		echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), array('style' => 'display:none', 'id' => 'reseter', 'class' => 'btn btn-danger', 'type' => 'reset'));
		?>
    </div>

	<?php
	$urlPostData = Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/SimpanRekening');
	?>
</fieldset>
<script type="text/javascript">
	$('#form-obyek-rekening').submit(function () {
		var kosong = "";
		var jumlahKosong = $("#fieldsetJenisRekening").find(".reqForm[value=" + kosong + "]");
		if (jumlahKosong.length > 0) {
			myAlert('Inputan bertanda bintang harap di isi !!');
		} else {

			$.post("<?php echo $urlPostData; ?>", {data: $(this).serialize()},
			function (data) {
				if (data.pesan == 'exist') {
					myAlert('Kode Rekening telah terdaftar');
                                        refreshTree();
				} else if (data.pesan == 'kode') {
                                        myAlert('Kode rekening harus 8 Karakter');
                                }

				if (data.status == 'ok') {
					myAlert('Rekening berhasil disimpan');
                                        refreshTree();
					if (data.pesan == 'insert') {
						$("#reseter").click();
						$('#fieldsetObyekRekening').find("input[name$='[kdrekening4]']").val(data.id_parent.kdrekening4);
					}

					//if (typeof getTreeMenu == 'function')
					//{
						//getTreeMenu();
						$.fn.yiiGridView.update('AKRekeningakuntansi-v', {});
					//}
				}
			}, "json"
					);
		}
		return false;
	});

	function autoInput() {
		var namaRekening = $('#AKRekening4M_nmrekening4').val();

		$('#AKRekening4M_nmrekeninglain4').val(namaRekening);
	}
</script>

<?php $this->endWidget(); ?>