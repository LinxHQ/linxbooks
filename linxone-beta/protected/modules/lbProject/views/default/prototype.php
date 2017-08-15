<?php

echo '<div id="lb-container-header">';
            echo '<div class="lb-header-right" style="margin-left: -10px"><h3>Dự án</h3></div>';
            echo '<div class="lb-header-left">';
            echo '<div id="lb_invoice" class="btn-toolbar" style="margin-top:2px;" >';
            echo '<i class="icon-plus icon-white" style="margin-top: -12px"></i><span>&nbsp;&nbsp;</span>';
                echo ' <input type="text" placeholder="Search" value="" style="border-radius: 15px;" onKeyup="search_name_invoice(this.value);">';
            echo '</div>';
            echo '</div>';
echo '</div>';
    ?>

<div style="margin-top: 20px">
    <ul class="nav nav-tabs">
        <li class="active">
            <a data-toggle="tab" href="#yw_tab_projects">Dự án <span class="badge">4</span></a>
        </li>
        <li class="">
            <a data-toggle="tab">Công việc <span class="badge badge-warning">25</span></a>
        </li>
        <li class="">
            <a data-toggle="tab">Văn bản <span class="badge badge-success">6</span></a>
        </li>
        <li class="">
            <a data-toggle="tab">Wiki <span class="badge badge-info">5</span></a>
        </li>
        <li class="">
            <a data-toggle="tab" href="#yw_tab_task_info">Thay đổi tài liệu...</a>
        </li>
</ul>
</div>

<div class="tab-content">
<div id="yw_tab_projects" class="tab-pane fade active in" style="margin-top: -30px;">
    <!--div style="text-align: right"><i class="icon-plus"></i> <a href="#">Tạo dự án</a></div-->
<div class="panel">

    <div>
    <div id="show_invoice"  style="maring-top: -10px;">
        <div id="lb-invoice-Outstanding-grid" class="grid-view">
<table class="items table" style="maring-top: -10px;">
<thead>
<tr>
<th id="lb-invoice-Outstanding-grid_c0">&nbsp;</th><th id="lb-invoice-Outstanding-grid_c1">&nbsp;</th><th id="lb-invoice-Outstanding-grid_c2">&nbsp;</th><th id="lb-invoice-Outstanding-grid_c3">&nbsp;</th></tr>
</thead>
<tbody>
<tr class="odd">
<td width="60" style="border-top: 0px">
<img src="http://app.kuckoo.vn/profile_photos/40" style="width:50px; height: 50px; border-radius: 25px;"/>
</td>
<td width="" style="border-top: 0px">
    Phát triển phiên bản Office4c v3.0
</td>
<td width="120" style="text-align: right;border-top: 0px">
    05/06/2017
</td>
<td width="250" style="text-align: right;border-top: 0px">
    <span class="badge badge-warning">5 vấn đề</span>&nbsp;
    <span class="badge badge-success" style="background-color: rgb(91, 183, 91)">15 nhiệm vụ</span>&nbsp;
    <span class="badge badge-important">0 chậm</span>
</td>
<td style="border-top: 0px">
    <i class="icon-wrench"></i>
</td>
</tr>
<tr class="odd">
<td width="60">
<img src="http://app.kuckoo.vn/profile_photos/637" style="width:50px; height: 50px; border-radius: 25px;"/>
</td>
<td width="">
    Marketing cho quý 3
</td>
<td width="120" style="text-align: right;">
    25/06/2017
</td>
<td width="250" style="text-align: right;">
    <span class="badge badge-warning">1 vấn đề</span>&nbsp;
    <span class="badge badge-success" style="background-color: rgb(91, 183, 91)">5 nhiệm vụ</span>&nbsp;
    <span class="badge badge-important">2 chậm</span>
</td>
<td>
    <i class="icon-wrench"></i>
</td>
</tr>
<tr class="odd">
<td width="60">
<img src="http://app.kuckoo.vn/profile_photos/344" style="width:50px; height: 50px; border-radius: 25px;"/>
</td>
<td width="">
    Phát triển kế hoạch học online cho core team
</td>
<td width="120" style="text-align: right;">
    15/07/2017
</td>
<td width="250" style="text-align: right;">
    <span class="badge badge-warning">2 vấn đề</span>&nbsp;
    <span class="badge badge-success" style="background-color: rgb(91, 183, 91)">8 nhiệm vụ</span>&nbsp;
    <span class="badge badge-important">0 chậm</span>
