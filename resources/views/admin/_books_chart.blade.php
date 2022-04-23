<div id="books-chart"></div>

<script>
    $(function () {
        var options = {
            chart: {
                type: 'bar',
                height: 350,
            },
            plotOptions: {
                bar: {
                    columnWidth: '50%',
                    borderRadius: 20,
                }

            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            dataLabels: {
                enabled: false
            },
            fill: {
                colors: ['#009688']
            },
            series: [{
                name: "@lang('books.total_books')",
                data: @json($books->pluck('total_books')->toArray())
            }],
            xaxis: {
                categories: @json($books->pluck('month')->toArray())
            }
        }

        var booksChart = new ApexCharts(document.querySelector("#books-chart"), options);

        booksChart.render();
    });//end of document ready
</script>