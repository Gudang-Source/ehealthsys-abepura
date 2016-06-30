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
    if (isset($_GET['id'])) {
        $this->renderPartial('gudangUmum.views.mutasibrgT._dataPesan', array('modPesan' => $modPesan));
    }
    ?>
    <fieldset class="box">
        <p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
        <legend class="rim">Data Mutasi Barang</legend>
<!--awal pemesanan-->
<?php if (!isset($_GET['id'])){ ?>
<div class="row-fluid">
    <div class = "span4">
        <div class="control-group ">
            <?php echo CHtml::label("No Pemesanan ", 'nopemesanan', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model'=>$modPesan,
                    'attribute' => 'nopemesanan',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('AutocompleteNoPemesanan') . '",
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
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                            $(this).val( ui.item.label);
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            $("#'.CHtml::activeId($modPesan, 'nopemesanan') . '").val(ui.item.nopemesanan);
                            $("#'.CHtml::activeId($modPesan, 'tglpesanbarang') . '").val(ui.item.tglpesanbarang);
                            $("#'.CHtml::activeId($modPesan, 'ruanganpemesan_id') . '").val(ui.item.ruanganpemesan_id);
                            $("#'.CHtml::activeId($modPesan, 'ruanganpemesan_nama') . '").val(ui.item.ruanganpemesan_nama);
                            $("#'.CHtml::activeId($modPesan, 'pegpemesan_id') . '").val(ui.item.pegpemesan_id);
                            $("#'.CHtml::activeId($modPesan, 'pegpemesan_nama') . '").val(ui.item.pegpemesan_nama);
                            $("#'.CHtml::activeId($model, 'pesanbarang_id') . '").val(ui.item.pesanbarang_id);
                            listRuangan(ui.item.instalasi_id, ui.item.ruanganpemesan_id);
                            submitMutasi();                                    
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'class'=>'nopsn',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#'.CHtml::activeId($modPesan, 'nopemesanan') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPemesanan'),
                ));
                ?>
                <?php //echo $form->hiddenField($modPemesanan, 'nopemesanan',array('readonly'=>true)); ?>

            </div>
        </div>

    </div>

    <div class="span4">
        <div class = "control-group">
            <?php echo CHtml::label("Tanggal Pesan Barang", 'tglpesanbarang', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($modPesan, 'tglpesanbarang',array('readonly'=>true, 'class'=>'span3')); ?>
            </div>
        </div>        
    </div>
    
    <div class = "span4">
        <?php echo $form->hiddenField($modPesan, 'ruanganpemesan_id',array('readonly'=>true)); ?>
        <?php echo $form->textFieldRow($modPesan, 'ruanganpemesan_nama',array('readonly'=>true)); ?>
        <?php echo $form->hiddenField($modPesan, 'pegpemesan_id',array('readonly'=>true)); ?>
        <?php echo $form->textFieldRow($modPesan, 'pegpemesan_nama',array('readonly'=>true)); ?>
    </div>
</div>

<hr/>
<?php } ?>
<!--akhir pemesanan-->
        <table width="100%">
            <tr>
                <td>

                            <?php //echo $form->textFieldRow($model,'pesanbarang_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  ?>
                            <?php //echo $form->textFieldRow($model,'tglmutasibrg',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->hiddenField($model,'pesanbarang_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
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
                            <?php echo $form->textField($model, 'pegpengirim_nama', array('readonly'=>true)); ?>
                            <!--                <div class="input-append" style='display:inline'>-->
                            <?php
                           /* $this->widget('MyJuiAutoComplete', array(
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
                                    'placeholder' => 'Ketikan Nama Pegawai Pengirim', 
                                    'readony'=>true,
                                    'disable'=>true,
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogPegawai'),
                            ));*/
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
                            echo $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,
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
//========= Dialog buat cari data pemesanan barang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPemesanan',
    'options'=>array(
        'title'=>'Pencarian Data Pemesanan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPesann = new GUPesanbarangT('search');
$modPesann->unsetAttributes();
$modPesann->ruangantujuan_id = Yii::app()->user->getState('ruangan_id');
if(isset($_GET['GUPesanbarangT'])) {
    $modPesann->attributes = $_GET['GUPesanbarangT'];
    $modPesann->ruangantujuan_id = Yii::app()->user->getState('ruangan_id');
    $modPesann->ruanganpemesan_id = $_GET['GUPesanbarangT']['ruanganpemesan_id'];
    $modPesann->pegawaipemesan_id = $_GET['GUPesanbarangT']['pegpemesan_id'];
}
//$provider = $modPesann->searchPesanBarang();
//$provider->criteria->addCondition('mutasibrg_id is null');
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'nopemesanan-grid',
	'dataProvider'=>$modPesann->searchPesanBarang(),
	'filter'=>$modPesann,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small",
                                    "href"=>"",
                                    "id" => "selectNopemesanan",
                                    "onClick" => "$(\"#'.CHtml::activeId($modPesan,'nopemesanan').'\").val(\"$data->nopemesanan\");
                                                  $(\"#'.CHtml::activeId($modPesan,'tglpesanbarang').'\").val(\"".MyFormatter::formatDateTimeForUser($data->tglpesanbarang)."\");
                                                  $(\"#'.CHtml::activeId($modPesan,'ruanganpemesan_id').'\").val(\"".$data->ruanganpemesan_id."\");                                                  
                                                  $(\"#'.CHtml::activeId($modPesan,'pegpemesan_id').'\").val(\"$data->pegpemesan_id\");                                                  
                                                  $(\"#'.CHtml::activeId($model,'pesanbarang_id').'\").val(\"$data->pesanbarang_id\");
                                                  $(\"#'.CHtml::activeId($model,'instalasi_id').'\").val(\"$data->instalasi_id\");
                                                  $(\"#'.CHtml::activeId($model,'ruangantujuan_id').'\").val(\"$data->ruanganpemesan_id\");
                                                  listRuangan(\"$data->instalasi_id\",\"$data->ruanganpemesan_id\");
                                                  submitMutasi();                                                  
                                                  $(\"#dialogPemesanan\").dialog(\"close\");
                                                  return false;
                                        "))',
                ),
                array(
                  'name'=>'tglpesanbarang',
                  'value'=>'MyFormatter::formatDateTimeForUser($data->tglpesanbarang)',
                  'filter'=>false
                  ),
                'nopemesanan',
                array(
                  'header'=>'Ruangan Pemesan',
                  'name'=>'ruanganpemesan_id',
                  'value'=>'$data->ruanganpemesan->ruangan_nama',
                  'filter'=>CHtml::activeDropDownList($modPesann,'ruanganpemesan_id',CHtml::listData(RuanganM::model()->findAll(array('condition'=>'ruangan_aktif = true','order'=>'ruangan_nama')),'ruangan_id','ruangan_nama'),array('empty'=>'-- Pilih --','class'=>'ruanganPemesan'))
                ),
                array(
                  'name'=>'pegpemesan_id',
                  'value'=>'$data->pegawaipemesan->namaLengkap',
                  'filter'=>CHtml::activeDropDownList($modPesann,'pegpemesan_id',CHtml::listData(PegawaiM::model()->findAll(array('condition'=>'pegawai_aktif = true','order'=>'nama_pegawai')),'pegawai_id','namaLengkap'),array('empty'=>'-- Pilih --'))
                ),
                'keterangan_pesan'
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        ));
$this->endWidget();
//========= end pemesanan barang dialog =============================
?>
    <?php
//========= Dialog buat cari Bahan Diet =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogPegawaiMengetahui',
        'options' => array(
            'title' => 'Daftar Pegawai Mengetahui',
            'autoOpen' => false,
            'modal' => true,
            'width' => 750,
            'height' => 600,
            'resizable' => false,
        ),
    ));    
    $modPegawai = new GUPegawaiRuanganV('search');
    $modPegawai->unsetAttributes();    
    if (isset($_GET['GUPegawaiRuanganV']))
        $modPegawai->attributes = $_GET['GUPegawaiRuanganV'];        

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
               'nomorindukpegawai',
            'nama_pegawai',                   
            'alamat_pegawai',
            array(
                'name' => 'agama',
                'filter' => CHtml::dropDownList('GUPegawaiRuanganV[agama]',$modPegawai->agama,LookupM::getItems('agama'), array('empty'=>'--Pilih--')),
                'value' => '$data->agama',
            ),
            array(
                'name' => 'jeniskelamin',
                'filter' => CHtml::dropDownList('GUPegawaiRuanganV[jeniskelamin]',$modPegawai->jeniskelamin,LookupM::getItems('jeniskelamin'), array('empty'=>'--Pilih--')),
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
    $urlGetMutasi =  $this->createUrl('getPesanBarangDariMutasi');
    $js = <<< JSCRIPT
    function submitMutasi()
    {
        idPesanbarang = $('#GUMutasibrgT_pesanbarang_id').val();
            if(idPesanbarang==''){
                alert('Silahkan Pilih No.Pemesanan Terlebih Dahulu');
            }else{
                $("#tableDetailBarang tbody tr").remove();
                $.post("${urlGetMutasi}", { idPesanbarang: idPesanbarang },
                function(data){
                    //if (typeof data.stok == "undefined") {
                    //  myAlert(data.pesan);
                   //}
                    //else{
                    $('.labelTotal').html('Total');
                    $('#GUPesanbarangT_ruanganpemesan_nama').val(data.ruangan_nama);
                    $('#GUPesanbarangT_pegpemesan_nama').val(data.nama_pegawai);
                    $('#tableDetailBarang').append(data.tr);
                    $("#tableDetailBarang tbody tr:last .numbersOnly").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0,"symbol":null});
                    renameInputRowBarang($("#tableDetailBarang"));
                   // hitungTotal();                
                  //}
                }, "json");
            }

            instalasiId = $('#GUMutasibrgT_instalasi_id').val();

    }

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
        
        
    function renameInputRowBarang(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find("#no_urut").val(row+1);
        $(this).find('span').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
            }
        });
        $(this).find('input,select,textarea').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
            }
        });
        row++;
    });
    
}

    </script>
    <script>
function listRuangan(instalasi_id, ruangan_id)
{
	$.ajax({
		type:'POST',
		url:'<?php echo Yii::app()->createUrl('ActionDynamic/ListRuangan/'); ?>',
		data: {instalasi_id: instalasi_id, ruangan_id: ruangan_id},//
		dataType: "json",
		success:function(data){
			$('#GUMutasibrgT_ruangantujuan_id').html(data.listRuangan);
                        
                        $('#GUMutasibrgT_ruangantujuan_id').val(data.ruangan_id);
                        $('#GUMutasibrgT_instalasi_id').val(data.instalasi_id);
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});	
}
</script>
    