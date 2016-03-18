<legend class="rim"><i class="icon-search icon-white"></i> Pencarian</legend>
<div class="search-form" style="">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'focus' => '#'.CHtml::activeId($model,'nama_pegawai'),
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
            ));
    ?>
 <style>

        #penjamin label.checkbox{
            width: 100px;
            display:inline-block;
        }

    </style>
	<div class="row-fluid">
		<div class="span6">
			<fieldset class="box2">
				<legend class="rim">Berdasarkan Tanggal Pelayanaan</legend>
				<?php echo CHtml::hiddenField('type', ''); ?>
				<?php //echo CHtml::hiddenField('src', ''); ?>
				<div class="control-group">
					<div class = 'control-label'>Tanggal Pelayanan</div>
					<div class="controls">  
						<?php
						$this->widget('MyDateTimePicker', array(
							'model' => $model,
							'attribute' => 'tgl_awal',
							'mode' => 'date',
							'options' => array(
								'dateFormat' => Params::DATE_FORMAT,
								'maxDate'=>'d',
							),
							'htmlOptions' => array('readonly' => true,
								'onkeypress' => "return $(this).focusNextInputField(event)"),
						));
						?>
					</div>
				</div>
				<div class="control-group">
					<?php echo CHtml::label('Sampai dengan', ' s/d', array('class' => 'control-label')) ?>
					<div class="controls">  
						<?php
						$this->widget('MyDateTimePicker', array(
							'model' => $model,
							'attribute' => 'tgl_akhir',
							'mode' => 'date',
							'options' => array(
								'dateFormat' => Params::DATE_FORMAT,
								'maxDate'=>'d',
							),
							'htmlOptions' => array('readonly' => true,
								'onkeypress' => "return $(this).focusNextInputField(event)"),
						));
						?>
					</div>
				</div>
			</fieldset>
			<fieldset class="box2">
				<legend class="rim">Berdasarkan Dokter </legend>
				<?php echo $form->textFieldRow($model,'nama_pegawai',array('placeholder'=>'Ketik Nama Dokter')); ?>
			</fieldset>
		</div>
		<div class="span6">
			<fieldset class="box2">
				<legend class="rim">Berdasarkan Kelas Pelayanan </legend>
				<div style='margin-left:0px;'>
					<?php echo CHtml::checkBox('checkAllKelas',true, array('onkeypress'=>"return $(this).focusNextInputField(event)",
						'class'=>'checkbox-column','onclick'=>'checkAll()','checked'=>'checked'))." Pilih Semua"; ?>
				</div>
				<?php echo'<table>
					<tr>
						<td>
							<div id="kelasPelayanan">'.
							$form->checkBoxList($model, 'kelaspelayanan_id', CHtml::listData(KelaspelayananM::model()->findAll("kelaspelayanan_aktif = TRUE ORDER BY kelaspelayanan_nama ASC"), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('value'=>'pengunjung', 'inline'=>true, 'empty' => '-- Pilih --')).'
							</div>
						</td>
					 </tr>
					 </table>';
				?>
			</fieldset>
			<fieldset class="box2">
				<legend class="rim">Berdasarkan Cara Bayar</legend>
				<?php echo '<table>
						<tr>
							<td>'.CHtml::hiddenField('filter', 'carabayar', array('disabled'=>'disabled')).'<label>Cara&nbsp;Bayar</label></td>
							<td>'.$form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
								'ajax' => array('type' => 'POST',
									'url' => $this->createUrl('GetPenjaminPasienForCheckBox', array('encode' => false, 'namaModel' => ''.$model->getNamaModel().'')),
									'update' => '#penjamin',  //selector to update
								),
							)).'
							</td>
						</tr>
						<tr>
							<td>
								<label>Penjamin</label>
							</td>
							<td>
								<div id="penjamin">
									   <label> Data belum ditemukan </label>
								</div>
							</td>
						</tr>
					</table>';
				?>
			</fieldset>
		</div>
	</div>
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary',
                'type' => 'submit', 'id' => 'btn_simpan', 
                
                'ajax' => array(
                 'type' => 'GET', 
                 'url' => array("/".$this->route),
                 'update' => '#tableLaporan',
                 'beforeSend' => 'function(){
                                      $("#tableLaporan").addClass("animation-loading");
                                  }',
                 'complete' => 'function(){
                                      $("#tableLaporan").removeClass("animation-loading");
                                  }',
             ),'onclick'=>'CekCaraBayar();' ));
        ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
			Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
				array('class'=>'btn btn-danger',
				  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
    </div>
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php Yii::app()->clientScript->registerScript('cekAll','
  $("#big").find("input").attr("checked", "checked");
  $("#kelasPelayanan").find("input").attr("checked", "checked");
',  CClientScript::POS_READY);
?>
<script>
    function CekCaraBayar(){
       var carabayar = $('#RJLaporanpendapatanruangan_carabayar_id').val();
       if(!jQuery.isNumeric(carabayar)){
           myAlert('Isi terlebih dahulu Cara Bayar');
           return false;
       }else{
          $('#searchLaporan');
       }
    }
</script>
<script>
function checkAll() {
    if ($("#checkAllKelas").is(":checked")) {
        $('#kelasPelayanan input[name*="kelaspelayanan_id"]').each(function(){
           $(this).attr('checked',true);
        })
//        myAlert('Checked');
    } else {
       $('#kelasPelayanan input[name*="kelaspelayanan_id"]').each(function(){
           $(this).removeAttr('checked');
        })
    }
    
    if ($("#checkAllCaraBayar").is(":checked")) {
        $('#penjamin input[name*="penjamin_id"]').each(function(){
           $(this).attr('checked',true);
        })
//        myAlert('Checked');
    } else {
       $('#penjamin input[name*="penjamin_id"]').each(function(){
           $(this).removeAttr('checked');
        })
    }
}   
</script>