<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<?php
$this->widget('bootstrap.widgets.BootAlert');
?>
	<fieldset class="box">
        <legend class='rim'>Pencarian Aset</legend>
        <div class="search-form" >
            <?php $this->renderPartial('_search',array(
                'model'=>$model,
            )); ?>
        </div><!-- search-form -->
    </fieldset>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'mareevaluasiaset-t-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>

	<div class="block-tabel">
            <h6>Tabel <b>Re-Evaluasi Aset</b></h6>
		<div class="row-fluid">
		<?php
			Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
					$('.search-form').toggle();
					return false;
			});
			$('.search-form form').submit(function(){
					$.fn.yiiGridView.update('aset-t-grid', {
							data: $(this).serialize()
					});
					return false;
			});
			");
			
		$search = new MAReevaluasiasetT('searchReevaluasiAset');
		$search->unsetAttributes();
		if (isset($_GET['MAReevaluasiasetT'])) {
			$search->attributes = $_GET['MAReevaluasiasetT'];
                        if (isset($_GET['MAReevaluasiasetT']['jenis_aset'])) $search->jenis_aset = $_GET['MAReevaluasiasetT']['jenis_aset'];
		}
                
                if (!isset($_GET['ajax']) || !in_array($_GET['ajax'], array('asetDialog-m-grid', 'obatAlkesDialog-m-grid'))) {
		
		$this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'aset-t-grid',
            'dataProvider'=>$search->searchReevaluasiAset(),
            //'filter'=>$search,
			'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
				array(
					'header' => 'Pilih',
					'type' => 'raw',
					'value'=>'CHtml::checkBox("pilih[$row]",null,array("value"=>1,"id"=>"pilih", "class"=>"cb_pilih", "onchange"=>"harga();"))',					
				),
				array(
				   'header' => 'No. Registrasi',
				   'name' => 'noreg',
				   'type'=>'raw',
				   'value'=>'$data->noreg
					   .CHtml::hiddenField("det[$row][invasetlain]",$data->invasetlain_id)
					   .CHtml::hiddenField("det[$row][invtanah]",$data->invtanah_id)
					   .CHtml::hiddenField("det[$row][invperalatan]",$data->invperalatan_id)
					   .CHtml::hiddenField("det[$row][invgedung]",$data->invgedung_id)
					   .CHtml::hiddenField("det[$row][barang_id]",$data->barang_id)
					   .CHtml::hiddenField("det[$row][invjalan]",$data->invjalan_id)',
					), 
				array(
				   'header' => 'Nama Aset',
				   'name' => 'barang_nama',
			   ),
				array(
				   'header' => 'Umur Ekonomis',
				   //'name' => 'umur_ekonomis',
					'type'=>'raw',
				   'value'=>'$data->umur_ekonomis.CHtml::hiddenField("det[$row][ue]",$data->umur_ekonomis,array("class"=>"integer2 ue","style"=>"width:100px;"))'
			   ),
				array(
				   'header' => 'Nilai Buku',
                                    'type'=>'raw',
                                    'htmlOptions'=>array('style'=>'text-align: right'),
                                    'value'=>'MyFormatter::formatNumberForPrint($data->hrg_peroleh - $data->penyusutan).CHtml::hiddenField("det[$row][nb]",$data->hrg_peroleh - $data->penyusutan,array("class"=>"integer2 nb","style"=>"width:100px;"))'
				),
				array(
				   'header' => 'Harga Pasar',
				   'name' => 'harga_pasar',
				   'type'=>'raw',
                                   'htmlOptions'=>array('style'=>'text-align: right'),
				   'value'=>'CHtml::textField("det[$row][hargapasar]",MyFormatter::formatNumberForPrint($data->hrg_peroleh - $data->penyusutan),array("class"=>"integer2 hargapasar","style"=>"width:100px;",
					   "onkeypress"=>"return $(this).focusNextInputField(event)","onkeyup"=>"harga()"))
					   .CHtml::hiddenField("det[$row][penyusutan]",$data->penyusutan,array("class"=>"integer2","style"=>"width:100px;"))
					   .CHtml::hiddenField("det[$row][hrgperolehan]",$data->hrg_peroleh,array("class"=>"integer2","style"=>"width:100px; text-align: right;"))'
					
			   ),
				array(
				   'header' => 'Selisih Re-evaluasi',
				   //'name' => 'selisih',
				   'type'=>'raw',
                                   'htmlOptions'=>array('style'=>'text-align: right'),
				   'value'=>'CHtml::textField("det[$row][selisih]","0",array("class"=>"integer2 selisih","style"=>"width:100px; text-align: right;"))'					
			   ),				
            ),
            'afterAjaxUpdate'=>'function(id, data){'
                    . 'jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});'
                    . '$("#aset-t-grid").find(".integer2:text").maskMoney({"symbol":"Rp. ", "defaultZero":true, "allowZero":true, "decimal":",", "thousands":".", "precision":0})'
                    . '}',
        ));		
                }
		?>			
		</div>
	</div>
