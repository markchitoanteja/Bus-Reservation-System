$(document).ready(function () {
  $(".logoutBtn").on("click", function (e) {
    const baseUrl = $(this).data("url");

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
  });
});
