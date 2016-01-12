<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'GET',
            'type' => 'horizontal',
            'id' => 'searchLaporan',
            'htmlOptions' => array(
                'enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'
            ),
        )
    );
?>
	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
	<?php echo $form->errorSummary(array($modPembayaranKlaim,$modPembayaranKlaimDetail)); ?>

<fieldset>
	<div class="row-fluid">
		<div class="span4">
			<div class="control-group">
				<?php echo CHtml::label('Tanggal Pelayanan', 'tgl_pendaftaran',array('class'=>'control-label')); ?>
				<div class="controls">
						<?php   
							$modPendaftaran->tgl_awal = $format->formatDateTimeForUser($modPendaftaran->tgl_awal);
							$this->widget('MyDateTimePicker',array(
											'name' => 'Filter[tgl_awal]',
											'model'=>$modPendaftaran,
											'attribute'=>'tgl_awal',
											'mode'=>'date',
											'options'=> array(
												'dateFormat'=>Params::DATE_FORMAT,
											),
											'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:140px;',
		//                                    'onchange'=>'ajaxGetList()',
											),
							)); 
							$modPendaftaran->tgl_awal = $format->formatDateTimeForDb($modPendaftaran->tgl_awal);
						?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Sampai Dengan', 'sampai dengan',array('class'=>'control-label')); ?>
				<div class="controls">
						<?php   
							$modPendaftaran->tgl_akhir = $format->formatDateTimeForUser($modPendaftaran->tgl_akhir);
							$this->widget('MyDateTimePicker',array(
											'name' => 'Filter[tgl_akhir]',
											'model'=>$modPendaftaran,
											'attribute'=>'tgl_akhir',
											'mode'=>'date',
											'options'=> array(
												'dateFormat'=>Params::DATE_FORMAT,
											),
											'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:140px;',
		//                                    'onchange'=>'ajaxGetList()',
											),
							)); 
							$modPendaftaran->tgl_akhir = $format->formatDateTimeForDb($modPendaftaran->tgl_akhir);
						?>
				</div>
			</div>
		</div>
		<div class="span4">
			<div class="control-group">
				<?php echo CHtml::label('Cara Bayar	<span class="required">*</span>', 'cara bayar',array('class'=>'control-label')); ?>
				<div class="controls">
						<?php 
							echo CHtml::activeDropDownList($modPendaftaran,'carabayar_id', CHtml::listData($modPendaftaran->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama') ,
										array('style'=>'width:120px;','empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",
												'ajax' => array('type'=>'POST',
													'url'=> $this->createUrl('GetPenjaminPasien',array('encode'=>false,'namaModel'=>'BKPendaftaranT')), 
												'update'=>'#BKPendaftaranT_penjamin_id'  //selector to update
										),
							)); 
						?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Penjamin <span class="required">*</span>', 'penjamin',array('class'=>'control-label')); ?>
				<div class="controls">
						<?php 
							echo CHtml::activeDropDownList($modPendaftaran,'penjamin_id', CHtml::listData($modPendaftaran->getPenjaminItems($modPendaftaran->carabayar_id), 
									'penjamin_id', 'penjamin_nama') ,array('style'=>'width:120px;','empty'=>'-- Pilih --',
												'onkeypress'=>"return $(this).focusNextInputField(event)",)); 
						?> 
				</div>
			</div>
		</div>
		<div class="span4">
			<div class="control-group">
				<?php echo CHtml::label('No. Pengajuan <span class="required">*</span>', 'No. Pengajuan',array('class'=>'control-label')); ?>
				<div class="controls">
						<?php echo $form->hiddenField($modPengajuanKlaim, 'pengajuanklaimpiutang_id',array('id'=>'pengajuanklaimpiutang_id')) ?>
						<?php
							if(!isset($_GET['pengajuanklaim_id'])){
							$this->widget('MyJuiAutoComplete', array(
										'name'=>'BKPengajuanklaimpiutangT[nopengajuanklaimanklaim]',
										 'options'=>array(
											   'showAnim'=>'fold',
											   'focus'=> 'js:function( event, ui ) {
													$(this).val(ui.item.value);
													return false;
												}',
											   'select'=>'js:function( event, ui ) {
													ajaxGetList(ui.item.pengajuanklaimpiutang_id);
													return false;
												}',
										),
										'htmlOptions'=>array(
											'placeholder'=>'Pilih No. Pengajuan ',
											'style'=>'width:160px;',
											'class'=>'span2',
											'onchange'=>'ajaxGetList()',
										),
										'tombolDialog'=>array('idDialog'=>'dialogPengajuan','idTombol'=>'tombolPengajuanDialog'),
							));
							}else{
								echo $form->textField($modPengajuanKlaim, 'nopengajuanklaimanklaim',array('id'=>'nopengajuanklaimanklaim','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100,'readonly'=>true));
							}
						?>
				</div>
			</div>
		</div>
	</div>
</fieldset> 
<div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','onClick'=>'ajaxGetList();')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset', 'onClick'=>'onReset()')); ?>
</div>
    
<?php
    $this->endWidget();
?>

<?php 
//========= Dialog buat cari data no pengunjung =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPengajuan',
    'options'=>array(
        'title'=>'Pencarian Data No Pengajuan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>1000,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPengajuan = new BKPengajuanklaimpiutangT('search');
$modPengajuan->unsetAttributes();
if(isset($_GET['BKPengajuanklaimpiutangT'])) {
    $modPengajuan->attributes = $_GET['BKPengajuanklaimpiutangT'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pengajuan-m-grid',
	'dataProvider'=>$modPengajuan->search(),
	'filter'=>$modPengajuan,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectPengajuan",
                                    "onClick" => "$(\"#pengajuanklaimpiutang_id\").val(\"$data->pengajuanklaimpiutang_id\");
                                                  $(\"#BKPengajuanklaimpiutangT_nopengajuanklaimanklaim\").val(\"$data->nopengajuanklaimanklaim\");
                                                  $(\"#dialogPengajuan\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'No. Pengajuan Klaim',
                    'name'=>'nopengajuanklaimanklaim',
                    'value'=>'$data->nopengajuanklaimanklaim',
                ),
                array(
                    'header'=>'Tanggal Pengajuan Klaim',
                    'name'=>'tglpengajuanklaimanklaim',
					'filter'=>false,
                    'value'=>'MyFormatter::formatDateTimeForUser($data->tglpengajuanklaimanklaim)',
                ),
                array(
                    'header'=>'Tanggal Jatuh Tempo',
                    'name'=>'tgljatuhtempo',
					'filter'=>false,
                    'value'=>'MyFormatter::formatDateTimeForUser($data->tgljatuhtempo)',
                ),
               
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end pencarian pasien dialog ====================================
?>