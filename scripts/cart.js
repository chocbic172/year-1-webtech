document.addEventListener("DOMContentLoaded", function() {
    const basket = sessionStorage.getItem("cart");
    const cartListElem = document.getElementById("cart-list");

    if (!basket) {
        cartListElem.innerHTML = "<h2>No Items in Basket</h2>";
        setTotalPrice("£0.00");
        return
    }

    loadBasket();
});

const setTotalPrice = (price) => {
    const priceElem = document.getElementById("total-price");
    priceElem.innerHTML = `<b>Total Cost:</b> ${price}`;
}

const loadBasket = () => {
    const basket = JSON.parse(sessionStorage.getItem("cart"));
    const cartListElem = document.getElementById("cart-list");
    
    var totalPrice = 0.0;

    for (const item of basket) {
        // Cribbed from https://stackoverflow.com/questions/54616643/
        // Removes all £ symbols in the price so the price can be parsed
        // as a float
        totalPrice += parseFloat(item.price.replace(/£/g, ""));
        cartListElem.innerHTML = cartListElem.innerHTML + 
        `
        <li><div class="cart-item">
            <p class="cart-item-name">${item.title}</p>
            <p class="cart-item-price">${item.price}</p>
            <button class="cart-item-remove" onclick="removeItemFromBasket('${item.title}')">Remove</button>
        </div></li>
        `
    }

    // Ensure the number has exactly 2 decimal places using toFixed()
    // MDN Ref: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number/toFixed
    setTotalPrice(`£${totalPrice.toFixed(2)}`);
}

const removeItemFromBasket = (itemName) => {
    const basketJSON = sessionStorage.getItem("cart");

    // Refreshes the page. Also used below. MDN Reference:
    // https://developer.mozilla.org/en-US/docs/Web/API/Location/reload
    if (!basketJSON) {location.reload()};

    const basket = JSON.parse(basketJSON);
    const idxToRemove = basket.findIndex((x) => x.title == itemName)

    if (basket.length == 1) {
        // Remove the session storage entry entirely if the
        // basket is empty
        sessionStorage.removeItem("cart");
    } else {
        basket.splice(idxToRemove, 1);
        sessionStorage.setItem("cart", JSON.stringify(basket));
    }

    location.reload();
}
