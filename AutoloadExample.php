<?php

namespace servsol\cropper;

use yii\widgets\InputWidget;

/**
 * This is just an example.
 */
class AutoloadExample extends InputWidget
{
    /**
     * @var boolean crop ratio
     * Set the aspect ratio of the crop box. 
     * By default, the crop box is free ratio.
     */
    public $aspectRatio;
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        echo 'yes';

        
        if ($this->hasModel()) {
            echo 'yes again';
            
        }    
        
    
    }
    
    /**
     * Registers jqueryCrop
     */
    protected function registerPlugin($options)
    {
        $view = $this->getView();
        CropperAsset::register($view);
    
        $id = $this->options['id'];
    
        $view->registerJs("jQuery('#{$id}').cropper({
                                        	  aspectRatio: NaN,
                                        	  crop: function(e) {
                                        
                                        	  }
                                        	});");
    }
}
