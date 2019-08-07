<div class="white-container">
    <legend class="rim2">Produksi <b>Gas Medis</b></legend>
    <?php 
        if(isset($_GET['sukses'])){
            Yii::app()->user->setFlash('success',"Produksi Gas Medis Berhasil Disimpan");
        }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'produksigasmedis-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onsubmit'=>'return requiredCheck(this);'),
    )); ?>
    <?php echo $this->renderPartial('subIndex/_formTransaksi', array('form'=>$form, 'produksi'=>$produksi), true); ?>
    
    <?php echo $this->renderPartial('subIndex/_formGasMedis', array('form'=>$form, 'produksi'=>$produksi), true); ?>
    
    
    <fieldset class="box" id="form-produksi">
        <legend class='rim'>Detail Produksi Gas Medis</legend>
        <table class="items table table-striped table-condensed" id="tabGasMedis">
            <thead>
                <tr>
                    <th>Mulai Produksi</th>
                    <th>Selesai Produksi</th>
                    <th>Gas Medis</th>
                    <th>Kapasitas</th>
                    <th>Qty</th>
                    <th>Batal</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach($det_produksi as $item) {
                    echo $this->renderPartial('subIndex/_rowGasMedis', array('oa'=>$item->obatalkes, 'row'=>$item));
                }; 
                ?>
            </tbody>
        </table>
    </fieldset>
    
    <div class="form-actions">
            <?php 
                $disableSave = !empty($id);
                //$disableSave = (!empty($_GET['penjualanresep_id'])) ? true : ($sukses > 0) ? true : false;; 
            //var_dump(empty($id));
            $disablePrint = ($disableSave) ? false : true;

            echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'cekValidasi();', 'onkeypress'=>'cekValidasi();','disabled'=>$disableSave))." "; //formSubmit(this,event)        
            
            if(!isset($_GET['frame'])){
                echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    $this->createUrl($this->id.'/index'), 
                    array('class'=>'btn btn-danger','onclick'=>'return refreshForm(this);'
                ))." ";
            } 
            echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue', 'disabled'=>$disablePrint,'type'=>'button','onclick'=>'print(1)'))." ";                 

            $content = $this->renderPartial('tips/tipsProduksiGasMedis',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
    </div>
    <?php $this->endWidget(); ?>
</div>

<?php echo $this->renderPartial('subIndex/_jsFunction', array('model'=>$produksi), true); ?>