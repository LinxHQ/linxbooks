<?php 
	echo '<div id="lb-container-header">';
        echo '<div class="lb-header-right"><h3>'.Yii::t("lang","Volunteers").'</h3></div>';
        echo '<div class="lb-header-left">';
	        echo '<div id="lb_invoice" class="btn-toolbar">';
	        	echo '<a live="false" data-workspace="1" href="/linxbooks/index.php/1/lbExpenses/create"><i style="margin-top: -12px;margin-right: 10px;" class="icon-plus"></i> </a>';
	            echo ' <input type="text" placeholder="Enter name..." value="" style="border-radius: 15px; width: 250px;" onKeyup="search_name_invoice(this.value);">';
	        echo '</div>';
        echo '</div>';
	echo '</div>';
	$picture = Yii::app()->baseUrl."/images/lincoln-default-profile-pic.png";
 ?>
<div class="lb-empty-15"></div>
<div id="advanced_search" style="width: 100%;height: 30px; display: inline-flex; /*border: 1px solid red;*/">
  <div id="left" style="width: 50%; padding: 5px;">
    <i class="icon-search"></i> Advanced Search
  </div>
  <div id="right" style="width: 50%; padding: 5px;">
    <p style="float: right;"><i class="icon-download-alt"></i> Excel <i class="icon-download-alt"></i> PDF</p>
  </div>
