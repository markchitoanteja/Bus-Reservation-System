$(document).ready(function () {
  $("#ticketingPayment").DataTable({
    ordering: false,
  });

  let selectedDate = localStorage.getItem("selectedDate") || null;

  // Re-apply active button if stored
  if (selectedDate) {
    $(`.date-btn[data-date="${selectedDate}"]`)
      .addClass("active btn-primary")
      .removeClass("btn-outline-primary");
  }

  // Fetch if both already selected
  if (selectedDate) {
    fetchBookings();
  }

  // Handle Date selection
  $(".date-btn").on("click", function () {
    $(".date-btn")
      .removeClass("active btn-primary")
      .addClass("btn-outline-primary");
    $(this).addClass("active btn-primary").removeClass("btn-outline-primary");

    selectedDate = $(this).data("date");
    localStorage.setItem("selectedDate", selectedDate);
    fetchBookings();
  });

  // Fetch passengers

  function fetchBookings() {
    if (selectedDate) {
      $.ajax({
        url: "bookings/fetch",
        method: "POST",
        data: { date: selectedDate },
        dataType: "json",
        success: function (bookings) {
          let tbody = $("#bookingTableBody");
          tbody.empty();
          if (bookings.length === 0) {
            tbody.append(`
              <tr>
                <td colspan="8" class="text-center text-muted">
                  No bookings found for this date.
                </td>
              </tr>
            `);
            return; // ✅ Stop here if empty
          }
          bookings.forEach((row, i) => {
            let statusBadge = "";
            switch (row.status) {
              case "Scheduled":
                statusBadge = `<span class="badge bg-primary text-dark">${row.status}</span>`;
                break;
              case "Ongoing":
                statusBadge = `<span class="badge bg-primary">${row.status}</span>`;
                break;
              case "Cancelled":
                statusBadge = `<span class="badge bg-danger">${row.status}</span>`;
                break;
              case "Completed":
                statusBadge = `<span class="badge bg-success">${row.status}</span>`;
                break;
            }

            let paymentBadge = "";
            switch (row.payment_method) {
              case "COB":
                paymentBadge = `<span class="badge bg-secondary">${row.payment_method}</span>`;
                break;
              case "GCash":
                paymentBadge = `<span class="badge bg-primary">${row.payment_method}</span>`;
                break;
            }

            let paymentStatusBadge = "";
            switch (row.payment_status) {
              case "Partial":
                paymentStatusBadge = `<span class="badge bg-primary">${row.payment_status}</span>`;
                break;
              case "Cash on Board":
                paymentStatusBadge = `<span class="badge bg-secondary">${row.payment_status}</span>`;
                break;
              case "Fully Paid":
                paymentStatusBadge = `<span class="badge bg-success">${row.payment_status}</span>`;
                break;
            }

            const fare =
              row.bus_type === "2x2 Aircon with CR, 45-seater"
                ? row.with_cr_fare
                : row.without_cr_fare;

            tbody.append(`
          <tr class="text-nowrap">
            <td>${i + 1}</td>
            <td>${row.booking_ref}</td>
            <td>${row.name}</td>
            <td>${row.origin} — ${row.destination}</td>
            <td>${statusBadge}</td>
            <td>${paymentBadge}</td>
            <td>${paymentStatusBadge}</td>
            <td class="text-center">
              <!-- View Booking -->
              <a href="javascript:void(0)" 
                 class="btn btn-primary btn-sm view-booking"
                 data-id="${row.bookings_tb_id}"
                 data-amount="${row.amount}"
                 data-btnfullypaid="${
                   row.status === "Cancelled" ||
                   row.payment_status === "Fully Paid"
                     ? "true"
                     : "false"
                 }"
                 data-btnnotpaid="${
                   row.status === "Cancelled" ||
                   row.payment_status !== "Fully Paid" ||
                   row.payment_status === "Cash on Board"
                     ? "true"
                     : "false"
                 }"
                 data-date="${row.date_created}" 
                 data-ref="${row.booking_ref}" 
                 data-origin="${row.origin}" 
                 data-destination="${row.destination}" 
                 data-depdate="${row.date}" 
                 data-deptime="${row.dep_time}" 
                 data-bus="${row.bus_name}" 
                 data-bustype="${row.bus_type}" 
                 data-seats="${row.seats}" 
                 data-amountpaid="${row.amount_paid}" 
                 data-paymentmethod="${row.payment_method}" 
                 data-paymentstatus="${row.payment_status}" 
                 data-noofpassengers="${row.no_of_passenger}" 
                 data-fare="${fare}" 
                 data-total="${row.amount}" 
                 data-status="${row.status}">
                 <i class="fas fa-eye"></i> View
              </a>

              <a href="javascript:void(0)" 
                  class="btn btn-success btn-sm btnFullyPaid ${
                    row.status === "Cancelled" ||
                    row.payment_status === "Fully Paid"
                      ? "disabled"
                      : ""
                  }"
                 data-id="${row.bookings_tb_id}"
                 data-amount="${row.amount}">
                 <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                 <i class="fas fa-check-circle"></i> Fully Paid
              </a>

              <a href="javascript:void(0)" 
                  class="btn btn-secondary btn-sm btnNotPaid ${
                    row.status === "Cancelled" ||
                    row.payment_status !== "Fully Paid" ||
                    row.payment_status === "Cash on Board"
                      ? "disabled"
                      : ""
                  }"
                 data-id="${row.bookings_tb_id}">
                 <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                 <i class="fas fa-ban"></i> Not Paid
              </a>
              
            </td>
          </tr>
        `);
          });
        },
        error: function () {
          console.error("Failed to fetch bookings");
        },
      });
    } else {
      let tbody = $("#bookingTableBody");
      tbody.empty();
      if (bookings.length === 0) {
        tbody.append(`
              <tr>
                <td colspan="8" class="text-center text-muted">
                  No bookings found for this date.
                </td>
              </tr>
            `);
        return; // ✅ Stop here if empty
      }
    }
  }

  $(document).on("click", ".view-booking", function () {
    const bookingId = $(this).data("id");
    const bookingAmount = $(this).data("amount");

    // Fill booking info from data attributes
    $("#btnFullyPaid").data("id", bookingId);
    $("#btnFullyPaid").data("amount", bookingAmount);
    $("#btnFullyPaid").prop("disabled", $(this).data("btnfullypaid"));

    $("#btnNotPaid").data("id", bookingId);
    $("#btnNotPaid").prop("disabled", $(this).data("btnnotpaid"));

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
      url: "getPassengers",
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

  $(document).on("click", "#btnFullyPaid, .btnFullyPaid", function () {
    Swal.fire({
      title: "Mark as Fully Paid?",
      text: "This will mark the booking as fully paid. Do you want to continue?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, proceed",
      cancelButtonText: "No, cancel",
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
        const bookingAmount = $(this).data("amount");

        $.ajax({
          url: "markFullyPaid",
          data: { id: bookingId, amount: bookingAmount },
          type: "POST",
          dataType: "json",
          success: function (response) {
            if (response.success) {
              location.reload();
            } else {
              console.error("Error marking as fully paid:", response.message);
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

  $(document).on("click", "#btnNotPaid, .btnNotPaid", function () {
    Swal.fire({
      title: "Mark as Not Paid?",
      text: "This will mark the booking as not paid. Do you want to continue?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, proceed",
      cancelButtonText: "No, cancel",
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

        $.ajax({
          url: "markNotPaid",
          data: { id: bookingId },
          type: "POST",
          dataType: "json",
          success: function (response) {
            if (response.success) {
              location.reload();
            } else {
              console.error("Error marking as not paid:", response.message);
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
});
