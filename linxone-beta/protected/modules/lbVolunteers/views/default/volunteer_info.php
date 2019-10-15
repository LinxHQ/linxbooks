<?php 
	echo '<div id="lb-container-header">';
        echo '<div class="lb-header-right"><h3 style="margin-top: 4px;">'.Yii::t("lang","Volunteer Info").'</h3></div>';
        echo '<div class="lb-header-left">';
	        echo '<div id="lb_invoice" class="btn-toolbar" style="margin-top:2px;" >';
	        	echo '<a live="false" data-workspace="1" href="/linxbooks/index.php/1/lbExpenses/create"><i style="margin-top: -12px;margin-right: 10px;" class="icon-plus"></i> </a>';
	            echo ' <input type="text" placeholder="Enter name..." value="" style="border-radius: 15px; width: 250px;" onKeyup="search_name_invoice(this.value);">';
	        echo '</div>';
        echo '</div>';
	echo '</div>';
	$picture = Yii::app()->baseUrl."/images/lincoln-default-profile-pic.png";
 ?>

<table style="border-bottom: 1px solid black;" width="100%">
	<tr>
		<td>
			<div style="padding: 10px;">
				<img id="picture_user_comment" style="width: 50px;" src="http://app.kuckoo.vn/profile_photos/40" class="img-circle" alt="Cinque Terre">
				Joseph (<a href="<?php echo $this->createUrl('/lbPeople/default/detailPeople'); ?>">Complete profile</a>)
			</div>
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
				<tr>
					<td>Name</td>
					<td>: Joseph</td>
				</tr>
				<tr>
					<td>Mobile</td>
					<td>: 012345</td>
				</tr>
				<tr>
					<td>Address</td>
					<td>: 15 Changi North Way #01-01 Singapore 498770</td>
				</tr>
				<tr>
					<td>Regular Service</td>
					<td>: BPJ 10am</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div style="width: 50%;">
		<table style="width: 100%;">
			<tbody>
				<tr>
					<td>Email</td>
					<td>: joseph@linxhq.com</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

 <table style="border-bottom: 1px solid black;" width="100%">
	<tr>
		<td>
			<h3>Volunteer</h3>
		</td>
		<td style="text-align: right;">
			<a href="#"><i class="icon-plus"></i></a>
		</td>
	</tr>
</table>

<table class="table">
	<thead>
		<tr>
			<th>Ministry</th>
			<th>Position</th>
			<th>Start</th>
			<th>End</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>Children</td>
			<td>Leader</td>
			<td>01 Jan 2008</td>
			<td>-</td>
		</tr>
		<tr>
			<td>Worship</td>
			<td>Leader</td>
			<td>01 Feb 2009</td>
			<td>-</td>
		</tr>

		<tr>
			<td>Children</td>
			<td>Leader</td>
			<td>01 Feb 2010</td>
			<td>-</td>
		</tr>

		<tr>
			<td>Worship</td>
			<td>Leader</td>
			<td>01 Jan 2011</td>
			<td>-</td>
		</tr>
		<tr>
			<td>Worship</td>
			<td>Leader</td>
			<td>01 Feb 2012</td>
			<td>-</td>
		</tr>

		<tr>
			<td>Children</td>
			<td>Leader</td>
			<td>01 Feb 2013</td>
			<td>-</td>
		</tr>
	</tbody>
</table>