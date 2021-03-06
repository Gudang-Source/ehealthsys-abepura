<?php 

	class Bpjs	{
		
		var $mode	= 1;
		var $uid    = ""; //ex: 2603
		var $secret = ""; //ex: 1rs2hs3
		var $url  	= "";
                var $inacbg_url = "";
		
		/*
		var $test_json_rujukan_rs = '{
	        "metadata": 
	        {
		        "code": "200",
		        "message": "OK"
	        },
	        "response": 
		        {
		        "item": 
		        {
			        "catatan": null,
			        "diagnosa": 
			        {
				        "kdDiag": "H259",
				        "nmDiag": null
			        },
			        "keluhan": "abcdef",
			        "noKunjungan": "0312R0010715A000058",
			        "pemFisikLain": "kumis hitam",
			        "peserta": 
			        {
			        "jenisPeserta": 
			        {
				        "kdJenisPeserta": "asd",
				        "nmJenisPeserta": "def"
			        },
			        "kelasTanggungan": 
			        {
				        "kdKelas": "1",
				        "nmKelas": "Kelas 1"
			        },
			        "nama": "RIMBAR YUNUS, IR",
			        "nik": "23424080182301928",
			        "noKartu": "0000033420148",
			        "noMr": null,
			        "pisa": "1",
			        "provUmum": 
			        {
						"kdCabang": null,
						"kdProvider": "03010402",
						"nmCabang": null,
						"nmProvider": "PEGAMBIRAN"
			        },
			        "sex": "P",
			        "statusPeserta": {
						"keterangan": "AKTIF",
						"kode": "0"
					},
			        "tglCetakKartu": null,
					"tglLahir": "1965-01-11",
					"tglTAT": "2065-01-11",
					"tglTMT": "1994-06-01",
			        "umur": null
			        },
			        "poliRujukan": 
			        {
				        "kdPoli": "MAT",
				        "nmPoli": "Poli Mata"
			        },
			        "provKunjungan": 
			        {
			        "kdCabang": null,
			        "kdProvider": "0312R001",
			        "nmCabang": null,
			        "nmProvider": "RSU DR ADNAN WD"
			        },
			        "provRujukan": 
			        {
				        "kdCabang": null,
				        "kdProvider": null,
				        "nmCabang": null,
				        "nmProvider": null
			        },
			        "tglKunjungan": "2015-07-14"
		        }
	        }
        }';		
		
		var $test_json_no_rujukan = '{
          "metadata": {
            "code": "200",
            "message": "OK"
          },
          "response": {
            "item": {
              "catatan": "",
              "diagnosa": {
                "kdDiag": "B54",
                "nmDiag": "Unspecified malaria"
              },
              "keluhan": "",
              "noKunjungan": "030104021115Y000002",
              "pemFisikLain": "",
              "peserta": {
                "informasi": {
                  "dinsos": null,
                  "iuran": null,
                  "noSKTM": null,
                  "prolanisPRB": null
                },
                "jenisPeserta": {
                  "kdJenisPeserta": "1",
                  "nmJenisPeserta": "PNS Daerah"
                },
                "kelasTanggungan": {
                  "kdKelas": "1",
                  "nmKelas": "KELAS I"
                },
                "nama": "SITI AMINAH",
                "nik": null,
                "noKartu": "0000099799751",
                "noMr": null,
                "pisa": "1",
                "provUmum": {
                  "kdCabang": null,
                  "kdProvider": "03010402",
                  "nmCabang": null,
                  "nmProvider": "PEGAMBIRAN"
                },
                "sex": "P",
                "statusPeserta": {
                  "keterangan": "AKTIF",
                  "kode": "0"
                },
                "tglCetakKartu": null,
                "tglLahir": "1965-01-11",
                "tglTAT": "2065-01-11",
                "tglTMT": "1994-06-01",
                "umur": null
              },
              "poliRujukan": {
                "kdPoli": "INT",
                "nmPoli": "Poli Penyakit Dalam"
              },
              "provKunjungan": {
                "kdCabang": null,
                "kdProvider": "03010402",
                "nmCabang": null,
                "nmProvider": "PEGAMBIRAN"
              },
              "provRujukan": {
                "kdCabang": null,
                "kdProvider": "0301R001",
                "nmCabang": null,
                "nmProvider": "RSUP DR M JAMIL PADANG"
              },
              "tglKunjungan": "2015-11-02",
              "tktPelayanan": {
                "nmPelayanan": "Rawat Jalan",
                "tktPelayanan": "10"
              }
            }
          }
        }';
		
		var $test_json_rujukan = '	
		{
          "metadata": {
            "code": "200",
            "message": "OK"
          },
          "response": {
            "item": {
              "catatan": "",
              "diagnosa": {
                "kdDiag": "B54",
                "nmDiag": "Unspecified malaria"
              },
              "keluhan": "",
              "noKunjungan": "030104021115Y000002",
              "pemFisikLain": "",
              "peserta": {
                "informasi": {
                  "dinsos": null,
                  "iuran": null,
                  "noSKTM": null,
                  "prolanisPRB": null
                },
                "jenisPeserta": {
                  "kdJenisPeserta": "1",
                  "nmJenisPeserta": "PNS Daerah"
                },
                "kelasTanggungan": {
                  "kdKelas": "1",
                  "nmKelas": "KELAS I"
                },
                "nama": "SITI AMINAH",
                "nik": null,
                "noKartu": "0000099799751",
                "noMr": null,
                "pisa": "1",
                "provUmum": {
                  "kdCabang": null,
                  "kdProvider": "03010402",
                  "nmCabang": null,
                  "nmProvider": "PEGAMBIRAN"
                },
                "sex": "P",
                "statusPeserta": {
                  "keterangan": "AKTIF",
                  "kode": "0"
                },
                "tglCetakKartu": null,
                "tglLahir": "1965-01-11",
                "tglTAT": "2065-01-11",
                "tglTMT": "1994-06-01",
                "umur": null
              },
              "poliRujukan": {
                "kdPoli": "INT",
                "nmPoli": "Poli Penyakit Dalam"
              },
              "provKunjungan": {
                "kdCabang": null,
                "kdProvider": "03010402",
                "nmCabang": null,
                "nmProvider": "PEGAMBIRAN"
              },
              "provRujukan": {
                "kdCabang": null,
                "kdProvider": "0301R001",
                "nmCabang": null,
                "nmProvider": "RSUP DR M JAMIL PADANG"
              },
              "tglKunjungan": "2015-11-02",
              "tktPelayanan": {
                "nmPelayanan": "Rawat Jalan",
                "tktPelayanan": "10"
              }
            }
          }
        }		
		';
		 * 
		 */
				
				
//		var $server = array(
//				'local'	 => 'http://10.10.0.2:8080/SepLokalRest',
//				'production' => 'http://10.10.0.1:8080/SepLokalRest',
//				'cloud' => 'http://api.asterix.co.id/SepWebRest'
//			);


		function __construct()
		{
			$this->uid = Yii::app()->user->getState('bpjs_uid');
			$this->secret = Yii::app()->user->getState('bpjs_secret');
			$this->url = Yii::app()->user->getState('bpjs_host');
                        $this->inacbg_url = Yii::app()->user->getState('bpjs_inacbg_path');
		}

		function output($content)
		{
			echo $content;
		}

		private function HashBPJS($args = '')
		{
			$uid = $this->uid;
//	RND-9103$uid = 26107; // kendari
//			$uid = 29136; // tarakan
//RND-9239	$timestmp = time();
			date_default_timezone_set('UTC');
			$timestmp = strval(time()-strtotime('1970-01-01 00:00:00'));
			$str = $uid."&".$timestmp;
			$secret = $this->secret;
//			$secret = '0FO9E8AB16'; // kendari
//			$secret = '1rVF57B2FB'; // kendari
			$hasher = base64_encode(hash_hmac('sha256', utf8_encode($str), utf8_encode($secret), TRUE)); //signature;
			return array($uid, $timestmp, $hasher);
		}

		private function request($url, $hashsignature, $uid, $timestmp, $method='', $myvars='', $contentType=null)
		{
			$session = curl_init($url);
			$arrheader =  array(
				'x-cons-id: '.$uid,
				'x-timestamp: '.$timestmp,
				'x-signature: '.$hashsignature,
				'Accept: application/json',
				//'Content-Type: application/xml; charset=utf-8',
				);
                        
                        if (!empty($contentType)) {
                            array_push($arrheader, $contentType);
                        } else {
                            array_push($arrheader, 'Content-Type: application/xml; charset=utf-8');
                        }

			curl_setopt($session, CURLOPT_URL, $url);
			curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
			curl_setopt($session, CURLOPT_VERBOSE, true);

			switch($method){
				case 'POST':
					curl_setopt($session, CURLOPT_POST, true );
					curl_setopt($session, CURLOPT_POSTFIELDS, $myvars);
					break;
				case 'PUT':
					curl_setopt($session, CURLOPT_CUSTOMREQUEST, "PUT");
					curl_setopt($session, CURLOPT_POSTFIELDS, $myvars);
					break;
				case 'DELETE':
					curl_setopt($session, CURLOPT_CUSTOMREQUEST, "DELETE");
					curl_setopt($session, CURLOPT_POSTFIELDS, $myvars);
					break;
			}
			
			curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
			$response = curl_exec($session);
			return $response;
		}

		function identity_magic()
		{
			list($uid, $timestmp, $hashsignature) = $this->HashBPJS();

			echo 'Server: '.$this->url.'<br>';
			echo 'x-cons-id: '.$uid.'<br>';
			echo 'x-timestamp: '.$timestmp.'<br>';
			echo 'x-signature: '.$hashsignature.'<br>';
			echo 'Accept: application/json'.'<br>';
			echo 'Content-Type: application/xml; charset=utf-8'.'<br>';
		}
		
		function help()
		{
			$url = $this->url.'/help';
			$session = curl_init($url);
			curl_setopt($session, CURLOPT_URL, $url);
			curl_setopt($session, CURLOPT_VERBOSE, true);
			curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
			$response = curl_exec($session);
			return $response;
		}

		function search_kartu($query)
		{
			list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
			$completeUrl = $this->url.'/peserta/peserta/'.$query;
			//echo $completeUrl; die;
			$dat = CJSON::decode($this->request($completeUrl, $hashsignature, $uid, $timestmp));
			if ($dat['metadata']['code'] == 200) {
				$k = KelaspelayananM::model()->findByAttributes(array(
					'kelasbpjs_id'=>$dat['response']['peserta']['kelasTanggungan']['kdKelas'],
				));
				$dat['response']['peserta']['kelasTanggungan']['kdKelasSim'] = $k->kelaspelayanan_id;
			}
			return CJSON::encode($dat); //$this->request($completeUrl, $hashsignature, $uid, $timestmp);
		}

		function search_nik($query)
		{
			list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
			$completeUrl = $this->url.'/peserta/peserta/nik/'.$query;
			// return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
			$dat = CJSON::decode($this->request($completeUrl, $hashsignature, $uid, $timestmp));
			if ($dat['metadata']['code'] == 200) {
				$k = KelaspelayananM::model()->findByAttributes(array(
					'kelasbpjs_id'=>$dat['response']['peserta']['kelasTanggungan']['kdKelas'],
				));
				$dat['response']['peserta']['kelasTanggungan']['kdKelasSim'] = $k->kelaspelayanan_id;
			}
			return CJSON::encode($dat); //$this->request($completeUrl, $hashsignature, $uid, $timestmp);
		}

		function search_rujukan_no_rujukan($query)
		{
			list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
			$completeUrl = $this->url.'/Rujukan/'.$query;
			
			$res = CJSON::decode($this->request($completeUrl, $hashsignature, $uid, $timestmp));
			// $res = CJSON::decode($this->test_json_no_rujukan);
			if ($res['metadata']['code'] == 200) {
				$item = $res['response']['item'];
				$item['tglKunjungan'] = MyFormatter::formatDateTimeForUser($item['tglKunjungan']);
				$item['peserta']['tglLahir'] = MyFormatter::formatDateTimeForUser($item['peserta']['tglLahir']);
				$item['peserta']['tglTAT'] = MyFormatter::formatDateTimeForUser($item['peserta']['tglTAT']);
				$item['peserta']['tglTMT'] = MyFormatter::formatDateTimeForUser($item['peserta']['tglTMT']);
				$res['response']['item'] = $item;
			}
			
			return CJSON::encode($res);
			// return $this->request($completeUrl, $hashsignature, $uid, $timestmp);	
		}

		function search_rujukan_no_bpjs($query)
		{
			list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
			$completeUrl = $this->url.'/Rujukan/Peserta/'.$query;
			
			$res = CJSON::decode($this->request($completeUrl, $hashsignature, $uid, $timestmp));
			// $res = CJSON::decode($this->test_json_rujukan);
			if ($res['metadata']['code'] == 200) {
				$item = $res['response']['item'];
				$item['tglKunjungan'] = MyFormatter::formatDateTimeForUser($item['tglKunjungan']);
				$item['peserta']['tglLahir'] = MyFormatter::formatDateTimeForUser($item['peserta']['tglLahir']);
				$item['peserta']['tglTAT'] = MyFormatter::formatDateTimeForUser($item['peserta']['tglTAT']);
				$item['peserta']['tglTMT'] = MyFormatter::formatDateTimeForUser($item['peserta']['tglTMT']);
				$res['response']['item'] = $item;
			}
			
			return CJSON::encode($res);
		}

		function list_rujukan_tanggal($query, $start, $limit)
		{
			list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
			$completeUrl = $this->url.'/rujukan/tglrujuk/'.$query.'/query?start='.$start.'&limit='.$limit;
			return $this->request($completeUrl, $hashsignature, $uid, $timestmp);		
		}
		
		function search_rujukan_rs_no_rujukan($query)
		{
			list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
			$completeUrl = $this->url.'/Rujukan/RS/'.$query;
			$res = CJSON::decode($this->request($completeUrl, $hashsignature, $uid, $timestmp));	
			// $res = CJSON::decode($this->test_json_rujukan_rs);
			
			// var_dump($res); die;
			
			if ($res['metadata']['code'] == 200) {
				$item = $res['response']['item'];
				$item['tglKunjungan'] = MyFormatter::formatDateTimeForUser($item['tglKunjungan']);
				$item['peserta']['tglLahir'] = MyFormatter::formatDateTimeForUser($item['peserta']['tglLahir']);
				$item['peserta']['tglTAT'] = MyFormatter::formatDateTimeForUser($item['peserta']['tglTAT']);
				$item['peserta']['tglTMT'] = MyFormatter::formatDateTimeForUser($item['peserta']['tglTMT']);
				$res['response']['item'] = $item;
			}
			
			return CJSON::encode($res);
			
		}

		function search_rujukan_rs_no_bpjs($query)
		{
			list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
			$completeUrl = $this->url.'/Rujukan/RS/peserta/'.$query;
			$res = CJSON::decode($this->request($completeUrl, $hashsignature, $uid, $timestmp));	
			// $res = CJSON::decode($this->test_json_rujukan_rs);
			if ($res['metadata']['code'] == 200) {
				$item = $res['response']['item'];
				$item['tglKunjungan'] = MyFormatter::formatDateTimeForUser($item['tglKunjungan']);
				$item['peserta']['tglLahir'] = MyFormatter::formatDateTimeForUser($item['peserta']['tglLahir']);
				$item['peserta']['tglTAT'] = MyFormatter::formatDateTimeForUser($item['peserta']['tglTAT']);
				$item['peserta']['tglTMT'] = MyFormatter::formatDateTimeForUser($item['peserta']['tglTMT']);
				$res['response']['item'] = $item;
			}
			
			return CJSON::encode($res);
			
		}

		function list_rujukan_rs_tanggal($query, $start, $limit)
		{
			list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
			$completeUrl = $this->url.'/rujukanrs/tglrujuk/'.$query.'/query?start='.$start.'&limit='.$limit;
			return $this->request($completeUrl, $hashsignature, $uid, $timestmp);		
		}
		
		function create_sep($nokartu, $tglsep, $tglrujukan, $norujukan, $ppkrujukan, $ppkpelayanan, $jnspelayanan, $catatan, $diagawal, $politujuan, $klsrawat, $user, $nomr, $no_trans, $lakaLantas)
		{
			$query = array(
				'request'=>array(
					't_sep'=>array(
						'noKartu'=>$nokartu,
						'tglSep'=>$tglsep,
						'tglRujukan'=>$tglrujukan,
						"noRujukan"=>$norujukan,
						"ppkRujukan"=>$ppkrujukan,
						"ppkPelayanan"=>$ppkpelayanan,
						"jnsPelayanan"=>$jnspelayanan,
						"catatan"=>$catatan,
						"diagAwal"=>$diagawal,
						"poliTujuan"=>$politujuan,
						"klsRawat"=>$klsrawat,
						"lakaLantas"=>$lakaLantas,
						"lokasiLaka"=>"",
						"user"=>'MDO',
						"noMr"=>$nomr
					),
				),
			);
			
			foreach ($query['request']['t_sep'] as $attr => $item) {
				$query['request']['t_sep'][$attr] = (string) $item;
			}
			
			// var_dump($query);
			// die;
                        
                        // echo "<pre>".CHtml::encode($query)."</pre>"; die;
                        //var_dump($this->HashBPJS());
			list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
			
			$completeUrl = $this->url.'/SEP/insert';
                        // echo $completeUrl; die;
			
			$result = $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'POST', CJSON::encode($query), 'Application/x‐www‐form‐urlencoded');
			// echo($result); die;
            $result = json_decode($result, true);
            // var_dump($result); die;
                        
			$final_result['response'] = $result['response'];
			$final_result['metadata'] = $result['metadata'];

			$this->mapping_trans($result['response'], $no_trans, $ppkpelayanan);
			return json_encode($final_result);
			
		}
		
		function update_sep($nosep, $nokartu, $tglsep, $tglrujukan, $norujukan, $ppkrujukan, $ppkpelayanan, $jnspelayanan, $catatan, $diagawal, $politujuan, $klsrawat, $user, $nomr, $no_trans, $lakaLantas)
		{
			$query = array(
				'request'=>array(
					't_sep'=>array(
						'noSep'=>$nosep,
						'noKartu'=>$nokartu,
						'tglSep'=>$tglsep,
						'tglRujukan'=>$tglrujukan,
						"noRujukan"=>$norujukan,
						"ppkRujukan"=>$ppkrujukan,
						"ppkPelayanan"=>$ppkpelayanan,
						"jnsPelayanan"=>$jnspelayanan,
						"catatan"=>$catatan,
						"diagAwal"=>$diagawal,
						"poliTujuan"=>$politujuan,
						"klsRawat"=>$klsrawat,
						"lakaLantas"=>$lakaLantas,
						"lokasiLaka"=>"",
						"user"=>'MDO',
						"noMr"=>$nomr
					),
				),
			);
			
			foreach ($query['request']['t_sep'] as $attr => $item) {
				$query['request']['t_sep'][$attr] = (string) $item;
			}
			
			// var_dump($query);
			// die;
                        
                        // echo "<pre>".CHtml::encode($query)."</pre>"; die;
                        //var_dump($this->HashBPJS());
			list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
			
			$completeUrl = $this->url.'/SEP/insert';
                        // echo $completeUrl; die;
			
			$result = $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'POST', CJSON::encode($query), 'Application/x‐www‐form‐urlencoded');
			// echo($result); die;
            $result = json_decode($result, true);
            // var_dump($result); die;
                        
			$final_result['response'] = $result['response'];
			$final_result['metadata'] = $result['metadata'];

			$this->mapping_trans($result['response'], $no_trans, $ppkpelayanan);
			return json_encode($final_result);
		}

		function update_tanggal_pulang_sep($nosep, $tglpulang, $ppkpelayanan){
			
			$query = array(
				'request'=>array(
					't_sep'=>array(
						'noSep'=>$nosep,
						'tglPlg'=>$tglpulang,
						'ppkPelayanan'=>$ppkpelayanan,
					)
				)
			);

			foreach ($query['request']['t_sep'] as $attr => $item) {
				$query['request']['t_sep'][$attr] = (string) $item;
			}
			
			list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
			$completeUrl = $this->url.'/Sep/updtglplg';
			return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'PUT', CJSON::encode($query), 'Application/x‐www‐form‐urlencoded');		
		}

		function mapping_trans($nosep, $notrans, $ppkpelayanan){
			$query = array(
				'request'=>array(
					't_map_sep'=>array(
						'noSep'=>$nosep,
						'noTrans'=>$notrans,
						'ppkPelayanan'=>$ppkpelayanan,
					)
				)
			);
			
			foreach ($query['request']['t_map_sep'] as $attr => $item) {
				$query['request']['t_map_sep'][$attr] = (string) $item;
			}
            //echo CHtml::encode($query); die;
			
			list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
			$completeUrl = $this->url.'/SEP/map/trans';
			return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'POST', CJSON::encode($query), 'Application/x‐www‐form‐urlencoded');		
		}

		function delete_sep($nosep, $ppkpelayanan) {
			$query = array(
				'request'=>array(
					't_sep'=>array(
						'noSep'=>$nosep,
						'ppkPelayanan'=>$ppkpelayanan,
					)
				)
			);
			
			foreach ($query['request']['t_sep'] as $attr => $item) {
				$query['request']['t_sep'][$attr] = (string) $item;
			}
			
			
			list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
			$completeUrl = $this->url.'/SEP/Delete';
			return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'DELETE', CJSON::encode($query), 'Application/x‐www‐form‐urlencoded');		
		}
		
		function delete_transaksi($nosep){
			list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
			$completeUrl = $this->url.'/SEP/sep';
			$query = '<request>
						<data>
							<t_map_sep>
								<noSep>'.$nosep.'</noSep>
								<ppkPelayanan>'.$ppkpelayanan.'</ppkPelayanan>
							</t_map_sep>
						</data>
					</request>';
			return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'DELETE', $query, 'Application/x‐www‐form‐urlencoded');		
		}

		function riwayat_terakhir($query){
			list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
			$completeUrl = $this->url.'/sep/peserta/'.$query;
			return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
		}

		function detail_sep($query){
			list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
			$completeUrl = $this->url.'/SEP/'.$query;
			return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
		}

		function detail_ppk_rujukan($query, $start, $limit){
			list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
			$completeUrl = $this->url.'/provider/ref/provider/query?nama='.$query.'&start='.$start.'&limit='.$limit;
			return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
		}
		
		function search_diagosa($query){
                        $vars = 'icd='.$query.'&reqdata=diagnosa';
			list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
			$completeUrl = $this->inacbg_url.'/icd.php';
			$res = CJSON::decode($this->request($completeUrl, $hashsignature, $uid, $timestmp, 'POST', $vars, 'Application/x‐www‐form‐urlencoded'));
                        
                        if (count($res) != 0) {
                            $icd_code = array();
                            foreach ($res as $key=>$row) {
                                $icd_code[$key] = $row['ICD_CODE'];
                            }
                            
                            array_multisort($icd_code, SORT_ASC, $res);
                        }
                        
                        return CJSON::encode($res);
		}
		
		function search_cbg_sep($query) {
			list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
			$completeUrl = $this->url.'/sep/cbg/'.$query;
			return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
		}
		
		function search_cbg($query){
                        $vars = 'icd='.$query.'&reqdata=procedure';
			list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
			$completeUrl = $this->inacbg_url.'/icd.php';
			$res = CJSON::decode($this->request($completeUrl, $hashsignature, $uid, $timestmp, 'POST', $vars, 'Application/x‐www‐form‐urlencoded'));
                        
                        if (count($res) != 0) {
                            $icd_code = array();
                            foreach ($res as $key=>$row) {
                                $icd_code[$key] = $row['ICD_CODE'];
                            }
                            
                            array_multisort($icd_code, SORT_ASC, $res);
                        }
                        
                        return CJSON::encode($res);
		}
		
		function search_cmg($query){
                        $vars = 'proc='.$query.'&reqdata=cmg';
			list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
			$completeUrl = $this->inacbg_url.'/ws_cmg.php';
			return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'POST', $vars, 'Application/x‐www‐form‐urlencoded');
		}
		
		function create_laporan_sep($query){
			list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
			$completeUrl = $this->url.'/sep/integrated/Kunjungan/sep/'.$query;
			return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
		}
		
		function monitor_verifikasi_klaim($tglMasuk = null, $tglKeluar = null, $klsRawat = null, $kasus = null, $cari = null, $status = null) {
			$completeUrl = $this->url.'/sep/integrated/Kunjungan';
			
			if (!empty($tglMasuk)) $completeUrl .= '/tglMasuk/'.$tglMasuk;
			if (!empty($tglKeluar)) $completeUrl .= '/tglKeluar/'.$tglKeluar;
			if (!empty($klsRawat)) $completeUrl .= '/klsRawat/'.$klsRawat;
			if (!empty($kasus)) $completeUrl .= '/kasus/'.$kasus;
			if (!empty($cari)) $completeUrl .= '/Cari/'.$cari;
			if (!empty($status)) $completeUrl .= '/status/'.$status;
			
			list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
			return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
		}
		
		function create_grouper($query){
			list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
			$completeUrl = $this->inacbg_url.'/ca_grouper.php?'.$query;
			return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
		}
		
		function create_finalisasi_grouper($query){
			list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
			$completeUrl = $this->url.'/gruper/grouper/save'.$query;
			return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
		}
		
		
		function referensi_diagnosa($query) {
			list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
			$completeUrl = $this->url.'/diagnosa/ref/diagnosa/'.$query;
			return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
		}
		
		function referensi_poli($query) {
			list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
			$completeUrl = $this->url.'/poli/ref/poli/'.$query;
			return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
		}
		
		function referensi_fasilitas($nama, $start, $limit) {
			list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
			$completeUrl = $this->url.'/provider/ref/provider/query?nama='.$nama
				."&start=".$start."&limit=".$limit;
			return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
		}
		
	}
	
?>