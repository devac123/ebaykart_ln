Drupal.behaviors.custom_behavior = {    
    attach: function (context, settings) {
        jQuery('.getName',context).click(function(){
            jQuery('.username').toggle()
        }) 
    },
    detach: function(context,settings){
        jQuery('.getName',context).click(function(){
            jQuery('.username').toggle()
        })
    }
};


