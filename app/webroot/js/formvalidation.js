function validateForm(form, rules)
{
  //clear out any old errors
  var isErrorExist = false;
  jQuery(".validation_error").remove();
  
  jQuery("#jsErrors").html("");
  jQuery("#jsErrors").slideUp();
  jQuery(".error-message").hide();  
  
  //loop through the validation rules and check for errors
  jQuery.each(rules, function(field)
  {    
      var val = jQuery.trim(jQuery("#" + field).val());    
      jQuery.each(this, function()
      {        
          //check if the input exists
          if(jQuery("#" + field).attr("id") != undefined)
          {            
              var valid = true;
              if(this['allowEmpty'] && val == '')
              {
                  //do nothing
              }
              else if(this['rule'].match(/^range/))
              {
                  var range = this['rule'].split('|');
                  if(val < parseInt(range[1]))
                  {
                      valid = false;
                  }
                  if(val > parseInt(range[2]))
                  {
                      valid = false;
                  }
              }
              else if(this['negate'])
              {
                  if(val.match(eval(this['rule'])))
                  {
                      valid = false;
                  }
              }
              else if(!val.match(eval(this['rule'])))
              {
                  valid = false;
              }
              /*if(!val.match(eval(this['rule']))){
                alert("rule not matched");
              }else{
                alert("rule matched"+this['message']);
              }*/
              
              if(!valid)
              {        
                //add the error message
                //jQuery("#jsErrors").append("<li>" + this['message'] + "</li>");
                //jQuery("#"+field).append("<div class='validation_error'>" + this['message'] + "</div>");                
                jQuery("#" + field).parent().append("<div class='validation_error'>" + this['message'] + "</div>");
                isErrorExist = true;
                
                //highlight the label
                //jQuery("label[for='" + field + "']").addClass("error");
                //jQuery("#" + field).parent().addClass("validation_error");
              }
          }
      });
  });
  
  //if(jQuery("#jsErrors").html() != "")
  if(isErrorExist)
  {    
      /*var data = jQuery("#jsErrors").html();    
      var temp = "<ul><h3>Oops! Something went wrong.</h3>"+data+"</ul>";    
      jQuery("#jsErrors").empty();
      jQuery("#jsErrors").append(temp); 
      jQuery("#jsErrors").wrapInner("<div class='errors'></div>");
      jQuery("#jsErrors").slideDown();*/
      return false;
  }
  return true;
}