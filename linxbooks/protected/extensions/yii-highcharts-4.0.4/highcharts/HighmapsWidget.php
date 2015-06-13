<?php

/**
 * HighmapsWidget class file.
 *
 * @author Milo Schuman <miloschuman@gmail.com>
 * @link https://github.com/miloschuman/yii-highcharts/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @version 4.0.4
 */
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'HighchartsWidget.php');

/**
 * @see HighchartsWidget
 *
 * In the likely event that you would like to use
 */
class HighmapsWidget extends HighchartsWidget
{

    protected $_constr = 'Map';
    protected $_baseScript = 'highcharts';

    /**
     * Highmaps must be run as a module if highstock or highcharts scripts are
     * on the same page. Since we can't know ahead of time whether one of the
     * other scripts will be included later, we just assume so and always run
     * highmaps as a module.
     */
    public function run()
    {
        array_unshift($this->scripts, 'modules/map');
        parent::run();
    }
}

