;(($) => {
  // Declare required variables
  var admin_url = window.admin_url || ""
  var initDataTable = window.initDataTable || (() => {})
  var alert_float =
    window.alert_float ||
    ((type, message) => {
      console.log(message)
    })

  // Check if required functions are available
  if (typeof admin_url === "undefined" || typeof initDataTable === "undefined" || typeof alert_float === "undefined") {
    console.error("QR Wine Module: Required Perfex CRM functions not available")
    return
  }

  $(document).ready(() => {
    // Initialize wine labels datatable
    if ($("#wine-labels").length > 0) {
      initDataTable("#wine-labels", admin_url + "qrwine/table", [0], [0], [], [6, "desc"])
    }

    // Wine label form validation
    $("#wine-label-form").validate({
      rules: {
        name: {
          required: true,
          minlength: 2,
        },
        grapev: {
          required: true,
        },
        vintage: {
          required: true,
          digits: true,
          min: 1900,
          max: new Date().getFullYear(),
        },
        alcohol: {
          required: true,
          number: true,
          min: 0,
          max: 100,
        },
      },
      messages: {
        name: {
          required: "Wine name is required",
          minlength: "Wine name must be at least 2 characters",
        },
        grapev: {
          required: "Grape variety is required",
        },
        vintage: {
          required: "Vintage year is required",
          digits: "Please enter a valid year",
          min: "Year must be after 1900",
          max: "Year cannot be in the future",
        },
        alcohol: {
          required: "Alcohol content is required",
          number: "Please enter a valid number",
          min: "Alcohol content cannot be negative",
          max: "Alcohol content cannot exceed 100%",
        },
      },
    })

    // Generate QR Code
    $(document).on("click", ".generate-qr-btn", function (e) {
      e.preventDefault()
      var labelId = $(this).data("label-id")

      $.post(admin_url + "qrwine/generate_qr", {
        label_id: labelId,
      }).done((response) => {
        if (response.success) {
          alert_float("success", "QR Code generated successfully")
          location.reload()
        } else {
          alert_float("danger", response.message || "Error generating QR code")
        }
      })
    })

    // Delete wine label
    $(document).on("click", ".delete-wine-label", function (e) {
      e.preventDefault()
      var labelId = $(this).data("label-id")

      if (confirm("Are you sure you want to delete this wine label?")) {
        $.post(admin_url + "qrwine/delete/" + labelId).done((response) => {
          if (response.success) {
            alert_float("success", "Wine label deleted successfully")
            $("#wine-labels").DataTable().ajax.reload()
          } else {
            alert_float("danger", response.message || "Error deleting wine label")
          }
        })
      }
    })
  })
})(window.jQuery)
