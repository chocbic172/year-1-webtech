// DOMContentLoaded is used to ensure the HTML has finished parsing
// before we attempt to make any changes to the DOM.
// MDN Reference: https://developer.mozilla.org/en-US/docs/Web/API/Document/DOMContentLoaded_event
document.addEventListener("DOMContentLoaded", function() {
    const productsRaw = document.getElementById('product-data').innerHTML;
    const productsJSON = JSON.parse(productsRaw);

    const urlParamsRaw = document.location.search;
    const urlParams = new URLSearchParams(urlParamsRaw);

    if (!urlParams.has("type") || !urlParams.has("color")) {
        handleNotFound();
    }

    loadItem(urlParams.get("type"), urlParams.get("color"), productsJSON);
});

/**
 * Updates the user interface to show the item could not be found
 */
const handleNotFound = () => {
    const pageContent = document.getElementById("item-content");
    pageContent.innerHTML = "<h2>This item could not be found!</h2>";
}

/**
 * Manipulates the DOM to match the requested item
 * @param  {[string]}  type of requested item
 * @param  {[string]}  color of requested item
 * @param  {[Array]}   data containing all items
 */
const loadItem = (type, color, data) => {
    // Switch Case statement is used here for code readability
    // MDN Reference: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/switch
    const item = getItemFromData(type, color, data);

    // Item cannot be found
    if (!item) {return}

    const itemTitle = `${item.name} - ${item.color}`;
    updateBreadcrumb(itemTitle);
    updateItemUI(itemTitle, item.price, item.description, item.img);
}

/**
 * Searches for item matching the parameters in `data`
 * @param  {[string]}  type of item to search for
 * @param  {[string]}  color of item to search for
 * @param  {[Array]}   data to be searched
 * @returns {[object]} item object if found, `undefined` if not
 */
const getItemFromData = (type, color, data) => {
    // Hoisting is used to declare a variable before we know what the value is.
    // W3 Reference: https://www.w3schools.com/js/js_hoisting.asp
    var item;

    // The Array.find() method is used to filter for the wanted data. MDN Ref:
    // https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/find
    switch (type) {
        case "hoodie":
            const hoodieArray = data.hoodies;
            item = hoodieArray.find((x) => x.color == color);
            return item ? item : handleNotFound();
        case "jumper":
            const jumperArray = data.jumpers;
            item = jumperArray.find((x) => x.color == color);
            return item ? item : handleNotFound();
        case "tshirt":
            const tshirtArray = data.tshirts;
            item = tshirtArray.find((x) => x.color == color);
            return item ? item : handleNotFound();
        default:
            handleNotFound();
    }
}

/**
 * Updates the UI with the final breadcrumb title
 * @param  {[string]} title to be displayed in the breadcrumbs
 */
const updateBreadcrumb = (title) => {
    const finalBreadcrumb = document.getElementById('title-breadcrumb');
    finalBreadcrumb.innerHTML = `<a href="#">${title}</a>`;
}

/**
 * Updates the UI with item details
 * @param  {[string]} title of the item
 * @param  {[string]} price of the item
 * @param  {[string]} description of the item
 * @param  {[string]} image url of the item
 */
const updateItemUI = (title, price, description, image) => {
    const titleElem = document.getElementById("item-title");
    titleElem.innerHTML = title;

    const priceElem = document.getElementById("item-price");
    priceElem.innerHTML = price;

    const descriptionElem = document.getElementById("item-desc");
    descriptionElem.innerHTML = description;

    const imageElem = document.getElementById("item-img");
    imageElem.src = `assets/${image}`;

    const basketButton = document.getElementById("item-cart-button");
    basketButton.addEventListener("click", () => {addItemToBasket(title, price)});
}

/**
 * Adds item to basket in `sessionStorage`
 * @param  {[string]} title of the item
 * @param  {[string]} price of the item
 */
const addItemToBasket = (title, price) => {
    const basketButton = document.getElementById("item-cart-button");

    // Can't mutate sessionStorage values so create a local copy
    // to edit, then overwrite the sessionStorage value
    const basket = JSON.parse(sessionStorage.getItem("cart"));
    const newItem = {title: title, price: price};

    if (basket) {
        basket.push(newItem);
        sessionStorage.setItem("cart", JSON.stringify(basket));
    } else {
        sessionStorage.setItem("cart", JSON.stringify([newItem]));
    }

    basketButton.innerHTML = "Added!";
    basketButton.className = "added";
}
