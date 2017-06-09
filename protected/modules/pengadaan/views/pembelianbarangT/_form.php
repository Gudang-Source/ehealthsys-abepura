<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<fieldset>
    <?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'gupembelianbarang-t-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
        'focus' => '#',
    ));
    ?>
    <?php
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        Yii::app()->user->setFlash("success", "Tansaksi Permintaan Pembelian barang berhasil disimpan!");
    }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

    <?php echo $form->errorSummary($model); ?>
    <table width="100%">
		<tr>
			<td>
				<div class="control-group ">
                        <?php 
						echo $form->label($renc, 'renkebbarang_no', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'renkebbarang_id'); ?>
                        <!--                <div class="input-append" style='display:inline'>-->
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $renc,
                            'attribute' => 'renkebbarang_no',
                            'source' => 'js: function(request, response) {
                                           $.ajax({
                                               url: "' . $this->createUrl("autoCompleteRencana"). '",
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
                                                                        $("#' . Chtml::activeId($model, 'renkebbarang_id') . '").val(ui.item.value); 
																		loadRencana(ui.item.value);
                                                                        return false;
                                                                    }',
                            ),
                            'htmlOptions' => array(
                                'class' => 'namaPegawai alphanumeric-only',
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'placeholder' => 'Ketikan nomor Rencana Pembelian Barang',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogRencana'),
                        ));
                        ?>
                        <?php echo $form->error($model, 'peg_pemesanan_id'); ?>
                    </div>
                </div>
			</td>
			<td>
				<div class="control-group">
					<?php echo $form->label($renc, 'renkebbarang_tgl', array('class' => 'control-label')); ?>
					<div class="controls">
						<?php echo $form->textField($renc, 'renkebbarang_tgl', array('readonly' => TRUE)); ?>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="3"><hr/></td>
		</tr>
        <tr>
            <td>
                <?php //echo $form->textFieldRow($model,'terimapersediaan_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->dropDownListRow($model, 'sumberdana_id', CHtml::listData(SumberdanaM::model()->findAll('sumberdana_aktif = true ORDER BY sumberdana_nama'), 'sumberdana_id', 'sumberdana_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->dropDownListRow($model, 'supplier_id', CHtml::listData(SupplierM::model()->findAll('supplier_aktif = true ORDER BY supplier_nama'), 'supplier_id', 'supplier_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php //echo $form->textFieldRow($model,'tglpembelian',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  ?>
                    <?php echo $form->textFieldRow($model, 'nopembelian', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            </td>
            <td>
                <div class="control-group ">
                        <?php echo $form->labelEx($model, 'tglpembelian', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglpembelian',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                        ));
                        ?>
                        <?php echo $form->error($model, 'tglpembelian'); ?>
                    </div>
                </div>
                <div class="control-group ">
                        <?php echo $form->labelEx($model, 'tgldikirim', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgldikirim',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'minDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                        ));
                        ?>
                        <?php echo $form->error($model, 'tgldikirim'); ?>
                    </div>
                </div>
                <div class="control-group ">
                        <?php echo $form->labelEx($model, 'peg_pemesanan_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'peg_pemesanan_id'); ?>
                        <?php echo $form->textField($model, 'peg_pemesan_nama', array('class'=>'span3', 'readonly'=>TRUE)); ?>
                        <!--                <div class="input-append" style='display:inline'>-->
                        <?php
                        /*$this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'peg_pemesan_nama',
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
                                                                        $("#' . Chtml::activeId($model, 'peg_pemesanan_id') . '").val(pegawai_id); 
                                                                        return false;
                                                                    }',
                            ),
                            'htmlOptions' => array(
                                'class' => 'namaPegawai',
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'placeholder' => 'Ketikan nama pegawai pemesanan',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPegawai', 'jsFunction' => 'openDialog("' . Chtml::activeId($model, 'peg_pemesanan_id') . '");'),
                        ));*/
                        ?>
                        <?php echo $form->error($model, 'peg_pemesanan_id'); ?>
                    </div>
                </div>
            </td>
            <td>
                <div class="control-group ">
                        <?php echo Chtml::label("Pegawai Mengetahui <font style='color:red'>*</font>", 'peg_mengetahui_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'peg_mengetahui_id'); ?>
                        <!--                <div class="input-append" style='display:inline'>-->
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'peg_mengetahui_nama',
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
                                                                        $("#' . Chtml::activeId($model, 'peg_mengetahui_id') . '").val(pegawai_id); 
                                                                        return false;
                                                                    }',
                            ),
                            'htmlOptions' => array(
                                'class' => 'namaPegawai required hurufs-only',
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'placeholder' => 'Ketikan nama pegawai mengetahui',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPegawai', 'jsFunction' => 'openDialog("' . Chtml::activeId($model, 'peg_mengetahui_id') . '");'),
                        ));
                        ?>
                        <?php echo $form->error($model, 'peg_mengetahui_id'); ?>
                    </div>
                </div>
                <div class="control-group ">
                        <?php echo Chtml::label("Pegawai Menyetujui <font style='color:red'>*</font>", 'peg_menyetujui_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'peg_menyetujui_id'); ?>
                        <!--                <div class="input-append" style='display:inline'>-->
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'peg_menyetujui_nama',
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
                                                                        $("#' . Chtml::activeId($model, 'peg_menyetujui_id') . '").val(pegawai_id); 
                                                                        return false;
                                                                    }',
                            ),
                            'htmlOptions' => array(
                                'class' => 'namaPegawai required hurufs-only',
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'placeholder' => 'Ketikan nama pegawai menyetujui',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPegawai', 'jsFunction' => 'openDialog("' . Chtml::activeId($model, 'peg_menyetujui_id') . '");'),
                        ));
                        ?>
                        <?php echo $form->error($model, 'peg_menyetujui_id'); ?>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    <?php //echo $form->textFieldRow($model,'tgldikirim',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <?php //echo $form->textFieldRow($model,'peg_pemesanan_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <?php //echo $form->textFieldRow($model,'peg_mengetahui_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <?php //echo $form->textFieldRow($model,'peg_menyetujui_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <?php //echo $form->textFieldRow($model,'create_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <?php //echo $form->textFieldRow($model,'update_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <?php //echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <?php //echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  ?>
    <?php //echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <div class="block-tabel">
        <h6>Tabel <b>Permintaan Pembelian Barang</b></h6>
        <?php
            if (isset($modDetails)) {
                echo $form->errorSummary($modDetails);
            }
        ?>
        <?php $this->renderPartial($this->path_view.'_formDetailBarang', array('model' => $model, 'form' => $form)); ?>
        <?php $this->renderPartial($this->path_view.'_tableDetailBarang', array('model' => $model, 'form' => $form, 'modDetails' => $modDetails)); ?>
    </div>
    <div class="form-actions">
        <?php
			if(isset($_GET['sukses'])){
				echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','disabled'=>true));
			}else{
				echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','disabled'=>false));
			}
        ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->module->id . '/Index'), array('class' => 'btn btn-danger',
            'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('Index') . '";} ); return false;'));
        ?>
		<?php
			if(isset($_GET['sukses'])){
				echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')",'disabled'=>false));
			}else{
				echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','disabled'=>true));
			}
		?>
        <?php
        $content = $this->renderPartial('pengadaan.views.tips/transaksi4', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>
</fieldset>

<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari Rencana Pembelian Barang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogRencana',
    'options' => array(
        'title' => 'Daftar Rencana Pembelian Barang',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

$modrencana=new ADInformasirenkebbarangV;
$format = new MyFormatter();


if(isset($_GET['ADInformasirenkebbarangV'])){
	$modrencana->attributes=$_GET['ADInformasirenkebbarangV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'rencana-m-grid',
    'dataProvider' => $modrencana->searchInformasiDialog(),
    'filter' => $modrencana,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns' => array(
        ////'pegawai_id',
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectBahan",
                                    "onClick" => "
									loadRencana(".$data->renkebbarang_id.");
									$(\"#dialogRencana\").dialog(\"close\");
                                    return false;"))',
        ),
        array(
			'header'=>'Tanggal Rencana',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->renkebbarang_tgl)',
                         'filter'=>$this->widget('MyDateTimePicker', array(
                                'model'=>$modrencana, 
                                'attribute'=>'renkebbarang_tgl', 
                                'mode' => 'date',    
                                //'language' => 'ja',
                                // 'i18nScriptFile' => 'jquery.ui.datepicker-ja.js', (#2)
                                'htmlOptions' => array(
                                    'id' => 'datepicker_for_due_date',
                                    'size' => '10',
                                    'style'=>'width:80%'
                                ),
                                'options' => array(  // (#3)                    
                                    'dateFormat' => Params::DATE_FORMAT,                    
                                    'maxDate' => 'd',
                                ),                              
                            ), 
                            true),
		),
                array(
                    'header' => 'No Rencana',
                    'name' => 'renkebbarang_no',
                    'filter' => Chtml::activeTextField($modrencana, 'renkebbarang_no', array('class' => 'alphanumeric-only'))
                ),		
                array(
                    'header' => 'Recomended Order(RO)',
                    'name' => 'ro_barang_bulan',
                    'filter' => Chtml::activeTextField($modrencana, 'ro_barang_bulan', array('class' => 'numbers-only'))
                ),		
		array(
			'header'=>'Pegawai Mengetahui',
			'type'=>'raw',
			'value'=>'ADInformasirenkebbarangV::pegawaimengetahui($data->pegmengetahui_id)',
		),
		array(
			'header'=>'Pegawai Menyetujui',
			'type'=>'raw',
			'value'=>'ADInformasirenkebbarangV::pegawaimengetahui($data->pegmenyetujui_id)',
		),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
    . 'reinstallDatePicker();'
    . '$(".alphanumeric-only").keyup(function() {
        setAlphaNumericOnly(this);
        });
        $(".numbers-only").keyup(function() {
        setNumbersOnly(this);
        });
    }',
));

