<fieldset id="formNonRacikan" class="table-bordered">
	<legend class="table-bordered radio">
		Pemakaian Bahan
	</legend>                
	<div class="control-group ">
		<label class="control-label" for="namaObat">Nama Obat & Kesehatan</label>
		<div class="controls">
		<?php echo CHtml::hiddenField('url',$this->createUrl('',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id)),array('readonly'=>TRUE));?>
		<?php echo CHtml::hiddenField('berubah','',array('readonly'=>TRUE));?>
		<?php echo CHtml::hiddenField('obatalkes_id'); ?>
		<?php echo CHtml::hiddenField('qty_stok'); ?>
		<?php echo CHtml::hiddenField('satuankecil_id'); ?>
		<?php echo CHtml::hiddenField('satuankecil_nama'); ?>
		<?php echo CHtml::hiddenField('hargajual'); ?>
		<?php echo CHtml::hiddenField('harganetto'); ?>
		<?php echo CHtml::hiddenField('obatalkes_nama'); ?>
		<?php echo CHtml::hiddenField('sumberdana_id'); ?>
			
		<?php 
			$this->widget('MyJuiAutoComplete', array(
				'name'=>'namaObatNonRacik',
				'source'=>'js: function(request, response) {
							   $.ajax({
								   url: "'.$this->createUrl('AutocompleteObatAlkes').'",
								   dataType: "json",
								   data: {
									   term: request.term,
									   sumberdana_id: $("#sumberdana_id").val(),
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
							$(this).val( ui.item.label);
							return false;
						}',
					   'select'=>'js:function( event, ui ) {
							$(this).val(ui.item.value);
							$("#obatalkes_id").val(ui.item.obatalkes_id);
							$("#qty_stok").val(ui.item.qty_stok);
							$("#satuankecil_id").val(ui.item.satuankecil_id);
							$("#satuankecil_nama").val(ui.item.satuankecil_nama);
							$("#hargajual").val(ui.item.hargajual);
							$("#harganetto").val(ui.item.harganetto);
							$("#obatalkes_nama").val(ui.item.obatalkes_nama);
							$("#namaObatNonRacik").val(ui.item.obatalkes_nama);
							$("#sumberdana_id").val(ui.item.sumberdana_id);
							return false;
						}',
				),
				'htmlOptions'=>array(
						'onkeypress'=>"return $(this).focusNextInputField(event)",
				),
				'tombolDialog'=>array('idDialog'=>'dialogAlkes'),
			)); 
		?>
<!--                </div>            -->
			 <?php //echo CHtml::link('<i class="icon-search icon-white"></i>', '#', array('class'=>'btn btn-primary','onclick'=>'$("#dialogAlkes").dialog("open");return false;')); ?>
		</div>
	</div>                
	<div class="control-group ">
		<label class="control-label" for="jumlah">Jumlah</label>
		<div class="controls">
			<?php echo CHtml::textField('qty_input', '1', array('readonly'=>false,'onblur'=>'$("#qty").val(this.value);','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span1 integer')) ?>
			<?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
					array('onclick'=>'inputPemakaianBahan(this);return false;',
						  'class'=>'btn btn-primary',
						  'onkeyup'=>"inputPemakaianBahan(this);",
						  'rel'=>"tooltip",
						  'title'=>"Klik untuk menambahkan resep",)); ?>
		</div>
	</div>
	</fieldset>
<fieldset>
    <legend>
        <?php //echo CHtml::dropDownList('daftartindakanPemakaianBahan', '',array()) ?>
        <?php //echo CHtml::link('<i class="icon-plus icon-white"></i>', '#', array('class'=>'btn btn-primary','onclick'=>'$("#dialogAlkes").dialog("open");return false;')); ?>
        <!--Pemakaian Bahan-->
    </legend>
    <br/>
    <legend class="rim">Tabel Obat & Kesehatan</legend>
    <table class="items table table-striped table-bordered table-condensed" id="tblInputPemakaianBahan">
        <thead>
            <tr>
                <th>&nbsp;</th>
                <th>Bahan Obat & Kesehatan</th>
<!--                <th>Harga</th>-->
                <th>Jumlah</th>
<!--                <th>Sub Total</th>-->
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
    <div>
<!--        <b>Total Pemakaian Bahan : </b>-->
        <b>Total & Jumlah Pemakaian Bahan : </b>
        <?php echo CHtml::textField("totQtyPemakaianBahan", 0,array('readonly'=>true,'class'=>'inputFormTabel integer')); ?>
    </div>
</fieldset>

<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogAlkes',
    'options'=>array(
        'title'=>'Alat Kesehatan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>750,
        'height'=>600,
        'resizable'=>false,
    ),
));

$moObatAlkes = new RIObatalkesM('search');
$moObatAlkes->unsetAttributes();
if(isset($_GET['RIObatalkesM'])){
    $moObatAlkes->attributes = $_GET['RIObatalkesM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'riobat-alkes-m-grid',
	'dataProvider'=>$moObatAlkes->searchObatFarmasi(),
	'filter'=>$moObatAlkes,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
					"id" => "selectObat",
					"onClick" => "
						$(\'#obatalkes_id\').val($data->obatalkes_id);
						$(\'#qty_stok\').val(".StokobatalkesT::getJumlahStok($data->obatalkes_id, Yii::app()->user->getState(\'ruangan_id\')).");
						$(\'#satuankecil_id\').val($data->satuankecil_id);
						$(\'#satuankecil_nama\').val(\'$data->SatuanKecilNama\');
						$(\'#hargajual\').val($data->hargajual);
						$(\'#harganetto\').val($data->harganetto);
						$(\'#obatalkes_nama\').val(\'$data->obatalkes_nama\');
						$(\'#namaObatNonRacik\').val(\'$data->obatalkes_nama\');
						$(\'#sumberdana_id\').val(\'$data->sumberdana_id\');
						$(\'#dialogAlkes\').dialog(\'close\');
						return false;"
						))',
//							"onClick" => "inputPemakaianBahan($data->obatalkes_id);$(\'#dialogAlkes\').dialog(\'close\');return false;"))',
		),
		'obatalkes_kategori',
		'obatalkes_nama',
		'obatalkes_golongan',
		array(
			'name'=>'satuankecilNama',
			'value'=>'$data->satuankecil->satuankecil_nama',
		),
		array(
			'name'=>'sumberdanaNama',
			'value'=>'$data->sumberdana->sumberdana_nama',
		),
		 array(
			'header'=>'Jumlah Stok',
			'type'=>'raw',
			'value'=>'StokobatalkesT::getJumlahStok($data->obatalkes_id, Yii::app()->user->getState("ruangan_id"))',
		),
	),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
?>



