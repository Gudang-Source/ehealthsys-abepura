<legend class = "rim"><i class = "icon-search icon-white"></i> Pencarian</legend>
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
<div class="row-fluid">
	<div class="span4">
            <?php $format = new MyFormatter(); ?>
            <?php echo CHtml::hiddenField('type', ''); ?>
            <?php echo CHtml::label('Periode Laporan', 'tgl_pendaftaran', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'jns_periode', array('hari' => 'Hari', 'bulan' => 'Bulan', 'tahun' => 'Tahun'), array('class' => 'span2', 'onchange' => 'ubahJnsPeriode();')); ?>
            </div>
        </div>
        <div class="span4">
            <div class='control-group hari'>
                <?php echo CHtml::label('Dari Tanggal', 'dari_tanggal', array('class' => 'control-label')) ?>
                <div class="controls">  
                    <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>                     
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_awal',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => "span2",
                            'onkeypress' => "return $(this).focusNextInputField(event)"),
                    ));
                    ?>
                    <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>                     
                </div> 

            </div>
            <div class='control-group bulan'>
                <?php echo CHtml::label('Dari Bulan', 'dari_tanggal', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php $model->bln_awal = $format->formatMonthForUser($model->bln_awal); ?>
                    <?php
                    $this->widget('MyMonthPicker', array(
                        'model' => $model,
                        'attribute' => 'bln_awal',
                        'options' => array(
                            'dateFormat' => Params::MONTH_FORMAT,
                        ),
                        'htmlOptions' => array('readonly' => true,
                            'class' => "span2",
                            'onkeypress' => "return $(this).focusNextInputField(event)"),
                    ));
                    ?>
                    <?php $model->bln_awal = $format->formatMonthForDb($model->bln_awal); ?>
                </div> 
            </div>
            <div class='control-group tahun'>
                <?php echo CHtml::label('Dari Tahun', 'dari_tanggal', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    echo $form->dropDownList($model, 'thn_awal', CustomFunction::getTahun(null, null), array('class' => "span2", 'onkeypress' => "return $(this).focusNextInputField(event)"));
                    ?>
                </div>
            </div>
        </div>
        <div class="span4">
            <div class='control-group hari'>
                <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                <div class="controls">  
                    <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_akhir',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => "span2",
                            'onkeypress' => "return $(this).focusNextInputField(event)"),
                    ));
                    ?>
                    <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
                </div> 
            </div>
            <div class='control-group bulan'>
                <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                <div class="controls"> 
                    <?php $model->bln_akhir = $format->formatMonthForUser($model->bln_akhir); ?>
                    <?php
                    $this->widget('MyMonthPicker', array(
                        'model' => $model,
                        'attribute' => 'bln_akhir',
                        'options' => array(
                            'dateFormat' => Params::MONTH_FORMAT,
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => "span2",
                            'onkeypress' => "return $(this).focusNextInputField(event)"),
                    ));
                    ?>
                    <?php $model->bln_akhir = $format->formatMonthForDb($model->bln_akhir); ?>
                </div> 
            </div>
            <div class='control-group tahun'>
                <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    echo $form->dropDownList($model, 'thn_akhir', CustomFunction::getTahun(null, null), array('class' => "span2", 'onkeypress' => "return $(this).focusNextInputField(event)"));
                    ?>
                </div>
            </div>
        </div> 
       
    </div>
    <table width="100%" border="0">
                <tr>
                  <td> 
                    <div id='searching'>
                            <fieldset>
                        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
						'id'=>'big',
//                                    'disabled'=>true,
						'content'=>array(
							'content1'=>array(
								'header'=>'Berdasarkan Wilayah',
								'isi'=>'<table><tr><td>'.CHtml::hiddenField('filter', 'wilayah').'<label>Propinsi</label></td><td>'.$form->dropDownList($model, 'propinsi_id', CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array('empty' => '-- Pilih --',
												'ajax' => array('type' => 'POST',
													'url' => $this->createUrl('SetDropdownKabupaten',array('encode'=>false,'model_nama'=>get_class($model))),
													'update' => '#'.CHtml::activeId($model, 'kabupaten_id').''),
												'onkeypress' => "return $(this).focusNextInputField(event)"
											)).'</td></tr><tr><td><label>Kabupaten</label></td><td>'.
											$form->dropDownList($model, 'kabupaten_id', array(), array('empty' => '-- Pilih --',
												'ajax' => array('type' => 'POST',
												'url' => $this->createUrl('SetDropdownKecamatan',array('encode'=>false,'model_nama'=>get_class($model))),
												'update' => '#'.CHtml::activeId($model, 'kecamatan_id').''),
												'onkeypress' => "return $(this).focusNextInputField(event)"
											)).'</td></tr></table>',
//                                                        .$form->dropDownList($model, 'kecamatan_id', array(), array('empty' => '-- Pilih --',
//                                                            'ajax' => array('type' => 'POST',
//                                                                'url' => Yii::app()->createUrl('ActionDynamic/GetKelurahan', array('encode' => false, 'namaModel' => ''.$model->getNamaModel().'')),
//                                                                'update' => '#'.CHtml::activeId($model, 'kelurahan_id').''),
//                                                            'onkeypress' => "return $(this).focusNextInputField(event)"
//                                                        )).'</td></tr><tr><td><label>Kabupaten</label></td><td>'.
//                                                        $form->dropDownList($model, 'kelurahan_id', array(), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")).'</td></tr></table>',
								'active'=>true,
								),   ),
				)); ?>
                </td>
                <td>
                <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
					'id'=>'kunjungan',
					'slide'=>true,
						'content'=>array(
						'content2'=>array(
							'header'=>'Berdasarkan Cara Bayar',
							'isi'=>'<table><tr>
								<td>'.CHtml::hiddenField('filter', 'carabayar',array('disabled'=>'disabled')).'<label>Cara Bayar</label></td>
								<td>'.$form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
									'ajax' => array('type' => 'POST',
								'url' => $this->createUrl('GetPenjaminPasien',array('encode'=>false,'model_nama'=>get_class($model))),
								'update' => '#'.CHtml::activeId($model, 'penjamin_id').''),
																						'onkeypress' => "return $(this).focusNextInputField(event)"
								)).'</td>
									</tr><tr>
								<td><label>Penjamin</label></td><td>'.
								$form->dropDownList($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)).'</td></tr></table>', 'active'=>false,       
					'active'=>false,
					),
				),
			)); ?>
                    </fieldset>
                        </div>
                </td>
            </tr>
            <tr><td><div id='searching'>                                
                        <fieldset>
                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'big',
//                                    'disabled'=>true,
                            'content' => array(
                                'content3' => array(
                                    'header' => 'Berdasarkan Grafik Pengunjung',
                                    'isi' => '<table>
                                                <tr>
                                                <td>' .
                                                $form->radioButtonList($model, 'pilihanx', $model::berdasarkanStatus(), array('value'=>'pengunjung', 'inline'=>true, 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")). '</td></tr></table>',
                                    'active' => true,
                                ),),
//                                    'htmlOptions'=>array('class'=>'aw',)
                        ));
                        ?>                    
                    </fieldset>
                        </div></td>
                </tr>
            
        </table>
		
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
</div>    
<?php
	$this->endWidget();
	$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
	$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
	$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => '')); ?>
<?php $this->renderPartial('_jsFunctions', array('model'=>$model));?>