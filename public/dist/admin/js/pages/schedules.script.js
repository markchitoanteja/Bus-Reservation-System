$(document).ready(function () {
  $("#schedulesTable").DataTable({
    ordering: false,
  });

  let hasScheduleError = false;
  let hasEditScheduleError = false;

  $("#scheduleRoute, #scheduleDate, #scheduleBus").on(
    "blur input change",
    function () {
      const routeId = $("#scheduleRoute").val();
      const date = $("#scheduleDate").val();
      const busId = $("#scheduleBus").val();

      if (routeId && date && busId) {
        $.ajax({
          url: "schedules/checkScheduleExists",
          method: "POST",
          data: {
            route_id: routeId,
            date: date,
            bus_id: busId,
          },
          dataType: "json",
          success: function (response) {
            if (response.exists) {
              $("#scheduleErrorAlert")
                .removeClass("d-none")
                .text(
                  "A schedule for this bus on the selected route and date is already exists."
                );
              $("#scheduleRoute").addClass("is-invalid");
              $("#scheduleDate").addClass("is-invalid");
              $("#scheduleBus").addClass("is-invalid");
              hasScheduleError = true;
            } else {
              $("#scheduleErrorAlert").addClass("d-none").text("");
              $("#addScheduleSubmitBtn").prop("disabled", false);
              $("#scheduleRoute").removeClass("is-invalid");
              $("#scheduleDate").removeClass("is-invalid");
              $("#scheduleBus").removeClass("is-invalid");
              hasScheduleError = false;
            }
          },
          error: function () {
            console.error("Schedule check failed.");
          },
        });
      }
    }
  );

  $("#addScheduleForm").on("submit", function (e) {
    if (hasScheduleError) {
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
      const submitBtn = document.getElementById("addScheduleSubmitBtn");
      const btnLoader = document.getElementById("addScheduleBtnLoader");

      btnLoader.classList.remove("d-none");
      submitBtn.disabled = true;

      return true;
    }
  });

  function editScheduleErrorAlert() {
    hasEditScheduleError = false;
    $("#editScheduleErrorAlert").addClass("d-none").html("");
    $("#editScheduleRoute, #editScheduleDate, #editScheduleBus").removeClass(
      "is-invalid"
    );
  }

  $(".edit-schedule").on("click", function () {
    editScheduleErrorAlert();
    // Get data from the clicked button
    const id = $(this).data("id");
    const route = $(this).data("route");
    const date = $(this).data("date");
    const departure = $(this).data("departure");
    const bus = $(this).data("bus");

    // Set values in the modal form
    $("#editScheduleId").val(id);
    $("#editScheduleRoute").val(route);
    $("#editScheduleDate").val(date);
    $("#editScheduleDeparture").val(departure);
    $("#editScheduleBus").val(bus);

    // Show the modal
    $("#editScheduleModal").modal("show");
  });

  $("#editScheduleRoute, #editScheduleDate, #editScheduleBus").on(
    "blur input change",
    function () {
      const routeId = $("#editScheduleRoute").val();
      const date = $("#editScheduleDate").val();
      const busId = $("#editScheduleBus").val();
      const scheduleId = $("#editScheduleId").val(); // exclude current ID

      if (routeId && date && busId) {
        $.ajax({
          url: "schedules/checkEditScheduleExists", // same endpoint
          method: "POST",
          data: {
            route_id: routeId,
            date: date,
            bus_id: busId,
            id: scheduleId, // pass this to avoid false positive on edit
          },
          dataType: "json",
          success: function (response) {
            if (response.exists) {
              $("#editScheduleErrorAlert")
                .removeClass("d-none")
                .text(
                  "A schedule for this bus on the selected route and date already exists."
                );
              $("#editScheduleRoute").addClass("is-invalid");
              $("#editScheduleDate").addClass("is-invalid");
              $("#editScheduleBus").addClass("is-invalid");
              hasEditScheduleError = true;
            } else {
              $("#editScheduleErrorAlert").addClass("d-none").text("");
              $("#editScheduleRoute").removeClass("is-invalid");
              $("#editScheduleDate").removeClass("is-invalid");
              $("#editScheduleBus").removeClass("is-invalid");
              hasEditScheduleError = false;
            }
          },
          error: function () {
            console.error("Edit schedule check failed.");
          },
        });
      }
    }
  );

  $("#editScheduleForm").on("submit", function (e) {
    if (hasEditScheduleError) {
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
      const submitBtn = document.getElementById("editScheduleSubmitBtn");
      const btnLoader = document.getElementById("editScheduleBtnLoader");

      btnLoader.classList.remove("d-none");
      submitBtn.disabled = true;

      return true;
    }
  });

  $(".delete-schedule").on("click", function (e) {
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
