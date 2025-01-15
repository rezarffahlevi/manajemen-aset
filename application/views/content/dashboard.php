<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Beranda
      <small>Selamat Bekerja!</small>
    </h1>
    <ol class="breadcrumb">
      <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <?= $this->session->flashdata("msg") ?>
      </div>
    </div>
    <div class="callout callout-info">
      <h4>Selamat datang <b>
          <?= $this->session->userdata('nama') ?>
        </b>.</h4>
      <p></p>
    </div>
    <!-- Default box -->
    <!-- <div class="box">
       <div class="box-header with-border">
         <h3 class="box-title">Title</h3>
         <div class="box-tools pull-right">
           <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
           <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
         </div>
       </div>
       <div class="box-body">
         Start creating your amazing application!
       </div>

       <div class="box-footer">
         Footer
       </div>
     </div> -->
    <!-- /.box -->
    <div class="box box-primary">
      <div class="box-header">
        <h3 class="box-title">Monitor Material Multemedia</h3>
      </div>
      <div class="box-body">
        <?php
        foreach ($less_stock as $key => $value): ?>
          <div class="row">
            <div class="col-md-12">
              <div class="callout callout-danger">
                <h4>Stok material <b>
                    <?= $value->material ?>
                  </b> number <b><?= $value->number ?></b> tersisa <b><?= $value->jumlah ?></b>
                </h4>
                <p></p>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
		</div>

		<!-- BAR CHART -->
		<div class="box box-success">
			<div class="box-header with-border">
				<i class="fa fa-bar-chart-o"></i>
				<h3 class="box-title">Stok Material</h3>

				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
					</button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				</div>
			</div>
			<div class="box-body">
				<div class="chart">
					<canvas id="barChart" style="height:230px"></canvas>
				</div>
			</div>

  </section><!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>

	let labels = "<?= $material_name ?>".split(',');
	let data = "<?= $stock ?>".split(',');
	
  $(function () {
    var areaChartData = {
      labels: labels,
      datasets: [
        {
          label: "Electronics",
          fillColor: "rgba(210, 214, "+222 + Math.random(0,1000)+", 1)",
          strokeColor: "rgba(210, 214, 222, 1)",
          pointColor: "rgba(210, 214, 222, 1)",
          pointStrokeColor: "#c1c7d1",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(220,220,220,1)",
          data: data
        },
			]
    };

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $("#barChart").get(0).getContext("2d");
    var barChart = new Chart(barChartCanvas);
    var barChartData = areaChartData;
    var barChartOptions = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: true,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - If there is a stroke on each bar
      barShowStroke: true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth: 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing: 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing: 1,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to make the chart responsive
      responsive: true,
      maintainAspectRatio: true
    };

    barChartOptions.datasetFill = false;
    barChart.Bar(barChartData, barChartOptions);
  });

	</script>
