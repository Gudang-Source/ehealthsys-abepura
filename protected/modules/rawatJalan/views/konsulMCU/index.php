<?php // Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB ?>
<?php
	$this->breadcrumbs=array(
		'Konsul Poli',
	);
	$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="block-tabel">
    <h6>Tabel <B>Konsultasi MCU</b></h6>
    <?php $this->renderPartial($this->path_view.'_listKonsulMCU',array('modRiwayatKonsul'=>$modRiwayatKonsul)); ?>
</div>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'rjkonsul-poli-t-form',
    'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#'.CHtml::activeId($modKonsul,'catatan_dokter_konsul'),
)); ?>
    <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
    
    <?php echo $form->errorSummary(array($modKonsul,$modelPendaftaran)); ?>
    <table width="100%">
        <tr>
            <td width="33%">
				<?php echo CHtml::hiddenField('url',$this->createUrl('',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id)),array('readonly'=>TRUE));?>
				<?php echo CHtml::hiddenField('berubah','',array('readonly'=>TRUE));?>
                    
                <div class="control-group ">
                    <?php echo $form->labelEx($modKonsul,'tglkonsulpoli', array('class'=>'control-label')) ?>
                    <?php $modKonsul->tglkonsulpoli = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modKonsul->tglkonsulpoli, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
                    <div class="controls">
                            <?php   
								$this->widget('MyDateTimePicker',array(
									'model'=>$modKonsul,
									'attribute'=>'tglkonsulpoli',
									'mode'=>'datetime',
									'options'=> array(
										'dateFormat'=>Params::DATE_FORMAT,
										'maxDate' => 'd',
									),
									'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker2'),
								));
							?>
                    </div>
                </div>
                <?php echo $form->dropDownListRow($modKonsul,'ruangan_id', CHtml::listData($modKonsul->getRuanganInstalasi(), 'ruangan_id', 'ruangan_nama'),
                                                    array('empty'=>'-- Pilih --','class'=>'span3','disabled'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);",'onchange'=>'setTarif()')); ?>
                <?php echo $form->dropDownListRow($modKonsul,'pegawai_id', CHtml::listData($modKonsul->getDokterItems($modPendaftaran->ruangan_id), 'pegawai_id', 'NamaLengkap'),
                                                    array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
				<?php echo $form->textAreaRow($modKonsul,'catatan_dokter_konsul',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			</td>
            <td width="67%">    
            </td>
        </tr>
    </table>
    <div class="row-fluid">
            <legend class="rim2">Pemeriksaan <b>Medical Check Up</b></legend>
			<fieldset class="box">
				<legend class="rim">Karcis MCU</legend>
				<div class = "span4">
					<?php echo $form->hiddenField($modPendaftaran, 'is_adakarcis', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
					<?php
					$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
						'id' => 'form-karcis',
						'content' => array(
							'content-karcis' => array(
								'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan karcis')) . '<b> Karcis</b>',
								'isi' => $this->renderPartial($this->path_view . '_formKarcis', array(
									'form' => $form,
									'modPendaftaran' => $modPendaftaran,
									'modTindakan' => $modTindakan,
									'modTindakanKarcis' => $modTindakanKarcis,
									'dataTindakans' => $dataTindakans,
										), true),
								'active' => $modPendaftaran->is_adakarcis,
							),
						),
					));
					?>
				</div>
			</fieldset>
            <fieldset class="box">
                <legend class="rim">Paket <b>Medical Check Up</b></legend>
                <div id='content-pemeriksaan-mcu-paket'>
                    <?php
                    $this->renderPartial($this->path_view . '_formCariPemeriksaan', array(
                        'modPaketPelayanan' => $modPaketPelayanan,
                    ));
                    ?>
                    <div class='checklists'></div>
                </div>
            </fieldset>
            <fieldset class="box">
                <legend class="rim">Diluar Paket</legend>
                <div id='content-pemeriksaan-mcu-diluar-paket'>
                <?php
					$this->renderPartial($this->path_view . '_formCariPemeriksaanDiluarPaket', array(
						'modPaketPelayanan' => $modPaketPelayanan,
					));
                ?>
                <div class='checklists-mcu-diluar-paket'></div>
                </div>			
            </fieldset>
            <div class="span12">
                <div class="control-group">
                    <div class="checkbox inline">
                        <label><b>Pernah Ke MCU</b></label>
                        <?php
                        echo CHtml::activeCheckBox($modPemeriksaanMcu, 'pernahmcu', array());
                        ?>
                    </div>
                </div>
                <div class="control-group ">
					<?php echo $form->labelEx($modPemeriksaanMcu, 'tglrencanaperiksa', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $modPemeriksaanMcu->tglrencanaperiksa = (!empty($modPemeriksaanMcu->tglrencanaperiksa) ? date("d/m/Y H:i:s", strtotime($modPemeriksaanMcu->tglrencanaperiksa)) : null);
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modPemeriksaanMcu,
                            'attribute' => 'tglrencanaperiksa',
                            'mode' => 'datetime',
                            'options' => array(
                                //                                    'dateFormat'=>Params::DATE_FORMAT,
                                'showOn' => false,
                                'minDate' => 'd',
                            ),
                            'htmlOptions' => array('class' => 'dtPicker3 datetimemask', 'onkeyup' => "return $(this).focusNextInputField(event)",),
                        ));
                        ?>
                        <?php echo $form->error($modPemeriksaanMcu, 'tglrencanaperiksa'); ?>
                    </div>
                </div>
                <?php echo $form->textAreaRow($modPemeriksaanMcu, 'keteranganpermintaan', array('placeholder' => 'Keterangan Permintaan', 'rows' => 2, 'cols' => 50, 'class' => 'span3 ', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>                
            </div>
            <div class="block-tabel">
                <h6>Tabel Pemeriksaan Medical Check Up</h6>
                <div id="form-tindakanpemeriksaan">
                    <table class="table table-condensed table-striped">
                        <thead>
                        <th>No.</th>
                        <th>Nama Pemeriksaan</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Tarif Tindakan</th>
                        <th>Total Tarif</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="block-tabel">
                <h6>Tabel Pemeriksaan <b>Medical Check Up - Diluar Paket</b></h6>
                <div id="form-tindakanpemeriksaan-diluar-paket">
                    <table class="table table-condensed table-striped">
                        <thead>
                        <th>No.</th>
                        <th>Nama Pemeriksaan</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Tarif Tindakan</th>
                        <th>Total Tarif</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
				array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan')); ?>
	   <?php
            if(isset($_GET['idKonsulPoli'])){
                echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
                echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
                echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp"; 
            }else{
                echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'disabled'=>'disabled'))."&nbsp&nbsp"; 
                echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'disabled'=>'disabled'))."&nbsp&nbsp"; 
                echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'disabled'=>'disabled'))."&nbsp"; 
            }
		?>  								
		<?php 
			$content = $this->renderPartial('rawatJalan.views.tips.tips',array(),true);
			$this->widget('UserTips',array('type'=>'admin','content'=>$content));
			$ruanganMCU = $modKonsul->ruangan_id; // ruangan Klinik MCU (sesuai dengan yg di dropdown)                       
		?>
    </div>
<?php $this->endWidget(); ?>
    
<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogDetailKonsul',
    'options'=>array(
        'title'=>'Detail Konsul',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'resizable'=>false,
        'position'=>'top',
    ),
));
echo '<div id="contentDetailKonsul"></div>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php $this->renderPartial($this->path_view.'_jsFunctions',array(
	'modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,
	'modKonsul'=>$modKonsul,'karcisTindakan'=>$karcisTindakan,
	'modRiwayatKonsul'=>$modRiwayatKonsul,'modelPendaftaran'=>$modelPendaftaran,
	'modJenisTarif'=>$modJenisTarif,'modPaketPelayanan'=>$modPaketPelayanan,
	'modPemeriksaanMcu'=>$modPemeriksaanMcu,'modTindakan'=>$modTindakan,
	'modPermintaanMcu'=>$modPermintaanMcu,'modPasienMasukPenunjang'=>$modPasienMasukPenunjang,
	'modTindakanKarcis'=>$modTindakanKarcis,'dataTindakans'=>$dataTindakans)); ?>