@extend(templates/back)

@section(body)

<table>
    <thead>
    <tr>
        <th></th>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($forms as $form): ?>
            <tr>
                <td>Id</td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

@endsection