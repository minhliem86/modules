<div class="chart-container">
    <canvas id="myChart"></canvas>
    <script>
        const ctx = document.getElementById('myChart');
        const myChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: [
                    @foreach($ga as $v)
                        "{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $v['date'])->toDateString()}}",
                    @endforeach
                ],
                datasets:[
                    {
                        label: 'Visitors',
                        data: [
                            @foreach($ga as $item_visitor)
                                "{{$item_visitor['visitors']}}",
                            @endforeach
                        ],
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255,99,132,1)'
                    },
                    {
                        label: 'Pageviews',
                        data: [
                            @foreach($ga as $item_pageview)
                                "{{$item_pageview['pageViews']}}",
                            @endforeach
                        ],
                        backgroundColor: 'rgba(131, 173, 239, 0.2)',
                        borderColor: 'rgba(131, 173, 239, 1)'
                    }
                ],
            },
            options: {
                responsive: true,
                title:{
                    display: true,
                    text: 'Dữ liệu khách hàng truy cập website',
                    position: 'bottom'
                },
                legend :{
                    position: 'bottom'
                }
            }
        });
    </script>
</div>
