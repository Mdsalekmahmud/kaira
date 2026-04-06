<form method="POST" action="{{ $route }}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm"
            onclick="return confirm('{{ $confirmMessage ?? 'Are you sure?' }}')">
        {{ $slot ?? 'Delete' }}
    </button>
</form>