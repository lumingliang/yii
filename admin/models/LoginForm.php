<?php

namespace app\admin\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    public $id;
    // public $name;
    // private $role_id;
    public $password;
    public $email;
    public $verifyCode;
    public $rememberMe;
    // private $rememberToken;

    public $_user = false;

    /**
     * @return array the validation rules.
     */

    public function rules()
    {
        // 服务端验证
        return [
            // username and password are both required
            ['verifyCode', 'captcha'],
            [['email', 'password'], 'required'],
            ['email', 'email'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }


    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        // 如果前面验证都成功,继续验证账号账号密码
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            // 先验证用户名再验证密码
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, '用户名或者密码错误.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            //echo '验证成功！';
            // 向login方法传递一个登录的实例
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
            //Yii::$app->login($this->getUser());
            // 创建一个cookie value
            // if($this->rememberMe) {

                // $key = Yii::$app->getSecurity()->generateRandomString();
                // $this->getUser()->rememberToken = $key;
                // $this->getUser()->save();
                // Yii::$app->response->cookies->add(new \yii\web\Cookie([
                    // 'name' => 'remember_token',
                    // // value自动加密
                    // 'value' => $key,
                // ]));
            // }

            return true;
        }
        return false;
    }



    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }
}
