<?php

/**
 * Wrapper Widget to use jQuery Select2 in Yii application.
 *
 * @author Muhammad Omer Aslam <buttflattery@hotmail.com>
 * @copyright Copyright &copy; 2014 omaraslam.com
 * @package extensions
 * @subpackage select2
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @version 3.4.3 rev.0
 *
 * @see https://github.com/ivaynberg/select2 jQuery Select2
 */
class Select2 extends CInputWidget
{

    /** @var string Path to assets directory published in init() */
    private $assetsDir;

    /** @var array Chosen script settings passed to $.fn.chosen() */
    private $settings = array();

    /** @var bool Multiple or single item should be selected */
    public $multiple = false;

    /** @var array See CHtml::listData() */
    public $data;
    public $onTrigger=array();

    /** Initiialize method to publish assets */
    public function init()
    {
        $dir = dirname(__FILE__) . '/assets';
        $this->assetsDir = Yii::app()->assetManager->publish($dir);

        if ($this->multiple) {
            $this->htmlOptions['multiple'] = true;
        } elseif (isset($this->htmlOptions['multiple'])) {
            $this->multiple = true;
        }
        
        if (isset($this->htmlOptions['placeholder'])) {
            $this->settings['placeholder'] = $this->htmlOptions['placeholder'];
        } elseif (isset($this->htmlOptions['data-placeholder'])) {
            $this->settings['placeholder'] = $this->htmlOptions['data-placeholder'];
        }

        if (isset($this->htmlOptions['select2Options'])) {
            if(array_key_exists("onTrigger",$this->htmlOptions['select2Options'])){
                    $this->onTrigger    =   CMap::mergeArray($this->onTrigger, $this->htmlOptions['select2Options']['onTrigger']);
                    unset($this->htmlOptions['select2Options']['onTrigger']);
            }
            $this->settings = CMap::mergeArray($this->settings, $this->htmlOptions['select2Options']);
            unset($this->htmlOptions['select2Options']);
        }
        
    }

    /**Update scripts and bind events */
    public function run()
    {
        list($name, $id) = $this->resolveNameID();
        
        if (isset($this->htmlOptions['id'])) {
            $id = $this->htmlOptions['id'];
        } else {
            $this->htmlOptions['id'] = $id;
        }

        if (isset($this->htmlOptions['name'])) {
            $name = $this->htmlOptions['name'];
        }
        
        if (isset($this->settings['ajax'])) {
            if (isset($this->model)) {
                echo CHtml::textField($name, $this->model->{$this->attribute}, $this->htmlOptions);
            } else {
                echo CHtml::textField($name, $this->value, $this->htmlOptions);
            }
        } else {
            if (isset($this->model)) {
                echo CHtml::dropDownList($name, $this->model->{$this->attribute}, $this->data, $this->htmlOptions);
            } else {
                echo CHtml::dropDownList($name, $this->value, $this->data, $this->htmlOptions);
            }
        }

        $this->registerScripts($id);
    }

    /** Register client scripts */
    private function registerScripts($id)
    {
        $cs = Yii::app()->getClientScript();
        //$cs->registerCoreScript('jquery');

        $src = !YII_DEBUG ? '' : '/src';
        $min = YII_DEBUG ? '' : '.min';

        $cs->registerCssFile($this->assetsDir . $src . '/select2' . $min . '.css');
        $cs->registerScriptFile($this->assetsDir . $src . '/select2' . $min . '.js');

        $lang = strtoupper(str_replace('_', '-', Yii::app()->language));
        $lang[0] = strtolower($lang[0]);
        $lang[1] = strtolower($lang[1]);

        $cs->registerScriptFile($this->assetsDir . $src . '/select2_locale_' . $lang . $min . '.js');
        
        $settings = CJavaScript::encode($this->settings);
        
        
        $onTriggers='';
        if(!empty($this->onTrigger)){
            foreach($this->onTrigger as $k=>$v){
                $onTriggers .='.on(\''.$k.'\','.CJavaScript::encode($v).')';
            }
        }
        
        $cs->registerScript("{$id}_select2", ""
                . "$('#{$id}').select2({$settings})".$onTriggers.";"
            );
            
    }

    
    public static function dropDownList($name, $select, $data, $htmlOptions = array())
    {
        return Yii::app()->getController()->widget(__CLASS__, array(
            'name' => $name,
            'value' => $select,
            'data' => $data,
            'htmlOptions' => $htmlOptions,
        ), true);
    }

    public static function activeDropDownList($model, $attribute, $data, $htmlOptions = array())
    {
        return self::dropDownList(CHtml::activeName($model, $attribute), CHtml::value($model, $attribute), $data, $htmlOptions);
    }

    /** Multiple elect */
    public static function multiSelect($name, $select, $data, $htmlOptions = array())
    {
        return Yii::app()->getController()->widget(__CLASS__, array(
            'name' => $name,
            'value' => $select,
            'data' => $data,
            'htmlOptions' => $htmlOptions,
            'multiple' => true,
        ), true);
    }

    public static function activeMultiSelect($model, $attribute, $data, $htmlOptions = array())
    {
        return self::multiSelect(CHtml::activeName($model, $attribute) . '[]', CHtml::value($model, $attribute), $data, $htmlOptions);
    }

}
