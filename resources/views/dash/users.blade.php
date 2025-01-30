@extends('layouts.adminLayout')
@section('title', 'Lietotaji')
@section('content')
<div class="content">
    <h1>Lietotāji</h1>
    <table class="table">
        <tr class="table-head">
            <th>Vārds</th>
            <th>Epasts</th>
            {{-- <th>Parole</th> --}}
            <th>Darbības</th>
        </tr>
        @foreach ($users as $user)
            <tr class="userTable-row">
                <td><p>{{ $user->name }}</p></td>
                <td><p>{{ $user->email }}</p></td>
                <td class="table-actions">
                    <button class="btn btn-danger" data-action="{{ route('users.destroy', $user->id) }}" onclick="showConfirmPopup('{{ route('users.destroy', $user->id) }}')">
                        Noņemt
                    </button>
                </td>
            </tr>
        @endforeach
    </table>
    {{ $users->links() }}
</div>

<x-confirm-popup>
    Vai tiešām vēlaties izdzēst lietotāju?
</x-confirm-popup>
@endsection