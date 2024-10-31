@props(['field', 'sortField', 'sortDirection', 'label'])

<th>
    <a wire:click.prevent="sortBy('{{ $field }}')" role="button" href="#">
        {{ $label }}
        @if ($sortField === $field)
            @if ($sortDirection === 'asc')
                ↑
            @else
                ↓
            @endif
        @endif
    </a>
</th>