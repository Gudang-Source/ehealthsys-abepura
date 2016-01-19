<?php
$this->breadcrumbs=array(
	'Satugaspengguna Ks'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('satugaspengguna-k-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
$this->widget('bootstrap.widgets.BootAlert'); ?>
<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class="cari-lanjut search-form" style="display:none">
    <?php $this->renderPartial('_search',array(
            'model'=>$model,
    )); ?>
</div><!-- search-form -->
<div class="block-tabel">
    <!--<legend class="rim">Pengaturan Tugas Pemakai</legend>-->
    <?php $this->widget('ext.bootstrap.widgets.BootGroupGridView',array(
        'id'=>'satugaspengguna-k-grid',
        'mergeColumns'=>array('peranpengguna.peranpenggunanama','tugas_nama','tugas_namalainnya','controller_nama'),
        'dataProvider'=>$model->searchTugasPengguna(),
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
                ////             'tugaspengguna_id',
                //               array(
                //               'name'=>'tugaspengguna_id',
                //               'value'=>'$data->tugaspengguna_id',
                //               'filter'=>false,
                //               ),
                array(
                'name'=>'peranpengguna.peranpenggunanama',
                'value'=>'$data->peranpengguna->peranpenggunanama',
                'filter'=>false,
                ),
                'tugas_nama',
                'tugas_namalainnya',
                
                array(
                'name'=>'modul_id',
                'type'=>'raw',
                'value'=>function($data) {
                    $dat = TugaspenggunaK::model()->findAllByAttributes(array('tugas_nama'=>$data->tugas_nama), array(
                        'group'=>'modul_id', 'select'=>'modul_id',
                    ));
                    $str = "<ul>";
                    foreach ($dat as $item) {
                        $str .= "<li>".$item->modul->modul_nama."</li>";
                    }
                    $str .= "</ul>";
                    
                    return $str;
                    //$data->modul->modul_nama;
                },
                //'filter'=>CHtml::listData($model->getNamaModul(), 'modul_id', 'modul_nama')
                ),
                //'controller_nama',
                //'action_nama',
                /*
                'keterangan_tugas',
                'tugaspengguna_aktif',
                'modul_id',
                */
                array(
                'header'=>Yii::t('zii','View'),
                'class'=>'bootstrap.widgets.BootButtonColumn',
                'template'=>'{view}',
                'buttons'=>array(
                        'view' => array(
                                'options'=>array('title'=>Yii::t('mds','View')),
                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/view",array("id"=>"$data->peranpengguna_id"))',                                  
                                ),
                        ),
                ),
                array(
                    'header'=>Yii::t('zii','Update'),
                    'type'=>'raw',
                    'value'=>function($data) {
                        $mod = ModulK::model()->findAll(array('condition'=>'modul_aktif = true', 'order'=>'modul_nama asc'));
                        return CHtml::dropDownList('update_modul', null, CHtml::listData($mod, 'modul_id', 'modul_nama'), array(
                            'empty'=>'-- Update --', 
                            'data-tugas'=>$data->tugas_nama,
                            'onchange'=>"redirectTugas('".$data->tugas_nama."', this);"));
                    }
                    /*
                'class'=>'bootstrap.widgets.BootButtonColumn',
                'template'=>'{update}',
                'buttons'=>array(
                        'update' => array(
                                'options'=>array('title'=>Yii::t('mds','Ubah')),
                                    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/update",array("id"=>$data->tugas_nama, "modul_id"=>$data->modul_id))',					
                                ),
                        ),
                     * 
                     */
                ), /*
                array(
                'header'=>Yii::t('zii','Delete'),
                'class'=>'bootstrap.widgets.BootButtonColumn',
                'template'=>'{delete}',
                'buttons'=>array(
//                        'remove' => array (
//                            'label'=>"<i class='entypo-cancel-circled'></i>",
//                            'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
//                            'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>"$data->tugaspengguna_id"))',
//                            'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
//                            ),
                                                        'delete'=> array(
                                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/delete",array("id"=>"$data->tugaspengguna_id"))',
                                                        ),
                        )
        ),
                 * 
                 */
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); ?>
</div>
<?php 
echo CHtml::link(Yii::t('mds','{icon} Tambah Tugas Pemakai',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),$this->createUrl($this->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp"; 
echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
$this->widget('UserTips',array('type'=>'admin'));
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#satugaspengguna-k-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>


<?php $urlUpdate = Yii::app()->controller->createUrl('update'); ?>
<script>

function redirectTugas(tugas, id) {
   window.location.replace("<?php echo $urlUpdate; ?>&id=" + tugas + "&modul_id=" + $(id).val());
}

</script>