$(document).ready(function () {
  let lastUpdated = null;

  function renderNotifications(data) {
    let badgeHtml = "";

    // If count > 0 → show badge
    if (data && data.count > 0) {
      badgeHtml = `<span class="badge badge-warning navbar-badge">${data.count}</span>`;
      let append = `${badgeHtml}`;
      $("#notifBell").append(append);
    } else {
      // Remove badge if no notifications
      $("#notifBell .navbar-badge").remove();
    }

    let html = "";

    if (
      data &&
      data.count > 0 &&
      Array.isArray(data.per_type) &&
      data.per_type.length > 0
    ) {
      html += `<span class="dropdown-item dropdown-header">
              ${data.count} Notifications
            </span>`;

      data.per_type.forEach((row) => {
        html += `
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item text-truncate w-100 notif-item" data-notify="${
          row.notify_for
        }">
          <span class="position-relative d-inline-block mr-2">
            <i class="${getNotifIcon(row.notify_for)}"></i>
            <span class="badge badge-warning position-absolute"
                  style="top:-6px; left:15px; min-width:18px; padding:2px 6px; text-align:center; white-space:nowrap;">
              ${row.total}
            </span>
          </span>
          <span class="ml-2">${row.notify_for}</span>
          <span class="float-right text-muted text-sm">
            ${timeAgo(row.last_time)}
          </span>
        </a>
      `;
      });

      html += `
      <div class="dropdown-divider"></div>
      <a href="#" class="dropdown-item dropdown-footer">View All</a>
    `;
    } else {
      // No notifications fallback
      html = `
      <span class="dropdown-item dropdown-header">No notifications</span>
    `;
    }

    $("#notifArea").html(html);
  }

  setInterval(function () {
    $.get("notifications/CheckUpdatesNotifications", function (data) {
      if (lastUpdated !== data.last_updated) {
        lastUpdated = data.last_updated;
        getNotificationsData();
      }
    });
  }, 3000);

  function getNotificationsData() {
    $.get("notifications/fetchUpdatesNotifications", function (data) {
      renderNotifications(data);
    });
  }

  function getNotifIcon(type) {
    const icons = {
      "New Booking": "fas fa-bus",
      "Booking Cancelled": "fas fa-bus",
      "Boarding": "fas fa-users",
      "In Transit": "fas fa-users",
      "Arrived": "fas fa-users",
      "Completed": "fas fa-users",
      "Cancelled": "fas fa-users",
      "Stranded": "fas fa-users",
      "Delayed": "fas fa-users",
      "New User": "fas fa-user-plus",
      "System Maintenance": "fas fa-cogs",
      "Default": "fas fa-info-circle",
    };
    return icons[type] || icons["Default"];
  }

  function timeAgo(datetime) {
    let timestamp = new Date(datetime).getTime() / 1000; // convert to seconds
    let diff = Math.floor(Date.now() / 1000 - timestamp);

    if (diff < 0) {
      return "Just now"; // in case of future time
    }

    if (diff < 5) {
      return "Just now";
    } else if (diff < 60) {
      return diff + "s ago";
    } else if (diff < 3600) {
      return Math.floor(diff / 60) + "m ago";
    } else if (diff < 86400) {
      return Math.floor(diff / 3600) + "h ago";
    } else if (diff < 604800) {
      return Math.floor(diff / 86400) + "d ago";
    } else {
      let d = new Date(datetime);
      return d.toLocaleString("en-US", { month: "short", day: "numeric" }); // "Sep 5"
    }
  }

  $("#notifArea").on("click", ".notif-item", function (e) {
    e.preventDefault();
    const notifyFor = $(this).data("notify");

    $.ajax({
      url: "notifications/markAsSeen",
      type: "POST",
      data: { notifyFor: notifyFor },
      dataType: "json",
      success: function (res) {
        getNotificationsData();
      },
      error: function (err) {
        console.error(err);
      },
    });
  });
});
