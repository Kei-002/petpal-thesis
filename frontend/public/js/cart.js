class Cart {
    constructor(items = [], services = [], totalQuantity = 0, totalAmount = 0) {
        this.items = items;
        this.services = services;
        this.totalQuantity = totalQuantity;
        this.totalAmount = totalAmount;
    }

    // Add item to cart
    add(item) {
        // Check if item already exists in cart
        const existingItem = this.items.find(
            (cartItem) => cartItem.id === item.id
        );

        if (existingItem) {
            // If item already exists, update its quantity
            existingItem.quantity += item.quantity;
        } else {
            // If item does not exist, add it to cart
            this.items.push(item);
        }

        this.totalAmount += item.quantity * item.price;
        this.totalQuantity += item.quantity;
        this.saveToLocalStorage();
    }

    addService(item) {
        // Check if item already exists in cart
        const existingItem = this.services.find(
            (cartItem) => cartItem.id === item.id
        );

        if (existingItem) {
            // If item already exists, update its quantity
            existingItem.quantity += item.quantity;
        } else {
            // If item does not exist, add it to cart
            this.services.push(item);
        }

        this.totalAmount += item.quantity * item.price;
        this.totalQuantity += item.quantity;
        this.saveToLocalStorage();
    }

    // Remove item from cart
    remove(itemId) {
        const itemInfo = this.items.find((item) => item.id === itemId);

        // remove item from array
        this.items = this.items.filter((item) => item.id !== itemId);

        this.totalAmount -= itemInfo.quantity * itemInfo.price;
        this.totalQuantity -= itemInfo.quantity;
        this.saveToLocalStorage();
    }

    removeService(itemId) {
        const serviceInfo = this.services.find((item) => item.id === itemId);

        // remove item from array
        this.services = this.items.filter((item) => item.id !== itemId);

        this.totalAmount -= serviceInfo.quantity * serviceInfo.price;
        this.totalQuantity -= serviceInfo.quantity;
        this.saveToLocalStorage();
    }

    // Update item quantity in cart
    update(itemId, quantity) {
        const itemToUpdate = this.items.find((item) => item.id === itemId);
        var oldTotal = this.totalAmount;
        var oldTotalQuantity = this.totalQuantity;
        oldTotal = oldTotal - itemToUpdate.price * itemToUpdate.quantity;
        oldTotalQuantity -= itemToUpdate.quantity;
        if (itemToUpdate) {
            itemToUpdate.quantity = quantity;

            oldTotal += itemToUpdate.price * itemToUpdate.quantity;
            oldTotalQuantity += itemToUpdate.quantity;
            this.totalAmount = oldTotal;
            this.totalQuantity = oldTotalQuantity;
        }
        this.saveToLocalStorage();
    }

    updateService(itemId, quantity) {
        const itemToUpdate = this.services.find((item) => item.id === itemId);
        var oldTotal = this.totalAmount;
        var oldTotalQuantity = this.totalQuantity;
        oldTotal = oldTotal - itemToUpdate.price * itemToUpdate.quantity;
        oldTotalQuantity -= itemToUpdate.quantity;
        if (itemToUpdate) {
            itemToUpdate.quantity = quantity;

            oldTotal += itemToUpdate.price * itemToUpdate.quantity;
            oldTotalQuantity += itemToUpdate.quantity;
            this.totalAmount = oldTotal;
            this.totalQuantity = oldTotalQuantity;
        }
        this.saveToLocalStorage();
    }

    // Clear cart
    clear() {
        this.items = [];
        this.services = [];
        this.totalQuantity = 0;
        this.totalAmount = 0;
        this.saveToLocalStorage();
    }

    // Save cart to local storage
    saveToLocalStorage() {
        localStorage.setItem("cart", JSON.stringify(this));
    }

    // Load cart from local storage
    loadFromLocalStorage() {
        const savedCart = localStorage.getItem("cart");

        if (savedCart) {
            this.items = JSON.parse(savedCart);
        }
    }
}
