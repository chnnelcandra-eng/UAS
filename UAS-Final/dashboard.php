<canvas id="chartPenjualan" style="width:100%"></canvas>
<br>
<canvas id="chartPembelian" style="width:100%"></canvas>

<script>
const xValues = ["Jan", "Feb", "Mar", "Apr", "Mei","Jun"];

// DATA
const penjualan = [55, 49, 44, 24, 15, 56];
const pembelian = [20, 30, 25, 15, 10, 20];

// CHART PENJUALAN (atas)
new Chart(document.getElementById('chartPenjualan'), {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      label: "Penjualan",
      backgroundColor: "red",
      data: penjualan
    }]
  },
  options: {
    plugins: {
      legend: { display: false },
      title: {
        display: true,
        text: "Penjualan"
      }
    }
  }
});

// CHART PEMBELIAN (bawah)
new Chart(document.getElementById('chartPembelian'), {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      label: "Pembelian",
      backgroundColor: "blue",
      data: pembelian
    }]
  },
  options: {
    plugins: {
      legend: { display: false },
      title: {
        display: true,
        text: "Pembelian"
      }
    }
  }
});
</script>