<?php
    $url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    $parse_url = parse_url($url, PHP_URL_PATH);
    
     include('civimobile.header.php');
?>
<div data-role="page" data-theme="c" id="jqm-contacts">

  <div id="jqm-contactsheader" data-role="header">
        <h3>Search Contacts</h3>
        <a href="/civimobile" data-ajax="false" data-direction="reverse" data-role="button" data-icon="home" data-iconpos="notext" class="ui-btn-right jqm-home">Home</a>
		<!-- <a href="#" id="add-contact-button" data-role="button" data-icon="plus" class="ui-btn-left jqm-home">Add</a> 
		<a href="#" id="back-contact-button" data-role="button" data-icon="arrow-l" class="ui-btn-left jqm-home" style="display:none">Back</a>
		-->
 </div>
 
<div data-role="content" id="contact-content"> 
  	<div class="ui-listview-filter ui-bar-c">
 	<div data-role="fieldcontain">
			<input type="checkbox" name="checkbox-1" id="useLocation" class="custom" />
			<label for="useLocation">Use current location</label>
	    </fieldset>
	 </div>   
	 </div>
	  <div id="locationResult"></div>
 </div>


  <div> 
          <a href="/civimobile/contact" data-role="button">Back to contact list</a>
  </div>  
 
    	  <script language="javascript" type="text/javascript">

    		   	$(document).ready(function(){

     				// Add a click listener on the button to get the location data
     				$('#useLocation').click(function(){
   					 if (this.checked) {
          				if (navigator.geolocation) {
               				navigator.geolocation.getCurrentPosition(onSuccess, onError);
          				} else {
               				// If location is not supported on this platform, disable it
               				$('#useLocation').value = "Geolocation not supported";
               				$('#useLocation').unbind('click');
          				}
          			}
     				});

     				function onSuccess(location) {
						//var message = document.getElementById("locationResult");
						//message.innerHTML ="<img src='http://maps.google.com/staticmap?center=" + location.coords.latitude + "," + location.coords.longitude + "&size=300x200&maptype=hybrid&zoom=16&key=YOURGOOGLEAPIKEY' />";
						/*
						message.innerHTML+="<p>Longitude: " + location.coords.longitude + "</p>";
						message.innerHTML+="<p>Latitude: " + location.coords.latitude + "</p>";
						message.innerHTML+="<p>Accuracy: " + location.coords.accuracy + "</p>";
						 */
						console.log('latitude' + location.coords.latitude );
						console.log('longitude' + location.coords.longitude );
						console.log('Accuracy: ' + location.coords.accuracy);

						contactSearch(location);
					}
     				 
					// Error function for Geolocation call
					function onError(msg){
						$('#locationResult').html("Geolocation not supported");
	  					$('#useLocation').unbind('click');
					}
 
				});

function contactSearch (params){
    $.mobile.showPageLoadingMsg( 'Searching' );
    $().crmAPI ('ContactMobile','get',{'version' :'3', 'latitude': params.coords.latitude, 'longitude' :  params.coords.longitude, 'distance' : 2000}
          ,{ 
            ajaxURL: crmajaxURL,
            success:function (data){ 
              if (data.count == 0) {
                cmd = null;
                $('#contacts').hide();                                             
              }
              else {
                cmd = "refresh";
                $('#contacts').show();
                $('#contacts').empty();
              }

            $('#contact-content').append('<ul id="contacts" data-role="listview" data-inset="false" data-filter="false" ></ul>');
  			$.each(data.values, function(key, value) {
     			$('#contacts').append('<li role="option" tabindex="-1" data-ajax="false" data-theme="c" id="contact-'+value.contact_id+'" ><a href="/codesprint/civimobile/contact/'+value.contact_id+'" data-role="contact-'+value.contact_id+'">'+value.display_name+'</a></li>');
   			});
           	$.mobile.hidePageLoadingMsg( );
           	$('#contacts').listview(); 

          }
   });
}
	
        
</script>


</div> 

<?php require('civimobile.footer.php'); ?>
