// This file contains all the common javascript functions.
/**
    * @Method : changeCheckboxStatus
    * @Purpose:This method is used to change checkbox status.
    * @Param: formObj
    * @Return: none
**/
function changeCheckboxStatus(formObj)
{
	selectAll = formObj.elements['selectAll'];
	
	alert(selectAll)
	
	var len = "";
	if(formObj.elements['box[]']){
	len = formObj.elements['box[]'].length;
	}
	if (len == undefined) {
		var elementsLen = formObj.elements.length;
		var len = 0;
		for (i = 0; i < elementsLen; i++)	{
			obj = formObj.elements[i];
			if (obj.name == "box[]") {
				len++;
			}
		}

		if (len == 1){
			var e = formObj.elements['box[]'];
			if (selectAll.checked) {
				e.checked = true;
			}
			else {
				e.checked = false;
			}
		}
	}
	else if (len > 1) {
		for (var i = 0; i < len; i++) {
			var e = formObj.elements['box[]'][i];
			if (selectAll.checked) {
				e.checked = true;
			}
			else {
				e.checked = false;
			}
		}
	}
}

/**
    * @Method : toggleCheck
    * @Purpose:This method is used to toggle checkbox.
    * @Param: formObj
    * @Return: none
**/
function toggleCheck(formObj) {
	var selectAll = formObj.elements['selectAll'];
	objCheckBoxes = null;
	if(document.getElementsByName('box[]')){
	var objCheckBoxes = document.getElementsByName('box[]');
	}
	var count = 0;
    	for (i = 0; i < objCheckBoxes.length; i++) {
		var e = objCheckBoxes[i];
		if(e.checked) {
		  count++;
		}
	}
	if(objCheckBoxes.length == count){
		selectAll.checked = true;
	}else{
		selectAll.checked = false;
	}
}

/**
    * @Method : atleastOneChecked
    * @Purpose:This method is used to check that atleast one checkbox is checked.
    * @Param: formObj
    * @Return: none
**/
function atleastOneChecked(message) {
	if(document.getElementsByName('box[]')){
	var objCheckBoxes = document.getElementsByName('box[]');
	var count = 0;
    	for (i = 0; i < objCheckBoxes.length; i++) {
		var e = objCheckBoxes[i];
		if(e.checked) {
		  count++;
		}
	}
    	if(count <= 0){ 
		alert("Please select atleast one checkbox.");
		return false;
	}else{
		return confirm(message);
	}
	}
	return true;
}

function selectDeselectAllChk(mainChk, className)
{
	//This function is used to select/deselect all the required checkboxes
	if(jQuery("#"+mainChk).is(":checked"))
	{
		jQuery("."+className).attr("checked", true);
	}
	else
	{
		jQuery("."+className).attr("checked", false);
	}
}

function isRecordSelected(className, selectRecordDivID, confirmMsgDivID, formName)
{
	//This function is used to check whether the user has been selected any record or not
	if(jQuery("."+className).is(":checked"))
	{
		commonConfirmDialogSubmitForm(confirmMsgDivID, formName);
	}
	else
	{
		commonMessageDialog(selectRecordDivID);
	}
	return false;
}

/**Function By Ashish Starts**/
function updateRecords(dval,frmName){
  if(dval > 0 || dval != ''){
  
    jQuery('#' + frmName).submit();
  
    /*var dealre = promptCheckOne(frmName,dval);
    if(dealre){
      jQuery('#' + frmName).submit();
    }*/
  }
}

function promptCheckOne(frmName,doAction)
{
  var flag=0;
  var actionText = doAction;
  if(doAction=='1'){
    actionText = 'Activate';
  }else if(doAction=='2'){
    actionText = 'Deactivate';
  }else if(doAction=='3'){
    actionText = 'Delete';
  }
  
  for (var i = 0; i < document.getElementById(frmName).elements.length; i++) 
  {
    if(document.getElementById(frmName).elements[i].checked == true)
    {
      flag=1;
    }
  }
  
  if(flag==1)
  {
    if(frmName==='listAppointmentForm'){
        if(actionText=='Activate')
        {
            actionText = 'Pending';
        }
        else if(actionText=='Deactivate')
        {
            actionText = 'Closed';
        }
        if(confirm('Are you sure that you want to mark selected records as ' + actionText + '?')){
            return true;
        }else{
            return false;
        }
    }else{
        if(confirm('Are you sure you want to ' + actionText + ' selected records?')){
            return true;
        }else{
            return false;
        }
    }
  }else{
    alert("Please select atleast one record");
    return false;
  }
}

function setPagingLimit(frmName)
{
  jQuery('#' + frmName).submit();
}                            



$("body").delegate( "#checkallBoxes", "change", function(event) {

    if($(this).is(':checked')) {
    
        $('.rowsCheckbox').prop('checked', true);
    } else {
    
        $('.rowsCheckbox').prop('checked', false);
    }
});

/**Function By Ashish Ends**/