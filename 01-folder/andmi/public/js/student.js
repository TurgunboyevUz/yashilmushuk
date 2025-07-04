document.addEventListener('DOMContentLoaded', () => {
    const currentUrl = window.location.href; // Get the current URL
    const navLinks = document.querySelectorAll('.nav-link'); // Select all navigation links

    navLinks.forEach(link => {
        if (link.href === currentUrl) {
            link.classList.add('active'); // Add 'active' class to the matching link
        } else {
            link.classList.remove('active'); // Ensure other links do not have 'active'
        }
    });
});

$(function() {
    $("table").each(function() {
        $(this).DataTable({
            responsive: true,
            autoWidth: false,
            language: {
                url: uzLocaleFile
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

function toggleTeamInputs() {
    const participants = document.getElementById('participants');
    const teamMembers = document.getElementById('teamMembers');

    if (participants.value === 'team') {
        teamMembers.style.display = 'block';
    } else {
        teamMembers.style.display = 'none';
    }
}