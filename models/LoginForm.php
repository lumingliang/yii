<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    public $name;
    public $email;
    public $password;
    public $rememberMe = true;

    // 该变量储存一个指向表的模型 
    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        // 服务端验证
        return [
            // username and password are both required
          //  ['verifyCode', 'captcha'],
            [['email', 'password'], 'required'],
            ['password', 'password'],
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
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            //var_dump($user);

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
            echo '验证成功';
            exit;
            // 向login方法传递一个登录的实例
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
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
            // $this->_user = User::findByUsername($this->username);
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }
}
