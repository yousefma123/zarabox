let finalQuantity = 0, finalSize = 0;
const getCart = () => {
    const cart = localStorage.getItem("cart");
    return cart ? JSON.parse(cart) : [];
};

const saveCart = (cart) => {
    localStorage.setItem("cart", JSON.stringify(cart));
    
    const stored = localStorage.getItem("cart");
    if (stored && stored === JSON.stringify(cart)) {
        return true;
    } else {
        return false;
    }
};

const addToCart = (id, size, quantity = 1) => {
    const cart = getCart();

    const existingItem = cart.find(
        item => item.id === id && item.size === size
    );

    if (existingItem) {
        if (existingItem.quantity >= 10) {
            return alert('More than 10')
        }
        existingItem.quantity = Number(existingItem.quantity) + Number(quantity);
    } else {
        cart.push({ id, size, quantity });
    }
    finalSize = size
    finalQuantity = quantity
    return saveCart(cart);
};

const removeFromCart = (id, size) => {
    const cart = getCart().filter(
        item => !(item.id === id && item.size === size)
    );

    saveCart(cart);
};

const clearCart = () => {
    localStorage.removeItem("cart");
};

const _closeCartTap = () => {
    const div = document.querySelector('.added')
    div.classList.remove('active')
    document.querySelector('.addToCart button').removeAttribute('disabled')
}

const _openCartTap = () => {
  const div = document.querySelector('.added')
  $finalQuantity.innerText = finalQuantity
  $finalSize.innerText = finalSize
  div.classList.add('active')
}

localStorage.clear();


