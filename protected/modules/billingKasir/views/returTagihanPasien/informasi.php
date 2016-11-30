<div class="white-container">
    <legend class="rim2">Informasi Retur <b>Tagihan Pasien</b></legend>
    
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'inforetur-form',
            'enableAjaxValidation'=>false,
                    'type'=>'horizontal',
                    'focus'=>'#',
                    'method'=>'GET',
                    'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
    )); ?>
    
    <?php Yii::app()->clientScript->registerScript('cariPasien', "
    $('#inforetur-form').submit(function(){
            $.fn.yiiGridView.update('inforetur-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    
    <div class="block-tabel">
        <h6>Tabel Retur <b>Tagihan Pasien</b></h6>
        <?php 
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
                'id'=>'inforetur-grid',
                'dataProvider'=>$model->searchInformasi(),
                'template'=>"{summary}\n{items}{pager}",
                'itemsCssClass'=>'table table-striped table-condensed',
                'columns'=>array(
                    array(
                        'header'=>'Tgl. Retur/<br/>No. Retur',
                        'name'=>'tglreturpelayanan',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tglreturpelayanan)."/<br/>".'
                        . '$data->noreturbayar',
                    ),
                    array(
                        'header'=>'Tgl. Pembayaran/<br/>No. Pembayaran',
                        'type'=>'raw',
                        'value'=>function($data) use (&$tb)
                        {
                            $tb = BKTandabuktibayarT::model()->findByPk($data->tandabuktibayar_id);
                            return MyFormatter::formatDateTimeForUser($tb->tglbuktibayar)."/<br/>"
                                    . $tb->nobuktibayar;
                        }
                    ),
                    array(
                        'header'=>'Tgl. Pendaftaran/<br/>No. Pendaftaran',
                        'type'=>'raw',
                        'value'=>function($data) use (&$tb, &$p)
                        {
                            $pb = PembayaranpelayananT::model()->findByAttributes(array(
                                'tandabuktibayar_id'=>$tb->tandabuktibayar_id
                            ));
                            $p = PendaftaranT::model()->findByPk($pb->pendaftaran_id);
                            
                            return MyFormatter::formatDateTimeForUser($p->tgl_pendaftaran)."/<br/>"
                                    . $p->no_pendaftaran; 
                        }
                    ),
                    array(
                        'header'=>'No. Rekam Medik',
                        'type'=>'raw',
                        'value'=>function($data) use (&$p)
                        {
                            return $p->pasien->no_rekam_medik;
                        },
                    ),
                    array(
                        'header'=>'Nama Pasien',
                        'type'=>'raw',
                        'value'=>function($data) use (&$p)
                        {
                            return $p->pasien->namadepan.$p->pasien->nama_pasien;
                        },
                    ),
                    array(
                        'header'=>'Cara Bayar/<br/>Penjamin',
                        'name'=>'carabayar_id',
                        'type'=>'raw',
                        'value'=>function($data) use (&$p)
                        {
                            return $p->carabayar->carabayar_nama."/<br/>".$p->penjamin->penjamin_nama;;
                        },
                    ),
                    array(
                        'name'=>'totaloaretur',
                        'value'=>'MyFormatter::formatNumberForPrint($data->totaloaretur)',
                        'htmlOptions'=>array(
                            'style'=>'text-align: right',
                        ),
                    ),
                    array(
                        'name'=>'totaltindakanretur',
                        'value'=>'MyFormatter::formatNumberForPrint($data->totaltindakanretur)',
                        'htmlOptions'=>array(
                            'style'=>'text-align: right',
                        ),
                    ),
                    array(
                        'name'=>'totalbiayaretur',
                        'value'=>'MyFormatter::formatNumberForPrint($data->totalbiayaretur)',
                        'htmlOptions'=>array(
                            'style'=>'text-align: right',
                        ),
                    ),
                    array(
                        'name'=>'biayaadministrasi',
                        'value'=>'MyFormatter::formatNumberForPrint($data->biayaadministrasi)',
                        'htmlOptions'=>array(
                            'style'=>'text-align: right',
                        ),
                    ),
                    'keteranganretur',
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        ));
            ?>
    </div>
    <fieldset class="box">
        <?php echo $this->renderPartial('_search', array('form'=>$form, 'model'=>$model), true); ?>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
            <?php  
                $tips = array(
                    '0' => 'tanggal',
                    '1' => 'cari',
                    '2' => 'ulang2',
                );
                $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
        </div>
    </fieldset>
    
    <?php $this->endWidget(); ?>
</div>