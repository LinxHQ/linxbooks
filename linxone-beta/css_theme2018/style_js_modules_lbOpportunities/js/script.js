$( document ).ready(function() {

	var from_date = $("#from_date").datepicker({
        format: 'dd-mm-yyyy',
    }).on('changeDate', function(ev) {
        from_date.hide();
    }).data('datepicker');

    var from_date = $("#to_date").datepicker({
        format: 'dd-mm-yyyy',
    }).on('changeDate', function(ev) {
        from_date.hide();
    }).data('datepicker');

    $(".datepicker").css("z-index", "99999");

	$('.panel-body').sortable({
        start: function(event, ui) {
            item = ui.item;
            newList = oldList = ui.item.parent().parent();
        },
        stop: function(event, ui) {
	        var id_task = item.attr('data');
	        var id_column = newList.attr('id');
	        $.ajax({
	            type: "POST",
	            url: 'SwitchOpportunity',
	            data: { id_task: id_task, id_column:id_column },
	            success: function(data) {

	            }
	        });
        },
        change: function(event, ui) {  
            if(ui.sender) newList = ui.placeholder.parent().parent();
        },
        connectWith: ".panel-body"
    }).disableSelection();
    $('#sortableKanbanBoards').sortable({
	    // axis: 'y',
	    opacity: 0.7,
	    update: function(event, ui) {
	        var list_sortable = $(this).sortable('toArray').toString();
	        $.ajax({
	            'url':'SortingColumn',
	            data: {list_order:list_sortable},
	            'success':function(data)
	            {
	                // var responseJSON = jQuery.parseJSON(data);
	                // alert('Invoice has been copy');
	                // window.location.assign(responseJSON.url);
	            }
	        });
	    }
	});

	
});
function search_opportunites(){
	var from_date = $("#chosse_date").find("#from_date").val();
	var to_date = $("#chosse_date").find("#to_date").val();
	$('#list_view_opportunites').hide();
	$('#export_excel_view').hide();
	$("#list_search_opportunites").load('SearchList',{from_date:from_date, to_date:to_date});
}
function add_opportunity(){
	$('#new_opportunity').modal();
	// $('#new_opportunity').modal();
	// $('#task_staf').load('LoadListStaff',function(){
 //        $("#task_staf").trigger("liszt:updated");
 //    } );
    // $('#status').load('LoadListStatus',function(){
    //     $("#status").trigger("liszt:updated");
    // } );
    $("#task_staf").select2();
    $("#contact_id").select2();
    var from_date = $("#view_deadline_task").datepicker({
        format: 'dd-mm-yyyy',
    }).on('changeDate', function(ev) {
        from_date.hide();
    }).data('datepicker');
    $(".datepicker").css("z-index", "99999");

}
function save_all_opportunity(type){
	var task_name = $("#task_name").val();
	var customer_id = $("#customer_id").val();
	var industry = $("#industry").val();
	var task_value = $("#task_value").val();
	var view_deadline_task = $("#chose_deadline").find("input").val();
	var contact_id = $("#contact_id").val();
	var task_staf = $("#task_staf").val();
	var status = $("#status").val();
	var task_note = $("#task_note").val();
	$.ajax({
        type:"POST",
        url:"SaveAllOpportunities", 
        data: {task_name:task_name, customer_id:customer_id, status:status, task_value:task_value, task_note:task_note, contact_id:contact_id, view_deadline_task:view_deadline_task, industry:industry, task_staf:task_staf},
        success:function(data){
        	if(data == "failure"){
        		alert('Added Opportunities Failure. Please check the required fields (*).');
        	} else {
	        	var opportunities_id = data;
	        	var option = {
	                data: { opportunities_id: opportunities_id }
	            }
	            $('#form_upload_images').ajaxSubmit(option);
	            // alert('The opportunity was successfully created');
	            if(type == 'board') {
	            	window.location.assign('board');
	            } else if(type == 'list'){
	            	window.location.assign('list');
	            }
	            
	        }
        }
    });
}
function load_contact_dropdown(){
	var customer_id = $("#customer_id").val();
	$('#contact_id').load("LoadListContact", { customer_id: customer_id },function(){
        $("#contact_id").trigger("liszt:updated");
    } );
    if(customer_id == 0){
        $('#popup_add_new_customers').modal();
    }
}
function save_add_column(){
	var column_name = $("#column_name").val();
	var color_picker = $("#color_picker").val();
	var list_sortable = $("#sortableKanbanBoards").sortable('toArray').toString();
	$.ajax({
        'url':'AddColumn',
        data: {column_name:column_name, color_picker: color_picker, list_sortable:list_sortable},
        'success':function(data)
        {
            alert('One column was successfully added.');
            $('#myModal').modal('toggle');
            window.location.assign('board');
        }
    });
}

function delete_column(column_id){
	if (confirm('Are you sure you want to delete this column ?')) {
		$.ajax({
	        'url':'DeleteColumn',
	        data: {column_id:column_id},
	        'success':function(data)
	        {
	            alert('The column was successfully deleted');
	            window.location.assign('board');
	        }
	    });
	}
}
function export_excel_view(){
	window.open('ExportExcelView', '_self');
}
function export_excel_search(){
	var from_date = $("#chosse_date").find("#from_date").val();
	var to_date = $("#chosse_date").find("#to_date").val();
	window.open('ExportExcelSearch?from_date=' + from_date + '&to_date=' + to_date+'', '_self');
}
function save_all_update_opportunity(){
	var opportunity_id = $("#opportunity_id_hidden").val();
	var name = $("#name").val();
	var customer_id = $("#customer_id").val();
	var contact_id = $("#contact_id").val();
	var industry = $("#industry").val();
	var value = $("#value").val();
	var deadline = $("#chosse_date").find("input").val();
	var status = $("#status").val();
	var note = $("#note").val();
	var staff = $("#staff").val();
	var invoice = $("#invoice").val();
	var quotation = $("#quotation").val();
    $.ajax({
        'url':'SaveAllUpdateOpportunity',
        data: {contact_id:contact_id, customer_id:customer_id, industry:industry, value:value, deadline:deadline, status:status,note:note,staff:staff,invoice:invoice,quotation:quotation},
        'success':function(data)
        {
            alert('The opportunity was successfully updated.');
            window.location.assign('list');
        }
    });

}
function edit_column(column_id){
	// // $('#popup_update_column').load('LoadFormUpdateColumn', { column_id: column_id}).modal();
	// // $('#popup_update_column').load('LoadFormUpdateColumn' + '#popup_update_column', function (response, status, xhr) {
 // //        if (status == "success") {
 // //            $('#popup_update_column').modal({ show: true });
 // //        }
 // //    });
 //    var url = "test";
	//  $('#popup_update_column').load(url,function(result){
	//   $('#test').modal({show:true});
	// });
	// // alert(column_id);
	alert("test");
}

