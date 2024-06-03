jQuery(document).ready(function(){
    document.getElementById('click_get_started').onclick = function () { 
      jQuery(this).html('<img src = ' + `${window.smack_nonce_object.imagePath}ajax-loader.gif`+ '>');
        var addons = [];
        jQuery.each(jQuery("input[name='offline']:checked"), function(){
            addons.push(jQuery(this).val());
        });
        
        if(addons.length == 0){
          window.location.replace(window.location.origin + ajaxurl+ '/../admin.php?page=com.smackcoders.csvimporternew.menu');
        }

        jQuery.each(addons, function (index, value) {
            var isLastElement = index == addons.length -1;
            var last_iteration = '';
            if (isLastElement) {
              last_iteration = 'yes';
            }
            jQuery.ajax({
              type: 'POST',
              url: smack_nonce_object.url,
              data: {
                'action' : 'install_plugins',
                'addons' : value,
                'last_iteration' : last_iteration,
                'all_addons' : addons,
                'securekey' : smack_nonce_object.nonce,
              },

              success: function(data){
                window.location.replace(window.location.origin + ajaxurl+ '/../admin.php?page=com.smackcoders.csvimporternew.menu');
              },
              error: function(errorThrown){
              }
            });
          });
    }
});