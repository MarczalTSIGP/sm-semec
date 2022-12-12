<form action="{{ $route }}" method="POST" novalidate>
  @csrf
  @method($method)

  <div class="row">
    <div class="col-6">
      @component('components.form.input_select', ['field'    => 'unit_id',
                                                  'label'    => 'Unidade',
                                                  'model'    => 'EdictUnit',
                                                  'value'    => $edictUnit->unit_id,
                                                  'options'  => $units,
                                                  'required' => true,
                                                  'default'  => 'Selecione uma unidade',
                                                  'errors'   => $errors]) @endcomponent
    </div>
    <div class="col-6">
      @component('components.form.input_text', ['field'    => 'number_vacancies',
                                                'label'    => 'Número de vagas',
                                                'model'    => 'edictUnit',
                                                'value'    => $edictUnit->number_vacancies,
                                                'required' => true,
                                                'errors'   => $errors]) @endcomponent
    </div>
  </div>

  @component('components.form.input_submit',['value' => $submit, 'back_url' => route('admin.edicts')]) @endcomponent
</form>

<div>
   <h4 class="mt-5">Vagas cadastradas para cada unidade: </h4>

   <table class="table card-table table-striped table-vcenter table-data w-50">
    <thead>
      <tr>
        <th>Unidade</th>
        <th>Número de vagas</th>
        <th>Tipo de vaga</th>
      </tr>
    </thead>
    <tbody>
      @each('admin.edicts.edicts_units._edicts_units_row', $edictUnits, 'edictUnit')
    </tbody>
  </table>
<div>
