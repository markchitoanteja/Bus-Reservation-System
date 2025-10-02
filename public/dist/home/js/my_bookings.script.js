document.addEventListener("DOMContentLoaded", function () {
  var tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });
});

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
    // Status with Bootstrap badge
    let status = $(this).data("status");
    let badgeClass = "bg-secondary"; // default

    if (status === "Scheduled" || status === "Ongoing") {
      badgeClass = "bg-primary";
    } else if (status === "Cancelled") {
      badgeClass = "bg-danger";
    } else if (status === "Confirmed") {
      badgeClass = "bg-success";
    }

    $("#infoStatus").html(`<span class="badge ${badgeClass}">${status}</span>`);
    // Payment Method Badge
    let paymentMethod = $(this).data("paymentmethod");
    let paymentMethodBadge = "";

    switch (paymentMethod) {
      case "COB":
        paymentMethodBadge = `<span class="badge bg-secondary">${paymentMethod}</span>`;
        break;
      case "GCash":
        paymentMethodBadge = `<span class="badge bg-primary">${paymentMethod}</span>`;
        break;
      default:
        paymentMethodBadge = `<span class="badge bg-dark">${paymentMethod}</span>`;
    }

    // Payment Status Badge
    let paymentStatus = $(this).data("paymentstatus");
    let paymentStatusBadge = "";

    switch (paymentStatus) {
      case "Partial":
        paymentStatusBadge = `<span class="badge bg-primary">${paymentStatus}</span>`;
        break;
      case "Cash on Board":
        paymentStatusBadge = `<span class="badge bg-secondary">${paymentStatus}</span>`;
        break;
      case "Fully Paid":
        paymentStatusBadge = `<span class="badge bg-success">${paymentStatus}</span>`;
        break;
      default:
        paymentStatusBadge = `<span class="badge bg-dark">${paymentStatus}</span>`;
    }

    // Inject into modal
    $("#infoPaymentMethod").html(paymentMethodBadge);
    $("#infoPaymentStatus").html(paymentStatusBadge);

    $("#infoBusType").text($(this).data("bustype"));
    $("#infoSeats").text($(this).data("seats"));

    $("#infoAmountPaid").html(
      '<i class="fa fa-peso-sign"></i>&nbsp;' + $(this).data("amountpaid")
    );

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

  // Show seat map when "View Seat Map" is clicked
  $(document).on("click", "#viewSeatsBtn", function () {
    let busType = $("#infoBusType").text().trim();
    let occupied = $("#infoSeats")
      .text()
      .split(",")
      .map((s) => s.trim());

    if (busType === "2x2 Aircon with CR, 45-seater") {
      withCR(occupied);
    }

    if (busType === "2x3 Aircon without CR, 61-seater") {
      withoutCR(occupied);
    }
  });

  function withCR(occupied) {
    let html = "";

    const seatLayout = [
      ["ON DUTY DRIVER", "", "", "VIP", "VIP"],
      ["DRIVER SEAT", "", "", 2, 1],
      [4, 3, "", 6, 5],
      [8, 7, "", 10, 9],
      [12, 11, "", 14, 13],
      [16, 15, "", "COMFORT ROOM", ""],
      [18, 17, "", "STAIRS", ""],
      [22, 21, "", 20, 19],
      [26, 25, "", 24, 23],
      [30, 29, "", 28, 27],
      [34, 33, "", 32, 31],
      [38, 37, "", 36, 35],
      [43, 42, 41, 40, 39],
    ];

    seatLayout.forEach((row) => {
      html += '<div class="button-row">';
      row.forEach((seat, index) => {
        if (
          seat === "" &&
          (row[index - 1] === "ON DUTY DRIVER" ||
            row[index - 1] === "DRIVER SEAT" ||
            row[index - 1] === "COMFORT ROOM" ||
            row[index - 1] === "STAIRS")
        ) {
          return;
        }

        let wrapperClass = "btn-wrapper-with-cr";
        if (
          seat === "ON DUTY DRIVER" ||
          seat === "DRIVER SEAT" ||
          seat === "COMFORT ROOM" ||
          seat === "STAIRS"
        ) {
          wrapperClass += " two-col";
        }

        html += `<div class="${wrapperClass}">`;

        if (seat) {
          if (
            seat === "ON DUTY DRIVER" ||
            seat === "DRIVER SEAT" ||
            seat === "COMFORT ROOM" ||
            seat === "STAIRS"
          ) {
            html += `<button type="button" class="btn btn-sm btn-outline-dark seat-btn" disabled>${seat}</button>`;
          } else {
            const seatCode = seat.toString();
            const isOccupied = occupied.includes(seatCode);
            html += `<button type="button" 
            class="btn btn-sm ${
              isOccupied ? "btn-pink" : "btn-outline-primary"
            } seat-btn" 
            disabled>${seatCode}</button>`;
          }
        } else {
          html += "&nbsp;";
        }

        html += "</div>";
      });
      html += "</div>";
    });

    $("#seatModalContainer").html(html);
  }

  function withoutCR(occupied) {
    let html = "<label class='form-label'>Seat Map (View Only)</label>";

    const seatLayout = [
      ["DRIVER SEAT", "", "", "", "VIP1", "VIP2"],
      [5, 4, 3, "", 2, 1],
      [10, 9, 8, "", 7, 6],
      [15, 14, 13, "", 12, 11],
      [20, 19, 18, "", 17, 16],
      [25, 24, 23, "", 22, 21],
      [30, 29, 28, "", 27, 26],
      [35, 34, 33, "", 32, 31],
      [40, 39, 38, "", 37, 36],
      [45, 44, 43, "", 42, 41],
      [50, 49, 48, "", 47, 46],
      [55, 54, 53, "", 52, 51],
      [61, 60, 59, 58, 57, 56],
    ];

    seatLayout.forEach((row) => {
      html += '<div class="button-row">';
      row.forEach((seat, index) => {
        if (seat === "" && row[index - 1] === "DRIVER SEAT") return;
        if (seat === "" && row[index - 2] === "DRIVER SEAT") return;

        let wrapperClass = "btn-wrapper-without-cr";
        if (seat === "DRIVER SEAT") {
          wrapperClass += " three-col";
        }

        html += `<div class="${wrapperClass}">`;

        if (seat) {
          if (seat === "DRIVER SEAT") {
            html += `<button type="button" class="btn btn-sm btn-outline-dark seat-btn" disabled>${seat}</button>`;
          } else {
            const seatCode = seat.toString();
            const isOccupied = occupied.includes(seatCode);
            html += `<button type="button" 
            class="btn btn-sm ${
              isOccupied ? "btn-pink" : "btn-outline-primary"
            } seat-btn" 
            disabled>${seatCode}</button>`;
          }
        } else {
          html += "&nbsp;";
        }

        html += "</div>";
      });
      html += "</div>";
    });

    $("#seatModalContainer").html(html);
  }
});
