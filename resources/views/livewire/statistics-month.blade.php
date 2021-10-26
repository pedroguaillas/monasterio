<div>
    <tr>
        <td>{{ $closure->date }}</td>
        <td>{{ number_format($closure->entry, 2, ',', '.') }}</td>
        <td>{{ number_format($closure->egress, 2, ',', '.') }}</td>
        <td>{{ number_format($closure->entry - $closure->egress, 2, ',', '.') }}</td>
        <td>
            <button class="btn btn-success btn-sm">+</button>
        </td>
    </tr>
</div>