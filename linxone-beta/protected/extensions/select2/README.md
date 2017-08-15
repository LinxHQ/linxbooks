# Select2 Extension for Yii

Extension to use jQuery Plugin Select2 in Yii application.

courtesy Select2 script: https://github.com/ivaynberg/select2


##Whats new 
Event binding support for select2 yii extension no need to write any line of javascript configure the whole dropdow via select2 extension


## Installation
Download or clone this repository and paste in `/protected/extensions/select2`


## Usage
Direct import into page 
```php
Yii::import('ext.select2.Select2');
```
Or in config to make it avaiable overall site
```php
    ...
    'import' => array(
        ...
        'ext.select2.Select2',
        ...
    ),
    ...
```

## Example:
 <br>
Simple call `Select2::dropDownList()`
Model reference  `Select2::activeDropDownList()`

##Advanced
```php
    ...
    echo Select2::multiSelect("test", '', array('Apple','Banana','Orange','Apricot','Black Current'), 
        array(
            'required' => 'required',
            'select2Options' => array(
              'placeholder' => 'Please select a fruit',
              'maximumSelectionSize' => 4,
            ),
        )
    );
    ...
    echo Select2::activeMultiSelect($model, "attr", array('test1','test2'), array(
        'placeholder' => 'This is a placeholder',
    ));
    ...
```
Or this

```php
    ...
    $this->widget('Select2', array(
       'name' => 'exampleInput',
       'value' => 1,
       'data' => array(
           1 => 'Apple',
           2 => 'Banana',
           3 => 'Orange',
           4 => 'Apricot',
        ),
    ));
    ...
```
##Initialize options with javascript function or expressions
Example populating text field with ajax support
```php
    ...
echo Select2::dropDownList('location', '', array(),
  array(
      'empty'=>'',
      'id'=>'location',
      'style'=>'width:100%',
      'select2Options'=>array(
          'allowClear'=>true,
          'placeholder'=>'Type Location Here',
           'minimumInputLength'=>'3',
          'ajax'=>array(
              'url'=>'/homes/locationsajax/',
              'type'=>'GET',
              'dataType'=>'jsonp',
              'data'=>new CJavaScriptExpression('function (term, page) {return {loc_name: term, page:page}}'),
              'results'=>new CJavaScriptExpression('function (data, page) {return {results:  data.locations}}'),

          ),
          'initSelection'=>new CJavaScriptExpression('function(element, callback) { '
                    . 'var id=jQuery(element).val(); '
                    . 'if (id!=="") {'
                    . ' jQuery.ajax("/homes/locationsajax/loc_id/"+id, { dataType: "jsonp" } ).done( function(data) {'
                    . 'callback(data);'
                    . '});'
                    . '}}'),
          'formatResult'=> new CJavaScriptExpression('locationFormatResult'),
          'formatSelection'=>new CJavaScriptExpression('locationFormatSelection'),
          'escapeMarkup'=>new CJavaScriptExpression('function (m) {return m;}'),
          )
  )
                            );
    ...
```
following  javascript is rendered by extension with the above piece of php code

```javascript
  ...
  $('#location').select2(
            {
            'allowClear':true,
            'placeholder':'Type Location Here',
            'minimumInputLength':'3',
            'ajax':{
                'url':'/homes/locationsajax/',
                'type':'GET',
                'dataType':'jsonp',
                'data':function (term, page) {return {loc_name: term, page:page}},
                'results':function (data, page) {return {results:  data.locations}}},
                'initSelection':function(element, callback) { 
                    var id=jQuery(element).val(); 
                    if (id!=="") { 
                      jQuery.ajax("/homes/locationsajax/loc_id/"+id, { dataType: "jsonp" } )
                      .done( function(data) {
                              callback(data)
                              }
                        );
                    }
                  },
                  'formatResult':locationFormatResult,
                  'formatSelection':locationFormatSelection,
                  'escapeMarkup':function (m) {return m;}
            }
  );
  ...

```

##Binding Events Examples with dropdown list
A dropdown example triggering the events "select2-selecting" and "select2-removed" 
which fire on selecting a choice and clearing a choice 
```php
  ...
    echo Select2::dropDownList('area_type', '', 
                array('sqft'=>'Square Feet','marla'=>'Marlas'),
                array('empty'=>'','id'=>'area_type','style'=>'width:100%',
                    'select2Options'=>array(
                        'allowClear'=>true,
                        'placeholder'=>'Unit Type',
                        'onTrigger'=>array(
                            'select2-selecting'=>new CJavaScriptExpression('function(e) { console.log(e.object.id);}'),
                            "select2-removed"=>new CJavaScriptExpression('function(e) { console.log(e.choice.text);}'),
                        )
                        ),

                    )
                );
  ...

```
The following javascript is rendered when you run the above piece of code
```javascript
  ...
   $('#area_type').select2(
      {
        'allowClear':true,
        'placeholder':'Unit Type'
      }
    )
    .on('select2-selecting',function(e) { console.log(e.object.id);})
    .on('select2-removed',function(e) { console.log(e.choice.text);});
  ...
```

