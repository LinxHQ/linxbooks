<?php
$this->breadcrumbs=array(
	'User Subscriptions',
);

//$this->menu=array(
//	array('label'=>'Create UserSubscription', 'url'=>array('create')),
//	array('label'=>'Manage UserSubscription', 'url'=>array('admin')),
//);
?>

<h1>User Subscriptions</h1>

<?php
//print_r($data);

    LBApplicationUI::newButton(Yii::t('lang','New User Subcription'), array(
            'url'=>$this->createUrl('/paypal/userSubscription/create'),
    ));
?>
<br>
<br>
<!--<div id="list_user_subscription" class="grid-view">-->
    <table class="items table table-striped table-bordered table-condensed">
        <thead>
            <th id="user-subscription-grid_c0">User</th>
            <th id="user-subscription-grid_c1">Subscription</th>
            <th id="user-subscription-grid_c2">Date From</th>
        </thead>
        <tbody>
            <?php
            foreach ($data as $da) {
                echo '<tr class="odd">';
                    echo '<td>'.$da['user_name'].'</td>';
                    echo '<td>'.$da['subscription'].'</td>';
                    echo '<td>'.$da['date_from'].'</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
<!--</div>-->
<?php 
//$this->widget('zii.widgets.CListView', array(
//	'dataProvider'=>$dataProvider,
//	'itemView'=>'_view',
//)); 
//print($sub->subscription_name);
?>
