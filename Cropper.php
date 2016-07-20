<?php
namespace servsol\cropper;


use yii\widgets\InputWidget;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Cropper renders a jquery Cropper plugin for image crop.
 */
class Cropper extends InputWidget
{
    /**
     * @var boolean crop ratio
     * Set the aspect ratio of the crop box. 
     * By default, the crop box is free ratio.
     */
    public $aspectRatio;
    
    public $clientOptions = [];
    
    /**
     * @var string url where uploaded files are stored
     * if empty and has model, will be got from CropImageBehavior
     */
    public $uploadUrl;
    
    public $uploadCroppedUrl;
    
    public $changeUrl;
    
    public $name;
    
    public $model;
    
    public $attribute;
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        $jsOptions = [
            'clientOptions' => $this->clientOptions,
        ];

        $this->options['id'] = 'input-id';
        if ($this->hasModel()) {
            echo Html::activeInput('file', $this->model, $this->attribute, $this->options);
            echo Html::img('#', ['id' => 'cropper-box']);
            echo Html::button('Crop', ['id' => 'cropImage']);
            
            $input_name = Html::getInputName($this->model, $this->attribute);
            $input_id = Html::getInputId($this->model, $this->attribute);
            
            echo Html::hiddenInput($input_name . '[file]', '', ['id' => $input_id . '_image']); 
            
            $jsOptions['model'] = $this->model;
            $jsOptions['attribute'] = $this->attribute;
            
        }  else {
			echo Html::fileInput($this->name, $this->value, $this->options);
			echo Html::img('#', ['id' => 'cropper-box']);
			echo Html::button('Crop', ['id' => 'cropImage']);
		}

		if ($this->uploadUrl)
		    $this->uploadUrl = \Yii::getAlias($this->uploadUrl);

	    $jsOptions['uploadUrl'] = $this->uploadUrl;
	    $jsOptions['uploadCroppedUrl'] = $this->uploadCroppedUrl;
	    $jsOptions['changeUrl'] = $this->changeUrl;
	    $jsOptions['name'] = $this->name;
	    $jsOptions['aspectRatio'] = $this->aspectRatio;

	    $this->registerPlugin($jsOptions);
    }
    
    /**
     * Registers jqueryCrop
     */
    protected function registerPlugin($options)
    {
        $view = $this->getView();
        CropperAsset::register($view);
        
        $id = $this->options['id'];
        $view->registerJs("jQuery('#{$id}').cropImage(".json_encode($options).");");
    }
    
}

