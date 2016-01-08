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
        #triase tr td label.checkbox{
            width: 100px;
            display:inline-block;
        }
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
	<div class="row-fluid">
		<div class="span6">
			<fieldset class="box2">
				<legend class="rim">Berdasarkan Kunjungan</legend>
				<?php echo CHtml::hiddenField('type', ''); ?>
				<div class='control-group'>
					<div class = 'control-label'>Tanggal Pemeriksaan</div>
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
				<div class="control-group ">
					<div class = 'control-label'>Sampai Dengan</div>
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
		</div>
		<div class="span6">
			<fieldset class="box2">
				<legend class="rim">Berdasarkan Triase</legend>
					<?php
						echo '<table id="triase">
								<tr>
									<td>'.
											$form->checkBoxList($model, 'triase_id', CHtml::listData(Triase::model()->findAll('triase_aktif = true'), 'triase_id', 'triase_nama'), array('template'=>'<label class="checkbox">{input}{label}</label>', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")).'

									</td>
								</tr>
							 </table>';
					?>
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
             ))); 
        ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                            array('class'=>'btn btn-danger',
                                  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
    </div>
    <?php //$this->widget('UserTips', array('type' => 'create')); ?>    
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
//$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>


