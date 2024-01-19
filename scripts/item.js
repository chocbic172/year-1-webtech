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

const handleNotFound = () => {
    const pageContent = document.getElementById("item-content");
    pageContent.innerHTML = "<h2>This item could not be found!</h2>";
}

const loadItem = (type, color, data) => {
    // Switch Case statement is used here for code readability
    // MDN Reference: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/switch
    const item = getItemFromData(type, color, data);

    // Item cannot be found
    if (!item) {return}

    const itemTitle = `${item.name} - ${item.color}`;
    updateBreadcrumb(itemTitle);
    updateDetails(itemTitle, item.price, item.description, item.img);
}

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

const updateBreadcrumb = (title) => {
    const finalBreadcrumb = document.getElementById('title-breadcrumb');
    finalBreadcrumb.innerHTML = `<a href="#">${title}</a>`;
}

const updateDetails = (title, price, description, image) => {
    const titleElem = document.getElementById("item-title");
    titleElem.innerHTML = title;

    const priceElem = document.getElementById("item-price");
    priceElem.innerHTML = price;

    const descriptionElem = document.getElementById("item-desc");
    descriptionElem.innerHTML = description;

    const imageElem = document.getElementById("item-img");
    imageElem.src = `assets/${image}`;
}
