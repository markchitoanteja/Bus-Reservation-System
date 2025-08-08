$(document).ready(function () {
  $("#busesTable").DataTable({
    ordering: false,
  });

  let hasBusError = false;
  let editHasBusError = false;

  $("#busNumber, #busName").on("input blur", function () {
    const busNumber = $("#busNumber").val().trim();
    const busName = $("#busName").val().trim();

    if (busNumber !== "" && busName !== "") {
      $.ajax({
        url: "buses/checkBusExists", // Adjust as needed
        method: "POST",
        data: {
          bus_number: busNumber,
          bus_name: busName,
        },
        dataType: "json",
        success: function (response) {
          if (response.exists) {
            hasBusError = true;
            $("#busErrorAlert")
              .removeClass("d-none")
              .html("Bus number or name already exists!");
            $("#busNumber, #busName").addClass("is-invalid");
          } else {
            hasBusError = false;
            $("#busErrorAlert").addClass("d-none").html("");
            $("#busNumber, #busName").removeClass("is-invalid");
          }
        },
        error: function () {
          console.error("Check failed.");
        },
      });
    }
  });

  function clearEditModalErrors() {
    editHasBusError = false;
    $("#editBusErrorAlert").addClass("d-none").html("");
    $("#editBusNumber, #editBusName").removeClass("is-invalid");
  }

  $("#editBusNumber, #editBusName").on("input blur", function () {
    const busNumber = $("#editBusNumber").val().trim();
    const busName = $("#editBusName").val().trim();
    const editBusId = $("#editBusId").val().trim();

    if (busNumber !== "" && busName !== "") {
      $.ajax({
        url: "buses/checkEditBusExists", // Adjust as needed
        method: "POST",
        data: {
          bus_number: busNumber,
          bus_name: busName,
          bus_id: editBusId,
        },
        dataType: "json",
        success: function (response) {
          if (response.exists) {
            editHasBusError = true;
            $("#editBusErrorAlert")
              .removeClass("d-none")
              .html("Bus number or name already exists!");
            $("#editBusNumber, #editBusName").addClass("is-invalid");
          } else {
            editHasBusError = false;
            $("#editBusErrorAlert").addClass("d-none").html("");
            $("#editBusNumber, #editBusName").removeClass("is-invalid");
          }
        },
        error: function () {
          console.error("Check failed.");
        },
      });
    }
  });

  // Prevent form submission if there's a duplicate error
  $("#addBusForm").on("submit", function (e) {
    if (hasBusError) {
      e.preventDefault(); // Stop form submission

      Swal.fire({
        icon: "error",
        title: "Duplicate Entry",
        text: "Bus number or name already exists. Please fix the error before submitting.",
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
      const submitBtn = document.getElementById("addBusSubmitBtn");
      const btnLoader = document.getElementById("addBusBtnLoader");

      btnLoader.classList.remove("d-none");
      submitBtn.disabled = true;

      return true;
    }
  });

  $(".edit-bus").on("click", function () {
    clearEditModalErrors();
    // Get data from the clicked button
    const id = $(this).data("id");
    const busNo = $(this).data("busno");
    const busName = $(this).data("busname");
    const busType = $(this).data("bustype");

    // Set values in the modal form
    $("#editBusId").val(id);
    $("#editBusNumber").val(busNo);
    $("#editBusName").val(busName);
    $("#editBusType").val(busType);

    // Show the modal
    $("#editBusModal").modal("show");
  });

  $("#editBusForm").on("submit", function (e) {
    if (editHasBusError) {
      e.preventDefault(); // Stop form submission

      Swal.fire({
        icon: "error",
        title: "Duplicate Entry",
        text: "Bus number or name already exists. Please fix the error before submitting.",
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
      // ✅ Show loading spinner in the button
      const submitBtn = document.getElementById("editBusSubmitBtn");
      const btnLoader = document.getElementById("editBusBtnLoader");

      btnLoader.classList.remove("d-none");
      submitBtn.disabled = true;
      // ✅ Allow form submission
      return true;
    }
  });

  $(".delete-bus").on("click", function (e) {
    e.preventDefault();

    const busId = $(this).data("id");
    const deleteUrl = $(this).data("url");

    Swal.fire({
      title: "Are you sure?",
      text: "This will permanently delete the bus.",
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
            name: "bus_id",
            value: busId,
          })
        );

        $("body").append(form);
        form.submit();
      }
    });
  });
});
