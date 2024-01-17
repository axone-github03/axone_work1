 $("#order_sales_channel_partner_type").select2({
     minimumResultsForSearch: Infinity
 });



 function getOrderCount() {

     $("#ordersCount").html("Loading...");
     $("#ordersAmount").html("Loading...");
     $("#ordersDispatchedAmount").html("Loading...");

     $.ajax({
         type: 'POST',
         url: ajaxSaleOrderCount,
         data: {
             "_token": csrfToken,
             "channel_partner_type": $("#order_sales_channel_partner_type").val(),
             "channel_partner_user_id": $("#order_sales_channel_partner_user_id").val(),
             "sales_user_id": $("#order_sales_sales_user_id").val(),
             "start_date": $("#order_sales_start_date").val(),
             "end_date": $("#order_sales_end_date").val(),

         },
         success: function(resultData) {



             if (resultData['status'] == 1) {

                 $("#ordersCount").html(resultData['order_count']);
                 $("#ordersAmount").html(resultData['order_total_amount']);
                 $("#ordersDispatchedAmount").html(resultData['order_dispateched_amount']);


             } else {

                 toastr["error"](resultData['msg']);

             }
         }
     });

 }

 $('#order_sales_start_date,#order_sales_end_date,#order_sales_channel_partner_user_id,#order_sales_sales_user_id,#order_sales_channel_partner_type').on('change', function() {
     getOrderCount();

 });

 $('#order_sales_channel_partner_type').on('change', function() {

    $("#order_sales_channel_partner_user_id").empty().trigger('change');
    $("#order_sales_sales_user_id").empty().trigger('change');

 });



 $("#order_sales_channel_partner_user_id").select2({
     ajax: {
         url: ajaxSaleOrderSearchChannelPartner,
         dataType: 'json',
         delay: 0,
         data: function(params) {
             return {
                 "type": function() {
                     return $("#order_sales_channel_partner_type").val();
                 },
                 q: params.term, // search term
                 page: params.page
             };
         },
         processResults: function(data, params) {
             // parse the results into the format expected by Select2
             // since we are using custom formatting functions we do not need to
             // alter the remote JSON data, except to indicate that infinite
             // scrolling can be used
             params.page = params.page || 1;
             return {
                 results: data.results,
                 pagination: {
                     more: (params.page * 30) < data.total_count
                 }
             };
         },
         cache: false
     },
     placeholder: 'Search for channel partner',

 });


 $("#order_sales_sales_user_id").select2({
     ajax: {
         url: ajaxSaleOrderSearchUser,
         dataType: 'json',
         delay: 0,
         data: function(params) {
             return {

                 q: params.term, // search term
                 page: params.page
             };
         },
         processResults: function(data, params) {
             // parse the results into the format expected by Select2
             // since we are using custom formatting functions we do not need to
             // alter the remote JSON data, except to indicate that infinite
             // scrolling can be used
             params.page = params.page || 1;
             return {
                 results: data.results,
                 pagination: {
                     more: (params.page * 30) < data.total_count
                 }
             };
         },
         cache: false
     },
     placeholder: 'Search for user',

 });

 getOrderCount();