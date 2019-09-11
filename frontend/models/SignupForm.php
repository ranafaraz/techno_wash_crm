<?php
namespace frontend\models;

use yii\base\Model;
use yii\helpers\Url;
use common\models\User;


/**
 * Signup form
 */
class SignupForm extends Model
{
    public $first_name;
    public $last_name;
    public $username;
    public $email;
    public $password;
    public $user_photo;
    public $user_type;
    public $branch_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            [['username'], 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            [['user_photo'], 'string', 'max' => 200],

            ['email', 'trim'],
            //['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            [['user_type'],'safe'],
            [['first_name','last_name'],'string','max'=>20],
            [['last_name','first_name'],'safe'],
            [['user_type'] ,'string'],
            [['branch_id'],'integer'],
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
        
        $user = new User();
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->username = $this->username;
        $user->email = $this->email;
        $user->user_photo = $this->user_photo;
        $user->user_type = $this->user_type;
        $user->branch_id = $this->branch_id;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }

    public function getPhotoInfo(){


        $path = Url::to('@common/userphotos/');
        $url = Url::to('@common/userphotos/');
        
        $filename = $this->username.'_photo'.'.jpg';
        $alt = $this->username."'s image not exist!";

        $imageInfo = ['alt'=>$alt];

        if(file_exists($path.$filename)){
            $imageInfo['url'] = $url.'default.jpg';
        }  else {
            $imageInfo['url'] = $url.$filename; 
        }
        return $imageInfo;
    }

    public function getSessionBranch()
    {
        return $this->hasOne(Branches::className(), ['branch_id' => 'session_branch_id']);
    }

}
