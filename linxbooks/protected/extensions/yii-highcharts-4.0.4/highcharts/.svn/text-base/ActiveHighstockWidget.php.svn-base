<?php

/**
 * ActiveHighstockWidget class file.
 *
 * @author David Baker <github@acorncomputersolutions.com>
 * @link https://github.com/miloschuman/yii-highcharts/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @version 4.0.4
 */

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'HighstockWidget.php');

/**
 * Usage:
 *
 * $this->widget('highcharts.ActiveHighstockWidget', array(
 * 'options' => array(
 * 'title' => array('text' => 'Site Percentile'),
 * 'yAxis' => array(
 * 'title' => array('text' => 'Site Rank')
 * ),
 * 'series' => array(
 * array(
 * 'name'  => 'Site percentile',
 * 'data'  => 'SiteRank12',        // data column in the dataprovider
 * 'time'  => 'RankDate',          // time column in the dataprovider
 * // 'timeType'  => 'date',
 * // defaults to a mysql timestamp, other options are 'date' (run through strtotime()) or 'plain'
 * ),
 * array(
 * 'name'  => 'Site percentile',
 * 'time'  => 'RankDate',          // time column in the dataprovider
 * 'type'  => 'arearange',
 * 'data'  => array(
 * 'Column1',      // specify an array of data options
 * 'Column2',      // if you are using an area range charts
 * ),
 * ),
 * ),
 * ),
 * 'dataProvider' => $dataProvider,
 * ));
 *
 * @see HighchartsWidget for additional options
 */
class ActiveHighstockWidget extends HighstockWidget
{
    /**
     * Pass in a data provider that we will turn into the series
     *
     * @var CDataProvider
     */
    public $dataProvider;

    public function run()
    {
        $data = $this->dataProvider->getData();
        $series = $this->options['series'];

        if (count($data) > 0) {
            foreach ($series as $i => $batch) {
                if (isset($batch['time']) && isset($batch['data']) &&
                    !is_array($batch['time'])
                ) {
                    $dateSeries = array();
                    foreach ($data as $row) {
                        $dateSeries[] = $this->processRow($row, $batch);
                    }

                    // we'll work on the actual item, this may be PHP 5.3+ specific
                    $this->sortDateSeries($dateSeries);

                    // clean up our time item so we don't accidentally conflict with Highstock
                    unset($this->options['series'][$i]['time']);

                    // and then reset our data column with our data series
                    $this->options['series'][$i]['data'] = $dateSeries;
                }
            }
        }

        parent::run();
    }

    /**
     * Handles processing a row and readying it for Highstock
     *
     * @param $row
     * @param $batch
     * @throws Exception
     * @return array
     */
    protected function processRow($row, $batch)
    {
        // if we're dealing with a javascript timestamp
        // then just setup our array
        $timeType = (isset($batch['timeType'])) ? $batch['timeType'] : 'mysql';

        switch ($timeType) {
            case 'plain':
                $time = $this->processPlainTimestamp($row, $batch);
                break;
            case 'date':
                $time = $this->processDateString($row, $batch);
                break;
            case 'mysql':
                $time = $this->processMysqlTimestamp($row, $batch);
                break;
            default:
                $functionName = 'process' . ucfirst($timeType);
                if (method_exists($this, $functionName)) {
                    return call_user_func(array($this, $functionName), $row, $batch);
                } else {
                    throw new Exception("Can't call your custom date processing function");
                }
        }

        // process our data by running it through our data processing method
        $data = $this->processData($row, $batch);

        // push our data value on the front of what may be multiple data values
        array_unshift($data, $time);

        return $data;
    }

    /**
     * Cleans up the data column so Highstock is happy
     *
     * @param $row
     * @param $batch
     * @return array
     */
    protected function processData($row, $batch)
    {
        if(!is_array($batch['data'])) {
            return array($this->processDataValue($row[$batch['data']]));
        }

        $items = array();
        foreach($batch['data'] as $item) {
            $items[] = $this->processDataValue($row[$item]);
        }
        return $items;
    }

    /**
     * Using this means your time needs to be in JS milliseconds
     *
     * @param $row
     * @param $batch
     * @return array
     */
    protected function processPlainTimestamp($row, $batch)
    {
        return floatval($row[$batch['time']]);
    }

    /**
     * Converts dates using strtotime() to a MySQL timestamp and then changes to JS milliseconds
     *
     * @param $row
     * @param $batch
     * @return array
     */
    protected function processDateString($row, $batch)
    {
        return 1000 * floatval(strtotime($row[$batch['time']]));
    }

    /**
     * Converts a SQL unix timestamp to a JS timestamp (in milliseconds)
     * This is our default time processor if not specified
     *
     * @param $row
     * @param $batch
     * @return array
     */
    protected function processMysqlTimestamp($row, $batch)
    {
        return 1000 * floatval($row[$batch['time']]);
    }

    /**
     * Sorts our date series so we have all the dates from first to last
     *
     * @param $series
     */
    protected function sortDateSeries(&$series)
    {
        $dates = array();

        //sort by first column (dates ascending order)
        foreach ($series as $key => $row) {
            $dates[$key] = $row[0];
        }
        array_multisort($dates, SORT_ASC, $series);
    }

    /**
     * Highstocks won't graph a value if we have a null for it.
     * We want to make sure we don't cast nulls to 0 using floatval,
     * so we check here to make sure the value should be converted to
     * a float before we do anything.
     *
     * @param $value
     * @return float|null
     */
    protected function processDataValue($value)
    {
        return ($value === null) ? null : floatval($value);
    }
}