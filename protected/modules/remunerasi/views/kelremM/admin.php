<div class="white-container">
    <legend class="rim2">Pengaturan <b>Kelompok Remunerasi</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sakelrem Ms'=>array('index'),
            'Manage',
    );

    $arrMenu = array();
                    (Yii::app()->user->checkAccess('Admin')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kelompok Remunerasi ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Kelompok Remunerasi', 'icon'=>'list', 'url'=>array('index'))) ;
                    (Yii::app()->user->checkAccess('Create')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kelompok Remunerasi', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

    $this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('kelrem-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <?php
        $this->widget('bootstrap.widgets.BootAlert');
        $this->renderPartial('_tabMenu',array());
    ?>
    <div class="biru">
        <div class="white">
            <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
            <div class="search-form cari-lanjut3" style="display:none">
                <?php $this->renderPartial('_search',array(
                        'model'=>$model,
                )); ?>
            </div><!-- search-form -->
            <!--<div class="block-tabel">-->
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id'=>'kelrem-m-grid',
                    'dataProvider'=>$model->search(),
                            'itemsCssClass'=>'table table-striped table-condensed',
                    'filter'=>$model,
                    'columns'=>array(
                            'kelrem_id',
                            'kelrem_urutan',
                            'kelrem_kode',
                            'kelrem_nama',
                            'kelrem_desc',
                            'kelrem_singkatan',
                            /*
                            'kelrem_rate',
                            'kelrem_aktif',
                            */
                            array(
                                'header'=>'<center>Status</center>',
                                'value'=>'($data->kelrem_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                                'htmlOptions'=>array('style'=>'text-align:center;'),
                            ),
            //                array(
            //                        'header'=>'Aktif',
            //                        'class'=>'CCheckBoxColumn',     
            //                        'selectableRows'=>0,
            //                        'id'=>'rows',
            //                        'checked'=>'$data->kelrem_aktif',
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
                            array(
                                'header'=>Yii::t('zii','Delete'),
                                'class'=>'bootstrap.widgets.BootButtonColumn',
                                'template'=>'{remove} {delete}',
                                'buttons'=>array(
                                    'remove' => array (
                                            'label'=>"<i class='icon-form-silang'></i>",
                                            'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
                                            'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->kelrem_id"))',
                                            'visible'=>'($data->kelrem_aktif && Yii::app()->user->checkAccess("Update")) ? TRUE : FALSE',
                                            'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
                                    ),
                                    'delete'=> array(
                                            'visible'=>'Yii::app()->user->checkAccess("Delete")',
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
            <!--</div>-->
            <?php
                echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
                echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
                echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
                $content = $this->renderPartial('../tips/master',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
            ?>
        </div>
    </div>
</div>
<?php
$js = <<< JSCRIPT
        function cekForm(obj)
{
    $("#sakelrem-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sakelrem-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>