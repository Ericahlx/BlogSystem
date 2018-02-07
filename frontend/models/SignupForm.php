<?php
//登陆表模型
namespace frontend\models;

use yii;
use yii\base\Model;
use common\models\UserModel;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    //添加两个字段用于实现再次输入密码和验证码功能
    public $rePassword;
    public $verifyCode;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            //修改为UserModel，判断用户唯一性，已经注册过的用户不允许再次注册
            ['username', 'unique', 'targetClass' => '\common\models\UserModel', 'message' => yii::t('common','This username has already been taken.')],
            //限制用户名长度
            ['username', 'string', 'min' => 3, 'max' => 16],
            //正则匹配规则
            ['username', 'match','pattern'=>'/^[(\x{4E00}-\x{9FA5})a-zA-Z]+[(\x{4E00}-\x{9FA5})a-zA-Z_\d]*$/u','message'=>'用户名由字母，汉字，数字，下划线组成，且不能以数字和下划线开头。'],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            //修改为UserModel，判断用户邮箱唯一性，已经注册过的用户邮箱不允许再次注册
            ['email', 'unique', 'targetClass' => '\common\models\UserModel', 'message' => yii::t('common','This email address has already been taken.')],

           /* ['password', 'required'],
            ['password', 'string', 'min' => 6],*/
            //将密码和验证写在一起，二者验证规则很像
            [['password', 'rePassword'],'required'],
            [['password', 'rePassword'], 'string', 'min' => 6],
            //添加重复密码规则
            ['rePassword','compare','compareAttribute'=>'password','message' => yii::t('common','Warning:You\'ve input different password this time!')],
            ['verifyCode','captcha'],
        ];
    }
    //程序员所写修改语言的函数
    public function attributeLabels()
    {
        return[
            //1、直接修改方法
            'username' => '用户名',
            //2、调用语言包方法
            'email' => yii::t('common','Email'),
            'password' => yii::t('common','Password'),
            //新增字段实现重复密码功能
            'rePassword' => '重复密码',
            'verifyCode' => '验证码',


        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new UserModel();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
}
