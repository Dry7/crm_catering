Время захода сотрудников в CRM {{ $date }}<br /><br />

<table>
    <tr>
        <th>Имя</th>
        <th>Время</th>
    </tr>
    @foreach($staff as $worker)
    <tr>
        <td>{{ $worker->name }}</td>
        <td>{{ $worker->time }}</td>
    </tr>
    @endforeach
</table>