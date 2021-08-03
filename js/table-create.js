function onReadyScript(id, type, ajaxurl) {
  $("#createForm").submit(function (e) {
    e.preventDefault();

    var fd = new FormData($("#createForm")[0]);
    fd.append("id", id);
    fd.append("action", "tables_add_or_update_" + type);

    $.ajax({
      type: "POST",
      url: ajaxurl,
      data: fd,
      contentType: false,
      processData: false,
      success: function (response) {
        if (isNaN(response)) showStatus(response);
        else
          window.location.href =
            SITE_URL + "/tables/" + type + "s/edit?id=" + response;
      }
    });
  });

  $("#delete").click(function () {
    $("#confirmDialog").modal("toggle");
  });

  $("#confirmForm").submit(function (e) {
    e.preventDefault();
    $(this.closest(".modal")).modal("toggle");

    var fd = new FormData();
    fd.append("id", id);
    fd.append("action", "tables_delete_" + type);

    $.ajax({
      type: "POST",
      url: ajaxurl,
      data: fd,
      contentType: false,
      processData: false,
      success: function (response) {
        if (isNaN(response)) showStatus(response);
        else window.history.back();
      }
    });
  });
}
