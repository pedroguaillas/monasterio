<div>
    <td>
        <a href="#" class="btn btn-success btn-sm">+</a>
    </td>
    @if($closuresmoth !== null && count($closuresmoth))
    @foreach($closuresmoth as $item)
    <table>
        <tbody>
            <tr>
                <td>{{ $item->date }}</td>
                <td>{{ number_format($item->entry, 2, ',', '.') }}</td>
                <td>{{ number_format($item->egress, 2, ',', '.') }}</td>
                <td>{{ number_format($item->entry - $item->egress, 2, ',', '.') }}</td>
                <td>
                    <a href="#" class="btn btn-success btn-sm">+</a>
                </td>
            </tr>
        </tbody>
    </table>
    @endforeach
    @endif
</div>