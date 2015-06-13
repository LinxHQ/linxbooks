# Yii Highstock Widget Examples #

## Area Spline with AJAX Data ##

This example is ported from the Highstock ["Area Spline" demo](http://www.highcharts.com/stock/demo/areaspline).
The `'callback'` option allows you to initialize the chart after an AJAX call or
other preprocessing.

```php
<script type="text/javascript">
$(function(){
	$.getJSON('//www.highcharts.com/samples/data/jsonp.php?filename=aapl-c.json&callback=?', myCallbackFunction);
});
</script>

<?php
$this->widget('ext.highcharts.HighstockWidget', array(
    // The highcharts initialization statement will be wrapped in a function
    // named 'mycallbackFunction' with one parameter: data.
	'callback' => 'myCallbackFunction',
    'options' => array(
        'rangeSelector' => array(
            'inputEnabled' => 'js:$("#container").width() > 480',
            'selected' => 1
        ),
        'title' => array(
            'text' => 'AAPL Stock Price'
        ),
        'series' => array(
            array(
                'name' => 'AAPL Stock Price',
                'data' => 'js:data', // Here we use the callback parameter, data
                'type' => 'areaspline',
                'threshold' => null,
                'tooltip' => array(
                    'valueDecimals' => 2
                ),
                'fillColor' => array(
                    'linearGradient' => array(
                        'x1' => 0,
                        'y1' => 0,
                        'x2' => 0,
                        'y2' => 1
                    ),
                    'stops' => array(
                        array(0, 'js:Highcharts.getOptions().colors[0]'),
                        array(1, 'js:Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get("rgba")')
                    )
                )
            )
        )
    )
));
```
