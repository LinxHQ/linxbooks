<?php 
	echo '<div id="lb-container-header">';
        echo '<div class="lb-header-right"><h3>'.Yii::t("lang","Global Player").'</h3></div>';
        echo '<div class="lb-header-left">';
	        echo '<div id="lb_invoice" class="btn-toolbar">';
	        	echo '<a live="false" data-workspace="1" href="/linxbooks/index.php/1/lbExpenses/create"><i style="margin-top: -12px;margin-right: 10px;" class="icon-plus"></i> </a>';
	        	
	            echo ' <input type="text" placeholder="Enter keyword to search..." value="" style="border-radius: 15px; width: 250px;" onKeyup="search_name_invoice(this.value);">';
	        echo '</div>';
        echo '</div>';
	echo '</div>';
	$picture = Yii::app()->baseUrl."/images/lincoln-default-profile-pic.png";
 ?>
<style type="text/css" media="screen">
 	td table tbody tr td {
    	border-top: none !important;
	}
	.pagination {
    display: inline-block;
    float: right;
}

.pagination a {
    color: black;
    float: left;
    padding: 8px 16px;
    text-decoration: none;
    border: 1px solid #eeeeee;
    border-radius: 4px;
}
 </style>
<table style="border-bottom: 1px solid black;" width="100%">
	<tr>
		<td>
			<h3>Event Details</h3>
		</td>
		<td style="text-align: right;">
			<a href="#"><i class="icon-pencil"></i></a>
		</td>
	</tr>
</table>
<br />
<table class="table table-bordered table-striped table-hover" id="yw1">
    <tbody>
        <tr class="odd">
            <th>Name</th>
            <td>Global Player</td>
        </tr>
        <tr class="even">
            <th>Start</th>
            <td>Oct 25, 2017, 06:00 PM</td>
        </tr>
        <tr class="odd">
            <th>End</th>
            <td>Oct 26, 2017, 03:00 PM</td>
        </tr>
        <tr class="even">
            <th>Venue</th>
            <td>Kallang Stadium</td>
        </tr>
        <tr class="odd">
            <th>Speaker</th>
            <td>John Willb</td>
        </tr>
        <tr class="even">
            <th>Early bird</th>
            <td>Oct 8, 2017</td>
        </tr>
        <tr class="odd">
            <th>Registration Open</th>
            <td>Oct 15, 2017</td>
        </tr>
        <tr class="even">
            <th>Fee</th>
            <td>$20.00</td>
        </tr>
    </tbody>
</table>

<table style="border-bottom: 1px solid black;" width="100%">
	<tr>
		<td>
			<h3>Participants (450)</h3>
		</td>
		<td style="text-align: right;">
			<a href="#"><i style="" class="icon-plus"></i></a>
		</td>
	</tr>
</table>
<br />
<table class="table">
	<thead>
		<tr>
			<th>Name</th>
			<th>NRIC</th>
			<th>Mobile</th>
			<th>Email</th>
			<th>Paid</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<table>
				    <tbody>
				        <tr>
				            <td>
				                <img id="picture_user_comment" style="width: 50px;" src="https://scontent.fhan4-1.fna.fbcdn.net/v/t1.0-1/c0.0.100.100/p100x100/21728345_1307210326054255_5633229461191556178_n.jpg?oh=2e91c8700d26653588c9802d50d96085&oe=5A834C4E" class="img-circle" alt="Cinque Terre">
				            </td>
				            <td>
				                <a href="detailPeople">Jenny Ng</a>
				            </td>
				        </tr>
				    </tbody>
				</table>
			</td>
			<td>S12345</td>
			<td>014578100</td>
			<td>jenny@gmail.com</td>
			<td><i class="icon-ok"></i></td>
		</tr>

		<tr>
			<td>
				<table>
				    <tbody>
				        <tr>
				            <td>
				                <img id="picture_user_comment" style="width: 50px;" src="https://scontent.fhan4-1.fna.fbcdn.net/v/t1.0-1/p100x100/21231187_1282442185199902_5796268154245036696_n.jpg?oh=52bbf4a72c7561ac83335fe7415c4359&oe=5A7F633A" class="img-circle" alt="Cinque Terre">
				            </td>
				            <td>
				                <a href="detailPeople">Lary Pan</a>
				            </td>
				        </tr>
				    </tbody>
				</table>
			</td>
			<td>S81000</td>
			<td>1234512312</td>
			<td>larypan@gmail.com</td>
			<td><i class="icon-ok"></i></td>
		</tr>

		<tr>
			<td>
				<table>
				    <tbody>
				        <tr>
				            <td>
				                <img id="picture_user_comment" style="width: 50px;" src="http://app.kuckoo.vn/profile_photos/40" class="img-circle" alt="Cinque Terre">
				            </td>
				            <td>
				                <a href="detailPeople">Mary Lim</a>
				            </td>
				        </tr>
				    </tbody>
				</table>
			</td>
			<td>S12000</td>
			<td>3451245323</td>
			<td>marylim@gmail.com</td>
			<td><i class="icon-ok"></i></td>
		</tr>
	</tbody>
