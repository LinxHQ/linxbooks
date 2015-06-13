# Yii Highcharts Widget Examples #

## Combination Chart ##

This example is ported from the Highcharts ["Column, Line and Pie" demo](http://www.highcharts.com/demo/combo/grid-light)
with optional exporting module and Grid Light theme enabled.

```php
$this->widget('ext.highcharts.HighchartsWidget', array(
    'scripts' => array(
        'modules/exporting',
        'themes/grid-light',
    ),
    'options' => array(
        'title' => array(
            'text' => 'Combination chart',
        ),
        'xAxis' => array(
            'categories' => array('Apples', 'Oranges', 'Pears', 'Bananas', 'Plums'),
        ),
        'labels' => array(
            'items' => array(
                array(
                    'html' => 'Total fruit consumption',
                    'style' => array(
                        'left' => '50px',
                        'top' => '18px',
                        'color' => 'js:(Highcharts.theme && Highcharts.theme.textColor) || \'black\'',
                    ),
                ),
            ),
        ),
        'series' => array(
            array(
                'type' => 'column',
                'name' => 'Jane',
                'data' => array(3, 2, 1, 3, 4),
            ),
            array(
                'type' => 'column',
                'name' => 'John',
                'data' => array(2, 3, 5, 7, 6),
            ),
            array(
                'type' => 'column',
                'name' => 'Joe',
                'data' => array(4, 3, 3, 9, 0),
            ),
            array(
                'type' => 'spline',
                'name' => 'Average',
                'data' => array(3, 2.67, 3, 6.33, 3.33),
                'marker' => array(
                    'lineWidth' => 2,
                    'lineColor' => 'js:Highcharts.getOptions().colors[3]',
                    'fillColor' => 'white',
                ),
            ),
            array(
                'type' => 'pie',
                'name' => 'Total consumption',
                'data' => array(
                    array(
                        'name' => 'Jane',
                        'y' => 13,
                        'color' => 'js:Highcharts.getOptions().colors[0]', // Jane's color
                    ),
                    array(
                        'name' => 'John',
                        'y' => 23,
                        'color' => 'js:Highcharts.getOptions().colors[1]', // John's color
                    ),
                    array(
                        'name' => 'Joe',
                        'y' => 19,
                        'color' => 'js:Highcharts.getOptions().colors[2]', // Joe's color
                    ),
                ),
                'center' => array(100, 80),
                'size' => 100,
                'showInLegend' => false,
                'dataLabels' => array(
                    'enabled' => false,
                ),
            ),
        ),
    )
));
```
