	<?php
    $url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];

    $parse_url = parse_url($url, PHP_URL_PATH);
    
    // Get logged in drupal user id
    global $user;
	civicrm_initialize( );
	require_once 'CRM/Core/Session.php';
	$session =& CRM_Core_Session::singleton( );
	$survey_results = civicrm_api("Survey","get", 
                    array ( 'sequential' =>'1', 
                            'version'=> 3 , 
                            'activity_type_id' => 28, 
							'created_id' => $session->get('userID'),
                            'return' => 'title')
                            );
    include('civimobile.header.php');
?>
<div data-role="page" data-theme="c" id="jqm-contacts">

 <div data-role="header" data-theme="a">
    <h3>Surveys</h3>
    	    <a href="<?php print url('civimobile') ?>" data-ajax="false" data-direction="reverse" data-role="button" data-icon="home" data-iconpos="notext" class="ui-btn-right jqm-home">Home</a>

  </div><!-- /header -->
	
		<div data-role="content" id="contact-content"> 
        <?php if ($survey_results['count'] > 0) :?>
        <div data-role="content">
        <ul id="main-survey-list" data-role="listview" data-inset="true" >
        <!--<li data-role="list-divider">Surveys</li>-->
         <?php 	
         $survey  = $survey_results['values'];
         foreach($survey as $key => $value) { ?>
            <li role="option" tabindex="-1" data-theme="c" id="survey-<?php print $value['id']; ?>" >
                <a href="<?php print url('civimobile/survey/').$value['id']; ?>" data-role="survey-<?php print $value['id']; ?>">
                <?php print $value['title']; ?></a>
            </li>
         <?php } ?>
         </ul>
         </div>
        <?php endif; ?>
    </div> 
</div> 

<?php require('civimobile.footer.php'); ?>