<?php 
	echo '<div id="lb-container-header">';
        echo '<div class="lb-header-right"><h3>'.Yii::t("lang","People").'</h3></div>';
        echo '<div class="lb-header-left">';
	        echo '<div id="lb_invoice" class="btn-toolbar" >';
	        	echo '<a live="false" href="'.$this->createUrl('/lbPeople/default/create').'"><i style="margin-top: -12px;margin-right: 10px;" class="icon-plus"></i> </a>';
	            echo ' <input type="text" placeholder="Enter name, email, mobile or NRIC..." value="" style="border-radius: 15px; width: 250px;" onKeyup="search_people_info(this.value);">';
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
<?php 
echo '<div id="show_people">';
$this->Widget('bootstrap.widgets.TbGridView',array(
            'id'=>'lb_show_people',
            'dataProvider'=>  $model->search(),
            // 'itemsCssClass' => 'table-bordered items',
            'template' => "{items}\n{pager}\n{summary}", 
            'columns'=>array(
              array(
                  'header'=>Yii::t('lang','Name'),
                  'type'=>'raw',
                  'value'=>function($data){
                  	$people_title_name = "";
                  	if($data->lb_title != ""){
                  		$people_title = UserList::model()->getTermName('people_title', $data->lb_title);
                  		if($people_title) $people_title_name = "(".$people_title[0]['system_list_item_name'].")";
                  	} 
                  	$redirect_people = $this->createUrl('/lbPeople/default/detailPeople/id/'.$data->lb_record_primary_key.'');
                    return "
                    	<div style='width: 100%; width: auto;height: 60px; display: flex;'>
							<div style='width: 20%; height: 60px;'>
								<img data-toggle='tooltip' title='".$data->lb_given_name."' id='picture_user_comment' style='width: 60px;' src='".Yii::app()->baseUrl."/images/lincoln-default-profile-pic.png' class='img-circle' alt='Cinque Terre'>
							</div>
							<div style='width: 80%; height: 60px;'>
									<p></p>
									<a href=".$redirect_people.">".$data->lb_given_name."</a><br />".$people_title_name."
							</div>
                   		</div>";
                  },
                  'htmlOptions'=>array('width'=>'200'),
              ),
              array(
                  'header'=>Yii::t('lang','Address'),
                  'type'=>'raw',
                  'value'=>function($data){
                  	return $data->lb_local_address_street."<br />".$data->lb_local_address_street2;
                  },
                  'htmlOptions'=>array('width'=>'250'),
              ),
              array(
                  'header'=>Yii::t('lang','Email'),
                  'type'=>'raw',
                  'value'=>function($data){
                    return $data->lb_local_address_email;
                  },
                  // 'value'=>'LbOpportunityIndustry::model()->searchIndustryName($data->industry)->attributes["industry_name"]',
                  'htmlOptions'=>array('width'=>'100'),
              ),
              array(
                  'header'=>Yii::t('lang','Mobile'),
                  'type'=>'raw',
                  'value'=> function($data){
                  	return $data->lb_local_address_mobile;
                  },
                  'htmlOptions'=>array('width'=>'100'),
              ),
                array(
					'class'=>'bootstrap.widgets.TbButtonColumn',
                    'template'=>'{update} {delete}',
                    'buttons'=>array(
                        'delete'=>array(
//                             'visible'=>'$data->isCanDetete()'
                        )
                    ),
                    'htmlOptions'=>array('style'=>'width:40px;')
				),
            )
        ));
echo '</div>';
?>
<script type="text/javascript">
	function search_people_info(info_people) {
		$("#show_people").load("<?php echo $this->createUrl('/lbPeople/Default/_search_info_people'); ?>",{info_people:info_people});
	}
