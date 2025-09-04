$(document).ready(function () {
  $("#passengerTable").DataTable({
    ordering: false,
  });

  let selectedDate = localStorage.getItem("selectedDate") || null;
  let selectedBus = localStorage.getItem("selectedBus") || null;

  // Re-apply active button if stored
  if (selectedDate) {
    $(`.date-btn[data-date="${selectedDate}"]`)
      .addClass("active btn-primary")
      .removeClass("btn-outline-primary");
  }
  if (selectedBus) {
    $(`.bus-btn[data-bus_id="${selectedBus}"]`)
      .addClass("active btn-primary")
      .removeClass("btn-outline-primary");
  }

  // Fetch if both already selected
  if (selectedDate && selectedBus) {
    fetchPassengers();
  }

  // Handle Date selection
  $(".date-btn").on("click", function () {
    $(".date-btn")
      .removeClass("active btn-primary")
      .addClass("btn-outline-primary");
    $(this).addClass("active btn-primary").removeClass("btn-outline-primary");

    selectedDate = $(this).data("date");
    localStorage.setItem("selectedDate", selectedDate);
    fetchPassengers();
  });

  // Handle Bus selection
  $(".bus-btn").on("click", function () {
    $(".bus-btn")
      .removeClass("active btn-primary")
      .addClass("btn-outline-primary");
    $(this).addClass("active btn-primary").removeClass("btn-outline-primary");

    selectedBus = $(this).data("bus_id");
    localStorage.setItem("selectedBus", selectedBus);
    fetchPassengers();
  });

  // Fetch passengers
  function fetchPassengers() {
    if (selectedDate && selectedBus) {
      $.ajax({
        url: "passengers/fetch",
        method: "POST",
        data: { date: selectedDate, bus_id: selectedBus },
        dataType: "json",
        success: function (data) {
          let tbody = $("#passengerTableBody");
          tbody.empty();

          if (data.length > 0) {
            data.forEach((row, i) => {
              tbody.append(`
                <tr>
                  <td>${i + 1}</td>
                  <td class="text-left">${row.passengers_name}</td>
                  <td>${row.age}</td>
                  <td>${row.gender}</td>
                  <td class="text-left">${row.origin} — ${row.destination}</td>
                  <td>${row.booking_ref}</td>
                  <td><button class="btn btn-primary">View</button></td>
                </tr>
              `);
            });
          } else {
            tbody.html(
              `<tr><td colspan="7" class="text-center">No passengers found.</td></tr>`
            );
          }
        },
      });
    }
  }
});
