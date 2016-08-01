
<div class="white-container">
    <legend class="rim2">Pengaturan Kasus <b>Penyakit Diagnosa</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Kasuspenyakitdiagnosa M'=>array('index'),
            'Manage',
    );

    $arrMenu = array();
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kasus Penyakit Diagnosa', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
                    //array_push($arrMenu,array('label'=>Yii::t('mds','List').' SANapzaM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Diagnosa Kasus Penyakit', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

    $this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
        $('#SAKasuspenyakitdiagnosaM_jeniskasuspenyakit_id').focus();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('rikasuspenyakitdiagnosa-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    if (isset($_GET['sukses'])):
        Yii::app()->user->setFlash('success','<strong>Berhasil</strong> Data berhasil disimpan');
    endif;
    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="cari-lanjut2 search-form" style="display:none">
        <?php $this->renderPartial($this->path_view.'_search',array('model'=>$model,)); ?>
    </div><!-- search-form -->
    <!--<div class="block-tabel">-->
        <!--<h6>Tabel Kasus <b>Penyakit Diagnosa</b></h6>-->
        <?php $this->widget('ext.bootstrap.widgets.BootGroupGridView',array(
            'id'=>'rikasuspenyakitdiagnosa-m-grid',
            'dataProvider'=>$model->searchTabel(),
     	    'filter'=>$model,
            'mergeColumns'=>'jeniskasuspenyakit.jeniskasuspenyakit_nama',
            'mergeCellCss' => 'text-align: left; vertical-align: middle',
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',            
        //                'mergeColumns'=>'jeniskasuspenyakit.jeniskasuspenyakit_nama',
            'columns'=>array(
                        array(
                            'name'=>'jeniskasuspenyakit.jeniskasuspenyakit_nama',
                            'header'=>'Jenis Kasus Penyakit',
                            'value'=>'$data->jeniskasuspenyakit->jeniskasuspenyakit_nama',
                            'filter' => CHtml::DropDownList('SAKasuspenyakitdiagnosaM[jeniskasuspenyakit_id]', $model->jeniskasuspenyakit_id, CHtml::listData($model->getJeniskasuspenyakitItems(),'jeniskasuspenyakit_id','jeniskasuspenyakit_nama'),array('empty'=>'-- Pilih --')),                            
                        ),
                        //'jeniskasuspenyakit.jeniskasuspenyakit_nama',
                        array(
                            'header'=>'Kode Diagnosa',
                            'name' => 'diagnosa_kode',
                            'value'=>'$data->diagnosa->diagnosa_kode',                            
                            'filter'=> CHtml::activeTextField($model,'diagnosa_kode'),
                        ),
                        array(
                            'header'=>'Nama Diagnosa',
                            'name' => 'diagnosa.diagnosa_nama',
                            'value'=>'$data->diagnosa->diagnosa_nama',                            
                            'filter'=> CHtml::activeTextField($model,'diagnosa_nama'),                            
                        ),
                        array(
                            'header'=>'Nama Lainnya',
                            'name' => 'diagnosa.diagnosa_namalainnya',
                            'value'=>'$data->diagnosa->diagnosa_namalainnya',
                            'filter'=> CHtml::activeTextField($model,'diagnosa_namalainnya'),                            
                        ),
                        array(
                            'header'=>Yii::t('zii','View'),
                            'class'=>'ext.bootstrap.widgets.BootButtonColumn',
                            'template'=>'{view}',
                            'buttons'=>array(
                                'view'=>array(
                                    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/View",array("id"=>"$data->jeniskasuspenyakit_id"))',
                                    'options'=>array('rel'=>'tooltip','title'=>'Lihat Kasus Penyakit Diagnosa'),
                                ),
                            ),
                        ),
                        array(
                            'header'=>Yii::t('zii','Update'),
                            'class'=>'ext.bootsrap.widgets.BootButtonColumn',
                            'template'=>'{update}',
                            'buttons'=>array(
                                'update'=>array(
                                    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Update",array("id"=>"$data->jeniskasuspenyakit_id"))',
                                    'options'=>array('rel'=>'tooltip','title'=>'Ubah Kasus Penyakit Diagnosa'),
                                ),
                             ),
                        ),
                        array(
                            'header'=>'Hapus',
                            'class'=>'ext.bootstrap.widgets.BootButtonColumn',
                            'template'=>'{delete}',
                            'buttons'=>array(
                                'delete'=>array(
                                    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Delete",array("jeniskasuspenyakit_id"=>"$data->jeniskasuspenyakit_id","diagnosa_id"=>"$data->diagnosa_id"))',
                                    'options'=>array('rel'=>'tooltip','title'=>'Hapus Kasus Penyakit Diagnosa'),
                                ),
                             ),
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
    <?php 
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Kasus Penyakit Diagnosa', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $content = $this->renderPartial($this->path_view.'tips/tipsAdmin',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
function cekForm(obj)
{
    $("#rikasuspenyakitdiagnosa-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#rikasuspenyakitdiagnosa-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
</div>