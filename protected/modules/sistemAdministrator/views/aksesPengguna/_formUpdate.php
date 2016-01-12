<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'saaksespengguna-k-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#',
)); ?>

    <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

    <?php echo $form->errorSummary($model); ?>
    
    <div class="row-fluid">

	<div class = "span4"><div class="control-group">
                    <?php echo CHtml::label('Login Pemakai','',array('class'=>'control-label')) ?>
                    <div class="controls">
                            <?php
                                $this->widget('MyJuiAutoComplete',array(
                                        'name'=>'namaloginpemakai',
                                        'value'=>$model->loginpemakai->nama_pemakai,
                                        'sourceUrl'=> $this->createUrl('AutocompleteLoginPemakai'),
                                        'options'=>array(
                                           'showAnim'=>'fold',
                                           'minLength' => 2,
                                           'focus'=> 'js:function( event, ui ) {
                                                setDataPemakai(ui.item.value);
                                                return false;
                                            }',
                                           'select'=>'js:function( event, ui ) {
                                                setDataPemakai(ui.item.value);
                                                return false;
                                            }',

                                        ),
                                        'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 '),
                                        'tombolDialog'=>array('idDialog'=>'dialogLoginPemakai','idTombol'=>'tombolLoginPemakai'),
                            )); ?>
                    </div>
                </div>
            <?php echo $form->hiddenField($model,'loginpemakai_id',array('id'=>'loginpemakai_id')); ?>
            <div class="control-group">
                <?php echo CHtml::label('Nama','',array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php echo CHtml::textField('nama_pegawai',$model->loginpemakai->pegawai->nama_pegawai,array('id'=>'namapegawai','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
                </div>
            </div>
    </div>
		<div class = "span4">
            
        </div>
        <div class = "span4">
            
        </div>
    </div>
    <div class="block-tabel">
        <h6>Tabel <b>Akses Pemakai</b></h6>
        <table class='table table-striped table-bordered table-condensed' id="aksesPengguna">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Peran Pemakai</th>
                    <th>Modul</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach ($data as $i => $peran) {
                ?>
                        <tr>
                            <td></td>
                            <td>
                            <?php 
                                echo CHtml::CheckBox('peran','', array(
                                            'value'=>$i,
                                            'onclick'=>'tambahModul(this)',
                                            ));
                                echo '&nbsp;'.$peran['nama'];
                            ?>
                            </td>
                            <td id="row_modul_<?php echo $i; ?>">
                            <?php 
                                echo "<span id='modul_".$i."'>";
                                    foreach ($data[$i]['modul'] as $j => $modul) {
                                        echo CHtml::CheckBox('modul['.$i.'][]','', array(
                                                            'value'=>$modul->modul_id,
                                                            ));
                                        echo '&nbsp;'.$modul->modul->modul_nama.'<br>';
                                    }
                                echo "</span>";
                            ?>

                            </td>
                        </tr>
                <?php 
                    }
                ?>
                
            </tbody>
        </table>
    </div>
    <div class="row-fluid">
	<div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        $this->createUrl($this->id.'/admin'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = window.location.href;} ); return false;'));  ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Akses Pemakai',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl($this->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
                <?php $this->widget('UserTips',array('type'=>'create'));?>
        </div>
    </div>
<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogLoginPemakai',
    'options'=>array(
        'title'=>'Daftar Login Pemakai',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPemakai = new LoginpemakaiK;
if (isset($_GET['LoginpemakaiK']))
    $modPemakai->attributes = $_GET['LoginpemakaiK'];

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawai-m-grid',
    'dataProvider'=>$modPemakai->search(),
    'filter'=>$modPemakai,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","#",array("class"=>"btn-small", 
                            "id" => "selectPemakai",
                            "onClick" => "
                                          setDataPemakai(\"$data->loginpemakai_id\");
                                          $(\"#dialogLoginPemakai\").dialog(\"close\");    
                                          return false;
                                "))',
        ),
        'nama_pemakai',
        'pegawai.nama_pegawai',
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>
