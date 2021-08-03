function onReadyScript(type) {
  var table = $("#datatable").DataTable();

  $("#datatable tbody tr")
    .click(function () {
      var rowNo = table.row(this).index();
      if (rowNo != null) {
        var curId = table.cell(rowNo, 1).data();
        window.location = "/COMaster/tables/" + type + "/edit?id=" + curId;
      }
    })
    .hover(function () {
      $(this).toggleClass("hovered");
    });

  $("#searchInput").keyup(function () {
    table.search($(this).val()).draw();

    if (table.rows({ filter: "applied" }).nodes().length == 1) {
      var curId = table.cell({ filter: "applied" }, 1).data();
      window.location = SITE_URL + "/tables/" + type + "/edit?id=" + curId;
    }
  });
}