</td>
<td>
    <i class="icon-wrench"></i>
</td>
</tr>
<tr class="odd">
<td width="60">
<img src="http://app.kuckoo.vn/profile_photos/344" style="width:50px; height: 50px; border-radius: 25px;"/>
</td>
<td width="">
    Hoạt động nghỉ mát và team building 2017
</td>
<td width="120" style="text-align: right;">
    15/07/2017
</td>
<td width="250" style="text-align: right;">
    <span class="badge badge-warning">1 vấn đề</span>&nbsp;
    <span class="badge badge-success" style="background-color: rgb(91, 183, 91)">5 nhiệm vụ</span>&nbsp;
    <span class="badge badge-important">1 chậm</span>
</td>
<td>
    <i class="icon-wrench"></i>
</td>
</tr>
</tbody>
</table>

<div class="keys" style="display:none" title="/index.php/20/lbInvoice/_form_oustanding_invoice"><span>937</span><span>986</span><span>980</span><span>974</span><span>938</span><span>778</span></div>
</div>       
    </div>
    </div>
    
    <!--    <div>
        <a class="more" href="<?//php echo LbInvoice::model()->getActionURLNormalized('admin'); ?>"><?//php echo Yii::t('lang','see more invoices'); ?></a>
    </div>-->
</div>

</div>

