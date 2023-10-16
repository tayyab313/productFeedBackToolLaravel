
$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

$.validator.addMethod("fileExtension", function(value, element) {
    // Get the file extension
    var fileExtension = value.split('.').pop().toLowerCase();

    // Allowed file extensions
    var allowedExtensions = ["pdf", "doc", "docx"];

    return $.inArray(fileExtension, allowedExtensions) !== -1;
}, "Please choose a valid file extension (pdf, doc, docx).");

$.validator.addMethod("fileSize", function(value, element) {
    // Get the file size in bytes
    var fileSize = element.files[0].size;

    // Maximum file size (in bytes)
    var maxSize = 1048576; // 1MB

    return fileSize <= maxSize;
}, "File size must not exceed 1MB.");
// Add the custom extension rule
$.validator.addMethod("extension", function(value, element, param) {
    param = typeof param === "string" ? param.replace(/ /g, '') : "";
    return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
}, "Please choose a valid file extension.");
$(".save-form").validate({
    rules: {
        title: {
            required: true
        },
        description: {
            required: true
        },
        category: {
            required: true
        },
        attachments: {
            required: true,
        }
    },
    messages: {
        description: {
            required: "Description is required."
        },
        category: {
            required: "Category is required."
        },
        attachments: {
            required: "Please choose a file to upload.",
        }
    },
    errorPlacement: function (error, element) {
        // error.appendTo(element.closest(".form-floating").find(".error-container"));
    },
    submitHandler: function(form) {
        // Serialize the form data
        var formData = new FormData(form);
        $.ajax({
            url: $(form).attr('action'),
            type: $(form).attr('method'),
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                Swal.fire({
                    title: 'Success',
                    text: response.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
                // window.location.href = "feedback/listing";


            },
            error: function(xhr, status, error) {
                if (xhr.status === 422) {
                    // Handle Laravel validation errors
                    var errors = xhr.responseJSON.errors;
                    var message = [];
                    var index = 1;
                    for (var key in errors) {
                        if (errors.hasOwnProperty(key)) {
                            message.push(index + '. ' + errors[key][0]);
                            index++;
                        }
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: message,
                    })
                } else {

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'An error occurred while processing your request.',
                    })
                }
            }
        });
    }
});
$(".update-form").validate({
    rules: {
        title: {
            required: true
        },
        description: {
            required: true
        },
        category: {
            required: true
        }
    },
    messages: {
        description: {
            required: "Description is required."
        },
        category: {
            required: "Category is required."
        }
    },
    errorPlacement: function (error, element) {
        // error.appendTo(element.closest(".form-floating").find(".error-container"));
    },
    submitHandler: function(form) {
        // Serialize the form data
        var formData = new FormData(form);
        $.ajax({
            url: $(form).attr('action'),
            type: $(form).attr('method'),
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                Swal.fire({
                    title: 'Success',
                    text: response.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
                // window.location.href = "feedback/listing";


            },
            error: function(xhr, status, error) {
                if (xhr.status === 422) {
                    // Handle Laravel validation errors
                    var errors = xhr.responseJSON.errors;
                    var message = [];
                    var index = 1;
                    for (var key in errors) {
                        if (errors.hasOwnProperty(key)) {
                            message.push(index + '. ' + errors[key][0]);
                            index++;
                        }
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: message,
                    })
                } else {

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'An error occurred while processing your request.',
                    })
                }
            }
        });
    }
});


// status change

$('input[type="radio"]').change(function() {
    // Get the selected value
    var selectedValue = $('input[type="radio"]:checked').val();
    var feedbackId = $('input[type="radio"]:checked').attr('id');
    var url = $('input[type="radio"]:checked').attr('url');
    // Make an AJAX request based on the selected value
    $.ajax({
      url: url, // Replace with your actual AJAX endpoint URL
      method: 'POST', // Choose the appropriate HTTP method
      headers: {
        'X-CSRF-TOKEN': csrfToken
    },
      data: {
        feedbackVoteStatus: selectedValue,
        feedbackId: feedbackId,
    },
      success: function(response) {
        Swal.fire({
            title: response.message,
            // showDenyButton: true,
            // showCancelButton: true,
            confirmButtonText: 'Ok',
            // denyButtonText: `Don't save`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                setTimeout(() => {
                    window.location.reload()
                }, 1000);
            }
        })
      },
      error: function(xhr, status, error) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'An error occurred while processing your request.',
        })
      }
    });
  });
  $('.comment-button').on('click', function() {
    var ids = $(this).attr('data-get-id');
    var commentInput = $('input.comentData-' + ids);
    var comment = commentInput.val();
    var url = $(this).attr('url');

    $.ajax({
        type: 'POST',
        url: url,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        data: {
            feedback_id: ids,
            comment: comment,
        },
        success: function(data) {
            if (data.success) {
                var commentsContainer = $('div.post-comments-' + ids);

                var newComment = '<div class="mt-4 d-flex"><div><img img src="' +
                    data.image +
                    '" class="circle-img border border-1 border-main p-2px" alt=""></div><div class="ms-3 mt-2"><h6 class="fs-13 mb-0 fw-bold">' +
                    data.user.name +'('+ data.date+')'+ '</h6>' + comment +
                    '</div></div>';
                commentsContainer.append(newComment);
                $('.comments_count-' + ids).html(data.comments_count)
                commentInput.val(''); // Clear the input field
            }
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
