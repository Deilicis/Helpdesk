@extends('layouts.adminLayout')
@section('title', 'Dashboard')
@section('content')
<div class="content">
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <main>
        <h1>Problēmas</h1>
        <section class="problemas">
            <div class="problemHolder">
                <table class="table">
                    <tr class="table-head">
                        <th>ID</th>
                        <th>Nozare</th>
                        <th>Virsraksts</th>
                        <th>Apraksts</th>
                        <th>Laiks</th>
                        <th>Epasts</th>
                        {{-- <th>Izveidošanas laiks</th> --}}
                    </tr>
                    @foreach ($problems as $problem)
                    <tr class="problemTable-row" data-id="{{ $problem->id }}">
                            <td>
                                <p>{{ $problem->id }}</p>
                            </td>
                            <td>
                                <p>{{ $problem->nozare }}</p>
                            </td>
                            <td>
                                <p>{{ $problem->virsraksts }}</p>
                            </td>
                            <td>
                                <p id="truncate">{{ $problem->apraksts }}</p>
                            </td>
                            <td>
                                @if ($problem->laiks == null)
                                    <p>-</p>
                                @else
                                    <p>{{ $problem->laiks }}</p>
                                @endif
                            </td>
                            <td>
                                <p>{{ $problem->epasts }}</p>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="problemHolder" id="problemDetails">
                <div>
                    <h1>Problēmas detaļas</h1>
                    <div id="detailsContent">
                        <p id="defaultMessage">Izvēlieties problēmu, lai redzētu tās detaļas</p>
                    </div>
                </div>
            </div>
        </section>
        {{ $problems->links() }}
        </section>
    </main>

</div>
@endsection