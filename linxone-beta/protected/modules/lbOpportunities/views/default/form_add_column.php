<!-- Popup new column -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">New Column</h4>
      </div>
      <div class="modal-body">
        <table>
        	<tbody>
        		<tr>
        			<td>Column Name : </td>
        			<td><input type="text" name="column_name" id="column_name"></td>
        		</tr>
        		<tr>
        			<td>Chosse Color :</td>
        			<td><input type='text' id="color_picker" /></td>
        		</tr>
        	</tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button onclick="save_add_column();" type="button" class="btn btn-info">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- End Popup new column -->