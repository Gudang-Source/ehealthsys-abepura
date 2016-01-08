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

        #penjamin label.checkbox{
            width: 100px;
            display:inline-block;
        }

    </style>
	<div class="row-fluid">
		<div class="span4">
			<fieldset class="box2">
				<legend class="rim">Berdasarkan Kunjungan</legend>
				<?php echo CHtml::hiddenField('type', ''); ?>
				<?php //echo CHtml::hiddenField('src', ''); ?>
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
			</fieldset>
		</div>
		<div class="span4">
			<fieldset class="box2">
				<legend class="rim">Berdasarkan status bayar</legend>
					<?php echo '<table>
						<tr>
							<td>
								<div class="penjamin">'.
								$form->checkBoxList($model, 'tindakansudahbayar_id', CustomFunction::getStatusBayar(), array('value'=>'pengunjung', 'inline'=>true, 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")).'
								</div>
							</td>
						 </tr>
					</table>'; ?>
			</fieldset>
		</div>
		<div class="span4">
			<fieldset class="box2">
				<legend class="rim">Berdasarkan Cara Bayar </legend>
				<?php echo '<table>
					<tr>
						<td>'.CHtml::hiddenField('filter', 'carabayar', array('disabled'=>'disabled')).'<label>Cara&nbsp;Bayar</label></td>
						<td>'.$form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
							'ajax' => array('type' => 'POST',
								'url' => Yii::app()->createUrl('ActionDynamic/GetPenjaminPasienForCheckBox', array('encode' => false, 'namaModel' => ''.$model->getNamaModel().'')),
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
							<div id="penjamin">'.
								//$form->checkBoxList($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_nama'), array('value'=>'pengunjung',  'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")).'
							'<label>Data Tidak Ditemukan</label></div>
						</td>
					</tr>
				</table>'; ?>
			</fieldset>
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