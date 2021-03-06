<fieldset class="box row-fluid">
    <legend class="rim">Pengaturan Diagnosa ICD IX</legend>
<?php
$this->breadcrumbs=array(
	'Sadiagnosa Icdixms'=>array('index'),
	'Manage',
);

$arrMenu = array();
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Diagnosa ICD IX ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SADiagnosaICDIXM', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Diagnosa ICD IX', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                
//$this->menu=$arrMenu;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sadiagnosa-icdixm-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class="cari-lanjut search-form" style="display:none">
<?php $this->renderPartial($this->path_view.'_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<!--<legend class='rim'>Tabel Diagnosa ICDIX</legend>-->
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'sadiagnosa-icdixm-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
		////'diagnosaicdix_id',
		array(
                        'name'=>'diagnosaicdix_id',
                        'value'=>'$data->diagnosaicdix_id',
                        'filter'=>false,
                ),
		'diagnosaicdix_kode',
		'diagnosaicdix_nama',
		'diagnosaicdix_namalainnya',
		'diagnosatindakan_katakunci',
		'diagnosaicdix_nourut',
		/*
		'diagnosaicdix_aktif',
		*/
                array(
                    'header'=>'<center>Status</center>',
                    'value'=>'($data->diagnosaicdix_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                    'htmlOptions'=>array('style'=>'text-align:center;'),
                ),
		array(
                        'header'=>Yii::t('zii','View'),
			'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{view}',
                        'buttons'=>array(
                        'view' => array(
                                          'options'=>array('rel' => 'tooltip' , 'title'=> 'Lihat Diagnosa ICD IX' ),
                                        ),
                         ),
		),
		array(
                        'header'=>Yii::t('zii','Update'),
			'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{update}',
                        'buttons'=>array(
                            'update' => array (
                                          'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                          'options'=>array('rel' => 'tooltip' , 'title'=> 'Ubah Diagnosa ICD IX' ),
                                        ),
                         ),
		),
		array(
                        'header'=>Yii::t('zii','Delete'),
			'class'=>'bootstrap.widgets.BootButtonColumn',
                        'htmlOptions'=>array('style'=>'width:80px;'),
                        'template'=>'{remove} {add} {delete}',
                        'buttons'=>array(
                                       'remove' => array (
                                                'label'=>"<i class='icon-form-silang'></i>",
                                                'options'=>array('rel' => 'tooltip' , 'title'=> 'Menonaktifkan DTD'),
                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->diagnosaicdix_id"))',
                                                'visible'=>'($data->diagnosaicdix_aktif) ? TRUE : FALSE',
                                                'click'=>'function(){ removeTemporary(this); return false;}',
                                        ),
                                        'add' => array (
                                                'label'=>"<i class='icon-form-check'></i>",
                                                'options'=>array('rel' => 'tooltip' , 'title'=> 'Mengaktifkan DTD'),
                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->diagnosaicdix_id", "add"=>1))',
                                                'visible'=>'($data->diagnosaicdix_aktif) ? FALSE : TRUE',
                                                'click'=>'function(){ addTemporary(this, 1); return false;}',
                                        ),
                                        'delete'=> array(
//                                                'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                                                'options'=>array('rel' => 'tooltip' , 'title'=> 'Hapus Diagnosa ICD IX' ),
                                        ),
                        )
		),
	),
        'afterAjaxUpdate'=>'function(id, data){
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
            $("table").find("input[type=text]").each(function(){
                cekForm(this);
            })
        }',
)); ?>

<?php 
        echo CHtml::link(Yii::t('mds', '{icon} Tambah Diagnosa ICD IX', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
        
        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $content = $this->renderPartial($this->path_view.'tips/tipsAdmin',array(),true);
			$this->widget('UserTips',array('type'=>'admin','content'=>$content));
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#sadiagnosa-icdixm-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sadiagnosa-icdixm-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
<script type="text/javascript">
    function removeTemporary(obj){
        var url = $(obj).attr('href');
        myConfirm("Yakin akan menonaktifkan data ini untuk sementara?","Perhatian!",function(r) {
            if (r){
                 $.ajax({
                    type:'GET',
                    url:url,
                    data: {},
                    dataType: "json",
                    success:function(data){
                        if(data.status == 'proses_form'){
                            $.fn.yiiGridView.update('sadiagnosa-icdixm-grid');
                        }else{
                            myAlert('Data Gagal di Nonaktifkan.')
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
                });
           }
       });
    }
    
    function addTemporary(obj, add){
        var url = $(obj).attr('href')+$(add).attr('href');
        myConfirm("Yakin akan mengaktifkan data ini untuk sementara?","Perhatian!",function(r) {
            if (r){
                 $.ajax({
                    type:'GET',
                    url:url,
                    data: {},
                    dataType: "json",
                    success:function(data){
                        if(data.status == 'proses_form'){
                            $.fn.yiiGridView.update('sadiagnosa-icdixm-grid');
                        }else{
                            myAlert('Data Gagal di Aktifkan.')
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
                });
           }
       });
    }
    $(document).ready(function(){
        $('input[name="SADiagnosaICDIXM[diagnosaicdix_kode]"]').focus();
    });
</script>
</fieldset>