<div class='white-container'>
    <legend class='rim2'>Pengaturan <b>Rekening Periode</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Rekperiod Ms'=>array('index'),
            'Manage',
    );

    $arrMenu = array();
    //	(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Rekening Periode ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    $this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('rekperiod-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-white icon-accordion"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="cari-lanjut2 search-form" style="display:none">
        <?php $this->renderPartial('_search',array(
                'model'=>$model,
        )); ?>
    </div><!-- search-form -->
    <!--<div class="block-tabel">-->
        <!--<h6>Tabel <b>Rekening Periode</b></h6>-->
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'rekperiod-m-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'No',
                        'value'=>'$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
                    ),
					array(
                        'name'=>'perideawal',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->perideawal)',
                        'filter'=>$this->widget('MyDateTimePicker',array(
                                        'model'=>$model,
                                        'attribute'=>'perideawal',
                                        'mode'=>'date',
                                        'options'=> array(
										'dateFormat'=>Params::DATE_FORMAT,
                                                            ),
                                        'htmlOptions'=>array('readonly'=>false, 'class'=>'dtPicker3','id'=>'perideawal'),
                                        ),true
                                    ),
                        'htmlOptions'=>array('width'=>'150','style'=>'text-align:left'),
                    ),
					array(
                        'name'=>'sampaidgn',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->sampaidgn)',
                        'filter'=>$this->widget('MyDateTimePicker',array(
                                        'model'=>$model,
                                        'attribute'=>'sampaidgn',
                                        'mode'=>'date',
                                        'options'=> array(
										'dateFormat'=>Params::DATE_FORMAT,
                                                            ),
                                        'htmlOptions'=>array('readonly'=>false, 'class'=>'dtPicker3','id'=>'sampaidgn'),
                                        ),true
                                    ),
                        'htmlOptions'=>array('width'=>'150','style'=>'text-align:left'),
                    ),
//                    'perideawal',
//                    'sampaidgn',
                    'deskripsi',
                    array(
                        'header'=>'Status Closing',
                        'filter'=>false,
                        'name'=>'isclosing',
                        'value'=>'($data->isclosing == 1) ? "Closing" : "Tidak Closing"',
                        'htmlOptions'=>array('style'=>'text-align:left'),
                    ),
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
            array(
                'header'=>'Hapus',
                'type'=>'raw',
<<<<<<< HEAD
                'value'=>'(!$data->isclosing)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->rekperiod_id)",array("id"=>"$data->rekperiod_id","rel"=>"tooltip","title"=>"Closing"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->rekperiod_id)",array("id"=>"$data->rekperiod_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->rekperiod_id)",array("id"=>"$data->rekperiod_id","rel"=>"tooltip","title"=>"Hapus"));',
                'htmlOptions'=>array('style'=>'text-align: center; width:80px'),
=======
                'value'=>'(!$data->isclosing)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->rekperiod_id)",array("id"=>"$data->rekperiod_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->rekperiod_id)",array("id"=>"$data->rekperiod_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->rekperiod_id)",array("id"=>"$data->rekperiod_id","rel"=>"tooltip","title"=>"Hapus"));',
                'htmlOptions'=>array('style'=>'text-align: left; width:80px'),
>>>>>>> 12f1e5a9c072640a387b6430d541776accbca7b2
            ),
            ),
            'afterAjaxUpdate'=>'function(id, data){
                 jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                 jQuery(\'#perideawal\').datepicker(jQuery.extend({
                        showMonthAfterYear:false}, 
                        jQuery.datepicker.regional[\'id\'], 
                       {\'dateFormat\':\'dd M yy\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                       \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
                jQuery(\'#perideawal_date\').on(\'click\', function(){jQuery(\'#sampaidgn\').datepicker(\'show\');});
                 jQuery(\'#sampaidgn\').datepicker(jQuery.extend({
                        showMonthAfterYear:false}, 
                        jQuery.datepicker.regional[\'id\'], 
                       {\'dateFormat\':\'dd M yy\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                       \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
                jQuery(\'#sampaidgn_date\').on(\'click\', function(){jQuery(\'#sampaidgn\').datepicker(\'show\');});
            }',
        )); ?>
    <!--</div>-->
    <?php 
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Rekening Periode', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $this->widget('UserTips',array('type'=>'admin'));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#rekperiod-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
</div>
<script type="text/javascript">
    function removeTemporary(id){
        var url = '<?php echo $url."/removeTemporary"; ?>';
        myConfirm("Yakin akan closing data ini untuk sementara?",'Perhatian!',function(r){
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('rekperiod-m-grid');
                            }else{
                                myAlert('Data Gagal di closing')
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
                                $.fn.yiiGridView.update('rekperiod-m-grid');
                            }else{
                                myAlert('Data Gagal di Hapus')
                            }
                },"json");
           }
        });
    }
</script>