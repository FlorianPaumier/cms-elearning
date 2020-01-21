{{ @View/base|extend }}

@section(title)
    Admin - Event
@endsection

@section(body)
    <h1>Evenements</h1>
<a href="{{ admin_event_new|path }}">Ajout</a>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>slug</th>
                <th>Date de création</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>slug</td>
                <td>11/11/2011</td>
                <td>
                    <a href="{{ admin_event_edit|path }}1">Edit</a>
                </td>
            </tr>
        </tbody>
    </table>
@endsection