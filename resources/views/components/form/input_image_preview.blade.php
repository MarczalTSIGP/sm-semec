<div id="box-image-preview" data-toggle="tooltip" data-placement="left" title="{{$label}}">
	<div class="input-field image_preview">
		<div class="box-image center">
			
			<img src="{{$asset}}"  class="file_preview active" id="image">
			
			<div class="form-group file optional user_profile_image form-group-valid">
				<input id="{{ $model}}_{{ $field}}" accept="image/*" type="file" name="{{ $field}}" class="form-control-file is-valid file optional image_validate">
			</div>
		</div>
	</div>
	<div class="text-box text-center">
		<p class="text-input"> {{ $label }}</p>
	</div>
</div>

