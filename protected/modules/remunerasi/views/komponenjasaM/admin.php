<div class="white-container" style = "overflow-x: scroll;">
    <legend class="rim2"  >Pengaturan <b>Komponen Jasa</b></legend>
        <?php
$this->breadcrumbs=array(
	'Komponenjasa Ms'=>array('index'),
	'Manage',
);

$arrMenu = array();
                (Yii::app()->user->checkAccess('Admin')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Komponen Jasa  ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Gelar Belakang', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess('Create')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Komponen Jasa ', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
       
                
$this->menu=$arrMenu;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('komponenjasa-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class="search-form cari-lanjut3" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'komponenjasa-m-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'komponenjasa_id',
		array(
                        'header' => 'ID',
                        //'name'=>'komponenjasa_id',
                        'value'=>'$data->komponenjasa_id',
                        'filter'=>false,
                ),
                array(
                    'header' => 'Komponen Tarif',
                    'name' => 'komponentarif_id',
                    'value' => 'isset($data->komponentarif_id)?$data->komponentarif->komponentarif_nama:""',
                    'filter' => CHtml::activeDropDownList($model,'komponentarif_id',CHtml::listData($model->getKomponentarifItems(),'komponentarif_id','komponentarif_nama'),array('empty'=>'-- Pilih --'))
                ),
                array(
                    'header' => 'Jenis Tarif',
                    'name' => 'jenistarif_id',
                    'value' => 'isset($data->jenistarif_id)?$data->jenistarif->jenistarif_nama:""',
                    'filter' => CHtml::activeDropDownList($model,'jenistarif_id', CHtml::listData($model->getJenistarifItems(), 'jenistarif_id', 'jenistarif_nama'),array('empty'=>'-- Pilih --'))
                ),
                 array(
                    'header' => 'Komponen Tarif',
                    'name' => 'carabayar_id',
                    'value' => 'isset($data->carabayar_id)?$data->carabayar->carabayar_nama:""',
                    'filter' => CHtml::activeDropDownList($model,'carabayar_id',CHtml::listData($model->getCarabayarItems(),'carabayar_id','carabayar_nama'),array('empty'=>'-- Pilih --'))
                ),
		array(
                    'header' => 'Komponen Tarif',
                    'name' => 'kelompoktindakan_id',
                    'value' => 'isset($data->kelompoktindakan_id)?$data->kelompoktindakan->kelompoktindakan_nama:""',
                    'filter' => CHtml::activeDropDownList($model,'kelompoktindakan_id',CHtml::listData($model->getKelompoktindakanItems(),'kelompoktindakan_id','kelompoktindakan_nama'),array('empty'=>'-- Pilih --'))
                ),
                array(
                    'header' => 'Komponen Tarif',
                    'name' => 'ruangan_id',
                    'value' => 'isset($data->ruangan_id)?$data->ruangan->ruangan_nama:""',
                    'filter' => CHtml::activeDropDownList($model,'ruangan_id',CHtml::listData($model->getRuanganItems(),'ruangan_id','ruangan_nama'),array('empty'=>'-- Pilih --'))
                ),						
		'komponenjasa_kode',
		'komponenjasa_nama',
		'komponenjasa_singkatan',
		'besaranjasa',
		'potongan',
		'jasadireksi',
		'kuebesar',
		'jasadokter',
		'jasaparamedis',
		'jasaunit',
		'jasabalanceins',
		'jasaemergency',
		'biayaumum',
		array(
                        'header'=>Yii::t('zii','View'),
			'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{view}',
		),
		array(
                        'header'=>Yii::t('zii','Update'),
			'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{update}',
                        'buttons'=>array(
                            'update' => array (
                                          'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
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
                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->komponenjasa_id"))',
                                                'visible'=>'($data->komponenjasa_aktif) ? TRUE : FALSE',
                                                'click'=>'function(){ removeTemporary(this); return false;}',
                                        ),
                                        'delete'=> array(
                                                'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                                        ),
                        )
		),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>

<?php 
        echo CHtml::link(Yii::t('mds', '{icon} Tambah Komponen Jasa', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
        $content = $this->renderPartial('../tips/master',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#komponenjasa-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
</div>
<script type="text/javascript">
    function removeTemporary(obj){
        var url = $(obj).attr('href');
        myConfirm("Apakah Anda yakin ingin menonaktifkan data ini untuk sementara?","Perhatian!",function(r) {
            if (r){
                 $.ajax({
                    type:'GET',
                    url:url,
                    data: {},
                    dataType: "json",
                    success:function(data){
                        if(data.status == 'proses_form'){
                            $.fn.yiiGridView.update('komponenjasa-m-grid');
                        }else{
                            myAlert('Data Gagal di Nonaktifkan.')
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
                });
           }
       });
    }       
</script> 