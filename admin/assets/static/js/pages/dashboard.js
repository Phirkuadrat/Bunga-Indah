// Fungsi untuk mengambil data pesanan bulanan dari server
async function fetchMonthlyOrders() {
  try {
    let response = await fetch('../admin/get_order_data.php'); 
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    let data = await response.json();
    return data;
  } catch (error) {
    console.error('Error fetching monthly orders:', error);
    return [];
  }
}

let optionsProfileVisit = {
  annotations: {
    position: 'back',
  },
  dataLabels: {
    enabled: false,
  },
  chart: {
    type: 'bar',
    height: 300,
  },
  fill: {
    opacity: 1,
  },
  plotOptions: {},
  series: [
    {
      name: 'Order',
      data: [], 
    },
  ],
  colors: '#435ebe',
  xaxis: {
    categories: [
      'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
      'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec',
    ],
  },
};

async function renderProfileVisitChart() {
  const monthlyOrders = await fetchMonthlyOrders();

  optionsProfileVisit.series[0].data = monthlyOrders;

  var chartProfileVisit = new ApexCharts(
    document.querySelector('#chart-profile-visit'),
    optionsProfileVisit
  );

  chartProfileVisit.render();
}

renderProfileVisitChart();
