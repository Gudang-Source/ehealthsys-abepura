<div class="white-container">
    <?php
    $this->breadcrumbs=array(
            'Gfpemusnahanobatalkes Ts'=>array('index'),
            'Create',
    );
    ?>
    <legend class="rim2">Pemusnahan <b>Obat dan Alkes</b></legend>
    <?php
    if(isset($_GET['sukses'])){
        if($_GET['sukses'] == 1){
            Yii::app()->user->setFlash("success","Data pemusnahan obat alkes berhasil disimpan!");
        }else{
            Yii::app()->user->setFlash("warning","Terdapat obat yang dibatalkan silahkan cek kembali !");
        }
    }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'gfpemusnahanobatalkes-t-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
            'focus'=>'#'.CHtml::activeId($model,'instalasiasal_id'),
    )); ?>

    <?php echo $this->renderPartial($this->path_view.'_form', array('form'=>$form,'model'=>$model, 'instalasiAsals'=>$instalasiAsals, 'ruanganAsals'=>$ruanganAsals)); ?>

    <?php  if(!isset($_GET['sukses'])){ ?>
    <fieldset class="box" id="form-tambahobatalkes">
        <legend class='rim'>Obat dan Alat Kesehatan</legend>
        <div class="row-fluid">
            <?php
            if(!isset($_GET['sukses'])){
                $this->renderPartial($this->path_view.'_formPilihObat',array('model'=>$model)); 
            }
            ?>
        </div>
        <?php } ?>
        <div class="block-tabel">
            <h6>Tabel <b>Obat Alkes</b></h6>
            <table class="items table table-striped table-condensed" id="table-pemusnahandetail">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Ruangan Asal</th>
                        <th>Kategori / Nama Obat</th>
                        <th>No. Batch</th>
                        <th>Tanggal Kadaluarsa </th>
                        <th>Satuan Kecil </th>
                        <th>Jumlah Stok</th>
                        <th>Jumlah Pemusnahan</th>
                        <th>Kondisi Obat</th>
                        <th>HPP</th>
                        <th>Harga Jual</th>
                        <th>Sub Total Netto</th>
                        <th>Batal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(count($modDetails) > 0){
                        foreach($modDetails AS $i=>$modPemusnahanDetail){
                            echo $this->renderPartial($this->path_view.'_rowPemusnahanDetail',array('modPemusnahanDetail'=>$modPemusnahanDetail,'pesan'=>$pesan),true);
                        }
                    }
                    ?>
                    <tfoot>
                        <tr>
                            <td colspan="11"><?php if(count($modDetails) > 0){
                                                    echo "Total";
                                                }else{
                                                    echo "<div style=\"color:#FF0000;font-weight:bold;\">".$pesan."</div>";
                                                }
                                             ;?>
                            </td>
                            <td><?php echo CHtml::textField('total',0,array('class'=>'span2 integer','style'=>'width:90px;'))?></td>    
                            <td></td>
                        </tr>
                    </tfoot>
                </tbody>
            </table>
        </div>
    </fieldset>
    <div class="row-fluid">
        <div class="form-actions">
                <?php 
                if(isset($_GET['pemusnahanobatalkes_id'])){
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
                              'onclick'=>'return refreshForm(this);')); ?>
                <?php 
                $content = $this->renderPartial($this->path_view.'tips/tipsPemusnahanObatAlkes',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
                ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
<?php $this->renderPartial($this->path_view.'_jsFunctions', array('model'=>$model)); ?>
