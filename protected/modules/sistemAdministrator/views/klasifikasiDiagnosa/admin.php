<fieldset class="box row-fluid">
    <legend class="rim">Pengaturan Klasifikasi Diagnosa</legend>
<?php
$this->breadcrumbs=array(
	'Saklasifikasidiagnosa Ms'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('saklasifikasidiagnosa-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<!--<legend class="rim2">Pengaturan Klasifikasi Diagnosa</legend>-->
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-white icon-accordion"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class="cari-lanjut  search-form" style="display:none">
<?php $this->renderPartial($this->path_view.'_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'saklasifikasidiagnosa-m-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
		array(
			'header'=>'No.',
			'value' => '($this->grid->dataProvider->pagination) ? 
					($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
					: ($row+1)',
			'type'=>'raw',
			'htmlOptions'=>array('style'=>'text-align:right;'),
		),
		'klasifikasidiagnosa_kode',
		'klasifikasidiagnosa_nama',
		'klasifikasidiagnosa_namalain',		
		'klasifikasidiagnosa_desc',
                array(
                        'header' => 'Status',
			//'name'=>'klasifikasidiagnosa_aktif',
			'value'=>'($data->klasifikasidiagnosa_aktif) ? "Aktif" : "Tidak Aktif"',
			//'filter'=>array(true=>'Aktif',false=>'Non-aktif'),
		),
		array(
			'header'=>Yii::t('zii','View'),
			'class'=>'bootstrap.widgets.BootButtonColumn',
			'template'=>'{view}',
			'buttons'=>array(
				'view' => array(),
			 ),
		),
		array(
			'header'=>Yii::t('zii','Update'),
			'class'=>'bootstrap.widgets.BootButtonColumn',
			'template'=>'{update}',
			'buttons'=>array(
				'update' => array(),
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
                                    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>"$data->klasifikasidiagnosa_id"))',
                                    'visible'=>'($data->klasifikasidiagnosa_aktif) ? TRUE : FALSE',
                                    'click'=>'function(){ nonActive(this); return false;}',
                                ),
                                'add' => array (
                                        'label'=>"<i class='icon-form-check'></i>",
                                        'options'=>array('rel' => 'tooltip' , 'title'=> 'Mengaktifkan DTD'),
                                        'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>"$data->klasifikasidiagnosa_id", "add"=>1))',
                                        'visible'=>'($data->klasifikasidiagnosa_aktif) ? FALSE : TRUE',
                                        'click'=>'function(){ active(this, 1); return false;}',
                                ),
				'delete'=> array(),
			)
		),
	),
//	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
	'afterAjaxUpdate'=>'function(id, data){
		jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
		$("table").find("input[type=text]").each(function(){
			cekForm(this);
		})
	}',
)); ?>

<?php 
	echo CHtml::link(Yii::t('mds','{icon} Tambah Klasifikasi Diagnosa',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),$this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
	$content = $this->renderPartial($this->path_view.'tips/tipsAdmin',array(),true);
	$this->widget('UserTips',array('content'=>$content));
	$urlPrint= $this->createUrl('print');

$js = <<< JSCRIPT
function cekForm(obj)
{
    $("#saklasifikasidiagnosa-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#saklasifikasidiagnosa-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
?>
<script type="text/javascript">
    function nonActive(obj){
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
                            $.fn.yiiGridView.update('saklasifikasidiagnosa-m-grid');
                        }else{
                            myAlert('Data Gagal di Nonaktifkan.')
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
                });
           }
       });
    }
    
    function active(obj, add){
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
                            $.fn.yiiGridView.update('saklasifikasidiagnosa-m-grid');
                        }else{
                            myAlert('Data Gagal di Aktifkan.')
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
                });
           }
       });
    }
       
</script>
</fieldset>