<?php
    $url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];

    $parse_url = parse_url($url, PHP_URL_PATH);
	
    // get last arg of path (survey id)
    $survey_id = arg(2);
	$survey_results = civicrm_api("Survey","get", 
                    array ( 'sequential' =>'1', 
                            'version'=>3, 
                            'id' => $survey_id, 
                            'return' => 'title')
                            );
	
	//civicrm_initialize( );
    //require_once 'CRM/Campaign/BAO/Survey.php';
    //$voters = CRM_Campaign_BAO_Survey::getSurveyVoterInfo( $survey_id );
	
    $results = civicrm_api("SurveyVoter","get", 
                    array ( 'sequential' => '1', 
                            'version'=> 3 ,
							'debug'=>1,							
                            'id'=>$survey_id) 
                            );
    $survey_voters = $results['values'];
	include('civimobile.header.php');
?>
<script type="text/javascript" src="http://github.com/janl/mustache.js/raw/master/mustache.js"></script>
<script type="text/javascript">
	var template = $('#surveyTpl').html();
	//alert(template);
	$().crmAPI ('Survey','get',{'version' :'3', 'id': '1'}
          ,{ 
            ajaxURL: crmajaxURL,
            success:function (data){ 
				alert(data.values[1].title);
				var surveyName = data.values[1].title;
            }
   });
   alert(surveyName);
   var surveyData = {
		surveyName: "surveyName",
		blogURL: "http://coenraets.org"
	};
    var html = Mustache.to_html(template, surveyData);
	//alert(html);
	$('#surveyBlock').html(html);
</script>
<script id="surveyTpl" type="text">
<div data-role="page1" data-theme="c" id="jqm-survey">
	<div data-role="header" data-theme="a">
		<a href="#" data-rel="back" class="ui-btn-left" data-icon="arrow-l">Back</a>
		<h3>{{surveyName}}</h3>
    	<a href="<?php print url('civimobile') ?>" data-ajax="false" data-direction="reverse" data-role="button" data-icon="home" data-iconpos="notext" class="ui-btn-right jqm-home">Home</a>
    </div>
<p>Blog URL: <a href="{{blogURL}}">{{blogURL}}</a></p>
</div>
</script>
<div id="surveyBlock"></div>
<!--<div data-role="page" data-theme="c" id="jqm-contacts">
 <div data-role="header" data-theme="a">
    <a href="#" data-rel="back" class="ui-btn-left" data-icon="arrow-l">Back</a>
    <h3>{{surveyName}}</h3>
    	    <a href="<?php print url('civimobile') ?>" data-ajax="false" data-direction="reverse" data-role="button" data-icon="home" data-iconpos="notext" class="ui-btn-right jqm-home">Home</a>
    </div>
	<div data-role="content" id="contact-content"> 
	
		<div data-role="collapsible" data-collapsed="true" data-theme="f">
		<h3>Filter by location</h3>
		<input type="search" name="postcode" id="postcode" placeholder="Postcode"/>
			<div data-role="fieldcontain">
					<input type="checkbox" name="curLocation" id="useLocation" class="custom" />
					<label for="useLocation">Use current location</label>
			</div>   
		</div>
        <?php if ($results['count'] > 0) :?>
        <div data-role="content">
        <ul id="survey-respondents-list" data-role="listview" data-inset="true" >
        <li data-role="list-divider">Record Survey Respondents</li>
         <?php 	
         foreach($survey_voters as $key => $voter) { ?>
            <li role="option" tabindex="-1" data-theme="c" id="survey-respondent-<?php print $voter['id']; ?>" >
                <a href="<?php print url('civimobile/contact/').$voter['voter_id']; ?>" data-role="survey-respondent-<?php print $voter['voter_id']; ?>">
                <?php print $voter['voter_name']; ?></a>
            </li>
         <?php } ?>
         </ul>
         </div>
        <?php endif; ?>
    </div> 
</div>--> 
<?php require('civimobile.footer.php'); ?>