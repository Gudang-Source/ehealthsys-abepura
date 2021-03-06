<div class="white-container">
    <legend class="rim2">Lihat Zat <b>Menu Diet</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sazatmenudiet Ms'=>array('index'),
            $model->zatmenudiet_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Zat Menu Diet '.$model->zatmenudiet_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Zat Menu Diet', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Zat Menu Diet', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Zat Menu Diet', 'icon'=>'pencil','url'=>array('update','id'=>$model->zatmenudiet_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Zat Menu Diet','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->zatmenudiet_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Zat Menu Diet', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data'=>$model,
            'attributes'=>array(
                    'zatmenudiet_id',
                    'zatgizi.zatgizi_nama',
                    'menudiet.menudiet_nama',
                    'kandunganmenudiet',
            ),
    )); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->zatmenudiet_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Zat Menu Diet', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('/sistemAdministrator/ZatMenuDietM/Admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>