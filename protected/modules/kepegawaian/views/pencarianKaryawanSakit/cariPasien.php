<fieldset class="white-container">
    <legend class="rim2">Pencarian <b>Pegawai Sakit</b></legend>

<?php
//$arrMenu = array();
 //               array_push($arrMenu,array('label'=>Yii::t('mds',''), 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//$this->menu=$arrMenu;
//$this->widget('bootstrap.widgets.BootAlert');
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'caripasien-form',
	'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'focus'=>'#no_rekam_medik',
                'method'=>'GET',
                'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
));

Yii::app()->clientScript->registerScript('cariPasien', "
$('#caripasien-form').submit(function(){
	$.fn.yiiGridView.update('pencarianpasien-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$format = new MyFormatter();
?>
<div class="block-tabel">
    <h6>
        Tabel <b>Pegawai Sakit</b>
    </h6>
<?php
    $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
	'id'=>'pencarianpasien-grid',
	'dataProvider'=>$model->search(),
//                'filter'=>$model,
                'template'=>"{pager}{summary}\n{items}",

                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'mergeHeaders'=>array(
            array(
                'name'=>'<center>Daftarkan</center>',
                'start'=>11, //indeks kolom 3
                'end'=>13, //indeks kolom 4
            ),
        ),
	'columns'=>array(
                    array(
                        'name'=>'tgl_pendaftaran',
                        'type'=>'raw',
                        'value'=>function($data) { return date('d M Y H:i:s', strtotime($data->tgl_pendaftaran)); },
								'headerHtmlOptions'=>array('style'=>'text-align:center'),                   
                    ),
                    array(
                        'name'=>'tgl_rekam_medik',
                        'type'=>'raw',
                        'value'=>function($data) { return date('d M Y', strtotime($data->tgl_rekam_medik)); },
                    ),
                    array(
                        'name'=>'no_rekam_medik',
                        'type'=>'raw',
                        'value'=>'$data->no_rekam_medik',
                        'headerHtmlOptions'=>array('style'=>'text-align:center'),
                    ), 
            array(
                        'name'=>'nomorindukpegawai',
                        'type'=>'raw',
                        'value'=>'$data->nomorindukpegawai',
                    ), 
                    array(
                        'header'=>'Nama Karyawan',
                        'name'=>'nama_pasien',
                        'type'=>'raw',
                        'value'=>'$data->nama_pasien',
                        'headerHtmlOptions'=>array('style'=>'text-align:center'),
                    ),
                     array(
                        'name'=>'jeniskelamin',
                        'value'=>'$data->jeniskelamin',
                        'headerHtmlOptions'=>array('style'=>'text-align:center'),
                    ),
                    array(
                        'name'=>'alamat_pasien',
                        'value'=>'$data->alamat_pasien',
                        'headerHtmlOptions'=>array('style'=>'text-align:center'),
                    ),
                    array(
          		'header'=>'Ruangan',
                        'name'=>'ruangan_nama',
                        'type'=>'raw',
                        'value'=>'$data->ruangan_nama',
                        'headerHtmlOptions'=>array('style'=>'text-align:center'),
                    ), 
                    array(
                        'header'=>'Jabatan',
                        'name'=>'jabatan_nama',
                        'type'=>'raw',
                        'value'=>'$data->jabatan_nama',
                        'headerHtmlOptions'=>array('style'=>'text-align:center'),
                    ), 
                    array(
                    		'header'=>'Status Periksa',
                    		'value'=>'$data->statusperiksa',
                    		'headerHtmlOptions'=>array('style'=>'text-align:center'),
                    ), /*
                    array(
                        'name'=>'Rt/Rw',
                        'value'=>'$data->rt." / ".$data->rw',
                    ), */
                  
                    
            ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
?>
</div>
<fieldset class="box search-form">
    <legend class="rim"><i class="icon-white icon-search"></i> Pencarian </legend>
    <table >
        <tr>
            <td>
                <div class="control-group ">
                    <?php echo Chtml::label("Tanggal Pendaftaran",'tgl_rm_awal', array('class'=>'control-label inline')) ?>
                    <div class="controls">
                        <?php   
                                $model->tgl_rm_awal = MyFormatter::formatDateTimeForUser($model->tgl_rm_awal);
                                $model->tgl_rm_akhir = MyFormatter::formatDateTimeForUser($model->tgl_rm_akhir);
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'tgl_rm_awal',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                    //'maxDate' => 'd',
                                                    //
                                                ),
                                                'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                ),
                        )); ?>
                        
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($model,'tgl_rm_akhir', array('class'=>'control-label inline')) ?>
                    <div class="controls">
                        <?php   
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'tgl_rm_akhir',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                    //'maxDate' => 'd',
                                                ),
                                                'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                ),
                        )); ?>
                        
                    </div>
                </div>
            </td>
            <td>
                <div class="control-group ">
                    
                    <div class="controls">
                        <?php //echo $form->labelEx($model,'rt', array('class'=>'control-label inline')) ?>
                        
                         <?php echo $form->textFieldRow($model,'nama_pasien',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                			<?php echo $form->textFieldRow($model,'no_rekam_medik',array('class'=>'span3 numbers-only','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
              				<?php echo $form->textFieldRow($model,'alamat_pasien',array('class'=>'span3 hurufs-only','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
               			<?php // echo $form->dropDownListRow($model,'statusperiksa', Params::statusPeriksa(), array('empty'=>'-- Pilih --', 'class'=>'span3')); ?>
               			<?php /* echo $form->dropDownListRow($model, 'ruangan_id',
               				CHtml::listData(RuanganM::model()->findAll(array('condition'=>'instalasi_id in (2,3,4,8)', 'order'=>'instalasi_id, ruangan_nama')), 'ruangan_id', 'ruangan_nama'),
               				array('empty'=>'-- Pilih --', 'class'=>'span3')
               			); */ ?>
                <?php // echo $form->textFieldRow($model,'nama_bin',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                        <?php // echo $form->textFieldRow($model,'rt', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 numberOnly','maxlength'=>3)); ?> 
                        <?php //echo $form->textFieldRow($model,'rw', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 numberOnly','maxlength'=>3)); ?> 
                
                    </div>
                </div>
                
            </td>
        </tr>
    </table>
</fieldset>
      
    <div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
		<?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), $this->createUrl('PencarianKaryawanSakit/'), array('class'=>'btn btn-danger')); ?>
                
 <?php
          $tips = array(
              '0' => 'tanggal',
              '1' => 'cari',
              '2' => 'ulang'
          );
          $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
          $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
		
</div>

<?php $this->endWidget(); ?>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
//$url =  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
$url = Yii::app()->createUrl('print/kartuPasien',array('idPasien'=>''));
$cetak = Yii::app()->createUrl('pendaftaranPenjadwalan/pencarianPasien/printKartu',array('id'=>''));
$urlPendaftaranRJ=Yii::app()->createAbsoluteUrl('pendaftaranPenjadwalan/Pendaftaran/RawatJalan');
$urlPendaftaranRD=Yii::app()->createAbsoluteUrl('pendaftaranPenjadwalan/Pendaftaran/RawatDarurat');

$js = <<< JSCRIPT

//function daftarRj(noRM)
//   {
//           
//            $('#norek').val(noRM);
//            document.getElementById("daftarRJ").submit();
//           
//   }

// ==* Fungsi Print *== //

function print(id,umur)
   {    
//               window.open('${url}'+id+'/umur/'+umur,'printwin','left=100,top=100,width=310,height=200,scrollbars=0');
               window.open('${url}'+id,'printwin','left=100,top=100,width=310,height=200,scrollbars=0');
   }
   
function getListKunjungan(id){
    if (jQuery.isNumeric(id)){
        $.fn.yiiGridView.update('pencarianlistkunjungan-grid', {
		data: 'PendaftaranT[pasien_id]='+id, 
                success: function (data) {
                        var hasil = $('<div>' + data + '</div>');
                        var updateId = '#pencarianlistkunjungan-grid';
                        var update2 = '#dataPasienKunjungan';
                        $(updateId).replaceWith($(updateId, hasil));
                        $(update2).replaceWith($(update2, hasil));
                        $("#dialogRiwayatKunjungan").dialog("open");
                }
	});
        
        
	return false;
    }
}

function daftarKeRJ(pasien_id)
{
    $('#pasien_id').val(pasien_id);
    $('#form_hidden_rj').submit();
}
function daftarKeRD(pasien_id)
{
    $('#pasien_id').val(pasien_id);
    $('#form_hidden_rd').submit();
}

JSCRIPT;

Yii::app()->clientScript->registerScript('jsPencarianPasien',$js, CClientScript::POS_HEAD);

$js = <<< JS
$('.numberOnly').keyup(function() {
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
Yii::app()->clientScript->registerScript('numberOnly',$js,CClientScript::POS_READY);
?>




<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogPjP',
    'options'=>array(
        'title'=>'Daftar Penanggung Jawab',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>700,
        'minHeight'=>400,
        'resizable'=>true,
    ),
));
?>
<iframe src="" name="iframeRincianTagihan" width="100%" height="550" ></iframe>
<?php
$this->endWidget();
?>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'form_hidden_rj',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'action'=>$urlPendaftaranRJ,
        'htmlOptions'=>array('target'=>'_new'),
)); ?>
    <?php echo CHtml::hiddenField('pasien_id','',array('readonly'=>true));?>
    <?php //echo CHtml::hiddenField('pendaftaran_id','',array('readonly'=>true));?>
<?php $this->endWidget(); ?>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'form_hidden_rd',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'action'=>$urlPendaftaranRD,
        'htmlOptions'=>array('target'=>'_new'),
)); ?>
    <?php echo CHtml::hiddenField('pasien_id','',array('readonly'=>true));?>
    <?php //echo CHtml::hiddenField('pendaftaran_id','',array('readonly'=>true));?>
<?php $this->endWidget(); ?>
<script>
    cekAll();
    function cekAll(){
        if ($("#KPPasienM_ceklis").is(":checked")) {
            $("#KPPasienM_tgl_rm_awal").removeAttr('disabled');
            $("#KPPasienM_tgl_rm_akhir").removeAttr('disabled');
        }else{
            $("#KPPasienM_tgl_rm_awal").attr('disabled','true');
            $("#KPPasienM_tgl_rm_akhir").attr('disabled','true');
        }
    }
</script>
</fieldset>