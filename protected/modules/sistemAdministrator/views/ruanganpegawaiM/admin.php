<div class="white-container">
    <legend class="rim2">Pengaturan <b>Ruangan Pegawai</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Ruanganpegawai M'=>array('index'),
            'Manage',
    );

    $arrMenu = array();
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Ruangan Pegawai ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
                    //array_push($arrMenu,array('label'=>Yii::t('mds','List').' SANapzaM', 'icon'=>'list', 'url'=>array('index'))) ;
                    // (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Ruangan Pegawai ', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

    //$this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('rjruanganpegawai-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    if (isset($_GET['sukses'])):
        Yii::app()->user->setFlash('success','<strong>Berhasil</strong> Data Berhasil disimpan');
    endif;
    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="cari-lanjut2 search-form" style="display:none">
    <?php $this->renderPartial($this->path_view.'_search',array('model'=>$model,)); ?>
    </div><!-- search-form -->
    <!--<div class="block-tabel">-->
        <!--<legend class='rim'>Tabel Ruangan Pegawai</legend>-->
        <?php $this->widget('ext.bootstrap.widgets.BootGroupGridView',array(
            'id'=>'rjruanganpegawai-m-grid',
            'dataProvider'=>$model->searchTabel(),
			'filter'=>$model,
			'template'=>"{summary}\n{items}{pager}",
			'itemsCssClass'=>'table table-striped table-condensed',
			'mergeColumns'=>'ruangan_nama',
            'columns'=>array(
                        array(
                            'name'=>'ruangan_nama',
                            'header'=>'Nama Ruangan',
                            'value'=>'$data->ruangan->ruangan_nama',
                            'filter'=>false,
                        ),
                        array(
                            'name'=>'nama_pegawai',
                            'header'=>'Nama Pegawai',
                            'value'=>'$data->pegawai->namalengkap',
                            'filter'=>CHtml::activeTextField($model,'nama_pegawai',array('class'=>'hurufs-only')),
                            'htmlOptions'=>array(
                                'style'=>'border-left: 1px solid #DDDDDD;'
                            ),
                        ),
                        array(
                            'header'=>Yii::t('zii','View'),
                            'class'=>'ext.bootstrap.widgets.BootButtonColumn',
                            'template'=>'{view}',
                            'buttons'=>array(
                                'view'=>array(
                                    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/View",array("id"=>"$data->ruangan_id"))',
                                    'options'=>array('rel' => 'tooltip' , 'title'=> 'Lihat Ruangan Pegawai' ),
                                ),
                            ),
                        ),
            //            array(
         //                   'header'=>Yii::t('zii','Update'),
          //                  'class'=>'ext.bootsrap.widgets.BootButtonColumn',
          //                  'template'=>'{update}',
         //                   'buttons'=>array(
         //                       'update'=>array(
        //                            'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Update",array("id"=>"$data->ruangan_id"))',
        //                            'options'=>array('rel' => 'tooltip' , 'title'=> 'ubah Ruangan Pegawai' ),
        //                        ),
        //                    ),
         //               ),
                        array(
                            'header'=>'Hapus',
                            'class'=>'ext.bootstrap.widgets.BootButtonColumn',
                            'template'=>'{delete}',
                            'buttons'=>array(
                                'delete'=>array(
                                //     'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Delete",array(ruangan_id=>"$data->ruangan_id","pegawai_id"=>"$data->pegawai_id"))',
                                    'options'=>array('rel' => 'tooltip' , 'title'=> 'Hapus Ruangan Pegawai' ),
                                ),
                            ),
                        ),
            ),
             'afterAjaxUpdate'=>'function(id, data){
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
            $(".hurufs-only").keyup(function() {
                setHurufsOnly(this);
            });    
            $("table").find("input[type=text]").each(function(){
                cekForm(this);
            })
        }',
        ));
        ?>
    <!--</div>-->
    <?php 
//            echo CHtml::link(Yii::t('mds', '{icon} Tambah Ruangan Pegawai', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('RuanganpegawaiMLB/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
			echo CHtml::link(Yii::t('mds', '{icon} Tambah Ruangan Pegawai', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";

            echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
            echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
            echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
         $content = $this->renderPartial($this->path_view.'tips/master2',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));	
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#rjruanganpegawai-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
<script type="text/javascript">
    function cekForm(obj)
	{
		$("#rjruanganpegawai-m-search :input[name='"+ obj.name +"']").val(obj.value);
	}
    $(document).ready(function(){
        $('input[name="SARuanganpegawaiM[ruangan_nama]"]').focus();
    })
</script>
</div>