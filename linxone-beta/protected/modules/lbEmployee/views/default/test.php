<!DOCTYPE html>
<html>
<head>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<meta charset=utf-8 />
<title>JS Bin</title>
</head>
<body>
  <label>Date :</label>
    <input name="startDate" id="txtFDt" class="date-picker" />
</body>
</html>
<script> 
$(function () {
            $('#txtFDt').datepicker({
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                dateFormat: 'dd-mm-yy',
                onClose: function (dateText, inst) {

                    //Get the selected month value
                    var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();

                    //Get the selected year value
                    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();

                    //set month value to the textbox 
                    $(this).datepicker('setDate', new Date(year, month, 1));
                }
            });
            
        });
        </script>
        <style>
          .ui-datepicker-calendar, .ui-datepicker-year
        {
            display: none;
        }
        </style>
