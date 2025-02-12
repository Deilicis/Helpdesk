@extends('layouts.adminLayout')
@section('title', 'Dashboard')
@section('content')
<div class="content">
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <main>
        <h1>Problēmas</h1>
        <section class="problems">
            <div class="problemHolder" id="problemTable">
                <table class="table">
                    <tr class="table-head">
                        <th>@sortablelink('id', 'ID')</th>
                        <th>@sortablelink('nozare', 'Nozare')</th>
                        <th>@sortablelink('virsraksts', 'Virsraksts')</th>
                        <th>@sortablelink('apraksts', 'Apraksts')</th>
                        <th>@sortablelink('laiks', 'Laiks')</th>
                        <th>@sortablelink('epasts', 'Epasts')</th>
                        <th>@sortablelink('priority', 'Prioritāte')</th>
                        <th>@sortablelink('status', 'Statuss')</th>
                    </tr>
                    @foreach ($problems as $problem)
                        <tr class="problemTable-row" data-id="{{ $problem->id }}">
                            <td><p>{{ $problem->id }}</p></td>
                            <td><p>{{ $problem->nozare }}</p></td>
                            <td><p>{{ $problem->virsraksts }}</p></td>
                            <td><p>{{ $problem->apraksts }}</p></td>
                            <td>
                                @if ($problem->laiks == null)
                                    <p>-</p>
                                @else
                                    <p>{{ $problem->laiks }}</p>
                                @endif
                            </td>
                            <td><p>{{ $problem->epasts }}</p></td>
                            <td class="non-clickable">
                                <form action="{{ route('problems.updatePriority', $problem->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="priority" onchange="this.form.submit()" class="priority-select" onclick="event.stopPropagation();">
                                        <option value="low" {{ $problem->priority == 'low' ? 'selected' : '' }}>Low</option>
                                        <option value="high" {{ $problem->priority == 'high' ? 'selected' : '' }}>High</option>
                                        <option value="critical" {{ $problem->priority == 'critical' ? 'selected' : '' }}>Critical</option>
                                    </select>
                                    <span class="priority-indicator {{ $problem->priority }}"></span>
                                </form>
                            </td>
                            <td class="non-clickable">
                                <form action="{{ route('problems.updateStatus', $problem->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="table-select" onclick="event.stopPropagation();">
                                        <option value="open" {{ $problem->status == 'open' ? 'selected' : '' }}>Open</option>
                                        <option value="closed" {{ $problem->status == 'closed' ? 'selected' : '' }}>Closed</option>
                                    </select>
                                    <span class="table-indicator {{ $problem->status }}"></span>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table> 
                <div class="pagination">
                    {{ $problems->appends(request()->except('page'))->links() }}
                </div>
            </div>
            <div class="problemHolder" id="problemDetails" style="display: none;">
                <div>
                    <div id="detailsContent">
                        <p id="defaultMessage">Izvēlieties problēmu, lai redzētu tās detaļas</p>
                    </div>
                    <div id="detailsActions">
                        <button id="backButton" class="btn back-button">Atpakaļ</button>
                        <button id="deleteButton" class="btn delete-button" style="display: none;">Dzēst</button>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>
@endsection
