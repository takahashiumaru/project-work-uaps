document.addEventListener("DOMContentLoaded", function () {
    var tanggalSekarang = new Date();
    var tanggalDiv = document.getElementById("tanggalSekarang");

    var options = { year: 'numeric', month: 'long', day: 'numeric' };
    var tanggalFormat = tanggalSekarang.toLocaleDateString('id-ID', options);

    tanggalDiv.textContent = "Today " + tanggalFormat;
});



document.addEventListener("DOMContentLoaded", function () {
    const startDateElement = document.getElementById("startDate");

    const currentDate = new Date();

    const startDate = new Date("Jul 2022");

    const yearsWorked = currentDate.getFullYear() - startDate.getFullYear();

    const monthsWorked = currentDate.getMonth() - startDate.getMonth();
    if (monthsWorked < 0) {
        yearsWorked--;
        monthsWorked += 12;
    }

    startDateElement.innerText = `Jul 2022 - Saat ini • ${yearsWorked} thn ${monthsWorked} bln`
});
