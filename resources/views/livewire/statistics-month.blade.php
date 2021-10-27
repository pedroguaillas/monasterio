<div>
    <tr>
        <td>{{ $date }}</td>
        <td>{{ number_format($entry, 2, ',', '.') }}</td>
        <td>{{ number_format($egress, 2, ',', '.') }}</td>
        <td>{{ number_format($entry - $egress, 2, ',', '.') }}</td>
        <td>
            <button class="btn btn-success btn-sm">+</button>
        </td>
    </tr>
</div>