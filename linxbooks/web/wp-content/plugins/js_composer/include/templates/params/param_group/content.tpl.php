<?php
return <<<DATA
<li class="wpb_vc_row wpb_sortable">
    <div class="controls vc_param_group-controls controls_row vc_clearfix">
        <a title="Drag row to reorder" href="#" class="vc_control column_move"><i class="vc_icon"></i></a>
        <span class="vc_row_edit_clone_delete"><a title="Delete this row" href="#" class="vc_control column_delete"><i class="vc_icon"></i></a> <a title="Clone this row" href="#" class="vc_control column_clone"><i class="vc_icon"></i></a> <a title="Toggle row" href="#" class="vc_control column_toggle"><i class="vc_icon"></i></a></span>
    </div>
    <div class="wpb_element_wrapper">
        <div class="vc_row vc_row-fluid wpb_row_container vc_container_for_children wpb-not-sortable">
            <div class="wpb_vc_column wpb_sortable vc_col-sm-12 wpb_content_holder">
                <div>
                    <div class="wpb_column_container vc_container_for_children">%content%</div>
                </div>
            </div>
        </div>
    </div>
</li>
DATA;
