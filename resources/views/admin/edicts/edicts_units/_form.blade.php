<form action="{{ $route }}" method="POST" novalidate>
@csrf
@method($method)
@component('components.form.input_units', [
                                              'title'    => 'Vagas disponíveis por unidade',
                                              'label'    => 'Selecione a unidade e inclua a quantidade de vagas',
                                              'field'    => 'unit_id',
                                              'fieldNumber' => 'number_vacancies',
                                              'model'    => 'edictUnit',
                                              'options'  => $units,
                                              'value'    => 'unit',
                                              'value_method_number' => 'number_vacancies',
                                              'default'  => 'Selecione a unidade',
                                              'value_method'  => 'id',
                                              'label_method'  => 'name',
                                              'required' => true,
                                              'errors'   => $errors]) @endcomponent  
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

@component('components.form.input_submit',['value' => $submit, 'back_url' => route('admin.edicts')]) @endcomponent
</form>