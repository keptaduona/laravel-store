<template>

    <div id="main" class="container">

        <!-- ALERTS -->
        <div class="new-product-alerts row" style="text-align: center;">
            <div v-if="newproductresponse" class="alert alert-success col-md-4 col-md-offset-4">
              <strong>OK!</strong> Naujas produktas sukurtas.
            </div>

            <div v-if="newproductresponse == false" class="alert alert-danger col-md-4 col-md-offset-4">
              <strong>O ne!</strong> Kažkas atsitiko, bandykite dar kartą.
            </div>
        </div>


        <h1>Sukurti Produktą</h1>


        <div class="title-description-image-category-row row">

            <!-- Title and Description -->
            <div class="title-description-category-col col-md-5 col-md-offset-1">

                <div class="title-description-row">
                    <label for="title">Pavadinimas</label>
                    <input style="font-weight: bold;" v-model="title" name="title" type="text" class="form-control" required>

                    <label for="description">Aprašymas</label>
                    <textarea v-model="description" class="form-control description" name="description"></textarea>
                </div>

                <!-- Select or Create a Category -->
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

                    <!-- Create Category Field -->
                    <div v-if="selectedcategory == 'Nauja Kategorija'" class="form-group new-category">
                        <label for="enter-new-category">Nauja Kategorija:</label>
                        <input v-model="newcategory" name="enter-new-category" type="text" class="form-control" required>
                        <button style="margin-top: 5px;" @click="create_new_category" type="button" class="btn btn-success" id="confirm-category">Sukurti Kategoriją</button>
                    </div>

                    <div v-if="newcategoryresponse" class="new-category-alerts">
                        <div v-if="newcategoryresponse != 'OK'" class="alert alert-warning">
                          <strong>{{ newcategoryresponse }}</strong>
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

                    <button @click="remove_size($event)" :value="size.id" type="button" name="button" class="btn btn-danger remove-size">Pašalinti</button>
                </div>

            </div>

        </div>

        <!-- CREATE-PRODUCT BUTTON -->

        <div class="confirm-creation col-md-4 col-md-offset-4" style="margin-top: 50px; margin-bottom: 50px; text-align: center">
            <button @click="create_new_product" type="button" class="btn btn-lg btn-warning center" id="create-new-product">Sukurti Produktą</button>

            <div class="validation-alert" style="height: 100px; margin-top: 25px;">
                <div v-if="validationmessage" class="alert alert-warning">
                    <strong>{{ validationmessage }}</strong>
                </div>
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
                title: null,
                description: null,
                image: null,
                height: null,
                length: null,
                width: null,
                price: null,
                sizes: [],
                sizeidcounter: 0,
                validationmessage: null
            }
        },

        created() {
            console.log('Component mounted.')

            axios.get('/categories')
                .then(response => this.categories = response.data)
                .catch(error => $);

        },

        watch: {
            categories: function() {
                if(this.getQueryStringValue('created')) {
                    this.newproductresponse = true;
                }
            }
        },

        methods: {
            getQueryStringValue (key) {
                return decodeURIComponent(window.location.search.replace(new RegExp("^(?:.*[&\\?]" + encodeURIComponent(key).replace(/[\.\+\*]/g, "\\$&") + "(?:\\=([^&]*))?)?.*$", "i"), "$1"));
            },

            create_new_category() {
                this.newcategory = $.trim(this.newcategory);
                if(!this.newcategory) {
                    this.newcategoryresponse = "Kategorija negali būti tuščia."
                } else if($.inArray(this.newcategory, this.categories) != -1) {
                    this.newcategoryresponse = "Tokia kategorija jau yra.";
                    this.selectedcategory = this.newcategory;
                } else {
                    axios.post('/admin/categories/create', {
                        name: this.newcategory
                        })
                        .then(response => {
                            this.newcategoryresponse = response.data;
                            this.categories.push(this.newcategory);
                            this.selectedcategory = this.newcategory;
                        })
                        .catch(error => this.newcategoryresponse = "Kažkas atsitiko, bandykite dar kartą.");
                }
            },

            create_new_size() {

                this.validationmessage = null;

                if(!this.height || !this.length || !this.width || !this.price) {
                    return this.validationmessage = 'Užpildykite visus dydžio laukelius.';
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

            create_new_product() {

                this.validationmessage = null;

                if (!this.title){
                    this.validationmessage = 'Pavadinimas negali būti tuščias.';
                } else if (!this.description) {
                    this.validationmessage = 'Aprašymas negali būti tuščias.';
                } else if (!this.selectedcategory) {
                    this.validationmessage = 'Pasirinkite arba sukurkite kategoriją šiam produktui.';
                } else if(!this.image) {
                    this.validationmessage = 'Įkelkite nuotrauką.';
                } else if (this.sizes.length == 0) {
                    this.validationmessage = 'Pridėkite bent vieną produkto dydį.';
                } else {
                    axios.post('/admin/products/create', {
                        title: this.title,
                        description: this.description,
                        sizes: this.sizes,
                        image: this.image,
                        category: this.selectedcategory
                    })
                    .then(response =>
                        window.location.href = "/admin/create?created=true")
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

    #add-size, .remove-size {
        margin-left: 25px;
        width: 150px;
    }

    .display-confirmed-size-price-row {
        margin-top: 5px;
    }





</style>
