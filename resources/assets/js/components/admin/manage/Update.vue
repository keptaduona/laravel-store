<template>

    <div v-if="showContent" id="main" class="container">

        <div class="new-product-alerts row" style="text-align: center;">
            <div v-if="newproductresponse == false" class="alert alert-danger col-md-4 col-md-offset-4">
              <strong>O ne!</strong> Kažkas atsitiko, bandykite dar kartą.
            </div>
        </div>

        <h1>Redaguoti Produktą</h1>

        <div class="title-description-image-category-row row">

            <div class="title-description-category-col col-md-5 col-md-offset-1">

                <div class="title-description-row">
                    <label for="title">Pavadinimas</label>
                    <input style="font-weight: bold;" v-model="title" name="title" type="text" class="form-control" required>

                    <label for="description">Aprašymas</label>
                    <textarea v-model="description" class="form-control description" name="description"></textarea>
                </div>

                <div class="category-row">
                    <div class="form-group select-category">
                      <label for="sel1">Šio Produkto Kategorija:</label>
                      <select v-model="selectedcategory" class="form-control" id="sel1">
                        <option></option>
                        <option v-for="category in categories">
                            {{ category }}
                        </option>
                        <option id="select-new-category" style="background-color: #5cb85c;font-weight: bold;color: white">Nauja Kategorija</option>
                      </select>
                    </div>

                    <div v-if="selectedcategory == 'Nauja Kategorija'" class="form-group new-category">
                        <label for="enter-new-category">Nauja Kategorija:</label>
                        <input v-model="newcategory" name="enter-new-category" type="text" class="form-control" required>
                        <button style="margin-top: 5px;" @click="create_new_category" type="button" class="btn btn-success" id="confirm-category">Sukurti Kategoriją</button>
                    </div>

                    <div class="new-category-alerts">
                        <div v-if="newcategoryresponse == false" class="alert alert-warning">
                          <strong>O ne!</strong> Kategorija negali būti tuščia.
                        </div>

                        <div v-if="newcategoryresponse == 'OK'" class="alert alert-success">
                          <strong>OK!</strong> Nauja Kategorija Sukurta.
                        </div>
                    </div>
                </div>

            </div>

            <div class="image-col col-md-5">
                <div class="display-img">
                    <img v-if="image" :src="image" alt="">
                </div>

                <label for="image">Nuotraukos URL</label>
                <input v-model="image" name="image" type="url" class="form-control" required>
            </div>

        </div>

        <!-- CATEGORY ROW -->

        <div class="size-price-main row">

            <!-- SIZE-PRICE ROW -->

            <div class="select-size-price">
                <div class="size-price-row col-md-10 col-md-offset-1">
                    <label for="title">Aukštis</label>
                    <input v-model="height" name="height" type="number" class="form-control">

                    <label for="length">Ilgis</label>
                    <input v-model="length" name="length" type="number" class="form-control">

                    <label for="width">Plotis</label>
                    <input v-model="width" name="width" type="number" class="form-control">

                    <div class="price-box">
                        <label style="color: #5cb85c;" for="price">Kaina</label>
                        <input v-model="price" name="price" type="number" class="form-control">
                        <span class="glyphicon glyphicon-euro"></span>
                    </div>

                    <button @click="create_new_size" type="button" class="btn btn-success" id="add-size">Pridėti</button>
                </div>

                <div v-for="size in sizes" class="display-confirmed-size-price-row col-md-10 col-md-offset-1" style="background-color: grey;">
                    <label for="title">Aukštis</label>
                    <input :value="size.height" name="height" type="number" class="form-control" disabled>

                    <label for="length">Ilgis</label>
                    <input :value="size.length" name="length" type="number" class="form-control" disabled>

                    <label for="width">Plotis</label>
                    <input :value="size.width" name="width" type="number" class="form-control" disabled>

                    <div class="price-box">
                        <label style="color: #5cb85c;" for="price">Kaina</label>
                        <input :value="size.price" name="price" type="number" class="form-control" disabled>
                        <span class="glyphicon glyphicon-euro"></span>
                    </div>

                    <button @click="remove_size($event)" :value="size.id" type="button" name="button" class="btn btn-danger" id="remove-size">Pašalinti</button>
                </div>

            </div>

        </div>

        <!-- CREATE-PRODUCT BUTTON -->

        <div class="confirm-creation col-md-4 col-md-offset-4" style="margin-top: 50px; text-align: center">
            <button @click="update_product" type="button" class="btn btn-lg btn-warning center" id="create-new-product">Redaguoti Produktą</button>

            <div v-for="message in validationmessages" class="alert alert-warning validation-alert">
                <strong>{{ message }}</strong>
            </div>
        </div>





    </div>

</template>

