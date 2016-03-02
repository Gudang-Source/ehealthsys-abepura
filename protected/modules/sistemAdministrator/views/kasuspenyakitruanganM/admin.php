<div class="white-container">
    <legend class="rim2">Pengaturan Kasus <b>Penyakit Ruangan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Kasuspenyakitruangan M'=>array('index'),
            'Manage',
    );

    $arrMenu = array();
            (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kasus Penyakit Ruangan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('rjkasuspenyakitruangan-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    if (isset($_GET['sukses'])):
        Yii::app()->user->setFlash('success','<strong>Berhasil</strong>Data Berhasil disimpan');
    endif;
    
    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="cari-lanjut2 search-form" style="display:none;">
    <?php $this->renderPartial($this->path_view.'_search',array('model'=>$model,)); ?>
    </div><!-- search-form -->
    <!--<div class="block-tabel">-->
        <!--<legend class='rim'>Tabel Kasus Penyakit Ruangan</legend>-->
        <?php $this->widget('ext.bootstrap.widgets.BootGroupGridView',array(
            'id'=>'rjkasuspenyakitruangan-m-grid',
            'dataProvider'=>$model->searchTabel(),
            'filter'=>$model,
            'mergeColumns'=>'ruangan.ruangan_nama',
            'template'=>"{summary}\n{items}{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    array(
                            'name'=>'ruangan.ruangan_nama',
                            'header'=>'Nama Ruangan',
                            'value'=>'$data->ruangan->ruangan_nama',
            ),
                    array(
                            'header'=>'Jenis Kasus Penyakit',
                            'name'=>'jeniskasuspenyakit_id',
                            'value'=>'$data->jeniskasuspenyakit->jeniskasuspenyakit_nama',
			    'filter'=> CHtml::activeDropDownList($model, 'jeniskasuspenyakit_id', CHtml::listData(SAJenisKasusPenyakitM::model()->getItems(),'jeniskasuspenyakit_id','jeniskasuspenyakit_nama'),array('empty'=>'--Pilih--')),
                            'htmlOptions'=>array(
                                    'style'=>'border-left:solid 1px #DDDDDD',
                            ),
                    ),
                    array(
                            'header'=>'Nama Lain Kasus',
                            'name'=>'jeniskasuspenyakit_namalainnya',
                            'value'=>'$data->jeniskasuspenyakit->jeniskasuspenyakit_namalainnya',
                    ),
                    array(
                            'header'=>Yii::t('zii','View'),
                            'class'=>'ext.bootstrap.widgets.BootButtonColumn',
                            'template'=>'{view}',
                            'buttons'=>array(
                                    'view'=>array(
                                            'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/View",array("id"=>"$data->ruangan_id"))',
                                            'options'=>array('rel' => 'tooltip' , 'title'=> 'Lihat Kasus Penyakit Ruangan' ),
                                    ),
                            ),
                    ),
                    array(
                            'header'=>Yii::t('zii','Update'),
                            'class'=>'ext.bootsrap.widgets.BootButtonColumn',
                            'template'=>'{update}',
                            'buttons'=>array(
                                    'update'=>array(
                                            'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Update",array("id"=>"$data->ruangan_id"))',
                                            'options'=>array('rel' => 'tooltip' , 'title'=> 'Ubah Kasus Penyakit Ruangan' ),
                                    ),
                            ),
                    ),
                    array(
                            'header'=>'Hapus',
                            'class'=>'ext.bootstrap.widgets.BootButtonColumn',
                            'template'=>'{delete}',
                            'buttons'=>array(
                                    'delete'=>array(
                                            'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Delete",array("ruangan_id"=>"$data->ruangan_id","jeniskasuspenyakit_id"=>"$data->jeniskasuspenyakit_id"))',
                                            'options'=>array('rel' => 'tooltip' , 'title'=> 'Hapus Kasus Penyakit Ruangan' ),
                                    ),
                            ),
                    ),
            ),
//            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
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
            echo CHtml::link(Yii::t('mds', '{icon} Tambah Kasus Penyakit Ruangan', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";

            echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
            echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
            echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
                    $content = $this->renderPartial('sistemAdministrator.views.tips.master2',array(),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');


    echo "<br />";



$js = <<< JSCRIPT
        function cekForm(obj)
{
    $("#rjkasuspenyakitruangan-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#rjkasuspenyakitruangan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
<script type="text/javascript">
    $(document).ready(function(){
        $("input[name='SAKasuspenyakitruanganM[jeniskasuspenyakit_nama]']").focus();
    })
</script>
</div>