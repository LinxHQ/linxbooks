Copyright: Shahram Monshi Pouri
Based on Christian Kütbach's FCKEditorWidget

GNU LESSER GENERAL PUBLIC LICENSE

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU lesser General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU lesser General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

Requirements:
The CK-Editor have to be installed and configured. The Editor itself is
not includet to this extension.

This extension have to be installed into:
<Yii-Application>/proected/extensions/ckeditor

Usage:
<?php $this->widget('ext.ckeditor.CKEditorWidget',array(
  "model"=>$pages,                 # Data-Model
  "attribute"=>'content',          # Attribute in the Data-Model
  "defaultValue"=>"Test Text",     # Optional

  # Additional Parameter (Check http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html)
  "config" => array(
      "height"=>"400px",
      "width"=>"100%",
      "toolbar"=>"Basic",
      ),

  #Optional address settings if you did not copy ckeditor on application root
  "ckEditor"=>Yii::app()->basePath."/../ckeditor/ckeditor.php",
                                  # Path to ckeditor.php
  "ckBasePath"=>Yii::app()->baseUrl."/ckeditor/",
                                  # Realtive Path to the Editor (from Web-Root)
  ) ); ?>