<script>
    export default {
        data() {
            return {
                selectedcategory: null,
                newcategory: null,
                newcategoryresponse: null,
                newproductresponse: null,
                categories: null,
                showContent: false,
                title: null,
                description: null,
                product: null,
                image: null,
                height: null,
                length: null,
                width: null,
                price: null,
                sizes: [],
                sizeidcounter: 0,
                validationmessages: []
            }
        },

        created() {
            console.log('Component mounted.')

            axios.get('/categories')
                .then(response => this.categories = response.data);

            if(this.getQueryStringValue('id')) {
                axios.post('/products/getById',
                    {
                        id: this.getQueryStringValue('id')
                    })
                    .then(response => this.product = response.data[0]);

            } else {
                window.location.href = '/admin';
            }

        },

        watch: {
            product: function() {
                if(this.product) {
                    this.showContent = true;
                    this.fillProductFields();
                } else {
                    window.location.href = '/admin';
                }
            }
        },

        methods: {
            getQueryStringValue (key) {
                return decodeURIComponent(window.location.search.replace(new RegExp("^(?:.*[&\\?]" + encodeURIComponent(key).replace(/[\.\+\*]/g, "\\$&") + "(?:\\=([^&]*))?)?.*$", "i"), "$1"));
            },

            fillProductFields() {
                this.title = this.product.title;
                this.description = this.product.description;
                this.selectedcategory = this.product.category;
                this.image = this.product.image;

                var self = this;

                this.product.sizes.forEach(function(size) {

                    console.log(this);

                    self.sizeidcounter += 1;

                    self.sizes.push({
                        height: size.height,
                        length: size.length,
                        width: size.width,
                        price: size.price,
                        id: self.sizeidcounter
                    })
                });
            },

            create_new_category() {
                if(this.newcategory) {
                    axios.post('/admin/categories/create', {
                        name: this.newcategory
                        })
                        .then(response => {
                            console.log(response.data);
                            this.newcategoryresponse = response.data;
                            this.categories.push(this.newcategory);
                            this.selectedcategory = this.newcategory;
                        })
                        .catch(error => this.newcategoryresponse = false);

                }
            },

            create_new_size() {

                this.validationmessages = [];

                if(!this.height || !this.length || !this.width || !this.price) {
                    return this.validationmessages.push('Užpildykite visus dydžio laukelius.');
                }

                this.sizeidcounter += 1;
                this.sizes.push(
                {
                    height: this.height,
                    length: this.length,
                    width: this.width,
                    price: this.price,
                    id: this.sizeidcounter
                });
                this.height = null;
                this.length = null;
                this.width = null;
                this.price = null;

            },

            remove_size(event) {

                let id = event.srcElement.value;

                this.sizes = this.sizes.filter(size => size.id != id);

            },

            update_product() {

                this.validationmessages = [];

                if (!this.title){
                    this.validationmessages.push('Pavadinimas negali būti tuščias.');
                } else if (!this.description) {
                    this.validationmessages.push('Aprašymas negali būti tuščias.');
                } else if (!this.selectedcategory) {
                    this.validationmessages.push('Pasirinkite arba sukurkite kategoriją šiam produktui.');
                } else if(!this.image) {
                    this.validationmessages.push('Įkelkite nuotrauką.');
                } else if (this.sizes.length < 1) {
                    this.validationmessages.push('Pridėkite bent vieną produkto dydį.');
                } else {
                    axios.post('/admin/products/update', {
                        id: this.product.id,
                        title: this.title,
                        description: this.description,
                        sizes: this.sizes,
                        image: this.image,
                        category: this.selectedcategory
                    })
                    .then(response =>
                        window.location.href = "/admin?updated=true")
                    .catch(error =>
                        this.newproductresponse = false);


                }



                // selectedcategory,
                // title,
                // description,
                // image,
                // sizes
            }

        }

    }
</script>

<style scoped>

    .description {
        height: 75px;
        resize: none;
    }

    .display-img {
        height: 300px;
        border: 1px solid grey;
        margin-top: 25px;
    }

    .display-img img {
        width: 100%;
        height: 100%;
    }

    .form-control {
        border-radius: 0;
    }

    #main h1 {
        text-align: center;
        margin-bottom: 25px;
    }


    #sel1:focus option:first-of-type {
        display: none;
    }

    .size-price-main {
        margin-top: 50px;
    }

    .size-price-row, .display-confirmed-size-price-row {
        display: flex;
        align-items: center;
        border: 1px solid grey;
        padding: 10px;
        border-radius: 6px;
        text-align: center;
    }

    .size-price-row input, .display-confirmed-size-price-row input {
        max-width: 100px;
        border-radius: 0px;
        margin: 0px 5px 0px 5px;
    }

    .price-box input {
        min-width: 75px;
    }

    .price-box {
        display: flex;
        align-items: center;
        margin-left: 25px;
    }

    #add-size, #remove-size {
        margin-left: 25px;
        width: 150px;
    }

    .display-confirmed-size-price-row {
        margin-top: 5px;
    }





</style>
