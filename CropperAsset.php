<?php
namespace servsol\cropper;

use yii\web\AssetBundle;

class CropperAsset extends AssetBundle
{
    public $sourcePath = '@vendor/servsol/yii2-cropper/assets';

    public $depends = [
            'yii\web\YiiAsset',
            'yii\web\JqueryAsset'
    ];

    public function init()
    {
        $this->js[] = 'yii2-cropper.js';
    }
}