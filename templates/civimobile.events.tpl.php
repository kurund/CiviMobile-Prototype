<?php require('civimobile.header.php'); ?>

<div data-role="page" data-theme="c" id="jqm-events"> 
<script>
$(function (){
      $().crmAPI ('Event','get',{'version' :'3' }
        ,{ 
          ajaxURL: crmajaxURL,
          success:function (data){
            $('#event-content').html('<ul id="events-list" data-role="listview" data-inset="true" data-filter="false" ></ul>');
            $.each(data.values, function(key, value) {
              $('#events-list').append('<li role="option" tabindex="-1" data-theme="c" id="event-'+value.id+'" ><a href="'+base_url+'civimobile/participants&event_id='+value.id+'" data-role="participants-'+value.id+'">'+value.title+'</a></li>');
              });
            $('#events-list').listview();
            },
         }
      );
});
</script>
	<div id="jqm-homeheader">
        <div data-role="header" data-theme="a">
            <h3>Events</h3>
            	    <a href="/civimobile" data-ajax="false" data-direction="reverse" data-role="button" data-icon="home" data-iconpos="notext" class="ui-btn-right jqm-home">Home</a>

        </div>
	</div> 
	
	<div data-role="content" id="event-content"> 
	</div>
	<div data-role="footer" data-id="global-footer" data-position="fixed" data-theme="c">
	<div data-role="navbar" data-theme="a">
      <ul>
        <li><a href="/civimobile/contact" data-ajax="false" data-icon="search">Contacts</a></li>
        <li><a href="/civimobile/events"  data-ajax="false" data-icon="grid">Events</a></li>
      </ul>
    </div><!-- /navbar -->
    </div><!-- /footer --> 
</div> 

<?php require('civimobile.footer.php'); ?>
