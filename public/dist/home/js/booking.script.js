$(document).ready(function () {
  let selectedSeats = [];

  // ==============================
  // Fetch buses based on route + date
  // ==============================
  $("#route, #date").on("input change blur", function () {
    const route = $("#route").val();
    const date = $("#date").val();

    if (route && date) {
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
                `<option value="${bus.bus_routes_tb_id}-${bus.bus_trav_sched_tb_id}">
                   ${depTime} ${bus.bus_name} (${bus.bus_no}) - ${bus.bus_type}
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

  // ==============================
  // Seat selection toggle
  // ==============================
  $(document).on("click", ".seat-btn", function () {
    const seat = $(this).data("seat");
    const passengerCount = parseInt($("#passenger").val());

    if ($(this).hasClass("btn-success")) {
      // Deselect
      $(this).removeClass("btn-success").addClass("btn-outline-success");
      selectedSeats = selectedSeats.filter((s) => s !== seat);
    } else {
      // Select (limit check)
      if (selectedSeats.length < passengerCount) {
        $(this).removeClass("btn-outline-success").addClass("btn-success");
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
  passengerInput.addEventListener("change", function () {
    let count = parseInt(this.value) || 1;
    if (count < 1) count = 1;
    generatePassengerFields(count);
  });
});
