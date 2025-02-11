@extends('layouts.guestLayout')

@section('title', 'Form')

@section('content')
<div class="content">
    <main>
        <div class="formCont">
            <h1>Problēma</h1>
            <form action="{{ url('/nosutit') }}" method="post" enctype="multipart/form-data" class="form">
                @csrf
                <div class="inputCont" autofocus>
                    <x-input-label for="nozare" class="label" :value="__('Nozare')"/>
                    <select name="nozare" id="nozare" class="ievade">
                        <option value="Ielas">Ielas</option>
                        <option value="Ēkas">Ēkas</option>
                        <option value="Elektrība">Elektrība</option>
                        <option value="Ūdens">Ūdens</option>
                        <option value="Daba">Daba</option>
                        <option value="Cits">Cits</option>
                    </select>
                </div>

                <div class="inputCont" id="customNozareCont" style="display: none;">
                    <input id="customNozare" class="nozareivd ievade" type="text" name="customNozare" maxlength="60" placeholder="Norādiet nozari"/>
                </div>

                <div class="inputCont">
                    <x-input-label for="title" class="label" :value="__('Virsraksts')"/>
                    <input id="title" class="ievade" type="text" name="virsraksts" required maxlength="60"/>
                </div>
                <div class="inputCont">
                    <x-input-label for="description" class="label" :value="__('Apraksts')" />
                    <textarea id="description" class="ievade" type="text" name="apraksts" required rows="5" ></textarea>
                </div>
                <div class="inputCont">
                    <x-input-label for="uploadImage" class="label" :value="__('Bilde')"/>  
                    <input class="ievade" type="file" name="uploadImage" id="uploadImage">
                </div>
                <div class="inputCont">
                    <x-input-label for="datetime" class="label" :value="__('Datums un Laiks')"/>
                    <input class="ievade" type="datetime-local" id="datetime" name="laiks">
                </div>
                <div class="inputCont">
                    <x-input-label for="epasts" class="label" :value="__('Epasts')" />
                    <input id="epasts" class="ievade" type="email" name="epasts" required maxlength="60"/>
                </div>
                <button type="submit" id="formBtn" class="btn">Nosūtīt</button>
            </form>
        </div>
    </main>
</div>
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