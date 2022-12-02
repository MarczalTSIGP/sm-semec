<tr>
  <td>{{$classification->rank }}</td>
  <td>{{$classification->inscription->servant->name}}</td>
  <td>{{$classification->inscription->contract->registration}}</td>
  <td>{{ \Carbon\Carbon::now()->diffInDays($classification->inscription->contract->admission_at) }} dias de trabalho</td>
  <td>{{$classification->inscription->contract->servantCompletaryData->formation->formation_name}}</td>
  <td>{{ $classification->worked_days_unit}} dias de trabalho</td>
  <td > 
  @if(!$classification->occupied_vacancy)
    <form action="{{route('admin.update.classifications', $classification->id)}}" method="POST" >
      @csrf
      <input type="submit" class="btn btn-primary ml-auto" value="Assumir vaga"/>
    </form>
  @else
    Assumiu a vaga na unidade de interesse
  @endif



  
  </td>
</tr>