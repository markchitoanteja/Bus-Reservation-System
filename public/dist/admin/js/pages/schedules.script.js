$(document).ready(function () {
  $(".schedulesTable").DataTable({
    ordering: false,
  });

  /* Bus Travel Schedule */

  let hasBusTravelScheduleError = false;
  let hasBusTravelScheduleDateError = false;
  let hasEditBusTravelScheduleError = false;

  $("#BusTravelScheduleDate").on("blur input change", function () {
    let selectedDate = new Date($(this).val());
    let today = new Date();

    // Remove time part for accurate date-only comparison
    today.setHours(0, 0, 0, 0);
    selectedDate.setHours(0, 0, 0, 0);

    if (selectedDate <= today) {
      hasBusTravelScheduleDateError = true;
      $("#dateError").show();
      $(this).addClass("is-invalid");
    } else {
      hasBusTravelScheduleDateError = false;
      $("#dateError").hide();
      $(this).removeClass("is-invalid");
    }
  });

  $("#BusTravelScheduleDate, #BusTravelScheduleBus").on(
    "blur input change",
    function () {
      const date = $("#BusTravelScheduleDate").val();
      const busId = $("#BusTravelScheduleBus").val();

      if (date && busId) {
        $.ajax({
          url: "schedules/checkBusTravelScheduleExists",
          method: "POST",
          data: {
            date: date,
            bus_id: busId,
          },
          dataType: "json",
          success: function (response) {
            if (response.exists) {
              $("#BusTravelScheduleErrorAlert")
                .removeClass("d-none")
                .text("A schedule for this bus is already exists.");
              $("#BusTravelScheduleDate").addClass("is-invalid");
              $("#BusTravelScheduleBus").addClass("is-invalid");
              hasBusTravelScheduleError = true;
            } else {
              $("#BusTravelScheduleErrorAlert").addClass("d-none").text("");
              $("#addScheduleSubmitBtn").prop("disabled", false);
              $("#BusTravelScheduleDate").removeClass("is-invalid");
              $("#BusTravelScheduleBus").removeClass("is-invalid");
              hasBusTravelScheduleError = false;
            }
          },
          error: function () {
            console.error("Schedule check failed.");
          },
        });
      }
    }
  );

  $("#addBusTravelScheduleForm").on("submit", function (e) {
    if (hasBusTravelScheduleError) {
      e.preventDefault(); // Stop form submission

      Swal.fire({
        icon: "error",
        title: "Duplicate Entry",
        text: "Schedule is already exists. Please fix the error before submitting.",
        timer: 5000, // Auto close after 5 seconds
        timerProgressBar: true,
        showConfirmButton: true,
        confirmButtonText: "OK",
        customClass: {
          confirmButton: "btn btn-primary",
        },
        buttonsStyling: false,
      });
    } else if (hasBusTravelScheduleDateError) {
      e.preventDefault(); // Stop form submission

      Swal.fire({
        icon: "error",
        title: "Invalid Date",
        text: "Please select a future date for the schedule.",
        timer: 5000, // Auto close after 5 seconds
        timerProgressBar: true,
        showConfirmButton: true,
        confirmButtonText: "OK",
        customClass: {
          confirmButton: "btn btn-primary",
        },
        buttonsStyling: false,
      });
    } else {
      // ✅ Show spinner and disable button
      const submitBtn = document.getElementById(
        "addBusTravelScheduleSubmitBtn"
      );
      const btnLoader = document.getElementById(
        "addBusTravelScheduleBtnLoader"
      );

      btnLoader.classList.remove("d-none");
      submitBtn.disabled = true;

      return true;
    }
  });

  function editBusTravelScheduleErrorAlert() {
    hasEditBusTravelScheduleError = false;
    $("#editBusTravelScheduleErrorAlert").addClass("d-none").html("");
    $("#editBusTravelScheduleDate, #editBusTravelScheduleBus").removeClass(
      "is-invalid"
    );
  }

  $(".edit-BusTravelSchedule").on("click", function () {
    editBusTravelScheduleErrorAlert();
    let scheduleId = $(this).data("id");
    let scheduleDate = $(this).data("date");
    let busId = $(this).data("bus_id");

    $("#editBusTravelScheduleId").val(scheduleId);
    $("#EditBusTravelScheduleDate").val(scheduleDate);
    $("#EditBusTravelScheduleBus").val(busId);

    $("#editBusTravelScheduleModal").modal("show");
  });

  $("#EditBusTravelScheduleDate, #EditBusTravelScheduleBus").on(
    "blur input change",
    function () {
      const date = $("#EditBusTravelScheduleDate").val();
      const busId = $("#EditBusTravelScheduleBus").val();
      const scheduleId = $("#editBusTravelScheduleId").val();

      if (busId && date) {
        $.ajax({
          url: "schedules/checkEditBusTravelScheduleExists",
          method: "POST",
          data: {
            date: date,
            bus_id: busId,
            id: scheduleId,
          },
          dataType: "json",
          success: function (response) {
            if (response.exists) {
              $("#EditBusTravelScheduleErrorAlert")
                .removeClass("d-none")
                .text(
                  "Schedule is already exists. Please fix the error before submitting."
                );
              $("#EditBusTravelScheduleDate").addClass("is-invalid");
              $("#EditBusTravelScheduleBus").addClass("is-invalid");
              hasEditBusTravelScheduleError = true;
            } else {
              $("#EditBusTravelScheduleErrorAlert").addClass("d-none").text("");
              $("#EditBusTravelScheduleDate").removeClass("is-invalid");
              $("#EditBusTravelScheduleBus").removeClass("is-invalid");
              hasEditBusTravelScheduleError = false;
            }
          },
          error: function () {
            console.error("Edit schedule check failed.");
          },
        });
      }
    }
  );

  $("#editBusTravelScheduleForm").on("submit", function (e) {
    if (hasEditBusTravelScheduleError) {
      e.preventDefault(); // Stop form submission

      Swal.fire({
        icon: "error",
        title: "Duplicate Entry",
        text: "Schedule is already exists. Please fix the error before submitting.",
        timer: 5000, // Auto close after 5 seconds
        timerProgressBar: true,
        showConfirmButton: true,
        confirmButtonText: "OK",
        customClass: {
          confirmButton: "btn btn-primary",
        },
        buttonsStyling: false,
      });
    } else {
      // ✅ Show spinner and disable button
      const submitBtn = document.getElementById(
        "editBusTravelScheduleSubmitBtn"
      );
      const btnLoader = document.getElementById(
        "editBusTravelScheduleBtnLoader"
      );

      btnLoader.classList.remove("d-none");
      submitBtn.disabled = true;

      return true;
    }
  });

  $(".delete-BusTravelSchedule").on("click", function (e) {
    e.preventDefault();

    const scheduleId = $(this).data("id");
    const deleteUrl = $(this).data("url");

    Swal.fire({
      title: "Are you sure?",
      text: "This will permanently delete the schedule.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "Cancel",
      customClass: {
        confirmButton: "btn btn-danger mr-2",
        cancelButton: "btn btn-secondary",
      },
      buttonsStyling: false,
    }).then((result) => {
      if (result.isConfirmed) {
        // Create and submit form
        const form = $("<form>", {
          method: "POST",
          action: deleteUrl,
        }).append(
          $("<input>", {
            type: "hidden",
            name: "schedule_id",
            value: scheduleId,
          })
        );

        $("body").append(form);
        form.submit();
      }
    });
  });

  /* Routes Schedule */

  let hasRouteScheduleError = false;
  let hasEditRouteScheduleError = false;

  $("#addRouteScheduleRoute, #addRouteScheduleDate, #addRouteScheduleBus").on(
    "input change blur",
    function () {
      const routeId = $("#addRouteScheduleRoute").val();
      const date = $("#addRouteScheduleDate").val();
      const busId = $("#addRouteScheduleBus").val();

      if (routeId && date && busId) {
        $.ajax({
          url: "schedules/checkRouteScheduleExists",
          method: "POST",
          data: {
            route_id: routeId,
            bus_id: busId,
          },
          dataType: "json",
          success: function (response) {
            if (response.exists) {
              $("#addRouteScheduleErrorAlert")
                .removeClass("d-none")
                .text(
                  "A schedule for this bus on the selected route and date is already exists."
                );
              $("#addRouteScheduleRoute").addClass("is-invalid");
              $("#addRouteScheduleDate").addClass("is-invalid");
              $("#addRouteScheduleBus").addClass("is-invalid");
              hasRouteScheduleError = true;
            } else {
              $("#addRouteScheduleErrorAlert").addClass("d-none").text("");
              $("#addRouteScheduleRoute").removeClass("is-invalid");
              $("#addRouteScheduleDate").removeClass("is-invalid");
              $("#addRouteScheduleBus").removeClass("is-invalid");
              hasRouteScheduleError = false;
            }
          },
          error: function () {
            console.error("Check route schedule failed.");
          },
        });
      } else {
        $("#addRouteScheduleErrorAlert").addClass("d-none").text("");
        $("#addRouteScheduleRoute").removeClass("is-invalid");
        $("#addRouteScheduleDate").removeClass("is-invalid");
        $("#addRouteScheduleBus").removeClass("is-invalid");
        hasRouteScheduleError = false;
      }
    }
  );

  $("#addRouteScheduleDate").on("blur input change", function () {
    const date = $(this).val();

    if (date !== "") {
      $.ajax({
        url: "schedules/getBusesByDate",
        type: "POST",
        data: { date: date },
        dataType: "json", // important so we don't need JSON.parse()
        success: function (buses) {
          let $select = $("#addRouteScheduleBus");
          $select.empty();

          if (buses.length > 0) {
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
            $select.append(
              `<option value="" disabled selected>No bus available</option>`
            );
          }
        },
        error: function () {
          alert("Error fetching buses.");
        },
      });
    }
  });

  $("#addRouteScheduleForm").on("submit", function (e) {
    if (hasRouteScheduleError) {
      e.preventDefault(); // Stop form submission

      Swal.fire({
        icon: "error",
        title: "Duplicate Entry",
        text: "Schedule already exists. Please fix the error before submitting.",
        timer: 5000, // Auto close after 5 seconds
        timerProgressBar: true,
        showConfirmButton: true,
        confirmButtonText: "OK",
        customClass: {
          confirmButton: "btn btn-primary",
        },
        buttonsStyling: false,
      });
    } else {
      // ✅ Show spinner and disable button
      const submitBtn = document.getElementById("addRouteScheduleSubmitBtn");
      const btnLoader = document.getElementById("addRouteScheduleBtnLoader");

      btnLoader.classList.remove("d-none");
      submitBtn.disabled = true;

      return true;
    }
  });

  function editRouteScheduleErrorAlert() {
    hasEditRouteScheduleError = false;
    $("#editRouteScheduleErrorAlert").addClass("d-none").html("");
    $(
      "#editRouteScheduleRoute, #editRouteScheduleDate, #editRouteScheduleBus"
    ).removeClass("is-invalid");
  }

  $(".edit-schedule").on("click", function () {
    editRouteScheduleErrorAlert();
    // Get data from the clicked button
    const id = $(this).data("id");
    const route = $(this).data("route");
    const date = $(this).data("date");
    const departure = $(this).data("departure");
    const bus = $(this).data("bus");

    // Set values in the modal form
    $("#editRouteScheduleId").val(id);
    $("#editRouteScheduleRoute").val(route);
    $("#editRouteScheduleDate").val(date);
    $("#editRouteScheduleDeparture").val(departure);

    // Show the modal
    $("#editRouteScheduleModal").modal("show");

    const dates = $(this).data("date");

    if (dates !== "") {
      $.ajax({
        url: "schedules/getBusesByDate",
        type: "POST",
        data: { date: date },
        dataType: "json", // important so we don't need JSON.parse()
        success: function (buses) {
          let $select = $("#editRouteScheduleBus");
          $select.empty();

          if (buses.length > 0) {
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
            $select.val(bus);
          } else {
            $select.append(
              `<option value="" disabled selected>No bus available</option>`
            );
          }
        },
        error: function () {
          alert("Error fetching buses.");
        },
      });
    }
  });

  $("#editRouteScheduleDate").on("blur input change", function () {
    const date = $(this).val();

    if (date !== "") {
      $.ajax({
        url: "schedules/getBusesByDate",
        type: "POST",
        data: { date: date },
        dataType: "json", // important so we don't need JSON.parse()
        success: function (buses) {
          let $select = $("#editRouteScheduleBus");
          $select.empty();

          if (buses.length > 0) {
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
          }
        },
        error: function () {
          alert("Error fetching buses.");
        },
      });
    }
  });

  $(
    "#editRouteScheduleRoute, #editRouteScheduleDate, #editRouteScheduleBus"
  ).on("blur input change", function () {
    const routeId = $("#editRouteScheduleRoute").val();
    const date = $("#editRouteScheduleDate").val();
    const busId = $("#editRouteScheduleBus").val();
    const scheduleId = $("#editRouteScheduleId").val();

    if (routeId && date && busId) {
      $.ajax({
        url: "schedules/checkEditRouteScheduleExists", // same endpoint
        method: "POST",
        data: {
          schedule_id: scheduleId,
          route_id: routeId,
          bus_id: busId,
        },
        dataType: "json",
        success: function (response) {
          if (response.exists) {
            $("#editRouteScheduleErrorAlert")
              .removeClass("d-none")
              .text(
                "A schedule for this bus on the selected route and date already exists."
              );
            $("#editRouteScheduleRoute").addClass("is-invalid");
            $("#editRouteScheduleDate").addClass("is-invalid");
            $("#editRouteScheduleBus").addClass("is-invalid");
            hasEditRouteScheduleError = true;
          } else {
            $("#editRouteScheduleErrorAlert").addClass("d-none").text("");
            $("#editRouteScheduleRoute").removeClass("is-invalid");
            $("#editRouteScheduleDate").removeClass("is-invalid");
            $("#editRouteScheduleBus").removeClass("is-invalid");
            hasEditRouteScheduleError = false;
          }
        },
        error: function () {
          console.error("Edit schedule check failed.");
        },
      });
    } else {
      $("#editRouteScheduleErrorAlert").addClass("d-none").text("");
      $("#editRouteScheduleRoute").removeClass("is-invalid");
      $("#editRouteScheduleDate").removeClass("is-invalid");
      $("#editRouteScheduleBus").removeClass("is-invalid");
      hasEditRouteScheduleError = false;
    }
  });

  $("#editRouteScheduleForm").on("submit", function (e) {
    if (hasEditRouteScheduleError) {
      e.preventDefault(); // Stop form submission

      Swal.fire({
        icon: "error",
        title: "Duplicate Entry",
        text: "Schedule already exists. Please fix the error before submitting.",
        timer: 5000, // Auto close after 5 seconds
        timerProgressBar: true,
        showConfirmButton: true,
        confirmButtonText: "OK",
        customClass: {
          confirmButton: "btn btn-primary",
        },
        buttonsStyling: false,
      });
    } else {
      // ✅ Show spinner and disable button
      const submitBtn = document.getElementById("editRouteScheduleSubmitBtn");
      const btnLoader = document.getElementById("editRouteScheduleBtnLoader");

      btnLoader.classList.remove("d-none");
      submitBtn.disabled = true;

      return true;
    }
  });

  $(".delete-routeSchedule").on("click", function (e) {
    e.preventDefault();

    const scheduleId = $(this).data("id");
    const deleteUrl = $(this).data("url");

    Swal.fire({
      title: "Are you sure?",
      text: "This will permanently delete the schedule.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "Cancel",
      customClass: {
        confirmButton: "btn btn-danger mr-2",
        cancelButton: "btn btn-secondary",
      },
      buttonsStyling: false,
    }).then((result) => {
      if (result.isConfirmed) {
        // Create and submit form
        const form = $("<form>", {
          method: "POST",
          action: deleteUrl,
        }).append(
          $("<input>", {
            type: "hidden",
            name: "schedule_id",
            value: scheduleId,
          })
        );

        $("body").append(form);
        form.submit();
      }
    });
  });
});
