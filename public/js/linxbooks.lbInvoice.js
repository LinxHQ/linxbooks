var lbinvoice_line_items_updated = false;
var lbinvoice_discounts_updated = false;
var lbinvoice_new_line_item_added = false;
var lbinvoice_new_discount_added = false;
var lbinvoice_new_tax_added = false;

var invoice_sub_total = 0;
var invoice_total_discount= 0;
var invoice_total_after_discounts = 0;
var invoice_total_tax = 0;
var invoice_total_after_taxes = 0;
var invoice_total_paid = 0;
var invoice_total_outstanding = 0;

/**
 * Get formatted address lines 
 * 
 * @param jsonResponse address lines in JSON
 * 
 * @returns string formatted address lines in HTML
 */
function getInvoiceAddressLines(jsonResponse)
{
	if (jsonResponse != null)
	{
		var address_lines = jsonResponse.formatted_address_line_1;
		if (jsonResponse.formatted_address_line_2)
			address_lines += "<br/>" + jsonResponse.formatted_address_line_2;
		if (jsonResponse.formatted_address_line_3)
			address_lines += "<br/>" + jsonResponse.formatted_address_line_3;
		if (jsonResponse.formatted_address_line_4)
			address_lines += "<br/>" + jsonResponse.formatted_address_line_4;
		
		return address_lines;
	}
	
	return '';
}

/**
 * Update the user interface of address lines
 * 
 * @param jsonResponse
 */
function updateInvoiceAddressLines(jsonResponse)
{
	var address_lines = getInvoiceAddressLines(jsonResponse);
	
	if (address_lines != '')
	{
		$("#container-invoice-customer-address .editable").html(getInvoiceAddressLines(jsonResponse));
		$("#container-invoice-customer-address .editable").attr("class","editable editable-click");
	} else {
		$("#container-invoice-customer-address .editable").html("No address available");
		$("#container-invoice-customer-address .editable").attr("class","editable editable-click editable-empty");
	}
}

function updateAttentionUI(invoice_id, contact_id, text)
{
    var attention_editable = $("#LbInvoice_invoice_attention_contact_id_"+invoice_id);
    attention_editable.attr("data-value",contact_id);
    attention_editable.editable("setValue", contact_id);
    attention_editable.attr("class","editable editable-click");
    attention_editable.html(text);
}

/**
 * based on given response, store invoice totals to their respective variables
 *
 * @param responseJSON
 */
function getInvoiceTotals(responseJSON)
{
    invoice_sub_total = responseJSON.lb_invoice_subtotal;
    invoice_total_after_discounts = responseJSON.lb_invoice_total_after_discounts;
    invoice_total_after_taxes = responseJSON.lb_invoice_total_after_taxes;
    invoice_total_paid = responseJSON.lb_invoice_total_paid;
    invoice_total_outstanding = responseJSON.lb_invoice_total_outstanding;
    //console.log(invoice_sub_total, invoice_total_after_taxes);
}

/**
 * Update GUI with (new) invoice totals
 * Usually these values are just recently updated from the server
 */
function updateInvoiceTotalsUI(invoice_id)
{
    $("#invoice-subtotal-"+invoice_id).html(parseFloat(invoice_sub_total).toFixed(2));
    $("#invoice-total-"+invoice_id).html(parseFloat(invoice_total_after_taxes).toFixed(2));
    if ($("#"+invoice_id) != null)
        $("#"+invoice_id).html(parseFloat(invoice_total_paid).toFixed(2));
    if ($("#"+invoice_id) != null)
        $("#"+invoice_id).html(parseFloat(invoice_total_outstanding).toFixed(2));
}

/************************************* CORE COMPUTATION FUNCTIONS *************************************/

/**
 * calculate line item total
 *
 * @param quantity string
 * @param value string
 * @return total final total with 2 decimal places, as string
 *
 */
function calculateLineItemTotal(quantity, value)
{
    // convert quantity string to 2 decimal place value
    // convert value string to 2 decimal place value
    var quantity_float = parseFloat(quantity);
    var value_float = parseFloat(value);
    var total_float = quantity_float*value_float;

    return parseFloat(total_float).toFixed(2);
}

