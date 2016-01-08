<div class="white-container">
    <legend class="rim2">Profil <b>Ruangan</b></legend>
    <?php
    $ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modelklinik = RuanganM::model()->findByPk($ruangan_id);
    ?>
    <table class="table table-striped table-bordered">
          <tr>
                  <td width="30%"> 
                       <?php echo CHtml::label('Ruangan','ruangan',array('style'=>'font-weight:bold;',)); ?>
                  </td>
                  <td width="40%" style="font-weight:bold;">
                        <?php echo $modelklinik->ruangan_nama; ?>                 
                   </td>

                   <td width="30%" rowspan="2" colspan="2">
                       <img src="<?php echo Params::urlRuanganTumbsDirectory().'kecil_'.$modelklinik->ruangan_image ?> ">
                   </td>
          </tr>
          <tr>
                   <td width="20%"> 
                       <?php echo CHtml::label('Pegawai','pegawai'); ?>
                  </td>
                  <td width="30%">
                        <?php
                        $tl='';
                        $users = RuanganpegawaiM::model()->findAll("ruangan_id='$ruangan_id' ORDER BY pegawai_id");
                        $tl .= '<ul>';
                        foreach ($users as $user)
                        {
                            $loginpemakai = LoginpemakaiK::model()->findAllByAttributes(array('pegawai_id'=>$user->pegawai_id));
                            foreach($loginpemakai as $i=>$pemakai)
                                $tl .= '<li>'.$pemakai->nama_pemakai.'</li>';
                        }
                        $tl .= '</ul>';
                        echo $tl;
                        ?>
                  </td>
            </tr>
          <tr>
                   <td width="20%"> 
                       <?php echo CHtml::label('Tindakan','tindakan'); ?>
                  </td>
                  <td width="30%">
                        <?php
                        $tl='';
                        $tindakan_ruangan = TindakanruanganM::model()->findAll("ruangan_id='$ruangan_id' ORDER BY ruangan_id");
                        $tl .= '<ul>';
                        foreach ($tindakan_ruangan as $tindakan){
                            $tl .= '<li>'.$tindakan->daftartindakan->daftartindakan_nama.'</li>';
                        }
                        $tl .= '</ul>';
                        echo $tl;
                        ?>
                  </td>
                  <td colspan="2" rowspan="2"></td>
            </tr>
    </table>
    <?php
    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>