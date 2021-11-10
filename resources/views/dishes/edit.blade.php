@extends('layouts.app')

@section('content')

    <div class="container">
        {{-- FORM FOR EDIT --}}
        <h1 class="text-center mb-3">Modifica Piatto</h1>
        <form action="{{ route('dishes.update', $dish->id) }}" method="POST" class="row g-3">
            @method('PATCH')
            @csrf
            <div class="col-md-6 mb-4">
                <label for="name" class="form-label">Nome</label>
                <input type="text" class="form-control  @error('name') is-invalid @enderror" id="name" name="name"
                    value="{{ old('name', $dish->name) }}">
                @error('name')
                    <div class="invalid-feedback">
                        Inserisci un nome valido
                    </div>
                @enderror
            </div>
            {{-- PICTURE --}}
            <div class="col-md-8  mb-4">
                <label for="picture" class="form-label">Link immagine</label>
                <input type="text" class="form-control" id="picture" name="picture"
                    value="{{ old('picture', $dish->picture) }}">
            </div>
            {{-- DESCRIPTION --}}
            <div class="col-md-12  mb-4">
                <label for="description" class="form-label">Descrizione</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                    name="description" rows="3" value="">{{ old('description', $dish->description) }}</textarea>
                @error('content')
                    <div class="invalid-feedback">
                        Inserisci una descrizione di almeno 10 lettere
                    </div>
                @enderror
            </div>
            {{-- ENTRY --}}
            <div class="col-md-12  mb-4">
                <label for="entry" class="form-label">Portata</label>
                <textarea class="form-control @error('entry') is-invalid @enderror" id="entry" name="entry" rows="3"
                    value="">{{ old('entry', $dish->entry) }}</textarea>
                @error('content')
                    <div class="invalid-feedback">
                        Inserisci la portata
                    </div>
                @enderror
            </div>
            {{-- PRICE --}}
            <div class="col-md-12  mb-4">
                <label for="price" class="form-label">Prezzo</label>
                <textarea class="form-control @error('price') is-invalid @enderror" id="price" name="price" rows="3"
                    value="">{{ old('price', $dish->price) }}</textarea>
                @error('content')
                    <div class="invalid-feedback">
                        Inserisci un prezzo
                    </div>
                @enderror
            </div>
            {{-- BOOLEANS --}}
            <div class="form-row">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="available" name="available" value="1">
                    <label class="form-check-label" for="available">Disponibile</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="gluten_free" name="gluten_free" value="0">
                    <label class="form-check-label" for="bool-1">Gluten Free</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="bool-2" name="vegetarian" value="1">
                    <label class="form-check-label" for="bool-2">Vegetariano</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="bool-3" name="vegan" value="1">
                    <label class="form-check-label" for="bool-3">Vegano</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="bool-4" name="frozen" value="1">
                    <label class="form-check-label" for="bool-4">Surgelato</label>
                </div>
                
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-secondary">Conferma Modifica</button>
            </div>
        </form>
    </div>

@endsection