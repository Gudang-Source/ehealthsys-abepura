<?php

/**
 * This is the model class for table "laporanclosingkasir_v".
 *
 * The followings are the available columns in table 'laporanclosingkasir_v':
 * @property integer $closingkasir_id
 * @property integer $shift_id
 * @property string $shift_nama
 * @property integer $pegawai_id
 * @property string $nama_pegawai
 * @property integer $setorbank_id
 * @property string $nostruksetor
 * @property string $tgldisetor
 * @property string $namabank
 * @property string $norekening
 * @property double $jumlahsetoran
 * @property string $tglclosingkasir
 * @property string $closingdari
 * @property string $sampaidengan
 * @property double $closingsaldoawal
 * @property double $terimauangmuka
 * @property double $terimauangpelayanan
 * @property double $totalpengeluaran
 * @property double $totalsetoran
 * @property string $keterangan_closing
 * @property double $jmluanglogam
 * @property double $jmluangkertas
 * @property integer $jmltransaksi
 * @property double $piutang
 * @property double $nilaiclosingtrans
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class LaporanclosingkasirV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanclosingkasirV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'laporanclosingkasir_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('closingkasir_id, shift_id, pegawai_id, setorbank_id, jmltransaksi', 'numerical', 'integerOnly'=>true),
			array('jumlahsetoran, closingsaldoawal, terimauangmuka, terimauangpelayanan, totalpengeluaran, totalsetoran, jmluanglogam, jmluangkertas, piutang, nilaiclosingtrans', 'numerical'),
			array('shift_nama, nama_pegawai', 'length', 'max'=>50),
			array('nostruksetor, namabank, norekening', 'length', 'max'=>100),
			array('tgldisetor, tglclosingkasir, closingdari, sampaidengan, keterangan_closing, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('closingkasir_id, shift_id, shift_nama, pegawai_id, nama_pegawai, setorbank_id, nostruksetor, tgldisetor, namabank, norekening, jumlahsetoran, tglclosingkasir, closingdari, sampaidengan, closingsaldoawal, terimauangmuka, terimauangpelayanan, totalpengeluaran, totalsetoran, keterangan_closing, jmluanglogam, jmluangkertas, jmltransaksi, piutang, nilaiclosingtrans, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'closingkasir_id' => 'Closing Kasir',
			'shift_id' => 'Shift',
			'shift_nama' => 'Shift',
			'pegawai_id' => 'Pegawai',
			'nama_pegawai' => 'Pegawai / Kasir',
			'setorbank_id' => 'Setorbank',
			'nostruksetor' => 'No. Struk Setor',
			'tgldisetor' => 'Tanggal Disetor',
			'namabank' => 'Nama Bank',
			'norekening' => 'No. Rekening',
			'jumlahsetoran' => 'Jumlah Setoran',
			'tglclosingkasir' => 'Tanggal Closing Kasir',
			'closingdari' => 'Closing Dari',
			'sampaidengan' => 'Sampai Dengan',
			'closingsaldoawal' => 'Saldo Awal',
			'terimauangmuka' => 'Uang Muka',
			'terimauangpelayanan' => 'Uang Pelayanan',
			'totalpengeluaran' => 'Total Pengeluaran',
			'totalsetoran' => 'Total Setoran',
			'keterangan_closing' => 'Keterangan Closing',
			'jmluanglogam' => 'Uang Logam',
			'jmluangkertas' => 'Uang Kertas',
			'jmltransaksi' => 'Transaksi',
			'piutang' => 'Piutang',
			'nilaiclosingtrans' => 'Jumlah Closing',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('closingkasir_id',$this->closingkasir_id);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('shift_nama',$this->shift_nama,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('setorbank_id',$this->setorbank_id);
		$criteria->compare('nostruksetor',$this->nostruksetor,true);
		$criteria->compare('tgldisetor',$this->tgldisetor,true);
		$criteria->compare('namabank',$this->namabank,true);
		$criteria->compare('norekening',$this->norekening,true);
		$criteria->compare('jumlahsetoran',$this->jumlahsetoran);
		$criteria->compare('tglclosingkasir',$this->tglclosingkasir,true);
		$criteria->compare('closingdari',$this->closingdari,true);
		$criteria->compare('sampaidengan',$this->sampaidengan,true);
		$criteria->compare('closingsaldoawal',$this->closingsaldoawal);
		$criteria->compare('terimauangmuka',$this->terimauangmuka);
		$criteria->compare('terimauangpelayanan',$this->terimauangpelayanan);
		$criteria->compare('totalpengeluaran',$this->totalpengeluaran);
		$criteria->compare('totalsetoran',$this->totalsetoran);
		$criteria->compare('keterangan_closing',$this->keterangan_closing,true);
		$criteria->compare('jmluanglogam',$this->jmluanglogam);
		$criteria->compare('jmluangkertas',$this->jmluangkertas);
		$criteria->compare('jmltransaksi',$this->jmltransaksi);
		$criteria->compare('piutang',$this->piutang);
		$criteria->compare('nilaiclosingtrans',$this->nilaiclosingtrans);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
//        RND-6992 Format date langsung diedit di view nya.      	
//        protected function afterFind(){
//            foreach($this->metadata->tableSchema->columns as $columnName => $column){
//
//                if (!strlen($this->$columnName)) continue;
//
//                if ($column->dbType == 'date'){                         
//                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
//                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
//                        }elseif ($column->dbType == 'timestamp without time zone'){
//                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
//                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss'));
//                        }
//            }
//            return true;
//        }
       
}