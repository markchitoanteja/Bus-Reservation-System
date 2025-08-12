$(document).ready(function () {
  let selectedSeats = [];
  $("#route, #date").on("input change blur", function () {
    const route = $("#route").val();
    const date = $("#date").val();

    if (route && date) {
      $.ajax({
        url: "booking/getAvailableBuses",
        type: "POST",
        data: {
          route: route,
          date: date,
        },
        dataType: "json",
        success: function (buses) {
          let $select = $("#bus");
          $select.empty();

          if (buses.length > 0) {
            hider();

            $select.append(
              `<option value="" disabled selected>Select a bus</option>`
            );
            buses.forEach(function (bus) {
              $select.append(
                `<option value="${bus.bus_trav_sched_tb_id}">
                                ${bus.bus_name} (${bus.bus_no}) - ${bus.bus_type}
                             </option>`
              );
            });
          } else {
            $select.append(`<option value="">No bus available</option>`);
            hider();
          }
        },
        error: function () {
          alert("Error fetching buses.");
        },
      });
    }
  });

  function hider() {
    $("#seatContainer").html("");
    $("#chooseSeatsBtn").addClass("d-none");
    $("#seatContainer").addClass("d-none");
  }

  // Handle bus change and seat rendering (your existing code)
  $("#bus").on("input change blur", function () {
    const busId = $(this).val();
    const date = $("#date").val();

    if (busId && date) {
      $.ajax({
        url: "booking/getBusAvailableSeats",
        type: "POST",
        data: { busId, date },
        dataType: "json",
        success: function (busDetails) {
          selectedSeats = []; // reset selection
          $("#selectedSeats").val("");

          let occupied = [];
          if (busDetails.occupied_seats) {
            occupied = busDetails.occupied_seats.split(",");
          }

          const prefixes = ["L", "M", "R", "", "X", "Y"];
          let html =
            "<label for='seats' class='form-label'>Select your seat(s)</label>";

          for (let i = 1; i <= 14; i++) {
            html += '<div class="button-row">';
            prefixes.forEach((prefix) => {
              html += '<div class="btn-wrapper">';
              if (prefix !== "") {
                const seatCode = prefix + i;
                const isOccupied = occupied.includes(seatCode);
                html += `<button type="button" 
                  class="btn btn-sm ${
                    isOccupied ? "btn-danger" : "btn-outline-success"
                  } seat-btn" 
                  data-seat="${seatCode}" 
                  ${isOccupied ? "disabled" : ""}>${seatCode}</button>`;
              } else {
                html += "&nbsp;";
              }
              html += "</div>";
            });
            html += "</div>";
          }

          $("#seatContainer").html(html);
          $("#chooseSeatsBtn").removeClass("d-none");
        },
        error: function () {
          alert("Error fetching bus details.");
        },
      });
    }
  });

  // Toggle seat selection
  $(document).on("click", ".seat-btn", function () {
    const seat = $(this).data("seat");
    const passengerCount = parseInt($("#passenger").val());

    if ($(this).hasClass("btn-success")) {
      // Deselect
      $(this).removeClass("btn-success").addClass("btn-outline-success");
      selectedSeats = selectedSeats.filter((s) => s !== seat);
    } else {
      // Select (check max limit)
      if (selectedSeats.length < passengerCount) {
        $(this).removeClass("btn-outline-success").addClass("btn-success");
        selectedSeats.push(seat);
      } else {
        Swal.fire({
          icon: "error",
          title: "Seat Selection Limit",
          text: "You can only select up to " + passengerCount + " seat(s).",
          timer: 5000, // Auto close after 5 seconds
          timerProgressBar: true,
          showConfirmButton: true,
          confirmButtonText: "OK",
          customClass: {
            confirmButton: "btn btn-primary",
          },
          buttonsStyling: false,
        });
      }
    }

    $("#selectedSeats").val(selectedSeats.join(","));
  });

  $("#chooseSeatsBtn").on("click", function () {
    if ($("#seatContainer").is(":visible")) {
      $("#seatContainer").addClass("d-none");
    } else {
      $("#seatContainer").removeClass("d-none");
    }
  });

  $("#bookingForm").on("submit", function (e) {
    e.preventDefault();

    const passengerCount = parseInt($("#passenger").val());
    const selectedCount = selectedSeats.length;

    if (selectedCount !== passengerCount) {
      Swal.fire({
        icon: "error",
        title: "Seat Selection Mismatch",
        text: `You selected ${selectedCount} ${
          selectedCount === 1 ? "seat" : "seats"
        }, but you entered ${passengerCount} ${
          passengerCount === 1 ? "passenger" : "passengers"
        }.`,
        timer: 5000,
        timerProgressBar: true,
        showConfirmButton: true,
        confirmButtonText: "OK",
        customClass: {
          confirmButton: "btn btn-primary",
        },
        buttonsStyling: false,
      });
    } else {
      Swal.fire({
        icon: "info", // "notification" is not a default SweetAlert icon
        title: "System Notification",
        text: "The subscription booking feature is currently under development. We apologize for the inconvenience.",
        timer: 10000,
        timerProgressBar: true,
        showConfirmButton: true,
        confirmButtonText: "OK",
        customClass: {
          confirmButton: "btn btn-primary",
        },
        buttonsStyling: false,
      });
    }
  });
});