function calculateInvoiceSubTotal(grid_id)
{
    invoice_sub_total = 0;
    $('#' + grid_id +' .lbinvoice-line-items').each(function() {
        var el_field_name = $(this).attr("line_item_field");

        // if this is total field, add
        if (el_field_name == 'item-total') {
            invoice_sub_total += parseFloat($(this).val());
        }
    });
}

function calculateInvoiceTotalDiscount(grid_id)
{
    invoice_total_discount = 0;
    $('#' + grid_id +' .lbinvoice-discount').each(function() {
        var el_field_name = $(this).attr("line_item_field");

        // if this is total field, add
        if (el_field_name == 'item-total') {
            invoice_total_discount += parseFloat($(this).val());
        }
    });
}

function calculateInvoiceTotalTax(grid_id)
{
    invoice_total_tax = 0;
    $('#' + grid_id +' .lbinvoice-tax').each(function() {
        var el_field_name = $(this).attr("line_item_field");
        var line_item_pk = $(this).attr("line_item_pk");

        // if this is total field, add
        if (el_field_name == 'item-total') {
            var this_tax_total = ($("#lb_invoice_item_value_"+line_item_pk).val()/100)*invoice_total_after_discounts;
            $(this).val(parseFloat(this_tax_total).toFixed(2));
            invoice_total_tax += parseFloat(this_tax_total);
        }
    });
}

function calculateInvoiceTotalAfterDiscounts()
{
    invoice_total_after_discounts = parseFloat(invoice_sub_total) - parseFloat(invoice_total_discount);
}

function calculateInvoiceTotalAfterTaxes()
{
    invoice_total_after_taxes = parseFloat(invoice_total_after_discounts) + parseFloat(invoice_total_tax);
}

function calculateInvoiceTotalPaid()
{
    invoice_total_paid = 0;
}

function calculateInvoiceTotalOutstanding()
{
    invoice_total_outstanding = invoice_total_after_taxes - invoice_total_paid;
}

/**
 * recalculate all invoice totals
 * it doesn't call the server-side. it assumes that everything on the GUI is up-to-date.
 * If you want to get data from server first, better call refreshTotals();
 */
function calculateInvoiceTotals(invoice_id)
{
    var line_items_grid_id = 'invoice-line-items-grid-'+invoice_id;
    var discounts_grid_id = 'invoice-discounts-grid-'+invoice_id;
    var taxes_grid_id = 'invoice-taxes-grid-'+invoice_id;

    calculateInvoiceSubTotal(line_items_grid_id);
    calculateInvoiceTotalDiscount(discounts_grid_id);
    calculateInvoiceTotalAfterDiscounts();
    calculateInvoiceTotalTax(taxes_grid_id);
    calculateInvoiceTotalAfterTaxes();
    calculateInvoiceTotalOutstanding();
}

/************************************* LINE ITEMS FUNCTIONS *************************************/

/**
 * bind line items to events that might have caused by
 * changes done by user
 */
function bindLineItemsForChanges(grid_id)
{
	$('#' + grid_id +' .lbinvoice-line-items').each(function() {
		var elem = $(this);
		console.log('binding...'+$(this));

		// Save current value of element
		elem.data('oldVal', elem.val());

		// Look for changes in the value
		elem.unbind("propertychange keyup input paste", lineItemsChangeHandler);
		elem.bind("propertychange keyup input paste", lineItemsChangeHandler);
	});
}

function lineItemsChangeHandler(event) 
{
	lbinvoice_line_items_updated = true;
	
	// recalculation of line item totals
	var el = event.target;
	var el_field_name = $(el).attr("line_item_field");
	var line_item_pk = $(el).attr("line_item_pk");
    var invoice_id = $(el).attr("data_invoice_id");
    if (el_field_name == "item-value" || el_field_name == "item-quantity")
	{
		var el_total_fld = $("#lb_invoice_item_total_"+line_item_pk);
		var el_quantity_fld = $("#lb_invoice_item_quantity_"+line_item_pk);
		var el_value_fld = $("#lb_invoice_item_value_"+line_item_pk);
		var item_total = calculateLineItemTotal(el_quantity_fld.val(),el_value_fld.val());
		el_total_fld.val(item_total);

        // recalculation of invoice totals
        var grid_id = 'invoice-line-items-grid-'+invoice_id;
        calculateInvoiceTotals(invoice_id);
        updateInvoiceTotalsUI(invoice_id);
	}

    enableSaveButton(invoice_id);
}

