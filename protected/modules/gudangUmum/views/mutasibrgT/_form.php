<?php
if (isset($_GET['idMutasi']) && !empty($_GET['idMutasi'])) {
    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="white-container">
    <legend class="rim2">Transaksi Mutasi <b>Barang</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'gumutasibrg-t-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
        'focus' => '#',
    ));
    ?>
    <?php echo $form->errorSummary($model); ?>
    <?php
    if (isset($modPesan)) {
        $this->renderPartial('gudangUmum.views.mutasibrgT._dataPesan', array('modPesan' => $modPesan));
    }
    ?>
    <fieldset class="box">
        <p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
        <legend class="rim">Data Mutasi Barang</legend>
        <table width="100%">
            <tr>
                <td>

                            <?php //echo $form->textFieldRow($model,'pesanbarang_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  ?>
                            <?php //echo $form->textFieldRow($model,'tglmutasibrg',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <div class="control-group ">
                            <?php echo $form->labelEx($model, 'tglmutasibrg', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tglmutasibrg',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                            ));
                            ?>
                    <?php echo $form->error($model, 'tglmutasibrg'); ?>
                        </div>
                    </div>
                        <?php echo $form->textFieldRow($model, 'nomutasibrg', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>

                            <?php //echo $form->textFieldRow($model,'pegpengirim_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <div class="control-group ">
                            <?php echo $form->labelEx($model, 'pegpengirim_id', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->hiddenField($model, 'pegpengirim_id'); ?>
                            <!--                <div class="input-append" style='display:inline'>-->
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'pegpengirim_nama',
                                'source' => 'js: function(request, response) {
                                                                                               $.ajax({
                                                                                                       url: "' . Yii::app()->createUrl('ActionAutoComplete/getPegawai') . '",
                                                                                                       dataType: "json",
                                                                                                       data: {
                                                                                                               term: request.term,
                                                                                                       },
                                                                                                       success: function (data) {
                                                                                                                       response(data);
                                                                                                       }
                                                                                               })
                                                                                            }',
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 2,
                                    'focus' => 'js:function( event, ui ) {
                                                                                                                                                            $(this).val( ui.item.label);
                                                                                                                                                            return false;
                                                                                                                                                    }',
                                    'select' => 'js:function( event, ui ) {
                                                                                                                                                            $("#' . Chtml::activeId($model, 'pegpengirim_id') . '").val(pegawai_id); 
                                                                                                                                                            return false;
                                                                                                                                                    }',
                                ),
                                'htmlOptions' => array(
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'placeholder' => 'Ketikan Nama Pegawai Pengirim'
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogPegawai'),
                            ));
                            ?>
                        <?php echo $form->error($model, 'pegpengirim_id'); ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="control-group ">
                            <?php echo $form->labelEx($model, 'pegmengetahui_id', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->hiddenField($model, 'pegmengetahui_id'); ?>
                            <!--                <div class="input-append" style='display:inline'>-->
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'pegmengetahui_nama',
                                'source' => 'js: function(request, response) {
                                                                                               $.ajax({
                                                                                                       url: "' . Yii::app()->createUrl('ActionAutoComplete/getPegawai') . '",
                                                                                                       dataType: "json",
                                                                                                       data: {
                                                                                                               term: request.term,
                                                                                                       },
                                                                                                       success: function (data) {
                                                                                                                       response(data);
                                                                                                       }
                                                                                               })
                                                                                            }',
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 2,
                                    'focus' => 'js:function( event, ui ) {
                                                                                                                                                            $(this).val( ui.item.label);
                                                                                                                                                            return false;
                                                                                                                                                    }',
                                    'select' => 'js:function( event, ui ) {
                                                                                                                                                            $("#' . Chtml::activeId($model, 'pegmengetahui_id') . '").val(pegawai_id); 
                                                                                                                                                            return false;
                                                                                                                                                    }',
                                ),
                                'htmlOptions' => array(
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'placeholder' => 'Ketikan Nama Pegawai Mengetahui'
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
                            ));
                            ?>
                        <?php echo $form->error($model, 'pegmengetahui_id'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                            <?php echo $form->labelEx($model, 'ruangantujuan_id', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            echo $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true'), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,
                                'ajax' => array('type' => 'POST',
                                    'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($model))),
                                    'update' => '#' . CHtml::activeId($model, 'ruangantujuan_id') . ''),));
                            ?>
                    <?php echo $form->dropDownList($model, 'ruangantujuan_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array('instalasi_id' => $model->instalasi_id, 'ruangan_aktif' => true)), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <?php echo $form->error($model, 'ruangantujuan_id'); ?>
                        </div>
                    </div>
                </td>
                <td>
                <?php echo $form->textAreaRow($model, 'keterangan_mutasi', array('rows' => 6, 'cols' => 50, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </td>
            </tr>
        </table>
    </fieldset>

    <?php //echo $form->textFieldRow($model,'totalhargamutasi',array('class'=>'span1 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <fieldset class="box">
        <?php $this->renderPartial('gudangUmum.views.mutasibrgT._formDetailBarang', array('model' => $model, 'form' => $form, 'modPesan' => $modPesan, 'modDetails' => $modDetails)); ?>
        <div class="block-tabel">
            <h6>Tabel <b>Barang</b></h6>
            <?php $this->renderPartial('gudangUmum.views.mutasibrgT._tableDetailBarang', array('model' => $model, 'form' => $form, 'modDetails' => $modDetails, 'modPesan' => $modPesan)); ?>
        </div>
    </fieldset>
    <?php //echo $form->textFieldRow($model,'pegmengetahui_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <?php //echo $form->textFieldRow($model,'ruangantujuan_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <?php //echo $form->textFieldRow($model,'create_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
<?php //echo $form->textFieldRow($model,'update_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  ?>
        <?php //echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  ?>
        <?php //echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <?php //echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <div class="form-actions">
		<?php
			if(isset($_GET['sukses'])){
				echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','disabled'=>true));
			}else{
				echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','disabled'=>false));
			}
        ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-danger',
            'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/index') . '";}); return false;'));
        ?>
		<?php
			if(isset($_GET['sukses'])){
				echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')",'disabled'=>false));
			}else{
				echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','disabled'=>true));
			}
		?>
        <?php
        $content = $this->renderPartial('gudangUmum.views.mutasibrgT.tips.transaksi2', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>	
    </div>
    <?php $this->endWidget(); ?>


    <?php
//========= Dialog buat cari Bahan Diet =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogPegawaiMengetahui',
        'options' => array(
            'title' => 'Daftar Pegawai',
            'autoOpen' => false,
            'modal' => true,
            'width' => 750,
            'height' => 600,
            'resizable' => false,
        ),
    ));

    $modPegawai = new GUPegawaiM('search');
    $modPegawai->unsetAttributes();
