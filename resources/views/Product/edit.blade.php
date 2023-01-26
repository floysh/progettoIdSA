@extends('layouts.app')

@section('title')
    Modifica {{ $product->name }} - {{ config('app.name', 'ZonkoShop') }}
@endsection

@section('content')
    <div class="section">
        <h1 class="title">Modifica dettagli prodotto</h1>

        <div class="container">
            <form action="{{ action('ProductController@update', $product->id) }}" method="POST">
                @csrf()
                @method('PATCH')
                
                <div class="field">
                    <div class="control">
                        <label class="label" for="name">Nome</label>
                        <div>
                            <input class="input" type="text" class="form-control form-control-lg" name="name" value="{{ $product->name }}">
                        </div>
                    </div>
                </div>

                <div class="field has-addons">
                    <div class="control">
                        <label class="label">Immagine</label>
                      <div class="button is-static">/images/products/</div>
                    </div>
                    <div class="control is-expanded">
                        <label class="label">&nbsp;</label>
                      <input class="input" type="text" name="imagepath" value="{{ $product->imagepath }}">
                    </div>
                </div>

                <div class="field">
                    <label class="label">Immagine NEW!</label>
                    <div class="control has-icons-left">
                        <div class="select">
                            <select>
                                <option value="armor">Armor</option>
                                <option value="mace">Mace</option>
                                <option value="object">Object</option>
                                <option value="potion">Potion</option>
                                <option value="shield">Shield</option>
                                <option value="spear">Spear</option>
                                <option value="spell">Spell</option>
                                <option value="sword">Sword</option>
                                <option value="wearable">Wearable</option>
                            </select>
                        </div>
                        <span class="icon is-left">
                            <i class="fas fa-images"></i>
                        </span>
                    </div>
                </div>

                <div class="columns">
                    <div class="column">
                        <div class="field has-addons">
                            <div class="control is-expanded">
                                <label class="label" for="price">Prezzo</label>
                                <input type="number" min="0" step="0.01" class="input" name="price" value="{{ $product->price }}">
                            </div>
                            <div class="control">
                                <label class="label" for="name">&nbsp;</label>
                                <div class="button is-static">
                                    <i class="fas fa-coins"></i>
                                </div>
                            </div>      
                        </div>
                    </div>
                    <div class="column">
                        <div class="field has-addons">
                            <div class="control is-expanded">
                                <label class="label" for="quantity">Quantità</label>
                                <input type="number" min="0" class="input" name="quantity" value="{{ $product->quantity }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="category">Categoria</label>
                    <div class="control">
                        <div class="select">
                            <select class="form-control" name="category" id="category">
                                @foreach (App\Enums\ProductCategory::cases() as $category)
        
                                    <option value="{{ $category->value }}" 
                                        {{ ( old('category') == $category->value || $category->value == $product->category->value ) ? 'selected' : ''}} 
                                        >
                                        {{ $category->name }}
                                    </option>

                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Visibilità catalogo</label>

                    <div class="control">
                        <label class="radio">
                            <input type="radio" name="is_disabled" value="0" {{ $product->isAvailable() ? 'checked' : '' }}>
                            Disponibile per l'acquisto
                        </label>
                    </div>
                    <div class="control">
                        <label class="radio">
                            <input class="radio" type="radio" name="is_disabled" value="1" {{ $product->isNotAvailable() ? 'checked' : '' }}>
                            Non disponibile
                        </label>
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <label class="label" for="content" class="form-field">Descrizione</label>
                        <div>
                            <textarea class="textarea" name="description" id="description" cols="30" rows="10">{{ $product->description }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="field is-grouped is-inline">
                    <button type="submit" class="button is-primary" dusk="edit-product-button">Salva modifiche</button>
                    <a href="." class="button">Annulla</a>
                </div>




            </form>
        </div>

    </div>

@endsection
