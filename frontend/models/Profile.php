<?php

namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * This is the model class for table "hts_users".
 *
 * @property integer $id
 * @property string $firstname
 * @property string $lastname
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $birthday
 * @property string $userstatus
 * @property string $hoststatus
 * @property integer $verify_pass
 * @property integer $verify_passcode
 * @property string $profile_image
 * @property string $address1
 * @property string $address2
 * @property string $city
 * @property string $state
 * @property integer $country
 * @property integer $created_at
 * @property integer $modified_at
 * @property integer $last_login
 * @property string $login_type
 * @property string $facebookid
 * @property string $googleid
 * @property string $referrer_id
 * @property string $credit_total
 * @property string $gender
 * @property integer $activation
 * @property string $user_level
 * @property string $phoneno
 * @property string $about
 * @property string $school
 * @property string $work
 * @property string $timezone
 * @property string $language
 * @property string $emergencyno
 * @property string $emergencyname
 * @property string $emergencyemail
 * @property string $emergencyrelation
 * @property integer $shippingid
 * @property string $workemail
 * @property string $pushnotification
 * @property string $notifications
 * @property string $emailsettings
 * @property string $socialconnections
 * @property string $findability
 * @property integer $loginnotify
 * @property integer $mobileverify
 * @property string $verifyno
 * @property integer $emailverify
 * @property string $verifycode
 * @property integer $reservationrequirement
 *
 * @property Listing[] $listings
 * @property Lists[] $lists
 * @property Messages[] $messages
 * @property Paymentmethods[] $paymentmethods
 * @property Payoutmethods[] $payoutmethods
 * @property Reservations[] $reservations
 * @property Reviews[] $reviews
 * @property Shippingaddress[] $shippingaddresses
 * @property Userinvitecredits[] $userinvitecredits
 * @property Userinvites[] $userinvites
 * @property Country $country0
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['verify_pass', 'verify_passcode', 'country', 'created_at', 'modified_at', 'last_login', 'facebookid', 'activation', 'phoneno', 'emergencyno', 'shippingid', 'loginnotify', 'mobileverify', 'emailverify', 'reservationrequirement'], 'integer'],
            [['verify_passcode'], 'required'],
            [['notifications', 'emailsettings'], 'string'],
            [['firstname','lastname','phoneno','state'],'required'],
            [['firstname', 'lastname', 'city', 'state'], 'string', 'min' => 3],
            [['firstname', 'lastname', 'city', 'state'], 'string', 'max' => 40],
            [['username'], 'string', 'max' => 15],
            [['email', 'emergencyemail', 'workemail'], 'string', 'max' => 150],
            [['password', 'profile_image', 'googleid', 'verifycode'], 'string', 'max' => 50],
            [['birthday', 'login_type', 'gender', 'user_level', 'verifyno'], 'string', 'max' => 10],
            [['userstatus', 'hoststatus'], 'string', 'max' => 1],
            [['address1', 'address2', 'emergencyname', 'emergencyrelation'], 'string', 'max' => 60],
            [['referrer_id', 'school', 'work', 'timezone', 'language'], 'string', 'max' => 100],
            [['credit_total'], 'string', 'max' => 45],
            [['about'], 'string', 'max' => 180],
            [['day','month','year'],'required'],
            [['pushnotification', 'socialconnections', 'findability'], 'string', 'max' => 3]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'birthday' => 'Birthday',
            'userstatus' => 'Userstatus',
            'hoststatus' => 'Hoststatus',
            'verify_pass' => 'Verify Pass',
            'verify_passcode' => 'Verify Passcode',
            'profile_image' => 'Profile Image',
            'address1' => 'Address1',
            'address2' => 'Address2',
            'city' => 'City',
            'state' => 'State',
            'country' => 'Country',
            'created_at' => 'Created At',
            'modified_at' => 'Modified At',
            'last_login' => 'Last Login',
            'login_type' => 'Login Type',
            'facebookid' => 'Facebookid',
            'googleid' => 'Googleid',
            'referrer_id' => 'Referrer ID',
            'credit_total' => 'Credit Total',
            'gender' => 'Gender',
            'activation' => 'Activation',
            'user_level' => 'User Level',
            'phoneno' => 'Phoneno',
            'about' => 'About',
            'school' => 'School',
            'work' => 'Work',
            'timezone' => 'Timezone',
            'language' => 'Language',
            /*'emergencyno' => 'Emergencyno',
            'emergencyname' => 'Emergencyname',
            'emergencyemail' => 'Emergencyemail',
            'emergencyrelation' => 'Emergencyrelation',*/
            'shippingid' => 'Shippingid',
            'workemail' => 'Workemail',
            'pushnotification' => 'Pushnotification',
            'notifications' => 'Notifications',
            'emailsettings' => 'Emailsettings',
            'socialconnections' => 'Socialconnections',
            'findability' => 'Findability',
            'loginnotify' => 'Loginnotify',
            'mobileverify' => 'Mobileverify',
            'verifyno' => 'Verifyno',
            'emailverify' => 'Emailverify',
            'verifycode' => 'Verifycode',
            'reservationrequirement' => 'Reservationrequirement',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListings()
    {
        return $this->hasMany(Listing::className(), ['userid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLists()
    {
        return $this->hasMany(Lists::className(), ['userid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Messages::className(), ['senderid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentmethods()
    {
        return $this->hasMany(Paymentmethods::className(), ['userid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayoutmethods()
    {
        return $this->hasMany(Payoutmethods::className(), ['userid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReservations()
    {
        return $this->hasMany(Reservations::className(), ['userid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::className(), ['userid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShippingaddresses()
    {
        return $this->hasMany(Shippingaddress::className(), ['userid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserinvitecredits()
    {
        return $this->hasMany(Userinvitecredits::className(), ['userid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserinvites()
    {
        return $this->hasMany(Userinvites::className(), ['userid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry0()
    {
        return $this->hasOne(Country::className(), ['id' => 'country']);
    }
    
    public static function findIdentity($id)
    {
         $user = User::find()->where(['id' => $id])->one();
		 return $user;
    }	    
}
