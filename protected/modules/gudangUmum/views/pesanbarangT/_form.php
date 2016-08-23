<div class="white-container">
    <legend class="rim2">Transaksi <b>Pemesanan Barang</b></legend>
    <?php
        $link_batal = Yii::app()->controller->id;
    ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'gupesanbarang-t-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
    )); ?> 
    <?php
    if(isset($_GET['id']) && !empty($_GET['id'])){
            Yii::app()->user->setFlash("success","Tansaksi Pemesanan barang berhasil disimpan!");
    }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php
    echo $form->errorSummary(array($model));
    ?>
    <p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
    <table width="100%">
        <tr>
            <td>  
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'tglpesanbarang', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglpesanbarang',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                        ));
                        ?>
                        <?php echo $form->error($model, 'tglpesanbarang'); ?>
                    </div>
                </div>
                <?php //echo $form->textFieldRow($model,'mutasibrg_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->hiddenField($model, 'nopemesanan', array('readonly'=>true,'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20,'readonly'=>true)); ?>
                <?php //echo $form->textFieldRow($model,'tglpesanbarang',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>            
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'tglmintadikirim', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglmintadikirim',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                // 'minDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                        ));
                        ?>
                        <?php echo $form->error($model, 'tglmintadikirim'); ?>
                    </div>
                </div>

                <?php //echo $form->textFieldRow($model,'tglmintadikirim',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  ?>
                <?php //echo $form->dropDownListRow($model,'ruanganpemesan_id', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true'), 'ruangan_id', 'ruangan_nama'),array('empty'=>'-- Pilih --', 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <div class="control-group ">
                    <?php echo CHtml::label('Ruangan Tujuan <font style="color:red;">*</font>', 'ruangantujuan_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array('autofocus'=>true, 'empty' => '-- Pilih --', 'class' => 'span2 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,
                            'ajax' => array('type' => 'POST',
                                'url' => $this->createUrl('SetDropdownRuangan',array('encode'=>false,'model_nama'=>get_class($model))),
                                'update' => '#' . CHtml::activeId($model, 'ruangantujuan_id') . ''),));
                        ?>
                        <?php echo $form->dropDownList($model, 'ruangantujuan_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array('instalasi_id'=>$model->instalasi_id,'ruangan_aktif'=>true), array('order'=>'ruangan_nama ASC')), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'required span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'onchange' => 'refreshDialogBarang();')); ?>
                        <?php echo $form->hiddenField($model, 'ruanganpemesan_id', array('readonly'=>true)); ?>
                        <?php echo $form->error($model, 'ruanganpemesan_id'); ?>
                    </div>
                </div>
            </td>
            <td>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'pegpemesan_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'pegpemesan_id'); ?>
                        <?php echo $form->textField($model, 'pegpemesan_nama', array('readonly'=>true)); ?>
                        <!--                <div class="input-append" style='display:inline'>-->
                        <?php
                       /* $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'pegpemesan_nama',
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
                                                                        $("#' . Chtml::activeId($model, 'pegpemesan_id') . '").val(ui.item.pegawai_id); 
                                                                        return false;
                                                                    }',
                            ),
                            'htmlOptions' => array(
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'class' => 'span3',
								'placeholder'=>'Ketikan nama pegawai pemesan',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPegawai'),
                        ));*/
                        ?>
                        <?php echo $form->error($model, 'pegpemesan_id'); ?>
                    </div>
                </div>
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
                                                                        $("#' . Chtml::activeId($model, 'pegmengetahui_id') . '").val(ui.item.pegawai_id); 
                                                                        return false;
                                                                    }',
                            ),
                            'htmlOptions' => array(
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'class' => 'span3',
								'placeholder'=>'Ketikan nama pegawai mengetahui',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
                        ));
                        ?>

                    </div>
                </div>
            </td>
            <td>
                <?php //echo $form->textFieldRow($model,'pegpemesan_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textAreaRow($model, 'keterangan_pesan', array('placeholder'=>'Keterangan Pemesanan Barang','rows' => 4, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder'=>'Keterangan Pemesanan Barang')); ?>
                <?php //echo $form->textFieldRow($model,'pegmengetahui_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textFieldRow($model,'create_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textFieldRow($model,'update_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  ?>
                <?php //echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  ?>
            </td>
        </tr>
    </table>
    <?php 
        /**
        Diupdate oleh     : David Yanuar
        Tgl. update        : 15 April 2014
        Fungsi            : Memberikan efek detail panel ("well")
        */
     ?>   
    <fieldset class="box row-fluid">
        <legend class="rim">Rincian Barang</legend>
        <?php $this->renderPartial('gudangUmum.views.pesanbarangT._formDetailBarang', array('model' => $model, 'form' => $form, 'modDetail' => $modDetail)); ?>      
        <?php $this->renderPartial('gudangUmum.views.pesanbarangT._tableDetailBarang', array('model' => $model, 'form' => $form, 'modDetail' => $modDetail)); ?>
    </fieldset>
    <?php 
        /**
        Akhir perubahan efek detail panel well
        */
    ?>
    <div class="form-actions">
        
        
            <?php
			if(isset($_GET['sukses'])){
				echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','disabled'=>true));
			}else{
				echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','disabled'=>false));
			}
			?>          
            <?php //if ($model->isNewRecord) {
             echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                $this->createUrl($this->id.'/index'), 
                                array('class'=>'btn btn-danger',
//                                      'onclick'=>'if(!confirm("Apakah anda ingin mengulang ini ?")) return false;'));
                                      'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "'.$this->createUrl($this->id.'/index').'";}); return false;'));
            ?>
        <?php //} ?>
		<?php
			if(isset($_GET['sukses'])){
				echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')",'disabled'=>false));
			}else{
				echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','disabled'=>true));
			}
		?>
        <?php
            $content = $this->renderPartial('gudangUmum.views.pesanbarangT.tips.transaksi2',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
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
            'resizable' => false,
        ),
    ));

    $modPegawai = new GUPegawaiRuanganV('search');
    $modPegawai->unsetAttributes();
    //$modPegawai->ruangan_id = 0;
    if (isset($_GET['GUPegawaiRuanganV']))
        $modPegawai->attributes = $_GET['GUPegawaiRuanganV'];

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'pegawai-m-grid',
        'dataProvider' => $modPegawai->searchDialog(),
        'filter' => $modPegawai,
       // 'template' => "{items}\n{pager}",
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
            'agama',
            array(
                'name' => 'jeniskelamin',
                'filter' => CHtml::dropDownList('GUPegawaiM[jeniskelamin]',$modPegawai->jeniskelamin,LookupM::getItems('jeniskelamin'),array('empty'=>'--Pilih--')),
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
            'title' => 'Daftar Pegawai Mengetahui',
            'autoOpen' => false,
            'modal' => true,
            'width' => 750,
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
        //'template' => "{items}\n{pager}",
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
                                        $(\'#' . Chtml::activeId($model, 'pegpemesan_nama') . '\').val(\'$data->nama_pegawai\');
                                        $(\'#' . Chtml::activeId($model, 'pegpemesan_id') . '\').val(\'$data->pegawai_id\');
                                        $(\'#dialogPegawai\').dialog(\'close\');
                                        return false;"))',
            ),
            'nama_pegawai',
            'nomorindukpegawai',
            'alamat_pegawai',
            'agama',
            array(
                'name' => 'jeniskelamin',
                'filter' => CHtml::dropDownList('GUPegawaiM[jeniskelamin]',$modPegawai->jeniskelamin,LookupM::getItems('jeniskelamin'),array('empty'=>'--Pilih--')),
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
    $idPesan = $model->pesanbarang_id;
    $js = <<< JSCRIPT
    function print(caraPrint)
    {
        window.open("${urlPrint}/&id=${idPesan}&caraPrint="+caraPrint,"",'location=_new, width=900px');
    }
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>
</div>
<script type="text/javascript">
function print(caraPrint)
{
    var pesanbarang_id = '<?php echo (!empty($model->pesanbarang_id)) ? $model->pesanbarang_id : null; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&id='+pesanbarang_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}
    $(document).ready(function(){
        <?php 
            if(isset($model->pesanbarang_id)){
        ?>
            var params = [];
            params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_GUDANGUMUM; ?>, judulnotifikasi:'Pesan Barang', isinotifikasi:'Pemesanan barang dari <?php echo Yii::app()->user->getState("ruangan_nama"); ?> ke <?php echo $model->ruanganpemesan->ruangan_nama ?>'}; // 16 
            insert_notifikasi(params);
        <?php } ?>
            
             refreshDialogBarang();
    })
    
function refreshDialogBarang(){    
	$("#namaBarang").addClass("animation-loading-1");
        var ru = $("#GUPesanbarangT_ruangantujuan_id option:selected").html();
       
	setTimeout(function(){
                $("#dialog_ruangan").html(ru);
		$("#namaBarang").removeClass("animation-loading-1");
	},500);
}


$('#tombolDialogBarang').click(function(){
        refreshDialogBarang();
	var ruangan_id = $('#<?php echo CHtml::activeId($model,"ruangantujuan_id") ?>').val();
        //alert(ruangan_id);
        $(".dialog_ruangan_id").val(ruangan_id);
	$.fn.yiiGridView.update('barang-m-grid', {
		data: {
			"GUInformasistokbarangV[ruangan_id]":ruangan_id,
		}
	});
});


</script>