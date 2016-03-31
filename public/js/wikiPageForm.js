$(document).ready(function() {
	var update_took_place;
	var propertyChangeUnbound = false;
	
	/** Check if page title is updated **/
	$("#WikiPage_wiki_page_title").on("propertychange", function(e) {
	    if (e.originalEvent.propertyName == "value") {
	        //alert("WikiPage_wiki_page_title Value changed!");
	        update_took_place = true;
	    }
	});
	
	$("#WikiPage_wiki_page_title").on("input", function() {
	    if (!propertyChangeUnbound) {
	        $("#WikiPage_wiki_page_title").unbind("propertychange");
	        propertyChangeUnbound = true;
	    }
	    //alert("WikiPage_wiki_page_title Value changed!");
	    update_took_place = true;
	});
	// end checking page title
	
	/** Check if page tags is updated **/
	$("#WikiPage_wiki_page_tags").on("propertychange", function(e) {
	    if (e.originalEvent.propertyName == "value") {
	        //alert("WikiPage_wiki_page_tags Value changed!");
	        update_took_place = true;
	    }
	});
	
	$("#WikiPage_wiki_page_tags").on("input", function() {
	    if (!propertyChangeUnbound) {
	        $("#WikiPage_wiki_page_tags").unbind("propertychange");
	        propertyChangeUnbound = true;
	    }
	    //alert("WikiPage_wiki_page_tags Value changed!");
	    update_took_place = true;
	});
	// end checking page tags
	
	/** Check if page parent is updated **/
	$("#WikiPage_wiki_page_parent_id").change(function(e) {
	    //alert("WikiPage_wiki_page_parent_id Value changed!");
	    update_took_place = true;
	});
	// end checking page parent
	
	/** Check if page content is updated **/
	var content_editor = CKEDITOR.instances["WikiPage[wiki_page_content]"];
	
	content_editor.on( 'key', function() {
		//alert("wiki_page_content Value changed!");
	    update_took_place = true;
	});
	//end checking page content
	
	// NOW every 10 secs check if we need to do any auto save
	window.setInterval(function(){
		if (update_took_place) {
			update_took_place = false;
			//alert(baseUrl);
			// save wiki page
			CKEDITOR.instances["WikiPage[wiki_page_content]"].updateElement(); // update content from ckeditor to element
			$.post(baseUrl + '/index.php/wikiPage/autoSave', $("#wiki-page-form").serialize(), function(data){
				if (data.status == 'success') {
					wiki_page_id = data.wiki_page_id;
					message = 'Autosaved at ' + data.time;
					$('#WikiPage_wiki_page_id').val(wiki_page_id);
					$('#wiki-page-form-auto-save-message-top').html(message);
					$('#wiki-page-form-auto-save-message-bottom').html(message);
					$('#WikiPage_session_date').val(data.session_date);
				}
			}, 'json');
		}
			
	}, 1000*10);
});