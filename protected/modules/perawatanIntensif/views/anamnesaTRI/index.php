<?php
//komen buat ngepull
$this->breadcrumbs = array(
    'Anamnesa',
);
if(isset($_GET['sukses'])){
    Yii::app()->user->setFlash('success',"Data anamnesa berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert');
//$this->renderPartial('/_ringkasDataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modAdmisi'=>$modAdmisi));
//echo '<legend class="rim">ANAMNESIS</legend><hr>';
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjanamnesa-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#RIAnamnesaT_keluhanutama_annoninput .maininput',
        ));
?>

<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
<?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
            'id'=>'tabel-riwayatanamnesa',
            'content'=>array(
                'content-detailanamnesa'=>array(
                    'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan Riwayat Anamnesa')).'<b> Tabel Riwayat Anamnesa</b>',
                    'isi'=>$this->renderPartial('_tabelRiwayatAnamnesa',array(
                            'tabelAnamnesa'=>$tabelAnamnesa,
                            'format'=>$format,
                            ),true),
                    'active'=>true,
                    ),   
                ),
)); ?>  
<?php echo $form->errorSummary($modAnamnesa); ?>
<table class="table-condensed">
    <tr>
        <td width="550px">
            <?php echo CHtml::hiddenField('url', $this->createUrl('', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)), array('readonly' => TRUE)); ?>
            <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
            <?php echo $form->dropDownListRow($modAnamnesa, 'pegawai_id', CHtml::listData($modAnamnesa->getDokterItems(), 'pegawai_id', 'NamaLengkap'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",)); ?>
            <?php //echo $form->dropDownListRow($modAnamnesa, 'paramedis_nama', CHtml::listData(ParamedisV::model()->findAll("ruangan_id = ".Yii::app()->user->getState('ruangan_id')), 'nama_pegawai', 'NamaLengkap'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>                        
            <?php //echo $form->dropDownListRow($modAnamnesa,'paramedis_nama', CHtml::listData($modAnamnesa->ParamedisItems, 'pegawai.NamaLengkap', 'pegawai.nama_pegawai'),array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            <?php echo $form->dropDownListRow($modAnamnesa,'paramedis_nama', CHtml::listData($modAnamnesa->getParamedisItems(), 'pegawai.NamaLengkap', 'pegawai.nama_pegawai'),array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
	    <?php //echo $form->textAreaRow($modAnamnesa, 'keluhanutama', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
           
            <div class="control-group ">
                <?php echo $form->labelEx($modAnamnesa, 'keluhanutama', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                        $this->widget('application.extensions.FCBKcomplete.FCBKcomplete',array(
                            'model'=>$modAnamnesa,
                            'attribute'=>'keluhanutama',
                            'data'=> explode(',', $modAnamnesa->keluhanutama),   
                            'debugMode'=>true,
                            'options'=>array(
                                //'bricket'=>false,
//                                'json_url'=>$this->createUrl('//actionAjax/MasterKeluhan'),
                                'addontab'=> true, 
                                'maxitems'=> 10,
                                'input_min_size'=> 0,
                                'cache'=> true,
                                'newel'=> true,
                                'addoncomma'=>true,
                                'select_all_text'=> "", 
                            ),
                        ));
                    ?>
                    <?php echo $form->error($modAnamnesa, 'keluhanutama'); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($modAnamnesa, 'keluhantambahan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                        $this->widget('application.extensions.FCBKcomplete.FCBKcomplete',array(
                            'model'=>$modAnamnesa,
                            'attribute'=>'keluhantambahan',
                            'data'=> explode(',', $modAnamnesa->keluhantambahan),   
                            'debugMode'=>true,
                            'options'=>array(
                                //'bricket'=>false,
//                                'json_url'=>$this->createUrl('//actionAjax/MasterKeluhan'),
                                'addontab'=> true, 
                                'maxitems'=> 10,
                                'input_min_size'=> 0,
                                'cache'=> true,
                                'newel'=> true,
                                'addoncomma'=>true,
                                'select_all_text'=> "", 
                            ),
                        ));
                    ?>
                    <?php echo $form->error($modAnamnesa, 'keluhantambahan'); ?>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label" for="RJAnamnesaT_riwayatperjalananpasien">Riwayat Perjalanan Penyakit Pasien</label>
                <div class="controls">
                    <?php echo $form->textArea($modAnamnesa, 'riwayatperjalananpasien', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        
                    <?php echo $form->error($modAnamnesa, 'riwayatperjalananpasien'); ?>
                </div>
            </div>
             <?php echo $form->textFieldRow($modAnamnesa, 'lamasakit', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
            <div class="control-group ">
                <?php echo $form->labelEx($modAnamnesa, 'riwayatpenyakitterdahulu', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textArea($modAnamnesa, 'riwayatpenyakitterdahulu', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    <?php
                    echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', array('class' => 'btn btn-primary', 'onclick' => "$('#dialogAddRiwayatPenyakitTerdahulu').dialog('open');",
                        'id' => 'btnAddRiwayatPenyakitTerdahulu', 'onkeypress' => "return $(this).focusNextInputField(event)",
                        'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $modAnamnesa->getAttributeLabel('riwayatpenyakitterdahulu')))
                    ?>
                    <?php echo $form->error($modAnamnesa, 'riwayatpenyakitterdahulu'); ?>
                </div>
            </div>
            <?php //echo $form->textAreaRow($modAnamnesa, 'riwayatpenyakitterdahulu', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));  ?>
            <div class="control-group ">
                <?php echo $form->labelEx($modAnamnesa, 'riwayatpenyakitkeluarga', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textArea($modAnamnesa, 'riwayatpenyakitkeluarga', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    <?php
                    echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', array('class' => 'btn btn-primary', 'onclick' => "$('#dialogAddRiwayatPenyakitKeluarga').dialog('open');",
                        'id' => 'btnAddRiwayatPenyakitKeluarga', 'onkeypress' => "return $(this).focusNextInputField(event)",
                        'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $modAnamnesa->getAttributeLabel('riwayatpenyakitkeluarga')))
                    ?>
                    <?php echo $form->error($modAnamnesa, 'riwayatpenyakitkeluarga'); ?>
                </div>
            </div>
           
            <?php echo $form->textAreaRow($modAnamnesa, 'riwayatalergiobat', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
             
        </td>
        <td>
            <?php echo $form->labelEx($modAnamnesa, 'tglanamnesis', array('class' => 'control-label')) ?>
            <div class="controls">  
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modAnamnesa,
                    'attribute' => 'tglanamnesis',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true,
                        'onkeypress' => "return $(this).focusNextInputField(event)"),
                ));
                ?>
            </div> 
            <?php //echo $form->textAreaRow($modAnamnesa, 'keluhantambahan', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            
            <?php //echo $form->textAreaRow($modAnamnesa, 'riwayatpenyakitkeluarga', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            <?php echo $form->textAreaRow($modAnamnesa, 'pengobatanygsudahdilakukan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 1000)); ?>
            <?php echo $form->textAreaRow($modAnamnesa, 'riwayatmakanan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            <?php echo $form->textAreaRow($modAnamnesa, 'riwayatkelahiran', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            <div class="control-group ">
                <?php echo $form->labelEx($modAnamnesa, 'riwayatimunisasi', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textArea($modAnamnesa, 'riwayatimunisasi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    <?php
                    echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', array('class' => 'btn btn-primary', 'onclick' => "$('#dialogAddRiwayatImunisasi').dialog('open');",
                        'id' => 'btnAddRiwayatImunisasi', 'onkeypress' => "return $(this).focusNextInputField(event)",
                        'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $modAnamnesa->getAttributeLabel('riwayatimunisasi')))
                    ?>
                    <?php echo $form->error($modAnamnesa, 'riwayatimunisasi'); ?>
                </div>
            </div>
			<div class="control-group ">
				<?php echo $form->labelEx($modAnamnesa,'statusmerokok', array('class'=>'control-label')) ?>
				<div class="controls">
					<div class="radio inline">
						<div class="form-inline">
							<?php echo $form->radioButtonList($modAnamnesa,'statusmerokok',array('0'=>'Tidak','1'=>'Ya'), array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'statusrokok','onclick'=>'setJumlahRokok(this);')); ?>            
						</div>
					</div>
					<?php echo $form->error($modAnamnesa, 'statusmerokok'); ?>
				</div>
			</div>
			<div class="control-group">
                <?php echo $form->labelEx($modAnamnesa, 'jmlrokok_btg_hr', array('class' => 'control-label')) ?>
                <div class="controls">
					<?php echo $form->textField($modAnamnesa, 'jmlrokok_btg_hr', array('class' => 'span1 jmlbtg', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
					<?php echo $form->labelEx($modAnamnesa, 'hari') ?>
				</div>
			</div>
            <?php echo $form->textAreaRow($modAnamnesa, 'keterangananamesa', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            
            <?php //echo $form->textAreaRow($modAnamnesa, 'riwayatalergiobat', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
           
            <?php //echo $form->textAreaRow($modAnamnesa, 'riwayatimunisasi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            
        </td>
    </tr>
</table>


<div class="form-actions">
    <?php
    echo CHtml::htmlButton($modAnamnesa->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan'));
    echo "&nbsp;";
    echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                            array('class'=>'btn btn-danger',
                                  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
    echo "&nbsp;";
    if($modAnamnesa->isNewRecord){
	echo CHtml::link(Yii::t('mds', '{icon} Print Anamnesa', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Tombol akan aktif setelah data tersimpan','class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;'));
        echo "&nbsp;";
    }else{
	echo CHtml::link(Yii::t('mds', '{icon} Print Anamnesa', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printAnamnesa();return false",'disabled'=>FALSE  ));
        echo "&nbsp;";
    }
    
    $content = $this->renderPartial('../tips/tips',array(),true);
    $this->widget('UserTips',array('type'=>'admin','content'=>$content));

    ?>
	
</div>

<?php $this->endWidget(); ?>

<?php
$js = <<< JS

//===============Awal untu Mengecek Form Sudah DiUbah Atw Belum====================    
    $(":input").keyup(function(event){
            $('#berubah').val('Ya');
         });
    $(":input").change(function(event){
            $('#berubah').val('Ya');
         });  
    $(":input").click(function(event){
            $('#berubah').val('Ya');
         });  
//================Akhir Untuk Mengecek  Form Sudah DiUbah Atw Belum===================         
JS;
Yii::app()->clientScript->registerScript('asuransi', $js, CClientScript::POS_READY);
?>

<?php
$js = <<< JS
//==================================================Validasi===============================================
//*Jangan Lupa Untuk menambahkan hiddenField dengan id "berubah" di setiap form
//* hidden field dengan id "url"
//*Copas Saja hiddenfield di Line 34 dan 35
//* ubah juga id button simpannya jadi "btn_simpan"

function palidasiForm(obj)
   {
        var berubah = $('#berubah').val();
        if(berubah=='Ya') 
        {
            myConfirm("Apakah Anda Akan menyimpan Perubahan Yang Sudah Dilakukan?","Perhatian!",function(r) {
                if(r)
                {
                         $('#url').val(obj);
                         $('#btn_simpan').click();

                }
            });

        }      
   }
JS;
Yii::app()->clientScript->registerScript('validasi', $js, CClientScript::POS_HEAD);
?>   

<?php
//========= Dialog buat Pemesanan obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogAddRiwayatPenyakitTerdahulu',
    'options' => array(
        'title' => 'Pencarian Data Diagnosa Penyakit Terdahulu',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'resizable' => false,
    ),
));

$modDataDiagnosaPenyakitTerdahulu = new RIDiagnosaM('searchDiagnosaAnamnesa');
$modDataDiagnosaPenyakitTerdahulu->unsetAttributes();
if(isset($_GET['RIDiagnosaM'])){
    $modDataDiagnosaPenyakitTerdahulu->attributes = $_GET['RIDiagnosaM'];
    $modDataDiagnosaPenyakitTerdahulu->diagnosa_nama = (isset($_GET['RIDiagnosaM']['diagnosa_nama']) ? $_GET['RIDiagnosaM']['diagnosa_nama'] : "");
    $modDataDiagnosaPenyakitTerdahulu->diagnosa_namalainnya = (isset($_GET['RIDiagnosaM']['diagnosa_namalainnya']) ? $_GET['RIDiagnosaM']['diagnosa_namalainnya'] : "");
    $modDataDiagnosaPenyakitTerdahulu->diagnosa_kode = (isset($_GET['RIDiagnosaM']['diagnosa_kode']) ? $_GET['RIDiagnosaM']['diagnosa_kode'] : "");
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'diagnosa-m-grid',
    'dataProvider' => $modDataDiagnosaPenyakitTerdahulu->searchDiagnosaAnamnesa(),
    'filter' => $modDataDiagnosaPenyakitTerdahulu,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectDiagnosa",
                                    "onClick" => "
                                                var data = $(\"#' . CHtml::activeId($modAnamnesa, 'riwayatpenyakitterdahulu') . '\").val();
                                                if (data == \"\"){
                                                    $(\"#' . CHtml::activeId($modAnamnesa, 'riwayatpenyakitterdahulu') . '\").val(\"$data->diagnosa_nama\");
                                                } else {
                                                    $(\"#' . CHtml::activeId($modAnamnesa, 'riwayatpenyakitterdahulu') . '\").val(data+\", $data->diagnosa_nama\");                                                  
                                                }
                                                  $(\"#dialogAddRiwayatPenyakitTerdahulu\").dialog(\"close\");    
                                        "))',
        ),
        'diagnosa_kode',
        'diagnosa_nama',
        'diagnosa_namalainnya',
        // 'diagnosa_katakunci',
        
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<?php
//========= Dialog buat Pencarian Diagnosa Penyakit Keluarga =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogAddRiwayatPenyakitKeluarga',
    'options' => array(
        'title' => 'Pencarian Data Pencarian Diagnosa Penyakit Keluarga',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'resizable' => false,
    ),
));
$modDataDiagnosaKeluarga = new RIDiagnosaM('searchDiagnosaAnamnesa');
$modDataDiagnosaKeluarga->unsetAttributes();
if(isset($_GET['RIDiagnosaM'])){
    $modDataDiagnosaKeluarga->attributes = $_GET['RIDiagnosaM'];
    $modDataDiagnosaKeluarga->diagnosa_nama = (isset($_GET['RIDiagnosaM']['diagnosa_nama']) ? $_GET['RIDiagnosaM']['diagnosa_nama'] : "");
    $modDataDiagnosaKeluarga->diagnosa_namalainnya = (isset($_GET['RIDiagnosaM']['diagnosa_namalainnya']) ? $_GET['RIDiagnosaM']['diagnosa_namalainnya'] : "");
    $modDataDiagnosaKeluarga->diagnosa_kode = (isset($_GET['RIDiagnosaM']['diagnosa_kode']) ? $_GET['RIDiagnosaM']['diagnosa_kode'] : "");
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'penyakitkeluarga-m-grid',
    'dataProvider' => $modDataDiagnosaKeluarga->searchDiagnosaAnamnesa(),
    'filter' => $modDataDiagnosaKeluarga,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectDiagnosaPenyakit",
                                    "onClick" => "
                                                var data = $(\"#' . CHtml::activeId($modAnamnesa, 'riwayatpenyakitkeluarga') . '\").val();
                                                if (data == \"\"){
                                                    $(\"#' . CHtml::activeId($modAnamnesa, 'riwayatpenyakitkeluarga') . '\").val(\"$data->diagnosa_nama\");
                                                } else {
                                                    $(\"#' . CHtml::activeId($modAnamnesa, 'riwayatpenyakitkeluarga') . '\").val(data+\", $data->diagnosa_nama\");
                                                }
                                                $(\"#dialogAddRiwayatPenyakitKeluarga\").dialog(\"close\");    
                                        "))',
        ),
        'diagnosa_kode',
        'diagnosa_nama',
        'diagnosa_namalainnya',
        
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Pencarian Diagnosa Penyakit Keluarga dialog =============================
?>



<?php
//========= Dialog buat Pencarian Riwayat Imunisasi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogAddRiwayatImunisasi',
    'options' => array(
        'title' => 'Pencarian Data Riwayat Imunisasi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'resizable' => false,
    ),
));



$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'imunisasi-m-grid',
    'dataProvider' => $modDataDiagnosa->searchImunisasi(),
    'filter' => $modDataDiagnosa,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectDiagnosaImunisasi",
                                    "onClick" => "
                                                var data = $(\"#' . CHtml::activeId($modAnamnesa, 'riwayatimunisasi') . '\").val();
                                                if (data == \"\"){
                                                    $(\"#' . CHtml::activeId($modAnamnesa, 'riwayatimunisasi') . '\").val(\"$data->diagnosa_nama\");
                                                } else {
                                                    $(\"#' . CHtml::activeId($modAnamnesa, 'riwayatimunisasi') . '\").val(data+\", $data->diagnosa_nama\");
                                                }
                                                $(\"#dialogAddRiwayatImunisasi\").dialog(\"close\");    
                                        "))',
        ),
        'diagnosa_kode',
        'diagnosa_nama',
        'diagnosa_namalainnya',
        'diagnosa_katakunci',
        
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Pencarian Riwayat Imunisasi dialog =============================
?>

<script type="text/javascript">
/**
 * print status
 */
function printAnamnesa()
{
    window.open('<?php echo $this->createUrl('printAnamnesa',array('pendaftaran_id'=>$modAnamnesa->pendaftaran_id)); ?>','printwin','left=100,top=100,width=640,height=480');
}

function defaultparamedis()
{   
    var paramedis = '<?php 
    $pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
    if (!empty($pegawai)) echo $pegawai->nama_pegawai; 
    ?>';
    $("#<?php echo CHtml::activeId($modAnamnesa,'paramedis_nama') ?>").val(paramedis);
}

function setJumlahRokok(obj){
	var status = $(obj).val();
	if(status == 0){
		$('.jmlbtg').attr('readonly',true);
	}else{
		$('.jmlbtg').removeAttr('readonly',true);
	}		
}

$(document).ready(function(){
	$('input[name$="[statusmerokok]"][type="radio"]').each(function(){		
		if($(this).is(':checked')){
			var status = $(this).val();
			if(status == 0){
				$('.jmlbtg').attr('readonly',true);
			}else{
				$('.jmlbtg').removeAttr('readonly',true);
			}		
		}
    });
    defaultparamedis();     
});
</script>