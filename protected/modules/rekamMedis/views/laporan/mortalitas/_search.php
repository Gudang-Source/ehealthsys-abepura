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
        #penjamin, #ruangan{
            width:250px;
        }
        #penjamin label.checkbox, #ruangan label.checkbox{
            width: 150px;
            display:inline-block;
        }

    </style>
    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
        <div class="row-fluid">
            <div class="span4">
                <?php echo CHtml::label('Kunjungan', 'tglmasukpenunjang', array('class' => 'control-label')) ?>
                <?php echo CHtml::hiddenField('type','',array()); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'jns_periode', array('hari'=>'Hari','bulan'=>'Bulan','tahun'=>'Tahun'), array('class'=>'span2', 'onchange'=>'ubahJnsPeriode();')); ?>
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
                                'maxDate'=>'d',
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
                                'options'=>array(
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
                        echo $form->dropDownList($model, 'thn_awal', CustomFunction::getTahun(null,null), array('class' => "span2",'onkeypress' => "return $(this).focusNextInputField(event)")); 
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
                                'maxDate'=>'d',
                            ),
                            'htmlOptions' => array('readonly' => true,'class' => "span2",
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
                                'options'=>array(
                                    'dateFormat' => Params::MONTH_FORMAT,
                                ),
                                'htmlOptions' => array('readonly' => true,'class' => "span2",
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
                        echo $form->dropDownList($model, 'thn_akhir', CustomFunction::getTahun(null,null), array('class' => "span2",'onkeypress' => "return $(this).focusNextInputField(event)")); 
                        ?>
                    </div>
                </div>
            </div> 
        </div>
        <table width="100%" border="0">
              <tr>
               
                        <td>
                            <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
						'id'=>'big',
						'slide'=>false,
						'content'=>array(
							'content2'=>array(
							'header'=>'Berdasarkan Instalasi dan Ruangan',
							'isi'=>'<table>
										<tr>
											<td>'.'<label>Instalasi</label></td>
											<td>'.$form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
												'ajax' => array('type' => 'POST',
													'url' => $this->createUrl('GetRuanganForCheckBox', array('encode' => false, 'namaModel' => ''.get_class($model).'')),
													'update' => '#ruangan',  //selector to update
												),
											)).'
											</td>
										</tr>
										<tr>
											<td>
												<label>Ruangan</label>
											</td>
											<td>
												<div id="ruangan">
													<label>Data Tidak Ditemukan</label>
												</div>
											</td>
										</tr>
									 </table>',
							 'active'=>true
							),
						),
//                                    'htmlOptions'=>array('class'=>'aw',)
				)); ?>
                        </td>
                </tr>
        </table>
        <div class="form-actions">
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));
            ?>
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), array('class' => 'btn btn-danger', 'onclick' => 'konfirmasi()', 'onKeypress' => 'return formSubmit(this,event)'));
            ?> 
        </div>
        <?php //$this->widget('UserTips', array('type' => 'create')); ?>
    </fieldset>
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<script>
function checkAll(){
        if($('#checkAllRuangan').is(':checked')){
           $('#searchLaporan input[name*="ruangan_id"]').each(function(){
                $(this).attr('checked',true);
           });
        }else{
             $('#searchLaporan input[name*="ruangan_id"]').each(function(){
                $(this).removeAttr('checked');
           });
        }
    }
</script>

