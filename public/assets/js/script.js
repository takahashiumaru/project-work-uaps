// login
function togglePassword() {
    var passwordField = document.getElementById("password");
    var toggleIcon = document.getElementById("toggle-icon");
    if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleIcon.classList.remove("fa-eye");
        toggleIcon.classList.add("fa-eye-slash");
    } else {
        passwordField.type = "password";
        toggleIcon.classList.remove("fa-eye-slash");
        toggleIcon.classList.add("fa-eye");
    }
}

function closeError() {
    var errorBox = document.getElementById("error-message");
    errorBox.classList.add("hide");
    setTimeout(() => {
        errorBox.style.display = "none";
    }, 500);
}

window.onload = function () {
    var errorBox = document.getElementById("error-message");
    if (errorBox) {
        setTimeout(() => {
            closeError();
        }, 5000);
    }
};

// home
function updateTanggal() {
    const now = new Date();
    const tanggalFormat = new Intl.DateTimeFormat('id-ID', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    }).format(now);
    document.getElementById('tanggalSekarang').textContent = `🕒 ${tanggalFormat}`;
}
setInterval(updateTanggal, 1000);
updateTanggal();

// Modal open prevention on specific buttons
$(document).ready(function () {
    $('.clickable-row').click(function (e) {
        if ($(e.target).closest('.no-click, button, i').length === 0) {
            const modalId = $(this).data('bs-target');
            $(modalId).modal('show');
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const body = document.body;
    const sidebar = document.getElementById('sidebar');
    const toggleButton = document.getElementById('toggleSidebar');

    const isCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';

    if (isCollapsed) {
        sidebar.classList.add('collapsed');
        body.classList.remove('with-sidebar');
    } else {
        sidebar.classList.remove('collapsed');
        body.classList.add('with-sidebar');
    }

    toggleButton.addEventListener('click', function () {
        const isNowCollapsed = sidebar.classList.toggle('collapsed');

        if (isNowCollapsed) {
            body.classList.remove('with-sidebar');
        } else {
            body.classList.add('with-sidebar');
        }

        localStorage.setItem('sidebar-collapsed', isNowCollapsed);
    });
});

$(document).ready(function () {
    $("#profileToggle").on("click", function (e) {
        e.preventDefault();
        $("#profileCard").toggle();
        e.stopPropagation();
    });

    $(document).on("click", function (e) {
        if (!$(e.target).closest('#profileCard, #profileToggle').length) {
            $("#profileCard").hide();
        }
    });
});
;

//tampilan salary
const salaryDisplay = document.getElementById('salary_display');
const salary = document.getElementById('salary');

salaryDisplay.addEventListener('input', function () {
    let raw = this.value.replace(/\D/g, '');
    salary.value = raw;

    this.value = parseInt(raw || 0).toLocaleString('id-ID');
});


function closeError() {
    const errorBox = document.getElementById('error-message');
    if (errorBox) {
        errorBox.style.display = 'none';
    }
}
