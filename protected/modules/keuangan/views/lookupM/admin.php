<div class="white-container">
    <legend class='rim2'>Pengaturan <b>Jenis Transaksi</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Lookup Ms'=>array('index'),
            'Manage',
    );

    $this->menu=array(
    //        array('label'=>Yii::t('mds','Manage').' Jenis Transaksi ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
    //	array('label'=>Yii::t('mds','List').' Lookup', 'icon'=>'list', 'url'=>array('index')),
    //	array('label'=>Yii::t('mds','Create').' Lookup', 'icon'=>'file', 'url'=>array('create')),
    );

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('lookup-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="cari-lanjut2 search-form" style="display:none">
        <?php $this->renderPartial('_search',array(
                'model'=>$model,
        )); ?>
    </div><!-- search-form -->
    <!--<div class="block-tabel">-->
        <!--<h6>Tabel <b>Jenis Transaksi</b></h6>-->
        <?php //echo CHtml::dropDownList('agama', '', LookupM::getItems('agama')); ?>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'lookup-m-grid',
            'dataProvider'=>$model->searchJenisTransaksi(),
            'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    ////'lookup_id',
                    array(
                            'header'=>'ID',
                            'value'=>'$data->lookup_id',
                    ),
                    //'lookup_type',
                    array(
                            'name'=>'lookup_type',
                            //'filter'=> CHtml::listData(LookupM::getAllLookupType(), 'lookup_type', 'lookup_type'),
							'value'=>'$data->lookup_type',
                            'filter' => false,
                    ),
                    'lookup_name',
                    'lookup_value',
                    'lookup_kode',
                    'lookup_urutan',

                    array(
                        'header'=>'<center>Status</center>',
                        'value'=>'($data->lookup_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                        'htmlOptions'=>array('style'=>'text-align:center;'),
                    ),
                    //'lookup_aktif',
    //                array(
    //                        'header'=>'Aktif',
    //                        'class'=>'CCheckBoxColumn',     
    //                        'selectableRows'=>0,
    //                        'id'=>'rows',
    //                        'checked'=>'$data->lookup_aktif',
    //                ),
                    array(
                            'header'=>Yii::t('zii','View'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{view}',
                    ),
                    array(
                            'header'=>Yii::t('zii','Update'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{update}',
                    ),
//                    array(
//                            'header'=>Yii::t('zii','Delete'),
//                            'class'=>'bootstrap.widgets.BootButtonColumn',
//                            'template'=>'{delete}',
//                    ),
				array(
                            'header'=>Yii::t('zii','Delete'),
    			'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{remove} {delete}',
                             'deleteConfirmation' => 'Apakah Anda yakin ingin menghapus data ini ?',       
                            'buttons'=>array(
                                    'remove' => array (
                                                   'label'=>"<i class='icon-form-silang'></i>",
                                                    'options'=>array('title'=>Yii::t('mds','Nonaktif Sementara')),
                                                    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>$data->lookup_id))',
                                                    'click'=>'function(){nonActive(this);return false;}',
                                                    'visible'=>'(($data->lookup_aktif) ? TRUE : FALSE)',
								),
//                                            'delete'=> array(
//                                                    'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
//            ),
									'delete'=> array(),
                            )
    		),
//				 array(
//                        'header'=>'Hapus',
//                        'type'=>'raw',
//                        'value'=>'($data->lookup_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->lookup_id)",array("id"=>"$data->lookup_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->lookup_id)",array("id"=>"$data->lookup_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->lookup_id)",array("id"=>"$data->lookup_id","rel"=>"tooltip","title"=>"Hapus"));',
//                        'htmlOptions'=>array('style'=>'text-align: center; width:80px'),
//                    ),
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
    <!--</div>-->
    <?php 
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Jenis Transaksi', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";        
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $content = $this->renderPartial('../tips/master',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
	$url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
	

$js = <<< JSCRIPT
         
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sakonfigfarmasi-k-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
</div>
<script>

</script>

<script type="text/javascript">
	$(document).ready(function(){
        $("input[name='KULookupM[lookup_name]']").focus();
});
	
	function cekForm(obj)
	{
		$("#sakonfigfarmasi-k-search :input[name='"+ obj.name +"']").val(obj.value);
	}
    
    function deleteRecord(id){
        var id = id;
        var url = '<?php echo $url."/delete"; ?>';
        myConfirm('Yakin Akan Menghapus Data ini?','Perhatian!',
        function(r){
            if(r){
                $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('lookup-m-grid');
                            }else{
                                myAlert('Data Gagal di Hapus')
                            }
                },"json");
            }
        }); 
    }
	
	function nonActive(obj){
		myConfirm("Apakah Anda yakin ingin menonaktifkan data ini untuk sementara?","Perhatian!",
			function(r){
				if(r){ 
					$.ajax({
						type:'GET',
						url:obj.href,
						data: {},//
						dataType: "json",
						success:function(data){
							$.fn.yiiGridView.update('lookup-m-grid');
							if(data.sukses > 0){
								myAlert('Data berhasil dinonaktifkan!');
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