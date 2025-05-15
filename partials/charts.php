<!-- ChartJS -->
<script src="../public/plugins/chart.js/Chart.min.js"></script>
<!-- Phân tích dữ liệu -->
<?php require_once('../partials/analytics.php'); ?>
<!-- Khởi tạo biểu đồ -->
<script>
    $(function() {

        /* Số lượng phòng theo từng loại */
        var roomNumberChart = $('#NumberOfRoomsAsType').get(0).getContext('2d')
        var roomNumberChartData = {
            labels: [
                'Phòng đôi',
                'Phòng penthouse',
                'Phòng thường lớn',
                'Phòng đơn',
                'Phòng tổng thống',
                'Phòng deluxe',
            ],
            datasets: [{
                data: [<?php echo $double; ?>, <?php echo $penthouse; ?>, <?php echo $regular; ?>, <?php echo $single; ?>, <?php echo $presidential; ?>, <?php echo $deluxe; ?>],
                backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
            }]
        }
        var roomNumberChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
        }

        var donutChart = new Chart(roomNumberChart, {
            type: 'doughnut',
            data: roomNumberChartData,
            options: roomNumberChartOptions
        })

        /* Số lượt đặt phòng theo từng loại */
        var roomReservationsChart = $('#roomReservations').get(0).getContext('2d')
        var roomReservationsChartData = {
            labels: [
                'Phòng đôi',
                'Phòng penthouse',
                'Phòng thường lớn',
                'Phòng đơn',
                'Phòng tổng thống',
                'Phòng deluxe',
            ],
            datasets: [{
                data: [<?php echo $resDouble; ?>, <?php echo $resPenthouse; ?>, <?php echo $resRegular; ?>, <?php echo $resSingle; ?>, <?php echo $resPresidential; ?>, <?php echo $resDeluxe; ?>],
                backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
            }]
        }
        var roomReservationsChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
        }

        var pieChart = new Chart(roomReservationsChart, {
            type: 'pie',
            data: roomReservationsChartData,
            options: roomReservationsChartOptions
        })

        /* Doanh thu theo từng loại phòng */
        var RoomsIncomeChart = $('#RoomsIncome').get(0).getContext('2d')
        var RoomsIncomeChartData = {
            labels: [
                'Phòng đôi',
                'Phòng penthouse',
                'Phòng thường lớn',
                'Phòng đơn',
                'Phòng tổng thống',
                'Phòng deluxe',
            ],
            datasets: [{
                data: [<?php echo $Double; ?>, <?php echo $Penthouse; ?>, <?php echo $Regular; ?>, <?php echo $Single; ?>, <?php echo $Presidential; ?>, <?php echo $Deluxe; ?>],
                backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
            }]
        }
        var RoomsIncomeChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
        }

        var donutChart = new Chart(RoomsIncomeChart, {
            type: 'doughnut',
            data: RoomsIncomeChartData,
            options: RoomsIncomeChartOptions
        })

    })
</script>