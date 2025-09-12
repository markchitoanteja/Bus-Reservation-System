$(document).ready(function () {
  if (notification && Object.keys(notification).length > 0) {
    displayPopupMessage(notification.message, notification.type);
  }

  function displayPopupMessage(message, type = "info") {
    const validTypes = ["success", "error", "warning", "info", "question"];
    const icon = validTypes.includes(type) ? type : "info";

    Swal.fire({
      icon: icon,
      title: message,
      confirmButtonText: "OK",
      timer: 2000,
      timerProgressBar: true,
      showConfirmButton: false,
      toast: true,
      position: "top-end",
      customClass: {
        confirmButton: "btn btn-primary ml-2",
        cancelButton: "btn btn-danger",
      },
      buttonsStyling: false, // disable SweetAlert default button styles
    });
  }

  // Handle logout button click
  $("#logoutBtn").on("click", function () {
    Swal.fire({
      title: "Are you sure?",
      text: "You will be logged out.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, logout",
      cancelButtonText: "No, cancel",
      customClass: {
        confirmButton: "btn btn-primary ml-2",
        cancelButton: "btn btn-danger",
      },
    }).then((result) => {
      if (result.isConfirmed) {
        $.post(
          "logout",
          function (response) {
            if (response.success) {
              window.location.href = BASE_URL + "#home";
            } else {
              Swal.fire({
                title: "Error!",
                text: response.message,
                icon: "error",
              });
            }
          },
          "json"
        );
      }
    });
  });

  $(document).on("click", ".view-booking", function () {
    const bookingId = $(this).data("id");

    // Fill booking info from data attributes
    $("#cancel-booking").data("id", bookingId);
    $("#cancel-booking").prop("disabled", $(this).data("btn"));
    $("#infoBookingRef").text($(this).data("ref"));
    $("#infoDateCreated").text($(this).data("date"));
    $("#infoOrigin").text($(this).data("origin"));
    $("#infoDestination").text($(this).data("destination"));
    $("#infoSchedule").text(
      $(this).data("depdate") + " — " + $(this).data("deptime")
    );
    $("#infoBus").text($(this).data("bus"));
    $("#infoStatus").text($(this).data("status"));

    $("#infoBusType").text($(this).data("bustype"));
    $("#infoSeats").text($(this).data("seats"));
    $("#infoPaymentStatus").text($(this).data("paymentstatus"));
    $("#infoAmountPaid").html(
      '<i class="fa fa-peso-sign"></i>&nbsp;' + $(this).data("amountpaid")
    );
    $("#infoPaymentMethod").text($(this).data("paymentmethod"));
    $("#infoPassengerCount").text($(this).data("noofpassengers"));
    $("#infoFare").html(
      '<i class="fa fa-peso-sign"></i>&nbsp;' + $(this).data("fare")
    );
    $("#infoTotal").html(
      '<i class="fa fa-peso-sign"></i>&nbsp;' + $(this).data("total")
    );

    // Clear passengers first
    $("#infoPassengers").empty();

    // Load passengers via AJAX
    $.ajax({
      url: "myBookings/getPassengers",
      type: "POST",
      data: { booking_id: bookingId },
      dataType: "json",
      success: function (response) {
        $("#infoPassengers").empty();

        if (response.success && response.passengers.length > 0) {
          response.passengers.forEach((p, index) => {
            $("#infoPassengers").append(`
              <h6 class="mb-2">Passenger ${index + 1}</h6>
                    <ul class="list-group mb-3">
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Booking ID:</strong>
                            <span>${p.booking_id}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Name:</strong>
                            <span>${p.passengers_name}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Age:</strong>
                            <span>${p.age}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Gender:</strong>
                            <span>${p.gender}</span>
                        </li>
                    </ul>
                `);
          });
        } else {
          $("#infoPassengers").append(
            `<div class="text-muted">No passengers found</div>`
          );
        }
      },
      error: function () {
        $("#infoPassengers").append(
          `<li class="list-group-item text-danger">Error loading passengers</li>`
        );
      },
    });

    // Show modal
    $("#bookingInfoModal").modal("show");
  });

  $("#cancel-booking, .cancel-booking").click(function () {
    Swal.fire({
      title: "Are you sure?",
      text: "Are you sure you want to cancel this booking?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, cancel",
      cancelButtonText: "No, keep it",
      customClass: {
        confirmButton: "btn btn-primary ml-2",
        cancelButton: "btn btn-danger",
      },
    }).then((result) => {
      if (result.isConfirmed) {
        const $clicked = $(this);

        // if already disabled, ignore
        if ($clicked.hasClass("disabled") || $clicked.prop("disabled")) return;
        const $spinner = $clicked.find(".spinner-border").first();
        startModalLoading($clicked, $spinner);
        const bookingId = $(this).data("id");
        const url = $(this).data("url");

        $.ajax({
          url: url,
          data: { id: bookingId },
          type: "POST",
          dataType: "json",
          success: function (response) {
            if (response.success) {
              location.reload();
            } else {
              console.error("Error updating profile:", response.message);
            }
          },
          error: function (_, _, error) {
            stopModalLoading($clicked, $spinner);
            console.error(error);
          },
        });
      }
    });
  });

  function startModalLoading($clicked, $spinner) {
    $clicked
      .addClass("disabled")
      .attr({ "aria-disabled": "true", tabindex: "-1" })
      .prop("disabled", true);
    $spinner.removeClass("d-none");
  }

  function stopModalLoading($clicked, $spinner) {
    $clicked
      .removeClass("disabled")
      .removeAttr("aria-disabled tabindex")
      .prop("disabled", false);
    $spinner.addClass("d-none");
  }

  function displayPopupMessage(message, type = "info") {
    const validTypes = ["success", "error", "warning", "info", "question"];
    const icon = validTypes.includes(type) ? type : "info";

    Swal.fire({
      icon: icon,
      title: message,
      confirmButtonText: "OK",
      timer: 2000,
      timerProgressBar: true,
      showConfirmButton: false,
      toast: true,
      position: "top-end",
    });
  }
});
