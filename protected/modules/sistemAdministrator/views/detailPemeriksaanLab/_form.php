<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sapemeriksaanlabdet-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">
		<div class="control-group ">
			<?php echo $form->labelEx($model,'pemeriksaanlab_id', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php 
					$pemeriksaanlab_nama = (isset($model->pemeriksaanlab->pemeriksaanlab_nama) ? $model->pemeriksaanlab->pemeriksaanlab_nama : "");
					echo Chtml::hiddenField('pemeriksaanlab_id',$model->pemeriksaanlab_id,array('readonly'=>true));
					$this->widget('MyJuiAutoComplete', array(
									'name'=>'pemeriksaanlab_nama',
									'value'=>$pemeriksaanlab_nama,
									'source'=>'js: function(request, response) {
												   $.ajax({
													   url: "'.$this->createUrl('AutocompletePemeriksaanLab').'",
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
										   'minLength' => 4,
											'focus'=> 'js:function( event, ui ) {
												 $(this).val( "");
												 return false;
											}',
										   'select'=>'js:function( event, ui ) {
												$(this).val(ui.item.pemeriksaanlab_nama);
												$("#pemeriksaanlab_id").val(ui.item.pemeriksaanlab_id);
												setPemeriksaanLabDet(ui.item.pemeriksaanlab_id);
												return false;
											}',
									),
									'tombolDialog'=>array('idDialog'=>'dialogPemeriksaanLab'),
									'htmlOptions'=>array('placeholder'=>'Ketik Nama Pemeriksaan Lab','rel'=>'tooltip','title'=>'Ketik Nama Pemeriksaan Lab','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3'),
								)); 
				?>
			</div>
		</div>
	</div>
	<div class="block-tabel row-fluid">
            <h6>Tabel Pilih <b>Nilai Rujukan (Referensi)</b></h6>
			<?php echo CHtml::hiddenField('ubahpemeriksaanlabdet_id','',array('readonly'=>true)); ?>
		<div style="margin-left: 30px">
			<?php 
			$modNilaiRujukan=new SANilairujukanM('search');
			$modNilaiRujukan->unsetAttributes();  // clear any default values
			if(isset($_GET['SANilairujukanM'])){
				$modNilaiRujukan->attributes=$_GET['SANilairujukanM'];
			}
			$this->widget('ext.bootstrap.widgets.BootGridView',array(
				'id'=>'sanilairujukan-m-grid',
				'dataProvider'=>$modNilaiRujukan->searchPilih(),
				'filter'=>$modNilaiRujukan,
				'template'=>"{summary}\n{items}\n{pager}",
				'itemsCssClass'=>'table table-striped table-condensed',
				'columns'=>array(
					array(
						'header'=>'Pilih',
						'type'=>'raw',
						'value'=>'CHtml::link("<i class=\'icon-check\'></i>","javascript:void(0);",array("onclick"=>"pilihNilaiRujukan(this);", "class"=>"btn-small", "title"=>"Klik untuk <br>memilih pemeriksaan", "rel"=>"tooltip")).
								CHtml::activeHiddenField($data,"nilairujukan_id",array("readonly"=>true));
								',
					),
					array(
						'header'=>'No.',
						'value' => '($this->grid->dataProvider->pagination) ? 
								($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
								: ($row+1)',
						'type'=>'raw',
						'htmlOptions'=>array('style'=>'text-align:right;'),
					),
					array(
						'name'=>'kelkumurhasillab_id',
						'type'=>'raw',
						'value'=>'isset($data->kelkumurhasillab->kelkumurhasillabnama) ? $data->kelkumurhasillab->kelkumurhasillabnama : "-"',
						'filter'=>CHtml::listData(KelkumurhasillabM::model()->findAll(array('order'=>'kelkumurhasillab_urutan'),'kelkumurhasillab_aktif = true'),'kelkumurhasillab_id','kelkumurhasillabnama'),
					),
					array(
						'name'=>'nilairujukan_jeniskelamin',
						'type'=>'raw',
						'value'=>'$data->nilairujukan_jeniskelamin',
						'filter'=>LookupM::getItems('jeniskelamin'),
					),
					'kelompokdet',
					'namapemeriksaandet',
					'nilairujukan_nama',
					'nilairujukan_min',
					'nilairujukan_max',
					'nilairujukan_satuan',
					'nilairujukan_metode',
				),
				'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
			)); ?>
		
		</div>
	</div>
	<div class="block-tabel row-fluid">
            <h6>Tabel <b>Detail Pemeriksaan</b></h6>
		<table id="table-pemeriksaanlabdet" class="table table-striped table-condensed">
			<thead>
				<th>No. Urut</th>
				<th>Kelompok Umur</th>
				<th>Jenis Kelamin</th>
				<th>Nama Detail</th>
				<th>Nilai Rujukan</th>
				<th>Nilai Minimum</th>
				<th>Nilai Maksimum</th>
				<th>Satuan</th>
				<th>Metode</th>
				<th>Geser</th>
				<th>Hapus</th>
			</thead>
			<tbody>
				
			</tbody>
		</table>
	</div>
	<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('index'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Detail Pemeriksaan',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('type'=>'create'));?>
		</div>
	</div>
<?php $this->endWidget(); ?>

<?php $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model)); ?>
	
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
	'id'=>'dialogPemeriksaanLab',
	'options'=>array(
		'title'=>'Pilih Pemeriksaan Laboratorium',
		'autoOpen'=>false,
		'modal'=>true,
		'width'=>1060,
		'height'=>480,
		'resizable'=>false,
	),
));
	$modPemeriksaanLab=new SAPemeriksaanlabM('search');
	$modPemeriksaanLab->unsetAttributes();  // clear any default values
	if(isset($_GET['SAPemeriksaanlabM'])){
		$modPemeriksaanLab->attributes=$_GET['SAPemeriksaanlabM'];
		$modPemeriksaanLab->daftartindakan_nama=$_GET['SAPemeriksaanlabM']['daftartindakan_nama'];
	}
	
	$this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'sapemeriksaanlab-m-grid',
		'dataProvider'=>$modPemeriksaanLab->searchDialog(),
		'filter'=>$modPemeriksaanLab,
		'template'=>"{summary}\n{items}\n{pager}",
		'itemsCssClass'=>'table table-striped table-condensed',
		'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::link("<i class=\'icon-check\'></i>","javascript:void(0);",
					array("onclick"=>"
							$(\"#pemeriksaanlab_nama\").val(\"$data->pemeriksaanlab_nama\");
							$(\"#pemeriksaanlab_id\").val(\"$data->pemeriksaanlab_id\");
							setPemeriksaanLabDet(\"$data->pemeriksaanlab_id\");
							$(\"#dialogPemeriksaanLab\").dialog(\"close\");
						", 
					"class"=>"btn-small", "title"=>"Klik untuk <br>memilih pemeriksaan", "rel"=>"tooltip"));',
			),
			array(
				'header'=>'No.',
				'value' => '($this->grid->dataProvider->pagination) ? 
						($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
						: ($row+1)',
				'type'=>'raw',
				'htmlOptions'=>array('style'=>'text-align:right;'),
			),
			array(
				'name'=>'jenispemeriksaanlab_id',
				'value'=>'$data->jenispemeriksaan->jenispemeriksaanlab_nama',
				'filter'=>CHtml::listData(JenispemeriksaanlabM::model()->findAll(array('order'=>'jenispemeriksaanlab_urutan'),'jenispemeriksaanlab_aktif = true'), 'jenispemeriksaanlab_id', 'jenispemeriksaanlab_nama'),
			),
			'pemeriksaanlab_kode',
			'pemeriksaanlab_nama',
			array(
				'name'=>'daftartindakan_id',
				'value'=>'$data->daftartindakan->daftartindakan_nama',
				'filter'=>CHtml::activeTextField($modPemeriksaanLab,'daftartindakan_nama'),
			),
		),
		'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":\''.Params::TOOLTIP_PLACEMENT.'\'});}',
	)); 
$this->endWidget();

?>