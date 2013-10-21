<div class="one_full">
	
	<section class="title">
		<h4><?php echo $title; ?></h4>
	</section>

	<section class="item">
		<div class="content">
			<?php if($enroll['total'] > 0): ?>

			<fieldset id="filters">
				<legend>Filters</legend>
				<ul>
					<li>
						<label for="f_course">Course</label>
						<select name="course" id="course">
							<option value="all">All</option>
							<?php foreach ($course['entries'] as $value): ?>
								<option value="<?php echo $value['id']; ?>"><?php echo $value['title']; ?></option>
							<?php endforeach; ?>
						</select>
					</li>
					<li>
						<label for="f_status">Enroll Status</label>
						<select name="enroll_status" id="status">
							<option value="all">All</option>
							<option value="pending">Pending</option>
							<option value="ongoing">On Going</option>
							<option value="completed">Completed</option>
							<option value="canceled">Canceled</option>
							<option value="dropped">Dropped</option>
						</select>
					</li>
				</ul>
			</fieldset>
			
			<div class="datatable">
				<table border="0" class="table-list" cellspacing="0">
					<thead>
						<tr>
							<th>Student</th>
							<th>Course</th>
							<th>Class</th>
							<th>Enroll Status</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($enroll['entries'] as $row): ?>
						<tr class="<?php echo $row['odd_even']; ?> ">
							<td><?php echo $row['student_id']['first_name'].' '.$row['student_id']['last_name']; ?></td>
							<td><?php echo $row['course_id']['title']; ?></td>
							<td><?php echo $row['class_id']['title']; ?></td>
							<td><?php echo $row['enroll_status']['value']; ?></td>
							<td style="text-align:right">
								<a class="button" href="<?php echo site_url('admin/enrollment/edit/'.$row['id']); ?>">Edit</a>
								<a class="button" href="<?php echo site_url('admin/enrollment/delete/'.$row['id']); ?>">Delete</a>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>

			<?php else: ?>
				<div class="no_data">There is no one enroll yet</div>
			<?php endif; ?>

		</div>
	</section>

	<script>
		$('select#course, select#status').change(function(){
			var course = $('select#course').val();
			var status = $('select#status').val();
			var oldcourse = $('.datatable').data('course');
			var oldstatus = $('.datatable').data('status');
			// alert(course + ' ' + status + ' ' + oldcourse + ' ' + oldstatus);
			if(oldcourse != course || oldstatus != status){
				$('.datatable').fadeOut(200).empty()
				.html('<div class="no_data">Loading..</div>');
				$.ajax({
					type: 'POST',
					url: BASE_URL + 'admin/course/enrollment/table_ajax/' + course + '/' + status,
					data: {course:course, status:status}
				}).done(function(resp){
					$('.datatable').fadeOut().empty();
					$('.datatable').html(resp).fadeIn()
					.data('course',course)
					.data('status',status);
				});
			}

		});
	</script>
	<style>.button{display:inline-block !important;}</style>

</div>