<script type="text/javascript">
	function harga(){
            $(".hargapasar").each(function() {
                var hg = parseFloat(unformatNumber($(this).val()));
                var nb = parseFloat(unformatNumber($(this).parents("tr").find(".nb").val()));
                var selisih = hg - nb;
				if (!$(this).parents("tr").find(".cb_pilih").is(":checked")) selisih = 0;
                $(this).parents("tr").find(".selisih").val(formatNumber(selisih));
            });
            /*
		var hg = parseFloat(unformatNumber(document.getElementById("hargapasar").value));
		var nb = parseFloat(unformatNumber(document.getElementById("nb").value));
                console.log(hg, nb);
		var selisih = hg-nb;
		document.getElementById("selisih").value = formatNumber(selisih);	
                */
	}
	function print(id)
	{
		var reevaluasiaset_id = '<?php echo (!empty($model->reevaluasiaset_id)) ? $model->reevaluasiaset_id : null; ?>';
		window.open('<?php echo $this->createUrl('print'); ?>&id='+id+'&caraPrint=PRINT','printwin','left=100,top=100,width=1000,height=640');
	}	
</script>

	<fieldset class="box">
		<legend class="rim">Data Re-evalusi Aset</legend>
		<div class="row-fluid">
			<div class="span4">
				<div class="control-group ">
						<?php echo $form->labelEx($model, 'reevaluasiaset_tgl', array('class' => 'control-label')) ?>
					<div class="controls">
						<?php
							$model->reevaluasiaset_tgl = !empty($model->reevaluasiaset_tgl) ? MyFormatter::formatDateTimeForUser($model->reevaluasiaset_tgl) : date('d M Y H:i:s');
							$this->widget('MyDateTimePicker', array(
								'model' => $model,
								'attribute' => 'reevaluasiaset_tgl',
								'mode' => 'date',
								'options' => array(
									'dateFormat' => Params::DATE_FORMAT,
									'maxDate' => 'd',
								),
								'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 realtime', 'onkeypress' => "return $(this).focusNextInputField(event)",),
							));
							$model->reevaluasiaset_tgl = !empty($model->reevaluasiaset_tgl) ? MyFormatter::formatDateTimeForDb($model->reevaluasiaset_tgl) : date('Y-m-d H:i:s');
						?>
						<?php echo $form->error($model, 'reevaluasiaset_tgl'); ?>
					</div>
				</div>
					<?php echo $form->textFieldRow($model,'reevaluasiaset_no',array('class'=>'span3 all-caps angkahuruf-only', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>25)); ?>
			</div>
			<div class="span4">
				
			<?php echo CHtml::hiddenField('pegawai_id'); ?>
			<label class="control-label">Pegawai Mengetahui</label>
			<div class="controls">
				<?php
				$this->widget('MyJuiAutoComplete', array(
					'name' => 'nama_pegawai',
					'source' => 'js: function(request, response) {
														   $.ajax({
															   url: "' . $this->createUrl('AutocompleteObatReseptur') . '",
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
						'minLength' => 2,
						'select' => 'js:function( event, ui ) {
													   $(this).val( ui.item.label);
													   $("#pegawai_id").val(ui.item.pegawai_id);
													   $("#pegawai_nama").val(ui.item.pegawai_nama);
														return false;
													}',
					),
					'tombolDialog' => array('idDialog' => 'dialogPegawai', 'idTombol' => 'tombolDialogOa'),
					'htmlOptions' => array("rel" => "tooltip", "title" => "Pencarian Data Pegawai",'class'=>'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"),
				));
				?>				
			</div>

			<?php echo CHtml::hiddenField('pegawai_id_'); ?>
			<label class="control-label">Pegawai Menyetujui</label>
			<div class="controls">
				<?php
				$this->widget('MyJuiAutoComplete', array(
					'name' => 'nama_pegawai_',
					'source' => 'js: function(request, response) {
														   $.ajax({
															   url: "' . $this->createUrl('AutocompleteObatReseptur') . '",
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
						'minLength' => 2,
						'select' => 'js:function( event, ui ) {
													   $(this).val( ui.item.label);
													   $("#pegawai_id_").val(ui.item.pegawai_id_);
													   $("#nama_pegawai_").val(ui.item.nama_pegawai_);
														return false;
													}',
					),
					'tombolDialog' => array('idDialog' => 'dialogPegawai_', 'idTombol' => 'tombolDialogOa'),
					'htmlOptions' => array("rel" => "tooltip", "title" => "Pencarian Data Pegawai",'class'=>'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"),
				));
				?>				
			</div>			
				
			</div>
		</div>
	</fieldset>

	<div class="row-fluid">
	<div class="form-actions">
<?php 
			$sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
			$disableSave = false;
			$disableSave = (!empty($_GET['id'])) ? true : ($sukses > 0) ? true : false;; 
		?>
		<?php $disablePrint = ($disableSave) ? false : true; ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','disabled'=>$disableSave)); //formSubmit(this,event) ?>

		<?php
			if(isset($_GET['sukses'])){
				echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('$_GET[id]')",'disabled'=>false));
			}else{
				echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','disabled'=>true));
			}
		?>
		
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('index'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogAset',
    'options' => array(
        'title' => 'Daftar Data Aset',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 900,
        'minHeight' => 400,
        'resizable' => false,
    ),
));

$modAsetDialog = new MAReevaluasiasetT('searchAset');
$modAsetDialog->unsetAttributes();
if (isset($_REQUEST['MAReevaluasiasetT'])) {
    $modAsetDialog->attributes = $_REQUEST['MAReevaluasiasetT'];
    if (isset($_REQUEST['MAReevaluasiasetT']['barang_kode'])) $modAsetDialog->barang_kode = $_REQUEST['MAReevaluasiasetT']['barang_kode'];
    if (isset($_REQUEST['MAReevaluasiasetT']['barang_nama'])) $modAsetDialog->barang_nama = $_REQUEST['MAReevaluasiasetT']['barang_nama'];
    if (isset($_REQUEST['MAReevaluasiasetT']['barang_type'])) $modAsetDialog->barang_type = $_REQUEST['MAReevaluasiasetT']['barang_type'];
    if (isset($_REQUEST['MAReevaluasiasetT']['barang_namalainnya'])) $modAsetDialog->barang_namalainnya = $_REQUEST['MAReevaluasiasetT']['barang_namalainnya'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'asetDialog-m-grid',
    'dataProvider' => $modAsetDialog->searchAset(),
    'filter' => $modAsetDialog,
    //'template' => "{items}\n{pager}",
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Barang/Aset ","class"=>"btn_small",
                "id"=>"selectAset",
                "onClick"=>"
                            $(\"#barang_id\").val(\"$data->barang_id\");
                            $(\"#barang_kode\").val(\"$data->barang_kode\");
                            $(\"#barang_nama\").val(\"$data->barang_nama\");
                            $(\"#dialogAset\").dialog(\"close\");
                            return false;
                ",
               ))'
        ),

	     array(
            'header' => 'Kode Aset',
            'name' => 'barang_kode',
            //'filter' => ,
        ), /*
       array(
            'header' => 'Jenis Aset',
            'name' => 'barang_type',
            'filter' => CHtml::activeDropDownList($modAsetDialog, 'barang_type', LookupM::getItems('barangumumtype'), array('empty'=>'-- Pilih --')),
        ), */
       array(
            'header' => 'Nama Aset',
            'name' => 'barang_nama',
            //'filter' => '',
        ),
       array(
            'header' => 'Nama Aset Lainya',
            'name' => 'barang_namalainnya',
            //'filter' => '',
        ),		
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogNoreg',
    'options' => array(
        'title' => 'Daftar Data Berdasarkan No. Registrasi',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 900,
        'minHeight' => 400,
        'resizable' => false,
    ),
));

$modNoregDialog = new MAReevaluasiasetT('searchNoreg');
$modNoregDialog->unsetAttributes();
if (isset($_GET['BarangV'])) {
    $modNoregDialog->attributes = $_GET['MAReevaluasiasetT'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatAlkesDialog-m-grid',
    'dataProvider' => $modNoregDialog->searchNoreg(),
    'filter' => $modNoregDialog,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Barang/Aset ","class"=>"btn_small",
                "id"=>"selectAset",
                "onClick"=>"
                            $(\"#kode_reg\").val(\"$data->barang_id\");
							$(\"#noreg\").val(\"$data->invasetlain_noregister$data->invtanah_noregister$data->invperalatan_noregister$data->invgedung_noregister$data->invjalan_noregister\");
                            $(\"#dialogNoreg\").dialog(\"close\");
                            return false;
                ",
               ))'
        ),
	     array(
            'header' => 'Inventarisasi Tanah',
            'name' => 'invtanah_noregister',
			 'value'=>'empty($data->invtanah_noregister) ? "Kosong" : "$data->invtanah_noregister / $data->invtanah_namabrg" ',
			 'filter' => '',
        ),
	     array(
            'header' => 'Inventarisasi Peralatan',
            'name' => 'invperalatan_noregister',
			 'value'=>'empty($data->invperalatan_noregister) ? "Kosong" : "$data->invperalatan_noregister / $data->invperalatan_namabrg" ',
			 'filter' => '',
        ),
	     array(
            'header' => 'Inventarisasi Gedung',
            'name' => 'invgedung_noregister',
			 'value'=>'empty($data->invgedung_noregister) ? "Kosong" : "$data->invgedung_noregister / $data->invgedung_namabrg" ',
			 'filter' => '',
        ),
	     array(
            'header' => 'Inventarisasi Jalan',
            'name' => 'invjalan_noregister',
			 'value'=>'empty($data->invjalan_noregister) ? "Kosong" : "$data->invjalan_noregister / $data->invjalan_namabrg" ',
			 'filter' => '',
        ),
	     array(
            'header' => 'Inventarisasi Aset Lain',
            'name' => 'invasetlain_noregister',
			 'value'=>'empty($data->invasetlain_noregister) ? "Kosong" : "$data->invasetlain_noregister / $data->invasetlain_namabrg" ',
			 'filter' => '',
        ),		
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Daftar Data Pegawai Menyetujui',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 900,
        'minHeight' => 400,
        'resizable' => false,
    ),
));

$pegawai = new PegawaiM('search');
$pegawai->unsetAttributes();
if (isset($_GET['PegawaiM'])) {
    $pegawai->attributes = $_GET['PegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaiDialog-m-grid',
    'dataProvider' => $pegawai->search(),
    'filter' => $pegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Barang/Aset ","class"=>"btn_small",
                "id"=>"selectAset",
                "onClick"=>"
                            $(\"#pegawai_id\").val(\"$data->pegawai_id\");
							$(\"#nama_pegawai\").val(\"$data->namaLengkap\");
                            $(\"#dialogPegawai\").dialog(\"close\");
                            return false;
                ",
               ))'
        ),
		'namaLengkap',
		'tempatlahir_pegawai',
		array(
			'name'=>'tgl_lahirpegawai',
			'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_lahirpegawai)',
		),
		'jeniskelamin',
		'statusperkawinan'
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPegawai_',
    'options' => array(
        'title' => 'Daftar Data Pegawai Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 900,
        'minHeight' => 400,
        'resizable' => false,
    ),
));

$pegawai_ = new PegawaiM('search');
$pegawai_->unsetAttributes();
if (isset($_GET['PegawaiM'])) {
    $pegawai_->attributes = $_GET['PegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai_Dialog-m-grid',
    'dataProvider' => $pegawai_->search(),
    'filter' => $pegawai_,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Barang/Aset ","class"=>"btn_small",
                "id"=>"selectAset",
                "onClick"=>"
                            $(\"#pegawai_id_\").val(\"$data->pegawai_id\");
							$(\"#nama_pegawai_\").val(\"$data->namaLengkap\");
                            $(\"#dialogPegawai_\").dialog(\"close\");
                            return false;
                ",
               ))'
        ),
		'namaLengkap',
		'tempatlahir_pegawai',
		array(
			'name'=>'tgl_lahirpegawai',
			'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_lahirpegawai)',
		),
		'jeniskelamin',
		'statusperkawinan'
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