<!-- NỘI DUNG TASK DEMO -->
<div id="yw_tab_task_info" class="tab-pane fade">
    <div id="task-main-body" style="width: 800px; float: left; margin-left: 10px;">
        <h4 style="display: inline; max-width: 800px; font-weight: normal">
        <div style="margin-bottom:8px;"><a href="#" rel="Task_task_name_3875" data-pk="3875" class="editable editable-click">
                Thay đổi tài liệu marketing sau họp Q2</a></div></h4>
            <div class="comment-container">
                <div id="task-description-container-3875">
                    <br>
                    Mô tả : 
                <a id="ajax-id-5923f52f5d246" href="#"><i class="icon-pencil"></i></a>            <div id="task-description-content-3875">
                    <span style="font-size: 13.3333px;">Except for the 2 Exports reported at Issue#51, please find the attached screenshots from the LIVE.</span>            </div>
                </div>

                <div class="footer-container">
                    02-06-2016&nbsp;bởi&nbsp;LyePing C.&nbsp;-&nbsp;
                        <strong>Thành viên:</strong> <div id="assignees-list" style="display: inline"><a><i class="icon-user"></i>Bạn</a>&nbsp;<a><i class="icon-user"></i>Hamilyn Q.</a>&nbsp;<a><i class="icon-user"></i>LyePing C.</a>&nbsp;<a><i class="icon-user"></i>Huong N.</a>&nbsp;</div><a data-value="381,40,357,377,386," href="#" rel="Task_task_assignees_3875" data-pk="3875" class="editable editable-click editable-empty">Cập nhật</a>&nbsp;&nbsp;<strong>Lịch:</strong> <div style="display: inline"><a data-value="2016-06-02" href="#" rel="Task_task_start_date_3875" data-pk="3875" class="editable editable-click">02-06-2016</a></div> to <div style="display: inline"><a data-value="2016-06-02" href="#" rel="Task_task_end_date_3875" data-pk="3875" class="editable editable-click">02-06-2016</a></div>&nbsp;&nbsp;<strong>Mốc:</strong> <div id="lc-task-milestones-list" style="display: inline"></div><a data-value="0," href="#" rel="Task_task_milestones_3875" data-pk="3875" class="editable editable-click editable-empty">Cập nhật</a>        </div>

            </div> <!-- end infor-container div -->

            <div id="form-comment" class="top-new-form well form" style="width: 760px; margin-top: 20px; margin-bottom: 40px">
                    <a id="ajax-id-5923f52f3ee09" href="#">Bình luận hoặc đăng tải văn bản</a>    </div>

            <div id="new-comment-form-link-holder" style="display: none">
                    <a id="ajax-id-5923f52f3ee09" href="#">Bình luận hoặc đăng tải văn bản</a>    </div>

            <div id="comments-thread" class="comments-thread">
                    <div id="comment-thread-20056" class="comment-root-20056 comment-container" style="height: auto; padding-bottom: 5px;">

                        <div id="comment-root-20056" class="comment-container" style="width: 100%;">
                                <div id="comment-content-container-20056"><div id="comment-profile-photo-20056" style="width: 55px; float: left;">
                        <a style="display: inline-block;" rel="tooltip" title="LyePing C." href="#"><img height="50" width="50" style="; margin-right: 5px; height: 50px; border-radius:25px; width: 50px; " src="http://www.linxcircle.com/profile_photos/381" alt=""></a></div><div id="comment-content-20056" style="display: table">
                        <b>LyePing C.</b>: <a id="anchor-task-comment-20056"></a>They are not reports but export to excel. Please work on this soonest<br></div></div>
        <div class="footer-container">
                Được đăng vào 21-03-2017 04:43 pm<div style="float: right">#20056&nbsp; </div></div>
                        </div>

                <div id="comment-reply-thread-20056" style="padding-left: 40px;">
                        <div class="comment-container" id="reply-container-20060"><div id="comment-content-container-20060"><div id="comment-profile-photo-20060" style="width: 55px; float: left;">
                        <a style="display: inline-block;" rel="tooltip" title="Huong N." href="#"><img height="50" width="50" style="; margin-right: 5px; height: 50px; border-radius:25px; width: 50px; " src="http://www.linxcircle.com/profile_photos/386" alt=""></a></div><div id="comment-content-20060" style="display: table">
                        <b>Huong N.</b>: <a id="anchor-task-comment-20060"></a>Ok, I noted. We will update on this issue and inform you soon. Thanks<br></div></div>
        <div class="footer-container">
                Được đăng vào 21-03-2017 04:57 pm<div style="float: right">#20060&nbsp; </div></div>
        </div>	</div>
                <div id="new-reply-form-link-holder-20056" style="display: none">
                <a id="ajax-id-5923f52f607c5" class="blur-summary" href="#">Click to Reply</a>	</div>

                <div id="comment-thread-reply-form-20056" class="" style="margin-left: 40px;"><a id="ajax-id-5923f52f607c5" class="blur-summary" href="#">Click to Reply</a></div></div> <!-- End div #comment -->
        <div id="comment-thread-19779" class="comment-root-19779 comment-container" style="height: auto; padding-bottom: 5px;">

                        <div id="comment-root-19779" class="comment-container" style="width: 100%;">
                                <div id="comment-content-container-19779"><div id="comment-profile-photo-19779" style="width: 55px; float: left;">
                        <a style="display: inline-block;" rel="tooltip" title="Huong N." href="#"><img height="50" width="50" style="; margin-right: 5px; height: 50px; border-radius:25px; width: 50px; " src="http://www.linxcircle.com/profile_photos/386" alt=""></a></div><div id="comment-content-19779" style="display: table">
                        <b>Huong N.</b>: <a id="anchor-task-comment-19779"></a>Hi Lye Ping,<div><br></div><div>Could you please let us know which reports you are mentioning to? Thank you</div><br></div></div>
        <div class="footer-container">
                Được đăng vào 04-02-2017 05:39 pm<div style="float: right">#19779&nbsp; </div></div>
                        </div>

                <div id="comment-reply-thread-19779" style="padding-left: 40px;">
                        <div class="comment-container" id="reply-container-19780"><div id="comment-content-container-19780"><div id="comment-profile-photo-19780" style="width: 55px; float: left;">
                        <a style="display: inline-block;" rel="tooltip" title="Bạn" href="#"><img height="50" width="50" style="; margin-right: 5px; height: 50px; border-radius:25px; width: 50px; " src="http://www.linxcircle.com/profile_photos/40" alt=""></a></div><div id="comment-content-19780" style="display: table">
                        <b>Bạn</b>: <a id="anchor-task-comment-19780"></a>Huong, it's in the task name "Pastoral Care" module's reports.<br></div></div>
        <div class="footer-container">
                Được đăng vào 04-02-2017 05:42 pm<div style="float: right">#19780&nbsp; </div></div>
        </div>	</div>
                <div id="new-reply-form-link-holder-19779" style="display: none">
                <a id="ajax-id-5923f52f60fa7" class="blur-summary" href="#">Click to Reply</a>	</div>

                <div id="comment-thread-reply-form-19779" class="" style="margin-left: 40px;"><a id="ajax-id-5923f52f60fa7" class="blur-summary" href="#">Click to Reply</a></div></div> <!-- End div #comment -->
        <div id="comment-thread-19678" class="comment-root-19678 comment-container" style="height: auto; padding-bottom: 5px;">

                        <div id="comment-root-19678" class="comment-container" style="width: 100%;">
                                <div id="comment-content-container-19678"><div id="comment-profile-photo-19678" style="width: 55px; float: left;">
                        <a style="display: inline-block;" rel="tooltip" title="LyePing C." href=#><img height="50" width="50" style="; margin-right: 5px; height: 50px; border-radius:25px; width: 50px; " src="http://www.linxcircle.com/profile_photos/381" alt=""></a></div><div id="comment-content-19678" style="display: table">
                        <b>LyePing C.</b>: <a id="anchor-task-comment-19678"></a>For the homebound, Export 1 is OK but not for Export 2. Please refer to attached<br></div></div><div id="container-document-6694" style="margin-left: 45px; "><img border="0" src="http://www.linxcircle.com/images/fileicons/32px/jpeg.png" alt=""><a href="/document/download/6694">Task#74-2 Homebound Export 2 (LIVE).jpg</a> <a data-lightbox="linxcircle_doc_preview_task_3875" data-title="Task#74-2 Homebound Export 2 (LIVE).jpg" href="/document/download/6694"><i class="icon-search"></i></a> <br></div>
        <div class="footer-container">
                Được đăng vào 18-01-2017 05:30 pm<div style="float: right"><i class="icon-comment"></i><a id="ajax-id-5923f52f68245" class="blur-summary" href="#">Trả lời</a>&nbsp;&nbsp;#19678&nbsp; </div></div>
                        </div>

                <div id="comment-reply-thread-19678" style="padding-left: 40px;">
                                </div>
                <div id="new-reply-form-link-holder-19678" style="display: none">
                <a id="ajax-id-5923f52f616cb" class="blur-summary" href="#">Click to Reply</a>	</div>

                <div id="comment-thread-reply-form-19678" class="" style="margin-left: 40px;"></div></div> <!-- End div #comment -->
        <div id="comment-thread-19676" class="comment-root-19676 comment-container" style="height: auto; padding-bottom: 5px;">

                        <div id="comment-root-19676" class="comment-container" style="width: 100%;">
                                <div id="comment-content-container-19676"><div id="comment-profile-photo-19676" style="width: 55px; float: left;">
                        <a style="display: inline-block;" rel="tooltip" title="LyePing C." href="#"><img height="50" width="50" style="; margin-right: 5px; height: 50px; border-radius:25px; width: 50px; " src="http://www.linxcircle.com/profile_photos/381" alt=""></a></div><div id="comment-content-19676" style="display: table">
                        <b>LyePing C.</b>: <a id="anchor-task-comment-19676"></a>For the bereavement export, please see attached.<br></div></div><div id="container-document-6692" style="margin-left: 45px; "><img border="0" src="http://www.linxcircle.com/images/fileicons/32px/jpeg.png" alt=""><a href="/document/download/6692">Task#74-1 Bereavement Export 2 (LIVE).jpg</a> <a data-lightbox="linxcircle_doc_preview_task_3875" data-title="Task#74-1 Bereavement Export 2 (LIVE).jpg" href="/document/download/6692"><i class="icon-search"></i></a> <br></div>
        <div class="footer-container">
                Được đăng vào 18-01-2017 05:13 pm<div style="float: right"><i class="icon-comment"></i><a id="ajax-id-5923f52f6c64a" class="blur-summary" href="#">Trả lời</a>&nbsp;&nbsp;#19676&nbsp; </div></div>
                        </div>

                <div id="comment-reply-thread-19676" style="padding-left: 40px;">
                                </div>
                <div id="new-reply-form-link-holder-19676" style="display: none">
                <a id="ajax-id-5923f52f6830e" class="blur-summary" href="#">Click to Reply</a>	</div>

                <div id="comment-thread-reply-form-19676" class="" style="margin-left: 40px;"></div></div> <!-- End div #comment -->
        <div id="comment-thread-19673" class="comment-root-19673 comment-container" style="height: auto; padding-bottom: 5px;">

                        <div id="comment-root-19673" class="comment-container" style="width: 100%;">
                                <div id="comment-content-container-19673"><div id="comment-profile-photo-19673" style="width: 55px; float: left;">
                        <a style="display: inline-block;" rel="tooltip" title="LyePing C." href="#"><img height="50" width="50" style="; margin-right: 5px; height: 50px; border-radius:25px; width: 50px; " src="http://www.linxcircle.com/profile_photos/381" alt=""></a></div><div id="comment-content-19673" style="display: table">
                        <b>LyePing C.</b>: <a id="anchor-task-comment-19673"></a>I have problem drilling into Hospital Visit in the UAT ( <a href="http://192.192.1.43/Visit/VisitDetails?VId=151" target="_blank">http://192.192.1.43/Visit/VisitDetails?VId=151</a> ), thus cannot check the export function. I attached the error message<br></div></div><div id="container-document-6691" style="margin-left: 45px; "><img border="0" src="http://www.linxcircle.com/images/fileicons/32px/jpeg.png" alt=""><a href="/document/download/6691">Task#74-1 pastoral care error in UAT.jpg</a> <a data-lightbox="linxcircle_doc_preview_task_3875" data-title="Task#74-1 pastoral care error in UAT.jpg" href="/document/download/6691"><i class="icon-search"></i></a> <br></div>
        <div class="footer-container">
                Được đăng vào 18-01-2017 04:47 pm<div style="float: right">#19673&nbsp; </div></div>
                        </div>

                <div id="comment-reply-thread-19673" style="padding-left: 40px;">
                        <div class="comment-container" id="reply-container-19679"><div id="comment-content-container-19679"><div id="comment-profile-photo-19679" style="width: 55px; float: left;">
                        <a style="display: inline-block;" rel="tooltip" title="Huong N." href="#"><img height="50" width="50" style="; margin-right: 5px; height: 50px; border-radius:25px; width: 50px; " src="http://www.linxcircle.com/profile_photos/386" alt=""></a></div><div id="comment-content-19679" style="display: table">
                        <b>Huong N.</b>: <a id="anchor-task-comment-19679"></a>Ok, we will check and update you soon. Thank you<br></div></div>
        <div class="footer-container">
                Được đăng vào 18-01-2017 05:36 pm<div style="float: right">#19679&nbsp; </div></div>
        </div>	</div>
                <div id="new-reply-form-link-holder-19673" style="display: none">
                <a id="ajax-id-5923f52f6c716" class="blur-summary" href="#">Click to Reply</a>	</div>

                <div id="comment-thread-reply-form-19673" class="" style="margin-left: 40px;"><a id="ajax-id-5923f52f6c716" class="blur-summary" href="#">Click to Reply</a></div></div> <!-- End div #comment -->
        <div id="comment-thread-19262" class="comment-root-19262 comment-container" style="height: auto; padding-bottom: 5px;">

                        <div id="comment-root-19262" class="comment-container" style="width: 100%;">
                                <div id="comment-content-container-19262"><div id="comment-profile-photo-19262" style="width: 55px; float: left;">
                        <a style="display: inline-block;" rel="tooltip" title="Bạn" href="#"><img height="50" width="50" style="; margin-right: 5px; height: 50px; border-radius:25px; width: 50px; " src="http://www.linxcircle.com/profile_photos/40" alt=""></a></div><div id="comment-content-19262" style="display: table">
                        <b>Bạn</b>: <a id="anchor-task-comment-19262"></a><span style="font-size: 13.3333px;">Hi LyePing &amp; Hamilyn, can you help me check issue?&nbsp;</span><br></div></div>
        <div class="footer-container">
                Được đăng vào 21-11-2016 06:00 pm<div style="float: right"><i class="icon-comment"></i><a id="ajax-id-5923f52f6f0af" class="blur-summary" href="#">Trả lời</a>&nbsp;&nbsp;#19262&nbsp; </div></div>
                        </div>

                <div id="comment-reply-thread-19262" style="padding-left: 40px;">
                                </div>
                <div id="new-reply-form-link-holder-19262" style="display: none">
                <a id="ajax-id-5923f52f6eb4e" class="blur-summary" href="#">Click to Reply</a>	</div>

                <div id="comment-thread-reply-form-19262" class="" style="margin-left: 40px;"></div></div> <!-- End div #comment -->
        <div id="comment-thread-17954" class="comment-root-17954 comment-container" style="height: auto; padding-bottom: 5px;">

                        <div id="comment-root-17954" class="comment-container" style="width: 100%;">
                                <div id="comment-content-container-17954"><div id="comment-profile-photo-17954" style="width: 55px; float: left;">
                        <a style="display: inline-block;" rel="tooltip" title="LyePing C." href="#"><img height="50" width="50" style="; margin-right: 5px; height: 50px; border-radius:25px; width: 50px; " src="http://www.linxcircle.com/profile_photos/381" alt=""></a></div><div id="comment-content-17954" style="display: table">
                        <b>LyePing C.</b>: <a id="anchor-task-comment-17954"></a>Uploaded document(s).<br></div></div><div id="container-document-5707" style="margin-left: 45px; "><img border="0" src="http://www.linxcircle.com/images/fileicons/32px/jpeg.png" alt=""><a href="/document/download/5707">Task#74 Bereavement Export 2 (LIVE).jpg</a> <a data-lightbox="linxcircle_doc_preview_task_3875" data-title="Task#74 Bereavement Export 2 (LIVE).jpg" href="/document/download/5707"><i class="icon-search"></i></a> <br></div><div id="container-document-5705" style="margin-left: 45px; "><img border="0" src="http://www.linxcircle.com/images/fileicons/32px/jpeg.png" alt=""><a href="/document/download/5705">Task#74 Homebound Export 1 (LIVE).jpg</a> <a data-lightbox="linxcircle_doc_preview_task_3875" data-title="Task#74 Homebound Export 1 (LIVE).jpg" href="/document/download/5705"><i class="icon-search"></i></a> <br></div><div id="container-document-5706" style="margin-left: 45px; "><img border="0" src="http://www.linxcircle.com/images/fileicons/32px/jpeg.png" alt=""><a href="/document/download/5706">Task#74 Homebound Export 2 (LIVE).jpg</a> <a data-lightbox="linxcircle_doc_preview_task_3875" data-title="Task#74 Homebound Export 2 (LIVE).jpg" href="/document/download/5706"><i class="icon-search"></i></a> <br></div><div id="container-document-5704" style="margin-left: 45px; "><img border="0" src="http://www.linxcircle.com/images/fileicons/32px/jpeg.png" alt=""><a href="/document/download/5704">Task#74 Hospital Visit Export 2 (LIVE).jpg</a> <a data-lightbox="linxcircle_doc_preview_task_3875" data-title="Task#74 Hospital Visit Export 2 (LIVE).jpg" href="/document/download/5704"><i class="icon-search"></i></a> <br></div>
        <div class="footer-container">
                Được đăng vào 02-06-2016 04:37 pm<div style="float: right">#17954&nbsp; </div></div>
                        </div>

                <div id="comment-reply-thread-17954" style="padding-left: 40px;">
                        <div class="comment-container" id="reply-container-17956"><div id="comment-content-container-17956"><div id="comment-profile-photo-17956" style="width: 55px; float: left;">
                        <a style="display: inline-block;" rel="tooltip" title="Huong N." href="#"><img height="50" width="50" style="; margin-right: 5px; height: 50px; border-radius:25px; width: 50px; " src="http://www.linxcircle.com/profile_photos/386" alt=""></a></div><div id="comment-content-17956" style="display: table">
                        <b>Huong N.</b>: <a id="anchor-task-comment-17956"></a>OK, I noted. We will update and inform you soon. Thank you.<br></div></div>
        <div class="footer-container">
                Được đăng vào 02-06-2016 04:41 pm<div style="float: right">#17956&nbsp; </div></div>
        </div><div class="comment-container" id="reply-container-18180"><div id="comment-content-container-18180"><div id="comment-profile-photo-18180" style="width: 55px; float: left;">
                        <a style="display: inline-block;" rel="tooltip" title="Huong N." href="#"><img height="50" width="50" style="; margin-right: 5px; height: 50px; border-radius:25px; width: 50px; " src="http://www.linxcircle.com/profile_photos/386" alt=""></a></div><div id="comment-content-18180" style="display: table">
                        <b>Huong N.</b>: <a id="anchor-task-comment-18180"></a>Hi Lye Ping and Hamilyn,<div><br></div><div>We updated this issue in UAT, please help us to check. Thank you.</div><br></div></div>
        <div class="footer-container">
                Được đăng vào 14-07-2016 11:04 am<div style="float: right">#18180&nbsp; </div></div>
        </div>	</div>
                <div id="new-reply-form-link-holder-17954" style="display: none">
                <a id="ajax-id-5923f52f6f156" class="blur-summary" href="#">Click to Reply</a>	</div>

                <div id="comment-thread-reply-form-17954" class="" style="margin-left: 40px;"><a id="ajax-id-5923f52f6f156" class="blur-summary" href="#">Click to Reply</a></div></div> <!-- End div #comment -->
            </div> <!-- comments-thread div -->

        </div>
</div>
<!-- END nội dung task demo -->
</div>