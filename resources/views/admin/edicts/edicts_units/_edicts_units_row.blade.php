<tr scope="row">
  <td>{{$edictUnit->unit_name}}</td>
  <td>{{$edictUnit->vacancies}}</td>
  <td class = "text-left">{{ $edictUnit->type_of_vacancy == 'registered' ? 'Cadastrada no edital' : 'Liberada após servidor assumir outra vaga'}}</td>
</tr>