<div class="white-container">
    <legend class="rim2">Transaksi Faktur <b>Pembelian Farmasi</b></legend>
<?php 
    if(isset($_GET['sukses'])){
        Yii::app()->user->setFlash('success',"Data Faktur Pembelian berhasil disimpan !");
    }
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
	
<?php
        $this->widget('application.extensions.moneymask.MMask',array(
            'element'=>'.currency',
            'currency'=>'PHP',
            'config'=>array(
                'symbol'=>'Rp. ',
                'defaultZero'=>true,
                'allowZero'=>true,
                'precision'=>0,
            )
        ));
    ?>
    
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'fakturpembelian-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onsubmit'=>'return requiredCheck(this);'),
)); ?>
    
    <fieldset class="box" id="form-rencanakebutuhan">
        <legend class="rim"><span class='judul'>Data Penerimaan </span></legend>
        <div>
            <?php $this->renderPartial($this->path_view.'_formPenerimaanBarang', array('form'=>$form,'format'=>$format,'modPenerimaanBarang'=>$modPenerimaanBarang,'modFakturPembelian'=>$modFakturPembelian)); ?>
        </div>
    </fieldset>

    <fieldset class="box" id="form-rencanakebutuhan">
        <legend class="rim"><span class='judul'>Data Faktur </span></legend>
        <div>
            <?php $this->renderPartial($this->path_view.'_formFakturPembelian', array('form'=>$form,'format'=>$format,'modFakturPembelian'=>$modFakturPembelian)); ?>
        </div>
    </fieldset>

    <div class="block-tabel">
        <h6>Tabel Faktur Obat <b>dan Alat Kesehatan</b></h6>
        <table class="items table table-striped table-condensed" id="table-obatalkespasien">
            <thead>
                <tr>
                    <th><?php  echo CHtml::checkBox('checklist',true,array('onclick'=>'checkAll(this);'));?></th>
                    <th>No.</th>
                    <th>Asal Barang</th>
                    <th>Kategori / Nama Obat</th>
                    <th>Jumlah Permintaan </th>
                    <th>Jumlah Diterima</th>
                    <th>Diskon (%)</th>
                    <th>Diskon Total (Rp.)</th>
                    <th>Harga Netto</th>
                    <th>PPN (%)</th>
                    <th>PPH (%)</th>
                    <th>Sub Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(count($modDetails) > 0){
                    foreach($modDetails AS $i=>$modFakturDetail){
                        echo $this->renderPartial($this->path_view.'_rowObatFakturPembelian',array('modFakturDetail'=>$modFakturDetail,'modFakturPembelian'=>$modFakturPembelian,'format'=>$format));
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <td colspan="11">Total</td>
                        <td><?php echo CHtml::textField('total','',array('class'=>'span2 integer','style'=>'width:90px;'))?></td>
                    </tr>
                </tfoot>
            </tbody>
        </table>
    </div>
                
    <div class="row-fluid">
        <div class="form-actions">
            <?php 
                if($modFakturPembelian->isNewRecord){
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'tombolSimpan();', 'onkeypress'=>'tombolSimpan();')); 
                    echo "&nbsp;";
                }else{
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'disabled'=>true)); 
                    echo "&nbsp;";
                }

                if(!isset($_GET['frame'])){
					echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    $this->createUrl($this->id.'/index'), 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'return refreshForm(this);'));
                    echo "&nbsp;";
                }
                if($modFakturPembelian->isNewRecord){
                    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'disabled'=>'true'));
                    echo "&nbsp;";
                    echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);',array('class'=>'btn btn-info', 'disabled'=>'true')); 
                    echo "&nbsp;";
                }else{
                    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
                    echo "&nbsp;";
                    echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); 
                    echo "&nbsp;";
                }

                $content = $this->renderPartial($this->path_view.'tips/tipsFakturPembelian',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
            ?> 
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
<?php $this->renderPartial($this->path_view.'_jsFunctions', array('modPenerimaanBarang'=>$modPenerimaanBarang,'modFakturPembelian'=>$modFakturPembelian)); ?>
