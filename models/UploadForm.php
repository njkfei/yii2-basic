<?php
/**
 * Created by PhpStorm.
 * User: njp
 * Date: 2016/4/14
 * Time: 14:55
 */

namespace app\models;
use yii\base\Model;
use yii\web\UploadedFile;
use Aws;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
          //  $this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            $this->imageFile->saveAs('c:/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);

            $config = array(
                'region' => 'ap-northeast-1',
                'credentials' => [
                    'key' => 'AKIAIXGXRS6IHTVI23QQ',
                    'secret' => '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',
                ],
                'version' => 'latest',
                // 'debug'   => true
            );

            $sdk = new Aws\Sdk($config);

            $client = $sdk->createS3();

            try {
                $result = $client->putObject(array(
                    'Bucket' => 'theme.kkk',
                    'Key' =>  $this->imageFile->baseName . '.' . $this->imageFile->extension,
                    'SourceFile' =>'c:/' . $this->imageFile->baseName . '.' . $this->imageFile->extension,
                    'ContentType' => 'text/plain',
                    //      'ACL' => 'public-read',
                ));
            } catch (S3Exception $e) {
                echo $e->getMessage() . "\n";
            }
            return true;
        } else {
            return false;
        }
    }
}