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
                
                <div class="inputCont" id="citsNozareCont" style="display: none;">
                    <x-input-label for="citsNozare" class="label" :value="__('Lūdzu, norādiet nozari')"/>
                    <input id="citsNozare" class="ievade" type="text" name="citsNozare" maxlength="60"/>
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