/************************************* DISCOUNTS FUNCTIONS *************************************/

function submitLineItemsAjaxForm()
{
        $(".submit-btn-line-items-form").click();
        lbinvoice_line_items_updated = false;
}


/**
 * bind discounts to events that might have caused by
 * changes done by user
 */
function bindDiscountsForChanges(grid_id)
{
    $('#' + grid_id +' .lbinvoice-discount').each(function() {
        var elem = $(this);

        console.log('binding discount...'+$(this));

        // Save current value of element
        elem.data('oldVal', elem.val());

        // Look for changes in the value
        elem.unbind("propertychange keyup input paste", discountChangeHandler);
        elem.bind("propertychange keyup input paste", discountChangeHandler);
    });
}

function discountChangeHandler(event)
{
    lbinvoice_discounts_updated = true;

    // recalculation
    var el = event.target;
    var el_field_name = $(el).attr("line_item_field");
    var line_item_pk = $(el).attr("line_item_pk");
    var invoice_id = $(el).attr("data_invoice_id");
    if (el_field_name == "item-total")
    {
        var el_total_fld = $("#lb_invoice_item_total_"+line_item_pk);
        // recalculation of invoice totals

        calculateInvoiceTotals(invoice_id);
        updateInvoiceTotalsUI(invoice_id);
    }

    enableSaveButton(invoice_id);
}

function submitDiscountsAjaxForm()
{
        $(".submit-btn-discounts-form").click();
        lbinvoice_discounts_updated = false;
}

/************************************* TAXES FUNCTIONS *************************************/

function submitTaxesAjaxForm()
{
    $(".submit-btn-taxes-form").click();
}

/************************ GENERAL **********************************/

$(document).ready(function(){
	
});

function onConfirmInvoiceSuccessful(invoiceJSON)
{
    // Refesh Invoice no
    $("#invoice-number-container").html(invoiceJSON.lb_invoice_no);
    
    //Refesh status
    $("#invoice-header-container .ribbon-green").html(invoiceJSON.lb_invoice_status_code);
    $("#lb_invocie_status .editable").html(invoiceJSON.lb_invoice_status_code);
    $("#lb_invocie_status .editable").attr('data-value',invoiceJSON.lb_invoice_status_code);
    $("#lb_invocie_status .editable").editable('setValue',invoiceJSON.lb_invoice_status_code);
    
    $("#btn-confirm-invoice-"+invoiceJSON.lb_record_primary_key).remove();
}

function saveInvoice(invoice_id)
{
    if (lbinvoice_line_items_updated)
    {
        submitLineItemsAjaxForm(); // this when called when cascade saving discounts form, too
    } else if (lbinvoice_discounts_updated) {
        // ok, cascading fails because line items weren't modified
        // have to called manually
        submitDiscountsAjaxForm();
    } else {
        submitTaxesAjaxForm();
    }
}

function disableSaveButton(invoice_id)
{
    $("#btn-invoice-save-all-"+invoice_id).html("Already saved.");
    $("#btn-invoice-save-all-"+invoice_id).attr("disabled","disabled");
}

function enableSaveButton(invoice_id)
{
    $("#btn-invoice-save-all-"+invoice_id).html("<i class=\"icon-ok icon-white\"></i> Save");
    $("#btn-invoice-save-all-"+invoice_id).removeAttr("disabled");
}

function lbAppUILoadModal(invoice_id, title, load_url)
{
    var modal_element = $("#modal-holder-"+invoice_id);
    modal_element.find("#modal-header").html(title);
    modal_element.find("#modal-body").html(getLoadingIconHTML(false));
    modal_element.find("#modal-body").load(load_url);
    modal_element.modal("show");
}

function lbAppUIHideModal(invoice_id)
{
    var modal_element = $("#modal-holder-"+invoice_id);
    modal_element.modal('hide');
}

/**
 * NOW every 5 secs check if we need to do any auto save
 */
//

window.setInterval(function(){
	if (lbinvoice_line_items_updated) {
		lbinvoice_line_items_updated = false;
		submitLineItemsAjaxForm();
		console.log('line items form auto-submitted: '+lbinvoice_line_items_updated);
	}

    if (lbinvoice_discounts_updated) {
        lbinvoice_discounts_updated = false;
        submitDiscountsAjaxForm();
        console.log('discounts form auto-submitted.');
    }
		
}, 1000*5);