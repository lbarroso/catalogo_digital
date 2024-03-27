<table>

    <thead>
        <tr>
            <th>id</th>
            <th>email</th>

        </tr>
    </thead>
    <tbody>

        @foreach ($users as $item)
            <tr>

                <td>{{ $item->id }}</td>
                <td>{{ $item->email }}</td>
    
            </tr>
        @endforeach
    </tbody>
</table>