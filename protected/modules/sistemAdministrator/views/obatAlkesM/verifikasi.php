<legend class="btn-info">Data Ubah Harga Obat</legend>
<div class="row-fluid form-horizontal">
    <div class="span6">
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                'obatalkes.obatalkes_nama',
                'sumberdana.sumberdana_nama',
                'loginpemakai_id',
                'tglperubahan',
            ),
    )); ?>
    
    </div>
    <div class="span6">
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                'harganettoasal',
                'hargajualasal',
                'harganettoperubahan',
                'hargajualperubahan',
            ),
    )); ?>
    </div>
    <div class="control-group">
        <label class="control-label required">Alasan Perubahan <span class="required">*</span></label>                               
        <div class="controls">
            <?php echo CHtml::textArea('alasanperubahan','',array('onchange'=>'setAlasan()')); ?>
        </div>
     </div>
     <div class="control-group">
        <label class="control-label required">Disetujui Oleh <span class="required">*</span></label>                               
        <div class="controls">
            <?php echo CHtml::textField('disetujuioleh', Yii::app()->user->nama_pemakai,array('onchange'=>'setAlasan()')); ?>
        </div>
     </div>
</div>
