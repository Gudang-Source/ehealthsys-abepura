<!--<div class='white-container'>-->
    <!--<legend class='rim2'>Pengaturan <b>Rekening Rekonsiliasi Bank</b></legend>-->
	<?php
	$this->breadcrumbs = array(
		'Jenis Penjamin Alkes Ms' => array('index'),
		'Manage',
	);

	$arrMenu = array();
	//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jurnal Rekening Penjamin ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
	//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Jurnal Rekening Penjamin ', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

	$this->menu = $arrMenu;

	Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
        $('#SARekonsiliasibankrekeningM_jenisrekonsiliasibank_nama').focus();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('rekonsiliasibankrek-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

	$this->widget('bootstrap.widgets.BootAlert');
	?>
		<?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
    <div class="cari-lanjut search-form" style="display:none">
		<?php
		$this->renderPartial($this->path_view.'_search', array(
			'model' => $model,
		));
		?>
    </div><!-- search-form -->
    <!--<div class="block-tabel">-->
        <!--<h6>Tabel Jurnal <b>Rekening Penjamin</b></h6>-->
		<?php
		$this->widget('ext.bootstrap.widgets.BootGridView', array(
			'id' => 'rekonsiliasibankrek-m-grid',
			'dataProvider' => $model->searchRekonsiliasi(),
			'filter' => $model,
			'template' => "{summary}\n{items}\n{pager}",
			'itemsCssClass' => 'table table-striped table-bordered table-condensed',
			'columns' => array(
				array(
					'header' => 'No',
					'value' => '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
				),
				array(
					'header' => 'Jenis Rekonsiliasi',
					'name' => 'jenisrekonsiliasibank_nama',
					//                    'filter'=>CHtml::listData(CarabayarM::model()->findAll(),'carabayar_id','carabayar_nama'),
					'value' => '$data->jenisrekonsiliasibank->jenisrekonsiliasibank_nama',
				),
				array(
					'header' => 'Rekening Debit',
					'name' => 'rekening_debit',
					'type' => 'raw',
					'value' => '$this->grid->owner->renderPartial("sistemAdministrator.views.rekonsiliasibankrekeningM/_rekRekonBankD",array("saldonormal"=>"D","jenisrekonsiliasibank_id"=>$data->jenisrekonsiliasibank_id),true)',
				),
				array(
					'header' => 'Rekening Kredit',
					'name' => 'rekeningKredit',
					'type' => 'raw',
					'value' => '$this->grid->owner->renderPartial("sistemAdministrator.views.rekonsiliasibankrekeningM/_rekRekonBankK",array("saldonormal"=>"K","jenisrekonsiliasibank_id"=>$data->jenisrekonsiliasibank_id),true)',
				),
				array(
					'header' => Yii::t('zii', 'View'),
					'class' => 'bootstrap.widgets.BootButtonColumn',
					'template' => '{view}',
					'buttons' => array(
						'view' => array(
							'label' => "<i class='icon-view'></i>",
							'options' => array('title' => Yii::t('mds', 'View')),
							'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/view",array("id"=>"$data->jenisrekonsiliasibank_id"))',
						//'visible'=>'($data->kabupaten_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
						//                                               
						),
					),
				),
				array(
                            'header'=>Yii::t('zii','Delete'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{delete}',
                            'buttons'=>array(
                                    'delete' => array (
                                            'label'=>"<i class='icon-delete'></i>",
                                            'options'=>array('title'=>Yii::t('mds','Delete')),
                                            'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/delete",array("id"=>"$data->jenisrekonsiliasibank_id"))',               
                                    ),
                            )
                    ),
			),
			'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
		));
		?>
    <!--</div>-->
	<?php
	echo CHtml::link(Yii::t('mds', '{icon} Tambah Rekening Rekonsiliasi Bank', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')) . "&nbsp&nbsp";
	echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";

	echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="icon-pdf icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp&nbsp";

	echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp";
	?>
	<?php
	$content = $this->renderPartial('sistemAdministrator.views.tips/master2', array(), true);
	$this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
	$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
	$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
	//$urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
        $urlPrint= $this->createUrl('print');


	/*$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}*/
        $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#jenisrekonsiliasi-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;

	Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
	?>
</div>
<?php
// Dialog buat lihat penjualan resep =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id' => 'dialogUbahRekeningDebitKredit',
	'options' => array(
		'title' => 'Ubah Data Rekening',
		'autoOpen' => false,
		'modal' => true,
		'minWidth' => 600,
		'minHeight' => 400,
		'resizable' => false,
		'close' => 'js:function(){$.fn.yiiGridView.update(\'rekonsiliasibankrek-m-grid\', {})}'
	),
));
?>
<iframe src="" name="iframeEditRekeningDebitKredit" width="100%" height="300" >

</iframe>
<?php $this->endWidget(); ?>