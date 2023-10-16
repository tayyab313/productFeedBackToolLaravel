

$("#notification").click(function(){
    $("#notificationBox").toggleClass("d-none");
  })

  $("#listStyle").click(function(){
    $(".listStyleBox").removeClass("col-lg-4");
    $(".listStyleBox").removeClass("col-md-4");
    $(".group-card").addClass("d-flex");
    $(".group-card").addClass("listView");

  })
  $("#gridStyle").click(function(){
    $(".listStyleBox").addClass("col-lg-4");
    $(".listStyleBox").addClass("col-md-4");
    $(".group-card").removeClass("d-flex");
    $(".group-card").removeClass("listView");
  })

  $('.requestAccept').on('click', function() {
    var ids = $(this).attr('data-get-id');
    var request = $(this).attr('data-request');
    var token = $(this).attr('token');
    $.ajax({
        type: 'POST',
        url: request,
        data: {
            group_id: ids,
            is_join: 1,
            _token: token
        },
        success: function(data) {
            alert(data.message,
                // footer: '<a href="">Why do I have this issue?</a>'
            )
            setTimeout(() => {
                window.location.reload()
            }, 2000);
        },
        error: function(xhr) {
            if (xhr.responseJSON && xhr.responseJSON.errors && xhr.responseJSON
                .errors.comment) {
                var contentErrorMessage = xhr.responseJSON.errors.comment[0];
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: contentErrorMessage,
                    // footer: '<a href="">Why do I have this issue?</a>'
                })
            }
        }
    });

});
$('.requestReject').on('click', function() {
    var ids = $(this).attr('data-get-id');
    var request = $(this).attr('data-reject');
    var token = $(this).attr('token');
    $.ajax({
        type: 'POST',
        url: request,
        data: {
            group_id: ids,
            is_join: 0,
            _token: token
        },
        success: function(data) {
            alert(data.message,
                // footer: '<a href="">Why do I have this issue?</a>'
            )
            setTimeout(() => {
                window.location.reload()
            }, 2000);
        },
        error: function(xhr) {

        }
});
});


