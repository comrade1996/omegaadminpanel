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
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            <td>Sub Total</td>
                            <td>Discount</td>
                            <td>Grand Total</td>
                        </tr>
                        <tr>
                            <td>{{this.subtotal}}</td>
                            <td><input type="number"  onchange="this.grandtotalcalculation()" v-model="discount" name="discount"></td>
                            <td>{{this.grandtotal}}</td>
                        </tr>
                        </tbody></table>

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
           var subtotal=0;
               var grandtotal=0;

            discount:'0'
            return{
                products:{},
                sells:[]
            }
        },
        methods:
            {

                addsell(product){
                    var added=false;
                    var tempProduct=product;
                        this.sells.forEach(function (element) {
                            if (element.id == tempProduct.id) {
                                element.quantity++;
                                added = true
                            }
                        });
                if(!added)
                    {
                        tempProduct.quantity=1;

                        console.log(product.quantity);
                        this.sells.push(tempProduct)
                    }

                    console.log(typeof this.sells);
                    console.log(this.sells);

                    this.subtotalcalculation();
                    this.grandtotalcalculation()
                },
                removesell(product)
                {
                    var removed=false;
                    var tempProduct=product;
                    this.sells.forEach(function (element) {
                        if (element.id == tempProduct.id && element.quantity>1) {
                            element.quantity--;
                            removed = true
                        }


                    });

                    this.subtotalcalculation();
                    this.grandtotalcalculation()
                },
                subtotalcalculation()
                {
                    var tempSubtotal=0;
                    this.sells.forEach(function (element) {
                        tempSubtotal=tempSubtotal+(element.quantity*element.sellingprice)
                    });
                    this.subtotal=tempSubtotal;
                },
                grandtotalcalculation(){
                    console.log()
                    this.grandtotal=this.subtotal - this.discount.toInteger()
                },
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
                            );
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
