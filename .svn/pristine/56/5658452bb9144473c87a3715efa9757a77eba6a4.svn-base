<?php $__env->startSection("contentheader_title", "LA Code Editor"); ?>
<?php $__env->startSection("contentheader_description", "Installation instructions"); ?>
<?php $__env->startSection("section", "LA Code Editor"); ?>
<?php $__env->startSection("sub_section", "Not installed"); ?>
<?php $__env->startSection("htmlheader_title", "Install LA Code Editor"); ?>

<?php $__env->startSection('main-content'); ?>

<div class="box">
	<div class="box-header">
		
	</div>
	<div class="box-body">
		<p>LaraAdmin Code Editor does not comes inbuilt now. You can get it by following commands.</p>
		<pre><code>composer require dwij/laeditor</code></pre>
		<p>This will download the editor package. Not install editor by following command:</p>
		<pre><code>php artisan la:editor</code></pre>
		<p>Now refresh this page or go to <a href="<?php echo e(url(config('laraadmin.adminRoute') . '/laeditor')); ?>"><?php echo e(url(config('laraadmin.adminRoute') . '/laeditor')); ?></a>.</p>
	</div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$(function () {
	
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('la.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>