<?php
    if ($this->hasTab):
?>
<fieldset class="box row-fluid">
    <legend class="rim">Pengaturan PTKP</legend>
<?php
    else:
?>
    <div class="white-container">
    <legend class="rim2">Pengaturan <b>PTKP</b></legend>
<?php
    endif;
?>
    <?php
    $this->breadcrumbs=array(
            'PTKP Ms'=>array('index'),
            'Manage',
    );

    $arrMenu = array();
    //    (Yii::app()->user->checkAccess('Admin')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' PTKP ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
        // (Yii::app()->user->checkAccess('Create')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' PTKP ', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

    $this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('ptkp-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
   // $this->renderPartial($this->path_view_tab. '_tabMenu',array());
    $this->widget('bootstrap.widgets.BootAlert'); ?>
   <!-- <div class="biru">
        <div class="white">-->
            <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-white icon-accordion"></i>')),'#',array('class'=>'search-button btn')); ?>
            <div class="cari-lanjut search-form" style="display:none">
                <?php $this->renderPartial($this->path_view. '_search',array(
                        'model'=>$model,  
                )); ?>
            </div><!-- search-form -->
            <!--<div class="block-tabel">
                <h6>Tabel <b>PTKP</b></h6>-->
                <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                    'id'=>'ptkp-m-grid',
                    'dataProvider'=>$model->search(),
                    'filter'=>$model,
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                    'columns'=>array(
                            array(
                        'name'=>'ptkp_id',
                        'value'=>'$data->ptkp_id',
                        'filter'=>false,
                    ),
                            //'tglberlaku',
                    array(
                        'header' => 'Tanggal Berlaku',
                        'value' => 'MyFormatter::formatDateTimeForUser($data->tglberlaku)'
                    ),
                            'statusperkawinan',                    
                            'jmltanggunan',
                           // 'wajibpajak_thn',
                    array(
                        'header' => 'Tahun Wajib Pajak',
                        'name' => 'wajibpajak_thn',
                        'value' => '"Rp".number_format($data->wajibpajak_thn,0,"",".")',                       
                        'htmlOptions' => array('style'=>'text-align:right;')
                    ),    
                    array(
                        'header' => 'Bulan Wajib Pajak',
                        'name' => 'wajibpajak_bln',
                        'value' => '"Rp".number_format($data->wajibpajak_bln,0,"",".")',                       
                        'htmlOptions' => array('style'=>'text-align:right;')
                    ),    
                   // 'wajibpajak_bln', 
                    array(
                        'header'=>'Berlaku',
                        'value'=>'($data->berlaku)?"Aktif":"Tidak Aktif"',
                        'filter'=>false,
                    ),
                    // array(
                    //     'header'=>'Aktif',
                    //     'class'=>'CCheckBoxColumn',
                    //     'id'=>'rows',
                    //     'selectableRows'=>0,
                    //     'checked'=>'$data->berlaku',
                    // ),
                            array(
                        'header'=>Yii::t('zii','View'),
                                    'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{view}',
                            ),
                            array(
                        'header'=>Yii::t('zii','Update'),
                                    'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{update}',
                        'buttons'=>array(
                            'update' => array (
                              'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                            ),
                        ),
                            ),
                  /*          array(
                        'header'=>Yii::t('zii','Delete'),
                                    'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{delete}',
                        'buttons'=>array(
                            'delete'=> array(
                                'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                            ),
                        )
                            ),   */
                 
                    array(
                            'header'=>'Hapus',
                            'type'=>'raw',
                            'value'=>'($data->berlaku)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->ptkp_id)",array("id"=>"$data->ptkp_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->ptkp_id)",array("id"=>"$data->ptkp_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->ptkp_id)",array("id"=>"$data->ptkp_id","rel"=>"tooltip","title"=>"Hapus"));',
                            'htmlOptions'=>array('style'=>'text-align: center; width:80px'),
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
           <!-- </div>
        </div>
    </div>-->
    <?php 
    echo CHtml::link(Yii::t('mds', '{icon} Tambah PTKP', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $content = $this->renderPartial('sistemAdministrator.views/tips/master',array(),true); 
    $this->widget('UserTips',array('type'=>'admin','content'=>$content));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
    
$js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#ptkp-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#ptkp-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
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
                                $.fn.yiiGridView.update('ptkp-m-grid');
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
                                $.fn.yiiGridView.update('ptkp-m-grid');
                            }else{
                            myAlert('Data gagal dihapus karena data digunakan di tabel lain.');
                            }
                },"json");
           }
		});
    }
    
    $(document).ready(function(){
        $("input[name='KPPtkpM[tglberlaku]']").focus();
    })
</script>
</fieldset>
</div>