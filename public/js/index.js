$( document ).ready(function() {
    // DETAILITEM

});

var jumlah = document.getElementById('jumlah');

function tambahJumlah() {
    jumlah.value = parseInt(jumlah.value, 10) + 1;
}

function kurangJumlah() {
    if (jumlah.value > 0)
        jumlah.value -= 1;
}