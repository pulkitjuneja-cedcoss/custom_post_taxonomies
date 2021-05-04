jQuery(document).ready(function () {
    
    jQuery('#btn').on('click', function () {
       var post = jQuery("#post").val();
      var taxonomy =  jQuery("#taxonomy").val();
      var column =  jQuery("#column").val();
      jQuery.ajax({
        type : "post",
        url : custom_post_script_obj.url,
      // jQuery.post(custom_post_script_obj.url,{
      //   action: 'save_date',
        data : {action: "save_data", post : post, taxonomy:taxonomy,column:column},
                   
       },function(){
           console.log('done')
       })
    });

  //   jQuery('#btn').on('click', function () {
  //     jQuery.post(wporg_meta_box_obj.url,{
  //      action: 'wporg_save_postdata',               // POST data, action
  //      //wporg_field_value: $('#btn').val() // POST data, wporg_field_value

  //     },function(){
  //         console.log('done')
  //     })
  //  });
})