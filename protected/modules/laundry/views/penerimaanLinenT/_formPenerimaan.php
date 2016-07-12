<div class="row-fluid">
	<div class="span4">
                <div class="control-group ">
                    <?php echo CHtml::label('No Pengajuan <font style = "color:red;">*</font>', 'no_perawatan', array('class'=>'control-label required ')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeHiddenField($model, 'pengperawatanlinen_id'); ?>
                    <?php 
                        $this->widget('MyJuiAutoComplete', array(
                            'model'=>$model,
                            'attribute'=>'pengperawatanlinen_no',
                            'source'=>'js: function(request, response) {
                                           $.ajax({
                                               url: "'.$this->createUrl('AutocompletePengLinen').'",
                                               dataType: "json",
                                               data: {
                                                   term: request.term,
                                               },
                                               success: function (data) {
                                                       response(data);
                                               }
                                           })
                                        }',
                             'options'=>array(
                                   'showAnim'=>'fold',
                                   'minLength' => 2,
                                   'focus'=> 'js:function( event, ui ) {
                                        $(this).val("");
                                        return false;
                                    }',
                                   'select'=>'js:function( event, ui ) {
                                        setPengajuanLinen(ui.item.pengperawatanlinen_id);
                                        return false;
                                    }',
                            ),
                            'htmlOptions'=>array(
                                'onkeyup'=>"return $(this).focusNextInputField(event)",
                                'class'=>'span3 required',
                            ),
                            'tombolDialog'=>array('idDialog'=>'dialogPengajuan'),
                        )); 
                        ?>
                    </div>
                </div>
            
            
		<?php echo $form->textFieldRow($model,'nopenerimaanlinen',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
		<div class="control-group ">
			<?php echo $form->labelEx($model, 'tglpenerimaanlinen', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php
				$model->tglpenerimaanlinen = !empty($model->tglpenerimaanlinen) ? $format->formatDateTimeForUser($model->tglpenerimaanlinen) : date('d M Y');
				$this->widget('MyDateTimePicker', array(
					'model' => $model,
					'attribute' => 'tglpenerimaanlinen',
					'mode' => 'date',
					'options' => array(
						'dateFormat' => Params::DATE_FORMAT,
//						'maxDate' => 'd',
					),
					'htmlOptions' => array('readonly' => true, 'class' => 'span2 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
				));
				$model->tglpenerimaanlinen = !empty($model->tglpenerimaanlinen) ? $format->formatDateTimeForDb($model->tglpenerimaanlinen) : date('Y-m-d');
				?>
				<?php echo $form->error($model, 'tglpenerimaanlinen'); ?>
			</div>
		</div>
		<div class="control-group ">
			<?php echo CHtml::label('Instalasi Asal', 'instalasi_nama', array('class' => 'control-label')) ?>
			<div class="controls">
			<?php echo $form->textField($model, 'instalasi_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
			</div>
		</div>
		<div class="control-group ">
			<?php echo CHtml::label('Ruangan Asal', 'ruangan_nama', array('class' => 'control-label')) ?>
			<div class="controls">
			<?php echo $form->hiddenField($model,'ruangan_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
			<?php echo $form->textField($model, 'ruangan_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="control-group ">
			<?php echo CHtml::label('Berat', 'beratlinen', array('class' => 'control-label')) ?>
			<div class="controls">
			<?php echo $form->textField($model, 'beratlinen',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			<?php echo CHtml::label('gram', 'beratlinen') ?>
			</div>
		</div>
		<?php echo $form->textAreaRow($model,'keterangan_penerimaanlinen',array('rows'=>6, 'cols'=>100, 'class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	</div>
	<div class="span4">
		<div class="control-group ">
			<?php echo $form->labelEx($model, 'pegmenerima_id', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->hiddenField($model, 'pegmenerima_id',array('readonly'=>true)); ?>
                            <?php echo $form->textField($model, 'pegawaimenerima_nama',array('readonly'=>true)); ?>
				<?php
				/*$this->widget('MyJuiAutoComplete', array(
					'model'=>$model,
					'attribute' => 'pegawaimenerima_nama',
					'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('AutocompletePegawaiMenerima') . '",
										   dataType: "json",
										   data: {
											   term: request.term,
										   },
										   success: function (data) {
												   response(data);
										   }
									   })
									}',
					'options' => array(
						'showAnim' => 'fold',
						'minLength' => 3,
						'focus' => 'js:function( event, ui ) {
							$(this).val( ui.item.label);
							return false;
						}',
						'select' => 'js:function( event, ui ) {
							$("#'.Chtml::activeId($model, 'pegmenerima_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
					),
					'htmlOptions' => array(
						'class'=>'pegawaimenerima_nama',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
						'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'pegmenerima_id') . '").val(""); '
					),
					'tombolDialog' => array('idDialog' => 'dialogPegawaiMenerima'),
				));*/
				?>
			</div>
		</div>
		<div class="control-group ">
			<?php echo $form->labelEx($model, 'pegmengetahui_id', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->hiddenField($model, 'pegmengetahui_id',array('readonly'=>true)); ?>
				<?php
				$this->widget('MyJuiAutoComplete', array(
					'model'=>$model,
					'attribute' => 'pegawaimengetahui_nama',
					'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('AutocompletePegawaiMengetahui') . '",
										   dataType: "json",
										   data: {
											   term: request.term,
										   },
										   success: function (data) {
												   response(data);
										   }
									   })
									}',
					'options' => array(
						'showAnim' => 'fold',
						'minLength' => 3,
						'focus' => 'js:function( event, ui ) {
							$(this).val( ui.item.label);
							return false;
						}',
						'select' => 'js:function( event, ui ) {
							$("#'.Chtml::activeId($model, 'pegmengetahui_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
					),
					'htmlOptions' => array(
						'class'=>'pegawaimengetahui_nama',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
						'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'pegmengetahui_id') . '").val(""); '
					),
					'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
				));
				?>
			</div>
		</div>
	</div>
</div>
<?php 
//========= Dialog buat cari data Pegawai Menerima =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiMenerima',
    'options'=>array(
        'title'=>'Pencarian Pegawai Menerima',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'zIndex'=>1002,
        'resizable'=>false,
    ),
));

$modPegawaiMenerima = new LAPegawaiV('searchPegawaiMenerima');
$modPegawaiMenerima->unsetAttributes();
if(isset($_GET['LAPegawaiV'])) {
    $modPegawaiMenerima->attributes = $_GET['LAPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimengajukan-grid',
	'dataProvider'=>$modPegawaiMenerima->searchPegawaiMenerima(),
	'filter'=>$modPegawaiMenerima,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#'.CHtml::activeId($model,'pegmenerima_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($model,'pegawaimenerima_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMenerima\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'value'=>'$data->nomorindukpegawai',
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenerima, 'nama_pegawai'),
                    'value'=>'$data->namaLengkap',
                ),
                array(
                    'header'=>'Alamat Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenerima, 'alamat_pegawai'),
                    'value'=>'$data->alamat_pegawai',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end Pegawai Menerima dialog =============================
?>

<?php 
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiMengetahui',
    'options'=>array(
        'title'=>'Pencarian Pegawai Mengetahui',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'zIndex'=>1002,
        'resizable'=>false,
    ),
));

$modPegawaiMengetahui = new LAPegawaiRuanganV('searchDialog');
$modPegawaiMengetahui->unsetAttributes();
if(isset($_GET['LAPegawaiRuanganV'])) {
    $modPegawaiMengetahui->attributes = $_GET['LAPegawaiRuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimengetahui-grid',
	'dataProvider'=>$modPegawaiMengetahui->searchDialog(),
	'filter'=>$modPegawaiMengetahui,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#'.CHtml::activeId($model,'pegmengetahui_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($model,'pegawaimengetahui_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'name' => 'nomorindukpegawai',
                    'value'=>'$data->nomorindukpegawai',
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
                    'value'=>'$data->namaLengkap',
                ),
                array(
                    'header'=>'Alamat Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'alamat_pegawai'),
                    'value'=>'$data->alamat_pegawai',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>


<?php 
//========= Dialog buat cari data Pengajuan Perawatan Linen =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPengajuan',
    'options'=>array(
        'title'=>'Pencarian Pengajuan Linen',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'zIndex'=>1002,
        'resizable'=>false,
    ),
));

$modPengperawatanlinen = new LAPengperawatanlinenT;
if(isset($_GET['LAPengperawatanlinenT']))
{
        $modPengperawatanlinen->attributes=$_GET['LAPengperawatanlinenT'];
        $modPengperawatanlinen->instalasi_id = $_GET['LAPengperawatanlinenT']['instalasi_id'];
}

$crit = new CDbCriteria;
$crit->compare('instalasi_id', $modPengperawatanlinen->instalasi_id);
$crit->addCondition('ruangan_aktif = true');
$crit->order='ruangan_nama ASC';

$dataInstalasi = CHtml::listData(InstalasiM::model()->findAllByAttributes(array(
    'instalasi_aktif'=>true,
), array('order'=>'instalasi_nama asc')), 'instalasi_id', 'instalasi_nama');

$dataRuangan = CHtml::listData(RuanganM::model()->findAll($crit), 'ruangan_id', 'ruangan_nama');

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pengajuanrawatlinen-grid',
	'dataProvider'=>$modPengperawatanlinen->searchInformasiDialog(),
	'filter'=>$modPengperawatanlinen,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#dialogPengajuan\").dialog(\"close\");
                                                  setPengajuanLinen(".$data->pengperawatanlinen_id.");
                                                  return false;
                                        "))',
                ),
                array(
                        'header'=>'No. Pengajuan',
                        'name'=>'pengperawatanlinen_no',
                        'type'=>'raw',
                        'value'=>'$data->pengperawatanlinen_no',
                ),
                array(
                        'header'=>'Tanggal Pengajuan',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tglpengperawatanlinen)',
                ),
                array(
                        'header'=>'Instalasi',
                        'type'=>'raw',
                        'value'=>'$data->ruangan->instalasi->instalasi_nama',
                        'filter'=>CHtml::activeDropDownList($modPengperawatanlinen, 'instalasi_id', $dataInstalasi, array(
                            'empty'=>'-- Pilih --',
                        )),
                ),
                array(
                        'header'=>'Ruangan',
                        'name'=>'ruangan_id',
                        'type'=>'raw',
                        'value'=>'$data->ruangan->ruangan_nama',
                        'filter'=>CHtml::activeDropDownList($modPengperawatanlinen, 'ruangan_id', $dataRuangan, array(
                            'empty'=>'-- Pilih --',
                        )),
                ),
                array(
                        'name'=>'keterangan_pengperawatanlinen',
                        'type'=>'raw',
                        'value'=>'$data->keterangan_pengperawatanlinen',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>