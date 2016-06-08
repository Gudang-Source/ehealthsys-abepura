<div class="white-container">
    <legend class="rim2">Transaksi Pemesanan <b>Obat Alkes</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Gfpemesananobatalkes Ts'=>array('index'),
            'Create',
    );
    ?>
    <?php
    if(isset($_GET['sukses'])){
        Yii::app()->user->setFlash("success","Data pemesanan obat alkes berhasil disimpan!");
    }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'gfpemesananobatalkes-t-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
            'focus'=>'#'.CHtml::activeId($modPesanObatalkes,'instalasitujuan_id'),
    )); ?>

    <?php echo $this->renderPartial($this->path_view.'_form', array('form'=>$form,'model'=>$modPesanObatalkes, 'instalasiTujuans'=>$instalasiTujuans, 'ruanganTujuans'=>$ruanganTujuans)); ?>

    <?php  if(!isset($_GET['sukses'])){ ?>
    <fieldset class="box" id="form-tambahobatalkes">
        <legend class='rim'>Obat dan Alat Kesehatan</legend>
        <div class="row-fluid">
            <?php
            if(!isset($_GET['sukses'])){
                $this->renderPartial($this->path_view.'_formPilihObat'); 
            }
            ?>
        </div>
        <?php } ?>
        <div class="block-tabel">
            <h6>Tabel <b>Obat Alkes</b></h6>
            <table class="items table table-striped table-condensed" id="table-detailpemesanan">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Jenis</th>
                        <th>Nama Obat</th>
                        <th>Tgl Kadaluarsa</th>
                        <th hidden>Satuan Kecil </th>
                        <th>Jumlah</th>
                        <th>Batal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(count($modDetails) > 0){
                        foreach($modDetails AS $i=>$modDetail){
                            echo $this->renderPartial($this->path_view.'_rowDetailPemesanan',array('modDetail'=>$modDetail));
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </fieldset>
    <div class="row-fluid">
        <div class="form-actions">
                <?php 
                if(isset($_GET['pesanobatalkes_id'])){
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'disabled'=>true, 'style'=>'cursor:not-allowed;'))."&nbsp;"; 
                    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print('PRINT');return false",'disabled'=>FALSE  ));
                }else{
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)'))."&nbsp"; 
                    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','disabled'=>TRUE,'style'=>'cursor:not-allowed;'));
                }
                ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        $this->createUrl($this->id.'/index'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'return refreshForm(this);'));  ?>
                <?php 
                $content = $this->renderPartial($this->path_view.'tips/tipsPemesanan',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
                ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>

    <?php $this->renderPartial($this->path_view.'_jsFunctions', array('model'=>$modPesanObatalkes)); ?>
</div>