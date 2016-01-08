<div class="search-form" style="">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    ));
    ?>
    <style>

        label.checkbox, label.radio{
            width:150px;
            display:inline-block;
        }

    </style>
    <div class="row-fluid">
        <div class="span6">
            <fieldset class="box2">
                <legend class="rim">Berdasarkan Kunjungan</legend>
                <?php echo CHtml::hiddenField('type', ''); ?>
                <?php //echo CHtml::hiddenField('src', ''); ?>
                <div class = 'control-label'>Tanggal Kunjungan</div>
                <div class="controls">  
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_awal',
                        'mode' => 'date',
                        'options' => array(
                            'maxDate'=>'d',
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array('readonly' => true,
                        'class'=>'dtPicker2',
                        'onkeypress' => "return $(this).focusNextInputField(event)"),
                    ));
                    ?>
                </div>
                <?php echo CHtml::label(' Sampai dengan', ' s/d', array('class' => 'control-label')) ?>
                <div class="controls">  
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_akhir',
                        'mode' => 'date',
                        'options' => array(
                            'maxDate'=>'d',
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array('readonly' => true,
                        'class'=>'dtPicker2',
                        'onkeypress' => "return $(this).focusNextInputField(event)"),
                    ));
                    ?>
                </div>
            </fieldset>
        </div>
        <div class="span6">
            <fieldset class="box2">
                <legend class="rim">Berdasarkan Rujukan</legend>
                <div style='margin-left:0px;'>
                    <?php echo CHtml::checkBox('checkAllRujukan', true, array('onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'checkbox-column', 'onclick' => 'checkAll()', 'checked' => 'checked')) . "Pilih Semua";
                    ?>
                </div><br>
                <div id="rujukan">
                    <?php echo $form->checkBoxList($model, 'asalrujukan_id', CHtml::listData(AsalrujukanM::model()->findAll('asalrujukan_aktif = true'), 'asalrujukan_id', 'asalrujukan_nama')); ?>
                </div>
            </fieldset>
        </div>
    </div>
    <div id='searching'>
        <fieldset class="box2">
            <legend class="rim">Berdasarkan Asal Instalasi </legend>
            <div style='margin-left:0px;'>
                <?php echo CHtml::checkBox('checkAllInstalasi', true, array('onkeypress' => "return $(this).focusNextInputField(event)",
                    'class' => 'checkbox-column', 'onclick' => 'checkAll()', 'checked' => 'checked')) . "Pilih Semua";
                ?>
            </div><br>
            <div id="instalasi">
                <?php echo $form->checkBoxList($model, 'ruanganasal_id', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true'), 'ruangan_id', 'ruangan_nama')); ?>
            </div>
        </fieldset>
        <fieldset class="box2">
            <legend class="rim">Opsi Grafik</legend>
            <?php $model->pilihan = 'instalasi'; ?>
            <?php echo $form->radioButtonList($model, 'pilihan', $model->pilihanGrafik()); ?>
        </fieldset>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));
        ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''), array('class' => 'btn btn-danger',
            'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . '') . '";}); return false;'));
        ?>
    </div>
<?php //$this->widget('UserTips', array('type' => 'create')); ?>    
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
?>
<?php Yii::app()->clientScript->registerScript('cekAll', '
  $("#content4").find("input[type=\'checkbox\']").attr("checked", "checked");
', CClientScript::POS_READY);
?>

<script>
    function checkAll() {
        if ($("#checkAllInstalasi").is(":checked")) {
            $('#instalasi input[name*="ruanganasal_id"]').each(function () {
                $(this).attr('checked', true);
            })
//        myAlert('Checked');
        } else {
            $('#instalasi input[name*="ruanganasal_id"]').each(function () {
                $(this).removeAttr('checked');
            })
        }

        if ($("#checkAllRujukan").is(":checked")) {
            $('#rujukan input[name*="asalrujukan_id"]').each(function () {
                $(this).attr('checked', true);
            })
//        myAlert('Checked');
        } else {
            $('#rujukan input[name*="asalrujukan_id"]').each(function () {
                $(this).removeAttr('checked');
            })
        }
    }
</script>

<?php
//Yii::app()->clientScript->registerScript('onclickButton','
//  var tampilGrafik = "<div class=\"tampilGrafik\" style=\"display:inline-block\"> <i class=\"icon-arrow-right icon-white\"></i> Grafik</div>";
//  $(".accordion-heading a.accordion-toggle").click(function(){
//            $(this).parents(".accordion").find("div.tampilGrafik").remove();
//            $(this).parents(".accordion-group").has(".accordion-body.in").length ? "" : $(this).append(tampilGrafik);
//            
//            
//  });
//',  CClientScript::POS_READY);
?>
