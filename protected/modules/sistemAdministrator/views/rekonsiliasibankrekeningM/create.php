<fieldset class="box">
    <legend class='rim'>Tambah Rekening Rekonsiliasi Bank</legend>
    <?php
    $this->breadcrumbs=array(
            'RekonsiliasiBankRek Ms'=>array('index'),
            'Create',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Jurnal Rek Pengeluaran ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jurnal Rek Pengeluaran ', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php // echo $this->renderPartial('_tabMenu',array()); ?>
<!--    <div class="biru">
        <div class="white">-->
            <?php echo $this->renderPartial($this->path_view .'_form', array('model'=>$model)); ?>
<!--        </div>
    </div>-->
</fieldset>