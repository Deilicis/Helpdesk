@extends('layouts.guestLayout')

@section('title', 'Form')

@section('content')
    <main div class="content">
        <div class="formCont">
            <h1>Problēma</h1>
            <form action="{{ url('/nosutit') }}" method="post" enctype="multipart/form-data" class="form">
                @csrf
                <div class="inputCont" autofocus>
                    <x-input-label for="nozare" class="label" :value="__('Nozare')"/>
                    <select name="nozare" id="nozare" class="input">
                        <option value="Ielas">Ielas</option>
                        <option value="Ēkas">Ēkas</option>
                        <option value="Elektrība">Elektrība</option>
                        <option value="Ūdens">Ūdens</option>
                        <option value="Daba">Daba</option>
                        <option value="Cits">Cits</option>
                    </select>
                </div>

                <div class="inputCont" id="customNozareCont" style="display: none;">
                    <input id="customNozare" class="input" type="text" name="customNozare" maxlength="60" placeholder="Norādiet nozari"/>
                </div>

                <div class="inputCont">
                    <x-input-label for="title" class="label" :value="__('Virsraksts')"/>
                    <input id="title" class="input" type="text" name="virsraksts" required maxlength="60"/>
                </div>
                <div class="inputCont">
                    <x-input-label for="description" class="label" :value="__('Apraksts')" />
                    <textarea id="description" class="input" type="text" name="apraksts" required rows="5" placeholder="Aprakstiet savu problēmu"></textarea>
                </div>
                {{--<div class="input">
                    <x-input-label for="uploadImage" class="label" :value="__('Bilde')"/>  
                    <input class="input" type="file" name="uploadImage" id="uploadImage">
                </div>
                    <input class="input" type="file" name="uploadImage" id="uploadImage">
                </div> --}}
                <div class="inputCont">
                    <x-input-label for="datetime" class="label" :value="__('Datums un Laiks')"/>
                    <input class="input" type="datetime-local" id="datetime" name="laiks" placeholder="Norādiet problēmas datumu, laiku">
                </div>
                <div class="inputCont">
                    <x-input-label for="epasts" class="label" :value="__('Epasts')" />
                    <input id="epasts" class="input" type="email" name="epasts" required maxlength="60"/ placeholder="Ievadiet savu epastu">
                </div>
                <button type="submit" id="formBtn" class="btn btn-primary">Nosūtīt</button>
            </form>
        </div>
    </main>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const nozareSelect = document.getElementById('nozare');
        const customNozareCont = document.getElementById('customNozareCont');
        const customNozareInput = document.getElementById('customNozare');

        nozareSelect.addEventListener('change', function () {
            if (this.value === 'Cits') {
                customNozareCont.style.display = 'block';
                customNozareInput.setAttribute('required', 'required');
            } else {
                customNozareCont.style.display = 'none';
                customNozareInput.removeAttribute('required');
            }
        });
    });
</script>