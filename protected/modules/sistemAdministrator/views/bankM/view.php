<div class='white-container'>
    <legend class='rim2'>Lihat <b>Bank</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Bank Ms'=>array('index'),
            $model->bank_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Bank', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Bank', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    array(
                            'label'=>'Nama Bank',
                            'value'=>isset($model->bank->namabank) ? $model->bank->namabank : "-",
                    ),
                    array(
                            'label'=>'No. Rekening',
                            'value'=>isset($model->bank->norekening) ? $model->bank->norekening : "-",
                    ),
                    array(
                            'label'=>'Mata Uang',
                            'value'=>isset($model->bank->matauang->matauang) ? $model->bank->matauang->matauang : "-",
                    ),
                    array(
                            'label'=>'Propinsi',
                            'value'=>isset($model->bank->propinsi->propinsi_nama) ? $model->bank->propinsi->propinsi_nama : "-",
                    ),
                    array(
                            'label'=>'Kabupaten',
                            'value'=>isset($model->bank->kabupaten->kabupaten_nama) ? $model->bank->kabupaten->kabupaten_nama : "-",
                    ),
                    array(
                            'label'=>'Alamat Bank',
                            'value'=>isset($model->bank->alamatbank) ? $model->bank->alamatbank : "-",
                    ),
                    array(
                            'label'=>'Telp Bank 1 / 2',
                            'value'=>isset($model->bank->telpbank1) ? $model->bank->telpbank1 : "-"." / ". isset($model->bank->telpbank2) ? $model->bank->telpbank2 : "-",
                    ),
                    array(
                            'label'=>'Fax Bank / <br/> Kode Pos',
                            'value'=>isset($model->bank->faxbank) ? $model->bank->faxbank : "-" ." / ". isset($model->bank->kodepos) ? $model->bank->kodepos : "-",
                    ),
                    array(
                            'label'=>'Email / <br/> Website',
                            'value'=>isset($model->bank->emailbank) ? $model->bank->emailbank : "-" ." / ". isset($model->bank->website) ? $model->bank->website : "-",
                    ),
                    array(
                            'label'=>'Cabang dari / <br/> Negara',
                            'value'=>isset($model->bank->cabangdari) ? $model->bank->cabangdari : "-" ." / ".isset($model->bank->negara) ? $model->bank->negara : "-",
                    ),
                    array(
                             'label'=>'Rekening Debit',
                             'type'=>'raw',
                             'value'=>$this->renderPartial($this->path_view. '_viewDebit',array('bank_id'=>$model->bank_id,'saldonormal'=>"D"),true),
                     ),
                     array(
                             'label'=>'Rekening Kredit',
                             'type'=>'raw',
                             'value'=>$this->renderPartial($this->path_view. '_viewKredit',array('bank_id'=>$model->bank_id,'saldonormal'=>"K"),true),
                     ),
                    array(            
                            'label'=>'Aktif',
                            'type'=>'raw',
                            'value'=>(($model->bank->bank_aktif==1)? ''.Yii::t('mds','Yes').'' : ''.Yii::t('mds','No').''),
                    ),
            ),
    )); ?>

    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>