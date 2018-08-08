<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */

namespace appbiz\local\local_models\mysqldb;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model.
 *
 * @property int $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string $password write-only password
 */
/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 10;
    const STATUS_ACTIVE = 1;

    public static function tableName()
    {
        return '{{%biz_user}}';
    }

    public function rules()
    {
        return [
            ['password', 'filter', 'filter' => 'trim'],
            ['password', 'string', 'length' => [6, 20]],

            ['password', 'filter', 'filter' => 'trim'],
            ['password', 'string', 'length' => 11],
            ['phone', 'required'],

        ];
    }

    /**
     * @property $id | Int , 用户id
     * 通过id 找到identity（状态有效）
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id);
    }


    /**
     * Finds user by password reset token.
     *
     * @param  string      $token password reset token
     * @return static|null
     */
    // 此处是忘记密码所使用的
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
        ]);
    }

    /**
     * Finds out if password reset token is valid.
     *
     * @param  string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        //$expire = Yii::$app->params['user.passwordResetTokenExpire'];
        // get from config, 86400
        //$expire = Yii::$service->email->customer->getPasswordResetTokenExpire();
        $expire = 86400;

        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * Validates password.
     *
     * @param  string $password password to validate
     * @return bool   if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model.
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }


    /**
     * Generates new password reset token.
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token.
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
