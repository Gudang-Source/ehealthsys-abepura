<fieldset class='box' id='fieldsetDetailObyekRekening'>
    <legend class="rim">Tambah Akun</legend>
	<?php
	Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js');
	$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
		'id' => 'form-detail-obyek-rekening',
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
	<?php echo $form->hiddenField($model, 'rekening4_id', array('class' => 'span1')); ?>
	<?php echo $form->hiddenField($model, 'rekening5_id', array('class' => 'span1')); ?>
    <div class="control-group ">
        <label class="control-label required" for="AKRekening5M_kdrekening5">Kode Akun&nbsp;<span class="required">*</span></label>
        <div class="controls">
			<?php echo $form->textField($model, 'kdrekening5', array('class' => 'span2 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 20, 'readonly' => false)); ?>
        </div>
    </div>
	<?php echo $form->textFieldRow($model, 'nourutrek', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 6, 'readonly' => false)); ?>
	<?php echo $form->textFieldRow($model, 'nmrekening5', array('class' => 'span4 reqForm', 'onkeyup' => 'autoInput();', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 500, 'readonly' => false)); ?>
	<?php echo $form->textFieldRow($model, 'nmrekeninglain5', array('class' => 'span4 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 500, 'readonly' => false)); ?>
	<?php echo $form->dropDownListRow($model, 'rekening5_nb', LookupM::getItems('jenis_rekening'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
	<?php echo $form->textAreaRow($model, 'keterangan', array('class' => 'span4 required', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => false)); ?>
	<?php echo $form->dropDownListRow($model, 'tiperekening_id', TiperekeningM::items(), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
	
	<?php // RND-9468 echo $form->dropDownListRow($model, 'kelompokrek', LookupM::getItems('kelompok_rekening'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
	<?php echo $form->radioButtonListInlineRow($model, 'rekening5_aktif', array('Tidak', 'Aktif'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
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
	$('#form-detail-obyek-rekening').submit(function () {
		var kosong = "";
		var jumlahKosong = $("#fieldsetDetailObyekRekening").find(".reqForm[value=" + kosong + "]");
		if (jumlahKosong.length > 0) {
			myAlert('Inputan bertanda bintang harap di isi !!');
		} else {

			$.post("<?php echo $urlPostData; ?>", {data: $(this).serialize()},
			function (data) {
				if (data.pesan == 'exist') {
					myAlert('Kode Rekening telah terdaftar');
                                        refreshTree();
				} else if (data.pesan == 'kode') {
                                        myAlert('Kode rekening harus 10 Karakter');
                                }

				if (data.status == 'ok') {
					myAlert('Rekening berhasil disimpan');
                                        refreshTree();
					if (data.pesan == 'insert') {
						$("#reseter").click();
						$('#fieldsetDetailObyekRekening').find("input[name$='[kdrekening5]']").val(data.id_parent.kdrekening5);
                                                $('#fieldsetDetailObyekRekening').find("select[name$='[rekening5_nb]']").val(data.id_parent.saldonormal);
					}
					//getTreeMenu();
					$.fn.yiiGridView.update('AKRekeningakuntansi-v', {});

				}
			}, "json"
					);
		}
		return false;
	});
	function autoInput() {
		var namaRekening = $('#AKRekening5M_nmrekening5').val();

		$('#AKRekening5M_nmrekeninglain5').val(namaRekening);
	}
</script>

<?php $this->endWidget(); ?>