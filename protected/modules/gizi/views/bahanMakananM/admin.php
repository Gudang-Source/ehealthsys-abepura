<fieldset class="box row-fluid">
    <legend class="rim">Pengaturan <b>Bahan Makanan</b></legend>
    <?php //$this->renderPartial('_tabMenu',array()); ?>
    <!--<div class="biru">
        <div class="white">-->
            <?php
            $this->breadcrumbs=array(
                    'gzbahanmakanan Ms'=>array('index'),
                    'Manage',
            );
            $arrMenu = array();
            //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Bahan Makanan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
            //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Bahan Makanan', 'icon'=>'list', 'url'=>array('index'))) ;
            //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Bahan Makanan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

            $this->menu=$arrMenu;

            Yii::app()->clientScript->registerScript('search', "
            $('.search-button').click(function(){
                    $('.search-form').toggle();
                $('#BahanmakananM_golbahanmakanan_id').focus();
                    return false;
            });
            $('.search-form form').submit(function(){
                    $.fn.yiiGridView.update('bahan-makanan-m-grid', {
                            data: $(this).serialize()
                    });
                    return false;
            });
            ");
            //var_dump(Yii::app()->user->getFlash('success'));
            
            $this->widget('bootstrap.widgets.BootAlert'); ?>
    
            <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-white icon-accordion"></i>')),'#',array('class'=>'search-button btn')); ?>
            <div class="cari-lanjut3 search-form" style="display:none">
                <?php $this->renderPartial('_search',array(
                        'model'=>$model,
                )); ?>
            </div><!-- search-form -->
            <!--<div class="block-tabel">-->
                <!--<h6>Tabel <b>Bahan Makanan</b></h6>-->
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id'=>'bahan-makanan-m-grid',
                    'dataProvider'=>$model->search(),
                    'filter'=>$model,
                            'itemsCssClass'=>'table table-striped table-condensed',
                            'template'=>"{summary}\n{items}{pager}",
                    'columns'=>array(
                            array(
                                    'header'=>'ID',
                                    'value'=>'$data->bahanmakanan_id',
                                ),
                         array(
                                    'name'=>'sumberdanabhn',
                                    'filter'=> CHtml::dropDownList('BahanmakananM[sumberdanabhn]', $model->sumberdanabhn,CHtml::listData($model->SumberDanaItems, 'lookup_name', 'lookup_value'), array('empty'=>'--Pilih--')),
                                    'value'=>'$data->sumberdanabhn',
                                ),
                            array(
                                    'name'=>'golbahanmakanan_id',
                                    'filter'=> CHtml::dropDownList('BahanmakananM[golbahanmakanan_id]', $model->golbahanmakanan_id,CHtml::listData($model->getGolBahanMakananItems(), 'golbahanmakanan_id','golbahanmakanan_nama'), array('empty'=>'--Pilih--')),
                                    'value'=>'$data->golbahanmakanan->golbahanmakanan_nama',
                                ),                   
                    array(
                                    'name'=>'jenisbahanmakanan',
                                    'filter'=> CHtml::dropDownList('BahanmakananM[jenisbahanmakanan]', $model->jenisbahanmakanan,CHtml::listData($model->JenisBahanMakananItems, 'lookup_name', 'lookup_value'), array('empty'=>'--Pilih--')),
                                    'value'=>'$data->jenisbahanmakanan',
                                ),
                    array(
                                    'name'=>'kelbahanmakanan',
                                    'filter'=> CHtml::dropDownList('BahanmakananM[kelbahanmakanan]', $model->kelbahanmakanan,CHtml::listData($model->KelBahanMakananItems, 'lookup_name', 'lookup_value'), array('empty'=>'--Pilih--')),
                                    'value'=>'$data->kelbahanmakanan',
                                ),
                            'namabahanmakanan',
                            /*
                    'sumberdanabhn',
                    'jenisbahanmakanan',
                    'kelbahanmakanan',
                            'jmlpersediaan',
                            'satuanbahan',
                            'harganettobahan',
                            'hargajualbahan',
                            'discount',
                            'tglkadaluarsabahan',
                            'jmlminimal',
                            */
                            array(
                                'header'=>Yii::t('mds','View'),
                                'class'=>'bootstrap.widgets.BootButtonColumn',
                                'template'=>'{view}',
                                'buttons'=>array(
                                    'view' => array(
                                                  'options'=>array('rel' => 'tooltip' , 'title'=> 'Lihat bahan makanan' ),
                                    ),
                                ),
                            ),
                            array(
                                'header'=>Yii::t('mds','Update'),
                                'class'=>'bootstrap.widgets.BootButtonColumn',
                                'template'=>'{update}',
                                'buttons'=>array(
                                    'update' => array(
                                                  'options'=>array('rel' => 'tooltip' , 'title'=> 'Ubah bahan makanan' ),
                                    ),
                                ),
                            ),
                            array(
                                'header'=>'Hapus',
                                'type'=>'raw',
                                'value'=>'CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->bahanmakanan_id)",array("id"=>"$data->bahanmakanan_id","rel"=>"tooltip","title"=>"Hapus bahan makanan"));',
                                'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
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
        <!--</div>
    </div>-->
    <?php 
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Bahan Makanan', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('bahanMakananM/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $content = $this->renderPartial('../tips/master2',array(),true);
    $this->widget('UserTips',array('type'=>'admin','content'=>$content)); 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
        
 function cekForm(obj)
{
    $("#gzbahanmakanan-m-search :input[name='"+ obj.name +"']").val(obj.value);
}             
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#gzbahanmakanan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
<!--</div>-->
<script type="text/javascript">
    function deleteRecord(id){
        var id = id;
        var url = '<?php echo $url."/delete"; ?>';
        myConfirm('Yakin Akan Menghapus Data ini?','Perhatian!',
        function(r){
            if(r){
                $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('bahan-makanan-m-grid');
                            }else{
                                myAlert('Data gagal dihapus karena data digunakan oleh Master Bahan Menu Diet atau Master Zat Bahan Makanan atau Menu Anamesa Diet.');
                            }
                },"json");
            }
        }); 
    }
$(document).ready(function(){
$("input[name='BahanmakananM[namabahanmakanan]']").focus();
});
</script>
</fieldset>