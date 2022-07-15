@extends('layouts.app')

@section('title')
    Aggiunta prodotto - {{ config('app.name', 'ZonkoShop') }}
@endsection

@section('content')
    <h1>Aggiungi un nuovo prodotto</h1>

    <form method="POST" action="{{ action('ProductController@create') }}">
        @csrf()

        <div class="form-group mb-3">
            <label class="form-label" for="name">Nome</label>
            <div>
                <input type="text" class="form-control form-control-lg" name="name" value="{{ old('name') }}">
            </div>
        </div>

        <div class="form-group mb-3">
            <label class="form-label" for="name">Immagine</label>
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">/images/prod/</div>
                </div>
                <input type="text" class="form-control form-control" name="imagepath" value="{{ old('imagepath') }}">
            </div>
            <div class="form-text text-muted">
                Lascia vuoto per un'immagine generica
            </div>
        </div>

        <div class="form-group row">
            <div class="col">
                <label class="form-label" for="price">Prezzo</label>
                <div>
                    <div class="input-group mb-2">
                            <input type="number" min="0" step="0.01" class="form-control" name="price" value="{{ old('price') }}">
                        <div class="input-group-append">
                            <div class="input-group-text"><i class="fas fa-coins"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <label class="form-label" for="quantity">Quantità</label>
                <input type="number" min="0" class="form-control" name="quantity" value="{{ old('quantity') }}">
            </div>
        </div>

        <div class="form-group mb-3">
            <label class="form-label" for="category">Categoria</label>
            <!-- WIP! -->
            <select class="form-control" name="category" id="category">
                <option selected hidden>-- scegli una categoria --</option>
                @foreach (App\Models\Product::categories() as $key => $category)
                    @if ( old('category') == $category )
                        <option value="{{ $key }}" selected>{{ $category }}</option>
                    @else
                        <option value="{{ $key }}" >{{ $category }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group mb-3">
                    <label class="form-label" for="content" class="form-field">Descrizione</label>
                    <div>
                        <textarea class="form-control" name="description" id="description" cols="30" rows="10">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group mb-3">
                    <div>
                        <label>Disponibile per l'acquisto</label>
                    </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input class="form-check-input" type="radio" name="is_disabled" value="0" checked>
                            <label class="form-label" class="form-check-label">Disponibile</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input class="form-check-input" type="radio" name="is_disabled" value="1">
                            <label class="form-label" class="form-check-label">Non disponibile</label>
                        </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <div class="form-group form-group-inline">
                <button type="submit" class="btn btn-primary">Conferma</button>
                <a href="{{ URL::previous() }}" class="btn btn-light pull-right">Annulla</a>
            </div>
        </div>

    </form>
@endsection
