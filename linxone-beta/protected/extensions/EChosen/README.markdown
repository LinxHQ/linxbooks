EChosen
=======

**EChosen** is an extension for Yii framework. This extension is a wrapper for [Chosen JavaScript plugin](http://harvesthq.github.com/chosen/ "Chosen JavaScript plugin") which makes long, unwieldy select boxes much more user-friendly. It is currently available in both jQuery and Prototype flavors.

Requirements
------------

* Yii 1.1 or above (tested on 1.1.8)
* jQuery or Prototype

Installation
------------

Move **EChosen** folder in your applications extensions folder (default: `protected/extensions`).

Using extension
---------------

Just place the following code inside your view file:

```php
<?php $this->widget( 'ext.EChosen.EChosen' ); ?>
```

You can also change some default settings:

```php
<?php $this->widget( 'ext.EChosen.EChosen', array(
  'target' => 'select',
  'useJQuery' => false,
  'debug' => true,
)); ?>
```

* **target** jQuery selector for elements to apply this plugin to (default: `.chzn-select`)
* **useJQuery** use jQuery framework on true, Prototype on false (default: `true`)
* **debug** use un-minified .js of plugin (default: `false`)

You will also need to add `chzn-select` class to your select elements you want to apply this plugin or if you use jQuery framework you can just change the selector.

Resources
---------

* [Chosen JavaScript plugin (contains demo)](http://harvesthq.github.com/chosen/ "Chosen JavaScript plugin")

Notes
-----

* For your convenience extension contains Chosen JavaScript plugin. Hovewer to make sure you have the newest plugin you should download it from [Chosen JavaScript plugin Git repository](https://github.com/harvesthq/chosen/ "Chosen JavaScript plugin Git repository")