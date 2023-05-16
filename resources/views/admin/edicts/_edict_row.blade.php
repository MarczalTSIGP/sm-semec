<tr>
  <td><a href="{{route('admin.show.edict', $edict->id)}}">{{ $edict->title }}</a></td>
  <td>{{ $edict->started_at->toShortDateTime() }}</td>
  <td>{{ $edict->ended_at->toShortDateTime() }}  </td>
  <td >
    <span class="icon mr-1">
      <a href="{{ route('admin.new.vacancies', $edict->id) }}" data-toggle="tooltip" data-placement="top" title="Cadastro de vagas"><i class="fas fa-solid fa-list-ol"></i></a>
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