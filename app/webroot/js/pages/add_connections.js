
function getFileNumberField(checkConnectionType)
{
    if(checkConnectionType=='parent') {

        $('.selectParentRadio').removeClass('hide');

        $('.selectChildCheckbox').addClass('hide');
        $('.selectChildCheckAll').addClass('hide');
        $('.selectChildCheckbox input').removeAttr('checked');
        $('.selectChildCheckAll input').removeAttr('checked');
    } else {

        $('.selectChildCheckbox').removeClass('hide');
        $('.selectChildCheckAll').removeClass('hide');

        $('.selectParentRadio').addClass('hide');
        $('.selectParentRadio input').removeAttr('checked');
    }
}

$(document).ready(function(){

    $("body").delegate("input[name='connectionType']", "change", function(event) {

        var checkConnectionType = $("input[name='connectionType']:checked").val();
        getFileNumberField(checkConnectionType)
    });

    var checkConnectionType = $("input[name='connectionType']:checked").val();
    getFileNumberField(checkConnectionType);
})

function updateConnections(doAction, frmName)
{
    var flag=1;

    /*for (var i = 0; i < document.getElementById(frmName).elements.length; i++)
    {
        if(document.getElementById(frmName).elements[i].checked == true)
        {
            flag=1;
        }
    }*/

    if(flag==1)
    {
        if(confirm('Are you sure you want to ' + doAction + ' selected records?')){
            jQuery('#' + frmName).submit();
        }
    }else{
        alert("Please select atleast one record");
        return false;
    }
}