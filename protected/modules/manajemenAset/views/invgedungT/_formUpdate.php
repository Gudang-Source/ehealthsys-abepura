<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'guinvgedung-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>

<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
<?php echo $form->errorSummary($model); ?>
<?php $this->renderPartial('/_dataBarang', array('modBarang' => $modBarang, 'model' => $model)); ?>
<fieldset class="box">
    <legend class="rim">Data Inventarisasi Gedung dan Bangunan</legend>
    <table width="100%">
        <tr>
            <td>
                <?php echo $form->dropDownListRow($model,'pemilikbarang_id',CHtml::listData(PemilikbarangM::model()->findAll(array('order'=>'pemilikbarang_kode')), 'pemilikbarang_id', 'pemilikbarang_nama'),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                <?php echo $form->hiddenField($model,'barang_id'); ?>
                <?php echo $form->hiddenField($model,'barang_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->dropDownListRow($model,'asalaset_id',CHtml::listData(AsalasetM::model()->findAll(), 'asalaset_id', 'asalaset_nama'),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                <?php echo $form->dropDownListRow($model,'lokasi_id',CHtml::listData(LokasiasetM::model()->findAll(array('order' => 'lokasiaset_namalokasi')), 'lokasi_id', 'lokasiaset_namalokasi'),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                <?php echo $form->textFieldRow($model, 'invgedung_kode', array('class' => 'span2 all-caps', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->textFieldRow($model, 'invgedung_noregister', array('class' => 'span2 all-caps', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->textFieldRow($model, 'invgedung_namabrg', array('class' => 'span3 all-caps', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            </td>
            <td>
                <?php echo $form->textFieldRow($model, 'invgedung_kontruksi', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <div class="control-group">
                    <?php echo $form->label($model, 'invgedung_luaslantai', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'invgedung_luaslantai',array('class'=>'span2 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align: right')); ?>
                        <?php echo CHtml::label(' m<sup>2</sup>', 'm2'); ?>
                    </div>
                </div>
                <?php echo $form->textAreaRow($model, 'invgedung_alamat', array('rows' => 4, 'cols' => 50, 'class' => 'span3 all-caps', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <div class="control-group ">
                        <?php echo $form->labelEx($model, 'invgedung_tgldokumen', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'invgedung_tgldokumen',
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
                    <?php echo $form->error($model, 'invgedung_tgldokumen'); ?>
                    </div>
                </div>
            </td>
            <td>
                <div class="control-group ">
					<div class="control-group">
                    <?php echo $form->labelEx($model,'umurekonomis',array('class'=>'control-label')); ?>
						<div class="controls">
							<?php echo $form->textField($model,'umurekonomis',array('class'=>'span1 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align: right')); ?>
							<?php echo CHtml::label('Tahun', 'tahun'); ?>
						</div>
					</div>
                    <?php echo $form->labelEx($model, 'invgedung_tglguna', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'invgedung_tglguna',
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
                        <?php echo $form->error($model, 'invgedung_tglguna'); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'invgedung_nodokumen', array('class' => 'span2 all-caps', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                <?php echo $form->textFieldRow($model, 'invgedung_harga', array('class' => 'span2 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'invgedung_akumsusut', array('class' => 'span2 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style'=>'text-align: right')); ?>
                
                <?php echo $form->textFieldRow($model, 'invgedung_ket', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                
            </td>
        </tr>
            <?php //echo $form->textFieldRow($model,'create_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'update_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  ?>
            <?php //echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  ?>
            <?php //echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  ?>
            <?php //echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    </table>
</fieldset>
<div class="form-actions">
    <?php
        echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')) :
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
    ?>
    <?php
        echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), Yii::app()->createUrl($this->module->id . '/invgedungT/admin'), array('class' => 'btn btn-danger',
        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
    ?>
    <?php $content = $this->renderPartial('tips/transaksi', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Inventarisasi Gedung dan Bangunan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
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
        'pemilikbarang_id',
        'pemilikbarang_kode',
        'pemilikbarang_nama',
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
        'asalaset_id',
        'asalaset_nama',
        'asalaset_singkatan',
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
        'lokasiaset_namalokasi',
        'lokasiaset_namainstalasi',
        'lokasiaset_namabagian',
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
