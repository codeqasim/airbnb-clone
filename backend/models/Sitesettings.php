<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\base\Model;
use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * This is the model class for table "hts_sitesettings".
 *
 * @property integer $id
 * @property string $sitename
 * @property string $sitetitle
 * @property string $metakey
 * @property string $metadesc
 * @property string $welcomeemail
 * @property string $signupactive
 * @property string $supportemail
 * @property string $noreplyname
 * @property string $noreplyemail
 * @property string $noreplypassword
 * @property string $gmail_smtp
 * @property integer $smtp_port
 * @property string $medial_url
 * @property string $media_server_hostname
 * @property string $media_server_username
 * @property string $media_server_password
 * @property string $sitelogoblack
 * @property string $sitelogowhite
 * @property string $defaultuserimage
 * @property string $paypalid

 * @property string $stripe_publishkey
 * @property string $stripe_secretkey

 * @property string $stripeid
 * @property string $stripekey
 * @property string $loginkey
 * @property string $transactionkey
   * @property string $braintreepaymenttype 
    * @property string $braintreemerchantid 
    * @property string $braintreepublickey 
    * @property string $braintreeprivatekey   
 * @property string $sitechanges
 * @property string $footercontent
 * @property string $footeractive
 * @property integer $commission_percentage
 * @property string $socialid
  * @property string $pricerange
  * @property string $smssettings 
 */
class Sitesettings extends \yii\db\ActiveRecord
{
	public $socialstatus;
	public $facebookstatus;
	public $facebookappid;
	public $facebooksecret;
	public $googlestatus;
	public $googleappid;
	public $googlesecret;
	public $facebookLink;
	public $twitterLink;
	public $googleLink;
	public $linkedinLink;
	public $youtubeLink;
	public $pinterestLink;
	public $instagramLink;
	public $address;
    public $ioslink;
    public $ioslinkstatus;
    public $androidlink;
    public $androidlinkstatus; 
	public $phone;
	public $email;	
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_sitesettings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	['supportemail', 'filter', 'filter' => 'trim'],
            [['welcomeemail', 'signupactive', 'gmail_smtp', 'sitechanges', 'footercontent', 'footeractive', 'socialid','fcmKey'], 'string'],
			[['braintreepaymenttype', 'braintreemerchantid', 'braintreepublickey', 'braintreeprivatekey','pricerange'], 'string'],
            [['smtp_port', 'commission_percentage'], 'integer'],
            [['facebookstatus', 'facebookappid', 'facebooksecret'], 'facebookRequired', 'on'=>['sociallogin']],
				[['googlestatus', 'googleappid', 'googlesecret'], 'googleRequired', 'on'=>['sociallogin']],
            [['sitename', 'noreplyname', 'noreplypassword', 'medial_url', 'media_server_username', 'media_server_password', 'stripeid', 'stripekey', 'loginkey', 'transactionkey'], 'string', 'max' => 50],
            [['sitetitle', 'media_server_hostname'], 'string', 'max' => 100],
            [['metakey', 'metadesc'], 'string', 'max' => 200],
            [['supportemail', 'noreplyemail', 'stripe_publishkey', 'stripe_secretkey', 'paypalid'], 'string', 'max' => 150],
            [['sitelogoblack', 'sitelogowhite', 'defaultuserimage'], 'string', 'max' => 20],
			[['paymenttype','paypaladaptive','smssettings'],'string'],
            
        ];
    }

	/**
	 * Check the appid and secret key
	 * fields if the user enabled the
	 * appropriate social login
	 * This is the 'facebookRequired' validator as declared in rules().
	 */
	public function facebookRequired($attribute, $params)
	{
		if($this->facebookstatus == 1){
			if($this->facebookappid == ''){
				$this->addError('facebookappid', 'Facebook Appid cannot be empty');
			}/* else{
			$this->clearErrors('facebookappid');
			} */
			if($this->facebooksecret == ''){
				$this->addError('facebooksecret', 'Facebook Secret Key cannot be empty');
			}
		}
	}

	/**
	 * Check the appid and secret key
	 * fields if the user enabled the
	 * appropriate social login
	 * This is the 'googleRequired' validator as declared in rules().
	 */
	public function googleRequired($attribute)
	{
		if($this->googlestatus == 1){
			if($this->googleappid == ''){
				$this->addError('googleappid', Yii::t('admin','Google Appid cannot be empty'));
			}
			if($this->googlesecret == ''){
				$this->addError('googlesecret', Yii::t('admin','Google Secret Key cannot be empty'));
			}
		}
	}

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sitename' => 'Sitename',
            'sitetitle' => 'Sitetitle',
            'metakey' => 'Metakey',
            'metadesc' => 'Metadesc',
            'welcomeemail' => 'Welcomeemail',
            'signupactive' => 'Signupactive',
            'supportemail' => 'Supportemail',
            'noreplyname' => 'Noreplyname',
            'noreplyemail' => 'Noreplyemail',
            'noreplypassword' => 'Noreplypassword',
            'gmail_smtp' => 'Gmail Smtp',
            'smtp_port' => 'Smtp Port',
            'medial_url' => 'Medial Url',
            'media_server_hostname' => 'Media Server Hostname',
            'media_server_username' => 'Media Server Username',
            'media_server_password' => 'Media Server Password',
            'sitelogoblack' => 'Sitelogoblack',
            'sitelogowhite' => 'Sitelogowhite',
            'defaultuserimage' => 'Defaultuserimage',
            'paymenttype' => 'Paymenttype',
            'paypaladaptive' => 'Paypaladaptive',
            'paypalid' => 'Paypalid',
            'stripe_publishkey' => 'Stripe Publishable Key',
            'stripe_secretkey' => 'Stripe Secret Key',
            'stripeid' => 'Stripeid',
            'stripekey' => 'Stripekey',
            'loginkey' => 'Loginkey',
            'transactionkey' => 'Transactionkey',
            'braintreepaymenttype' => 'Braintreepaymenttype', 
            'braintreemerchantid' => 'Braintreemerchantid', 
            'braintreepublickey' => 'Braintreepublickey', 
            'braintreeprivatekey' => 'Braintreeprivatekey',			
            'sitechanges' => 'Sitechanges',
            'footercontent' => 'Footercontent',
            'footeractive' => 'Footeractive',
            'commission_percentage' => 'Commission Percentage',
            'socialid' => 'Socialid',
			//'facebookstatus' => 'Enable Facebook',
			'twitterstatus' => 'Enable Twitter',
			//'googlestatus' => 'Enable Google',
			'facebookappid' => 'Facebook App id',
			'facebooksecret' => 'Facebook Secret Key',
			'twitterappid' => 'Twitter App id',
			'twittersecret' => 'Twitter Secret Key',
			'googleappid' => 'Google App id',
			'googlesecret' =>'Googlie Secret Key',
			'socialstatus' => Yii::t('app','Enable Social'),
			'pricerange' => 'Pricerange',
            'fcmKey' => 'FCM Key',
            'smssettings' => 'Sms Settings',
        ];
    }
    
    public static function findIdentity()
    {
         $user = Sitesettings::find()->where(['id' => '1'])->one();
		 return $user;
    }    
}
