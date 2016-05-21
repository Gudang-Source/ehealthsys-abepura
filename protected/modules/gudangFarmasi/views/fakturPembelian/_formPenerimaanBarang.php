<div class = "row-fluid">
    <div class="span4">
        <?php echo CHtml::hiddenField('fakturpembelian_id',$modFakturPembelian->fakturpembelian_id, array('class'=>'span3 isRequired','readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event)")) ?>
        <?php // echo $form->textFieldRow($modPenerimaanBarang,'noterima', array('class'=>'span3 isRequired','readonly'=>false, 'onkeypress'=>"return $(this).focusNextInputField(event)")) ?>
		<?php echo CHtml::activehiddenField($modPenerimaanBarang,'penerimaanbarang_id',array('readonly'=>TRUE));?>
		<div class="control-group ">
			<?php echo $form->labelEx($modPenerimaanBarang,'noterima', array('class'=>'control-label')); ?>
			<div class="controls">
				<?php $this->widget('MyJuiAutoComplete',array(
							'model'=>$modPenerimaanBarang,
							'attribute'=>'noterima',
							'sourceUrl'=> $this->createUrl('AutoCompletePenerimaanBarang'),
							'options'=>array(
							   'showAnim'=>'fold',
							   'minLength' => 2,
							   'select'=>'js:function( event, ui ) {
										  $("#'.CHtml::activeId($modPenerimaanBarang,'noterima').'").val(ui.item.noterima);
										  $("#'.CHtml::activeId($modPenerimaanBarang,'penerimaanbarang_id').'").val(ui.item.penerimaanbarang_id);
										  $("#'.CHtml::activeId($modPenerimaanBarang,'tglterima').'").val(ui.item.tglterima);
										  $("#'.CHtml::activeId($modPenerimaanBarang,'supplier_id').'").val(ui.item.supplier_id);
										  $("#'.CHtml::activeId($modPenerimaanBarang,'supplier_nama').'").val(ui.item.supplier_nama);
										setFakturObatAlkes(ui.item.penerimaanbarang_id);
								}',
							),
							'htmlOptions'=>array(
								'disabled'=>false,
								'onkeypress'=>"$(this).focusNextInputField(event)",'class'=>'span3 ','readonly'=>FALSE),
							'tombolDialog' => array('idDialog' => 'dialogPenerimaanBarang'),
				)); 
				?>
			</div>
		</div>
		
    </div>
    <div class="span4">
        <div class="control-group ">
            <?php echo $form->labelEx($modPenerimaanBarang,'tglterima', array('class'=>'control-label')) ?>
            <div class="controls">
				<?php echo $form->textField($modPenerimaanBarang,'tglterima', array('class'=>'span3','readonly'=>false, 'onkeypress'=>"return $(this).focusNextInputField(event)",'readonly'=>true)) ?>
            </div>
        </div>
    </div>
    <div class="span4">
        <div class="control-group">
			<?php echo CHtml::activehiddenField($modPenerimaanBarang,'supplier_id',array('readonly'=>TRUE));?>
			<?php echo $form->textFieldRow($modPenerimaanBarang,'supplier_nama', array('class'=>'span3','readonly'=>false, 'onkeypress'=>"return $(this).focusNextInputField(event)",'readonly'=>true)) ?>
        </div>
    </div>
</div>
<?php 
//========= Dialog buat Permintaan Kebutuhan obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPenerimaanBarang',
    'options'=>array(
        'title'=>'Pencarian Terima Persediaan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$format = new MyFormatter();
$modTerimaPers = new GFInformasipenerimaanbarangV();
if (isset($_GET['GFInformasipenerimaanbarangV'])){
    $modTerimaPers->attributes = $_GET['GFInformasipenerimaanbarangV'];
//    $modTerimaPers->peg_penerima_id = $_GET['GFInformasipenerimaanbarangV']['peg_penerima_id'];
//    $modTerimaPers->tglterima = $format->formatDateTimeForDb($_GET['GFInformasipenerimaanbarangV']['tglterima']);
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'permintaan-m-grid',
	'dataProvider'=>$modTerimaPers->searchDialog(),
	'filter'=>$modTerimaPers,
        'template'=>"{pager}{summary}\n{items}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                    "id" => "selectPenerimaan",
                                    "onClick" => "	$(\"#'.CHtml::activeId($modPenerimaanBarang,'noterima').'\").val(\"$data->noterima\");
													$(\"#'.CHtml::activeId($modPenerimaanBarang,'tglterima').'\").val(\"".MyFormatter::formatDateTimeForUser($data->tglterima)."\")
													$(\"#'.CHtml::activeId($modPenerimaanBarang,'supplier_id').'\").val(\"$data->supplier_id\")
													$(\"#'.CHtml::activeId($modPenerimaanBarang,'supplier_nama').'\").val(\"$data->supplier_nama\")
													$(\"#'.CHtml::activeId($modPenerimaanBarang,'penerimaanbarang_id').'\").val(\"$data->penerimaanbarang_id\")
													$(\"#dialogPenerimaanBarang\").dialog(\"close\");   
													setFakturObatAlkes(\"$data->penerimaanbarang_id\");
                                        "))',
                ),
				'noterima',
                array(
			'name' => 'tglterima',
                        'value' => 'MyFormatter::formatDateTimeForUser($data->tglterima)'
		),
                array(
                        'header'=>'Supplier',
                        'name'=>'supplier_nama',
                ),
				'pegawaimengetahui_nama',
	),
        'afterAjaxUpdate'=>'function(id, data){
            $("#testing").datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional["id"], {"dateFormat":"dd M yy","timeText":"Waktu","hourText":"Jam","minuteText":"Menit","secondText":"Detik","showSecond":true,"timeOnlyTitle":"Pilih Waktu","timeFormat":"hh:mm:ss","changeYear":true,"changeMonth":true,"showAnim":"fold","yearRange":"-80y:+20y"}));
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
$this->endWidget();

//========= end Permintaan dialog =============================
?>