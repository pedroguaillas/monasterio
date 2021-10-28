<div>
    <tr>
        <td>{{ $date }}</td>
        <td>{{ number_format($entry, 2, ',', '.') }}</td>
        <td>{{ number_format($egress, 2, ',', '.') }}</td>
        <td>{{ number_format($entry - $egress, 2, ',', '.') }}</td>
        <td>
            <input type="checkbox" wire:click="levelClicked" value="{{ 'a' .$date }}" wire:model="active" id="a{{ 'a' .$date }}">
            <!-- <a wire:click="collapseddddd(true)" class="btn btn-success btn-sm">+</a> -->
        </td>
    </tr>
    @if($active)
    @foreach($closuresmoth as $item)
    <tr>
        <td>{{ $month }}</td>
        <td>{{ number_format($entry, 2, ',', '.') }}</td>
        <td>{{ number_format($egress, 2, ',', '.') }}</td>
        <td>{{ number_format($entry - $egress, 2, ',', '.') }}</td>
        <td>
            <button class="btn btn-success btn-sm">+</button>
        </td>
    </tr>
    @endforeach
    @endif
</div>