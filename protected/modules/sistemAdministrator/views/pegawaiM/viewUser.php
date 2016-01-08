<fieldset style="width:800px; ">
        <table style="width: 800px" class="table table-bordered">
              <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('nama_pegawai'),$model->getAttributeLabel('nama_rumahsakit'));?>
                      </td>
                      <td width="30%">
                            <?php //echo CHtml::label($model->gelardepan.' '.$model->nama_pegawai.' '.$model->gelarbelakang->gelarbelakang_nama,  $model->gelardepan.' '.$model->nama_pegawai.' '.$model->gelarbelakang->gelarbelakang_nama);?>                  
                            <?php echo CHtml::label($model->gelardepan.' '.$model->nama_pegawai.' '.(isset($model->gelarbelakang_id)?$model->gelarbelakang->gelarbelakang_nama:""), $model->gelardepan.' '.$model->nama_pegawai.' '.(isset($model->gelarbelakang_id)?$model->gelarbelakang->gelarbelakang_nama:""));?>                  
                       </td>
                       
                       <td width="20%">
                           <?php echo CHtml::label('Username','nama_pemakai'); ?>
                       </td>
                       <td width="30%">
                           <?php
                                $loginpemakai=LoginpemakaiK::model()->find("pegawai_id='$model->pegawai_id'");
                                echo $loginpemakai->nama_pemakai;
                           ?>
                       </td>
              </tr>
              <tr>
                       <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('jeniskelamin'),$model->getAttributeLabel('jeniskelamin'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $model->jeniskelamin, $model->jeniskelamin);?>                     
                      </td>
                      
                      <td width="20%">
                            <?php echo CHtml::label('Terakhir Login','terakhir login'); ?>
                      </td>
                      <td width="30%">
                            <?php echo $loginpemakai->lastlogin; ?>
                      </td>
              </tr>
              <tr>
                       <td width="20%"> 
                           <?php echo CHtml::label('Tempat Tanggal Lahir','ttl')?>
                      </td>
                      <td width="30%">
                          <?php echo $model->tempatlahir_pegawai . ' ' .$model->tgl_lahirpegawai ?>
                      </td>
                      
                      <td width="20%">
                          <?php echo CHtml::label('Tanggal Pembuatan','tanggal pembuatan'); ?>
                      </td>
                      <td width="30%">
                          <?php $loginpemakai->tglpembuatanlogin; ?>
                      </td>
              </tr>
                <tr>
                       <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('jabatan_id').' / '.$model->getAttributeLabel('kelompokjabatan'),$model->getAttributeLabel('jabatan_id').'/'.$model->getAttributeLabel('kelompokjabatan'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( 'jabatan',(isset($model->jabatan) ? $model->jabatan->jabatan_nama .'/' : "").$model->kelompokjabatan);?>                     
                      </td>
                      <td width="20%">
                          <?php echo CHtml::label('Tanggal Update','tanggal update'); ?>
                      </td>
                      
                      <td width="30%">
                           <?php echo $loginpemakai->tglupdatelogin; ?>                          
                      </td>
                </tr>
                 <tr>
                      <td width="20%" height="2px"> 
                           <?php echo CHtml::label($model->getAttributeLabel('agama'),$model->getAttributeLabel('agama'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label($model->agama, $model->agama);?>                   
                      </td>
					  <td width="20%" rowspan="3"> 
                           <?php echo CHtml::label($model->getAttributeLabel('ruangan'),$model->getAttributeLabel('ruangan'));?>
                      </td>
                      <td width="30%" rowspan="3">
                          <?php $this->renderPartial('_ruanganPegawai',array('pegawai_id'=>$model->pegawai_id))?>
                      </td>
                 </tr>
                 <tr>
                      <td width="20%" height="2px"> 
                           <?php echo CHtml::label($model->getAttributeLabel('notelp_pegawai'),$model->getAttributeLabel('notelp_pegawai'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label($model->notelp_pegawai, $model->notelp_pegawai);?>
                      </td>
                 </tr>
                <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('alamat_pegawai'),$model->getAttributeLabel('alamat_pegawai'));?>
                      </td>
                   <td>
                         <?php echo CHtml::label( $model->alamat_pegawai, $model->alamat_pegawai);?>                     
                   </td>
                </tr>
        </table>
</fieldset>
<?php
$this->widget('bootstrap.widgets.BootAlert'); ?>