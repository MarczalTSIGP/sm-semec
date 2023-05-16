<form action="{{ $route }}" method="POST" enctype="multipart/form-data" novalidate>
    @csrf
    @method($method)
    @component('components.form.input_select', ['field'  => 'unit_id',
                                              'label'    => 'Unidade',
                                              'model'    => 'edictUnit',
                                              'value'    => $edictUnit->unit_id,
                                              'options'  => $units,
                                              'required' => true,
                                              'default'  => 'Selecione uma unidade',
                                              'errors'   => $errors]) @endcomponent

    @component('components.form.input_text', ['field'    => 'available_vacancies',
                                              'label'    => 'Quantidade de vagas',
                                              'model'    => 'edictUnit',
                                              'value'    => $edictUnit->available_vacancies,
                                              'required' => true,
                                              'errors'   => $errors]) @endcomponent
    
    <input type="hidden" name="edict_id" value="{{ $edict->id }}">

    @component('components.form.input_submit',['value' => $submit, 'back_url' => route('admin.edicts')]) @endcomponent

</form>