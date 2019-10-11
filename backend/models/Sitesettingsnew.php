<?php

namespace backend\models;

use Yii;

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
 * @property string $paymenttype
 * @property string $paypaladaptive
 * @property string $paypalid
 * @property string $stripeid
 * @property string $stripekey
 * @property string $loginkey
 * @property string $transactionkey
 * @property string $sitechanges
 * @property string $footercontent
 * @property string $footeractive
 * @property integer $commission_percentage
 * @property string $socialid
 * @property string $gender
 */
class Sitesettings extends \yii\db\ActiveRecord
{
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
            [['welcomeemail', 'signupactive', 'gmail_smtp', 'paypaladaptive', 'sitechanges', 'footercontent', 'footeractive', 'socialid'], 'string'],
            [['smtp_port', 'commission_percentage'], 'integer'],
            [['sitelogowhite', 'paymenttype', 'paypaladaptive'], 'required'],
            [['sitename', 'noreplyname', 'noreplypassword', 'medial_url', 'media_server_username', 'media_server_password', 'stripeid', 'stripekey', 'loginkey', 'transactionkey'], 'string', 'max' => 50],
            [['sitetitle', 'media_server_hostname'], 'string', 'max' => 100],
            [['metakey', 'metadesc'], 'string', 'max' => 200],
            [['supportemail', 'noreplyemail', 'paypalid'], 'string', 'max' => 150],
            [['sitelogoblack', 'sitelogowhite', 'defaultuserimage'], 'string', 'max' => 20],
            [['paymenttype', 'gender'], 'string', 'max' => 10]
        ];
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
            'stripeid' => 'Stripeid',
            'stripekey' => 'Stripekey',
            'loginkey' => 'Loginkey',
            'transactionkey' => 'Transactionkey',
            'sitechanges' => 'Sitechanges',
            'footercontent' => 'Footercontent',
            'footeractive' => 'Footeractive',
            'commission_percentage' => 'Commission Percentage',
            'socialid' => 'Socialid',
            'gender' => 'Gender',
        ];
    }
    public static function findIdentity()
    {
         $user = Sitesettings::find()->where(['id' => '1'])->one();
		 return $user;
    }       
}