</table>

<div class="pagination">
  <a href="#">&laquo;</a>
  <a href="#">1</a>
  <a href="#">2</a>
  <a href="#">3</a>
  <a href="#">4</a>
  <a href="#">5</a>
  <a href="#">6</a>
  <a href="#">&raquo;</a>
</div>

<table style="border-bottom: 1px solid black;" width="100%">
	<tr>
		<td>
			<h3>Volunteers</h3>
		</td>
		<td style="text-align: right;">
			<a href="#"><i style="" class="icon-plus"></i></a>
		</td>
	</tr>
</table>
<br />
<table class="table">
	<thead>
		<tr>
			<th>Name</th>
			<th>Mobile</th>
			<th>Email</th>
			<th>Position</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<table>
				    <tbody>
				        <tr>
				            <td>
				                <img id="picture_user_comment" style="width: 50px;" src="https://scontent.fhan4-1.fna.fbcdn.net/v/t1.0-1/p100x100/21317573_1601156846621834_1543939844389751457_n.jpg?oh=ba2612e208eaacebf4d3a9f9aad953a6&oe=5A873C6C" class="img-circle" alt="Cinque Terre">
				            </td>
				            <td>
				                <a href="detailPeople">Mike Tng</a>
				            </td>
				        </tr>
				    </tbody>
				</table>
			</td>
			<td>9764312</td>
			<td>mike@gmail.com</td>
			<td>Usher</td>
		</tr>

		<tr>
			<td>
				<table>
				    <tbody>
				        <tr>
				            <td>
				                <img id="picture_user_comment" style="width: 50px;" src="https://scontent.fhan4-1.fna.fbcdn.net/v/t1.0-1/p160x160/21105502_1283056201798313_9109381480282283205_n.jpg?oh=1dabfdd5735dbbed611e40bb882b163b&oe=5A432447" class="img-circle" alt="Cinque Terre">
				            </td>
				            <td>
				                <a href="detailPeople">John Page</a>
				            </td>
				        </tr>
				    </tbody>
				</table>
			</td>
			<td>76514520</td>
			<td>john@gmail.com</td>
			<td>Welcomer</td>
		</tr>

		<tr>
			<td>
				<table>
				    <tbody>
				        <tr>
				            <td>
				                <img id="picture_user_comment" style="width: 50px;" src="http://app.kuckoo.vn/profile_photos/40" class="img-circle" alt="Cinque Terre">
				            </td>
				            <td>
				                <a href="detailPeople">Julie Ann M</a>
				            </td>
				        </tr>
				    </tbody>
				</table>
			</td>
			<td>100678</td>
			<td>julie@gmail.com</td>
			<td>Usher</td>
		</tr>
	</tbody>
</table>

<div class="pagination">
  <a href="#">&laquo;</a>
  <a href="#">1</a>
  <a href="#">2</a>
  <a href="#">3</a>
  <a href="#">4</a>
  <a href="#">5</a>
  <a href="#">6</a>
  <a href="#">&raquo;</a>
</div>