<div class="white-container">
    <legend class="rim2">Lihat <b>Supplier</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Gfsupplier Ms'=>array('index'),
            $model->supplier_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Supplier ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Supplier', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Supplier', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Supplier', 'icon'=>'pencil','url'=>array('update','id'=>$model->supplier_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Supplier','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->supplier_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Supplier', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row-fluid">
            <div class="span4">
                    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                            'data'=>$model,
                            'attributes'=>array(
                                    'supplier_id',
                                    'supplier_kode',
                                    'supplier_nama',
                                    'supplier_namalain',
                                    'supplier_alamat',
                                    'supplier_propinsi',
                                    'supplier_kabupaten',)
                    )); ?>
            </div>
            <div class="span4">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                    'data'=>$model,
                    'attributes'=>array(
            //		'supplier_id',
            //		'supplier_kode',
            //		'supplier_nama',
            //		'supplier_namalain',
            //		'supplier_alamat',
            //		'supplier_propinsi',
            //		'supplier_kabupaten',
                            'supplier_kodepos',
                            'latitude',
                            'longitude',
                            'supplier_telp',
                            'supplier_fax',
                            'supplier_npwp',
                            'supplier_website',
                    ),
            )); ?>
            </div>
            <div class="span4">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                    'data'=>$model,
                    'attributes'=>array(
                            'supplier_email',
                            'supplier_cp',
                                            'supplier_norekening',
                                             array(
                                                     'name'=>'obatalkes_nama',
                                                     'type'=>'raw',
                                                     'value'=>$this->renderPartial($this->path_view.'_obatSupplier',array('supplier_id'=>$model->supplier_id),true),
                                             ),
                                              array(               // related city displayed as a link
                                                    'name'=>'supplier_aktif',
                                                    'type'=>'raw',
                                                    'value'=>(($model->supplier_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')),
                                            ),
                    ),
            )); ?>
            </div>
    </div>

    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Supplier', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>