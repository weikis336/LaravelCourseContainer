import Chart from 'chart.js/auto';

window.Echo.channel('server-metrics')
    .listen('.server.metrics.update', (e) => {
        const res = e.resources;

        console.log(res)
    });


let cpuChartInstance = null;
let memoryChartInstance = null;

document.addEventListener('DOMContentLoaded', function() {
    const gridColor = 'rgba(255, 255, 255, 0.1)';
    const textColor = '#9ca3af';

    const commonOptions = { /* tus opciones tal cual */ };

    const cpuCanvas = document.getElementById('cpuChart');
    const memoryCanvas = document.getElementById('memoryChart');

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
            .listen('GetServerMetrics', (e) => {
                const res = e.resources;

                const label = res.recorded_at ?? new Date().toLocaleTimeString();

                if (cpuChartInstance) {
                    cpuChartInstance.data.labels.push(label);
                    cpuChartInstance.data.datasets[0].data.push(res.cpu_percentage);

                    if (cpuChartInstance.data.labels.length > 20) {
                        cpuChartInstance.data.labels.shift();
                        cpuChartInstance.data.datasets[0].data.shift();
                    }

                    cpuChartInstance.update('none');
                }

                if (memoryChartInstance) {
                    memoryChartInstance.data.labels.push(label);
                    memoryChartInstance.data.datasets[0].data.push(res.memory_percentage);

                    if (memoryChartInstance.data.labels.length > 20) {
                        memoryChartInstance.data.labels.shift();
                        memoryChartInstance.data.datasets[0].data.shift();
                    }

                    memoryChartInstance.update('none');
                }
            });
    }
});
