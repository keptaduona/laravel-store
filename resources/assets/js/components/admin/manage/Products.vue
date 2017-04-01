<template>

<div class="products-main container">

    <h1 id="search-result-count" style="display: none">Rasta produktų: {{ searchResultCount }}</h1>

    <div class="all-products row">
        <div v-for="product in products" class="product col-md-4 col-xs-6">
            <div data-toggle="modal" data-target=".bd-example-modal-lg" @click="setProductDetails" class="product-thumbnail" :id="product.id">
                <div :style="{ 'background-image': 'url(' + product.image + ')' }" class="product-image"></div>

                <h5 style="font-weight:bold;" class="title">{{ product.title }}</h5>

                <p class="price">&euro;{{ product.sizes[0].price }}</p>
            </div>
        </div>
    </div>



    <div v-if="selectedproduct" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <h2 style="font-weight:600;">{{ selectedproduct.title }}</h2>

                <div :style="{ 'background-image': 'url(' + selectedproduct.image + ')' }" class="modal-image">
                    <img :src="selectedproduct.image" style="visibility: hidden;" />
                </div>

                <div class="vert-line"></div>

                <div class="description">
                    <p>{{ selectedproduct.description }}</p>
                </div>

                <div class="vert-line"></div>

                <div class="size-price-row">
                    <div class="form-group">
                        <label for="sel1">Pasirinkite dydį:</label>
                        <select v-model="selectedprice" class="form-control" id="sel1">
                            <option v-for="size in selectedproduct.sizes" :value="size.price">{{size.length}} x {{size.width}} x {{size.height}}</option>
                        </select>
                    </div>

                    <h3 style="font-weight: 500;">&euro; {{ selectedprice }}</h3>
                </div>

            </div>
        </div>
    </div>

    <div class="alert alert-danger" v-if="errors">
        <strong>Nepavyko rasti produktų, bandykite dar kartą.</strong>
    </div>

</div>



</template>

<script>

    export default {
        data() {
            return {
                products: null,
                selectedproduct: null,
                selectedprice: null,
                searchResultCount: 0,
                errors: false
            }
        },

        mounted() {
            console.log('Component mounted.')

            // Check if any Queries and fetch products accordingly
            if(this.getQueryStringValue('category').trim()) {
                axios.post('/products/byCategory',
                {
                    category: this.getQueryStringValue('category')
                })
                .then(response => this.products = response.data)
                .catch(error => this.errors = true);

            } else if(this.getQueryStringValue('search').trim()) {
                axios.post('/search',
                {
                    query: this.getQueryStringValue('search')
                })
                .then(response =>
                    this.products = response.data,
                    $('#search-result-count').show()
                )
                .catch(error => this.errors = true);

            } else {
                axios.get('/products')
                    .then(response =>this.products = response.data)
                    .catch(error => this.errors = true);
            }

        },

        watch: {
            products: function() {
                this.checkQueries();
            }
        },

        methods: {
            getQueryStringValue (key) {
                return decodeURIComponent(window.location.search.replace(new RegExp("^(?:.*[&\\?]" + encodeURIComponent(key).replace(/[\.\+\*]/g, "\\$&") + "(?:\\=([^&]*))?)?.*$", "i"), "$1"));
            },

            updateQueryStringParameter(uri, key, value) {
                var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
                var separator = uri.indexOf('?') !== -1 ? "&" : "?";
                if (uri.match(re)) {
                    return uri.replace(re, '$1' + key + "=" + value + '$2');
                }
                else {
                    return uri + separator + key + "=" + value;
                }
            },

            setProductDetails(e, clickedElement) {
                if (clickedElement === undefined) {
                    clickedElement = event.srcElement.parentElement.id;
                }
                let product = this.products.filter(product => product.id == clickedElement);
                this.selectedproduct = product[0];
                this.selectedprice = this.selectedproduct.sizes[0].price;
                this.addQuery('product', clickedElement);
            },

            checkQueries() {
                if (this.getQueryStringValue('product')) {
                    this.setProductDetails(undefined, this.getQueryStringValue('product'));
                    $(document).ready(function() {
                        $('.modal').modal('show');
                    });
                }

                if(this.getQueryStringValue('search').trim()) {
                    this.searchResultCount = this.products.length;
                }

            },

            addQuery(query, value) {

                let updatedQuery = this.updateQueryStringParameter(window.location.href, query, value);
                history.pushState("data", "title", updatedQuery);

            }

        }

    }
</script>

<style scoped>


    .product {
        padding: 0;
    }

    .product-thumbnail {
        border: 1px solid grey;
        margin: 5px 5px;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        height: 250px;
    }

    .product-image {
        width: 90%;
        height: 150px;
        border-radius: 6px;
        margin-top: 10px;
        background-size: 50%;
        background-repeat: no-repeat;
        background-position: 50% 50%;
    }

    .product-info {
        margin: 1px;
        overflow: hidden;
        display: flex;
        align-items: center;
    }

    .product-info h5 {
        text-overflow: ellipsis;
    }



    .modal-content {
        display: flex;
        align-items: center;
        flex-direction: column;
        padding: 10px;
        padding-top: 0px;
        width: 80%;
        margin: 0 auto;
        border-radius: 0px;
    }

    .modal-content .modal-image {
        width: 100%;
        max-height: 400px;
        background-size: contain;
        background-repeat: no-repeat;
        background-position: 50% 50%;
        border-radius: 6px;
        margin-bottom: 25px;
        margin-top: 10px;
    }

    .description {
        width: 65%;
        display: flex;
        justify-content: center;
    }

    .size-price-row {
        margin: 0 auto;
        margin-right: 25px;
        display: flex;
        align-items: center;
    }

    .size-price-row .form-group {
        margin-right: 25px;
    }


    .vert-line {
        width: 50%;
        height: 1px;
        background-color: grey;
        margin: 15px 0px 25px 0px;
    }


</style>