$this->endWidget();
Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {        
    $('#datepicker_for_due_date').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['id'],{'dateFormat':'".Params::DATE_FORMAT."','changeMonth':true, 'changeYear':true,'maxDate':'d'}));
}
");
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

$modPegawai = new PegawairuanganV('search');
$modPegawai->unsetAttributes();
$modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
//$modPegawai->ruangan_id = 0;
if (isset($_GET['PegawairuanganV'])){
    $modPegawai->attributes = $_GET['PegawairuanganV'];
    $modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-m-grid',
    'dataProvider' => $modPegawai->search(),
    'filter' => $modPegawai,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns' => array(
        ////'pegawai_id',
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectBahan",
                                    "onClick" => "
                                    var parent = $(\"#dialogPegawai\").attr(\"parentclick\");
                                    $(\"#\"+parent+\"\").val($data->pegawai_id);
                                    $(\"#\"+parent+\"\").parents(\".controls\").find(\".namaPegawai\").val(\"$data->nama_pegawai\");
                                    $(\'#dialogPegawai\').dialog(\'close\');
                                    return false;"))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => Chtml::activeTextField($modPegawai, 'nomorindukpegawai', array('class'=>'numbers-only'))
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'filter' => Chtml::activeTextField($modPegawai, 'nama_pegawai', array('class'=>'hurufs-only'))
        ),             
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function ($data){
                $p = JabatanM::model()->findByPk($data->jabatan_id);
                
                if (count($p)>0){
                    return $p->jabatan_nama;
                }else{
                    return '-';
                }
            },
            'filter' => Chtml::activeDropDownList($modPegawai, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"),'jabatan_id','jabatan_nama') ,array('empty'=>'-- Pilih --'))
        ),  
        
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
    . '$(".numbers-only").keyup(function() {
        setNumbersOnly(this);
        });
        $(".hurufs-only").keyup(function() {
        setHurufsOnly(this);
        });'
    . '}',
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

<script type="text/javascript">
	
function hitungTotal(obj)
{
    var satuan = parseFloat(unformatNumber($(obj).parents("tr").find(".satuan").val()));
    var jml = parseFloat(unformatNumber($(obj).parents("tr").find(".qty").val()));
    
    $(obj).parents("tr").find(".beli").val(formatNumber(satuan * jml));
}

function loadRencana(id)
{
	$.post('<?php echo $this->createUrl("loadRencana") ?>', {
		id: id,
	}, function(data) {
		$("#ADPembelianbarangT_renkebbarang_id").val(data.rencana.renkebbarang_id);
		$("#RenkebbarangT_renkebbarang_no").val(data.rencana.renkebbarang_no);
		$("#RenkebbarangT_renkebbarang_tgl").val(data.rencana.renkebbarang_tgl);
		
		$("#tableDetailBarang tbody").html(data.html);
		$("#tableDetailBarang tbody .numbersOnly").maskMoney(
			{"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0}
		);
		$("#tableDetailBarang tbody .integer2").maskMoney(
			{"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
		);
		rename();
		clear();
	}, "json");
}
        
function print(caraPrint)
{
    var id = '<?php echo (!empty($model->pembelianbarang_id)) ? $model->pembelianbarang_id : null; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&id='+id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

    $(document).ready(function () {
<?php
if (isset($model->pembelianbarang_id)) {
    ?>
            var params = [];
            params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_AKUNTANSI ?>, judulnotifikasi: 'Permintaan Pembelian Barang', isinotifikasi: 'Telah dilakukan permintaan pembelian barang dengan <?php echo $model->nopembelian ?> pada <?php echo $model->tglpembelian ?>'}; // 16 
            insert_notifikasi(params);
    <?php
}
?>
    });
</script>