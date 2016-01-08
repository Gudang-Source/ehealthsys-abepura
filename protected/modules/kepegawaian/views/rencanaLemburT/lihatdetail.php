<br>
<?php 

$arrMenu = array();
                 // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>'Lihat Detail Rencana Lembur ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
$this->menu=$arrMenu;
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'lihat-detail-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>
<table class="table-condensed">
    <tr>
        <td width="50%">
            <div class="control-group">
                <?php echo $form->uneditableRow($modRencanaLembur,'tglrencana', array('class'=>'span3')); ?>
            </div>
            <div class="control-group">
                <?php echo $form->uneditableRow($modRencanaLembur,'norencana',array('class'=>'span3')); ?>
                </div>
        </td>
        <td width="50%">
            <div class="control-group">
                <?php $modRencanaLembur->mengetahui_nama = $modRencanaLembur->getPegawaiAttributes($modRencanaLembur->mengetahui_id,'nama_pegawai'); ?>
                <?php echo $form->uneditableRow($modRencanaLembur,  'mengetahui_nama',array('class'=>'span3')); ?>
            </div>
            <div class="control-group">
                <?php $modRencanaLembur->menyetujui_nama = $modRencanaLembur->getPegawaiAttributes($modRencanaLembur->menyetujui_id,'nama_pegawai'); ?>
                <?php echo $form->uneditableRow($modRencanaLembur,  'menyetujui_nama',array('class'=>'span3')); ?>
            </div>
        </td>
    </tr>
</table>
<table id="tabelPegawaiLembur" class="table table-bordered table-condensed">
    <thead>
    <tr>
        <th style="text-align: center;">No.</th>
        <th style="text-align: center;">No. Induk Pegawai</th>
        <th style="text-align: center;">Nama Pegawai</th>
        <!--<th style="text-align: center;">Departemen</th>-->
        <th style="text-align: center;">Jam Mulai</th>
        <th style="text-align: center;">Jam Selesai</th>
        <th style="text-align: center;">Alasan Lembur</th>
        
    </tr>
    </thead>
    <tbody>
        <?php                    
            $tr = '';
            $no = 1;
            $format = new MyFormatter;
             foreach ($modDetail as $key => $detail) {
                    $modDetail[$key]->jamMulai = date('H:i', strtotime($modDetail[$key]->tglmulai));
                    $modDetail[$key]->jamSelesai = date('H:i', strtotime($modDetail[$key]->tglselesai));
                    $tr.="<tr>
                       <td>". CHtml::TextField('noUrut',$no++,array('class'=>'span1 noUrut','readonly'=>TRUE))."</td>
                       <td>".$modDetail[$key]->pegawai->nomorindukpegawai."</td>
                       <td>".$modDetail[$key]->pegawai->nama_pegawai."</td>
                       <td style='text-align:center;'>".$modDetail[$key]->jamMulai."</td>
                       <td style='text-align:center;'>".$modDetail[$key]->jamSelesai."</td>
                       <td>".$modDetail[$key]->alasanlembur."</td>
                       </tr>   
                   "; // <td>".$modDetail[$key]->pegawai->departement->departement_nama."</td>
                    
             }
             echo $tr;
        ?>
    </tbody>
</table>
<table class="table-condensed">
    <tr>
        <td width="50%">
            <div class="control-group">
                <?php echo $form->labelEx($modRencanaLembur, 'keterangan', array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textArea($modRencanaLembur, 'keterangan', array('readonly'=>true)); ?>
                </div>
            </div>
        </td>
        <td width="50%">
            <div class="control-group">
                <?php $modRencanaLembur->pemberitugas_nama = $modRencanaLembur->getPegawaiAttributes($modRencanaLembur->pemberitugas_id,'nama_pegawai'); ?>
                <?php echo $form->uneditableRow($modRencanaLembur,  'pemberitugas_nama',array('class'=>'span3')); ?>
            </div>
        </td>
    </tr>    

</table>
            

<?php $this->endWidget(); ?>


