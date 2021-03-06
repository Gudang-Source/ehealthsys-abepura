<div class="white-container">
    <legend class="rim2">Pengaturan <b>Layar Antrian</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Salayarantrian Ms'=>array('index'),
            'Manage',
    );

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('salayarantrian-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-white icon-accordion"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="cari-lanjut search-form" style="display:none">
        <?php $this->renderPartial($this->path_view.'_search',array(
                'model'=>$model,
        )); ?>
    </div><!-- search-form -->
    <div class="block-tabel">
        <h6>Tabel <b>Layar Antrian</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'salayarantrian-m-grid',
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
                    ////'layarantrian_id',
    //		array(
    //                        'name'=>'layarantrian_id',
    //                        'value'=>'$data->layarantrian_id',
    //                        'filter'=>false,
    //                ),
                    'layarantrian_jenis',
                    'layarantrian_nama',
                    'layarantrian_judul',
                    'layarantrian_runningtext',
                    array(
                        'header' => 'Latar Belakang',
                        'value' => '$data->layarantrian_latarbelakang'
                    ),
                   // 'layarantrian_latarbelakang',
                    array(
                        'header' => 'Status',
                        'value' => '($data->layarantrian_aktif)?"Aktif":"Tidak Aktif"',
                    ),
                    /*
                    'layarantrian_maksitem',
                    'layarantrian_itemhigh',
                    'layarantrian_itemwidth',
                    'layarantrian_intrefresh',
                    'layarantrian_aktif',
                    */
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
                            'template'=>'{remove} {delete}',
                            'buttons'=>array(
                                    'remove' => array (
                                                    'label'=>"<i class='icon-form-silang'></i>",
                                                    'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
                                                    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>$data->layarantrian_id))',
                                                    'click'=>'function(){removeTemporary(this);return false;}',
                                                    'visible' => '($data->layarantrian_aktif)?true:false'
                                    ),
                                    'delete'=> array(),
                            )
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <?php 
    echo CHtml::link(Yii::t('mds','{icon} Tambah Layar Antrian',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),$this->createUrl($this->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $content = $this->renderPartial($this->path_view.'tips/tipsAdmin',array(),true);
    $this->widget('UserTips',array('type'=>'admin','content'=>$content));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#salayarantrian-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
</div>
<script type="text/javascript">
    function removeTemporary(obj){
        myConfirm("Yakin akan menonaktifkan data ini untuk sementara?","Perhatian!",
			function(r){
				if(r){ 
					$.ajax({
						type:'GET',
						url:obj.href,
						data: {},//
						dataType: "json",
						success:function(data){
							$.fn.yiiGridView.update('salayarantrian-m-grid');
							if(data.sukses > 0){
								
							}else{
								myAlert('Data gagal dinonaktifkan!');
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { myAlert('Data gagal dinonaktifkan!'); console.log(errorThrown);}
					});
				}
			}
		);
		return false;
    }
</script>