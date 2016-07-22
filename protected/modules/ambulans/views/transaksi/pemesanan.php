<div class="white-container">
    <legend class="rim2">Pemesanan <b>Ambulans Pasien Luar</b></legend>
    <?php
    $sukses = null;
    if(isset($_GET['sukses'])){
        $sukses = $_GET['sukses'];
    }
    if($sukses > 0) 
        Yii::app()->user->setFlash('success',"Transaksi Pemesanan Ambulans Pasien Luar berhasil disimpan !");

    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
        'id'=>'pesanambulans-t-form',
        'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#'.CHtml::activeId($modPemesanan,'norekammedis'),
    )); ?>

    <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

    <?php //echo $form->errorSummary($modPemesanan); ?>

    <?php echo CHtml::activeHiddenField($modPemesanan,'pasien_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <?php echo CHtml::activeHiddenField($modPemesanan,'pendaftaran_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <table>
        <tr>
            <td>
               
                <?php //echo $form->textFieldRow($modPemesanan,'rt_rw',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
               
            </td>
            <td>
			
                
            </td>
        </tr>
    </table>
    <div class="row-fluid">
        <div class="span4">
            <div class="control-group ">
                <?php echo CHtml::label('No. Rekam Medis', 'no_rekam_medis', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $modPemesanan,
                        'attribute' => 'norekammedis',
                        'value' => '',
                        'sourceUrl' => $this->createUrl('AutocompletePasienLama'),
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 2,
                            'focus' => 'js:function( event, ui ) {
                                    $(this).val( ui.item.label);
                                    return false;
                                }',
                                'select' => 'js:function( event, ui ) {
                                    $("#' . CHtml::activeId($modPemesanan, 'pasien_id') . '").val(ui.item.pasien_id);
                                    $("#' . CHtml::activeId($modPemesanan, 'namapasien') . '").val(ui.item.nama_pasien);
                                    $("#' . CHtml::activeId($modPemesanan, 'pendaftaran_id') . '").val(ui.item.pendaftaran_id);
                            }',
                        ), 
                        'tombolDialog'=>array('idDialog'=>'dialogPasien'),
                        'htmlOptions'=>array(
                            'class'=>'span3',
                            'placeholder'=>'Ketikan No. Rekam Medis',
                            'onkeypress'=>"return $(this).focusNextInputField(event);"
                        ),
                    ));
                    ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label($modPemesanan->getAttributeLabel('namapasien')." <span class='required'>*</span>", 'namapasien', array('class'=>'control-label required'))?>
                <div class="controls">
                    <?php echo $form->textField($modPemesanan,'namapasien',array('class'=>'span3 reqPasien', 'onchange'=>'clearDataPasien();' ,'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($modPemesanan,'tglpemesananambulans', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php
                    $modPemesanan->tglpemesananambulans = (!empty($modPemesanan->tglpemesananambulans) ? date("d/m/Y H:i:s",strtotime($modPemesanan->tglpemesananambulans)) : null);
                    $this->widget('MyDateTimePicker',array(
                            'model'=>$modPemesanan,
                            'attribute'=>'tglpemesananambulans',
                            'mode'=>'datetime',
                            'options'=> array(
                                'showOn' => false,
                                'maxDate' => 'd',
                            ),
                        'htmlOptions'=>array('class'=>'dtPicker3 datetimemask','placeholder'=>'00:00:0000 00:00:00', 'onkeyup'=>"return $(this).focusNextInputField(event)",),
                    )); ?>
                    <?php echo $form->error($modPemesanan, 'tglpemesananambulans'); ?>
                </div>
            </div>
            <?php if (isset($modPemesanan->pesanambulans_no)){ ?>
            <?php echo $form->textFieldRow($modPemesanan,'pesanambulans_no',array('class'=>'span3 reqPasien', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
            <?php } ?>
            <div class="control-group ">
                <?php echo CHtml::activeLabel($modPemesanan, 'tempat tujuan', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modPemesanan,'tempattujuan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::activeLabel($modPemesanan, 'kelurahan_nama', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modPemesanan,'kelurahan_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                </div>
            </div>

        </div>
        <div class="span4">
            <div class="control-group ">
                <?php echo CHtml::activeLabel($modPemesanan, 'alamat tujuan', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textArea($modPemesanan,'alamattujuan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('RT / RW','rt', array('class'=>'control-label inline')) ?>
                <div class="controls">
                    <?php echo $form->textField($modPemesanan,'rt', array('onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 numbers-only','maxlength'=>3,'placeholder'=>'RT')); ?>   / 
                    <?php echo $form->textField($modPemesanan,'rw', array('onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 numbers-only','maxlength'=>3,'placeholder'=>'RW')); ?>            
                    <?php echo $form->error($modPemesanan, 'rt'); ?>
                    <?php echo $form->error($modPemesanan, 'rw'); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('No. Handphone', 'no_mobile', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modPemesanan,'nomobile',array('class'=>'span3 numbers-only', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('No. Telepon', 'no telepon', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modPemesanan,'notelepon',array('class'=>'span3 numbers-only', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                </div>
            </div>
             <div class="control-group ">
                <?php echo CHtml::activeLabel($modPemesanan, 'Tanggal Pemakaian Ambulans', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php   
                        $modPemesanan->tglpemakaianambulans = (!empty($modPemesanan->tglpemakaianambulans) ? date("d/m/Y H:i:s",strtotime($modPemesanan->tglpemakaianambulans)) : null);
                        $this->widget('MyDateTimePicker',array(
							'model'=>$modPemesanan,
							'attribute'=>'tglpemakaianambulans',
							'mode'=>'datetime',
							'options'=> array(
								'showOn' => false,
								'maxDate' => 'd',
							),
							'htmlOptions'=>array('placeholder'=>'00:00:0000 00:00:00','class'=>'dtPicker3 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)",),
                    )); ?>
                    <?php echo $form->error($modPemesanan, 'tglpemakaianambulans'); ?>
                </div>
            </div>
        </div>
        <div class="span4">
           
            <div class="control-group ">
                <?php echo CHtml::activeLabel($modPemesanan, 'untuk keperluan', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textArea($modPemesanan,'untukkeperluan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::activeLabel($modPemesanan, 'keterangan pesan', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textArea($modPemesanan,'keteranganpesan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label($modPemesanan->getAttributeLabel('Ruangan')." <span class='required'>*</span>", 'Ruangan', array('class'=>'control-label required'))?>
                <div class="controls">
                    <?php echo CHtml::dropDownList('instalasi', Params::INSTALASI_ID_AMBULAN, $instalasiTujuans,
                                                    array('empty' =>'-- Pilih --','class'=>'reqPasien','onkeypress'=>"return $(this).focusNextInputField(event);",
                                                          'ajax'=>array('type'=>'POST',
                                                                        'url'=>  CController::createUrl('dynamicRuangan'),
                                                                        'update'=>'#AMPesanambulansT_ruangan_id',),'class'=>'span2')); ?>
                    <?php echo CHtml::activeDropDownList($modPemesanan, 'ruangan_id', $ruanganTujuans,array('class'=>'span2 reqPasien','onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions">
		<?php 
			$disableSave = false;
			$disableSave = (!empty($_GET['sukses'])) ? true : false; 
		?>
		<?php $disablePrint = ($disableSave) ? false : true; ?>
		<?php echo CHtml::htmlButton($modPemesanan->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
				Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
				array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','disabled'=>$disableSave,)); ?>
		<?php
			echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue', 'disabled'=>$disablePrint,'type'=>'button','onclick'=>'print(\'PRINT\')'));                 
		?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl($this->module->id.'/pemesanan'), 
				array('class'=>'btn btn-danger',
				'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('pemesanan').'";} ); return false;'))."&nbsp;";  ?>		
		<?php  $content = $this->renderPartial('ambulans.views.tips.transaksi_ambulans',array(),true);
				$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>
<?php $this->renderPartial($this->path_view.'_jsFunctions',array('modPemesanan'=>$modPemesanan)); ?>
<?php
//========= Dialog buat cari data obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Pencarian Data Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'resizable' => false,
    ),
));

$modPasien = new AMPasienM('searchPasien');
$modPasien->unsetAttributes();
if (isset($_GET['AMPasienM'])) {
    $modPasien->attributes = $_GET['AMPasienM'];
}

echo "<legend class=rim> Tabel Data Pasien</legend>";
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasien-m-grid',
    'dataProvider' => $modPasien->searchPasien(),
    'filter' => $modPasien,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectPasien",
				"onClick" => "$(\"#AMPesanambulansT_norekammedis\").val(\"$data->no_rekam_medik\");
							  $(\"#AMPesanambulansT_namapasien\").val(\"$data->nama_pasien\");
							  $(\"#AMPesanambulansT_alamattujuan\").val(\"$data->alamat_pasien\");
							  $(\"#AMPesanambulansT_nomobile\").val(\"$data->no_mobile_pasien\");
							  $(\"#AMPesanambulansT_notelepon\").val(\"$data->no_telepon_pasien\");
							  $(\"#AMPesanambulansT_pasien_id\").val(\"$data->pasien_id\");
							  $(\"#dialogPasien\").dialog(\"close\");    
					"))',
        ),
        'no_rekam_medik',
        'nama_pasien',
        'alamat_pasien',
        'no_mobile_pasien'       
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end obatAlkes dialog =============================
?>