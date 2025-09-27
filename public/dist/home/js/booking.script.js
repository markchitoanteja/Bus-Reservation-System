$(document).ready(function () {
  if (window.showLoginModal) {
    $("#loginModal").modal("show");
  }

  let selectedSeats = [];

  // ==============================
  // Fetch buses based on route + date
  // ==============================
  $("#route, #date").on("input change blur", function () {
    const route = $("#route").val();
    const date = $("#date").val();

    if (route && date) {
      $("#getFare").val("0.00");
      updateFare();
      $.ajax({
        url: "booking/getAvailableBuses",
        type: "POST",
        data: { route, date },
        dataType: "json",
        success: function (buses) {
          function formatTime(timeStr) {
            // Handles "HH:MM:SS"
            let parts = timeStr.split(":");
            let h = parseInt(parts[0]);
            let m = parts[1];
            let suffix = h >= 12 ? "PM" : "AM";
            h = h % 12 || 12;
            return `${h}:${m} ${suffix}`;
          }

          let $select = $("#bus");
          $select.empty();

          if (buses.length > 0) {
            hider();

            $select.append(
              `<option value="" disabled selected>Select a bus</option>`
            );
            buses.forEach(function (bus) {
              let depTime = formatTime(bus.dep_time);

              $select.append(
                `<option value="${bus.bus_routes_tb_id}-${
                  bus.bus_trav_sched_tb_id
                }">
                    ${depTime} ${bus.bus_name} (${bus.bus_no}) - ${
                  bus.bus_type
                } ₱${(bus.bus_type === "2x2 Aircon with CR, 45-seater"
                  ? parseFloat(bus.with_cr_fare)
                  : parseFloat(bus.without_cr_fare)
                ).toLocaleString("en-PH", {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2,
                })}


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

  function updateFare() {
    const fare = parseFloat($("#getFare").val()) || 0;
    const passengerCount = parseInt($("#passenger").val()) || 1;
    const total = fare * passengerCount;
    $("#fare").text(
      `₱${fare.toLocaleString("en-PH", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
      })}`
    );
    $("#totalFare").text(
      `₱${total.toLocaleString("en-PH", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
      })}`
    );
  }

  $("#bus").on("input change blur", function () {
    const bus_id = $(this).val();
    const route_id = $("#route").val();

    if (bus_id && route_id) {
      $.ajax({
        url: "booking/getFare",
        type: "POST",
        data: { bus_id, route_id },
        dataType: "json",
        success: function (fare) {
          if (fare.bus_type === "2x2 Aircon with CR, 45-seater") {
            $("#getFare").val(fare.with_cr_fare);
          } else if (fare.bus_type === "2x3 Aircon without CR, 61-seater") {
            $("#getFare").val(fare.without_cr_fare);
          } else {
            $("#getFare").val("0.00");
          }
          $("#busType").val(fare.bus_type);
          updateFare();
        },
        error: function () {
          alert("Error fetching bus details.");
        },
      });
    }
  });
  // ==============================
  // Fetch seat availability
  // ==============================
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
          selectedSeats = []; // reset
          $("#selectedSeats").val("");
          const busType = $("#busType").val();

          let occupied = [];
          if (busDetails.occupied_seats) {
            occupied = busDetails.occupied_seats.split(",");
          }

          if (busType === "2x2 Aircon with CR, 45-seater") {
            withCR();
          }

          if (busType === "2x3 Aircon without CR, 61-seater") {
            withoutCR();
          }

          function withCR() {
            let html =
              "<label for='seats' class='form-label'>Select your seat(s)</label>";

            // Define the actual seat layout per row based on the image
            const seatLayout = [
              ["ON DUTY DRIVER", "", "", "VIP", "VIP"],
              ["DRIVER SEAT", "", "", 2, 1],
              [4, 3, "", 6, 5],
              [8, 7, "", 10, 9],
              [12, 11, "", 14, 13],
              [16, 15, "", "COMFORT ROOM", ""],
              [18, 17, "", "STAIRS", ""],
              [12, 11, "", 14, 13],
            ];

            seatLayout.forEach((row) => {
              html += '<div class="button-row">';
              row.forEach((seat, index) => {
                // Skip empty cell if previous is a two-col seat
                if (
                  seat === "" &&
                  (row[index - 1] === "ON DUTY DRIVER" ||
                    row[index - 1] === "DRIVER SEAT" ||
                    row[index - 1] === "COMFORT ROOM" ||
                    row[index - 1] === "STAIRS")
                ) {
                  return;
                }

                // Assign wrapper class properly
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
                    html += `<button type="button" class="btn btn-sm btn-outline-dark seat-btn" disabled style="color:black;">${seat}</button>`;
                  } else {
                    const seatCode = seat.toString();
                    const isOccupied = occupied.includes(seatCode);
                    html += `<button type="button" 
                  class="btn btn-sm ${
                    isOccupied ? "btn-pink" : "btn-outline-primary"
                  } seat-btn" 
                  data-seat="${seatCode}" 
                  ${isOccupied ? "disabled" : ""}>${seatCode}</button>`;
                  }
                } else {
                  html += "&nbsp;";
                }

                html += "</div>";
              });
              html += "</div>";
            });

            $("#seatContainer").html(html);
          }

          function withoutCR() {
            let html =
              "<label for='seats' class='form-label'>Select your seat(s)</label>";

            // Define the actual seat layout per row based on the image
            const seatLayout = [
              ["DRIVER SEAT", "", "", "", "VIP", "VIP"],
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
                // Skip empty cells if previous seat spans multiple columns
                if (seat === "" && row[index - 1] === "DRIVER SEAT") return;
                if (seat === "" && row[index - 2] === "DRIVER SEAT") return;

                // Assign wrapper class properly
                let wrapperClass = "btn-wrapper-without-cr";
                if (seat === "DRIVER SEAT") {
                  wrapperClass += " three-col";
                }

                html += `<div class="${wrapperClass}">`;

                if (seat) {
                  if (seat === "DRIVER SEAT") {
                    html += `<button type="button" class="btn btn-sm btn-outline-dark seat-btn" disabled style="color:black;">${seat}</button>`;
                  } else {
                    const seatCode = seat.toString();
                    const isOccupied = occupied.includes(seatCode);
                    html += `<button type="button" 
                  class="btn btn-sm ${
                    isOccupied ? "btn-pink" : "btn-outline-primary"
                  } seat-btn" 
                  data-seat="${seatCode}" 
                  ${isOccupied ? "disabled" : ""}>${seatCode}</button>`;
                  }
                } else {
                  html += "&nbsp;";
                }

                html += "</div>";
              });
              html += "</div>";
            });

            $("#seatContainer").html(html);
          }

          $("#chooseSeatsBtn").removeClass("d-none");
        },
        error: function () {
          alert("Error fetching bus details.");
        },
      });
    }
  });

  // ==============================
  // Seat selection toggle
  // ==============================
  $(document).on("click", ".seat-btn", function () {
    const seat = $(this).data("seat");
    const passengerCount = parseInt($("#passenger").val());

    if ($(this).hasClass("btn-primary")) {
      // Deselect
      $(this).removeClass("btn-primary").addClass("btn-outline-primary");
      selectedSeats = selectedSeats.filter((s) => s !== seat);
    } else {
      // Select (limit check)
      if (selectedSeats.length < passengerCount) {
        $(this).removeClass("btn-outline-primary").addClass("btn-primary");
        selectedSeats.push(seat);
      } else {
        Swal.fire({
          icon: "error",
          title: "Seat Selection Limit",
          text: "You can only select up to " + passengerCount + " seat(s).",
          timer: 5000,
          timerProgressBar: true,
          showConfirmButton: true,
          confirmButtonText: "OK",
          customClass: { confirmButton: "btn btn-primary" },
          buttonsStyling: false,
        });
      }
    }

    $("#selectedSeats").val(selectedSeats.join(","));
  });

  // Show/Hide seat container
  $("#chooseSeatsBtn").on("click", function () {
    $("#seatContainer").toggleClass("d-none");
  });

  // ==============================
  // Booking form validation
  // ==============================
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
        customClass: { confirmButton: "btn btn-primary" },
        buttonsStyling: false,
      });
    } else {
      e.currentTarget.submit(); // ✅ safer than this.submit()
    }
  });

  // ==============================
  // Passenger input fields
  // ==============================
  const passengerInput = document.getElementById("passenger");
  const container = document.getElementById("passengerNamesContainer");

  function generatePassengerFields(count) {
    // Save old values
    const existingNames = Array.from(
      document.getElementsByName("passenger_names[]")
    ).map((input) => input.value);
    const existingAges = Array.from(
      document.getElementsByName("passenger_ages[]")
    ).map((input) => input.value);
    const existingGenders = Array.from(
      document.getElementsByName("passenger_genders[]")
    ).map((select) => select.value);

    container.innerHTML = "";

    for (let i = 1; i <= count; i++) {
      // ===== Name =====
      const colName = document.createElement("div");
      colName.classList.add("col-md-4", "p-2");

      const labelName = document.createElement("label");
      labelName.classList.add("form-label");
      labelName.textContent = `Passenger ${i} Name`;

      const inputName = document.createElement("input");
      inputName.type = "text";
      inputName.name = "passenger_names[]";
      inputName.classList.add("form-control");
      inputName.placeholder = `Enter Passenger ${i} Name`;
      inputName.required = true;
      inputName.value = existingNames[i - 1] || "";
      inputName.addEventListener("blur", function () {
        this.value = this.value.trim();
      });

      colName.appendChild(labelName);
      colName.appendChild(inputName);

      // ===== Age =====
      const colAge = document.createElement("div");
      colAge.classList.add("col-md-4", "p-2");

      const labelAge = document.createElement("label");
      labelAge.classList.add("form-label");
      labelAge.textContent = `Passenger ${i} Age`;

      const inputAge = document.createElement("input");
      inputAge.type = "number";
      inputAge.name = "passenger_ages[]";
      inputAge.classList.add("form-control");
      inputAge.placeholder = `Enter Passenger ${i} Age`;
      inputAge.min = 0;
      inputAge.required = true;
      inputAge.value = existingAges[i - 1] || "";

      colAge.appendChild(labelAge);
      colAge.appendChild(inputAge);

      // ===== Gender =====
      const colGender = document.createElement("div");
      colGender.classList.add("col-md-4", "p-2");

      const labelGender = document.createElement("label");
      labelGender.classList.add("form-label");
      labelGender.textContent = `Passenger ${i} Gender`;

      const selectGender = document.createElement("select");
      selectGender.name = "passenger_genders[]";
      selectGender.classList.add("form-select");
      selectGender.required = true;

      const optionDefault = new Option(
        `Select Passenger ${i} Gender`,
        "",
        true,
        true
      );
      optionDefault.disabled = true;
      selectGender.add(optionDefault);
      selectGender.add(new Option("Male", "Male"));
      selectGender.add(new Option("Female", "Female"));
      selectGender.value = existingGenders[i - 1] || "";

      colGender.appendChild(labelGender);
      colGender.appendChild(selectGender);

      // Append to container
      container.appendChild(colName);
      container.appendChild(colAge);
      container.appendChild(colGender);
    }
  }

  // Initial render
  generatePassengerFields(passengerInput.value || 1);

  // Update fields on change
  // passengerInput.addEventListener("change", function () {
  //   let count = parseInt(this.value) || 1;
  //   if (count < 1) count = 1;
  //   generatePassengerFields(count);
  // });

  function handlePassengerChange() {
    let count = parseInt(passengerInput.value) || 1;
    if (count < 1) count = 1;
    generatePassengerFields(count);
    updateFare();
  }

  passengerInput.addEventListener("change", handlePassengerChange);
  passengerInput.addEventListener("input", handlePassengerChange);
  passengerInput.addEventListener("blur", handlePassengerChange);
});
