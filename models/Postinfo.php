<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "postinfo".
 *
 * @property integer $id
 * @property string $pacname
 * @property string $version
 * @property string $version_in
 * @property string $title
 * @property string $zip_source
 * @property string $zip_name
 * @property string $themepic
 * @property string $theme_url
 * @property integer $status
 */
class Postinfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'postinfo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['version_in'], 'safe'],
            [['status'], 'integer'],
            [['pacname', 'title', 'theme_url'], 'string', 'max' => 100],
            [['version'], 'string', 'max' => 30],
            [['zip_source_file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'zip'],
            [[ 'zip_name','zip_source','themepic'], 'string', 'max' => 200],
            [['themepic_file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pacname' => 'Pacname',
            'version' => 'Version',
            'version_in' => 'Version In',
            'title' => 'Title',
            'zip_source' => 'Zip Source',
            'zip_name' => 'Zip Name',
            'themepic' => 'Themepic',
            'theme_url' => 'Theme Url',
            'status' => 'Status',
            'themepic_file' => "themepic_file",
            'zip_source_file' => 'zip_source_file'
        ];
    }

    public function upload()
    {
        var_dump($this->zip_source_file);
        var_dump($this->themepic_file);
        var_dump($this);

        foreach ($this->zip_source_file as $file) {
            echo $file->baseName;
            echo $file->extension;
            $file->saveAs('C:/wamp2016_new/www/yii2/upload/' . $file->baseName . '.' . $file->extension);

            $this->zip_source = 'C:/wamp2016_new/www/yii2/upload/' . $file->baseName . '.' . $file->extension;
            var_dump($this->zip_source);
            $this->zip_source_file = null;
        }


        foreach ($this->themepic_file as $file) {
            echo $file->baseName;
            echo $file->extension;
            $file->saveAs('C:/wamp2016_new/www/yii2/upload/' . $file->baseName . '.' . $file->extension);

            $this->themepic = 'C:/wamp2016_new/www/yii2/upload/' . $file->baseName . '.' . $file->extension;
            var_dump($this->themepic);
            $this->themepic_file = null;
        }

        return true;
/*        if ($this->validate()) {
            var_dump($this->zip_source);
            var_dump($this->themepic);
            echo "validate sucess";

            return true;
        } else {

            var_dump($this->zip_source);
            var_dump($this->themepic);
            echo "validate fail";
            return true;
        }*/
    }
}
