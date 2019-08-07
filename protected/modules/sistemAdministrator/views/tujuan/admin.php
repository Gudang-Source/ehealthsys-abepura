<?php
$this->breadcrumbs=array(
	'Sarekeningcolumn Ms'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('#sarekeningcolumn-m-search').submit(function(){
	$.fn.yiiGridView.update('sarekeningcolumn-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="white-container">
	<legend class="rim2">Pengaturan <b>Tujuan</b></legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-white icon-accordion"></i>')),'#',array('class'=>'search-button btn')); ?>
	<div class="cari-lanjut2 search-form" style="display:none">
	<?php $this->renderPartial($this->path_view.'_search',array(
		'model'=>$model,
	)); ?>
	</div><!-- search-form -->
	<div class="block-tabel">
		<!--<h6 class="rim2">Tabel Periode Posting</h6>-->
	<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'sarekeningcolumn-m-grid',
		'dataProvider'=>$model->search(),
		'filter'=>$model,
		'template'=>"{summary}\n{items}\n{pager}",
		'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
				'header'=>'No.',
				'value' => '($this->grid->dataProvider->pagination) ? 
						($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
						: ($row+1)',
				'type'=>'raw',
				'htmlOptions'=>array('style'=>'text-align:right;'),
			),
			array(
				'header' => 'Diagnosa Keperawatan',
				'name'=>'diagnosakep_nama',
				'value'=>'$data->diagnosakep->diagnosakep_nama',
			),
			array(
				'name'=>'tujuan_nama',
				'value'=>'$data->tujuan_nama',
			),
			array(
				'header'=>'Status',
				'name'=>'tujuan_aktif',
				'value'=>'($data->tujuan_aktif == 1)? "Aktif" :"Tidak Aktif"',
				'filter' => CHtml::dropDownList(
						'aktif', $model->aktif, array('1' => 'Aktif',
					'0' => 'Tidak Aktif',), array('empty' => '--Pilih--'))
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
				'template'=>'{delete}',
				'buttons'=>array(
					
					'delete' => array (
							'label'=>"<i class='icon-delete'></i>",
							'options'=>array('title'=>Yii::t('mds','Delete')),
							'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/delete",array("id"=>"$data->tujuan_id"))',               
					),
				)
			),
		),
		'afterAjaxUpdate'=>'function(id, data){
                jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                $("table").find("input[type=text]").each(function(){
                    cekForm(this);
                })
                 $("table").find("select").each(function(){
                    cekForm(this);
                })
            }',
	)); ?>
</div>
<?php 
	echo CHtml::link(Yii::t('mds','{icon} Tambah Tujuan',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),$this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
	$this->widget('UserTips',array('content'=>''));
	$urlPrint= $this->createUrl('print');
	$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url= Yii::app()->createAbsoluteUrl($module.'/'.$controller);
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sarekeningcolumn-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
?></div>
<script type="text/javascript">	
	  function cekForm(obj)
	{
		$("#sarekeningcolumn-m-search :input[name='"+ obj.name +"']").val(obj.value);
	}
</script>