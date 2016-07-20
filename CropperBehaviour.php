<?php
namespace servsol\cropper;

use mongosoft\file\UploadBehavior;

class CropperBehavior extends UploadBehavior
{
    /**
     * @var array the scenarios in which the behavior will be triggered
     */
    public $scenarios = ['default'];
    
    private $crops_internal;
    
}