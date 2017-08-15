<?php

/**
 * HighchartsWidget class file.
 *
 * @author Milo Schuman <miloschuman@gmail.com>
 * @link https://github.com/miloschuman/yii-highcharts/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @version 4.0.4
 */

/**
 * HighchartsWidget encapsulates the {@link http://www.highcharts.com/ Highcharts}
 * charting library's Chart object.
 *
 * To use this widget, you may insert the following code in a view:
 * <pre>
 * $this->Widget('ext.highcharts.HighchartsWidget', array(
 *    'options'=>array(
 *       'title' => array('text' => 'Fruit Consumption'),
 *       'xAxis' => array(
 *          'categories' => array('Apples', 'Bananas', 'Oranges')
 *       ),
 *       'yAxis' => array(
 *          'title' => array('text' => 'Fruit eaten')
 *       ),
 *       'series' => array(
 *          array('name' => 'Jane', 'data' => array(1, 0, 4)),
 *          array('name' => 'John', 'data' => array(5, 7, 3))
 *       )
 *    )
 * ));
 * </pre>
 *
 * By configuring the {@link $options} property, you may specify the options
 * that need to be passed to the Highcharts JavaScript object. Please refer to
 * the demo gallery and documentation on the {@link http://www.highcharts.com/
 * Highcharts website} for possible options.
 *
 * Alternatively, you can use a valid JSON string in place of an associative
 * array to specify options:
 *
 * <pre>
 * $this->Widget('ext.highcharts.HighchartsWidget', array(
 *    'options'=>'{
 *       "title": { "text": "Fruit Consumption" },
 *       "xAxis": {
 *          "categories": ["Apples", "Bananas", "Oranges"]
 *       },
 *       "yAxis": {
 *          "title": { "text": "Fruit eaten" }
 *       },
 *       "series": [
 *          { "name": "Jane", "data": [1, 0, 4] },
 *          { "name": "John", "data": [5, 7,3] }
 *       ]
 *    }'
 * ));
 * </pre>
 *
 * Note: You must provide a valid JSON string (e.g. double quotes) when using
 * the second option. You can quickly validate your JSON string online using
 * {@link http://jsonlint.com/ JSONLint}.
 *
 * Note: You do not need to specify the <code>chart->renderTo</code> option as
 * is shown in many of the examples on the Highcharts website. This value is
 * automatically populated with the id of the widget's container element. If you
 * wish to use a different container, feel free to specify a custom value.
 */
class HighchartsWidget extends CWidget
{
    protected $_constr = 'Chart';
    protected $_baseScript = 'highcharts';
    public $options = array();
    public $htmlOptions = array();
    public $setupOptions = array();
    public $scripts = array();
    public $callback = false;

    /**
     * Renders the widget.
     */
    public function run()
    {
        if (isset($this->htmlOptions['id'])) {
            $this->id = $this->htmlOptions['id'];
        } else {
            $this->htmlOptions['id'] = $this->getId();
        }

        echo CHtml::openTag('div', $this->htmlOptions);
        echo CHtml::closeTag('div');

        // check if options parameter is a json string
        if (is_string($this->options)) {
            if (!$this->options = CJSON::decode($this->options)) {
                throw new CException('The options parameter is not valid JSON.');
            }
        }

        // merge options with default values
        $defaultOptions = array('chart' => array('renderTo' => $this->id));
        $this->options = CMap::mergeArray($defaultOptions, $this->options);
        array_unshift($this->scripts, $this->_baseScript);

        $this->registerAssets();
    }

    /**
     * Publishes and registers the necessary script files.
     */
    protected function registerAssets()
    {
        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);

        $cs = Yii::app()->clientScript;
        $cs->registerCoreScript('jquery');

        // register additional scripts
        $extension = YII_DEBUG ? '.src.js' : '.js';
        foreach ($this->scripts as $script) {
            $cs->registerScriptFile("{$baseUrl}/{$script}{$extension}");
        }

        // highcharts and highstock can't live on the same page
        if ($this->_baseScript === 'highstock') {
            $cs->scriptMap["highcharts{$extension}"] = "{$baseUrl}/highstock{$extension}";
        }

        // prepare and register JavaScript code block
        $jsOptions = CJavaScript::encode($this->options);
        $setupOptions = CJavaScript::encode($this->setupOptions);
        $js = "Highcharts.setOptions($setupOptions); var chart = new Highcharts.{$this->_constr}($jsOptions);";
        $key = __CLASS__ . '#' . $this->id;
        if (is_string($this->callback)) {
            $callbackScript = "function {$this->callback}(data) {{$js}}";
            $cs->registerScript($key, $callbackScript, CClientScript::POS_END);
        } else {
            $cs->registerScript($key, $js, CClientScript::POS_LOAD);
        }
    }
}
