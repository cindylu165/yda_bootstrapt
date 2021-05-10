<?php $this->load->view('templates/new_header'); ?>

<div class="breadcrumb-div">
	<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item active" style="color:blue;" aria-current="page">
				<a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
			</li>
			<li class="breadcrumb-item active" style="color:blue;" aria-current="page">
				<a href="#"><?php echo '報表管理'; ?></a>
			</li>
			<li class="breadcrumb-item active" style="color:blue;" aria-current="page">
				<a href="<?php echo site_url('/report/counseling_member_count_report_table/' . $yearType . '/' . $monthType); ?>"><?php echo '每月執行進度表清單'; ?></a>
			</li>
			<li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
		</ol>
	</nav>
</div>

<div class="container" style="width:100%;">
	<div class="row">
		<div class="card-body col-sm-12">
			<!-- <div class="row">
				<div class="col-sm-6">
					<a class="btn btn-success" href="<?php echo site_url('/report/counseling_member_count_report_table/' . $yearType . '/' . $monthType); ?>">←每月執行進度表清單</a>
				</div>
			</div> -->
			<h4 class="card-title text-center"><?php echo $title ?></h4>
      <h6 class="card-title text-center"><?php echo '民國'  . $yearType . '年' . $monthType . '月'; ?></h6>

			<div class="card-content">

				<form action="<?php echo site_url($url); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
					<input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>" value="<?php echo $security->get_csrf_hash() ?>" />


					<!-- years -->
					<div class="row justify-content-center">
						<div class="col-sm-10 col-md-8 mb-3">
							<label>年度</label>
							<select class="form-select form-select-lg" name="years" id="years" onchange="location = this.value;">

								<?php foreach ($years as $i) { ?>

									<option <?php echo ($yearType == ($i['year'])) ? 'selected' : '' ?> value="<?php echo site_url('report/funding_execute_report_yda_table/' . $i['year'] . '/' . $monthType . '/' . $countyType); ?>"><?php echo $i['year'] ?></option>
								<?php } ?>

							</select>
						</div>
					</div>

					<!-- months -->
					<div class="row justify-content-center">
						<div class="col-sm-10 col-md-8 mb-3">
							<label>月份</label>
							<select class="form-select form-select-lg" name="months" id="months" onchange="location = this.value;">

								<?php foreach ($months as $i) { ?>

									<option <?php echo ($monthType == $i) ? 'selected' : '' ?> value="<?php echo site_url('report/funding_execute_report_yda_table/'  . $yearType . '/' . $i . '/' . $countyType); ?>"><?php echo $i ?></option>
								<?php } ?>

							</select>
						</div>
					</div>

					<!-- counties -->
					<div class="row justify-content-center">
						<div class="col-sm-10 col-md-8 mb-3">
							<label>縣市</label>
							<select class="form-select form-select-lg" name="counties" id="counties" onchange="location = this.value;">
								<option <?php echo ($countyType == 'all') ? 'selected' : '' ?> value="<?php echo site_url('report/funding_execute_report_yda_table/'  . $yearType . '/' . $monthType . '/all'); ?>">全部</option>
								<?php foreach ($countiesName as $i) { ?>
									<option <?php echo ($countyType == $i['no']) ? 'selected' : '' ?> value="<?php echo site_url('report/funding_execute_report_yda_table/'  . $yearType . '/' . $monthType . '/' . $i['no']); ?>"><?php echo $i['name'] ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<?php $total = 0;
					$county_table = [];
					if ($countyType != 'all') {
						for ($i = 0; $i < count($counties); $i++) {
							foreach ($counties[$i] as $cValue) {
								if ($cValue == $countyType) {
									$county_table[$i] = $counties[$i];
								}
							}
						}
						// print_r($county_table);
					} else {
						$county_table = $counties;
						// print_r($county_table);
					} ?>


					<a class="btn btn-success" href="<?php echo site_url('export/yda_month_report_export/' . 'fundingExecuteReport' . '/' . $yearType . '/' . $monthType); ?>"><?php echo $title ?>表列印(下載EXCEL檔)</a>
          <a class="btn btn-success" href="<?php echo site_url('export/yda_month_report_export/' . 'fundingExecuteReport' . '/' . $yearType . '/' . $monthType . '/ods'); ?>"><?php echo $title?>表列印(下載ODS檔)</a>
					<br /><br />


					<div class="row justify-content-center">
						<table class="table table-hover table-bordered align-middle text-center" style="border:2px grey solid;">
							<thead class="header">
								<tr>
									<th scope="col">縣市</th>
									<th scope="col">青年署核定經費A</th>
									<th scope="col">青年署已撥付金額</th>
									<th scope="col">青年署待撥付金額</th>
									<th scope="col">縣市執行經費B</th>
									<th scope="col">縣市截至<?php echo $monthType ?>月執行率C=(B/A)*100</th>

								</tr>
							</thead>
							<?php
							for ($j = 0; $j < count($counties); $j++) {
							?>
								<tbody>
									<tr>
										<?php if ($reportProcessesCountyStatusArray[$j] != $reviewStatus['review_process_pass']) { ?>
											<td colspan="6"><?php echo $counties[$j]['name'] . '尚未送出報表' ?></td>
										<?php } else { ?>
											<td><?php echo $counties[$j]['name']; ?></td>
											<td><?php echo number_format($projectArray[$j]->funding); ?></td>
											<td><?php echo number_format($fundingApproveArray[$j]->sum); ?></td>
											<td><?php echo number_format($projectArray[$j]->funding - $fundingApproveArray[$j]->sum); ?></td>
											<td><?php echo number_format($counselingMemberCountReportArray[$j]->funding_execute); ?></td>
											<?php $projectArray[$j]->funding = $projectArray[$j]->funding ? $projectArray[$j]->funding : 1; ?>
											<td><?php echo round(($counselingMemberCountReportArray[$j]->funding_execute / $projectArray[$j]->funding), 2) * 100 . '%'; ?></td>


										<?php  } ?>
									</tr>

								<?php } ?>

								<tr>
									<td>總計</td>
									<td><?php echo number_format($sumDetail['projectFunding']); ?></td>
									<td><?php echo number_format($sumDetail['fundingApprove']); ?></td>
									<td><?php echo number_format($sumDetail['fundingApproveNotYet']); ?></td>
									<td><?php echo number_format($sumDetail['fundingExecute']); ?></td>
									<?php $sumDetail['projectFunding'] = $sumDetail['projectFunding'] ? $sumDetail['projectFunding'] : 1; ?>
									<td><?php echo round(($sumDetail['fundingExecute'] / $sumDetail['projectFunding']), 2) * 100 . '%'; ?></td>
								</tr>

								</tbody>
						</table>
					</div>
					<br />

			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('#download').click(function() {
		var data = $("#form").html();
		if (data == '') {
			alert('請先搜尋您想要下載的數據');
		} else {
			var html = "<html><head><meta   charset= 'utf-8'></head><body>" + data + "</body></html>";
			window.open('data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,' + encodeURIComponent(html));
		}
	});

	function downloadCSV(csv, filename) {
		var csvFile;
		var downloadLink;

		// CSV file
		csvFile = new Blob(["\uFEFF" + csv], {
			type: 'text/csv;charset=utf-8;'
		});

		// Download link
		downloadLink = document.createElement("a");

		// File name
		downloadLink.download = filename;

		// Create a link to the file
		downloadLink.href = window.URL.createObjectURL(csvFile);

		// Hide download link
		downloadLink.style.display = "none";

		// Add the link to DOM
		document.body.appendChild(downloadLink);

		// Click download link
		downloadLink.click();
	}

	function exportTableToCSV(report, filename) {
		var csv = [];
		var rows = document.querySelectorAll(report + "table tr");

		for (var i = 0; i < rows.length; i++) {
			var row = [],
				cols = rows[i].querySelectorAll("td, th");
			if (i % 2 != 0 || i == 0) {
				for (var j = 0; j < cols.length; j++)

					row.push(cols[j].innerText);
				csv.push(row.join(","));
			}

		}
		// Download CSV file
		downloadCSV(csv.join("\n"), filename);
	}
</script>

<?php $this->load->view('templates/new_footer'); ?>