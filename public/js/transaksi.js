$(function() {
  if (window.location == `${BASE_URL}/penjualan`) {
      $('.content-header').remove()
      $('.content').addClass('pt-2')
  }

  function detailKeranjang() {
      let keranjang = ''
      $.ajax({
          url: `${BASE_URL}/Penjualan/keranjang`,
          dataType: 'json',
          success: function(response) {
              $('#invoice').text(response.invoice) // menampilkan no invoice

          },
      })
  }
  detailKeranjang() // pertama
  $('#barcode').autocomplete({
      source: `${BASE_URL}/produk/barcode`,
      autoFocus: true,
      select: function(e, ui) {
          $.ajax({
              url: `${BASE_URL}produk/detail`,
              type: 'get',
              data: {
                  barcode: ui.item.value,
              },
              success: function(response) {
                  $('#iditem').val(response.produk_id)
                  $('#barcode').val(response.no_produk)
                  $('#nama').val(response.produk)
                  $('#harga').val(response.harga)
                  $('#stok').val(response.stok)
                  $('#tampil-stok').text(`Stok Produk ${response.stok}`)
                  if (response.stok == 0) {
                      $('#jumlah').prop('disabled', true)
                  } else {
                      $('#jumlah').prop('disabled', false).focus()
                  }
              },
              error: function(xhr, ajaxOptions, thrownError) {
                  alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
              }

          })
      },
  })
  $('#jumlah').on('keyup', function(e) {
      let jumlah = parseInt(e.target.value)
      let barcode = $('#barcode').val()

      if (isNaN(jumlah) || jumlah == 0) {
          $('#tambah').prop('disabled', true)
      } else {
          $.ajax({
              url: `${BASE_URL}produk/cekstok`,
              data: {
                  barcode: barcode,
              },
              success: (respon) => {
                  if (jumlah > respon.stok) {
                      Swal.fire({
                          title: `Jumlah melebihi stok, maksimal ${respon.stok}`,
                          icon: 'warning',
                      }).then((res) => {
                          e.target.value = 1
                      })
                  }
              },
          })
          $('#tambah').prop('disabled', false)
      }
  })
})