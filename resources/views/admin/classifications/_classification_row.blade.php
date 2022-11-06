<tr>
  <td>{{$classification->rank }}</td>
  <td>{{$classification->inscription->servant->name}}</td>
  <td>{{$classification->inscription->contract->registration}}</td>
  <td>{{ \Carbon\Carbon::now()->diffInDays($classification->inscription->contract->admission_at) }} dias de trabalho</td>
  <td>{{$classification->inscription->contract->servantCompletaryData->formation->formation_name}}</td>
  <td>{{ $classification->worked_days_unit}} dias de trabalho</td>
</tr>