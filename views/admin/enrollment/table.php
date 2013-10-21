<?php if($enroll['total'] > 0): ?>
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

<?php else: ?>
	<div class="no_data">Filtered enrollment data not found.</div>
<?php endif; ?>