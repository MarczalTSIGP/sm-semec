<div class="input-group mb-2">
  <label class="input-group string required" for="name">
      {{ $label}} @if ($required) <abbr title="obrigatório">*</abbr> @endif
  </label>
  <select class="input-group-text  @if ($required) required @endif"
          @if ($required) required="required" @endif
          autofocus="autofocus" name="{{ $field }}" 
          id="{{ $model }}_{{ $field }}">
    <option value=''> {{$default ?? ''}} </option>
    @if(!empty($options))
          {{ $value_method = isset($value_method) ? $value_method : 'id' }}
          {{ $label_method = isset($label_method) ? $label_method : 'name' }}
          @foreach($options as $option)
            <option value="{{ $option->$value_method }}"
                           {{ $value == $option->$value_method ? 'selected' : '' }} >
                {{ $option->$label_method }}
            </option>
          @endforeach
        @endif
    </select>     
   <input type="text" class="form-control"  name="{{ $fieldNumber }}" placeholder=""  autocomplete="off"/>
</div>