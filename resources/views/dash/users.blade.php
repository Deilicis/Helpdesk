@extends('layouts.adminLayout')
@section('title', 'Lietotaji')
@section('content')
<div class="content">
    <h1>Lietotāji</h1>
    <div class="userHolder">
    <table class="table">
        <thead class="bg-primary">
            <th>Vārds</th>
            <th>Epasts</th>
            {{-- <th>Parole</th> --}}
            <th>Darbības</th>
        </thead>
        @foreach ($users as $user)
            <tr class="userTable-row">
                <td><p>{{ $user->name }}</p></td>
                <td><p>{{ $user->email }}</p></td>
                <td class="table-actions">
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Noņemt</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    <div class="pagination">
        {{ $users->appends(request()->except('page'))->links() }}
    </div>
</div>
</div>

@endsection