<?php $__env->startSection("contentheader_title", "Edit Field: ".$field->label); ?>
<?php $__env->startSection("contentheader_description", "from ".$module->model." module"); ?>
<?php $__env->startSection("section", "Module ".$module->name); ?>
<?php $__env->startSection("section_url", url(config('laraadmin.adminRoute') . '/modules/'.$module->id)); ?>
<?php $__env->startSection("sub_section", "Edit Field"); ?>

<?php $__env->startSection("htmlheader_title", "Field Edit : ".$field->label); ?>

<?php $__env->startSection("main-content"); ?>
<div class="box">
	<div class="box-header">
		
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<?php echo Form::model($field, ['route' => [config('laraadmin.adminRoute') . '.module_fields.update', $field->id ], 'method'=>'PUT', 'id' => 'field-edit-form']); ?>

					<?php echo e(Form::hidden("module_id", $module->id)); ?>

					
					<div class="form-group">
						<label for="label">Field Label :</label>
						<?php echo e(Form::text("label", null, ['class'=>'form-control', 'placeholder'=>'Field Label', 'data-rule-minlength' => 2, 'data-rule-maxlength'=>20, 'required' => 'required'])); ?>

					</div>
					
					<div class="form-group">
						<label for="colname">Column Name :</label>
						<?php echo e(Form::text("colname", null, ['class'=>'form-control', 'placeholder'=>'Column Name (lowercase)', 'data-rule-minlength' => 2, 'data-rule-maxlength'=>20, 'data-rule-banned-words' => 'true', 'required' => 'required'])); ?>

					</div>
					
					<div class="form-group">
						<label for="field_type">UI Type:</label>
						<?php echo e(Form::select("field_type", $ftypes, null, ['class'=>'form-control', 'required' => 'required'])); ?>

					</div>
					
					<div id="unique_val">
						<div class="form-group">
							<label for="unique">Unique:</label>
							<?php echo e(Form::checkbox("unique", "unique")); ?>

							<div class="Switch Round Off" style="vertical-align:top;margin-left:10px;"><div class="Toggle"></div></div>
						</div>
					</div>

					<div class="form-group">
						<label for="defaultvalue">Default Value :</label>
						<?php echo e(Form::text("defaultvalue", null, ['class'=>'form-control', 'placeholder'=>'Default Value'])); ?>

					</div>
					
					<div id="length_div">
						<div class="form-group">
							<label for="minlength">Minimum :</label>
							<?php echo e(Form::number("minlength", null, ['class'=>'form-control', 'placeholder'=>'Default Value'])); ?>

						</div>
						
						<div class="form-group">
							<label for="maxlength">Maximum :</label>
							<?php echo e(Form::number("maxlength", null, ['class'=>'form-control', 'placeholder'=>'Default Value'])); ?>

						</div>
					</div>
					
					<div class="form-group">
						<label for="required">Required:</label>
						<?php echo e(Form::checkbox("required", "required")); ?>

						<div class="Switch Round Off" style="vertical-align:top;margin-left:10px;"><div class="Toggle"></div></div>
					</div>
					
					<div class="form-group values">
						<label for="popup_vals">Values :</label>
						<?php
						$default_val = "";
						$popup_value_type_table = false;
						$popup_value_type_list = false;
						if(starts_with($field->popup_vals, "@")) {
							$popup_value_type_table = true;
							$default_val = str_replace("@", "", $field->popup_vals);
						} else if(starts_with($field->popup_vals, "[")) {
							$popup_value_type_list = true;
							$default_val = json_decode($field->popup_vals);
						}
						?>
						<div class="radio" style="margin-bottom:20px;">
							<label><?php echo e(Form::radio("popup_value_type", "table", $popup_value_type_table)); ?> From Table</label>
							<label><?php echo e(Form::radio("popup_value_type", "list", $popup_value_type_list)); ?> From List</label>
						</div>
						<?php echo e(Form::select("popup_vals_table", $tables, $default_val, ['class'=>'form-control', 'rel' => ''])); ?>

						
						<select class="form-control popup_vals_list" rel="taginput" multiple="1" data-placeholder="Add Multiple values (Press Enter to add)" name="popup_vals_list[]">
							<?php if(is_array($default_val)): ?>
								<?php foreach($default_val as $value): ?>
									<option selected><?php echo e($value); ?></option>
								<?php endforeach; ?>
							<?php endif; ?>
						</select>
						
						<?php
						// print_r($tables);
						?>
					</div>
					
                    <br>
					<div class="form-group">
						<?php echo Form::submit( 'Update', ['class'=>'btn btn-success']); ?> <button class="btn btn-default pull-right"><a href="<?php echo e(url(config('laraadmin.adminRoute') . '/modules/'.$module->id)); ?>">Cancel</a></button>
					</div>
				<?php echo Form::close(); ?>

				
				<?php if($errors->any()): ?>
				<ul class="alert alert-danger">
					<?php foreach($errors->all() as $error): ?>
						<li><?php echo e($error); ?></li>
					<?php endforeach; ?>
				</ul>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$(function () {
	$("select.popup_vals_list").show();
	$("select.popup_vals_list").next().show();
	$("select[name='popup_vals_table']").hide();
	
	function showValuesSection() {
		var ft_val = $("select[name='field_type']").val();
		if(ft_val == 7 || ft_val == 15 || ft_val == 18 || ft_val == 20) {
			$(".form-group.values").show();
		} else {
			$(".form-group.values").hide();
		}
		
		$('#length_div').removeClass("hide");
		if(ft_val == 2 || ft_val == 4 || ft_val == 5 || ft_val == 7 || ft_val == 9 || ft_val == 11 || ft_val == 12 || ft_val == 15 || ft_val == 18 || ft_val == 21 || ft_val == 24 ) {
			$('#length_div').addClass("hide");
		}
		
		$('#unique_val').removeClass("hide");
		if(ft_val == 1 || ft_val == 2 || ft_val == 3 || ft_val == 7 || ft_val == 9 || ft_val == 11 || ft_val == 12 || ft_val == 15 || ft_val == 18 || ft_val == 20 || ft_val == 21 || ft_val == 24 ) {
			$('#unique_val').addClass("hide");
		}
	}

	$("select[name='field_type']").on("change", function() {
		showValuesSection();
	});
	showValuesSection();

	function showValuesTypes() {
		console.log($("input[name='popup_value_type']:checked").val());
		if($("input[name='popup_value_type']:checked").val() == "list") {
			$("select.popup_vals_list").show();
			$("select.popup_vals_list").next().show();
			$("select[name='popup_vals_table']").hide();
		} else {
			$("select[name='popup_vals_table']").show();
			$("select.popup_vals_list").hide();
			$("select.popup_vals_list").next().hide();
		}
	}
	
	$("input[name='popup_value_type']").on("change", function() {
		showValuesTypes();
	});
	showValuesTypes();

	$.validator.addMethod("data-rule-banned-words", function(value) {
		return $.inArray(value, ['files']) == -1;
	}, "Column name not allowed.");

	$("#field-edit-form").validate({
		
	});
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make("la.layouts.app", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>