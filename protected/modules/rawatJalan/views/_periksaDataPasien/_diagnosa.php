<?php
$modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
if(count($modPendaftaran) > 0){
	if(!empty($modPendaftaran->rujukan_id)){
		$modRujukan = RujukanT::model()->findByPk($modPendaftaran->rujukan_id);
		echo isset($modRujukan->kddiagnosa_rujukan) ? $modRujukan->kddiagnosa_rujukan : ""." - ".isset($modRujukan->diagnosa_rujukan) ? $modRujukan->diagnosa_rujukan : "";
	}
}
?>