//$modPegawai->ruangan_id = 0;
    if (isset($_GET['GUPegawaiM']))
        $modPegawai->attributes = $_GET['GUPegawaiM'];

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'pegawai-m-grid',
        'dataProvider' => $modPegawai->searchDialog(),
        'filter' => $modPegawai,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            ////'pegawai_id',
             array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectBahan",
                                    "onClick" => "
                                        $(\'#' . Chtml::activeId($model, 'pegmengetahui_nama') . '\').val(\'$data->nama_pegawai\');
                                        $(\'#' . Chtml::activeId($model, 'pegmengetahui_id') . '\').val(\'$data->pegawai_id\');
                                        $(\'#dialogPegawaiMengetahui\').dialog(\'close\');
                                        return false;"))',
            ),
            'nama_pegawai',
            'nomorindukpegawai',
            'alamat_pegawai',
            'agama',
            array(
                'name' => 'jeniskelamin',
                'filter' => CHtml::dropDownList('GUPegawaiM[jeniskelamin]',$modPegawai->jeniskelamin,LookupM::getItems('jeniskelamin'), array('empty'=>'--Pilih--')),
                'value' => '$data->jeniskelamin',
            ),
           
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));

    $this->endWidget();
    ?>
    <?php
//========= Dialog buat cari Bahan Diet =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogPegawai',
        'options' => array(
            'title' => 'Daftar Pegawai',
            'autoOpen' => false,
            'modal' => true,
            'width' => 750,
            'height' => 600,
            'resizable' => false,
        ),
    ));

    $modPegawai2 = new GUPegawaiM('search');
    $modPegawai2->unsetAttributes();
//$modPegawai->ruangan_id = 0;
    if (isset($_GET['GUPegawaiM']))
        $modPegawai2->attributes = $_GET['GUPegawaiM'];

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'pegawai-m-grid2',
        'dataProvider' => $modPegawai2->searchDialog(),
        'filter' => $modPegawai2,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            ////'pegawai_id',
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectBahan",
                                    "onClick" => "
                                    $(\'#' . Chtml::activeId($model, 'pegpengirim_nama') . '\').val(\'$data->nama_pegawai\');
                                    $(\'#' . Chtml::activeId($model, 'pegpengirim_id') . '\').val(\'$data->pegawai_id\');
                                    $(\'#dialogPegawai\').dialog(\'close\');
                                    return false;"))',
            ),
            'nama_pegawai',
            'nomorindukpegawai',
            'alamat_pegawai',
            'agama',
            array(
                'name' => 'jeniskelamin',
                'filter' => CHtml::dropDownList('GUPegawaiM[jeniskelamin]',$modPegawai->jeniskelamin,LookupM::getItems('jeniskelamin'), array('empty'=>'--Pilih--')),
                'value' => '$data->jeniskelamin',
            ),
            
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));

    $this->endWidget();
    ?>
    <?php
    $this->widget('application.extensions.moneymask.MMask', array(
        'element' => '.numbersOnly',
        'config' => array(
            'defaultZero' => true,
            'allowZero' => true,
            'decimal' => ',',
            'thousands' => '',
            'precision' => 0,
        )
    ));
    ?>

    <?php
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
    $idMutasi = $model->mutasibrg_id;
    $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/&id=${idMutasi}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
    ?>

    <script type="text/javascript">
        $(document).ready(function () {
<?php
if (isset($model->mutasibrg_id)) {
    ?>
                var params = [];
                params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id'] ?>, judulnotifikasi: 'Mutasi Barang', isinotifikasi: 'Mutasi barang dari <?php echo Yii::app()->user->getState("ruangan_nama"); ?> ke <?php echo $model->ruangantujuan->ruangan_nama ?>'}; // 16 
                insert_notifikasi(params);
    <?php
}
?>
        });
    </script>