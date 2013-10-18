<div class="one_full">
	<div class="one_half">

		<section class="title">
			<h4>Course Description</h4>
		</section>

		<section class="item">
			<div class="content">

				<table border="0" class="table-list" cellspacing="0">
					<tbody>
						<tr>
							<td>
								<strong><?php echo $course->title; ?></strong>
							</td>
						</tr>
						<tr>
							<td style="line-height:16px;">
								<strong><?php echo lang('pyrocourse:description'); ?></strong><br />
								<?php echo $course->introduction; ?></td>
						</tr>
						<tr>
							<td><strong><?php echo lang('pyrocourse:date_created'); ?></strong><br />
								<?php echo date('d F Y g:i a', $course->created); ?></td>
						</tr>
						<tr>
							<td><strong><?php echo lang('pyrocourse:visibility'); ?></strong><br />
								<?php echo $course->visibility['value']; ?></td>
						</tr>
						<tr>
							<td><strong><?php echo lang('pyrocourse:status'); ?></strong><br />
								<?php echo $course->status['value']; ?></td>
						</tr>
						<tr>
							<td style="text-align:right">
								<?php echo anchor('admin/pyrocourse/course_edit/'.$this->uri->segment(4), lang('pyrocourse:edit_course'), 'class="button"');?>
								<?php echo anchor('admin/pyrocourse/course_delete/'.$this->uri->segment(4), lang('pyrocourse:delete_course'), 'class="button delete confirm"');?>
							</td>
						</tr>
					</tbody>
				</table>

			</div>
		</section>
	</div>

	<div class="one_half last">

		<section class="title">
			<h4>
				<?php echo lang('pyrocourse:lessons');?>
				<?php echo anchor('admin/pyrocourse/lesson_create/'.$this->uri->segment(4), lang('pyrocourse:new_lesson'), 'class="button" style="float:right;margin-right:17px;"');?>
			</h4>
		</section>

		<section class="item">
			<div class="content">

				<?php if(count($lesson['entries']) > 0): ?>
				<div id="lesson-list">
					<ul class="sortable">
						<?php foreach ($lesson['entries'] as $value) : ?>
						<li id="lesson_<?php echo $value['id']; ?>">
							<div>
								<a href="<?php echo site_url('admin/pyrocourse/lesson_manage/'.$value['id']); ?>" 
									class="<?php echo $value['status']['key'].' '.$value['visibility']['key']; ?>" 
									rel="<?php echo $value['id'] ?>"
									title="<?php echo $value['title']; ?>"><?php echo $value['title']; ?></a>
								<em><span><br>2 assignments</span></em>
							</div>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
				
				<?php else: ?>
					<p class="center">
						<em>There is no lesson for this course yet.</em>
					</p>
				<?php endif; ?>

			</div>
		</section>

	</div>

</div>