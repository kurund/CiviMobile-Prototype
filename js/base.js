$().crmAPI ('Event','get',{'version' :'3', }
  ,{ success:function (data){    
      $.each(data, function(key, value) {
        alert('<li>'+value+'</li>');
        });
    }
});

function civimobileCreatePage (json) {
    
    }

$(document).ready(function() {
    $('a').live('click' function(){
    alert('clicked');
    linkURL = $(this).attribute('href');
    $.getJSON(linkURL, function(data) {
    $(document).append('<div data-role="page" data-theme="b" id="jqm-events">');
    });

});