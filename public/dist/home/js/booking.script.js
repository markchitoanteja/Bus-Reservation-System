$(document).ready(function () {
  // Booking Form Submission
  const $bookingForm = $("#booking form");
  if ($bookingForm.length) {
    const $from = $("#from");
    const $to = $("#to");
    const $date = $("#date");
    const $passenger = $("#passenger");

    // Handle form submit
    $bookingForm.on("submit", function (e) {
      e.preventDefault();
      let valid = true;

      // Basic empty check for all fields
      [$from, $to, $date, $passenger].forEach(($input) => {
        if (!$input.val().trim()) {
          $input.addClass("is-invalid");
          valid = false;
        } else {
          $input.removeClass("is-invalid");
        }
      });

      // Check if origin and destination are the same, but only if both have values
      const fromVal = $from.val().trim().toLowerCase();
      const toVal = $to.val().trim().toLowerCase();

      if (fromVal && toVal && fromVal === toVal) {
        Swal.fire({
          icon: "warning",
          title: "Invalid Selection",
          text: "Origin and destination cannot be the same.",
          confirmButtonText: "OK",
        });
        $from.addClass("is-invalid");
        $to.addClass("is-invalid");
        valid = false;
      }

      // Check if date is not in the past
      const selectedDate = new Date($date.val());
      const today = new Date();
      today.setHours(0, 0, 0, 0); // Normalize to midnight for comparison

      if ($date.val().trim() && selectedDate < today) {
        Swal.fire({
          icon: "warning",
          title: "Invalid Date",
          text: "Please select a date that is today or later.",
          confirmButtonText: "OK",
        });
        $date.addClass("is-invalid");
        valid = false;
      }

      if (!valid) return;

      // Successful submission alert
      Swal.fire({
        icon: "success",
        title: "Booking Submitted",
        html: `Demo Booking:<br><strong>From:</strong> ${$from.val()}<br><strong>To:</strong> ${$to.val()}<br><strong>Date:</strong> ${$date.val()}<br><strong>Passengers:</strong> ${$passenger.val()}<br><br><em>This is a demo. Booking is not functional yet.</em>`,
        confirmButtonText: "OK",
      });

      $bookingForm[0].reset();
    });

    // Real-time input validation
    [$from, $to, $date, $passenger].forEach(($input) => {
      $input.on("input change", function () {
        const value = $(this).val().trim();

        // Basic required field check
        if (value) {
          $(this).removeClass("is-invalid");
        } else {
          $(this).addClass("is-invalid");
        }

        // Extra check for from/to: if both filled and not equal, remove invalid styling
        const fromVal = $from.val().trim().toLowerCase();
        const toVal = $to.val().trim().toLowerCase();

        if (fromVal && toVal && fromVal !== toVal) {
          $from.removeClass("is-invalid");
          $to.removeClass("is-invalid");
        }
      });
    });
  }
});
