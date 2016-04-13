function getLoadingIconHTML(with_text)
{
    var html = '<img src="/images/loading.gif"/>';
    if (with_text)
    {
        html += '&nbsp;<b>Loading...</b>';
    }
    return html;
}

function setDashboardStyle() {
	$('#content').css({"background":"none", "border": "0", "border-radius": "0px", "box-shadow": "none"});
}

function workspaceLoadContent(url) {
	$("#page").append('<div id="workspace-loader-icon" style="z-index: 9999; position: fixed; top: 5px; left: 600px; background-color: #FFFFFF"><img src="'+BASE_URL+'/images/loading.gif"/> <b>Loading...</b></div>');
	removeWorkspaceClickEvent(null);

	$.get(workspaceTransformUrl(url), function(data) {
		$('#content').removeAttr('style');
		$("#content").html(data);
		$('#page #workspace-loader-icon').remove();
		if($("#content #project-tiles-container").html() != undefined) {
			setDashboardStyle();
		}
		//$("#content").show();
		addWorkspaceClickEvent(null);
		$('html, body').animate({ scrollTop: 0 }, 600);
	});
}

function workspacePushState(url) {
	window.history.pushState('{"url": "' + workspaceTransformUrl(url) + '"}',
			"page main", url);
}

function workspaceTransformUrl(url) {
	url = urlInsertParam(url, 'workspace', '1');
	url = urlInsertParam(url, '_', uniqid());
	return url;
}

function addWorkspaceClickEvent(container_id) {
	var el;
	if (container_id == null) {
		el = 'a[data-workspace="1"]';
	} else {
		el = '#' + container_id + ' a[data-workspace="1"]';
	}
	$(el).each(function(index, value) {

		$(this).click(function(e) {
			var url = $(this).attr("href");
			// make the ajax call
			workspaceLoadContent(url);
			// add state for new page
			workspacePushState(url);
			return false;
		});
	});
}

function removeWorkspaceClickEvent(container_id) {
	var el;
	if (container_id == null) {
		el = 'a[data-workspace="1"]';
	} else {
		el = '#' + container_id + ' a[data-workspace="1"]';
	}
	$(el).each(function(index, value) {
		// this.addEventListener('onclick', change_my_url, false);
		$(this).unbind('click');
	});
}

function resetWorkspaceClickEvent(container_id)
{
	removeWorkspaceClickEvent(container_id);
	addWorkspaceClickEvent(container_id);
}

function addWorkspaceClickEventToElement(element)
{
	if ($(element).get(0).tagName == 'A' && $(element).attr('data-workspace') == 1)
		$(element).click(function(e) {
			var url = $(element).attr("href");
			// make the ajax call
			workspaceLoadContent(url);
	
			// add state for new page
			workspacePushState(url);
			return false;
		});
}

function uniqid() {
	return 'xxxxxxxyxxxxxxxxxxxxxyxxxxxx'.replace(/[xy]/g, function(c) {
		var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
		return v.toString(16);
	});
}

function urlInsertParam(url, key, value) {
	var urlHashSplit = url.split('#');
	var urlParamSplit = url.split('?');
	var newUrl = '';

	if (urlParamSplit.length >= 2) {
		newUrl = urlHashSplit[0] + '&' + key + '=' + value;
	} else {
		newUrl = urlHashSplit[0] + '?' + key + '=' + value;
	}

	if (urlHashSplit.length >= 2) {
		newUrl += '#' + urlHashSplit[1];
	}

	return newUrl;
}

$(document).ready(function() {
	window.addEventListener('popstate', function(event) {
		var data = event.state;
		var url = '';
		// console.log(data);
		data = JSON.parse(data);
		if (data != null) url = data.url;
		// alert("URL to visit:" + data.url);
		if (url.indexOf("workspace=1") >= 0)
			workspaceLoadContent(url);
	});

	// When page is load
	// always specify its state object in history as called from
	// workspace
	workspacePushState(document.location.pathname);
	addWorkspaceClickEvent(null);
	
	// global search form
	$("#linx-global-search").typeahead({
		minLength: 3,items:20,
	    source: function (query, process) {
	        return $.getJSON(BASE_URL + '/index.php/site/search', { query: query }, function (data) {
	        	return process(data.options);
	        });
	    },
	    updater: function(item) {
	    	var linx_type = $(item).attr('data-linx-type');
	    	var linx_href = $(item).attr('href');
	    	if (linx_type == 'linx-document' || linx_type == 'linx-resource-link')
	    	{
	    		window.open(linx_href, '_new');
	    		//document.location = linx_href;
	    	} else {
	    		workspaceLoadContent(linx_href);
	    		workspacePushState(linx_href);
	    	}
	    	return $(item).attr('title');
	    },
	    highlighter: function(item){
	    	var linx_type = $(item).attr('data-linx-type');
	    	var temp = '<strong>';
	    	switch (linx_type)
	    	{
	    		case 'linx-document':
	    			temp += 'Document';
	    			break;
	    		case 'linx-resource-link':
	    			temp += 'Link';
	    			break;
	    		case 'linx-task':
	    			temp += 'Task';
	    			break;
	    		case 'linx-wiki-page':
	    			temp += 'Wiki';
	    			break;
	    	}
	    	temp+= '</strong><br/>';
	    	temp+= $(item).html()
	    	return temp;
	    }
	}); // end global search form

    // tooltip
    $(".lb-tooltip-right").tooltip({placement: 'right'});
    $(".lb-tooltip-left").tooltip({placement: 'left'});
    $(".lb-tooltip-top").tooltip({placement: 'top'});
    $(".lb-tooltip-bottom").tooltip({placement: 'bottom'});
});