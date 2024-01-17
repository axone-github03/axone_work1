$("#inquiry_architects_count_user_id").select2({
    ajax: {
        url: ajaxInquiryArchitectsCountSearchUser,
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
    placeholder: 'Search for a user',

});

function getInquiryCount() {

    $("#inquiryCount").html("Loading...");
    $("#nonPrimeArchitectsCount").html("Loading...");
    $("#primeArchitectsCount").html("Loading...");
    $("#inquiryConversionRatio").html("Loading...");

    $.ajax({
        type: 'POST',
        url: ajaxInquiryArchitectsCountData,
        data: {
            "_token": csrfToken,
            "start_date": $("#inquiry_architects_count_start_date").val(),
            "end_date": $("#inquiry_architects_count_end_date").val(),
            "user_id": $("#inquiry_architects_count_user_id").val(),

        },
        success: function(resultData) {



            if (resultData['status'] == 1) {

                $("#inquiryCount").html(resultData['inquiry_count']);
                $("#nonPrimeArchitectsCount").html(resultData['non_prime_architects_count']);
                $("#primeArchitectsCount").html(resultData['prime_architects_count']);

                $("#nonPrimeElecriciansCount").html(resultData['non_prime_electricians_count']);
                $("#primeElecriciansCount").html(resultData['prime_electricians_count']);

                $("#inquiryCountMateialSent").html(resultData['inquiry_material_sent']);
                $("#inquiryCountRejected").html(resultData['inquiry_rejected']);
                $("#inquiryCountNonPotential").html(resultData['inquiry_non_potential']);
                $("#inquiryConversionRatio").html(resultData['conversion_ratio']);


            } else {

                toastr["error"](resultData['msg']);

            }
        }
    });

}

$('#inquiry_architects_count_start_date,#inquiry_architects_count_end_date,#inquiry_architects_count_user_id').on('change', function() {
    getInquiryCount();

});
getInquiryCount();