import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', function() {
    const gridColor = 'rgba(255, 255, 255, 0.1)';
    const textColor = '#9ca3af'; 

    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                mode: 'index',
                intersect: false,
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                max: 100,
                grid: {
                    color: gridColor,
                },
                ticks: {
                    color: textColor,
                    callback: function(value) {
                        return value + '%';
                    }
                }
            },
            x: {
                grid: {
                    display: false,
                },
                ticks: {
                    color: textColor,
                    maxTicksLimit: 6
                }
            }
        },
        interaction: {
            mode: 'nearest',
            axis: 'x',
            intersect: false
        }
    };

    const cpuCanvas = document.getElementById('cpuChart');
    if (cpuCanvas) {
        new Chart(cpuCanvas, {
            type: 'line',
            data: {
                labels: ['10s', '20s', '30s', '40s', '50s', '60s'],
                datasets: [{
                    label: 'CPU Usage',
                    data: [12, 19, 15, 25, 22, 30],
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4, 
                    pointRadius: 3,
                    pointBackgroundColor: '#3b82f6'
                }]
            },
            options: commonOptions
        });
    }

    
    const memoryCanvas = document.getElementById('memoryChart');
    if (memoryCanvas) {
        new Chart(memoryCanvas, {
            type: 'line',
            data: {
                labels: ['10s', '20s', '30s', '40s', '50s', '60s'],
                datasets: [{
                    label: 'RAM Usage',
                    data: [45, 48, 42, 50, 49, 52],
                    borderColor: '#10b981', 
                    backgroundColor: 'rgba(16, 185, 129, 0.2)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 3,
                    pointBackgroundColor: '#10b981'
                }]
            },
            options: commonOptions
        });
    }

    const networkCanvas = document.getElementById('networkChart');
    if (networkCanvas) {
        new Chart(networkCanvas, {
            type: 'line',
            data: {
                labels: ['10s', '20s', '30s', '40s', '50s', '60s'],
                datasets: [{
                    label: 'Network Traffic',
                    data: [5, 15, 8, 20, 12, 25], 
                    borderColor: '#f59e0b', 
                    backgroundColor: 'rgba(245, 158, 11, 0.2)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 3,
                    pointBackgroundColor: '#f59e0b'
                }]
            },
            options: commonOptions
        });
    }
});
