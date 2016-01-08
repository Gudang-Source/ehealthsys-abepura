<style>
	input,.uneditable-input{display:inline-block;width:210px;height:16px;padding:2px;margin-bottom:1px;font-size:12px;line-height:15px;color:#555555;border:1px solid #ccc;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;}
	.uneditable-textarea{width:800px;height:190px;}

	select,.uneditable-input{display:inline-block;width:210px;height:22px;padding:2px;margin-bottom:1px;font-size:12px;line-height:15px;color:#555555;border:1px solid #ccc;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;}

	.dtPicker3, .input-append input, .input-append .uneditable-input{
		height: 14px;
		cursor: pointer;
	}
	
	.form-horizontal .control-label{
		font-size:12px;
		width: 150px;
		font-family: monospace;
	}

	fieldset{
		height: 130px;
	}

	.form-actions{
		margin-bottom: -9px;
		margin-top: -10px;
	}

	textarea{
		width: 249px;
		height: 30px;
		font-size:12px;
	}

	label, input, button, select{
		line-height:15px;
	}

	.form-horizontal .control-labelcoslpan{
		width: 400px;
		font-size:12px;
		font-family: monospace;
		text-align: right;
	}

	.radio.inline, .checkbox.inline{
		padding-top: 0px;
	}
</style>
<script>
	$(function(){
		$('#PPPasienM_no_identitas_pasien').keyboard();
		$('#PPPasienM_nama_pasien').keyboard();
		$('#PPPasienM_nama_bin').keyboard();
		$('#PPPasienM_tempat_lahir').keyboard();
		$('#PPPasienM_alamat_pasien').keyboard(); 
		$('#PPPasienM_rt').keyboard();
		$('#PPPasienM_rw').keyboard();
		$('#BuatjanjipoliT_keteranganbuatjanji').keyboard();
		$('#PPPasienM_no_rekam_medik').keyboard();
	});
</script>

<div class="block-kioskmodule" id="buatjanji" name="buatjanji">
	<legend class="rim">BUAT JANJI</legend><hr>

	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
	<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
		'action'=>Yii::app()->createUrl('ekios/Default/SimpanJanji'),
		'method'=>'post',
		'id'=>'ppbuat-janji-poli-t-form',
		'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onsubmit'=>'return cek_janji()'),
        //'focus'=>'#',
	)); ?>

	<?php 
		$modPasien = new PPPasienM();
		$modPPBuatJanjiPoli = new BuatjanjipoliT();
	?>
	<?php echo $form->errorSummary($modPPBuatJanjiPoli); ?>
	<?php echo $this->renderPartial('_formPasien', array('model'=>$model,'form'=>$form,'modPasien'=>$modPasien,'format'=>$format)); ?>
	<br><br><br>
	<fieldset>
        <h4> &nbsp;
			Masukan Data Janji 

			<?php  echo $form->checkBox($modPPBuatJanjiPoli,'byphone', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			<i class="icon-phone"></i> <?php echo $modPPBuatJanjiPoli->getAttributeLabel('byphone'); ?>
            <?php echo $form->error($modPPBuatJanjiPoli, 'byphone'); ?>
		</h4>


		<table>
            <tr>
                <td>
                    <?php echo $form->dropDownListRow($modPPBuatJanjiPoli,'ruangan_id', CHtml::listData($modPPBuatJanjiPoli->getRuanganItems(), 'ruangan_id', 'ruangan_nama') ,
                        array('empty'=>'-- Pilih --',
                            'onchange'=>"listDokterRuangan(this.value);",
                            'ajax'=>array(),
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>    
                    <?php echo $form->dropDownListRow($modPPBuatJanjiPoli,'pegawai_id', array() ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>

                    <div class="control-group ">
                        <?php echo $form->labelEx($modPPBuatJanjiPoli,'tgljadwal', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?php   
                                    $this->widget('MyDateTimePicker',array(
                                        'model'=>$modPPBuatJanjiPoli,
                                        'attribute'=>'tgljadwal',
                                        'mode'=>'datetime',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                            'minDate' => 'd',
                                            'onkeypress'=>"js:function(){getUmur(this);}",
                                            'onSelect'=>'js:function(){hariBaru(this);}',
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                        ),
                                )); ?>
                                <?php echo $form->error($modPPBuatJanjiPoli, 'tgljadwal'); ?>
                            </div>
              		</div>		
                </td>
                <td>
                	<?php echo $form->textFieldRow($modPPBuatJanjiPoli,'harijadwal',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20,'readonly'=>TRUE)); ?>
                    <?php echo $form->textAreaRow($modPPBuatJanjiPoli,'keteranganbuatjanji',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php  //echo $form->checkBoxRow($modPPBuatJanjiPoli,'byphone', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </td>
            </tr>
        </table>
	</fieldset>
	<div class="form-actions">
        <?php
                 if ($modPPBuatJanjiPoli->isNewRecord) {
	    echo CHtml::htmlButton($modPPBuatJanjiPoli->isNewRecord ? Yii::t('mds','{icon} Kirim',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                    Yii::t('mds','{icon} Kirim',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                    array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)'));
                 } else {
	    echo CHtml::htmlButton($modPPBuatJanjiPoli->isNewRecord ? Yii::t('mds','{icon} Kirim',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                    Yii::t('mds','{icon} Kirim',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                    array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','disabled'=>true));
                 }
                 ?>
                <a href="index.php?r=ekios" class="btn btn-danger">
					<i class="icon-refresh icon-white"></i>
					Batal
				</a>
	</div>

	<?php $this->endWidget(); ?>
</div>	

<?php

$urlGetTglLahir = $this->createUrl('GetTglLahir');
$urlGetUmur = $this->createUrl('GetUmur');
$urlGetDaerah = Yii::app()->createUrl('ActionAjax/getListDaerahPasien');
$idTagUmur = CHtml::activeId($modPasien,'umur');
$urlListDokterRuangan = Yii::app()->createUrl('actionDynamic/listDokterRuangan');
$urlGetHari = Yii::app()->createUrl('ActionAjax/GetHari');
$urlPrintKartuJanjiPoli = Yii::app()->createUrl('print/lembarJanjiPoli',array('idBuatJanjiPoli'=>''));

//Yii::app()->clientScript->registerScript('fungsipasien',$js,CClientScript::POS_READY);
?>

<script type="text/javascript">

function cek_janji(){
	var nama_pasien = $('#PPPasienM_nama_pasien').val();
	var tgl_lahir 	= $('#PPPasienM_tanggal_lahir').val();
	var jk_l		= $('input:radio[id=PPPasienM_jeniskelamin_0]:checked').val();
	var jk_p		= $('input:radio[id=PPPasienM_jeniskelamin_1]:checked').val();
	var alamat	 	= $('#PPPasienM_alamat_pasien').val();

	var ruangan		= $('#BuatjanjipoliT_ruangan_id').val();
	var tgl_janji	= $('#BuatjanjipoliT_tgljadwal').val();
	var dokter		= $('#BuatjanjipoliT_pegawai_id').val();

	//myAlert(dokter);
	
	if(nama_pasien==null || nama_pasien==''){
		myAlert('Nama Pasien Harus Diisi');
		return false;
	}else if(tgl_lahir==null || tgl_lahir==''){
		myAlert('Tgl. Lahir Harus Diisi');
		return false;
	}else if((jk_l=='' || jk_l==null) && (jk_p=='' || jk_p==null)){
		myAlert('Jenis Kelamin Harus Diisi');
		return false;
	}else if(alamat==null || alamat==''){
		myAlert('Alamat Harus Diisi');
		return false;
	}else if(ruangan=='' || ruangan==null){
		myAlert('Ruangan harus dipilih');
		return false;
	}else if(tgl_janji=='' || tgl_janji==null){
		myAlert('Tanggal Janji harus diisi');
		return false;
	}else if(dokter=='' || dokter==null){
		myAlert('Dokter harus diisi');
		return false;
	}else{
		return true;
	}
}

function hariBaru()
{
    var tanggal = $('#BuatjanjipoliT_tgljadwal').val();
    $.post("<?php echo $urlGetHari; ?>",{tanggal: tanggal},
    function(data){
       $('#BuatjanjipoliT_harijadwal').val(data.hari); 

   	},"json");
   

}

function listDokterRuangan(idRuangan)
{
    $.post("<?php echo Yii::app()->createUrl('actionDynamic/listDokterRuangan'); ?>", { idRuangan: idRuangan },
        function(data){
            $('#BuatjanjipoliT_pegawai_id').html(data.listDokter);
    }, "json");
}

</script>