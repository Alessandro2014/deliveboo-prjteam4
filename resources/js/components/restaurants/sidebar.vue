<template>
    <div id="sidebar" class="row">
        <div class="col-12">
            <h4>Categorie:</h4>
            <div>
                <div v-for="(type, i) in types" :key="i">
                    <input
                        type="checkbox"
                        :name="type.name"
                        :id="type.name"
                        v-model="selection"
                        :value="type.id"
                    />
                    <label :for="type.name">{{ type.name }}</label>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { eventBus } from "../../../js/app";
export default {
    name: "Sidebar",
    data() {
        return {
            baseUri: "http://127.0.0.1:8000",
            types: [],
            selection: [],
        };
    },
    methods: {
        getTypes() {
            console.log(`Fetching all types from API...`);
            axios
                .get(`${this.baseUri}/api/types`)
                .then((r) => {
                    const data = r.data;
                    this.types = data;
                })
                .catch((e) => {
                    console.error(e);
                });
        },
        // sends selection to searchbar when requested
        sendSelection() {
            this.$store.commit("changeSelection", this.selection);
        },
    },
    mounted() {
        console.log("Component mounted.");
        this.getTypes();
        eventBus.$on("requestSelection", () => {
            this.sendSelection();
        });
    },
};
</script>
<style lang="scss" scoped>
h4{
    margin-bottom: 20px;
    font-weight: bold;
}
#sidebar {
    position: fixed;
    width: 200px;
    height:100vh;
    left: 0;
    padding: 120px 0 0 40px;
    background-color: transparent;

}
input[type="checkbox"] {
    margin-right: 5px;
    margin-bottom: 5px;
}

</style>
