<fieldset class="box row-fluid">
    <?php
        if ($model->lookup_type == 'jenisbahanmakanan'):      
            echo "<legend class='rim'>Lihat <b>Jenis Bahan Makanan</b></legend>"; 
            $pengaturan = CHtml::link(Yii::t('mds', '{icon} Pengaturan Jenis Bahan Makanan', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('/gizi/JenisBahanMakanan/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));            
        else:   
            echo "<legend class='rim'>Lihat <b>Kelompok Bahan Makanan</b></legend>";
            $pengaturan = CHtml::link(Yii::t('mds', '{icon} Pengaturan Kelompok Bahan Makanan', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('/gizi/KelompokBahanMakanan/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));            
        endif;
    ?>  
    <?php
    $this->breadcrumbs=array(
            'Lookup Ms'=>array('index'),
            $model->lookup_id,
    );

    $this->menu=array(
    //        array('label'=>Yii::t('mds','View').' Satuan Barang ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
    //	array('label'=>Yii::t('mds','List').' Lookup', 'icon'=>'list', 'url'=>array('index')),
    //	array('label'=>Yii::t('mds','Create').' Lookup', 'icon'=>'file', 'url'=>array('create')),
    //        array('label'=>Yii::t('mds','Update').' Lookup', 'icon'=>'pencil','url'=>array('update','id'=>$model->lookup_id)),
    //	array('label'=>Yii::t('mds','Delete').' Lookup','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->lookup_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?'))),
    //	array('label'=>Yii::t('mds','Manage').' Satuan Barang', 'icon'=>'folder-open', 'url'=>array('admin')),
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    //'lookup_id',
                    'lookup_type',
                    //'lookup_name',
                array(
                         'label'=>'Nama',
                         'type'=>'raw',
                         'value'=>$this->renderPartial($this->path_view.'_Lookup',array('lookup_id'=>$model->lookup_id),true),
                     ),
                    //'komponentarif_aktif',
                    array(            
                                'label'=>'Aktif',
                                'type'=>'raw',
                                'value'=>(($model->lookup_aktif==1)? ''.Yii::t('mds','Yes').'' : ''.Yii::t('mds','No').''),
                            ),
                    //'lookup_value',
                    'lookup_kode',
                    'lookup_urutan',
//                    'lookup_aktif',

            ),
    )); ?>

    
    <?php echo $pengaturan;?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
</fieldset>