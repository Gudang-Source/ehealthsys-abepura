<div class="white-container">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'pppendaftaran-mp-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => false,
        'type' => 'horizontal',
        'focus' => '#isPasienLama',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    ));
    //
    ?>
    <?php
    $this->widget('bootstrap.widgets.BootAlert');
    $this->renderPartial('template/_ringkasDataPasien', array('modPasienMasukPenunjang' => $modPasienMasukPenunjang));
    echo $form->errorSummary(array($modKirimSample, $modPengambilanSample));
    ?>
    <fieldset class="box">
        <legend class="rim">Data Sampel <?php echo CHtml::htmlButton("<i class='icon icon-white icon-plus'></i>", array('onclick' => 'addRowSample(this);return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk menambah data sample', 'class' => 'btn btn-primary')); ?></legend>
        <table width="100%" id="data-sample">
            <?php
            $samples = count($modPengambilanSamples);
            if ($samples > 0) {
                foreach ($modPengambilanSamples as $i => $pengambilanSample) {
                    echo $this->renderPartial('_rowSample', array('form' => $form, 'modPengambilanSample' => $pengambilanSample, 'i' => $i), true);
                }
            } else {
                echo $this->renderPartial('_rowSample', array('form' => $form, 'modPengambilanSample' => $modPengambilanSample, 'i' => 0), true);
            }
            ?>
        </table>
    </fieldset>
    <div class='form-actions'>
        <?php
        echo CHtml::htmlButton($modKirimSample->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')) :
                        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit',
            'id' => 'btn_simpan',
        ));
        ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Batal', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl('index'), array('class' => 'btn btn-danger')); ?>
    </div>
    <?php
    if ($samples > 0) {
        $trSample = $this->renderPartial('_rowSample', array('form' => $form, 'modPengambilanSample' => $modPengambilanSample, 'i' => $i+1), true);
    } else {
        $trSample = $this->renderPartial('_rowSample', array('form' => $form, 'modPengambilanSample' => $modPengambilanSample, 'i' => 0), true);
    }
    ?>
    <?php $this->endWidget(); ?>
</div>
<script type="text/javascript">
    function addRowSample()
    {
        var trSample = <?= json_encode($trSample) ?>;
        $('table#data-sample').append(trSample.replace());
        renameInput();
    }
    function hapusRowSample(obj, id = null)
    {
        if (id == null) {
            $(obj).parents('tr').detach();
        } else {
            myConfirm("Apakah anda yakin akan menghapus data sampel ini?", "Perhatian!", function (r) {
                if (r) {
                    $.post('<?php echo $this->createUrl('ajaxDeleteDataSample') ?>', {id: id}, function (data) {
                        if (data.success)
                        {
                            $(obj).parents('tr').detach();
                            myAlert('Data berhasil dihapus !!');
                        } else {
                            myAlert('Data Gagal dihapus');
                        }
                    }, 'json');
                }
            });
        }

    }


    function renameInput() {
        var row = 0;
        var obj_table = '#data-sample';
        $(obj_table).find("tbody > tr").each(function () {

            $(this).find('input,select,textarea').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            $(this).find('span.add-on').each(function () {
                var old_name = $(this).parent('.input-append').find('input').attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                var id_span = '';
                if (old_name_arr.length == 3) {
                    id_span = old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_date";
                    id = old_name_arr[0] + "_" + row + "_" + old_name_arr[2];
                    registerDateJs(id, id_span);
                }
            });
            row++;
        });
    }

    function registerDateJs(id, id_span) {
        jQuery('#' + id).datetimepicker(jQuery.extend({showMonthAfterYear: false}, jQuery.datepicker.regional['id'], {'dateFormat': 'dd M yy', 'maxDate': 'd', 'timeText': 'Waktu', 'hourText': 'Jam', 'minuteText': 'Menit', 'secondText': 'Detik', 'showSecond': true, 'timeOnlyTitle': 'Pilih Waktu', 'timeFormat': 'hh:mm:ss', 'changeYear': true, 'changeMonth': true, 'showAnim': 'fold', 'yearRange': '-80y:+20y'}));
        jQuery('#' + id_span).on('click', function () {
            jQuery('#' + id).datepicker('show');
        });
    }

</script>
<?php
$jscript = <<< JS
function enableInputSample(obj)
{
    
}
JS;
Yii::app()->clientScript->registerScript('enabledKirimSample', $jscript, CClientScript::POS_HEAD);

$enableInputSample = ($modKirimSample->isKirimSample) ? 1 : 0;
$js = <<< JS

JS;
Yii::app()->clientScript->registerScript('ready', $js, CClientScript::POS_READY);
?>