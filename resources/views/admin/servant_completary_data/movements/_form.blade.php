<form action="{{ $route }}" method="post" novalidate>
    @csrf
    @method($method)

    @component('components.form.input_select', ['field'    => 'occupation',
                                              'label'    => 'Função',
                                              'model'    => 'movement',
                                              'value'    => $movement->occupation,
                                              'options'  => $roles,
                                              'required' => true,
                                              'default'  => 'Selecione uma função',
                                              'errors'   => $errors]) @endcomponent

    @component('components.form.input_radio_button', ['field'    => 'period',
                                              'label'    => 'Período',
                                              'model'    => 'movement',
                                              'values'   => [0 => 'morning' , 1 => 'evening'],
                                              'value'    => $movement->period,
                                              'value_method' => '',
                                              'required' => true,
                                              'errors'   => $errors]) @endcomponent

  @component('components.form.input_select', ['field'    => 'unit_id',
                                              'label'    => 'Lotação',
                                              'model'    => 'movement',
                                              'value'    => $movement->unit_id,
                                              'options'  => $units,
                                              'required' => true,
                                              'default'  => 'Selecione uma Lotação',
                                              'errors'   => $errors]) @endcomponent

    @component('components.form.input_datetimepicker', [
                                              'field'    => 'started_at',
                                              'label'    => 'Início',
                                              'model'    => 'movement',
                                              'value'    => $movement->started_at,
                                              'required' => true,
                                              'errors'   => $errors]) @endcomponent

    @component('components.form.input_datetimepicker', [
                                              'field'    => 'ended_at',
                                              'label'    => 'Término',
                                              'model'    => 'movement',
                                              'value'    => $movement->ended_at,
                                              'required' => true,
                                              'errors'   => $errors]) @endcomponent


   @component('components.form.input_submit',['value' => $submit, 'back_url' => route('admin.index.completary_datas', ['servant_id' => $completaryData->contract->servant_id, 'id' => $completaryData->contract_id])]) @endcomponent
</form>
