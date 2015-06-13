# Yii Highmaps Widget Examples #

## Basic Example ##

This is a basic example using Highmaps' free, hosted map data. Add the following
code to any view file. Note the separate `registerScriptFile()` statement at the
very bottom.

```php
$this->widget('ext.highcharts.HighmapsWidget', array(
    'options' => array(
        'title' => array(
            'text' => 'Highmaps basic demo',
        ),
        'mapNavigation' => array(
            'enabled' => true,
            'buttonOptions' => array(
                'verticalAlign' => 'bottom',
            )
        ),
        'colorAxis' => array(
            'min' => 0,
        ),
        'series' => array(
            array(
                'data' => array(
                    array('hc-key' => 'de-ni', 'value' => 0),
                    array('hc-key' => 'de-hb', 'value' => 1),
                    array('hc-key' => 'de-sh', 'value' => 2),
                    array('hc-key' => 'de-be', 'value' => 3),
                    array('hc-key' => 'de-mv', 'value' => 4),
                    array('hc-key' => 'de-hh', 'value' => 5),
                    array('hc-key' => 'de-rp', 'value' => 6),
                    array('hc-key' => 'de-sl', 'value' => 7),
                    array('hc-key' => 'de-by', 'value' => 8),
                    array('hc-key' => 'de-th', 'value' => 9),
                    array('hc-key' => 'de-st', 'value' => 10),
                    array('hc-key' => 'de-sn', 'value' => 11),
                    array('hc-key' => 'de-br', 'value' => 12),
                    array('hc-key' => 'de-nw', 'value' => 13),
                    array('hc-key' => 'de-bw', 'value' => 14),
                    array('hc-key' => 'de-he', 'value' => 15),
                ),
                'mapData' => 'js:Highcharts.maps["countries/de/de-all"]',
                'joinBy' => 'hc-key',
                'name' => 'Random data',
                'states' => array(
                    'hover' => array(
                        'color' => '#BADA55',
                    )
                ),
                'dataLabels' => array(
                    'enabled' => true,
                    'format' => '{point.name}',
                )
            )
        )
    )
));

/*
 * To use Highcharts hosted map data, we must register those files separately.
 * Any map data files should come after the widget declaration to ensure the
 * main Highmaps script gets loaded first.
 */
Yii::app()->clientScript->registerScriptFile('//code.highcharts.com/mapdata/countries/de/de-all.js');

```
