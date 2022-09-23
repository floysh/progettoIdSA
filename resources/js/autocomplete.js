// getting all required elements
const searchWrapper = document.querySelector("#search_bar");
const inputBox = searchWrapper.querySelector("input");

const autocompleteWrapper = searchWrapper.querySelector("#search_autocomplete")
const suggestionList = autocompleteWrapper.querySelector(".suggestions");



function createProductSuggestion(product) {
    const elem = document.createElement('div');
    elem.innerHTML = `
        <div class="list-item mt-2 mb-2">
            <a href="/products/${product.id}">
            <div class="columns">
                <div class="column is-narrow pt-2 pr-0">
                    <div class="image is-48x48">
                        <img src="${ product.imgpath }" style="max-height: unset">
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

    return elem;
}

// hide autocomplete suggestions when the search bar is out of focus
document.addEventListener('click', event => {
    if (! searchWrapper.contains(event.target)) {
        autocompleteWrapper.classList.add("is-hidden");
    }
})
searchWrapper.addEventListener('focusin', event => {
    if (suggestionList.childElementCount > 0) {
        autocompleteWrapper.classList.remove("is-hidden");
    }
})


inputBox.addEventListener('input', event => {
    let input = event.target.value;

    // clear previous search results
    suggestionList.replaceChildren();

    if(input.length < 1) {
        autocompleteWrapper.classList.add("is-hidden");
        return;
    }

    fetch(`/search?q=${input}`)
        .then(response => response.json())
        .then(results => {
            suggestionList.replaceChildren();
            results.forEach(product => {

                // parse json into a DOM Element
                let suggestion = createProductSuggestion(product);

                // add to the list
                suggestionList.appendChild(suggestion);
            });
            
            // show results
            autocompleteWrapper.classList.remove("is-hidden")
        })
});