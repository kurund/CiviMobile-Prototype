<?php
    $url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    $parse_url = parse_url($url, PHP_URL_PATH);
     include('civimobile.header.php');
?>
<div data-role="page" data-theme="c" id="jqm-contacts">

  <div id="jqm-contactsheader" data-role="header">
        <h3>Contacts proximity search</h3>
        <a href="<?php print base_path(); ?>civimobile" data-ajax="false" data-direction="reverse" data-role="button" data-icon="home" data-iconpos="notext" class="ui-btn-right jqm-home">Home</a>
	</div>
 
<div data-role="content" id="contact-content"> 
	<div class="ui-listview-filter ui-bar-c">
		<input type="search" name="postcode" id="postcode" placeholder="Postcode"/>
	</div>
	<div data-role="fieldcontain">
		<input type="checkbox" name="curLocation" id="useLocation" class="custom" />
		<label for="useLocation">Use current location</label>
	</div>   
</div>

  <div> 
          <a href="<?php print base_path(); ?>civimobile/contact" data-role="button">Back to contact list</a>
  </div>  
 
    	  <script language="javascript" type="text/javascript">
            
    		   	$(document).ready(function(){
     				// Add a click listener on the button to get the location data
       				$('#useLocation').click(function(){
              $('#postcode').val('');
     					 if (this.checked) {
                    $('#contacts').remove();
            				if (navigator.geolocation) {
                 				navigator.geolocation.getCurrentPosition(onSuccess, onError);
            				} else {
                 				// If location is not supported on this platform, disable it
                 				$('#useLocation').value = "Geolocation not supported";
                 				$('#useLocation').unbind('click');
                        //$('#postcode').show();
            				}
            		}else{
                  $('#contacts').remove();
                }
     				 });

             $('#postcode').change (function () {
                $('#useLocation').attr('checked', false);    
                $("#useLocation").checkboxradio("refresh");    
                $('#contacts').remove();
                searchContactByPostcode ($(this).val());
              }); 

     				function onSuccess(location) {  			
  						console.log('latitude' + location.coords.latitude );
  						console.log('longitude' + location.coords.longitude );
  						console.log('Accuracy: ' + location.coords.accuracy);
  						searchContactByGeoLocation(location);
					}
     				 
					// Error function for Geolocation call
					function onError(msg){
						$('#locationResult').html("Geolocation not supported");
	  				$('#useLocation').unbind('click');
					}
 
				});

function searchContactByPostcode(postcode){
      $.mobile.showPageLoadingMsg( 'Searching' );
      console.log(postcode)
      if(postcode != null){
        $().crmAPI ('Address','get',{'version' :'3', 'postal_code' : postcode}
          ,{
           ajaxURL: crmajaxURL,
           success:function (data){ 
            if(data.count != 0){
              $('#contact-content').append('<ul id="contacts" data-role="listview" data-inset="false" data-filter="false" ></ul>');
              $.each(data.values, function(key, value) {
                if(value.contact_id != null){
                  $().crmAPI ('Contact','getsingle',{'version' :'3', 'contact_id' :value.contact_id}
                      ,{ 
                       ajaxURL: crmajaxURL,
                       success:function (data){    
                          buildList(data);
                          $('#contacts').listview();
                       }
                  });
                }
              });
            }  
          }
        }); 
      }     
      $.mobile.hidePageLoadingMsg( );
}        

function searchContactByGeoLocation (params){
    $.mobile.showPageLoadingMsg( 'Searching' );
    $().crmAPI ('Location','get_by_location',{'version' :'3', 'latitude': params.coords.latitude, 'longitude' :  params.coords.longitude, 'distance' : 200, 'units' : 'miles'}
          ,{ 
            ajaxURL: crmajaxURL,
            success:function (data){ 
              if (data.count == 0) {                
                 $('#contacts').hide();    
              }
              else {
                $('#contact-content').append('<ul id="contacts" data-role="listview" data-inset="false" data-filter="false" ></ul>');
                $.each(data.values, function(key, value) {
                    buildList(value);
                });
                $('#contacts').listview();
              }
              $.mobile.hidePageLoadingMsg( );             
          }
   });
}


function buildList(data){
  $('#contacts').append('<li role="option" tabindex="-1" data-ajax="false" data-theme="c" id="contact-'+data.contact_id+'" ><a href="'+base_url+'civimobile/contact/'+data.contact_id+'" data-role="contact-'+data.contact_id+'">'+data.display_name+'</a></li>');
}
	
        
</script>
</div> 
<?php require('civimobile.footer.php'); ?>
