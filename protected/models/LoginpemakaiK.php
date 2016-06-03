<?php

/**
 * This is the model class for table "loginpemakai_k".
 *
 * The followings are the available columns in table 'loginpemakai_k':
 * @property integer $loginpemakai_id
 * @property string $nama_pemakai
 * @property string $katakunci_pemakai
 * @property string $lastlogin
 * @property string $tglpembuatanlogin
 * @property string $tglupdatelogin
 * @property boolean $statuslogin
 * @property boolean $loginpemakai_aktif
 * @property integer $create_user_id
 * @property integer $update_user_id
 */
class LoginpemakaiK extends CActiveRecord
{
        public $new_password;
        public $new_password_repeat;
        public $old_password;
        public $ruangan;
        public $modul;
        public $nama_pegawai;
        public $nama_pasien;
        public $jenispemakai;
                
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LoginpemakaiK the static model class
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
		return 'loginpemakai_k';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('pegawai_id, pasien_id', 'numerical', 'integerOnly'=>true),
			array('nama_pemakai, katakunci_pemakai', 'required'),
			array('nama_pemakai', 'length', 'max'=>200),
			array('katakunci_pemakai', 'length', 'max'=>200),
			array('lastlogin, tglpembuatanlogin,  statuslogin, loginpemakai_aktif', 'safe'),
                        array('old_password','cekPassword','on'=>' changePassword'),
                        array('old_password','cekPassword2','on'=>' changePassword2'),
                        array('nama_pemakai','cekUsername','on'=>'insert, changePassword,update'),
                        array('new_password', 'length', 'max'=>200),
                        array('new_password', 'compare', 'on'=>'insert, changePassword'),
                        array('new_password_repeat,ruangan,ruanganaktifitas', 'safe'),
                        array('new_password, new_password_repeat', 'required', 'on'=>'insert'),
//                        array('new_password, new_password_repeat,ruangan,modul', 'required', 'on'=>'insert'),
                        array('old_password,new_password, new_password_repeat', 'required', 'on'=>'changePassword'),
                        array('tglpembuatanlogin','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'insert'),
                        array('tglupdatelogin','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'update,changePassword'),
                     array('tglupdatelogin','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'update,changePassword2'),
                        array('loginpemakai_create','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('loginpemakai_update','default','value'=>Yii::app()->user->id,'on'=>'update'),
                        array('tglupdatelogin','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'update,changePassword'),
                     array('tglupdatelogin','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'update,changePassword2'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('loginpemakai_id, nama_pemakai, katakunci_pemakai, lastlogin, tglpembuatanlogin, tglupdatelogin, statuslogin, loginpemakai_aktif,pegawai_id,pasien_id', 'safe', 'on'=>'search'),
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
			'ruanganpegawai'=>array(self::BELONGS_TO,'RuanganpegawaiM','pegawai_id'),
			'pegawai'=>array(self::BELONGS_TO,'PegawaiM','pegawai_id'),
			'pasien'=>array(self::BELONGS_TO,'PasienM','pasien_id'),                        
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'loginpemakai_id' => 'Id',
			'pegawai_id' => 'Pegawai',
			'pasien_id' => 'Pasien',
			'nama_pemakai' => 'Username',
			'katakunci_pemakai' => 'kata kunci',
			'lastlogin' => 'Terakhir Login',
			'tglpembuatanlogin' => 'Tanggal Pembuatan Login',
			'tglupdatelogin' => 'Tanggal Update Login',
			'statuslogin' => 'Status Login',
			'loginpemakai_aktif' => 'Aktif',
                        'new_password' => 'Kata Kunci Baru',
			'new_password_repeat' => 'Ulangi Kata Kunci',
                        'old_password' => 'Kata Kunci Lama',
                        'ruangan'=>'Ruangan',
                        'modul'=>'Modul',
                        'loginpemakai_create'=>'Dibuat oleh Pemakai',
                        'loginpemakai_update'=>'Diubah oleh Pemakai',
                        'ruanganaktifitas'=>'Ruangan Aktifitas',
                        'jenispemakai'=>'Jenis Pemakai',
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

		$criteria->compare('loginpemakai_id',$this->loginpemakai_id);
                $criteria->compare('pegawai_id',$this->pegawai_id);
                $criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(nama_pemakai)',strtolower($this->nama_pemakai),true);
		$criteria->compare('LOWER(katakunci_pemakai)',strtolower($this->katakunci_pemakai),true);
//		$criteria->compare('LOWER(lastlogin)',strtolower($this->lastlogin),true);
//		$criteria->compare('LOWER(tglpembuatanlogin)',strtolower($this->tglpembuatanlogin),true);
//		$criteria->compare('LOWER(tglupdatelogin)',strtolower($this->tglupdatelogin),true);
		$criteria->compare('statuslogin',$this->statuslogin);
		$criteria->compare('loginpemakai_aktif',isset($this->loginpemakai_aktif)?$this->loginpemakai_aktif:true);
		$criteria->compare('loginpemakai_create',$this->loginpemakai_create);
		$criteria->compare('loginpemakai_update',$this->loginpemakai_update);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchByMonitoring()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('loginpemakai_id',$this->loginpemakai_id);
                $criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(nama_pemakai)',strtolower($this->nama_pemakai),true);
                if(isset($this->statuslogin))
                {
                    $this->statuslogin = strtolower($this->statuslogin);
                    $criteria->compare('statuslogin', ($this->statuslogin == 'login' ? true : false));
                }
                $criteria->addCondition("loginpemakai_aktif = TRUE AND statuslogin IS NOT NULL");
                $criteria->order ='statuslogin DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}        
        
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('loginpemakai_id',$this->loginpemakai_id);
                $criteria->compare('pegawai_id',$this->pegawai_id);
                $criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(nama_pemakai)',strtolower($this->nama_pemakai),true);
		$criteria->compare('LOWER(katakunci_pemakai)',strtolower($this->katakunci_pemakai),true);
		$criteria->compare('LOWER(lastlogin)',strtolower($this->lastlogin),true);
		$criteria->compare('LOWER(tglpembuatanlogin)',strtolower($this->tglpembuatanlogin),true);
		$criteria->compare('LOWER(tglupdatelogin)',strtolower($this->tglupdatelogin),true);
//		$criteria->compare('statuslogin',$this->statuslogin);
//		$criteria->compare('loginpemakai_aktif',$this->loginpemakai_aktif);
		$criteria->compare('loginpemakai_create',$this->loginpemakai_create);
		$criteria->compare('loginpemakai_create',$this->loginpemakai_create);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                         'pagination'=>false,
		));
	}
        
        protected function afterValidate() {
            parent::afterValidate();
            if(($this->getScenario() == 'insert'))
            {
                $this->katakunci_pemakai = $this->encrypt($this->katakunci_pemakai);

            }
        }

        public function encrypt($value) {
            return md5($value);
        }

        public function cekPassword()
        {
          if($this->katakunci_pemakai == $this->encrypt($this->old_password)){
               return true;
           }else{
                $this->addError('old_password', 'Password lama tidak sesuai');
                return false;
           }
        }
        
         public function cekPassword2()
        {
          if($this->katakunci_pemakai == $this->old_password){
               return true;
           }else{
               // $this->addError('old_password', 'Password lama tidak sesuai');
                return false;
           }
        }

        public function cekUsername()
        {
           if(($this->getScenario() == 'insert')){
               $cek = LoginpemakaiK::model()->findByAttributes(array('nama_pemakai'=>$this->nama_pemakai));
               if(($this->getScenario() == 'insert')){
                   if(count($cek) > 0 ){ //kondisi apabila di tabel user, username tersebut sudah dipakai
                       $this->addError('nama_pemakai', 'Username sudah digunakan, harap mengganti username Anda.');
                       return false;
                   }else{
                        return true;
                   }
               }
           }
           if(($this->getScenario() == 'update' || $this->getScenario() == 'changePassword')){
               $cek = LoginpemakaiK::model()->findByAttributes(array('nama_pemakai'=>$this->nama_pemakai));
               if (count($cek) > 0 )
               { //kondisi apabila di tabel user, username tersebut sudah dipakai
                   if($this->loginpemakai_id == $cek->loginpemakai_id)
                   {
                       return true;
                   }
                   else
                   {  
                       $this->addError('nama_pemakai', 'Username sudah digunakan, harap mengganti username Anda.');
                       return false;
                   }
               }
               else
               {
                    return true;
               }
           }
        }

//        protected function afterFind()
//        {
//            foreach($this->metadata->tableSchema->columns as $columnName => $column) {
//
//                if (!strlen($this->$columnName)) continue;
//
//                if ($column->dbType == 'date') {                         
//                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
//                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
//                        } elseif ($column->dbType == 'timestamp without time zone') {
//                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
//                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss','medium',null));
//                        }
//            }
//            return true;
//        }
        
        public static function pegawaiLoginPemakai(){
            return self::model()->findByPk(Yii::app()->user->id)->pegawai;
        }
         
        public function pegawaiLoginPemakaiById($id){
            $cek = $this->findByPk($id)->pegawai;
           
            if (empty($cek)):
                return true;
            else:
                return $cek->nama_pegawai;
            endif;
        }
        
        public function getRuangan(){
            if(isset($this->ruanganaktifitas))
            {
                return RuanganM::model()->findByPk($this->ruanganaktifitas)->ruangan_nama;
            }else{
                return "-";
            }
            
        }        
            
            
}