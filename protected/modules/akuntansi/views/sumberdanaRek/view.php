<!--<div class='white-container'>
    <legend class='rim2'>Lihat Jurnal <b>Rekening Sumber Dana</b></legend>-->
<fieldset class = "box">
    <legend class = "rim">Lihat Jurnal Rekening Sumber Dana</legend>
    <?php /*
    $this->breadcrumbs=array(
        'Jurnal Rekening Sumber Dana'=>array('index'),
        $model->sumberdana_id,
    );

    $arrMenu = array();
    //    array_push($arrMenu,array('label'=>Yii::t('mds','View').' Jurnal Rekening Sumber Dana ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jurnal Rekening Sumber Dana', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;
*/
    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php 
    
    $this->widget('ext.bootstrap.widgets.BootDetailView',array(
        'data'=>$model,
        'attributes'=>array(

            array(
                        'label'=>'Sumber Dana',
                        'type'=>'raw',
                        'value'=>$model->sumberdana_nama,
                    ),
            array(
                        'label'=>'Rekening Debit',
                        'type'=>'raw',
                        'value'=>$this->renderPartial('_viewDebit',array('sumberdana_id'=>$model->sumberdana_id,'saldonormal'=>'D'),true),
                     ),
            array(
                        'label'=>'Rekening Kredit',
                        'type'=>'raw',
                        'value'=>$this->renderPartial('_viewDebit',array('sumberdana_id'=>$model->sumberdana_id,'saldonormal'=>'K'),true),
                     ),
        ),
    )); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Jurnal Rekening Sumber Dana',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
<!--</div>-->
</fieldset>