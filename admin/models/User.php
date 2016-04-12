<?php

namespace app\admin\models;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use Yii;
use app\models\Role;

class User extends ActiveRecord implements IdentityInterface
{
    // private $id;
    // public $name;
    // private $role_id;
    // public $password;
    // public $email;
    // private $rememberToken;
    private $authKey;
    //private $username = '';
    // 手机端token
    //public $accessToken;

    // 果然，因为这里是static变量
    // private static $users = [
        // '100' => [
            // 'id' => '100',
            // 'username' => 'admin',
            // 'password' => 'admin',
            // 'authKey' => 'test100key',
            // 'accessToken' => '100-token',
        // ],
        // '101' => [
            // 'id' => '101',
            // 'username' => 'demo',
            // 'password' => 'demo',
            // 'authKey' => 'test101key',
            // 'accessToken' => '101-token',
        // ],
    // ];

    public static function tableName() {

        return 'users_table';
    }

    /**
     * @inheritdoc
     */
    // 与session登录相关,得到一个相应认证实例
    public static function findIdentity($id)
    {
        // 这里就是给cookie登录时使用，因为cookie中包含了一个id信息
        return static::findOne($id);
        //return static::findOne(['access_token' => $token]); //另外用法
    }

    /**
     * @inheritdoc
     */
    // 手机端验证,self应该是对自身静态使用
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // foreach (self::$users as $user) {
            // if ($user['accessToken'] === $token) {
                // return new static($user);
            // }
        // }
        // return static::findOne(['access_token' => $token]); //真正使用时会查询这个token并验证
        // return null;
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($name)
    {
        echo 'find by userName';
        $this->findByEmail();
        // 用来在登录时利用唯一用户名找到整个实例 
        // foreach (self::$users as $user) {
            // if (strcasecmp($user['username'], $username) === 0) {
                // return new static($user);
            // }
        // }

        // return null;
    }

    public static function findByEmail($email) {

        // 得到一个模型，供全局使用
        return static::findOne(['email' => $email]);
    }

    /**
     * @inheritdoc
     */
    // 返回用户id,这个比较有用
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    // 和cookie 相关，会返回一个cookie储存的key,该方法对应接口
    public function getAuthKey()
    {
        // 因为有了
        $this->authKey = $this->generateAuthKey();
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    // 实现cookie验证逻辑
    public function validateAuthKey($authKey) //该authKey是从cookie中取出来的
    {
        // echo 'check authKey';
        // exit;
        return $this->getAuthKey() === $authKey;
    }

    public function generateAuthKey() {
        $authKey = Yii::$app->getSecurity()->generatePasswordHash($this->id.'lumin');
        return $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    // 验证密码
    public function validatePassword($password)
    {
        //return $this->password === $password;
        $flag = Yii::$app->getSecurity()->validatePassword($password, $this->password);
        return $flag;
    }

    public function getRole() {

        return $this->hasOne(Role::className(), ['id' =>  'role_id']);
    }
}
