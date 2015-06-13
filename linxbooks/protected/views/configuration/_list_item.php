<?php
//    $name = 'config.php';
//    include './protected/modules/lbPayment/'.$name;
 ?>
<div>
    <table class = "table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>List</th>
            </tr>
        </thead>
        <?php
        
            for ($i = 0; $i < count($list); $i++) {
               $tbl = "<tr>
                       <td>".($i+1)."</td>
                            <td>".CHtml::link($list[$i],array('configuration/list_item','list'=>$list[$i]))."</td>
                       </tr>";
               echo $tbl;
               
            }
            
        ?>
    </table>
    
</div>
<p></p>
<script>
$( ".list tr:odd" ).css( "background-color", "#f9f9f9" );
$( ".list tr:odd" ).css( "width", "50%" );

</script>