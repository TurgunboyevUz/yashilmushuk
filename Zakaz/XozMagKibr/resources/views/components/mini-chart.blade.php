<div
    x-data="{
        chart: null,
        init() {
            this.chart = new ApexCharts(this.$refs.chart, {
                chart: {
                    type: 'line',
                    height: 50,
                    sparkline: { enabled: true },
                },
                series: [{
                    data: {{ json_encode($data) }},
                }],
                colors: ['#10b981'], // green-500 by default
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
            })
            this.chart.render()
        }
    }"
    x-init="init"
>
    <div x-ref="chart"></div>
</div>