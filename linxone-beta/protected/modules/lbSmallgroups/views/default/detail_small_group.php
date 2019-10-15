<?php 
	echo '<div id="lb-container-header">';
        echo '<div class="lb-header-right"><h3>'.Yii::t("lang","Small Groups Info - Alpha ONE").'</h3></div>';
        echo '<div class="lb-header-left">';
	        echo '<div id="lb_invoice" class="btn-toolbar" >';
	        	echo '<a live="false" data-workspace="1" href="/linxbooks/index.php/1/lbExpenses/create"><i style="margin-top: -12px;margin-right: 10px;" class="icon-plus"></i> </a>';
	            echo ' <input type="text" placeholder="Enter leader\'s name..." value="" style="border-radius: 15px; width: 250px;" onKeyup="search_name_invoice(this.value);">';
	        echo '</div>';
        echo '</div>';
	echo '</div>';
 ?>

<table style="border-bottom: 1px solid black;" width="100%">
	<tr>
		<td>
			<h3>Infomation</h3>
		</td>
		<td style="text-align: right;">
			<a href="#"><i class="icon-pencil"></i></a>
		</td>
	</tr>
</table>

<div style="width: 100%; margin-top: 10px; display: inline-flex;">
	<div style="width: 50%;">
		<table style="width: 100%;">
			<tbody>
				<tr">
					<td>Name</td>
					<td>: Alpha ONE</td>
				</tr>
				<tr>
					<td>Type</td>
					<td>: Young Adults</td>
				</tr>
				<tr>
					<td>Since</td>
					<td>: 07 Sep 2012</td>
				</tr>
				<tr>
					<td>Meeting Time</td>
					<td>: Friday 7PM</td>
				</tr>
				<tr>
					<td>Frequency</td>
					<td>: Weekly</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div style="width: 50%;">
		<table style="width: 100%;">
			<tbody>
				<tr>
					<td>Status</td>
					<td>: Active</td>
				</tr>
				<tr>
					<td>Location</td>
					<td>: West</td>
				</tr>
				<tr>
					<td>District</td>
					<td>: BPJ</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<table style="border-bottom: 1px solid black;" width="100%">
	<tr>
		<td>
			<h3>Members</h3>
		</td>
		<td style="text-align: right;">
			<a href="#"><i class="icon-plus"></i></a>
		</td>
	</tr>
</table>

<table class="table">
	<thead>
		<tr>
			<th>Name</th>
			<th>Postion</th>
			<th>Mobile</th>
			<th>Active</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>John Doe</td>
			<td>Leader</td>
			<td>01234567</td>
			<td><i class="icon-remove"></i></td>
			<td><i style="cursor: pointer;" onclick="delete_departments();" class="icon-trash"></i></td>
		</tr>

		<tr>
			<td>Mary</td>
			<td>Assistant</td>
			<td>01234567</td>
			<td><i class="icon-ok"></i></td>
			<td><i style="cursor: pointer;" onclick="delete_departments();" class="icon-trash"></i></td>
		</tr>

		<tr>
			<td>Joel</td>
			<td>Member</td>
			<td>01234567</td>
			<td><i class="icon-ok"></i></td>
			<td><i style="cursor: pointer;" onclick="delete_departments();" class="icon-trash"></i></td>
		</tr>
	</tbody>
</table>