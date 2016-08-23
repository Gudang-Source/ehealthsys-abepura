<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'guinvjalan-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>

<div>
    <!--<legend class="rim" style="width:450px;">Transaksi Inventarisasi Jalan Irigasi dan Jaringan</legend>-->

    <p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
    <?php echo $form->errorSummary($model); ?>
    <?php $this->renderPartial('/_dataBarang', array('modBarang' => $modBarang, 'model' => $model)); ?>
    <fieldset class="box">
        <legend class="rim">Data Inventarisasi Jalan Irigasi dan Jaringan</legend>
        <table width="100%">
            <tr>
                <td>
                    <?php echo $form->dropDownListRow($model,'pemilikbarang_id',CHtml::listData(PemilikbarangM::model()->findAll(array('order'=>'pemilikbarang_kode')), 'pemilikbarang_id', 'pemilikbarang_nama'),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                    <?php echo $form->hiddenField($model,'barang_id'); ?>
                    <?php echo $form->hiddenField($model,'barang_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->dropDownListRow($model,'asalaset_id',CHtml::listData(AsalasetM::model()->findAll(), 'asalaset_id', 'asalaset_nama'),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                    <?php echo $form->dropDownListRow($model,'lokasi_id',CHtml::listData(LokasiasetM::model()->findAll(array('order' => 'lokasiaset_namalokasi')), 'lokasi_id', 'lokasiaset_namalokasi'),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                    <?php echo $form->textFieldRow($model, 'invjalan_kode', array('class' => 'span2 all-caps', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <?php echo $form->textFieldRow($model, 'invjalan_noregister', array('class' => 'span2 all-caps', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <?php echo $form->textFieldRow($model, 'invjalan_namabrg', array('class' => 'span3 all-caps', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    <?php echo $form->textFieldRow($model, 'invjalan_kontruksi', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
  
                </td>
                <td>
                    <?php echo $form->textFieldRow($model, 'invjalan_panjang', array('class' => 'span2 ', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>
                    <?php echo $form->textFieldRow($model, 'invjalan_lebar', array('class' => 'span2 ', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>
                    <?php echo $form->textFieldRow($model, 'invjalan_luas', array('class' => 'span2 ', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>
                    <?php echo $form->textFieldRow($model, 'invjalan_letak', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>
                    <div class="control-group">
						<?php echo $form->labelEx($model,'invjalan_umurekonomis',array('class'=>'control-label')); ?>
						<div class="controls">
							<?php echo $form->textField($model,'invjalan_umurekonomis',array('class'=>'span1 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align: right')); ?>
							<?php echo CHtml::label('Tahun', 'tahun'); ?>
						</div>
                    </div>
					<div class="control-group ">
                        <?php echo $form->labelEx($model, 'invjalan_tgldokumen', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'invjalan_tgldokumen',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                //
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                            <?php echo $form->error($model, 'invjalan_tgldokumen'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model, 'invjalan_tglguna', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'invjalan_tglguna',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                //
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                            <?php echo $form->error($model, 'invjalan_tglguna'); ?>
                        </div>
                    </div>
                </td>
                <td>
                    <?php echo $form->textFieldRow($model, 'invjalan_nodokumen', array('class' => 'span3 all-caps', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>
                    <?php echo $form->textFieldRow($model, 'invjalan_statustanah', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <?php echo $form->textFieldRow($model, 'invjalan_keadaaan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <?php echo $form->textFieldRow($model, 'invjalan_harga', array('class' => 'span2 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style'=>'text-align: right')); ?>
                    <?php echo $form->textFieldRow($model, 'invjalan_akumsusut', array('class' => 'span2 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style'=>'text-align: right')); ?>
                    <?php echo $form->textFieldRow($model, 'invjalan_ket', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                </td>
                <?php //echo $form->textFieldRow($model,'craete_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textFieldRow($model,'update_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  ?>
                <?php // echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  ?>
                <?php //echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  ?>
                <?php //echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  ?>
            </tr>
        </table>
    </fieldset>
    <div class="form-actions">
        <?php
            echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled'=>!$model->isNewRecord));
        ?>
        <?php
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->module->id . '/Create'), array('class' => 'btn btn-danger',
            'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('Create') . '";} ); return false;'));
        ?>
        <?php $content = $this->renderPartial('tips/transaksi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php
//========= Dialog buat cari data Pemilik Barang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPemilikBarang',
    'options' => array(
        'title' => 'Pemilik Barang',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

$modPemilik = new MAPemilikbarangM('search');
$modPemilik->unsetAttributes();
if (isset($_GET['MAPemilikbarangM']))
    $modPemilik->attributes = $_GET['MAPemilikbarangM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'sainstalasi-m-grid',
    'dataProvider' => $modPemilik->search(),
    'filter' => $modPemilik,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>",
                                "#",
                                array(
                                    "class"=>"btn-small", 
                                    "id" => "selectBidang",
                                    "onClick" => "
                                    $(\"#' . CHtml::activeId($model, 'pemilikbarang_id') . '\").val(\'$data->pemilikbarang_id\');
                                    $(\"#pemilikNama\").val(\'$data->pemilikbarang_nama\');
                                    $(\'#dialogPemilikBarang\').dialog(\'close\');return false;"))'
        ),
        'pemilikbarang_id',
        'pemilikbarang_kode',
        'pemilikbarang_nama',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<?php
//========= Dialog buat cari data Asal Aset =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogAsalAset',
    'options' => array(
        'title' => 'Asal Aset',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

$modAsalAset = new MAAsalasetM('search');
$modAsalAset->unsetAttributes();
if (isset($_GET['MAAsalasetM']))
    $modAsalAset->attributes = $_GET['MAAsalasetM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'sainstalasi-m-grid',
    'dataProvider' => $modAsalAset->search(),
    'filter' => $modAsalAset,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>",
                                "#",
                                array(
                                    "class"=>"btn-small", 
                                    "id" => "selectBidang",
                                    "onClick" => "
                                    $(\"#' . CHtml::activeId($model, 'asalaset_id') . '\").val(\'$data->asalaset_id\');
                                    $(\"#asalAsetNama\").val(\'$data->asalaset_nama\');
                                    $(\'#dialogAsalAset\').dialog(\'close\');return false;"))'
        ),
        'asalaset_id',
        'asalaset_nama',
        'asalaset_singkatan',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<?php
//========= Dialog buat cari data Lokasi Aset =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogLokasiAset',
    'options' => array(
        'title' => 'Asal Aset',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

$modLokasiAset = new MALokasiasetM('search');
$modLokasiAset->unsetAttributes();
if (isset($_GET['MALokasiasetM']))
    $modAsalAset->attributes = $_GET['MALokasiasetM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'sainstalasi-m-grid',
    'dataProvider' => $modLokasiAset->search(),
    'filter' => $modLokasiAset,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>",
                                "#",
                                array(
                                    "class"=>"btn-small", 
                                    "id" => "selectBidang",
                                    "onClick" => "
                                    $(\"#' . CHtml::activeId($model, 'lokasi_id') . '\").val(\'$data->lokasi_id\');
                                    $(\"#lokasiAsetNama\").val(\'$data->lokasiaset_namalokasi\');
                                    $(\'#dialogLokasiAset\').dialog(\'close\');return false;"))'
        ),
        'lokasiaset_namalokasi',
        'lokasiaset_namainstalasi',
        'lokasiaset_namabagian',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<?php
$js = <<< JS
$('.numbersOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9]*/g, "");
var msg = "Only Integer Values allowed.";

if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}

if (value != '') {
orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
$(this).val(orignalValue);
}
});
JS;
Yii::app()->clientScript->registerScript('numberOnly', $js, CClientScript::POS_READY);
?>
