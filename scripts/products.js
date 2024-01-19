document.addEventListener("DOMContentLoaded", function() {
    const productsRaw = document.getElementById('product-data').innerHTML;
    const productsJSON = JSON.parse(productsRaw);
    loadHoodies(productsJSON);
    loadJumpers(productsJSON);
    loadTshirts(productsJSON);
});

function sleep(ms) {
    var start = new Date().getTime(), expire = start + ms;
    while (new Date().getTime() < expire) { }
    return;
}

const loadHoodies = (products) => {
    const hoodiesContainer = document.getElementById('hoodies-container')
    const hoodiesArray = products.hoodies;

    // Clear container before populating it with new elements
    hoodiesContainer.innerHTML = "";

    for (const hoodie of hoodiesArray) {
        hoodiesContainer.innerHTML = hoodiesContainer.innerHTML +
        `<a href=""><div class="col-33">
            <div class="product">
                <img src="assets/${hoodie.img}" alt="Hoodie Image">
                <p><b>${hoodie.name} - ${hoodie.color}</b></p>
                <p>${hoodie.description}</p>
                <p><i>${hoodie.price}</i></p>
            </div>
        </div></a>`
    }
}

const loadJumpers = (products) => {
    const jumpersContainer = document.getElementById('jumpers-container')
    const jumpersArray = products.jumpers;

    // Clear container before populating it with new elements
    jumpersContainer.innerHTML = "";

    for (const jumper of jumpersArray) {
        jumpersContainer.innerHTML = jumpersContainer.innerHTML +
        `<a href=""><div class="col-33">
            <div class="product">
                <img src="assets/${jumper.img}" alt="Jumper Image">
                <p><b>${jumper.name} - ${jumper.color}</b></p>
                <p>${jumper.description}</p>
                <p><i>${jumper.price}</i></p>
            </div>
        </div></a>`
    }
}

const loadTshirts = (products) => {
    const tshirtsContainer = document.getElementById('tshirts-container')
    const tshirtsArray = products.tshirts;

    // Clear container before populating it with new elements
    tshirtsContainer.innerHTML = "";

    for (const tshirt of tshirtsArray) {
        tshirtsContainer.innerHTML = tshirtsContainer.innerHTML +
        `<a href=""><div class="col-33">
            <div class="product">
                <img src="assets/${tshirt.img}" alt="TShirt Image">
                <p><b>${tshirt.name} - ${tshirt.color}</b></p>
                <p>${tshirt.description}</p>
                <p><i>${tshirt.price}</i></p>
            </div>
        </div></a>`
    }
}