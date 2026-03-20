// Advanced Seller Performance Charts
class SellerPerformanceCharts {
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
        // Top Performers Chart
        this.createTopPerformersChart();
        
        // Revenue Analysis Chart
        this.createRevenueChart();
        
        // Fulfillment Metrics Chart
        this.createFulfillmentChart();
        
        // Satisfaction Scores Chart
        this.createSatisfactionChart();
        
        // Growth Trends Chart
        this.createGrowthChart();
        
        // Top Products Chart
        this.createTopProductsChart();
        
        // Category Performance Chart
        this.createCategoryChart();
    }

    createTopPerformersChart() {
        const ctx = document.getElementById('topPerformersChart');
        if (!ctx) return;

        this.charts.topPerformers = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: this.getChartData('topPerformers').labels,
                datasets: [{
                    label: 'Performance Score',
                    data: this.getChartData('topPerformers').data,
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
                        max: 100,
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
                        callbacks: {
                            afterLabel: (context) => {
                                const index = context.dataIndex;
                                const performerData = this.getTopPerformersData();
                                if (performerData[index]) {
                                    const performer = performerData[index];
                                    return [
                                        `Revenue: $${performer.revenue.toFixed(2)}`,
                                        `Orders: ${performer.orders}`,
                                        `Fulfillment: ${performer.fulfillment_rate.toFixed(1)}%`,
                                        `Rating: ${performer.satisfaction_score.toFixed(1)}/5.0`
                                    ];
                                }
                                return [];
                            }
                        }
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeInOutQuart'
                }
            }
        });

        // Populate table with data
        this.populateTopPerformersTable();
    }

    createRevenueChart() {
        const ctx = document.getElementById('revenueChart');
        if (!ctx) return;

        this.charts.revenue = new Chart(ctx, {
            type: 'line',
            data: {
                labels: this.getChartData('revenue').labels,
                datasets: [{
                    label: 'Monthly Revenue',
                    data: this.getChartData('revenue').data,
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
                        ticks: {
                            font: {
                                size: 11
                            },
                            callback: function(value) {
                                return '$' + value.toLocaleString();
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
                            label: (context) => {
                                return `Revenue: $${context.parsed.y.toLocaleString()}`;
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

        // Populate revenue distribution
        this.populateRevenueDistribution();
    }

    createFulfillmentChart() {
        const ctx = document.getElementById('fulfillmentChart');
        if (!ctx) return;

        this.charts.fulfillment = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: this.getChartData('fulfillment').labels,
                datasets: [{
                    data: this.getChartData('fulfillment').data,
                    backgroundColor: [
                        '#10B981', '#7EC8B3', '#F6C1CC', '#FFD6A5', '#A8D5C2'
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
                                return `${label}: ${value} sellers (${percentage}%)`;
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

        // Populate fulfillment distribution
        this.populateFulfillmentDistribution();
    }

    createSatisfactionChart() {
        const ctx = document.getElementById('satisfactionChart');
        if (!ctx) return;

        this.charts.satisfaction = new Chart(ctx, {
            type: 'radar',
            data: {
                labels: this.getChartData('satisfaction').labels,
                datasets: [{
                    label: 'Average Rating',
                    data: this.getChartData('satisfaction').data,
                    borderColor: this.colors.secondary,
                    backgroundColor: this.hexToRgba(this.colors.secondary, 0.2),
                    borderWidth: 2,
                    pointBackgroundColor: this.colors.secondary,
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    r: {
                        beginAtZero: true,
                        max: 5,
                        ticks: {
                            stepSize: 1,
                            font: {
                                size: 10
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: (context) => {
                                return `${context.label}: ${context.parsed.r.toFixed(1)}/5.0`;
                            }
                        }
                    }
                },
                animation: {
                    duration: 1200,
                    easing: 'easeInOutQuart'
                }
            }
        });

        // Populate satisfaction distribution
        this.populateSatisfactionDistribution();
    }

    createGrowthChart() {
        const ctx = document.getElementById('growthChart');
        if (!ctx) return;

        this.charts.growth = new Chart(ctx, {
            type: 'line',
            data: {
                labels: this.getChartData('growth').labels,
                datasets: [{
                    label: 'New Sellers',
                    data: this.getChartData('growth').newSellers,
                    borderColor: this.colors.tertiary,
                    backgroundColor: this.hexToRgba(this.colors.tertiary, 0.1),
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    yAxisID: 'y'
                }, {
                    label: 'Revenue Growth',
                    data: this.getChartData('growth').revenue,
                    borderColor: this.colors.primary,
                    backgroundColor: this.hexToRgba(this.colors.primary, 0.1),
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    yAxisID: 'y1'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'New Sellers',
                            font: {
                                size: 11
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Revenue ($)',
                            font: {
                                size: 11
                            }
                        },
                        grid: {
                            drawOnChartArea: false
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
                        position: 'bottom',
                        labels: {
                            padding: 10,
                            font: {
                                size: 11
                            }
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
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

        // Populate growth trends
        this.populateGrowthTrends();
    }

    createTopProductsChart() {
        const ctx = document.getElementById('topProductsChart');
        if (!ctx) return;

        this.charts.topProducts = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: this.getChartData('topProducts').labels,
                datasets: [{
                    label: 'Revenue',
                    data: this.getChartData('topProducts').data,
                    backgroundColor: this.colors.quaternary,
                    borderColor: this.colors.quaternary,
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
                            },
                            callback: function(value) {
                                return '$' + value.toLocaleString();
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
                                const index = context.dataIndex;
                                const productData = this.getTopProductsData();
                                if (productData[index]) {
                                    const product = productData[index];
                                    return [
                                        `Seller: ${product.seller}`,
                                        `Orders: ${product.orders}`,
                                        `Rating: ${product.rating.toFixed(1)}/5.0`
                                    ];
                                }
                                return [];
                            }
                        }
                    }
                }
            }
        });

        // Populate top products table
        this.populateTopProductsTable();
    }

    createCategoryChart() {
        const ctx = document.getElementById('categoryChart');
        if (!ctx) return;

        this.charts.category = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: this.getChartData('category').labels,
                datasets: [{
                    label: 'Average Revenue',
                    data: this.getChartData('category').revenue,
                    backgroundColor: this.colors.quinary,
                    borderColor: this.colors.quinary,
                    borderWidth: 1,
                    borderRadius: 8
                }, {
                    label: 'Average Orders',
                    data: this.getChartData('category').orders,
                    backgroundColor: this.colors.primary,
                    borderColor: this.colors.primary,
                    borderWidth: 1,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
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
                        position: 'bottom',
                        labels: {
                            padding: 10,
                            font: {
                                size: 11
                            }
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                animation: {
                    duration: 1200,
                    easing: 'easeInOutQuart'
                }
            }
        });

        // Populate category table
        this.populateCategoryTable();
    }

    setupEventListeners() {
        // Handle window resize
        window.addEventListener('resize', () => {
            Object.values(this.charts).forEach(chart => {
                if (chart) chart.resize();
            });
        });

        // Handle filter changes
        const filters = ['periodFilter', 'sellerStatusFilter', 'minRevenueFilter', 'minOrdersFilter'];
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
        const sellerStatus = document.getElementById('sellerStatusFilter')?.value || 'all';
        const minRevenue = document.getElementById('minRevenueFilter')?.value || 0;
        const minOrders = document.getElementById('minOrdersFilter')?.value || 0;

        const response = await fetch(`/api/seller-performance/data?type=all&period=${period}&seller_status=${sellerStatus}&min_revenue=${minRevenue}&min_orders=${minOrders}`, {
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
        if (data.top_performers && this.charts.topPerformers) {
            this.updateTopPerformersChart(data.top_performers);
        }

        if (data.revenue_analysis && this.charts.revenue) {
            this.updateRevenueChart(data.revenue_analysis);
        }

        if (data.fulfillment_metrics && this.charts.fulfillment) {
            this.updateFulfillmentChart(data.fulfillment_metrics);
        }

        if (data.satisfaction_scores && this.charts.satisfaction) {
            this.updateSatisfactionChart(data.satisfaction_scores);
        }

        if (data.growth_trends && this.charts.growth) {
            this.updateGrowthChart(data.growth_trends);
        }

        if (data.product_performance && this.charts.topProducts) {
            this.updateTopProductsChart(data.product_performance);
        }
    }

    // Helper methods for populating tables and additional data
    populateTopPerformersTable() {
        const tableBody = document.getElementById('topPerformersTable');
        if (!tableBody) return;

        const performers = this.getTopPerformersData();
        tableBody.innerHTML = '';

        performers.forEach((performer, index) => {
            const row = document.createElement('tr');
            row.className = 'border-b border-gray-100 hover:bg-gray-50';
            row.innerHTML = `
                <td class="px-4 py-2 text-sm font-medium text-gray-900">
                    <div class="flex items-center">
                        <span class="text-xs font-semibold text-gray-500 mr-2">${index + 1}</span>
                        ${performer.seller}
                    </div>
                </td>
                <td class="px-4 py-2 text-sm text-gray-900">$${performer.revenue.toFixed(2)}</td>
                <td class="px-4 py-2 text-sm text-gray-900">${performer.orders}</td>
                <td class="px-4 py-2 text-sm text-gray-900">
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium" style="background-color: ${this.getFulfillmentColor(performer.fulfillment_rate)}20; color: ${this.getFulfillmentColor(performer.fulfillment_rate)}">
                        ${performer.fulfillment_rate.toFixed(1)}%
                    </span>
                </td>
                <td class="px-4 py-2 text-sm text-gray-900">
                    <div class="flex items-center">
                        <span class="text-yellow-400 mr-1">★</span>
                        ${performer.satisfaction_score.toFixed(1)}
                    </div>
                </td>
                <td class="px-4 py-2 text-sm text-gray-900">
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium" style="background-color: ${this.getPerformanceColor(performer.performance_score)}20; color: ${this.getPerformanceColor(performer.performance_score)}">
                        ${performer.performance_score.toFixed(1)}
                    </span>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    populateRevenueDistribution() {
        const container = document.getElementById('revenueRanges');
        if (!container) return;

        const ranges = [
            { label: '$0-$1,000', value: 15, color: '#6B4F4F' },
            { label: '$1,000-$5,000', value: 35, color: '#A8D5C2' },
            { label: '$5,000-$10,000', value: 25, color: '#FFD6A5' },
            { label: '$10,000-$25,000', value: 20, color: '#F6C1CC' },
            { label: '$25,000+', value: 5, color: '#7EC8B3' }
        ];

        container.innerHTML = ranges.map(range => `
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">${range.label}</span>
                <div class="flex items-center space-x-2">
                    <div class="w-16 bg-gray-200 rounded-full h-2">
                        <div class="h-2 rounded-full" style="width: ${range.value}%; background-color: ${range.color}"></div>
                    </div>
                    <span class="text-sm font-medium text-gray-900 w-8 text-right">${range.value}%</span>
                </div>
            </div>
        `).join('');
    }

    populateFulfillmentDistribution() {
        const container = document.getElementById('fulfillmentDistribution');
        if (!container) return;

        const distribution = [
            { label: '96-100%', value: 45, color: '#10B981' },
            { label: '86-95%', value: 30, color: '#7EC8B3' },
            { label: '71-85%', value: 20, color: '#F6C1CC' },
            { label: '51-70%', value: 4, color: '#FFD6A5' },
            { label: '0-50%', value: 1, color: '#6B4F4F' }
        ];

        container.innerHTML = distribution.map(item => `
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">${item.label}</span>
                <span class="text-sm font-medium text-gray-900">${item.value} sellers</span>
            </div>
        `).join('');
    }

    populateSatisfactionDistribution() {
        const container = document.getElementById('scoreDistribution');
        if (!container) return;

        const distribution = [
            { label: '4-5 stars', value: 65, color: '#10B981' },
            { label: '3-4 stars', value: 25, color: '#7EC8B3' },
            { label: '2-3 stars', value: 8, color: '#F6C1CC' },
            { label: '1-2 stars', value: 2, color: '#6B4F4F' }
        ];

        container.innerHTML = distribution.map(item => `
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">${item.label}</span>
                <span class="text-sm font-medium text-gray-900">${item.value}%</span>
            </div>
        `).join('');
    }

    populateGrowthTrends() {
        const container = document.getElementById('newSellersTrend');
        if (!container) return;

        const trends = [
            { month: 'Jan', sellers: 5 },
            { month: 'Feb', sellers: 8 },
            { month: 'Mar', sellers: 12 },
            { month: 'Apr', sellers: 7 },
            { month: 'May', sellers: 15 },
            { month: 'Jun', sellers: 10 }
        ];

        container.innerHTML = trends.map(trend => `
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">${trend.month}</span>
                <span class="text-sm font-medium text-gray-900">+${trend.sellers}</span>
            </div>
        `).join('');
    }

    populateTopProductsTable() {
        const tableBody = document.getElementById('topProductsTable');
        if (!tableBody) return;

        const products = this.getTopProductsData();
        tableBody.innerHTML = '';

        products.forEach((product, index) => {
            const row = document.createElement('tr');
            row.className = 'border-b border-gray-100 hover:bg-gray-50';
            row.innerHTML = `
                <td class="px-4 py-2 text-sm font-medium text-gray-900">${product.name}</td>
                <td class="px-4 py-2 text-sm text-gray-900">${product.seller}</td>
                <td class="px-4 py-2 text-sm text-gray-900">$${product.revenue.toFixed(2)}</td>
                <td class="px-4 py-2 text-sm text-gray-900">${product.orders}</td>
                <td class="px-4 py-2 text-sm text-gray-900">
                    <div class="flex items-center">
                        <span class="text-yellow-400 mr-1">★</span>
                        ${product.rating.toFixed(1)}
                    </div>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    populateCategoryTable() {
        const tableBody = document.getElementById('categoryTable');
        if (!tableBody) return;

        const categories = this.getCategoryData();
        tableBody.innerHTML = '';

        categories.forEach((category, index) => {
            const row = document.createElement('tr');
            row.className = 'border-b border-gray-100 hover:bg-gray-50';
            row.innerHTML = `
                <td class="px-4 py-2 text-sm font-medium text-gray-900">${category.name}</td>
                <td class="px-4 py-2 text-sm text-gray-900">$${category.avgRevenue.toFixed(2)}</td>
                <td class="px-4 py-2 text-sm text-gray-900">${category.avgOrders}</td>
                <td class="px-4 py-2 text-sm text-gray-900">
                    <div class="flex items-center">
                        <span class="text-yellow-400 mr-1">★</span>
                        ${category.avgRating.toFixed(1)}
                    </div>
                </td>
                <td class="px-4 py-2 text-sm text-gray-900">
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-jade-green text-white">
                        #${category.rank}
                    </span>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    // Helper methods for getting chart data
    getChartData(type) {
        // This would typically come from the server
        // For now, return placeholder data
        const data = {
            topPerformers: {
                labels: ['Sarah Johnson', 'Mike Chen', 'Emma Wilson', 'James Brown', 'Lisa Anderson'],
                data: [95, 88, 82, 78, 72]
            },
            revenue: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                data: [45000, 52000, 48000, 61000, 58000, 67000]
            },
            fulfillment: {
                labels: ['96-100%', '86-95%', '71-85%', '51-70%', '0-50%'],
                data: [45, 30, 20, 4, 1]
            },
            satisfaction: {
                labels: ['Product Quality', 'Shipping Speed', 'Customer Service', 'Communication', 'Packaging'],
                data: [4.5, 4.2, 4.7, 4.3, 4.6]
            },
            growth: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                newSellers: [5, 8, 12, 7, 15, 10],
                revenue: [45000, 52000, 48000, 61000, 58000, 67000]
            },
            topProducts: {
                labels: ['Retinol Serum', 'Vitamin C Cream', 'Hyaluronic Acid', 'Niacinamide Booster', 'AHA Toner'],
                data: [12000, 8500, 7200, 6800, 5900]
            },
            category: {
                labels: ['Serums', 'Moisturizers', 'Cleansers', 'Toners', 'Masks'],
                revenue: [8500, 7200, 5800, 4500, 3200],
                orders: [120, 95, 78, 62, 45]
            }
        };

        return data[type] || { labels: [], data: [] };
    }

    getTopPerformersData() {
        return [
            { seller: 'Sarah Johnson', revenue: 12500, orders: 85, fulfillment_rate: 98.5, satisfaction_score: 4.7, performance_score: 95 },
            { seller: 'Mike Chen', revenue: 9800, orders: 72, fulfillment_rate: 96.2, satisfaction_score: 4.5, performance_score: 88 },
            { seller: 'Emma Wilson', revenue: 8200, orders: 68, fulfillment_rate: 94.8, satisfaction_score: 4.3, performance_score: 82 },
            { seller: 'James Brown', revenue: 7500, orders: 55, fulfillment_rate: 92.1, satisfaction_score: 4.4, performance_score: 78 },
            { seller: 'Lisa Anderson', revenue: 6800, orders: 48, fulfillment_rate: 89.7, satisfaction_score: 4.2, performance_score: 72 }
        ];
    }

    getTopProductsData() {
        return [
            { name: 'Retinol Serum', seller: 'Sarah Johnson', revenue: 12000, orders: 45, rating: 4.8 },
            { name: 'Vitamin C Cream', seller: 'Mike Chen', revenue: 8500, orders: 38, rating: 4.6 },
            { name: 'Hyaluronic Acid', seller: 'Emma Wilson', revenue: 7200, orders: 32, rating: 4.5 },
            { name: 'Niacinamide Booster', seller: 'James Brown', revenue: 6800, orders: 28, rating: 4.4 },
            { name: 'AHA Toner', seller: 'Lisa Anderson', revenue: 5900, orders: 25, rating: 4.3 }
        ];
    }

    getCategoryData() {
        return [
            { name: 'Serums', avgRevenue: 8500, avgOrders: 45, avgRating: 4.6, rank: 1 },
            { name: 'Moisturizers', avgRevenue: 7200, avgOrders: 38, avgRating: 4.5, rank: 2 },
            { name: 'Cleansers', avgRevenue: 5800, avgOrders: 32, avgRating: 4.4, rank: 3 },
            { name: 'Toners', avgRevenue: 4500, avgOrders: 25, avgRating: 4.3, rank: 4 },
            { name: 'Masks', avgRevenue: 3200, avgOrders: 18, avgRating: 4.2, rank: 5 }
        ];
    }

    // Helper methods for colors and utilities
    getPerformanceColor(score) {
        if (score >= 90) return '#7EC8B3';
        if (score >= 80) return '#F6C1CC';
        if (score >= 70) return '#FFD6A5';
        if (score >= 60) return '#A8D5C2';
        return '#6B4F4F';
    }

    getFulfillmentColor(rate) {
        if (rate >= 95) return '#10B981';
        if (rate >= 90) return '#7EC8B3';
        if (rate >= 85) return '#F6C1CC';
        if (rate >= 80) return '#FFD6A5';
        if (rate >= 75) return '#A8D5C2';
        return '#6B4F4F';
    }

    hexToRgba(hex, alpha) {
        const r = parseInt(hex.slice(1, 3), 16);
        const g = parseInt(hex.slice(3, 5), 16);
        const b = parseInt(hex.slice(5, 7), 16);
        return `rgba(${r}, ${g}, ${b}, ${alpha})`;
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
            <h1 style="text-align: center; margin-bottom: 30px;">Seller Performance Report</h1>
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
    window.sellerPerformanceCharts = new SellerPerformanceCharts();
});

// Global functions for external access
window.exportSellerChart = function(chartName) {
    if (window.sellerPerformanceCharts) {
        window.sellerPerformanceCharts.exportChart(chartName);
    }
};

window.exportAllSellerCharts = function() {
    if (window.sellerPerformanceCharts) {
        window.sellerPerformanceCharts.exportAllCharts();
    }
};

window.printSellerCharts = function() {
    if (window.sellerPerformanceCharts) {
        window.sellerPerformanceCharts.printCharts();
    }
};
