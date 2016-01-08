<?php
$this->breadcrumbs=array(
	'Rujukan Keluar',
);
$this->widget('bootstrap.widgets.BootAlert');
?>
<!--<legend class="rim2">Rujukan Keluar Pasien</legend>-->
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'rjpasien-dirujuk-keluar-t-form',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);','onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#'.CHtml::activeId($modRujukanKeluar,'nosuratrujukan'),
)); ?>

    <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
        'id'=>'form-riwayat',
        'content'=>array(
            'content-detailpasien'=>array(
                'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan riwayat pasien')).'<b> Riwayat Rujukan Keluar</b>',
                'isi'=>$this->renderPartial($this->path_view.'_listRujukanKeluar',array(
                        'form'=>$form,
                        'modRiwayatRujukanKeluar'=>$modRiwayatRujukanKeluar
                        ),true),
                'active'=>true,
                ),   
            ),
    )); ?>
    <div class="row-fluid">
        <div class="span12">
            <?php $this->widget('bootstrap.widgets.BootButtonGroup', array(
                'type'=>'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'buttons'=>array(
                    array('label'=>'Print', 'icon'=>'icon-print icon-white', 'url'=>'#', 'htmlOptions'=>array('onclick'=>'print(\'PRINT\')')),
                    array('label'=>'', 'items'=>array(
                        array('label'=>'PDF', 'icon'=>'icon-book', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'PDF\')')),
                        array('label'=>'Excel','icon'=>'icon-pdf', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'EXCEL\')')),
                       
                    )),       
                ),
                'htmlOptions'=>array('style'=>'float:right')
        //        'htmlOptions'=>array('class'=>'btn')
            )); ?>
        </div>
    </div>
            
     

    <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

    <?php echo $form->errorSummary($modRujukanKeluar); ?>
    
    <table class="items">
        <tr>
            <td width="50%">
                <?php echo CHtml::hiddenField('url',$this->createUrl('',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id)),array('readonly'=>TRUE));?>
				<?php echo CHtml::hiddenField('berubah','',array('readonly'=>TRUE));?>
                <?php //echo $form->textFieldRow($modRujukanKeluar,'pasienadmisi_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textFieldRow($modRujukanKeluar,'pendaftaran_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <div class="control-group ">
                    <?php echo $form->labelEx($modRujukanKeluar,'tgldirujuk', array('class'=>'control-label')) ?>
                    <?php $modRujukanKeluar->tgldirujuk = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modRujukanKeluar->tgldirujuk, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
                    <div class="controls">
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$modRujukanKeluar,
                                                    'attribute'=>'tgldirujuk',
                                                    'mode'=>'datetime',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'maxDate' => 'd',
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true),
                            )); ?>
                    </div>
                </div>
				<div class="control-group ">
                    <?php echo $form->labelEx($modRujukanKeluar,'tglberlakusurat', array('class'=>'control-label')) ?>
                    <?php $modRujukanKeluar->tgldirujuk = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modRujukanKeluar->tglberlakusurat, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
                    <div class="controls">
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$modRujukanKeluar,
                                                    'attribute'=>'tglberlakusurat',
                                                    'mode'=>'datetime',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'maxDate' => 'd',
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true),
                            )); ?>
                    </div>
                </div>
                <?php echo $form->dropDownListRow($modRujukanKeluar,'pegawai_id', CHtml::listData($modRujukanKeluar->getDokterItems($modPendaftaran->ruangan_id), 'pegawai_id', 'NamaLengkap'),
                                                array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->dropDownListRow($modRujukanKeluar,'rujukankeluar_id', CHtml::listData($modRujukanKeluar->getRujukanItems(), 'rujukankeluar_id', 'rumahsakitrujukan'),
                                                array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modRujukanKeluar,'nosuratrujukan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50, 'readonly'=>true)); ?>
                <?php //echo $form->textFieldRow($modRujukanKeluar,'tgldirujuk',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modRujukanKeluar,'kepadayth',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                <?php echo $form->textFieldRow($modRujukanKeluar,'dirujukkebagian',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                <?php //echo $form->dropDownListRow($modRujukanKeluar,'ruanganasal_id', CHtml::listData($modRujukanKeluar->getRuanganInstalasiItems($modPendaftaran->instalasi_id), 'ruangan_id', 'ruangan_nama'),
                                                //array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textAreaRow($modRujukanKeluar,'catatandokterperujuk',array('rows'=>3, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textAreaRow($modRujukanKeluar,'alasandirujuk',array('rows'=>3, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            </td>
            <td width="50%">
                <?php echo $form->textAreaRow($modRujukanKeluar,'hasilpemeriksaan_ruj',array('rows'=>3, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <div class="control-group ">
                    <?php echo $form->labelEx($modRujukanKeluar, 'diagnosasementara_ruj', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textArea($modRujukanKeluar, 'diagnosasementara_ruj', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                        <?php
                            echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i> <i class="icon-white icon-chevron-right"></i>', array('class' => 'btn btn-primary', 'onclick' => "$('#dialogAddDiagnosaSementara').dialog('open');",
                                'id' => 'btnAddDiagnosaSementara', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $modRujukanKeluar->getAttributeLabel('diagnosasementara_ruj')))
                        ?>
                        <?php echo $form->error($modRujukanKeluar, 'diagnosasementara_ruj'); ?>
                    </div>
                </div>
                <?php echo $form->textAreaRow($modRujukanKeluar,'pengobatan_ruj',array('rows'=>3, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textAreaRow($modRujukanKeluar,'lainlain_ruj',array('rows'=>3, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            </td>
        </tr>
    </table>
            
    <div class="form-actions">
			<?php if(isset($_GET['pasiendirujukkeluar_id'])){ ?>
				<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                    array('class'=>'btn btn-primary', 'type'=>'button','disabled'=>true)); ?>
			<?php }else{ ?>
				<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                    array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan')); ?>
			<?php } ?>			      
            <?php 
           $content = $this->renderPartial('rawatJalan.views.tips.tips',array(),true);
			$this->widget('UserTips',array('type'=>'admin','content'=>$content));
                        
                        $urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/print&id='.$modPendaftaran->pendaftaran_id);
                        $urlPrintRujukan=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/printRujukan&id='.$modPendaftaran->pendaftaran_id);

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
function printRujukan(caraPrint,rujukankeluar_id)
{
    window.open("${urlPrintRujukan}&rujukankeluar_id="+rujukankeluar_id+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
			
    </div>

<?php $this->endWidget(); ?>


    <?php 
$js = <<< JS
//==================================================Validasi===============================================
//*Jangan Lupa Untuk menambahkan hiddenField dengan id "berubah" di setiap form
//* hidden field dengan id "url"
//*Copas Saja hiddenfield di Line 36 dan 35
//* ubah juga id button simpannya jadi "btn_simpan"


function palidasiForm(obj)
{
    var berubah = $('#berubah').val();
    if(berubah=='Ya'){
        myConfirm("Apakah Anda Akan menyimpan Perubahan Yang Sudah Dilakukan?","Perhatian!",function(r) {
            if(r){
                $('#url').val(obj);
                $('#btn_simpan').click();
            }
        });
    }      
}

JS;
Yii::app()->clientScript->registerScript('js',$js,CClientScript::POS_READY);
?>   
    
<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogDetailrujukan',
    'options'=>array(
        'title'=>'Detail Rujukan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'resizable'=>false,
        'position'=>'top',
    ),
));

    echo '<div id="contentDetailRujukan">dialog content here</div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
   
<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogAddDiagnosaSementara',
    'options'=>array(
        'title'=>'Diagnosa Sementara',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'resizable'=>false,
        'position'=>'top',
    ),
));

    $this->renderPartial($this->path_view.'_diagnosaSementara',array('modRujukanKeluar'=>$modRujukanKeluar));

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<script type="text/javascript">
function viewDetailRujukan(idPasienDirujuk)
{
    $.post('<?php echo $this->createUrl('ajaxDetailRujukanKeluar') ?>', {idPasienDirujuk: idPasienDirujuk}, function(data){
        $('#contentDetailRujukan').html(data.result);
    }, 'json');
    $('#dialogDetailrujukan').dialog('open');
}


function hapusRujukan(id)
{
    tabel = obj;
    myConfirm('Apakah anda akan menghapus obat / alat kesehatan ini?', 'Perhatian!', function(r)
    {
        if(r){
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('hapusObatAlkesPasien'); ?>',
                data: {rujukankeluar_id:id},
                dataType: "json",
                success:function(data){
                    if(data.sukses){
                        var delete_row = $(tabel).parents('tr');
                        delete_row.detach();
                    }
                    myAlert(data.pesan);
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });

        }
    });
}

$(document).ready(function(){
    // Notifikasi Pasien
    <?php 
        if(isset($_GET['smspasien'])){
            if($_GET['smspasien']==0){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien <?php echo $modPasien->nama_pasien; ?> tidak memiliki nomor mobile'}; // 16 
        insert_notifikasi(params);
    <?php            
            }
        }
    ?>
});
</script>