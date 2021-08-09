<form action="{{ $route }}" method="POST" novalidate>
    @csrf
    @method($method)
    @component('components.form.input_text', ['field'    => 'name',
                                              'label'    => 'Nome do Cargo',
                                              'model'    => 'role',
                                              'value'    => $role->name,
                                              'required' => true,
                                              'errors'   => $errors]) @endcomponent

    @component('components.form.input_submit',['value' => $submit, 'back_url' => route('admin.roles')]) @endcomponent
</form>