</div>
<div class="lb-empty-15"></div>
<style type="text/css" media="screen">
 	td table tbody tr td {
    	border-top: none !important;
	}
	.pagination {
    display: inline-block;
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
<table class="table table-hover">
	<thead>
		<tr>
			<th>Name</th>
			<th>Ministry</th>
			<th>Position</th>
			<th>Mobile</th>
			<th>Email</th>
			<th>Active</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<table>
				    <tbody>
				        <tr>
				            <td>
				                <img id="picture_user_comment" style="width: 50px;" src="https://scontent.fhan4-1.fna.fbcdn.net/v/t1.0-1/p160x160/21105502_1283056201798313_9109381480282283205_n.jpg?oh=1dabfdd5735dbbed611e40bb882b163b&oe=5A432447" class="img-circle" alt="Cinque Terre">
				            </td>
				            <td>
				                <a href="volunteerInfo">John</a>
				            </td>
				        </tr>
				    </tbody>
				</table>
			</td>
			<td>Sunbeams</td>
			<td>Leader</td>
			<td>0124</td>
			<td>julia@linxhq.com</td>
			<td><i class="icon-ok"></i></td>
		</tr>

		<tr>
			<td>
				<table>
				    <tbody>
				        <tr>
				            <td>
				                <img id="picture_user_comment" style="width: 50px;" src="https://scontent.fhan4-1.fna.fbcdn.net/v/t1.0-1/p100x100/22221865_1113649658767216_945841794904183438_n.jpg?oh=1f95f5ef1138b765a3001c4e3e82effa&oe=5A7575F9" class="img-circle" alt="Cinque Terre">
				            </td>
				            <td>
				                <a href="volunteerInfo">Joel</a>
				            </td>
				        </tr>
				    </tbody>
				</table>
			</td>
			<td>Small groups</td>
			<td>Leader</td>
			<td>1234</td>
			<td>joel@linxhq.com</td>
			<td><i class="icon-ok"></i></td>
		</tr>

		<tr>
			<td>
				<table>
				    <tbody>
				        <tr>
				            <td>
				                <img id="picture_user_comment" style="width: 50px;" src="https://scontent.fhan4-1.fna.fbcdn.net/v/t1.0-1/p100x100/18157557_1301123946669001_3252960279739469875_n.jpg?oh=85a181d4ec1af86e5c5a309f2482b350&oe=5A819A32" class="img-circle" alt="Cinque Terre">
				            </td>
				            <td>
				                <a href="volunteerInfo">Peter</a>
				            </td>
				        </tr>
				    </tbody>
				</table>
			</td>
			<td>Worship</td>
			<td>Leader</td>
			<td>4567</td>
			<td>peter@linxhq.com</td>
			<td><i class="icon-remove"></i></td>
		</tr>

		<tr>
			<td>
				<table>
				    <tbody>
				        <tr>
				            <td>
				                <img id="picture_user_comment" style="width: 50px;" src="https://scontent.fhan4-1.fna.fbcdn.net/v/t1.0-1/p100x100/21371374_1594856827232100_6674743843593956039_n.jpg?oh=b96c1e440a34ace444a2e47d45cc7ba2&oe=5A7E7B10" class="img-circle" alt="Cinque Terre">
				            </td>
				            <td>
				                <a href="volunteerInfo">Tommy</a>
				            </td>
				        </tr>
				    </tbody>
				</table>
			</td>
			<td>Worship</td>
			<td>Leader</td>
			<td>3241</td>
			<td>tommy@linxhq.com</td>
			<td><i class="icon-ok"></i></td>
		</tr>

		<tr>
			<td>
				<table>
				    <tbody>
				        <tr>
				            <td>
				                <img id="picture_user_comment" style="width: 50px;" src="https://scontent.fhan4-1.fna.fbcdn.net/v/t1.0-1/c0.17.100.100/p100x100/15073282_830388230437369_1899238737884427847_n.jpg?oh=22c1f5ed1858ac09c25ef999fb236cd2&oe=5A8078C3" class="img-circle" alt="Cinque Terre">
				            </td>
				            <td>
				                <a href="volunteerInfo">Julia</a>
				            </td>
				        </tr>
				    </tbody>
				</table>
			</td>
			<td>Worship</td>
			<td>Leader</td>
			<td>3434</td>
			<td>julia@linxhq.com</td>
			<td><i class="icon-ok"></i></td>
		</tr>

		<tr>
			<td>
				<table>
				    <tbody>
				        <tr>
				            <td>
				                <img id="picture_user_comment" style="width: 50px;" src="https://scontent.fhan4-1.fna.fbcdn.net/v/t1.0-1/p100x100/22279814_10214971841755519_4399598374766674044_n.jpg?oh=d1e9d5ff8ea8c305bde9360635835e19&oe=5A412A9A" class="img-circle" alt="Cinque Terre">
				            </td>
				            <td>
				                <a href="volunteerInfo">Eva</a>
				            </td>
				        </tr>
				    </tbody>
				</table>
			</td>
			<td>Worship</td>
			<td>Leader</td>
			<td>6434</td>
			<td>eva@linxhq.com</td>
			<td><i class="icon-remove"></i></td>
		</tr>

		<tr>
			<td>
				<table>
				    <tbody>
				        <tr>
				            <td>
				                <img id="picture_user_comment" style="width: 50px;" src="https://scontent.fhan4-1.fna.fbcdn.net/v/t1.0-1/p100x100/11222230_1013900985322340_586638784224523294_n.jpg?oh=3386abfca1e99b581b5da6c979006e62&oe=5A40255B" class="img-circle" alt="Cinque Terre">
				            </td>
				            <td>
				                <a href="volunteerInfo">Nana E.</a>
				            </td>
				        </tr>
				    </tbody>
				</table>
			</td>
			<td>Worship</td>
			<td>Leader</td>
			<td>6434</td>
			<td>nana@linxhq.com</td>
			<td><i class="icon-ok"></i></td>
		</tr>


		<tr>
			<td>
				<table>
				    <tbody>
				        <tr>
				            <td>
				                <img id="picture_user_comment" style="width: 50px;" src="https://scontent.fhan4-1.fna.fbcdn.net/v/t1.0-1/p100x100/21317573_1601156846621834_1543939844389751457_n.jpg?oh=ba2612e208eaacebf4d3a9f9aad953a6&oe=5A873C6C" class="img-circle" alt="Cinque Terre">
				            </td>
				            <td>
				                <a href="volunteerInfo">Neymar Q.</a>
				            </td>
				        </tr>
				    </tbody>
				</table>
			</td>
			<td>Worship</td>
			<td>Leader</td>
			<td>9823</td>
			<td>neymar@linxhq.com</td>
			<td><i class="icon-remove"></i></td>
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
				                <a href="volunteerInfo">Joseph</a>
				            </td>
				        </tr>
				    </tbody>
				</table>
			</td>
			<td>Worship</td>
			<td>Leader</td>
			<td>1233</td>
			<td>joseph@linxhq.com</td>
			<td><i class="icon-remove"></i></td>
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
				                <a href="volunteerInfo">Queen O.</a>
				            </td>
				        </tr>
				    </tbody>
				</table>
			</td>
			<td>Worship</td>
			<td>Leader</td>
			<td>1233</td>
			<td>queen@linxhq.com</td>
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