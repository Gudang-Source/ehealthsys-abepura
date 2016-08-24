<div class="white-container">
    <?php
    $this->breadcrumbs=array(
            'Informasi Faktur Pembelian Umum',
    );

    Yii::app()->clientScript->registerScript('search', "
    $('#fakturpembelianumum-t-search').submit(function(){
            $.fn.yiiGridView.update('fakturpembelianumum-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <legend class="rim2">Informasi Faktur <b>Pembelian Umum</b></legend>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'action'=>Yii::app()->createUrl($this->route),
            'method'=>'get',
            'id'=>'fakturpembelianumum-t-search',
            'type'=>'horizontal',
    )); ?>
    <div class="block-tabel">
        <h6>Table Faktur <b>Pembelian Umum</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
            'id'=>'fakturpembelianumum-m-grid',
            'dataProvider'=>$modFaktur->search(),
            'template'=>"{pager}{summary}\n{items}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    array(
                            'header'=>'Tanggal Terima',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime($data->tglterima)))',
                    ),
					
		'nopenerimaan',
                    'supplier_nama',
                    'nofaktur',
                    array(
                        'header' => 'Tanggal Jatuh Tempo',
                        'name' => 'tgljatuhtempo',
                        'value' => 'MyFormatter::formatDateTimeForUser($data->tgljatuhtempo)'
                    ),                    
                    array(
                            'header'=>'Keterangan Persediaan',
                            'type'=>'raw',
                            'value'=>'$data->keterangan_persediaan',
                    ),
                    array(
                            'header'=>'Umur Hutang',
                            'type'=>'raw',
                            'value'=>'$data->umurHutang',
                            'footer'=>'Total Hutang :',
                            'footerHtmlOptions'=>array('colspan'=>7,'style'=>'text-align:right;'),
                            'htmlOptions' => array('style'=>'text-align:right;')
                    ),
                    array(
                            'header'=>'Total Harga',
                            'name'=>'totalharga',
                            'type'=>'raw',
                            'value'=>'number_format($data->totalharga,0,"",".")',
                            'footer'=>'sum(totalharga)',
                            'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                            'htmlOptions' => array('style'=>'text-align:right;')
                    ),
                    array(
                            'header'=>'Discount',
                            'name'=>'discount',
                            'type'=>'raw',
                            'value'=>'number_format($data->discount,0,"",".")',   
                            'footer'=>'-',
                            'footerHtmlOptions'=>array('style'=>'text-align:right;color:white;'),
                            'htmlOptions' => array('style'=>'text-align:right;')
                    ),
                    array(
                            'header'=>'Pajak PPH',
                            'name'=>'pajakpph',
                            'type'=>'raw',
                            'value'=>'number_format($data->pajakpph,0,"",".")',
                            'footer'=>'-',
                            'footerHtmlOptions'=>array('style'=>'text-align:right;color:white;'),
                            'htmlOptions' => array('style'=>'text-align:right;')
                    ),
                    array(
                            'header'=>'Pajak PPN',
                            'name'=>'pajakppn',
                            'type'=>'raw',
                            'value'=>'number_format($data->pajakppn,0,"",".")',
                            'footer'=>'-',
                            'footerHtmlOptions'=>array('style'=>'text-align:right;color:white;'),
                            'htmlOptions' => array('style'=>'text-align:right;')
                    ),                 
                    array(
                       'header'=>'Details',
                       'type'=>'raw',
                       'htmlOptions'=>array('style'=>'text-align:left;'),
                       'value'=>'CHtml::link("<i class=\'icon-form-detail\'></i> ",Yii::app()->createUrl("keuangan/InformasiFakturUmum/detailsFaktur",array("pembelianbarang_id"=>$data->pembelianbarang_id)) ,array("title"=>"Klik Untuk Melihat Detail Faktur","target"=>"iframe", "onclick"=>"$(\"#dialogDetailsFaktur\").dialog(\"open\");", "rel"=>"tooltip"))',
                       'footer'=>'-',
                       'footerHtmlOptions'=>array('style'=>'text-align:left;color:white;'),
                    ),
                    array( 
                            'header'=>'Bayar ke Supplier',
                            'type'=>'raw',
                            'htmlOptions'=>array('style'=>'text-align:left;'),
                            'value'=>'((empty($data->bayarkesupplier_id)) ? CHtml::link("<i class=\'icon-form-bayar\'></i> ",Yii::app()->createUrl("keuangan/PembayaranKeSupplierUmum/index",array("frame"=>1,"terimapersediaan_id"=>$data->terimapersediaan_id)) ,array("title"=>"Klik Untuk Membayar ke Supplier","target"=>"iframeRetur", "onclick"=>"$(\"#dialogRetur\").dialog(\"open\");", "rel"=>"tooltip")) : "Lunas")',
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
<div class="row-fluid">
	<fieldset class="box" id="divSearch-form">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
		<div class="span5">
			<div class="control-group ">
				<?php //$modFaktur->tgl_awal = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modFaktur->tgl_awal, 'yyyy-MM-dd H:i:s'),'long',null); ?>
				<?php echo CHtml::label('Tanggal Terima','InformasifakturumumV_tgl_awal', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php   
												$modFaktur->tgl_awal = MyFormatter::formatDateTimeForUser($modFaktur->tgl_awal);
						$this->widget('MyDateTimePicker',array(
										'model'=>$modFaktur,
										'attribute'=>'tgl_awal',
										'mode'=>'date',
										'options'=> array(
											'dateFormat'=>Params::DATE_FORMAT,
										),
										'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3 span3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
										),
					)); ?>
				</div>
			</div>
			<div class="control-group ">
				<?php //$modFaktur->tgl_akhir = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modFaktur->tgl_akhir, 'yyyy-MM-dd H:i:s'),'long',null); ?>
				<?php echo CHtml::label('Sampai Dengan','InformasifakturumumV_tgl_akhir', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php   
												$modFaktur->tgl_akhir = MyFormatter::formatDateTimeForUser($modFaktur->tgl_akhir);
						$this->widget('MyDateTimePicker',array(
										'model'=>$modFaktur,
										'attribute'=>'tgl_akhir',
										'mode'=>'date',
										'options'=> array(
											'dateFormat'=>Params::DATE_FORMAT,
										),
										'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3 span3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
										),
					)); ?>
				</div>
			</div>  
		</div>
		<div class="span5">
			<div class="control-group ">
				<?php //$modFaktur->tgl_awalJatuhTempo = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modFaktur->tgl_awalJatuhTempo, 'yyyy-MM-dd'),'medium',null); ?>
				<label class="control-label">
					<?php echo CHtml::checkBox('berdasarkanJatuhTempo','',array('uncheckValue'=>0)); ?>
					Tanggal Jatuh Tempo
				</label>
				<div class="controls">
					<?php   
												$modFaktur->tgl_awalJatuhTempo = MyFormatter::formatDateTimeForUser($modFaktur->tgl_awalJatuhTempo);
						$this->widget('MyDateTimePicker',array(
										'model'=>$modFaktur,
										'attribute'=>'tgl_awalJatuhTempo',
										'mode'=>'date',
										'options'=> array(
											'dateFormat'=>Params::DATE_FORMAT,
										),
										'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3 span3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
										),
					)); ?>
				</div>
			</div>
			<div class="control-group ">
				<?php //$modFaktur->tgl_akhirJatuhTempo = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modFaktur->tgl_akhirJatuhTempo, 'yyyy-MM-dd'),'medium',null); ?>
				<?php echo CHtml::label('Sampai Dengan','InformasifakturumumV_tgl_akhirJatuhTempo', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php   
												$modFaktur->tgl_akhirJatuhTempo = MyFormatter::formatDateTimeForUser($modFaktur->tgl_akhirJatuhTempo);
							$this->widget('MyDateTimePicker',array(
											'model'=>$modFaktur,
											'attribute'=>'tgl_akhirJatuhTempo',
											'mode'=>'date',
											'options'=> array(
												'dateFormat'=>Params::DATE_FORMAT,
											),
											'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3 span3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
											),
						)); ?>
					</div>
			</div>
		</div>
		<div class="span5">
			<?php echo $form->textFieldRow($modFaktur,'nopenerimaan',array('class'=>'angkahuruf-only span3')); ?>
			<?php echo $form->dropDownListRow($modFaktur,'supplier_id',
															 CHtml::listData(SupplierM::model()->findAll(array('order'=>'supplier_nama asc')), 'supplier_id', 'supplier_nama'),
															 array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
															 'empty'=>'-- Pilih --',)); ?>
		</div>
</div>
    
	
		
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
            <?php  
                $content = $this->renderPartial('billingKasir.views.tips.informasi',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
</div>
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
                        'title'=>'Rincian Faktur Pembelian',
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
                    'id'=>'dialogRetur',
                        // additional javascript options for the dialog plugin
                        'options'=>array(
                        'title'=>'Pembayaran Supplier',
                        'autoOpen'=>false,
                        'width'=>1300,
                        'resizable'=>false,
                            "beforeClose"=>'js:function(){$("#divSearch-form form").submit();}'
                         ),
                    ));
?>
<iframe src="" name="iframeRetur" width="100%" height="500">
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
Yii::app()->clientScript->registerScript('javascript',$js,CClientScript::POS_HEAD);