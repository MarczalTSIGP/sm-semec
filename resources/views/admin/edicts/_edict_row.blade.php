<tr>
  <td><a href="{{route('admin.show.edict', $edict->id)}}">{{ $edict->title }}</a></td>
  <td>{{ $edict->started_at->toShortDateTime() }}</td>
  <td>{{ $edict->ended_at->toShortDateTime() }}  </td>
  <td >
  @if($edict->ended_at >=  Carbon\Carbon::today())
    <span class="icon mr-1">
        <a href="{{ route('admin.new.vacant_unit', $edict->id)}}" title="Cadastrar vagas por unidade"><i class="fa-solid fa-arrow-up-9-1"></i></a>
    </span>
  @endif

  <span class="icon mr-1">
        <a href="{{ route('admin.classifications', $edict->id)}}" title="Classificação"><i class="fa-solid fa-ranking-star"></i></a>
    </span>
    <span class="icon mr-1">
      <a href="{{ route('admin.inscriptions', $edict->id) }}" data-toggle="tooltip" data-placement="top" title="Inscrições"><i class="fas fa-align-left"></i></a>
    </span>
    <span class="icon mr-1">
        <a href="{{ route('admin.index.pdf', $edict->id) }}"><i class="far fa-file-pdf"></i></a>
    </span>

    @component('components.links.edit', ['url' => route('admin.edit.edict', $edict->id)]) @endcomponent
    @component('components.links.delete', ['url' => route('admin.destroy.edict', $edict->id)]) @endcomponent
   </td>
</tr>