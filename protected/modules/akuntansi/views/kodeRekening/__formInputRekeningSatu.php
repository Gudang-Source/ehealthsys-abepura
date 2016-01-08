<fieldset class='box' id='fieldsetRekeningSatu'>
    <legend class="rim">Tambah Struktur Rekening</legend>
    <?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js');
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'form-rekening-satu',
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
    <?php echo $form->hiddenField($rekeningSatu, 'rekening1_id', array('class' => 'span3')); ?>
	<?php echo $form->dropDownListRow($rekeningSatu,'kelrekening_id',CHtml::listData(KelrekeningM::model()->findAll(array("condition"=>"kelrekening_aktif =  TRUE")), 'kelrekening_id', 'namakelrekening'),array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
    <?php echo $form->textFieldRow($rekeningSatu, 'kdrekening1', array('class' => 'span1 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 6, 'readonly' => false)); ?>
    <?php echo $form->textFieldRow($rekeningSatu, 'nmrekening1', array('class' => 'span3 reqForm', 'onkeyup' => 'autoInput();', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 32, 'readonly' => false)); ?>
    <?php echo $form->textFieldRow($rekeningSatu, 'nmrekeninglain1', array('class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 32, 'readonly' => false)); ?>
    <?php echo $form->radioButtonListInlineRow($rekeningSatu, 'rekening1_aktif', array('Tidak', 'Aktif'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
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
        $('#form-rekening-satu').submit(function () {
            var kosong = "";
            var jumlahKosong = $("#fieldsetRekeningSatu").find(".reqForm[value=" + kosong + "]");
            if (jumlahKosong.length > 0) {
                myAlert('Inputan bertanda bintang harap di isi !!');
            } else {

                $.post("<?php echo $urlPostData; ?>", {data: $(this).serialize()},
                function (data) {
                    if (data.pesan == 'exist') {
                        myAlert('Kode Rekening telah terdaftar');
                    }

                    if (data.status == 'ok') {
                        myAlert('Rekening berhasil disimpan');
                        if (data.pesan == 'insert') {
                            $("#reseter").click();
                            $('#fieldsetRekeningSatu').find("input[name$='[kdrekening1]']").val(data.id_parent.kdrekening1);
                        }

                        if (typeof getTreeMenu == 'function')
                        {
                            getTreeMenu();
                            $.fn.yiiGridView.update('AKRekeningakuntansi-v', {});
                        }

                    }
                }, "json"
                        );
            }
            return false;
        });

        function autoInput() {
            var namaRekening = $('#AKRekening1M_nmrekening1').val();

            $('#AKRekening1M_nmrekeninglain1').val(namaRekening);
        }
    </script>

    <?php $this->endWidget(); ?>