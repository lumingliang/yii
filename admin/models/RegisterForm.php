<?php

namespace app\admin\models;

use Yii;
use yii\base\Model;
use app\admin\models\User;

/**
 * LoginForm is the model behind the login form.
 */
class RegisterForm extends Model
{
    // 注意：这里的属性因为并没有和数据表相关，所以要自己定义，但是如user model所有属性会和数据表相关，因此不用显式定义数据表里面的属性
    private $id;
    public $name;
    private $role_id = 0;
    public $password;
    public $email;
    public $verifyCode;
    public $password2;
    // private $rememberToken;

    private $_user = false;

    /**
     * @return array the validation rules.
     */

    public function rules()
    {
        // 服务端验证
        return [
            // username and password are both required
            [['name', 'email', 'password'], 'required'],
            ['password2', 'compare', 'compareAttribute' => 'password'],
            ['verifyCode', 'captcha'],
            // rememberMe must be a boolean value
            // password is validated by validatePassword()
        ];
    }

    public function attributeLabels() {
        return [
            'name' => '请设置一个名字',
            'email' => '输入您的邮箱',
            'password' => '设置您的密码',
            'password2' => '重新输入一遍您的密码',
            'verifyCode' => '输入验证码',
        ];
    }

    public function createNewUser() {

        //echo 'love you';
        $User = new User();
        // $Role = new Role();
        // var_dump($this->attributes);
        // exit;
        // 可以使用
        // $User->attributes = $this->attributes;
        // echo $this->name;
        // 无法使用两个model 间赋值
        $transaction = User::getDb()->beginTransaction();
        $User->name = $this->name;
        // 密码加密
        $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
        $User->password = $this->password;
        $User->email = $this->email;
        $User->role_id = 0;
        //$transaction2 = Role::getDb()->beginTransaction();
        //var_dump($User->attributes);
        // exit;
        try {

            $User->save();
            $transaction->commit();
            return true;
        } catch(\Exception $e) {
            // echo $e; //log $e
            $transaction->rollBack();
            return false;
        }
        // if ( $User->save() ) {
            // echo '保存成功!';
            // return true;
        // } else {
            // return false;
        // }
    }


}
