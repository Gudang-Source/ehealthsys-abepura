<div class="white-container">
	<legend class="rim2">Transaksi <b>Mutasi Obat Alkes</b></legend>
<?php
$this->breadcrumbs=array(
	'Terima Mutasi Obat Alkes'=>array('index'),
	'Create',
);
?>
<?php
if(isset($_GET['sukses'])){
    Yii::app()->user->setFlash("success","Data terima mutasi obat alkes berhasil disimpan!");
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'terimamutasiobat-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#'.CHtml::activeId($model,'instalasitujuan_id'),
)); ?>

<?php echo $this->renderPartial($this->path_view.'_form', array('form'=>$form,'model'=>$model, 'instalasiTujuans'=>$instalasiTujuans, 'ruanganTujuans'=>$ruanganTujuans,'modMutasiRuangan'=>$modMutasiRuangan)); ?>

<?php  if(!isset($_GET['sukses']) && (!isset($_GET['mutasioaruangan_id']))){ ?>
    <fieldset id="form-tambahobatalkes">
        <legend class='rim'>Obat dan Alat Kesehatan</legend>
        <div class="row-fluid box">
            <?php
            if(!isset($_GET['sukses'])){
                $this->renderPartial($this->path_view.'_formPilihObat'); 
            }
            ?>
        </div>
    </fieldset>
<?php } ?>
<div class="block-tabel">
	<h6>Tabel <b>Obat Alkes</b></h6>
<fieldset>
    <table class="items table table-striped table-bordered table-condensed" id="table-mutasidetail">
        <thead>
            <tr>
                <th>No.</th>
                <th>Asal Barang</th>
                <th>Kategori / Nama Obat</th>
                <th>Tanggal Kadaluarsa </th>
                <th>Satuan Kecil </th>
                <th>Jumlah Mutasi</th>
                <th>Jumlah Terima</th>
                <th>HPP</th>
                <th>Harga Jual</th>
                <th>Sub Total Netto</th>
                <th>Batal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(count($modDetails) > 0){
                foreach($modDetails AS $i=>$modMutasiDetail){
                    echo $this->renderPartial($this->path_view.'_rowMutasiDetail',array('modMutasiDetail'=>$modMutasiDetail));
                }
            }
            ?>
            <tfoot>
                <tr>
                    <td colspan="9" style="text-align:right;">Total</td>
                    <td><?php echo CHtml::textField('total',0,array('readonly'=>true,'class'=>'span2 integer','style'=>'width:80px;'))?></td>
                    <td></td>
                </tr>
            </tfoot>
        </tbody>
    </table>
</fieldset>
</div>


<div class="row-fluid">
    <div class="form-actions">
            <?php 
            if(isset($_GET['terimamutasi_id'])){
                echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'disabled'=>true, 'style'=>'cursor:not-allowed;'))."&nbsp;"; 
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print('PRINT')",'disabled'=>FALSE  ));
            }else{
                echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)'))."&nbsp"; 
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','disabled'=>TRUE,'style'=>'cursor:not-allowed;'));
            }
            ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    $this->createUrl($this->id.'/index&mutasioaruangan_id='.$_GET['mutasioaruangan_id']), 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'return refreshForm(this);'));  ?>
                 
            <?php 
            $content = $this->renderPartial($this->path_view.'tips/tipsTerimaMutasiObatAlkes',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
            ?>
    </div>
</div>
<?php $this->endWidget(); ?>

</div>

<?php $this->renderPartial($this->path_view.'_jsFunctions', array('model'=>$model,'modMutasiRuangan'=>$modMutasiRuangan)); ?>
