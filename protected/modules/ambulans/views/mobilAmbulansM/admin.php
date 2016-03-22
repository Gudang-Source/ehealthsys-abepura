<div class="white-container">
    <legend class="rim2">Pengaturan <b>Mobil Ambulans</b></legend>
    <?php $this->renderPartial('_tabMenu',array()); ?>
    <div class="biru">
        <div class="white">
            <?php
            //$daftartindakan_nama = CHtml::activeId($model,'inventarisaset_id');
            $this->breadcrumbs=array(
                    'Samobilambulans Ms'=>array('index'),
                    'Manage',
            );
            $arrMenu = array();
            //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Mobil Ambulans ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
            //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Mobil Ambulans', 'icon'=>'list', 'url'=>array('index'))) ;
            //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Mobil Ambulans', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

            $this->menu=$arrMenu;

            Yii::app()->clientScript->registerScript('search', "
            $('.search-button').click(function(){
                    $('.search-form').toggle();
                    $('#inventarisaset').focus();
                    return false;
            });
            $('.search-form form').submit(function(){
                    $.fn.yiiGridView.update('mobil-ambulans-m-grid', {
                            data: $(this).serialize()
                    });
                    return false;
            });
            ");

            $this->widget('bootstrap.widgets.BootAlert'); ?>
            
            <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
            <div class="cari-lanjut3 search-form" style="display:none">
                <?php $this->renderPartial('_search',array(
                        'model'=>$model
                )); ?>
            </div><!-- search-form -->
            <!--<div class="block-tabel">-->
                <!--<h6>Tabel <b>Mobil Ambulans</b></h6>-->
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id'=>'mobil-ambulans-m-grid',
                    'dataProvider'=>$model->search(),
                    'filter'=>$model,
                            'itemsCssClass'=>'table table-striped table-condensed',
                            'template'=>"{summary}\n{items}\n{pager}",
                    'columns'=>array(
                            array(
                                'header'=>'ID',
                                'value'=>'$data->mobilambulans_id',
                            ),
                             array(
                                'header'=>'Inventaris Aset',
                                 'name' => 'barang_nama',
                                'value'=> function($model){                                    
                                        $r = $model->getNamaBarang($model->inventarisaset_id);
                                        return $r;
                                },
                                
                                //'filter'=>  CHtml::activeTextField($model,'inventarisaset_id'),
                            ),
                            array(
                                'header'=>'Kode',
                                'value'=>'$data->mobilambulans_kode',
                                'filter'=>  CHtml::activeTextField($model,'mobilambulans_kode'),
                            ),
                            'nopolisi',
                            //'jeniskendaraan',
                            array(
                                'header' => 'Jenis Kendaraan',
                                'name' => 'jeniskendaraan',
                                'value' => '$data->jeniskendaraan',
                                'filter' => CHtml::dropDownList('MobilambulansM[jeniskendaraan]',$model->jeniskendaraan,CHtml::listData($model->JenisKendaraanItems, 'lookup_name', 'lookup_value'),array('empty'=>'--Pilih--')),
                            ),         
                            'isibbmliter',
                             array(
                                'header'=>'<center>Status</center>',
                                'value'=>'($data->mobilambulans_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                                'htmlOptions'=>array('style'=>'text-align:center;'),
                            ),
            //                array(
            //                    'header'=>'Aktif',
            //                    'class'=>'CCheckBoxColumn',     
            //                    'selectableRows'=>0,
            //                    'id'=>'rows',
            //                    'checked'=>'$data->mobilambulans_aktif',
            //                ),
                            array(
                                'header'=>Yii::t('zii','View'),
                                'class'=>'ext.bootstrap.widgets.BootButtonColumn',
                                'template'=>'{view}',
                                'buttons'=>array(                            
                                        'view'=>array(
                                            'options'=>array('rel'=>'tooltip','title'=>'Lihat Mobil Ambulans'),
                                        ),
                                    ),
                            ),
                            array(
                                'header'=>Yii::t('zii','Update'),
                                'class'=>'ext.bootstrap.widgets.BootButtonColumn',
                                'template'=>'{update}',
                                'buttons'=>array(                            
                                        'update'=>array(
                                            'options'=>array('rel'=>'tooltip','title'=>'Ubah Mobil Ambulans'),
                                        ),
                                    ),
                            ),
                            array(
                                'header'=>'<center>Hapus</center>',
                                'class'=>'ext.bootstrap.widgets.BootButtonColumn',
                                'template'=>'{remove}{delete}',
                                'buttons'=>array(
                                                    'remove' => array
                                                        (
                                                            'label'=>"<i class='icon-form-silang'></i>",
                                                            'options'=>array('rel'=>'tooltip','title'=>'Menonaktifkan Mobil Ambulans'),
                                                            'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->mobilambulans_id"))',
                                                            //'visible'=>'($data->mobilambulans_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
                                                            'visible'=>'($data->mobilambulans_aktif) ? TRUE : FALSE',
                                                            'click'=>'function(){ removeTemporary(this); return false;}',
                                                        ),
                                                      'delete' => array
                                                        (
                                                            'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                                                            'options'=>array('rel'=>'tooltip','title'=>'Hapus Mobil Ambulans'),
                                                        ),
                                ),
                            ),
                            /*
                            'kmterakhirkend',
                            'photokendaraan',
                            'hargabbmliter',
                            'formulajasars',
                            'formulajasaba',
                            'formulajasapel',
                            'mobilambulans_aktif',
                            */
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
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai        

    echo CHtml::link(Yii::t('mds', '{icon} Tambah Mobil Ambulans', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl($controller.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";    
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')')).""; 
    echo "&nbsp;";
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')')).""; 
    echo "&nbsp;";
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')')).""; 
    echo "&nbsp;";
    $content = $this->renderPartial('../tips/master',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
        
         function cekForm(obj)
{
    $("#mobilambulance-m-search :input[name='"+ obj.name +"']").val(obj.value);
}     
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#mobilambulance-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
</div>
<script type="text/javascript">
    function removeTemporary(obj){
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
                            $.fn.yiiGridView.update('mobil-ambulans-m-grid');
                        }else{
                            myAlert('Data Gagal di Nonaktifkan.')
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
                });
           }
       });
    }
    $('.filters #MobilambulansM_mobilambulans_kode').focus();
</script>