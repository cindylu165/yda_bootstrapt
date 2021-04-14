<?php $this->load->view('templates/new_header');?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h4 class="text-dark text-center"><?php echo $title ?></h4>
      <?php if($hasDelegation != '0' && $canInsert != '0'): ?>
        <div class="d-grid gap-2 col-2 mx-auto">
          <a class="btn btn-info m-3" href="<?php echo site_url($url);?>">新增</a>
        </div>
      <?php endif;?>
      <div class="card-content">

        <!-- years -->
				<div class="row">
          <div class="input-field col s10 offset-m2 m8">
            <select name="years" id="years" onchange="location = this.value;">
		
						<?php foreach($years as $i) {?>
            
							<option <?php echo ($yearType == $i['year']) ? 'selected' : ''?> value="<?php echo site_url('/work/get_work_attendance_table_by_organization/' .  $i['year']);?>"><?php echo $i['year']?></option>
            <?php } ?>

            </select>
            <label>年度</label>
          </div>
        </div>

        <a id="print" class="btn waves-effect">列印</a>   

        <table class="highlight centered">
          <thead class="thead-dark">
            <tr>
              <th scope="col">店家名稱</th>
              <th scope="col">時間</th>
              <th scope="col">參與學員</th>
              <th scope="col">要項</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($workAttendances as $i) { ?>
              <tr>
                <td><?php echo $i['name'];?></td>
                <td><?php echo $i['start_time'];?></td>
                <td><?php echo $i['youthName'];?></td>
                <td>
                  <a class="btn waves-effect blue lighten-1" href="<?php echo site_url($url .$i['work_experience'] . '/' .$i['no']);?>">查看/修改</a>   
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">

  $('#print').click(function () {

    document.getElementById('footer').style.display = 'none';

    window.print();
  });

</script>
<?php $this->load->view('templates/new_footer');?>
