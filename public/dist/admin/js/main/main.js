$(document).ready(function () {
  $(".logoutBtn").on("click", function (e) {
    e.preventDefault();

    const baseUrl = $(this).data("url");

    Swal.fire({
      title: "Are you sure?",
      text: "You will be logged out.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, log out",
      cancelButtonText: "Cancel",
      reverseButtons: true,
      focusCancel: true,

      // ✅ Button styling
      customClass: {
        popup: "swal2-small", // custom small size
        confirmButton: "btn btn-primary ml-2",
        cancelButton: "btn btn-danger",
      },
      buttonsStyling: false, // disable SweetAlert default button styles
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "../logout",
          type: "POST",
          dataType: "JSON",
          processData: false,
          contentType: false,
          success: function (response) {
            location.href = baseUrl;
          },
          error: function (_, _, error) {
            console.error(error);
          },
        });
      }
    });
  });
});
