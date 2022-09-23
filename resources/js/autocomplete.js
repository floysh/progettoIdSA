// getting all required elements
const searchWrapper = document.querySelector("#search_bar");
const inputBox = searchWrapper.querySelector("input");

const autocompleteWrapper = document.querySelector("#search_autocomplete")
const suggestionList = autocompleteWrapper.querySelector(".suggestions");

function createProductSuggestion(product) {
    const elem = document.createElement('div');
    elem.innerHTML = `
        <div class="list-item mt-2 mb-2">
            <a href="/products/${product.id}">
            <div class="columns">
                <div class="column is-narrow pt-2 pr-0">
                    <div class="image is-48x48">
                        <img src="/images/placeholders/${ product.category }.svg" style="max-height: unset">
                    </div>
                </div>
                <div class="column pt-2">
                    <div class="title is-size-6 mb-1">
                        ${ product.name }
                    </div>
                    <div class="label">
                      <span class="icon"><i class="fas fa-coins"></i></span>
                      <span>${ product.price }</span>
                    </div>
                </div>
            </div>
            </a>
        </div>
        `
    // use the product image instead of placeholder if available
    fetch(`/images/products/${product.imagepath}`)
        .then(response => {
            if (response.ok) {
                elem.querySelector('img').src = response.url
            }
        })
        .catch(error => {
            console.warn(imagePath)
            // Ignore error, leave the placeholder image
        });

    return elem;
}

// if user presses any key and release
inputBox.onkeyup = event => {
    let userData = event.target.value; //user input
    //console.log(event.target.value);

    suggestionList.replaceChildren();

    if (event.target.value.length < 3) return null;

    searchResults = [];
    fetch(`/search?q=${userData}`)
        .then(response => response.json())
        .then(results => {
            suggestionList.replaceChildren();
            results.forEach(product => {
                //console.log(product)

                let suggestion = createProductSuggestion(product);

                // add to the list
                suggestionList.appendChild(suggestion);
            });
        })
}