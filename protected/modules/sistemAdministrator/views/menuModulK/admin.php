<div class="white-container">
    <legend class="rim2">Pengaturan <b>Menu</b></legend>
    <?php $this->renderPartial('_tab'); ?>
    <div class='biru'>
        <div class='white'>
            <?php
            $this->breadcrumbs=array(
                    'Samenu Modul Ks'=>array('index'),
                    'Manage',
            );

            $this->menu=array(
            //        array('label'=>Yii::t('mds','Manage').' Menu ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
            //	array('label'=>Yii::t('mds','List').' Menu', 'icon'=>'list', 'url'=>array('index')),
            //	array('label'=>Yii::t('mds','Create').' Menu', 'icon'=>'file', 'url'=>array('create','modul_id'=>(isset($_REQUEST['modul_id']) ? $_REQUEST['modul_id'] : ''))),
            );

            Yii::app()->clientScript->registerScript('search', "
            $('.search-button').click(function(){
                    $('.search-form').toggle();
                $('#SAMenuModulK_kelmenu_id').focus();
                    return false;
            });
            $('.search-form form').submit(function(){
                    $.fn.yiiGridView.update('samenu-modul-k-grid', {
                            data: $(this).serialize()
                    });
                    return false;
            });
            ");

            $this->widget('bootstrap.widgets.BootAlert'); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
            <div class="cari-lanjut3 search-form" style="display:none">
                <?php $this->renderPartial('_search',array(
                        'model'=>$model,
                )); ?>
            </div><!-- search-form -->
            <!--<div class='block-tabel'>-->
<!--                <legend class="rim">Tabel Menu</legend>-->
                <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                    'id'=>'samenu-modul-k-grid',
                    'dataProvider'=>$model->search(),
                    'filter'=>$model,
                    'template'=>"{summary}\n{items}\n{pager}",
                    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                    'columns'=>array(
                            ////'menu_id',
                            array(
                                'name'=>'menu_id',
                                'value'=>'$data->menu_id',
                                'filter'=>false,
                            ),
                            //'kelmenu_id',
                             array(
								'name'=>'modul_id',
								'value'=>'$data->modulk->modul_nama',
								'filter'=> CHtml::dropDownList('SAMenuModulK[modul_id]',$model->modul_id,CHtml::listData($model->getModulItems(), 'modul_id', 'modul_nama'),array('empty'=>'-- Pilih --')),
                            ),
                            array(
								'name'=>'kelmenu_id',
								'value'=>'$data->kelompokmenu->kelmenu_nama',
								'filter'=> CHtml::dropDownList('SAMenuModulK[kelmenu_id]',$model->kelmenu_id,CHtml::listData($model->getKelompokMenuItems(), 'kelmenu_id', 'kelmenu_nama'),array('empty'=>'-- Pilih --')),
                            ),
                            //'kelompokmenu.kelmenu_nama',
                           
                            //'modul_id',
                            //'modulk.modul_nama',
                            'menu_nama',
                            'menu_fungsi',
                           // 'menu_namalainnya',
                            //'menu_url',
                            //'menu_urutan',
                            /*
                            'menu_key',
                            'menu_fungsi',
                            'menu_aktif',
                            */
						/*	array(
								'header'=>'Icon',
								'name'=>'menu_icon',
								'type'=>'raw',
								'value'=>'isset($data->menu_icon) ? "<i class=\'$data->menu_icon\'></i> $data->menu_icon"   : "-"'
							),*/
                            array(
								'header'=>'<center>Status</center>',
								'value'=>'($data->menu_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
								'htmlOptions'=>array('style'=>'text-align:center;'),
                            ),
            //                array(
            //                        'header'=>'Aktif',
            //                        'class'=> 'CCheckBoxColumn',
            //                        'selectableRows'=>0,
            //                        'checked'=>'$data->menu_aktif',
            //                ),
                            array(
								'header'=>Yii::t('zii','View'),
								'class'=>'bootstrap.widgets.BootButtonColumn',
								'template'=>'{view}',
								'buttons'=>array(
										'view'=>array(
												'options'=>array('rel'=>'tooltip','title'=>'Lihat Menu'),
										),
								),
                            ),
                            array(
								'header'=>Yii::t('zii','Update'),
								'class'=>'bootstrap.widgets.BootButtonColumn',
								'template'=>'{update}',
								'buttons'=>array(
										'update'=>array(
												'options'=>array('rel'=>'tooltip','title'=>'Ubah Menu'),
										),
								),
                            ),
                            array(
								'header'=>'Hapus',
								'type'=>'raw',
								'value'=>'($data->menu_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->menu_id)",array("id"=>"$data->menu_id","rel"=>"tooltip","title"=>"Menonaktifkan Menu"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->menu_id)",array("id"=>"$data->menu_id","rel"=>"tooltip","title"=>"Hapus Menu")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->menu_id)",array("id"=>"$data->menu_id","rel"=>"tooltip","title"=>"Hapus Menu"));',
								'htmlOptions'=>array('style'=>'text-align:left; width:80px'),
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
            <!--</div>-->
        </div>
    </div>
    <?php 
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Menu', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('/sistemAdministrator/MenuModulK/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $content = $this->renderPartial('../tips/master',array(),true);
    $this->widget('UserTips',array('type'=>'admin','content'=>$content));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    $url= Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
function cekForm(obj)
{
    $("#samenu-modul-k-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#samenu-modul-k-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
</div>
<script type="text/javascript">
    function removeTemporary(id){
        var url = '<?php echo $url."/removeTemporary"; ?>';
        myConfirm("Yakin akan menonaktifkan data ini untuk sementara?",'Perhatian!',function(r){
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('samenu-modul-k-grid');
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
                                $.fn.yiiGridView.update('samenu-modul-k-grid');
                            }else{
                                myAlert('Data Gagal di Hapus')
                            }
                },"json");
           }
		});
    }
    $('.filters #SAMenuModulK_kelmenu_id').focus();
</script>