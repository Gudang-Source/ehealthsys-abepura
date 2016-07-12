<div class="white-container">
    <legend class="rim2">Rencana <b>Kebutuhan</b></legend>
    <?php 
        if(isset($_GET['sukses'])){
            Yii::app()->user->setFlash('success',"Data Rencana Kebutuhan berhasil disimpan !");
        }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'rencanakebutuhan-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);'),//dimatikan karena pakai cekObat >> ,'onsubmit'=>'return requiredCheck(this);'
    )); ?>
    
    <fieldset class="box" id="form-rencanakebutuhan">
        <legend class="rim"><span class='judul'>Data Rencana Kebutuhan </span></legend>
        <div>
            <?php $this->renderPartial($this->path_view.'_formRencanaKebutuhan', array('form'=>$form,'format'=>$format,'modRencanaKebFarmasi'=>$modRencanaKebFarmasi)); ?>
        </div>
    </fieldset>
    <?php /*
    <fieldset class="box" id="form-recomendedorder">
        <legend class="rim"><span class='judul'>Recomended Order (RO) </span></legend>
        <div>
            <?php $this->renderPartial($this->path_view.'_formRecomendedOrder', array('form'=>$form,'format'=>$format,'modRencanaKebFarmasi'=>$modRencanaKebFarmasi)); ?>
        </div>
    </fieldset>
     * 
     */ ?>
    <?php  if(!isset($_GET['sukses'])){ ?>
    <fieldset class="box" id="form-tambahobatalkes">
        <legend class='rim'>Tambah Obat dan Alat Kesehatan</legend>
        <div class="row-fluid">
            <?php $this->renderPartial($this->path_view.'_formObatRencanaKebutuhan',array('modRencanaKebFarmasi'=>$modRencanaKebFarmasi)); ?>
        </div>
    </fieldset>
    <?php } ?>

	
    <div class="block-tabel">
        <h6>Tabel <b>Rencana Kebutuhan</b></h6>
        <table class="items table table-striped table-condensed" id="table-obatalkespasien">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Jenis</th>
                    <th>Nama Obat</th>
                    <th>Tgl. Kadaluarsa</th>
                    <th>Minimal Stok</th>
                    <th>Maksimal Stok</th>
                    <th>Stok Akhir</th>
                    <th>Jumlah Kebutuhan</th>
                    <th>Satuan </th>
                    <!--th>Buffer Stok</th-->
                    <th>HPP</th>
                    <th>Sub Total</th>
                    <th>VEN</th>
                    <th>ABC</th>
                    <th>Batal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(count($modDetails) > 0){
                    foreach($modDetails AS $i=>$modRencanaDetailKeb){
                        echo $this->renderPartial($this->path_view.'_rowObatRencanaKebutuhan',array('modRencanaDetailKeb'=>$modRencanaDetailKeb,'modRencanaKebFarmasi'=>$modRencanaKebFarmasi));
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <td colspan="10">Total</td>
                        <td><?php echo CHtml::textField('total','',array('class'=>'span2 integer2','style'=>'width:90px;'))?></td>
                        <td></td>
						<td></td>
						<td></td>
                    </tr>
                </tfoot>
            </tbody>
        </table>
    </div>  
    <?php isset($_GET['ubah'])? $modRencanaKebFarmasi->rencanakebfarmasi_id = '' : '' ; ?>
    <?php /*
	<fieldset class="box">
        <legend class='rim'>Pegawai Berwenang</legend>
        <div class="row-fluid">
			<div class="span2">
			</div>
			<div class="span4">
				
			</div>
			<div class="span4">
				
			</div>
		</div>
	</fieldset>
     * 
     */ ?>
    <div class="row-fluid">
        <div class="form-actions">
            <?php 
                if(!isset($_GET['sukses'])){
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'cekObat();', 'onkeypress'=>'cekObat();')); //formSubmit(this,event)
                    echo "&nbsp;";
//              Jika tanpa CekObat();
//                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'formSubmit(this,event);', 'onkeypress'=>'formSubmit(this,event);')); 
                }else{
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'formSubmit(this,event);', 'onkeypress'=>'formSubmit(this,event);','disabled'=>true)); 
                    echo "&nbsp;";
                }


                if(!isset($_GET['frame'])){
                    echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        $this->createUrl($this->id.'/index'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'return refreshForm(this);'));
                    echo "&nbsp;";
                }
                if(!isset($_GET['sukses'])){
                    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'disabled'=>'true'));
                    echo "&nbsp;";
//                    echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);',array('class'=>'btn btn-info', 'disabled'=>'true'));  /**RND-4043*/
                }else{
                    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
                    echo "&nbsp;";
//                    echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); /**RND-4043*/
                }


                $content = $this->renderPartial($this->path_view.'tips/tipsRencanaKebutuhan',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
            ?> 
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
<?php $this->renderPartial($this->path_view.'_jsFunctions', array('modRencanaKebFarmasi'=>$modRencanaKebFarmasi)); ?>
