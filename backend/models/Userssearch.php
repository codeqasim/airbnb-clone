<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Users;

/**
 * Userssearch represents the model behind the search form about `backend\models\Users`.
 */
class Userssearch extends Users
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'verify_pass', 'verify_passcode', 'country', 'created_at', 'modified_at', 'last_login', 'facebookid', 'activation', 'phoneno', 'emergencyno', 'shippingid', 'loginnotify', 'mobileverify', 'emailverify', 'reservationrequirement'], 'integer'],
            [['firstname', 'lastname', 'username', 'email', 'password', 'birthday', 'userstatus', 'hoststatus', 'profile_image', 'address1', 'address2', 'city', 'state', 'login_type', 'googleid', 'referrer_id', 'credit_total', 'gender', 'user_level', 'about', 'school', 'work', 'timezone', 'language', 'emergencyname', 'emergencyemail', 'emergencyrelation', 'workemail', 'pushnotification', 'notifications', 'emailsettings', 'socialconnections', 'findability', 'verifyno', 'verifycode'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchblockusers($params)
    {
        $query = Users::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andWhere(['<>','user_level','god']);
        $query->andFilterWhere([
            'id' => $this->id,
            'verify_pass' => $this->verify_pass,
            'verify_passcode' => $this->verify_passcode,
            'country' => $this->country,
            'created_at' => $this->created_at,
            'modified_at' => $this->modified_at,
            'last_login' => $this->last_login,
            'facebookid' => $this->facebookid,
            'activation' => $this->activation,
            'phoneno' => $this->phoneno,
            'emergencyno' => $this->emergencyno,
            'shippingid' => $this->shippingid,
            'loginnotify' => $this->loginnotify,
            'mobileverify' => $this->mobileverify,
            'emailverify' => $this->emailverify,
            'reservationrequirement' => $this->reservationrequirement,
            'userstatus' => '1',
        ]);
        

        $query->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'birthday', $this->birthday])
            ->andFilterWhere(['like', 'userstatus', $this->userstatus])
            ->andFilterWhere(['like', 'hoststatus', $this->hoststatus])
            ->andFilterWhere(['like', 'profile_image', $this->profile_image])
            ->andFilterWhere(['like', 'address1', $this->address1])
            ->andFilterWhere(['like', 'address2', $this->address2])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'login_type', $this->login_type])
            ->andFilterWhere(['like', 'googleid', $this->googleid])
            ->andFilterWhere(['like', 'referrer_id', $this->referrer_id])
            ->andFilterWhere(['like', 'credit_total', $this->credit_total])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'user_level', $this->user_level])
            ->andFilterWhere(['like', 'about', $this->about])
            ->andFilterWhere(['like', 'school', $this->school])
            ->andFilterWhere(['like', 'work', $this->work])
            ->andFilterWhere(['like', 'timezone', $this->timezone])
            ->andFilterWhere(['like', 'language', $this->language])
            ->andFilterWhere(['like', 'emergencyname', $this->emergencyname])
            ->andFilterWhere(['like', 'emergencyemail', $this->emergencyemail])
            ->andFilterWhere(['like', 'emergencyrelation', $this->emergencyrelation])
            ->andFilterWhere(['like', 'workemail', $this->workemail])
            ->andFilterWhere(['like', 'pushnotification', $this->pushnotification])
            ->andFilterWhere(['like', 'notifications', $this->notifications])
            ->andFilterWhere(['like', 'emailsettings', $this->emailsettings])
            ->andFilterWhere(['like', 'socialconnections', $this->socialconnections])
            ->andFilterWhere(['like', 'findability', $this->findability])
            ->andFilterWhere(['like', 'verifyno', $this->verifyno])
            ->andFilterWhere(['like', 'verifycode', $this->verifycode]);

        return $dataProvider;
    }
    
    public function searchunblockusers($params)
    {
        $query = Users::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andWhere(['<>','user_level','god']);
        $query->andFilterWhere([
            'id' => $this->id,
            'verify_pass' => $this->verify_pass,
            'verify_passcode' => $this->verify_passcode,
            'country' => $this->country,
            'created_at' => $this->created_at,
            'modified_at' => $this->modified_at,
            'last_login' => $this->last_login,
            'facebookid' => $this->facebookid,
            'activation' => $this->activation,
            'phoneno' => $this->phoneno,
            'emergencyno' => $this->emergencyno,
            'shippingid' => $this->shippingid,
            'loginnotify' => $this->loginnotify,
            'mobileverify' => $this->mobileverify,
            'emailverify' => $this->emailverify,
            'reservationrequirement' => $this->reservationrequirement,
            'userstatus' => '0',
        ]);
        

        $query->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'birthday', $this->birthday])
            ->andFilterWhere(['like', 'userstatus', $this->userstatus])
            ->andFilterWhere(['like', 'hoststatus', $this->hoststatus])
            ->andFilterWhere(['like', 'profile_image', $this->profile_image])
            ->andFilterWhere(['like', 'address1', $this->address1])
            ->andFilterWhere(['like', 'address2', $this->address2])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'login_type', $this->login_type])
            ->andFilterWhere(['like', 'googleid', $this->googleid])
            ->andFilterWhere(['like', 'referrer_id', $this->referrer_id])
            ->andFilterWhere(['like', 'credit_total', $this->credit_total])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'user_level', $this->user_level])
            ->andFilterWhere(['like', 'about', $this->about])
            ->andFilterWhere(['like', 'school', $this->school])
            ->andFilterWhere(['like', 'work', $this->work])
            ->andFilterWhere(['like', 'timezone', $this->timezone])
            ->andFilterWhere(['like', 'language', $this->language])
            ->andFilterWhere(['like', 'emergencyname', $this->emergencyname])
            ->andFilterWhere(['like', 'emergencyemail', $this->emergencyemail])
            ->andFilterWhere(['like', 'emergencyrelation', $this->emergencyrelation])
            ->andFilterWhere(['like', 'workemail', $this->workemail])
            ->andFilterWhere(['like', 'pushnotification', $this->pushnotification])
            ->andFilterWhere(['like', 'notifications', $this->notifications])
            ->andFilterWhere(['like', 'emailsettings', $this->emailsettings])
            ->andFilterWhere(['like', 'socialconnections', $this->socialconnections])
            ->andFilterWhere(['like', 'findability', $this->findability])
            ->andFilterWhere(['like', 'verifyno', $this->verifyno])
            ->andFilterWhere(['like', 'verifycode', $this->verifycode]);

        return $dataProvider;
    }
    
    public function searchactivehosts($params)
    {
        $query = Users::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andWhere(['<>','user_level','god']);
        $query->andFilterWhere([
            'id' => $this->id,
            'verify_pass' => $this->verify_pass,
            'verify_passcode' => $this->verify_passcode,
            'country' => $this->country,
            'created_at' => $this->created_at,
            'modified_at' => $this->modified_at,
            'last_login' => $this->last_login,
            'facebookid' => $this->facebookid,
            'activation' => $this->activation,
            'phoneno' => $this->phoneno,
            'emergencyno' => $this->emergencyno,
            'shippingid' => $this->shippingid,
            'loginnotify' => $this->loginnotify,
            'mobileverify' => $this->mobileverify,
            'emailverify' => $this->emailverify,
            'reservationrequirement' => $this->reservationrequirement,
            'hoststatus' => '1',
        ]);
        

        $query->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'birthday', $this->birthday])
            ->andFilterWhere(['like', 'userstatus', $this->userstatus])
            ->andFilterWhere(['like', 'hoststatus', $this->hoststatus])
            ->andFilterWhere(['like', 'profile_image', $this->profile_image])
            ->andFilterWhere(['like', 'address1', $this->address1])
            ->andFilterWhere(['like', 'address2', $this->address2])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'login_type', $this->login_type])
            ->andFilterWhere(['like', 'googleid', $this->googleid])
            ->andFilterWhere(['like', 'referrer_id', $this->referrer_id])
            ->andFilterWhere(['like', 'credit_total', $this->credit_total])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'user_level', $this->user_level])
            ->andFilterWhere(['like', 'about', $this->about])
            ->andFilterWhere(['like', 'school', $this->school])
            ->andFilterWhere(['like', 'work', $this->work])
            ->andFilterWhere(['like', 'timezone', $this->timezone])
            ->andFilterWhere(['like', 'language', $this->language])
            ->andFilterWhere(['like', 'emergencyname', $this->emergencyname])
            ->andFilterWhere(['like', 'emergencyemail', $this->emergencyemail])
            ->andFilterWhere(['like', 'emergencyrelation', $this->emergencyrelation])
            ->andFilterWhere(['like', 'workemail', $this->workemail])
            ->andFilterWhere(['like', 'pushnotification', $this->pushnotification])
            ->andFilterWhere(['like', 'notifications', $this->notifications])
            ->andFilterWhere(['like', 'emailsettings', $this->emailsettings])
            ->andFilterWhere(['like', 'socialconnections', $this->socialconnections])
            ->andFilterWhere(['like', 'findability', $this->findability])
            ->andFilterWhere(['like', 'verifyno', $this->verifyno])
            ->andFilterWhere(['like', 'verifycode', $this->verifycode]);

        return $dataProvider;
    }
    
    public function searchinactivehosts($params)
    {
        $query = Users::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andWhere(['<>','user_level','god']);
        $query->andFilterWhere([
            'id' => $this->id,
            'verify_pass' => $this->verify_pass,
            'verify_passcode' => $this->verify_passcode,
            'country' => $this->country,
            'created_at' => $this->created_at,
            'modified_at' => $this->modified_at,
            'last_login' => $this->last_login,
            'facebookid' => $this->facebookid,
            'activation' => $this->activation,
            'phoneno' => $this->phoneno,
            'emergencyno' => $this->emergencyno,
            'shippingid' => $this->shippingid,
            'loginnotify' => $this->loginnotify,
            'mobileverify' => $this->mobileverify,
            'emailverify' => $this->emailverify,
            'reservationrequirement' => $this->reservationrequirement,
            'hoststatus' => '0',
        ]);
        

        $query->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'birthday', $this->birthday])
            ->andFilterWhere(['like', 'userstatus', $this->userstatus])
            ->andFilterWhere(['like', 'hoststatus', $this->hoststatus])
            ->andFilterWhere(['like', 'profile_image', $this->profile_image])
            ->andFilterWhere(['like', 'address1', $this->address1])
            ->andFilterWhere(['like', 'address2', $this->address2])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'login_type', $this->login_type])
            ->andFilterWhere(['like', 'googleid', $this->googleid])
            ->andFilterWhere(['like', 'referrer_id', $this->referrer_id])
            ->andFilterWhere(['like', 'credit_total', $this->credit_total])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'user_level', $this->user_level])
            ->andFilterWhere(['like', 'about', $this->about])
            ->andFilterWhere(['like', 'school', $this->school])
            ->andFilterWhere(['like', 'work', $this->work])
            ->andFilterWhere(['like', 'timezone', $this->timezone])
            ->andFilterWhere(['like', 'language', $this->language])
            ->andFilterWhere(['like', 'emergencyname', $this->emergencyname])
            ->andFilterWhere(['like', 'emergencyemail', $this->emergencyemail])
            ->andFilterWhere(['like', 'emergencyrelation', $this->emergencyrelation])
            ->andFilterWhere(['like', 'workemail', $this->workemail])
            ->andFilterWhere(['like', 'pushnotification', $this->pushnotification])
            ->andFilterWhere(['like', 'notifications', $this->notifications])
            ->andFilterWhere(['like', 'emailsettings', $this->emailsettings])
            ->andFilterWhere(['like', 'socialconnections', $this->socialconnections])
            ->andFilterWhere(['like', 'findability', $this->findability])
            ->andFilterWhere(['like', 'verifyno', $this->verifyno])
            ->andFilterWhere(['like', 'verifycode', $this->verifycode]);

        return $dataProvider;
    }      
}
