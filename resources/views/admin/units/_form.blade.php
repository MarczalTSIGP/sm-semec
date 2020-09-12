<form action="{{ $route }}" method="POST" enctype="multipart/form-data" novalidate>
    @csrf
    @method($method)
    @component('components.form.input_text', ['field'    => 'name',
                                              'label'    => 'Nome da Unidade',
                                              'model'    => 'unit',
                                              'value'    => $unit->name,
                                              'required' => true,
                                              'errors'   => $errors]) @endcomponent
    
    @component('components.form.input_text', ['field'    => 'address',
                                              'label'    => 'Endereço',
                                              'model'    => 'unit',
                                              'value'    => $unit->address,
                                              'required' => true,
                                              'errors'   => $errors]) @endcomponent

    @component('components.form.input_text', ['field'    => 'phone',
                                              'label'    => 'Telefone',
                                              'model'    => 'unit',
                                              'value'    => $unit->phone,
                                              'required' => true,
                                              'errors'   => $errors]) @endcomponent

    @component('components.form.input_select', ['field'    => 'category_id',
                                              'label'    => 'Categoria',
                                              'model'    => 'unit',
                                              'value'    => $unit->category_id,
                                              'options'  => $categories,
                                              'required' => true,
                                              'errors'   => $errors]) @endcomponent


@component('components.form.input_submit',['value' => $submit, 'back_url' => route('admin.units')]) @endcomponent
</form>
