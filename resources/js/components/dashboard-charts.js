import Chart from 'chart.js/auto';
let cpuChartInstance = null;
let memoryChartInstance = null;
let cpuTempChartInstance = null;
document.addEventListener('DOMContentLoaded', function () {
    const gridColor = 'rgba(255, 255, 255, 0.1)';
    const textColor = '#9ca3af';

    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false,
        animation: false,
        scales: {
            x: {
                ticks: { color: textColor, maxRotation: 45 },
                grid: { color: gridColor }
            },
            y: {
                min: 0,
                max: 100,
                ticks: {
                    color: textColor,
                    callback: (value) => value + '%'
                },
                grid: { color: gridColor }
            }
        },
        plugins: {
            legend: {
                labels: { color: textColor }
            }
        }
    };
    const tempOptions = {
        ...commonOptions,
        scales: {
            y: {
            min: 0,
            max: 100,
            ticks: {
              stepSize: 10
            },
            }   
        }}
    const cpuTempCanvas = document.getElementById('cpuTempChart');
    const cpuCanvas = document.getElementById('cpuChart');
    const memoryCanvas = document.getElementById('memoryChart');

    if (cpuTempCanvas) {
        cpuTempChartInstance = new Chart(cpuTempCanvas, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'CPU Temp',
                    data: [],
                    borderColor: '#bd4b25ff',
                    backgroundColor: 'rgba(189, 75, 37, 0.2)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 3,
                    pointBackgroundColor: '#bd4b25ff'
                }]
            },
            options: tempOptions
        });
    }

    if (cpuCanvas) {
        cpuChartInstance = new Chart(cpuCanvas, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'CPU Usage',
                    data: [],
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

    if (memoryCanvas) {
        memoryChartInstance = new Chart(memoryCanvas, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'RAM Usage',
                    data: [],
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

    if (window.Echo) {
        window.Echo.channel('server-metrics')
            .listen('.server.metrics.update', (e) => {
                const res = e.resources;
                console.log(res)
                const label = res.recorded_at
                    ? res.recorded_at.split(' ')[1]
                    : new Date().toLocaleTimeString();

                const MAX_POINTS = 8;

                if (cpuTempChartInstance) {
                    cpuTempChartInstance.data.labels.push(label);
                    cpuTempChartInstance.data.datasets[0].data.push(res.cpu_temp);

                    if (cpuTempChartInstance.data.labels.length > MAX_POINTS) {
                        cpuTempChartInstance.data.labels.shift();
                        cpuTempChartInstance.data.datasets[0].data.shift();
                    }

                    cpuTempChartInstance.update('none');
                }

                if (cpuChartInstance) {
                    cpuChartInstance.data.labels.push(label);
                    cpuChartInstance.data.datasets[0].data.push(res.cpu_percentage);

                    if (cpuChartInstance.data.labels.length > MAX_POINTS) {
                        cpuChartInstance.data.labels.shift();
                        cpuChartInstance.data.datasets[0].data.shift();
                    }

                    cpuChartInstance.update('none');
                }

                if (memoryChartInstance) {
                    memoryChartInstance.data.labels.push(label);
                    memoryChartInstance.data.datasets[0].data.push(res.memory_percentage);

                    if (memoryChartInstance.data.labels.length > MAX_POINTS) {
                        memoryChartInstance.data.labels.shift();
                        memoryChartInstance.data.datasets[0].data.shift();
                    }

                    memoryChartInstance.update('none');
                }
            });
    }
});