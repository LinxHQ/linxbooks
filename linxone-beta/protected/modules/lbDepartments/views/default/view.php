<style type="text/css">
    .pagination a{
        border: 1px solid #777;
        border-radius: 5px;
        margin: 5px;
        
    }

    .pagination a {
        color: black;
        float: left;
        padding: 8px 16px;
        text-decoration: none;
    }
    .pagination a.active {
        background-color: #4CAF50;
        color: white !important;
        border-radius: 5px;
    }

    .pagination a:hover:not(.active) {
        background-color: #ddd;
        border-radius: 5px;
    }
</style>
<div id="lb-container-header">
            <div class="lb-header-right" style="margin-left:-11px;"><h3>View Detail Department</h3></div>
            <div class="lb-header-left">
                <a href="<?php echo $this->createUrl('/lbDepartments/default/departmentsManager'); ?>" class="btn"><i class="icon-arrow-left"></i> Back</a>
            </div>
</div><br>
<h3>Department Infomation</h3>
<table class="table table-bordered table-striped table-hover" id="yw1">
    <tbody>
        <tr class="odd">
            <th>Department Company</th>
            <td>Kydon Singapore</td>
        </tr>
        <tr class="even">
            <th>Department Name</th>
            <td>Kydon Singapore</td>
        </tr>
        <tr class="odd">
            <th>Department No</th>
            <td>KD-0123456</td>
        </tr>
        <tr class="even">
            <th>Address</th>
            <td>Số 58, Trần Thái Tông, Cầu giấy, Hà Nội</td>
        </tr>
        <tr class="odd">
            <th>Phone</th>
            <td>0123456789</td>
        </tr>
        <tr class="even">
            <th>Fax</th>
            <td>445566</td>
        </tr>
        <tr class="odd">
            <th>City</th>
            <td>Hà Nội</td>
        </tr>
        <tr class="even">
            <th>State</th>
            <td></td>
        </tr>
        <tr class="odd">
            <th>Department Parent</th>
            <td></td>
        </tr>
        <!-- <tr class="even">
            <th>Department Employees</th>
            <td>John, Tommy, Zac</td>
        </tr> -->
        <tr class="even">
            <th>Description</th>
            <td>Công ty phát triển phần mềm hoành tráng</td>
        </tr>
    </tbody>
</table>
<br>
<hr>
<h3>Department Employees</h3>
<table class="table table-hover table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Position</th>
            <th>Date</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Cherryl</td>
            <td>Vice President</td>
            <td>01/01/2017</td>
            <td><i style="cursor: pointer;" class="icon-trash"></i></td>
        </tr>

        <tr>
            <td>Edward</td>
            <td>Director</td>
            <td>01/01/2017</td>
            <td><i style="cursor: pointer;" class="icon-trash"></i></td>
        </tr>

        <tr>
            <td>James</td>
            <td>Chief accountant</td>
            <td>01/01/2017</td>
            <td><i style="cursor: pointer;" class="icon-trash"></i></td>
        </tr>

        <tr>
            <td>Joseph</td>
            <td>HR Manager</td>
            <td>01/01/2017</td>
            <td><i style="cursor: pointer;" class="icon-trash"></i></td>
        </tr>

        <tr>
            <td>Rosie</td>
            <td>HR Manager</td>
            <td>01/01/2017</td>
            <td><i style="cursor: pointer;" class="icon-trash"></i></td>
        </tr>

        <tr>
            <td>Frederick</td>
            <td>Director</td>
            <td>01/01/2017</td>
            <td><i style="cursor: pointer;" class="icon-trash"></i></td>
        </tr>
        
        <tr>
            <td>Thomas Edison</td>
            <td>HR Manager</td>
            <td>01/01/2017</td>
            <td><i style="cursor: pointer;" class="icon-trash"></i></td>
        </tr>

        <tr>
            <td>John</td>
            <td>HR Manager</td>
            <td>01/01/2017</td>
            <td><i style="cursor: pointer;" class="icon-trash"></i></td>
        </tr>

        <tr>
            <td>Adam</td>
            <td>HR Manager</td>
            <td>01/01/2017</td>
            <td><i style="cursor: pointer;" class="icon-trash"></i></td>
        </tr>

        <tr>
            <td>Eva</td>
            <td>HR Manager</td>
            <td>01/01/2017</td>
            <td><i style="cursor: pointer;" class="icon-trash"></i></td>
        </tr>

        <tr>
            <td>
                <select name="">
                    <option value="">Rosie</option>
                    <option value="">Edward</option>
                    <option value="">James</option>
                    <option value="">Joseph</option>
                </select>
            </td>
            <td>
                <select name="">
                    <option value="">Vice President</option>
                    <option value="">Director</option>
                    <option value="">Chief accountant</option>
                    <option value="">HR Manager</option>
                </select>
            </td>
            <td><input type="text" name="" value="" placeholder=""></td>
            <td>
                <button type="" class="btn btn-success">Save</button>
            </td>
        </tr>
    </tbody>
</table>
<div class="pagination">
  <a href="#">&laquo;</a>
  <a href="#">1</a>
  <a href="#" class="active">2</a>
  <a href="#">3</a>
  <a href="#">4</a>
  <a href="#">5</a>
  <a href="#">6</a>
  <a href="#">&raquo;</a>
</div>