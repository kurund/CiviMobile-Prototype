<?php  // $Id: page.tpl.php,v 1.0 kylejaster Exp $ 
if(!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')):
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $civimobile_page_settings['language'] ?>" lang="<?php print $civimobile_page_settings['language'] ?>" >
  <head>
    <title><?php print $civimobile_page_settings['title'] ?></title>
    <?php print $civimobile_page_settings['head'] ?>
    <?php print $civimobile_page_settings['favicon'] ?>
    <?php print $civimobile_page_settings['styles'] ?>
    <?php print $civimobile_page_settings['scripts'] ?>

    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.0a3/jquery.mobile-1.0a3.min.css" />
    <script src="http://code.jquery.com/jquery-1.5.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.0a3/jquery.mobile-1.0a3.min.js"></script>
    <script src="<?php print $civimobile_page_settings['civicrm_base'];?>/../js/rest.js"></script>
    <script>
         var crmajaxURL = '<?php print base_path(); ?>civicrm/ajax/rest';
         var base_url =  '<?php print base_path(); ?>';
    </script>
    <script src="<?php print $civimobile_page_settings['civimobile_assets'];?>/js/base.js"></script>
  </head>
<body> 
<?php endif; 

function navbar ($back = false) {
echo "
    <div data-role='navbar'>
      <ul>
        <li><a href='".base_path()."civimobile/contact' class='ui-btn-active'>Contacts</a></li>
        <li><a href='".base_path()."civimobile/events'>Events</a></li>

      </ul>
    </div>";
 if ($back) {
   echo '<a href="#" class="ui-btn-active" data-rel="back" data-icon="arrow-l" class="ui-btn-right">Back</a>';
 }

}
?>
