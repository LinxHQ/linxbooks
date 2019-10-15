<?php 
	echo '<div id="lb-container-header">';
        echo '<div class="lb-header-right"><h3>'.Yii::t("lang","Small Groups").'</h3></div>';
        echo '<div class="lb-header-left lb-header-left-small-group">';
	        echo '<div id="lb_invoice" class="btn-toolbar" style="margin-top:2px;" >';
	        	?>
			    <div class="input-append">
			    	<a live="false" data-workspace="1" href="/linxbooks/index.php/1/lbExpenses/create"><i style="margin-top: -9px;margin-right: 10px;" class="icon-plus"></i> </a>
			      <input type="text" placeholder="Enter leader's name..." value="" style="width: 250px;">
			      <div class="btn-group">
			        <button class="btn dropdown-toggle" data-toggle="dropdown">
			          Location
			          <span class="caret"></span>
			        </button>
			        <ul class="dropdown-menu" style="min-width: 100px !important;">
	                  <li><a href="#">All</a></li>
	                  <li><a href="#">West.BPJ</a></li>
	                  <li><a href="#">Central.TP</a></li>
	                  <!-- <li class="divider"></li> -->
	                  <li><a href="#">East.Bedok</a></li>
	                </ul>
			      </div>
			    </div>
	        	<?php
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
<!-- <br> -->
<style type="text/css" media="screen">
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
			<th>Group Name</th>
			<th>Leader</th>
			<th>Assistant</th>
			<th>Type</th>
			<th>Location</th>
			<th>Active</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><a href="detailSmallGroup">Alpha ONE</a></td>
			<td>John Doe</td>
			<td>
				<p>Jason W.</p>
				<p>Jenny L.</p>
			</td>
			<td>Young Adults</td>
			<td>West.BPJ</td>
			<td>Yes</td>
		</tr>
		<tr>
			<td><a href="detailSmallGroup">Revelation Song</a></td>
			<td>Bern Doe</td>
			<td>
				<p>Joel L.</p>
				<p>Lil R.</p>
			</td>
			<td>35-45</td>
			<td>Central.TP</td>
			<td>Yes</td>
		</tr>
		<tr>
			<td><a href="detailSmallGroup">H.I.F</a></td>
			<td>Mary Ng</td>
			<td>John</td>
			<td>Young Adults</td>
			<td>East.Bedok</td>
			<td>No</td>
		</tr>

		<tr>
			<td><a href="detailSmallGroup">Taque</a></td>
			<td>John</td>
			<td>Mary Ng</td>
			<td>35-45</td>
			<td>East.Bedok</td>
			<td>Yes</td>
		</tr>

		<tr>
			<td><a href="detailSmallGroup">M.A</a></td>
			<td>Jason W.</td>
			<td>John Doe</td>
			<td>35-45</td>
			<td>East.Bedok</td>
			<td>No</td>
		</tr>

		<tr>
			<td><a href="detailSmallGroup">N.I.O</a></td>
			<td>Bern Doe</td>
			<td>Fredick</td>
			<td>Young Adults</td>
			<td>East.Bedok</td>
			<td>Yes</td>
		</tr>

		<tr>
			<td><a href="detailSmallGroup">K.O.K</a></td>
			<td>Mary Ng</td>
			<td><p>John</p>Cherryl</td>
			<td>Young Adults</td>
			<td>East.Bedok</td>
			<td>Yes</td>
		</tr>

		<tr>
			<td><a href="detailSmallGroup">Moon</a></td>
			<td>Bern Doe</td>
			<td><p>Cherryl</p>John Ng.</td>
			<td>Young Adults</td>
			<td>East.Bedok</td>
			<td>Yes</td>
		</tr>

		<tr>
			<td><a href="detailSmallGroup">BQENN</a></td>
			<td>Jason W.</td>
			<td><p>Cherryl Ng.</p>Toony Ng</td>
			<td>Young Adults</td>
			<td>East.Bedok</td>
			<td>No</td>
		</tr>

		<tr>
			<td><a href="detailSmallGroup">B.B.B</a></td>
			<td>Kunka</td>
			<td><p>Poba Ng.</p>Tommy K.</td>
			<td>35-45</td>
			<td>East.Bedok</td>
			<td>No</td>
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