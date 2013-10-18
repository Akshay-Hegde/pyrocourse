<div class="one_full">
	<div class="one_half">

		<section class="title">
			<h4>Lesson Description</h4>
		</section>

		<section class="item">
			<div class="content">

				<table border="0" class="table-list" cellspacing="0">
					<tbody>
						<tr>
							<td>
								<?php echo anchor('admin/pyrocourse/manage/'.$lesson->course_id, get_coursename($lesson->course_id)); ?>
								&raquo;
								<strong><?php echo $lesson->title; ?></strong>
							</td>
						</tr>
						<tr>
							<td style="line-height:16px;">
								<?php echo $lesson->introduction; ?></td>
						</tr>
						<tr>
							<td><strong><?php echo lang('pyrocourse:date_created'); ?></strong><br />
								<?php echo date('d F Y g:i a', $lesson->created); ?></td>
						</tr>
						<tr>
							<td><strong><?php echo lang('pyrocourse:visibility'); ?></strong><br />
								<?php echo $lesson->visibility['value']; ?></td>
						</tr>
						<tr>
							<td><strong><?php echo lang('pyrocourse:status'); ?></strong><br />
								<?php echo $lesson->status['value']; ?></td>
						</tr>
						<tr>
							<td style="text-align:right">
								<?php echo anchor('admin/pyrocourse/edit_lesson/'.$this->uri->segment(4), lang('pyrocourse:edit_lesson'), 'class="button"');?>
								<?php echo anchor('admin/pyrocourse/delete_lesson/'.$this->uri->segment(4), lang('pyrocourse:delete_lesson'), 'class="button delete confirm"');?>
							</td>
						</tr>
					</tbody>
				</table>

			</div>
		</section>
	</div>

	<div class="one_half last">
		<div class="one-full">
			<section class="title">
				<h4>
					<?php echo lang('pyrocourse:content'); ?>
					<?php echo anchor('admin/pyrocourse/content_add/text/'.$this->uri->segment(4), lang('pyrocourse:add_text_content'), 'class="button" style="float:right;margin-right:17px;"');?>
					<?php echo anchor('admin/pyrocourse/content_add/video/'.$this->uri->segment(4), lang('pyrocourse:add_video_content'), 'class="button" style="float:right;margin-right:7px;"');?>
				</h4>
			</section>
			<section class="item">
				<div class="content">

					<?php if(count($contents) > 0): ?>
					<div id="content-list">
						<ul class="sortable small">
							<?php foreach ($contents as $value) : ?>
							<li id="content_<?php echo $value['id']; ?>">
								<div>
									<a href="<?php echo site_url('admin/pyrocourse/content_edit/'.$value['content_type'].'/'.$value['content_id'].'/'.$value['lesson_id']); ?>" 
										class="<?php echo $value['content_type']; ?>" 
										rel="<?php echo $value['id']; ?>"
										title="<?php echo $value['title']; ?>"><?php echo ucfirst($value['content_type']); ?> - <?php echo $value['title']; ?></a>
								</div>
							</li>
							<?php endforeach; ?>
						</ul>
					</div>
					
					<?php else: ?>
						<p class="center">
							<em>There is no content for this course yet.</em>
						</p>
					<?php endif; ?>

				</div>
			</section>
		</div>
		
		<br>

		<div class="one_full">
			
			<section class="title">
				<h4>
					<?php echo lang('pyrocourse:assignments');?>
					<?php echo anchor('admin/pyrocourse/assignment_create/'.$this->uri->segment(4), lang('pyrocourse:add_assignment'), 'class="button" style="float:right;margin-right:17px;"');?>
				</h4>
			</section>

			<section class="item">
				<div class="content">

					<?php if(count($assignment['entries']) > 0): ?>
					<div id="assignment-list">
						<ul class="sortable small">
							<?php foreach ($assignment['entries'] as $value) : ?>
							<li id="assignment_<?php echo $value['id']; ?>">
								<div>
									<a href="<?php echo site_url('admin/pyrocourse/assignment/'.$value['id']); ?>" 
										class="<?php echo $value['status']['key']; ?>" 
										rel="<?php echo $value['id'] ?>"
										title="<?php echo $value['title']; ?>"><?php echo $value['title']; ?></a>
								</div>
							</li>
							<?php endforeach; ?>
						</ul>
					</div>
					
					<?php else: ?>
						<p class="center">
							<em>There is no assignment for this course yet.</em>
						</p>
					<?php endif; ?>

				</div>
			</section>

		</div>

	</div>

</div>