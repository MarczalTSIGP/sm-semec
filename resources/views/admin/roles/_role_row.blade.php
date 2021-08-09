<tr>
  <td>{{ $role->name }}</td>
  <td>
    @component('components.links.edit', ['url' => route('admin.edit.role', $role->id)]) @endcomponent
    @component('components.links.delete', ['url' => route('admin.destroy.role', $role->id)]) @endcomponent
  </td>
</tr>
