$(document).ready(function () {
  $("#routesTable").DataTable({
    ordering: false,
  });

  let hasRouteError = false;
  let editHasRouteError = false;

  // Add Route Duplicate Check
  $("#routeOrigin, #routeDestination").on("input blur", function () {
    const routeOrigin = $("#routeOrigin").val().trim();
    const routeDestination = $("#routeDestination").val().trim();

    if (routeOrigin !== "" && routeDestination !== "") {
      $.ajax({
        url: "routes/checkRouteExists",
        method: "POST",
        data: {
          route_origin: routeOrigin,
          route_destination: routeDestination,
        },
        dataType: "json",
        success: function (response) {
          if (response.exists) {
            hasRouteError = true;
            $("#routeErrorAlert")
              .removeClass("d-none")
              .html("Route origin or destination already exists!");
            $("#routeOrigin, #routeDestination").addClass("is-invalid");
          } else {
            hasRouteError = false;
            $("#routeErrorAlert").addClass("d-none").html("");
            $("#routeOrigin, #routeDestination").removeClass("is-invalid");
          }
        },
        error: function () {
          console.error("Check failed.");
        },
      });
    }
  });

  // Edit Route Duplicate Check
  $("#editRouteOrigin, #editRouteDestination").on("input blur", function () {
    const routeOrigin = $("#editRouteOrigin").val().trim();
    const routeDestination = $("#editRouteDestination").val().trim();
    const editRouteId = $("#editRouteId").val().trim();

    if (routeOrigin !== "" && routeDestination !== "") {
      $.ajax({
        url: "routes/checkEditRouteExists",
        method: "POST",
        data: {
          route_origin: routeOrigin,
          route_destination: routeDestination,
          route_id: editRouteId,
        },
        dataType: "json",
        success: function (response) {
          if (response.exists) {
            editHasRouteError = true;
            $("#editRouteErrorAlert")
              .removeClass("d-none")
              .html("Route origin or destination already exists!");
            $("#editRouteOrigin, #editRouteDestination").addClass("is-invalid");
          } else {
            editHasRouteError = false;
            $("#editRouteErrorAlert").addClass("d-none").html("");
            $("#editRouteOrigin, #editRouteDestination").removeClass(
              "is-invalid"
            );
          }
        },
        error: function () {
          console.error("Check failed.");
        },
      });
    }
  });

  // Prevent Route Form Submit if Duplicate Found
  $("#addRouteForm").on("submit", function (e) {
    if (hasRouteError) {
      e.preventDefault();

      Swal.fire({
        icon: "error",
        title: "Duplicate Entry",
        text: "Route code or name already exists. Please fix the error before submitting.",
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
      const submitBtn = document.getElementById("addRouteSubmitBtn");
      const btnLoader = document.getElementById("addRouteBtnLoader");

      btnLoader.classList.remove("d-none");
      submitBtn.disabled = true;

      return true;
    }
  });

  function clearEditModalErrors() {
    editHasRouteError = false;
    $("#editRouteErrorAlert").addClass("d-none").html("");
    $("#editRouteOrigin, #editRouteDestination").removeClass("is-invalid");
  }

  // Open Edit Route Modal
  $(".edit-route").on("click", function () {
    clearEditModalErrors();

    const id = $(this).data("id");
    const origin = $(this).data("origin");
    const destination = $(this).data("destination");

    $("#editRouteId").val(id);
    $("#editRouteOrigin").val(origin);
    $("#editRouteDestination").val(destination);

    $("#editRouteModal").modal("show");
  });

  // Submit Edit Route Form
  $("#editRouteForm").on("submit", function (e) {
    if (editHasRouteError) {
      e.preventDefault();

      Swal.fire({
        icon: "error",
        title: "Duplicate Entry",
        text: "Route code or name already exists. Please fix the error before submitting.",
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
      const submitBtn = document.getElementById("editRouteSubmitBtn");
      const btnLoader = document.getElementById("editRouteBtnLoader");

      btnLoader.classList.remove("d-none");
      submitBtn.disabled = true;

      return true;
    }
  });

  // Delete Route
  $(".delete-route").on("click", function (e) {
    e.preventDefault();

    const routeId = $(this).data("id");
    const deleteUrl = $(this).data("url");

    Swal.fire({
      title: "Are you sure?",
      text: "This will permanently delete the route.",
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
        const form = $("<form>", {
          method: "POST",
          action: deleteUrl,
        }).append(
          $("<input>", {
            type: "hidden",
            name: "route_id",
            value: routeId,
          })
        );

        $("body").append(form);
        form.submit();
      }
    });
  });
});
