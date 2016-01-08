<div class="white-container">
    <legend class="rim2">Informasi Finger <b>Print Pegawai</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Kppengangkatanpns Ts'=>array('index'),
            'Manage',
    );


    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('form#sapegawai-m-search').submit(function(){
            $.fn.yiiGridView.update('kppengangkatanpns-t-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="block-tabel">
        <h6>Tabel Finger <b>Print Pegawai</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'kppengangkatanpns-t-grid',
            'dataProvider'=>$model->searchInformasi(),
            'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                     array(
                        'header'=>'No. Finger Print',
                        'name'=>'nofingerprint',
                         'type'=>'raw',
                        'value'=>'CHtml::link($data->nofingerprint,"", array("class"=>"poping","data-title"=>Yii::t("mds","Tips"), "data-content"=>CHtml::textField("test"), "rel"=>"popover"))',
    //                     'value'=>'CHtml::link($data->nofingerprint, Yii::app()->createUrl($this->grid->owner->module->id.\'/\'.$this->grid->owner->id.\'/finger&id=\'.$data->pegawai_id), array(\'onclick\'=>\'setFinger(this);return false;\', \'class\'=>\'parentFinger\'))',
                    ),
                    array(
                        'header'=>'NIP',
                        'name'=>'nomorindukpegawai',
                        'value'=>'$data->nomorindukpegawai',
                    ),
                    array(
                        'header'=>'Nama Pegawai',
                        'name'=>'nama_pegawai',
                        'value'=>'$data->nama_pegawai',
                    ),
                    array(
                        'header'=>'Jenis Kelamin',
                        'name'=>'jeniskelamin',
                        'value'=>'$data->jeniskelamin',
                    ),
                    array(
                        'header'=>'Jabatan',
                        'name'=>'jabatan_id',
                        'filter'=>  CHtml::listData(JabatanM::model()->findAll('jabatan_aktif = true'), 'jabatan_id', 'jabatan_nama'),
                        'value'=>'$data->jabatan_nama',
                    ),
    //                array(
    //                    'visible'=>true,
    //                    'class'=>'bootstrap.widgets.BootButtonGroup',
    //                    'htmlOptions'=>array('style'=>'width: 50px'),
    //                ),
                    /*
                    'pangkat',
                    'pendidikan',
                    'keterangan',
                    'pimpinannama',
                    */
    //		array(
    //                        'header'=>Yii::t('zii','View'),
    //			'class'=>'bootstrap.widgets.BootButtonColumn',
    //                        'template'=>'{view}',
    //		),
    //		array(
    //                        'header'=>Yii::t('zii','Update'),
    //			'class'=>'bootstrap.widgets.BootButtonColumn',
    //                        'template'=>'{update}',
    //                        'buttons'=>array(
    //                            'update' => array (
    //                                          'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
    //                                        ),
    //                         ),
    //		),
    //		array(
    //                        'header'=>Yii::t('zii','Delete'),
    //			'class'=>'bootstrap.widgets.BootButtonColumn',
    //                        'template'=>'{remove} {delete}',
    //                        'buttons'=>array(
    //                                        'remove' => array (
    //                                                'label'=>"<i class='icon-remove'></i>",
    //                                                'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
    //                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->pegawai_id"))',
    //                                                //'visible'=>'($data->kabupaten_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
    //                                                'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
    //                                        ),
    //                                        'delete'=> array(
    //                                                'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
    //                                        ),
    //                        )
    //		),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <?php $this->renderPartial('_searchInformasi',array('model'=>$model)); ?>
</div>
<?php 
 
//        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
//        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
//        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
//        $this->widget('UserTips',array('type'=>'admin'));
//        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
//        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
//        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
//
//$js = <<< JSCRIPT
//function print(caraPrint)
//{
//    window.open("${urlPrint}/"+$('#kppengangkatanpns-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
//}
//JSCRIPT;
//Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
<?php 
    
//Yii::app()->clientScript->registerScript('onheadfungsi','
//        function cekFingerPrint(){
//            finger = $("#'.CHtml::activeId($model, 'no_fingerprint').'").val();
//            if (finger != ""){
//                $.post("'.Yii::app()->createUrl('actionAjax/cekFinger').'",{finger:finger, '.(($model->isNewRecord) ? '' : 'pegawai : '.$model->karyawan_id).'},function(data){
//                    if (data != 1){
//                        myAlert("No. Finger Print telah diset untuk Pegawai lain");
//                        $("#'.CHtml::activeId($model, 'no_fingerprint').'").val("");
//                        $("#'.CHtml::activeId($model, 'no_fingerprint').'").focus();
//                        $("#'.CHtml::activeId($model, 'no_fingerprint').'").addClass("error");
//                    }
//                });
//            }
//        }
//',  CClientScript::POS_HEAD); ?>