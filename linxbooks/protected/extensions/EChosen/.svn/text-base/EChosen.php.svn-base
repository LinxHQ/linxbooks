<?php
/**
 * EChosen class file.
 * 
 * @author Andrius Marcinkevicius <andrew.web@ifdattic.com>
 * @copyright Copyright &copy; 2011 Andrius Marcinkevicius
 * @license Licensed under MIT license. http://ifdattic.com/MIT-license.txt
 * @version 1.5.1
 */

/**
 * EChosen makes select boxes much more user-friendly.
 * 
 * @author Andrius Marcinkevicius <andrew.web@ifdattic.com>
 */
class EChosen extends CWidget
{
  /**
   * @var string apply chosen plugin to these elements.
   */
  public $target = '.chzn-select';
  
  /**
   * @var boolean use jQuery plugin, otherwise use Prototype plugin.
   */
  public $useJQuery = true;
  
  /**
   * @var boolean include un-minified plugin then debuging.
   */
  public $debug = false;
  
  /**
   * @var array native Chosen plugin options.
   */
  public $options = array();
  
  /**
   * @var int script registration position.
   */
  public $scriptPosition = CClientScript::POS_END;
  
  /**
   * Apply Chosen plugin to select boxes.
   */
  public function run()
  {
    // Publish extension assets
    $assets = Yii::app()->getAssetManager()->publish( Yii::getPathOfAlias(
      'ext.EChosen' ) . '/assets' );
    
    // Register extension assets
    $cs = Yii::app()->getClientScript();
    $cs->registerCssFile( $assets . '/chosen.css' );
    
    // Get extension for JavaScript file
    $ext = '.min.js';
    if( $this->debug )
      $ext = '.js';
    
    // Use jQuery plugin version
    if( $this->useJQuery )
    {
      // Register jQuery scripts
      $options = CJavaScript::encode( $this->options );
      $cs->registerScriptFile( $assets . '/chosen.jquery' . $ext,
        $this->scriptPosition );
      $cs->registerScript( 'chosen',
        "$( '{$this->target}' ).chosen({$options});", CClientScript::POS_READY );
    }
    // Use Prototype plugin version
    else
    {
      // Register Prototype scripts
      $cs->registerScriptFile( $assets . '/chosen.proto' . $ext,
        $this->scriptPosition );
    }
  }
}
?>