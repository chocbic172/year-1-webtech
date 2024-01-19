// DOMContentLoaded is used to ensure the HTML has finished parsing
// before we attempt to make any changes to the DOM.
// MDN Reference: https://developer.mozilla.org/en-US/docs/Web/API/Document/DOMContentLoaded_event
document.addEventListener("DOMContentLoaded", function() {
    const productsRaw = document.getElementById('product-data').innerHTML;
    const productsJSON = JSON.parse(productsRaw);
    loadHoodies(productsJSON);
    loadJumpers(productsJSON);
    loadTshirts(productsJSON);
});

/**
 * Adds all hoodies to the UI
 * @param  {[Array]} products array of all products
 */
const loadHoodies = (products) => {
    const hoodiesContainer = document.getElementById('hoodies-container');
    const hoodiesArray = products.hoodies;
    loadItem('hoodie', hoodiesContainer, hoodiesArray);
}

/**
 * Adds all jumpers to the UI
 * @param  {[Array]} products array of all products
 */
const loadJumpers = (products) => {
    const jumpersContainer = document.getElementById('jumpers-container');
    const jumpersArray = products.jumpers;
    loadItem('jumper', jumpersContainer, jumpersArray);
}

/**
 * Adds all tshirts to the UI
 * @param  {[Array]} products array of all products
 */
const loadTshirts = (products) => {
    const tshirtsContainer = document.getElementById('tshirts-container')
    const tshirtsArray = products.tshirts;
    loadItem('tshirt', tshirtsContainer, tshirtsArray);
}

/**
 * Loads an item into the DOM, using consistent styling
 * @param  {[Array]}   type of item to add
 * @param  {[Element]} container to add items to
 * @param  {[Array]}   itemArray array of all items to be added
 */
const loadItem = (type, container, itemArray) => {
    // Clear container before populating it with new elements
    container.innerHTML = "";
    
    for (const item of itemArray) {
        // Use the URLSearchParams object to generate a "get" request to the
        // item page. MDN Reference:
        // https://developer.mozilla.org/en-US/docs/Web/API/URLSearchParams
        const itemUrlParams = new URLSearchParams({type: type, color: item.color});
        const itemUrl = `./item.html?${itemUrlParams.toString()}`
        
        const itemTitle = `${item.name} - ${item.color}`;
    
        container.innerHTML = container.innerHTML +
        `<a href="${itemUrl}"><div class="col-33">
            <div class="product">
                <img src="assets/${item.img}" alt="${itemTitle}">
                <p><b>${itemTitle}</b></p>
                <p><i>${item.price}</i></p>
            </div>
        </div></a>`
    }
}
