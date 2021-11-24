<template>
    <div id="dish-card-wrapper" class="col-lg-8 col-md-6 p-0 d-flex flex-wrap">
        <div
            id="dish-card"
            v-for="(dish, i) in dishes"
            :key="i"
            class="card col-lg-5 col-md-12 shadow-sm p-3 mb-3 me-3 d-flex"
            :class="[dish.available ? 'available' : 'd-none']"
        >
            <img
                style="object-fit: cover"
                :src="
                    dish.picture
                        ? '/storage/' + dish.picture
                        : '/img/placeholder.svg'
                "
                alt=""
            />
            <div
                class="
                    card-body
                    p-0
                    mt-3
                    d-flex
                    flex-column
                    justify-content-between
                "
            >
                <div>
                    <h4 class="card-title">{{ dish.name }}</h4>
                    <p class="card-text">{{ dish.description }}</p>
                </div>
                <div
                    class="
                        pos-bot
                        d-flex
                        align-items-end
                        justify-content-between
                        mt-4
                    "
                >
                    <span class="price"
                        ><strong>Prezzo: </strong>€ {{ dish.price }}</span
                    >
                    <button
                        @click="addToCart(dish.id, dish.price)"
                        class="btn"
                        type="button"
                    >
                        Aggiungi
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { eventBus } from "../../../js/app";
export default {
    name: "restaurantmenu",
    data() {
        return {
            baseUri: "http://127.0.0.1:8000",
            dishes: [],
            isLoading: false,
        };
    },
    computed: {
        currenRestaurantID: function () {
            const restaurantID = window.location.pathname.replace(
                "/restaurants/",
                ""
            );
            return restaurantID;
        },
    },
    methods: {
        // Fetch dishes with an API call
        getDishes() {
            this.isLoading = true;
            const restaurantID = window.location.pathname.replace(
                "/restaurants/",
                ""
            );
            console.log(`Fetching dishes from restaurantID ${restaurantID}`);
            axios
                //restaurants/{restaurantID}/dishes
                .get(`${this.baseUri}/api/restaurants/${restaurantID}/dishes`)
                .then((r) => {
                    const data = r.data;
                    this.dishes = data;
                    this.isLoading = false;
                })
                .catch((e) => {
                    console.error(e);
                });
        },
        addToCart(dish_id, price) {
            const currentCart = JSON.parse(sessionStorage.getItem("cart"));
            let isDuplicate = false;
            currentCart.orders.forEach((order) => {
                if (order.dish_id === dish_id) {
                    isDuplicate = true;
                }
            });
            console.log(`isDuplicate? ${isDuplicate}`);
            if (!isDuplicate) {
                currentCart.orders.push({
                    dish_id: dish_id,
                    quantity: 1,
                    price: price,
                });

                sessionStorage.setItem("cart", JSON.stringify(currentCart));
                eventBus.$emit("update", currentCart.orders.length);
            }
        },
        initCart() {
            console.log("Initializing cart...");
            if (sessionStorage.getItem("cart") === null) {
                console.log("Cart did not exist, creating...");
                let cart = {
                    restaurantID: 0,
                    orders: [],
                };

                console.log("everything's fine");
                cart.restaurantID = this.currenRestaurantID;
                sessionStorage.setItem("cart", JSON.stringify(cart));
            }
            // se esiste già, ne leggiamo il contenuto
            const currentCart = JSON.parse(sessionStorage.getItem("cart"));
            // soluzione provvisoria: svuota il carrello se visito un'altro ristorante
            if (currentCart.restaurantID !== this.currenRestaurantID) {
                console.log("restaurant id did not match");
                let cart = {
                    restaurantID: 0,
                    orders: [],
                };
                console.log("dropping order...");
                sessionStorage.removeItem("order");

                console.log("reinitializing...");
                cart.restaurantID = this.currenRestaurantID;
                sessionStorage.setItem("cart", JSON.stringify(cart));
            } else {
                console.log("restaurant id match");
            }
        },
    },
    created() {
        console.log("---Currently in restaurantmenu---");
        this.getDishes();
        this.initCart();
    },
};
</script>

<style scoped lang="scss">
#dish-card {
    transition: transform 0.2s;

    // @media screen and (min-width: 980px) {
    //     width: 50%;
    //     // aggiustare qui
    // }
    // @media screen and (min-width: 1200px) {
    //     width: calc(100% / 3 - 20px);

    // }
}
#dish-card {
    @media screen and (max-width: 780px) {
        width: 100%;
    }
}
#dish-card:hover {
    transform: scale(1.02);
}

img {
    width: 100px;
    height: 100px;
}

button[type="button"] {
    background-color: #00bb55;
    color: white;
    font-size: 1rem;
    font-weight: bold;
}

.unavailable {
    display: none;
}
</style>
