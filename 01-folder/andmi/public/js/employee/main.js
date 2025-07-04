document.addEventListener('DOMContentLoaded', () => {
    const currentUrl = window.location.href;
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        if (link.href === currentUrl) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const checkAll = document.getElementById("checkAll");
    const checkItems = document.querySelectorAll(".checkItem");

    checkAll.addEventListener("change", function () {
        checkItems.forEach((item) => {
            item.checked = this.checked;
        });
    });

    checkItems.forEach((item) => {
        item.addEventListener("change", function () {
            checkAll.checked = Array.from(checkItems).every((item) => item.checked);
        });
    });
});

$(document).ready(function () {
    $("#zipDownload").on("click", function () {
        const selectedUuids = [];

        $(".checkItem:checked").each(function () {
            const uuid = $(this).data("uuid");
            
            if (Array.isArray(uuid)) {
                selectedUuids.push(...uuid);
            }else{
                selectedUuids.push(uuid);
            }
        });

        $(".checkItem:checked")
            .map(function () {
                return $(this).closest("tr").find("[data-uuid]").data("uuid");
            })
            .get();

        if (selectedUuids.length === 0) {
            alert("Iltimos yuklab olish uchun kamida 1 ta faylni tanlang!");
            return;
        }

        const downloadUrl = $(this).data("url");
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const name = $(this).data("name");

        $.ajax({
            url: downloadUrl,
            type: "POST",

            data: {
                uuids: selectedUuids,
                name: name,
                _token: csrfToken
            },
            xhrFields: {
                responseType: "blob",
            },
            success: function (data, status, xhr) {
                const filename = xhr.getResponseHeader("Content-Disposition")
                    ? xhr.getResponseHeader("Content-Disposition").split("filename=")[1]
                    : "download.zip";
                const blob = new Blob([data], { type: "application/zip" });
                const url = window.URL.createObjectURL(blob);
                const link = document.createElement("a");
                link.href = url;
                link.download = filename.replace(/"/g, "");
                document.body.appendChild(link);
                link.click();
                link.remove();
            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
                alert("ZIP faylni yuklab olish jarayonida xatolik yuzaga keldi!");
            },
        });
    });
});


$(function() {
    $("table").each(function() {
        if ($(this).attr('id') !== "ListofProfessorsandStudents" && $(this).attr('id') !== "assignedTable" && !$.fn.dataTable.isDataTable(this)) {
            $(this).DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    url: uzLocaleFile
                }
            });
        }
    });

    $(".confirmAction").click(function(e) {
        e.preventDefault();

        var itemId = $(this).data('id');
        var url = $(this).data('url');
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        if (confirm("Tasdiqlamoqchimisiz?")) {
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    _token: csrfToken,
                    id: itemId
                },
                success: function(response) {
                    window.location.reload();
                },
                error: function(xhr) {
                    alert('Xatolik yuz berdi: ' + xhr.responseText);
                }
            });
        }
    });

    let cancelItemId = null;

    $(".cancelAction").click(function() {
        cancelItemId = $(this).data("id");
        var cancelUrl = $(this).data('url');
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        $("#cancelModal").modal("show");

        $("#cancelModal .btn-primary").click(function() {
            const reason = $("#cancelModal textarea").val();

            if (!reason) {
                alert("Bekor qilish sababini kiriting!");
                return;
            }

            $.ajax({
                url: cancelUrl,
                type: "POST",
                data: {
                    id: cancelItemId,
                    reason: reason,
                    _token: csrfToken
                },
                success: function(response) {
                    $("#cancelModal").modal("hide");

                    window.location.reload();
                },
                error: function(xhr) {
                    alert("Bekor qilishda xatolik yuz berdi.");
                }
            });
        });
    });

    $(document).ready(function() {
        $("#reject-eye-button").on("click", function() {
            const reason = $(this).data("reason");

            $("#reject-reason").text(reason || "Rad etilish sababi mavjud emas");

            $("#rejectModal").modal("show");
        });

        $(".btn-close, .btn-secondary").on("click", function() {
            $("#rejectModal").modal("hide");
        });
    });
});