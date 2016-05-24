<div class='white-container'>
    <legend class='rim2'>Pengaturan <b>Bank</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Bank Ms'=>array('index'),
            'Manage',
    );

    $arrMenu = array();
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Bank ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Bank', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

    $this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
        $('#SABankRekM_propinsi_id').focus();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('bank-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-white icon-accordion"></i>')),'#',array('class'=>'search-button btn')); ?>
<!--<<<<<<< HEAD:protected/modules/sistemAdministrator/views/bankM/admin.php-->
   <!-- <div class="cari-lanjut search-form" style="display:none">-->
        <!--< //$this->renderPartial($this->path_view .'_search',array(-->
<!--=======-->
    <div class="cari-lanjut2 search-form" style="display:none">
        <?php $this->renderPartial($this->path_view .'_search',array(
                'model'=>$model,
        )); //>>>>>>> 12f1e5a9c072640a387b6430d541776accbca7b2:protected/modules/akuntansi/views/bankM/admin.php?>
    </div><!-- search-form -->
    <!--<div class="block-tabel">-->
        <!--<h6>Tabel <b>Bank</b></h6>-->
        <!-- <div style='max-width:970;overflow-x:scroll'> -->
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'bank-m-grid',
            'dataProvider'=>$model->searchBank(),
            'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                            'header'=>'No',
                            'value'=>'$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
                    ),
                    array(
                            'header'=>'Nama Bank',
                            'name'=>'namabank',
                            'value'=>'isset($data->bank->namabank) ? $data->bank->namabank : "-"',
                    ),
                    array(
                            'header'=>'No. Rekening',
                            'name'=>'norekening',
                            'value'=>'isset($data->bank->norekening) ? $data->bank->norekening : "-"',
                    ),
                    array(
                            'header'=>'Mata Uang',
                            'name'=>'matauang_id',
                            'value'=>'isset($data->bank->matauang->matauang) ? $data->bank->matauang->matauang : "-"',
                            'filter'=> CHtml::dropDownList('SABankRekM[matauang_id]', $model->matauang_id, CHtml::listData(MatauangM::model()->findAll("matauang_aktif = TRUE ORDER BY matauang"), 'matauang_id', 'matauang'), array('empty'=>'-- Pilih --'))
                    ),
                    array(
                            'header'=>'Propinsi',
                            'name'=>'propinsi_nama',
                            'value'=>'isset($data->bank->propinsi->propinsi_nama) ? $data->bank->propinsi->propinsi_nama : "-"',
                    ),
                    array(
							'header'=>'Kabupaten',
							'name'=>'kabupaten_id',
							'value'=>'isset($data->bank->kabupaten->kabupaten_nama) ? $data->bank->kabupaten->kabupaten_nama : "-"',
					),
                    array(
                            'header'=>'Alamat Bank',
                            'name'=>'alamatbank',
                            'value'=>'isset($data->bank->alamatbank) ? $data->bank->alamatbank : "-"',
                    ),
                    array(
                            'header'=>'Cabang dari / <br/> Negara',
                            'name'=>'cabangdari',
                            'value'=>'isset($data->bank->cabangdari) ? $data->bank->cabangdari : "-" ." / ".isset($data->bank->negara) ? $data->bank->negara : "-"',
                    ),
                    array(
                             'header'=>'Rekening Debit',
                             'name'=>'rekening_debit',
                             'type'=>'raw',
                             'value'=>'$this->grid->owner->renderPartial("sistemAdministrator.views.bankM/_rekBankD",array("bank_id"=>$data->bank_id),true)',
                     ),
                    array(
                            'header'=>'Rekening Kredit',
                            'name'=>'rekeningKredit',
                            'type'=>'raw',
                            'value'=>'$this->grid->owner->renderPartial("sistemAdministrator.views.bankM/_rekBankK",array("bank_id"=>$data->bank_id),true)',
                    ),
                    array(
                            'header'=>'Aktif',
                            'value'=>'($data->bank->bank_aktif == TRUE) ? "Aktif" : "Tidak Akitf"',
                    ),
                    array(
                            'header'=>Yii::t('zii','View'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{view}',
                            'buttons'=>array(
                                    'view' => array (
                                            'label'=>"<i class='icon-view'></i>",
                                            'options'=>array('title'=>Yii::t('mds','View')),
                                            'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/view",array("id"=>"$data->bank_id"))',

                                    ),
                            ),
                    ),
                    array(
                            'header'=>Yii::t('zii','Delete'),
                'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{remove} {delete}',
                            'buttons'=>array(
                                    'remove' => array (
                                            'label'=>"<i class='icon-form-silang'></i>",
                                            'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
                                            'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->bank_id"))',
                                            'visible'=>'($data->bank->bank_aktif)?FALSE:FALSE',
                                           // 'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
                                    ),
                                    'delete' => array (
											'label'=>"<i class='icon-delete'></i>",
											'options'=>array('title'=>Yii::t('mds','Delete')),
											'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/delete",array("id"=>"$data->bank_id"))',               
									),
                            )
            ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
        <!-- </div></br> -->
    <!--</div>-->
    <?php 
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Bank', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $content = $this->renderPartial('sistemAdministrator.views.tips.master2',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#bank-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
</div>
<?php 
// Dialog buat lihat penjualan resep =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogUbahRekeningDebitKredit',
    'options'=>array(
        'title'=>'Ubah Data Rekening',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>800,
        'minHeight'=>400,
        'resizable'=>false,
        'close'=>'js:function(){$.fn.yiiGridView.update(\'bank-m-grid\', {})}'
    ),
));
?>
<iframe src="" name="iframeEditRekeningDebitKredit" width="100%" height="300" >
</iframe>
<?php $this->endWidget(); ?>