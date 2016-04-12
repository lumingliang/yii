<?php

namespace app\models;
use Yii;

class User extends \yii\base\Object implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;

    // 果然，因为这里是static变量
    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];

    /**
     * @inheritdoc
     */
    // 与session登录相关
    public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * @inheritdoc
     */
    // 手机端验证,self应该是对自身静态使用
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    // 返回用户id,这个比较有用
    public function getId()
    {
        return $this->id;
    }
    public function getAuthKey()
    {
        // 因为有了
        $this->authKey = $this->generateAuthKey();
        return $this->generateAuthKey();
    }

    /**
     * @inheritdoc
     */
    // 实现cookie验证逻辑
    public function validateAuthKey($authKey)
    {
        echo 'test validateAuthKey';
        return $this->getAuthKey() === $authKey;
    }

    public function generateAuthKey() {
        $authKey = Yii::$app->getSecurity()->generatePasswordHash($this->id.'lumin');
        return $authKey;
    }

    /**
     * @inheritdoc
     */
    // 和cookie 相关，会返回一个cookie储存的key
    // public function getAuthKey()
    // {
    // // authKey每次可以从这里获得，包括第一次rememberme和 之后的验证时
        // return $this->authKey;
    // }

    /**
     * @inheritdoc
     */
    // // 实现cookie验证逻辑
    // public function validateAuthKey($authKey)
    // {
        // return $this->authKey === $authKey;
    // }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    // 验证密码
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
