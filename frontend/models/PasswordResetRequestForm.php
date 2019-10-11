<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $firstname;
    public $lastname;
    public $email;
    public $password;
	public $id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required','on' => 'passwordrequest'],
            ['email', 'email'],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail($email)
    {
        /* @var $user User */
        $user = User::findByEmail($email);
        if ($user) {
            /*if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
                $user->generatePasswordResetToken();
            }*/
            if ($user->save()) {
				return \Yii::$app->mailer->compose ( 'welcome', [ 
						'name' => $user->firstname,
				] )->setFrom ( 'noreply@hitasoft.com' )->setTo ( $email )->setSubject ( 'Password reset mail' )->send ();
            }
        }

        return false;
    }

}
