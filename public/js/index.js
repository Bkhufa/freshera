$( document ).ready(function() {
    // DETAILITEM

});

var jumlah = document.getElementById('jumlah');
var harga = document.getElementById('harga');
var btnedit = document.getElementById('btn-edit');
var btndelete = document.getElementById('btn-delete');


function tambahJumlah() {
    jumlah.value = parseInt(jumlah.value, 10) + 1;
}

function kurangJumlah() {
    if (jumlah.value > 0)
    jumlah.value -= 1;
}

function updateJumlah() {
    document.getElementById('modal-jumlah').value = jumlah.value;
    document.getElementById('modal-harga').value = parseFloat(jumlah.value, 10) * parseFloat(harga.innerHTML, 10) * 1000;
}
