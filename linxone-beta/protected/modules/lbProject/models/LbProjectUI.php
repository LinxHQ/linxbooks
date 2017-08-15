<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LbProjectUI {        
        public static function getOverdueBadge($text = 'Overdue')
        {
            return '<span class="badge badge-warning">'.$text.'</span>';
        }
        
        public static function getInProgressBadge($text = 'In-progress')
        {
            return '<span class="badge">'.$text.'</span>';
        }
        
        public static function getDoneBadge($text = 'Done')
        {
            return '<span class="badge badge-info">'.$text.'</span>';
        }
        
        public static function getPriorityLabelHigh($text)
        {
            return '<span class="badge badge-important">'.$text. '</span>';
        }
        
        public static function getPriorityLabelNormal($text)
        {
            return '<span class="badge badge-info">'.$text. '</span>';
        }
        
        public static function getPriorityLabelLow($text)
        {
            return '<span class="badge">'.$text. '</span>';
        }
        
        public static function getOverdueColor()
        {
            return '#f89406';
        }
        
        /**
         * 
         * @param array $url
         * @param string $caption
         * @param string $set default null
         * @return type
         */
        public static function imagePreviewLink($url, $caption, $set = "")
        {
            return CHtml::link("<i class='icon-search'></i>", 
                            $url,
                            array(
                                'data-lightbox'=>'linxcircle_doc_preview_' . $set,
                                'data-title'=>$caption));
        }
        
        public static function showLoadingImage()
        {
            return CHtml::image(Yii::app()->baseUrl.'/images/loading.gif', 'Loading...', array('style'=>'border: none;'));
        }
}