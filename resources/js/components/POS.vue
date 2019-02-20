<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Products</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody><tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Expire Date</th>
                                <th>Options</th>
                            </tr>
                            <tr v-for="product in products.data" :key="product.id">
                                <td>{{product.id}}</td>
                                <td>{{product.name}}</td>
                                <td>{{product.sellingprice}}</td>
                                <td>{{product.quantity | capitalize}}</td>
                                <td>{{product.edate | readableDate }}</td>
                                <td>
                                    <button  @click="addsell(product)"><i class="fas fa-plus-circle text-green"></i></button>
                                    /
                                    <button  @click="removesell(product)"> <i class="fas fa-minus-circle text-red"></i></button>
                                </td>
                            </tr>
                            </tbody></table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="products"
                                    @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
                <!-- /.card -->
            </div>

            <!-- /.Sells begin -->
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Sells</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody><tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                            <tr v-for="sell in sells" :key="sell.id">
                                <td>{{sell.id}}</td>
                                <td>{{sell.name}}</td>
                                <td>{{sell.quantity | capitalize}}</td>
                                <td>{{sell.sellingprice}}</td>
                            </tr>

                            </tbody></table>
                    </div>

                    <button class="btn btn-flat btn-success" @click="">Submit</button>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.Sells end -->
        </div>
        <!-- Modal -->

    </div>
</template>

<script>
    export default {
        data()
        {

            return{
                products:{},
                sells:[]

            }
        },
        methods:
            {

                addsell(product){
                      this.sells.push(product)

                    console.log(typeof this.sells)
                    console.log(this.sells)
                },
                removesell(product){},
                getResults(page = 1) {
                    axios.get('api/product?page=' + page)
                        .then(response => {
                            this.users = response.data;
                        });},
                getProducts()
                {
                    axios.get("api/product").then(({data}) => (this.products =data));
                },
                updateProduct()
                {
                    // this.$progress.start();
                    console.log("hoola");
                    this.form.put('api/product/'+this.form.id)
                        .then(()=>
                        {
                            swal.fire(
                                'Updated!',
                                'Your Product has been updated.',
                                'success'
                            )
                            // this.$progress.finish();
                            $('#createProduct').modal('hide');
                            Fire.$emit('afterCreate');
                        })
                        .catch(()=>
                        {
                            //  this.$Progress.fail();
                        })
                }

            },
        mounted() {
            console.log('Component mounted.')
        },
        created() {
            Fire.$on('searching', () => {
                let query =this.$parent.search;
                axios.get('api/findProduct?q='+query)
                    .then((data)=>{
                        this.products = data.data
                    })
                    .catch(()=>{})
            });
            this.getProducts();
            Fire.$on('afterCreate',()=>{this.getProducts()});


        }
    }
</script>
