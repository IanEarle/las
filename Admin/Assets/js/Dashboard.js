const ctxGrowth = document.getElementById('growthChart').getContext('2d');
const growthChart = new Chart(ctxGrowth, {
    type: 'bar',
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June'],
        datasets: [{
            label: 'New Users',
            data: [50, 100, 150, 200, 250, 300],
            backgroundColor: '#ff4d6d',
        }]
    },
    options: {
        responsive: true,
        scales: {
            x: {
                grid: {
                    display: false
                }
            },
            y: {
                grid: {
                    borderDash: [5, 5]
                }
            }
        },
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                callbacks: {
                    label: function (tooltipItem) {
                        return tooltipItem.raw + ' users';
                    }
                }
            }
        }
    }
});

const ctxShopGrowth = document.getElementById('shopGrowthChart').getContext('2d');
const shopGrowthChart = new Chart(ctxShopGrowth, {
    type: 'bar',
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June'],
        datasets: [{
            label: 'New Shops',
            data: [20, 40, 60, 80, 100, 120],
            backgroundColor: '#ff4d6d',  
        }]
    },
    options: {
        responsive: true,
        scales: {
            x: {
                grid: {
                    display: false
                }
            },
            y: {
                grid: {
                    borderDash: [5, 5]
                }
            }
        },
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                callbacks: {
                    label: function (tooltipItem) {
                        return tooltipItem.raw + ' shops';
                    }
                }
            }
        }
    }
});