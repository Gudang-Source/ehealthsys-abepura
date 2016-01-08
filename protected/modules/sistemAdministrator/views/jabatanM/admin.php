
<div class="white-container">
    <legend class="rim2">Pengaturan <b>Jabatan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sajabatan Ms'=>array('index'),
            'Manage',
    );

    $arrMenu = array();
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jabatan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Jabatan', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Jabatan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

    $this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
        $('#SAJabatanM_jabatan_nama').focus();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('sajabatan-m-grid', {
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
        <h6>Tabel <b>Jabatan</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'sajabatan-m-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    ////'jabatan_id',
                    array(
                            'name'=>'jabatan_id',
                            'value'=>'$data->jabatan_id',
                            'filter'=>false,
                    ),
                    array(
                            'name'=>'jabatan_nama',
                            'value'=>'$data->jabatan_nama',
                            'filter'=>CHtml::activeTextField($model, 'jabatan_nama'),
                    ),
                    'jabatan_lainnya',

                    array(
                        'header'=>'<center>Status</center>',
                        'value'=>'($data->jabatan_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                        'htmlOptions'=>array('style'=>'text-align:center;'),
                    ),
                    //'jabatan_aktif',
    //                array(
    //                        'header'=>'Aktif',
    //                        'class'=>'CCheckBoxColumn',     
    //                        'selectableRows'=>0,
    //                        'id'=>'rows',
    //                        'checked'=>'$data->jabatan_aktif',
    //                ),
//                    array(
//                            'header'=>Yii::t('zii','View'),
//                            'class'=>'bootstrap.widgets.BootButtonColumn',
//                            'template'=>'{view}',
//                            'buttons'=>array(
//                                'view'=>array(
//                                    'options'=>array('rel'=>'tooltip','title'=>'Lihat Jabatan'),
//                                ),
//                            ),
//                    ),
//                    array(
//                            'header'=>Yii::t('zii','Update'),
//                            'class'=>'bootstrap.widgets.BootButtonColumn',
//                            'template'=>'{update}',
//                            'buttons'=>array(
//                                'update' => array (
//                                            'options'=>array('rel'=>'tooltip','title'=>'Ubah Jabatan'),
//                                            'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
//                                            ),
//                             ),
//                    ), 
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
//                        'header'=>'Hapus',
//                        'type'=>'raw',
//                        'value'=>'($data->jabatan_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->jabatan_id)",array("id"=>"$data->jabatan_id","rel"=>"tooltip","title"=>"Menonaktifkan Jabatan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->jabatan_id)",array("id"=>"$data->jabatan_id","rel"=>"tooltip","title"=>"Hapus Jabatan")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->jabatan_id)",array("id"=>"$data->jabatan_id","rel"=>"tooltip","title"=>"Hapus Jabatan"));',
//                        'htmlOptions'=>array('style'=>'text-align: center; width:80px'),
//                    ),
    		array(
                            'header'=>Yii::t('zii','Delete'),
							'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{remove}{delete}',
                            'buttons'=>array(
									'remove' => array (
											'label'=>"<i class='icon-form-silang'></i>",
											'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
											'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>$data->jabatan_id))',
											'click'=>'function(){nonActive(this);return false;}',
											'visible'=>'Yii::app()->controller->checkAccess(array("action"=>"nonActive"))',
									),
//                                    'delete' => array (
//                                                    'label'=>"<i class='icon-remove'></i>",
//                                                    'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
//                                                    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->jabatan_id"))',
//                                                    'visible'=>'($data->jabatan_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
//                                                    'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
//                                            ),
                                            'delete'=> array(
                                                    'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
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
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Jabatan', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('/sistemAdministrator/jabatanM/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $content = $this->renderPartial('../tips/master',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    $url=Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#sajabatan-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sajabatan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
</div>
<script type="text/javascript">
	function nonActive(obj){
		myConfirm("Yakin akan menonaktifkan data ini untuk sementara?","Perhatian!",
			function(r){
				if(r){ 
					$.ajax({
						type:'GET',
						url:obj.href,
						data: {},//
						dataType: "json",
						success:function(data){
							$.fn.yiiGridView.update('sajabatan-m-grid');
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
    function removeTemporary(id){
        var url = '<?php echo $url."/removeTemporary"; ?>';
        myConfirm("Yakin akan menonaktifkan data ini untuk sementara?",'Perhatian!',function(r){
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('sajabatan-m-grid');
                            }else{
                                myAlert('Data Gagal di Nonaktifkan')
                            }
                },"json");
           }
	   });
    }
    
    function deleteRecord(id){
        var id = id;
        var url = '<?php echo $url."/delete"; ?>';
        myConfirm("Yakin Akan Menghapus Data ini ?",'Perhatian!',function(r){
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('sajabatan-m-grid');
                            }else{
                                myAlert('Data Gagal di Hapus')
                            }
                },"json");
           }
		});
    }
    $('.filters #SAJabatanM_jabatan_nama').focus();
</script>
