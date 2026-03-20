// Advanced Chart Components for Skin Trends
class SkinTrendCharts {
    constructor() {
        this.charts = {};
        this.colors = {
            primary: '#7EC8B3',
            secondary: '#F6C1CC',
            tertiary: '#FFD6A5',
            quaternary: '#A8D5C2',
            quinary: '#6B4F4F',
            palette: [
                '#7EC8B3', '#F6C1CC', '#FFD6A5', '#A8D5C2', '#6B4F4F',
                '#4A90E2', '#50E3C2', '#F5A623', '#BD10E0', '#7B68EE'
            ]
        };
        this.init();
    }

    init() {
        this.initializeCharts();
        this.setupEventListeners();
    }

    initializeCharts() {
        // Skin Type Distribution Chart
        this.createSkinTypeChart();
        
        // Skin Concerns Chart
        this.createConcernsChart();
        
        // Popular Ingredients Chart
        this.createIngredientsChart();
        
        // Age Demographics Chart
        this.createAgeChart();
        
        // Seasonal Trends Chart
        this.createSeasonalChart();
        
        // Regional Data Chart
        this.createRegionalChart();
    }

    createSkinTypeChart() {
        const ctx = document.getElementById('skinTypeChart');
        if (!ctx) return;

        this.charts.skinType = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: this.getChartData('skinTypes').labels,
                datasets: [{
                    data: this.getChartData('skinTypes').data,
                    backgroundColor: this.colors.palette.slice(0, 5),
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: (context) => {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        });
    }

    createConcernsChart() {
        const ctx = document.getElementById('concernsChart');
        if (!ctx) return;

        this.charts.concerns = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: this.getChartData('concerns').labels,
                datasets: [{
                    label: 'Number of Users',
                    data: this.getChartData('concerns').data,
                    backgroundColor: this.colors.primary,
                    borderColor: this.colors.primary,
                    borderWidth: 1,
                    borderRadius: 8,
                    barThickness: 40
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    },
                    y: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 12,
                                weight: '500'
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleFont: {
                            size: 14
                        },
                        bodyFont: {
                            size: 12
                        },
                        padding: 12,
                        cornerRadius: 8
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeInOutQuart'
                }
            }
        });
    }

    createIngredientsChart() {
        const ctx = document.getElementById('ingredientsChart');
        if (!ctx) return;

        this.charts.ingredients = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: this.getChartData('ingredients').labels,
                datasets: [{
                    label: 'Usage Count',
                    data: this.getChartData('ingredients').data,
                    backgroundColor: this.colors.secondary,
                    borderColor: this.colors.secondary,
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    },
                    y: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 12,
                                weight: '500'
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            afterLabel: (context) => {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed.x / total) * 100).toFixed(1);
                                return `${percentage}% of total usage`;
                            }
                        }
                    }
                }
            }
        });
    }

    createAgeChart() {
        const ctx = document.getElementById('ageChart');
        if (!ctx) return;

        this.charts.age = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: this.getChartData('age').labels,
                datasets: [{
                    data: this.getChartData('age').data,
                    backgroundColor: [
                        this.colors.primary,
                        this.colors.secondary,
                        this.colors.tertiary,
                        this.colors.quaternary,
                        this.colors.quinary
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            padding: 10,
                            font: {
                                size: 11
                            },
                            generateLabels: (chart) => {
                                const data = chart.data;
                                if (data.labels.length && data.datasets.length) {
                                    return data.labels.map((label, i) => {
                                        const dataset = data.datasets[0];
                                        const value = dataset.data[i];
                                        const total = dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = ((value / total) * 100).toFixed(1);
                                        return {
                                            text: `${label} (${percentage}%)`,
                                            fillStyle: dataset.backgroundColor[i],
                                            hidden: false,
                                            index: i
                                        };
                                    });
                                }
                                return [];
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: (context) => {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return `${label}: ${value} users (${percentage}%)`;
                            }
                        }
                    }
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        });
    }

    createSeasonalChart() {
        const ctx = document.getElementById('seasonalChart');
        if (!ctx) return;

        this.charts.seasonal = new Chart(ctx, {
            type: 'line',
            data: {
                labels: this.getChartData('seasonal').labels,
                datasets: [{
                    label: 'Average Skin Score',
                    data: this.getChartData('seasonal').data,
                    borderColor: this.colors.primary,
                    backgroundColor: this.hexToRgba(this.colors.primary, 0.1),
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: this.colors.primary,
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 5,
                        ticks: {
                            stepSize: 1,
                            font: {
                                size: 11
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 12,
                                weight: '500'
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleFont: {
                            size: 14
                        },
                        bodyFont: {
                            size: 12
                        },
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            afterLabel: (context) => {
                                const seasonalData = this.getSeasonalData();
                                const season = context.label;
                                const data = seasonalData.find(s => s.label === season);
                                if (data) {
                                    return `Top Concern: ${data.top_concern}`;
                                }
                                return '';
                            }
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                animation: {
                    duration: 1500,
                    easing: 'easeInOutQuart'
                }
            }
        });
    }

    createRegionalChart() {
        const ctx = document.getElementById('regionalChart');
        if (!ctx) return;

        this.charts.regional = new Chart(ctx, {
            type: 'polarArea',
            data: {
                labels: this.getChartData('regional').labels,
                datasets: [{
                    data: this.getChartData('regional').data,
                    backgroundColor: [
                        this.hexToRgba(this.colors.primary, 0.7),
                        this.hexToRgba(this.colors.secondary, 0.7),
                        this.hexToRgba(this.colors.tertiary, 0.7),
                        this.hexToRgba(this.colors.quaternary, 0.7),
                        this.hexToRgba(this.colors.quinary, 0.7)
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    r: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 10,
                            font: {
                                size: 11
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: (context) => {
                                const label = context.label || '';
                                const value = context.parsed.r || 0;
                                return `${label}: ${value} users`;
                            }
                        }
                    }
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        });
    }

    setupEventListeners() {
        // Handle window resize
        window.addEventListener('resize', () => {
            Object.values(this.charts).forEach(chart => {
                if (chart) chart.resize();
            });
        });

        // Handle filter changes
        const filters = ['periodFilter', 'skinTypeFilter', 'concernFilter'];
        filters.forEach(filterId => {
            const element = document.getElementById(filterId);
            if (element) {
                element.addEventListener('change', () => {
                    this.updateCharts();
                });
            }
        });
    }

    updateCharts() {
        // Show loading state
        this.showLoadingState();

        // Fetch updated data
        this.fetchUpdatedData()
            .then(data => {
                this.updateChartsData(data);
                this.hideLoadingState();
            })
            .catch(error => {
                console.error('Error updating charts:', error);
                this.hideLoadingState();
            });
    }

    async fetchUpdatedData() {
        const period = document.getElementById('periodFilter')?.value || '30days';
        const skinType = document.getElementById('skinTypeFilter')?.value || 'all';
        const concern = document.getElementById('concernFilter')?.value || 'all';

        const response = await fetch(`/api/skin-trends/data?type=all&period=${period}&skin_type=${skinType}&concern=${concern}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error('Failed to fetch updated data');
        }

        return response.json();
    }

    updateChartsData(data) {
        // Update each chart with new data
        if (data.skin_types && this.charts.skinType) {
            this.charts.skinType.data.labels = data.skin_types.chart_data.map(item => item.label);
            this.charts.skinType.data.datasets[0].data = data.skin_types.chart_data.map(item => item.value);
            this.charts.skinType.update();
        }

        if (data.concerns && this.charts.concerns) {
            this.charts.concerns.data.labels = Object.keys(data.concerns.top_concerns).map(k => ucfirst(k));
            this.charts.concerns.data.datasets[0].data = Object.values(data.concerns.top_concerns);
            this.charts.concerns.update();
        }

        if (data.ingredients && this.charts.ingredients) {
            this.charts.ingredients.data.labels = Object.keys(data.ingredients.top_ingredients).map(k => ucfirst(k));
            this.charts.ingredients.data.datasets[0].data = Object.values(data.ingredients.top_ingredients);
            this.charts.ingredients.update();
        }

        if (data.age_demographics && this.charts.age) {
            this.charts.age.data.labels = data.age_demographics.chart_data.map(item => item.label);
            this.charts.age.data.datasets[0].data = data.age_demographics.chart_data.map(item => item.value);
            this.charts.age.update();
        }

        if (data.seasonal && this.charts.seasonal) {
            this.charts.seasonal.data.labels = data.seasonal.chart_data.map(item => item.label);
            this.charts.seasonal.data.datasets[0].data = data.seasonal.chart_data.map(item => item.avg_score);
            this.charts.seasonal.update();
        }

        if (data.regional && this.charts.regional) {
            this.charts.regional.data.labels = data.regional.chart_data.map(item => item.region);
            this.charts.regional.data.datasets[0].data = data.regional.chart_data.map(item => item.users);
            this.charts.regional.update();
        }
    }

    showLoadingState() {
        Object.values(this.charts).forEach(chart => {
            if (chart && chart.canvas) {
                chart.canvas.style.opacity = '0.5';
            }
        });
    }

    hideLoadingState() {
        Object.values(this.charts).forEach(chart => {
            if (chart && chart.canvas) {
                chart.canvas.style.opacity = '1';
            }
        });
    }

    // Helper methods
    getChartData(type) {
        // This would typically come from the server
        // For now, return placeholder data
        const data = {
            skinTypes: {
                labels: ['Oily', 'Dry', 'Combination', 'Sensitive', 'Normal'],
                data: [25, 30, 20, 15, 10]
            },
            concerns: {
                labels: ['Acne', 'Hyperpigmentation', 'Aging', 'Dryness'],
                data: [45, 38, 32, 28]
            },
            ingredients: {
                labels: ['Retinol', 'Vitamin C', 'Hyaluronic Acid', 'Niacinamide'],
                data: [120, 98, 85, 72]
            },
            age: {
                labels: ['18-24', '25-34', '35-44', '45-54', '55+'],
                data: [15, 35, 25, 15, 10]
            },
            seasonal: {
                labels: ['Spring', 'Summer', 'Fall', 'Winter'],
                data: [3.8, 4.2, 3.6, 3.4]
            },
            regional: {
                labels: ['North', 'South', 'East', 'West', 'Central'],
                data: [120, 95, 110, 85, 75]
            }
        };

        return data[type] || { labels: [], data: [] };
    }

    getSeasonalData() {
        return [
            { label: 'Spring', top_concern: 'Acne' },
            { label: 'Summer', top_concern: 'Oily Skin' },
            { label: 'Fall', top_concern: 'Dryness' },
            { label: 'Winter', top_concern: 'Dryness' }
        ];
    }

    hexToRgba(hex, alpha) {
        const r = parseInt(hex.slice(1, 3), 16);
        const g = parseInt(hex.slice(3, 5), 16);
        const b = parseInt(hex.slice(5, 7), 16);
        return `rgba(${r}, ${g}, ${b}, ${alpha})`;
    }

    // Export chart as image
    exportChart(chartName, filename = null) {
        const chart = this.charts[chartName];
        if (!chart) return;

        const url = chart.toBase64Image();
        const link = document.createElement('a');
        link.download = filename || `${chartName}_${new Date().toISOString().split('T')[0]}.png`;
        link.href = url;
        link.click();
    }

    // Export all charts
    exportAllCharts() {
        Object.keys(this.charts).forEach(chartName => {
            setTimeout(() => {
                this.exportChart(chartName);
            }, 100 * Object.keys(this.charts).indexOf(chartName));
        });
    }

    // Print charts
    printCharts() {
        const originalContent = document.body.innerHTML;
        
        // Create print-friendly version
        const printContent = document.createElement('div');
        printContent.innerHTML = `
            <h1 style="text-align: center; margin-bottom: 30px;">Skin Trends Report</h1>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                ${Object.values(this.charts).map(chart => `
                    <div style="break-inside: avoid;">
                        <canvas id="${chart.canvas.id}" style="max-width: 100%; height: auto;"></canvas>
                    </div>
                `).join('')}
            </div>
        `;

        document.body.innerHTML = printContent.innerHTML;
        
        // Recreate charts in print view
        setTimeout(() => {
            this.initializeCharts();
            window.print();
            document.body.innerHTML = originalContent;
            this.initializeCharts();
        }, 500);
    }

    // Destroy all charts
    destroy() {
        Object.values(this.charts).forEach(chart => {
            if (chart) chart.destroy();
        });
        this.charts = {};
    }
}

// Initialize charts when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    window.skinTrendCharts = new SkinTrendCharts();
});

// Global functions for external access
window.exportSkinChart = function(chartName) {
    if (window.skinTrendCharts) {
        window.skinTrendCharts.exportChart(chartName);
    }
};

window.exportAllSkinCharts = function() {
    if (window.skinTrendCharts) {
        window.skinTrendCharts.exportAllCharts();
    }
};

window.printSkinCharts = function() {
    if (window.skinTrendCharts) {
        window.skinTrendCharts.printCharts();
    }
};
