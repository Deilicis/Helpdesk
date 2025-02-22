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
                    <thead class="bg-primary">
                        <th scope="col">@sortablelink('id', 'ID')</th>
                        <th scope="col">@sortablelink('nozare', 'Nozare')</th>
                        <th scope="col">@sortablelink('virsraksts', 'Virsraksts')</th>
                        <th scope="col">@sortablelink('apraksts', 'Apraksts')</th>
                        <th scope="col">@sortablelink('laiks', 'Laiks')</th>
                        <th scope="col">@sortablelink('epasts', 'Epasts')</th>
                        <th scope="col">@sortablelink('editor', 'Atbildīgais')</th>
                        <th scope="col">@sortablelink('priority', 'Prioritāte')</th>
                        <th scope="col">@sortablelink('status', 'Statuss')</th>
                        <th scope="col">@sortablelink('izvLaiks', 'Izveidošanas Laiks')</th>
                    </thead>
                    <tbody>
                    @foreach ($problems as $problem)
                        <tr class="problemTable-row" data-id="{{ $problem->id }}">
                            <th scope="row"><p>{{ $problem->id }}</p></th>
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
                                @if (auth()->user()->isAdmin())
                                    <form action="{{ route('problems.updateEditor', $problem->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="editor" onchange="this.form.submit()" class="editor-select" onclick="event.stopPropagation();">
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}" {{ $problem->editor == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                @else
                                     <p>{{ $problem->editor?->name ?? 'N/A' }}</p>
                                @endif
                            </td>
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
                                        <option value="procesa" {{ $problem->status == 'procesa' ? 'selected' : '' }}>Procesā</option>
                                        <option value="closed" {{ $problem->status == 'closed' ? 'selected' : '' }}>Closed</option>
                                    </select>
                                    <span class="table-indicator {{ $problem->status }}"></span>
                                </form>
                            </td>
                            <td>
                                <p>{{ $problem->created_at }}</p>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                </table> 
                <div class="pagination">
                    {{ $problems->appends(request()->except('page'))->links() }}
                </div>
            </div>
            <div class="problemHolder" id="problemDetails" style="display: none;">
                <div id="detailsContent">
                    <p id="defaultMessage">Izvēlieties problēmu, lai redzētu tās detaļas</p>
                </div>
                <div id="detailsActions">
                    <button id="backButton" class="btn btn-primary">Atpakaļ</button>
                    <button id="deleteButton" class="btn btn-danger" style="display: none;">Dzēst</button>
                </div>
            </div>
        </section>
    </main>
</div>
@endsection