</script>
 <!-- <table class="table table-hover">
 	<thead>
 		<tr>
 			<th class="text-center">Name</th>
 			<th class="text-center">Address</th>
 			<th class="text-center">Email</th>
 			<th class="text-center">Mobile</th>
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
				                <a href="detailPeople">Julia</a>
				                <p>(Mrs.)</p>
				            </td>
				        </tr>
				    </tbody>
				</table>
 			</td>
 			<td>15 Changi North Way #01-01 Singapore 498770</td>
 			<td>johndoe@linxhq.com</td>
 			<td>65481813</td>
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
				                <a href="detailPeople">Julia Ets</a>
				                <p>(Mrs.)</p>
				            </td>
				        </tr>
				    </tbody>
				</table>
 			</td>
 			<td>Blk 36 Bedok South Avenue 2 #11-407</td>
 			<td>juliaets@linxhq.com</td>
 			<td>21312334</td>
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
				                <a href="detailPeople">Poba</a>
				                <p>(Mr.)</p>
				            </td>
				        </tr>
				    </tbody>
				</table>
 			</td>
 			<td>1 Mt. Faber Road #05-03 The Pearl Singapore 099206</td>
 			<td>poba@linxhq.com</td>
 			<td>123123343</td>
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
				                <a href="detailPeople">Kunka</a>
				                <p>(Mr.)</p>
				            </td>
				        </tr>
				    </tbody>
				</table>
 			</td>
 			<td>51 Cove Drive #05-01 Turquoise Singapore 098393</td>
 			<td>kunka@linxhq.com</td>
 			<td>213123344</td>
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
				                <a href="detailPeople">Maria</a>
				                <p>(Mrs.)</p>
				            </td>
				        </tr>
				    </tbody>
				</table>
 			</td>
 			<td>25 Joo Chiat Lane # 05-16 Legenda @ Joo Chiat Singapore 428099</td>
 			<td>maria@linxhq.com</td>
 			<td>456456211</td>
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
				                <a href="detailPeople">Queen</a>
				                <p>(Mrs.)</p>
				            </td>
				        </tr>
				    </tbody>
				</table>
 			</td>
 			<td>25 Joo Chiat Lane # 05-16 Legenda @ Joo Chiat Singapore 428099</td>
 			<td>maria@linxhq.com</td>
 			<td>212213137</td>
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
				                <a href="detailPeople">Joseph</a>
				                <p>(Mr.)</p>
				            </td>
				        </tr>
				    </tbody>
				</table>
 			</td>
 			<td> 15 Changi North Way #01-01</td>
 			<td>josehp@linxhq.com</td>
 			<td>65481881</td>
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
				                <a href="detailPeople">Frederick</a>
				                <p>(Mr.)</p>
				            </td>
				        </tr>
				    </tbody>
				</table>
 			</td>
 			<td>15 Changi North Way Level 2 Singapore</td>
 			<td>frederick@linxhq.com</td>
 			<td>65483169</td>
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
				                <a href="detailPeople">Cherryl</a>
				                <p>(Mrs.)</p>
				            </td>
				        </tr>
				    </tbody>
				</table>
 			</td>
 			<td>15 Changi North Way - Rooftop Singapore</td>
 			<td>cherryl@linxhq.com</td>
 			<td>98523313</td>
 		</tr>
 		<tr>
 			<td>
 				<table>
				    <tbody>
				        <tr>
				            <td>
				                <img id="picture_user_comment" style="width: 50px;" src="https://scontent.fhan4-1.fna.fbcdn.net/v/t1.0-1/c0.0.100.100/p100x100/21728345_1307210326054255_5633229461191556178_n.jpg?oh=2e91c8700d26653588c9802d50d96085&oe=5A834C4E" class="img-circle" alt="Cinque Terre">
				            </td>
				            <td>
				                <a href="detailPeople">Tommy</a>
				                <p>(Mr.)</p>
				            </td>
				        </tr>
				    </tbody>
				</table>
 			</td>
 			<td>15 Changi North Way Level 1 Warehouse Singapore</td>
 			<td>tommy@linxhq.com</td>
 			<td>81124468</td>
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
</div> -->