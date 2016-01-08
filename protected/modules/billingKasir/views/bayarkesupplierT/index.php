<?php
$this->breadcrumbs=array(
	'Pembayaran Ke Supplier',
);

Yii::app()->clientScript->registerScript('search', "
$('#divSearch-form form').submit(function(){
	$.fn.yiiGridView.update('bayarkesupplier-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<fieldset>
<legend class="rim2">Informasi Pembayaran ke Supplier</legend>
<legend class="rim">Tabel Pembayaran ke Supplier</legend>
<div id="divSearch-form">
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'bayarkesupplier-t-search',
        'type'=>'horizontal',
    'focus'=>'#BayarkesupplierT_nofaktur'
)); ?>
    <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'bayarkesupplier-m-grid',
	'dataProvider'=>$model->searchInformasi(),
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
					array(
						'header'=>'Tanggal Faktur',
						'type'=>'raw',
						'value'=>'MyFormatter::formatDateTimeForUser($data->fakturpembelian->tglfaktur)',
					),
                    'fakturpembelian.nofaktur',
                    'fakturpembelian.supplier.supplier_nama',
                    'tglbayarkesupplier',
                    array(
                        'header'=>'Total Tagihan',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatUang($data->totaltagihan)',
                    ),
//                    'totaltagihan',
                    array(
                        'header'=>'Jumlah Dibayarkan',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatUang($data->jmldibayarkan)',
                    ),
//                    'jmldibayarkan',
                   array( 
                       'header'=>'Batal bayar',
                       'type'=>'raw',
                       'value'=>'CHtml::link("<i class=\'icon-list-alt\'></i> ",Yii::app()->controller->createUrl("BatalBayarSupplier/index",array("frame"=>1,"idFakturPembelian"=>$data->fakturpembelian_id)) ,array("title"=>"Klik Untuk Membatalkan pembayaran ke Supplier","target"=>"iframeBatal", "onclick"=>"$(\"#dialogBatal\").dialog(\"open\");", "rel"=>"tooltip"))',
                        ),    
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
<legend class="rim">Pencarian</legend>
<table>
    <tr>
        <td>
            <div class="control-group ">
                <?php $model->tgl_awal = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_awal, 'yyyy-MM-dd'),'medium',null); ?>
                <?php echo CHtml::label('Tanggal Faktur','BKFakturPembelianT_tgl_awal', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php   
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'tgl_awal',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                ),
                        )); ?>
                    </div>
            </div>
            <div class="control-group ">
                <?php $model->tgl_akhir = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_akhir, 'yyyy-MM-dd'),'medium',null); ?>
                <?php echo CHtml::label('Sampai Dengan','BKFakturPembelianT_tgl_akhir', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php   
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'tgl_akhir',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                ),
                        )); ?>
                    </div>
            </div> 
            <div class="control-group ">
                <?php $model->tgl_awalbayarkesupplier = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_awalbayarkesupplier, 'yyyy-MM-dd'),'medium',null); ?>
                <label class="control-label">
                    <?php echo CHtml::checkBox('berdasarkanpembayaran','',array('uncheckValue'=>0,'onClick'=>'cekTanggal()')); ?>
                    Tanggal Pembayaran
                </label>
                    <div class="controls">
                        <?php   
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'tgl_awalbayarkesupplier',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                ),
                        )); ?>
                    </div>
            </div>
            <div class="control-group ">
                <?php $model->tgl_akhirbayarkesupplier = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_akhirbayarkesupplier, 'yyyy-MM-dd'),'medium',null); ?>
                <?php echo CHtml::label('Sampai Dengan','BayarkesupplierT_tgl_akhirbayarkesupplier', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php   
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'tgl_akhirbayarkesupplier',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                ),
                        )); ?>
                    </div>
            </div> 
        </td>
        <td>
              <?php echo $form->textFieldRow($model,'nofaktur',array('class'=>'numberOnly')); ?>
              <?php echo $form->dropDownListRow($model,'supplier_id',
                                                               CHtml::listData($model->getSupplierItems(), 'supplier_id', 'supplier_nama'),
                                                               array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                               'empty'=>'-- Pilih --',)); ?>
        </td>
    </tr>
</table>
<div class="form-actions">
     <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	 <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	 			<?php  
$content = $this->renderPartial('../tips/informasi2',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
</div>
<?php $this->endWidget(); ?>
    
</div>
</fieldset>
<?php
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$action=$this->getAction()->getId();
$currentUrl=  Yii::app()->createUrl($module.'/'.$controller.'/'.$action);
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'form_hiddenFaktur',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('target'=>'_new'),
        'action'=>Yii::app()->createUrl($module.'/fakturPembelian/index'),
)); ?>
    <?php echo CHtml::hiddenField('idPenerimaanForm','',array('readonly'=>true));?>
    <?php echo CHtml::hiddenField('noPenerimaanForm','',array('readonly'=>true));?>
    <?php echo CHtml::hiddenField('tglPenerimaanForm','',array('readonly'=>true));?>
    <?php echo CHtml::hiddenField('currentUrl',$currentUrl,array('readonly'=>true));?>
<?php $this->endWidget(); ?>
<?php
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id'=>'dialogDetailsFaktur',
                        // additional javascript options for the dialog plugin
                        'options'=>array(
                        'title'=>'Details Permintaan Pembelian',
                        'autoOpen'=>false,
                        'minWidth'=>1100,
                        'minHeight'=>100,
                        'resizable'=>false,
                         ),
                    ));
?>
<iframe src="" name="iframe" width="100%" height="500">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================

// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id'=>'dialogBatal',
                        // additional javascript options for the dialog plugin
                        'options'=>array(
                        'title'=>'Pembatalan pembayaran',
                        'autoOpen'=>false,
                        'minWidth'=>1100,
                        'minHeight'=>100,
                        'resizable'=>false,
                         ),
                    ));
?>
<iframe src="" name="iframeBatal" width="100%" height="500">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================

$js = <<< JSCRIPT
function formFaktur(idPenerimaan,noPenerimaan,tglPenerimaan)
{
    $('#idPenerimaanForm').val(idPenerimaan);
    $('#noPenerimaanForm').val(noPenerimaan);
    $('#tglPenerimaanForm').val(tglPenerimaan);
    $('#form_hiddenFaktur').submit();
}
JSCRIPT;
Yii::app()->clientScript->registerScript('javascript',$js,CClientScript::POS_HEAD); ?>
<script>
document.getElementById('BayarkesupplierT_tgl_awalbayarkesupplier_date').setAttribute("style","display:none;");
document.getElementById('BayarkesupplierT_tgl_akhirbayarkesupplier_date').setAttribute("style","display:none;");
function cekTanggal(){
    var checklist = $('#berdasarkanpembayaran');
    var pilih = checklist.attr('checked');
    if(pilih){
        document.getElementById('BayarkesupplierT_tgl_awalbayarkesupplier_date').setAttribute("style","display:block;");
        document.getElementById('BayarkesupplierT_tgl_akhirbayarkesupplier_date').setAttribute("style","display:block;");
    }else{
        document.getElementById('BayarkesupplierT_tgl_awalbayarkesupplier_date').setAttribute("style","display:none;");
        document.getElementById('BayarkesupplierT_tgl_akhirbayarkesupplier_date').setAttribute("style","display:none;");
    }
}    
</script>
