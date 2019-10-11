<?php
namespace frontend\models;

use Yii;
use common\models\User;
use yii\base\Model;


/**
 * Signup form
 */
class SignupForm extends Model
{
	public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $password;
    public $month;
    public $rememberMe;
    private $_user;
    public $facebookid;
    public $googleid; 
	public $day;
    public $language;
	public $year;
	public $emailverify;
	public $gender;
	public $state;
	public $about;
	public $school;
	public $work;
	public $phoneno;
	public $emergencyno;
	public $emergencyname;
	public $emergencyemail;
	public $emergencyrelation;
	public $referrer_id;
	public $paypalid;
	public $notifications;
	public $emailsettings;
	public $userstatus;
    public $profile_image;
	
 
    public static function tableName()
    {
        return '{{%users}}';
    }
 
    public function rules()
    {
        return [
            ['firstname', 'filter', 'filter' => 'trim'],
            ['firstname', 'required','on' => 'register'],
            ['firstname', 'string', 'min' => 3, 'max' => 255],            
            
            ['lastname', 'filter', 'filter' => 'trim'],
            ['lastname', 'required','on' => 'register'],
            ['lastname', 'string', 'min' => 3, 'max' => 255],
            
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required','on' => 'register'],
            ['email', 'string', 'max' => 255],
            
            ['password', 'required','on' => 'register'],
			['month', 'required','on' => 'register'],
			['day', 'required','on' => 'register'],
			['year', 'required','on' => 'register'],
			['phoneno','number','max'=>20],
			['referrer_id','string'],
			['paypalid','string']
			
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->firstname = $this->firstname;
            $user->lastname = $this->lastname;
            $user->email = $this->email;
            $user->password = base64_encode($this->password);
			$user->birthday = $this->month."-".$this->day."-".$this->year;
			$user->userstatus = "1";
			$user->user_level = "normal";
			$user->hoststatus = "2";
            if(isset($this->facebookid))
            {
                $user->facebookid = $this->facebookid;
            } 
            if(isset($this->googleid))
            {
                $user->googleid = $this->googleid;  
            }
			if(isset($this->referrer_id))
			{
				$reff_id['reffid'] = $this->referrer_id;
				$reff_id['first'] = 'first';
				$user->referrer_id = json_encode($reff_id);
			}
            $user->pushnotification = "1";

            $notifications = array();
            $notifications['mobilenotify'] = "0";
            $notifications['messagenotify'] = "1";
            $notifications['reservationnotify'] = "1";
            $notifications['accountnotify'] = "0";
            $emails = array();
            $emails['generalemail'] = "0";
            $emails['reservationemail'] = "1";   

            $user->notifications = json_encode($notifications);
            $user->emailsettings = json_encode($emails);  
              
            //$user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }
    
	public function uniquevalue($attribute) {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->uniquevalue($this->email)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }else{
                $this->addError($attribute, 'Correct username or password.');
            }
        }
	}    
    
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }
    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
       if ($this->getUser()) {
			if(isset($_POST['SignupForm']['rememberMe']) && $_POST['SignupForm']['rememberMe'] == "on"){
				setcookie ("email", base64_encode($this->email), time()+3600*24*4); 
				//setcookie ("password", $this->password, time()+3600*24*4);
			}else{
				setcookie ("email", '');
				//setcookie ("password", ''); 
			}		
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }
    public static function findByEmail($email)
    {
         $user = User::find()->where(['email' => $email])->one();
		 return $user;
    }
	
    public static function findIdentity($id)
    {
         $user = User::find()->where(['id' => $id])->one();
		 return $user;
    }	
	
    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::find()->where([
            		'email' => $this->email,
            		'userstatus' => 1
            ])->One();
        }
        return $this->_user;
    }
	

}
