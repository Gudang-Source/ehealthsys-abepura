<div class="search-form" style="">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
            ));
    ?>
    <style>
        table{
            margin-bottom: 0px;
        }
        .form-actions{
            padding:4px;
            margin-top:5px;
        }
        .nav-tabs>li>a{display:block; cursor:pointer;}
        .nav-tabs > .active a:hover{cursor:pointer;}
    </style>
       <style>

        #jeniskecelakaan tr td label.checkbox{
            width: 100%;
            display:inline-block;
        }

    </style>
	<div class="row-fluid">
		<div class="span4">
			<fieldset class="box2">
				<legend class="rim">Berdasarkan Tanggal</legend>
				<?php echo CHtml::hiddenField('type', ''); ?>
				<?php //echo CHtml::hiddenField('src', ''); ?>
				<div class = 'control-label'>Tanggal Pasien Pulang</div>
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
				<?php echo CHtml::label('Sampai dengan', 'Sampai dengan', array('class' => 'control-label')) ?>
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
			</fieldset>
		</div>
		<div class="span4">
			<div id='searching'>
				<fieldset class="box2">
					<legend class="rim">Berdasarkan Jenis Kecelakaan </legend>
					<?php echo '<table id="jeniskecelakaan">
						<tr>
							<td>
								'.
									$form->checkBoxList($model, 'jeniskecelakaan_id', CHtml::listData(JeniskecelakaanM::model()->findAll('jeniskecelakaan_aktif = true ORDER BY jeniskecelakaan_nama ASC'), 'jeniskecelakaan_id', 'jeniskecelakaan_nama'), array('onkeypress' => "return $(this).focusNextInputField(event)",'checked'=>true)).'
							</td>
						</tr>
					 </table>'; ?>
				</fieldset>
			</div>
		</div>
		<div class="span4">
			<div id='searching'>
                <fieldset>
				<?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
							'id'=>'big',
//                                    'parent'=>false,
//                                    'disabled'=>true,
//                                    'accordion'=>false, //default
							'content'=>array(
								'content1'=>array(
								'header'=>'Berdasarkan Wilayah',
								'isi'=>'<table><tr><td>'.CHtml::hiddenField('filter', 'wilayah').'<label>Propinsi</label></td><td>'.$form->dropDownList($model, 'propinsi_id', CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array('empty' => '-- Pilih --',
											'ajax' => array('type' => 'POST',
												'url' => $this->createUrl('SetDropdownKabupaten', array('encode' => false, 'model_nama' => ''.$model->getNamaModel().'')),
												'update' => '#'.CHtml::activeId($model, 'kabupaten_id').''),
											'onkeypress' => "return $(this).focusNextInputField(event)",
											'onchange'=>"setClearDropdownKelurahan();setClearDropdownKecamatan();"
										)).'</td></tr><tr><td><label>Kabupaten</label></td><td>'.
										$form->dropDownList($model, 'kabupaten_id', CHtml::listData($model->getKabupatenItems($model->propinsi_id), 'kabupaten_id', 'kabupaten_nama'), array('empty' => '-- Pilih --',
											'ajax' => array('type' => 'POST',
											'url' => $this->createUrl('SetDropdownKecamatan', array('encode' => false, 'model_nama' => ''.$model->getNamaModel().'')),
											'update' => '#'.CHtml::activeId($model, 'kecamatan_id').''),
											'onkeypress' => "return $(this).focusNextInputField(event)",
											'onchange'=>"setClearDropdownKelurahan();"
										)).'</td></tr><tr><td><label>Kecamatan</label></td><td>'
										.$form->dropDownList($model, 'kecamatan_id', CHtml::listData($model->getKecamatanItems($model->kabupaten_id),'kecamatan_id','kecamatan_nama'), array('empty' => '-- Pilih --',
											'ajax' => array('type' => 'POST',
												'url' => $this->createUrl('SetDropdownKelurahan', array('encode' => false, 'model_nama' => ''.$model->getNamaModel().'')),
												'update' => '#'.CHtml::activeId($model, 'kelurahan_id').''),
											'onkeypress' => "return $(this).focusNextInputField(event)"
										)).'</td></tr><tr><td><label>Kelurahan</label></td><td>'.
										$form->dropDownList($model, 'kelurahan_id',CHtml::listData($model->getKelurahanItems($model->kecamatan_id), 'kelurahan_id', 'kelurahan_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")).'</td></tr></table>',
								'active'=>true,
								),
							),
					)); ?>
				</fieldset>
			</div>
		</div>
	</div>
    <div class="form-actions">
        <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan',
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
             )
            )); 
             
            ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/pasienkecelakaan/PasienKecelakaan'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  
             ?>
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
  $("#jeniskecelakaan").find("input").attr("checked", "checked");
',  CClientScript::POS_READY);
?>
<script type="text/javascript">	
/** bersihkan dropdown kecamatan */
function setClearDropdownKecamatan()
{
    $("#<?php echo CHtml::activeId($model,"kecamatan_id");?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
}
/** bersihkan dropdown kelurahan */
function setClearDropdownKelurahan()
{
    $("#<?php echo CHtml::activeId($model,"kelurahan_id");?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
}
</script>