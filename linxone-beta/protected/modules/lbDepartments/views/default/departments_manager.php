<div id="lb-container-header">
            <div class="lb-header-right" style="margin-left:-11px;"><h3>Departments</h3></div>
            <div class="lb-header-left">
                <a href="<?php echo Yii::app()->baseUrl ?>/index.php/lbDepartments/default/create" class="btn"><i class="icon-plus"></i> New</a>
                <!-- <a href="list?tab=list"><i class="icon-th-list icon-white"></i></i></a>&nbsp;
                <a href="<?php echo Yii::app()->baseUrl ?>/1/configuration?tab7" onclick=""><i class="icon-wrench icon-white"></i></i></a> -->
            </div>
</div><br>

<div id="jquery-script-menu">
<div class="jquery-script-center">
<div class="jquery-script-clear"></div>
</div>
</div>

<table id="tree-table" class="table table-hover table-bordered" >
    <tbody>
    <th>Departments</th>
    <th>Date</th>
    <th>Employees</th>
    <th></th>
    <tr data-id="1" data-parent="0" data-level="1">
      <td  data-column="name">Kydon Singapore</td>
      <td >20/09/2015</td>
      <td >10</td>
      <td >
      	<a href="<?php echo $this->createUrl('/lbDepartments/default/view'); ?>"><i class="icon-eye-open"></i></a>
      	<a href="<?php echo $this->createUrl('/lbDepartments/default/update'); ?>"><i class="icon-pencil"></i></a>
      	<i style="cursor: pointer;" onclick="delete_departments();" class="icon-trash"></i>
      </td>
    </tr>
    <tr data-id="2" data-parent="1" data-level="2">
      <td  data-column="name"><span class="treegrid-expander icon-chevron-right"></span>Administrative Office</td>
      <td >20/09/2015</td>
      <td >11</td>
      <td >
      	<a href="<?php echo $this->createUrl('/lbDepartments/default/view'); ?>"><i class="icon-eye-open"></i></a>
      	<a href="<?php echo $this->createUrl('/lbDepartments/default/update'); ?>"><i class="icon-pencil"></i></a>
      	<i style="cursor: pointer;" onclick="delete_departments();" class="icon-trash"></i>
      </td>
    </tr>

    <tr data-id="2" data-parent="1" data-level="2">
      <td  data-column="name"><span class="treegrid-expander icon-chevron-right"></span>Research & Development</td>
      <td >20/09/2015</td>
      <td >50 </td>
      <td >
        <a href="<?php echo $this->createUrl('/lbDepartments/default/view'); ?>"><i class="icon-eye-open"></i></a>
        <a href="<?php echo $this->createUrl('/lbDepartments/default/update'); ?>"><i class="icon-pencil"></i></a>
        <i style="cursor: pointer;" onclick="delete_departments();" class="icon-trash"></i>
      </td>
    </tr>

    <tr data-id="2" data-parent="1" data-level="2">
      <td  data-column="name"><span class="treegrid-expander icon-chevron-right"></span>Customer Support</td>
      <td >20/09/2015</td>
      <td >12 </td>
      <td >
        <a href="<?php echo $this->createUrl('/lbDepartments/default/view'); ?>"><i class="icon-eye-open"></i></a>
        <a href="<?php echo $this->createUrl('/lbDepartments/default/update'); ?>"><i class="icon-pencil"></i></a>
        <i style="cursor: pointer;" onclick="delete_departments();" class="icon-trash"></i>
      </td>
    </tr>

    <tr data-id="2" data-parent="1" data-level="2">
      <td  data-column="name"><span class="treegrid-expander icon-chevron-right"></span>Marketing</td>
      <td >20/09/2015</td>
      <td >25 </td>
      <td >
        <a href="<?php echo $this->createUrl('/lbDepartments/default/view'); ?>"><i class="icon-eye-open"></i></a>
        <a href="<?php echo $this->createUrl('/lbDepartments/default/update'); ?>"><i class="icon-pencil"></i></a>
        <i style="cursor: pointer;" onclick="delete_departments();" class="icon-trash"></i>
      </td>
    </tr>

    <tr data-id="3" data-parent="1" data-level="2">
      <td  data-column="name">Kydon Vietnam</td>
      <td >20/10/2015</td>
      <td >12</td>
      <td >
      	<a href="<?php echo $this->createUrl('/lbDepartments/default/view'); ?>"><i class="icon-eye-open"></i></a>
      	<a href="<?php echo $this->createUrl('/lbDepartments/default/update'); ?>"><i class="icon-pencil"></i></a>
      	<i style="cursor: pointer;" onclick="delete_departments();" class="icon-trash"></i>
      </td>
    </tr>
    <tr data-id="4" data-parent="3" data-level="3">
      <td  data-column="name"><span class="treegrid-expander icon-chevron-right"></span>HR Department</td>
      <td >20/11/2015</td>
      <td >13</td>
      <td >
      	<a href="<?php echo $this->createUrl('/lbDepartments/default/view'); ?>"><i class="icon-eye-open"></i></a>
      	<a href="<?php echo $this->createUrl('/lbDepartments/default/update'); ?>"><i class="icon-pencil"></i></a>
      	<i style="cursor: pointer;" onclick="delete_departments();" class="icon-trash"></i>
      </td>
    </tr>
  
    <tr data-id="4" data-parent="3" data-level="3">
      <td  data-column="name"><span class="treegrid-expander icon-chevron-right"></span>Engineering</td>
      <td >20/11/2015</td>
      <td >10</td>
      <td >
        <a href="<?php echo $this->createUrl('/lbDepartments/default/view'); ?>"><i class="icon-eye-open"></i></a>
        <a href="<?php echo $this->createUrl('/lbDepartments/default/update'); ?>"><i class="icon-pencil"></i></a>
        <i style="cursor: pointer;" onclick="delete_departments();" class="icon-trash"></i>
      </td>
    </tr>

    <tr data-id="4" data-parent="3" data-level="3">
      <td  data-column="name"><span class="treegrid-expander icon-chevron-right"></span>Marketing</td>
      <td >20/11/2015</td>
      <td >10</td>
      <td >
        <a href="<?php echo $this->createUrl('/lbDepartments/default/view'); ?>"><i class="icon-eye-open"></i></a>
        <a href="<?php echo $this->createUrl('/lbDepartments/default/update'); ?>"><i class="icon-pencil"></i></a>
        <i style="cursor: pointer;" onclick="delete_departments();" class="icon-trash"></i>
      </td>
    </tr>
      </tbody>
    
  </table>
<script type="text/javascript">
  function load_more_employees(id){
  	$(".load_more_employees_"+id+"").toggle(500);
  	
  }
  function delete_departments(){
  	if (confirm('Are you sure to delete Department ?')) {
  		alert("Deleted Successfully");
  	}
  }
</script>