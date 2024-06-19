<h2 style="font-size: 30px; color: #262626;">Grafik Monitoring</h2>

<div id="container"></div>

<script src="../asset/plugin/chart/js/highcharts.js"></script>
<script src="../asset/plugin/chart/js/exporting.js"></script>
<script type="text/javascript">
    Highcharts.chart('container', {
        chart: {
            type: 'area'
        },
        title: {
            text: 'Data Setor Sampah per Hari'
        },
        subtitle: {
            text: 'Source: Bank Sampah Kosmetik Lowayu'
        },
        xAxis: {
            categories: [<?php $query = mysqli_query($conn, "SELECT DISTINCT tanggal_setor FROM setor ORDER BY tanggal_setor"); while($row = mysqli_fetch_array($query)){echo "'".$row['tanggal_setor']."',"; } ?>],
            tickmarkPlacement: 'on',
            title: {
                enabled: false
            }
        },
        yAxis: {
            title: {
                text: 'Berat Sampah (Kg)'
            }
        },
        tooltip: {
            shared: true,
            valueSuffix: ' Kg'
        },
        plotOptions: {
            area: {
                stacking: 'normal',
                lineColor: '#666666',
                lineWidth: 1,
                marker: {
                    lineWidth: 1,
                    lineColor: '#666666'
                }
            }
        },
        series: [{
            name: 'Berat Sampah',
            data: [<?php $query = mysqli_query($conn, "SELECT SUM(berat) AS total_berat FROM setor GROUP BY tanggal_setor"); while($row = mysqli_fetch_array($query)){echo ($row['total_berat']).","; } ?>],
            tooltip: {
                valueSuffix: ' Kg' // tambahkan 'Kg' di belakang nilai tooltip untuk berat sampah
            }
        }]
    });
</script>
