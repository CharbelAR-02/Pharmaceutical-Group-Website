@if (isset($message))
    <span class="d-block fs-6 mt-2">{{ $message }}</span>
@endif
<table class="table" id="medicamentsTable">

    <tbody class="tbody">
        @foreach ($medications as $medication)
            <tr>
                <td>{{ $medication->name }}</td>
                <td>{{ $medication->category }}</td>
                <td>{{ $medication->state }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
