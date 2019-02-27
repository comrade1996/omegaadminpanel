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
                                <td>{{product.quantity }}</td>
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
                            <tr v-for="sell in sells" :key="sell.id" v-if="sell.quantity>0">
                                <td>{{sell.id}}</td>
                                <td>{{sell.name}}</td>
                                <td >{{sell.quantity }}</td>
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
                            <td>{{subtotal}}</td>
                            <td><input type="number" ref="discount" data-value="0" @input="grandtotalcalculation(discount)"   v-model="discount"></td>
                            <td>{{grandtotal}}</td>
                        </tr>
                        </tbody></table>

                    <button class="btn btn-flat btn-success" @click="updateSales">Submit</button>
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
           var subtotal;
               var grandtotal;


            return{
                 subtotal,
             grandtotal,
                discount:'',
                products:{},
                sells:[]
            }
        },
        methods:
            {

                addsell(product){
                    var added=false;
                    var tempProduct = JSON.parse(JSON.stringify(product));
                        this.sells.forEach(function (element) {
                            if (element.id == tempProduct.id && product.quantity>0) {
                                element.quantity++;
                                product.quantity--;
                                added = true
                            }
                        });
                if(!added && product.quantity>0)
                    {
                        tempProduct.quantity=1;
                        product.quantity--;

                        this.sells.push(tempProduct)
                    }
                  //  this.$toasted.global.quantity();
                    console.log(product.quantity)
                    this.subtotalcalculation();
                    this.grandtotalcalculation(this.discount)

                },
                removesell(product)
                {
                    var removed=false;
                    var tempProduct=product;
                    this.sells.forEach(function (element) {
                        if (element.id == tempProduct.id && element.quantity>0) {
                            element.quantity--;
                            product.quantity++;
                            removed = true
                        }
                        if (element.id == tempProduct.id && element.quantity==1) {
                            this.sells.slice(indexOf(element))
                            removed = true
                        }


                    });

                    this.subtotalcalculation();
                },
                subtotalcalculation()
                {
                    var tempSubtotal=0;
                    this.sells.forEach(function (element) {
                        tempSubtotal=tempSubtotal+(element.quantity*element.sellingprice)
                    });
                    this.subtotal=tempSubtotal;
                    this.grandtotalcalculation(this.discount)

                },
                grandtotalcalculation(discount){
                   var tempGrandtotal=0;
                     var disc=0
                    var disc = parseInt(discount, 10);
                    var  tempsub =parseInt(this.subtotal, 10);
                    tempGrandtotal=tempsub - disc;
                    this.grandtotal = tempGrandtotal;



                },
                updateSales()
                {
                  //  var formData = new FormData();
                   // formData.append('foo', 'bar');
                    //this.$http.post('/api', formData)
                    var id =Math.floor(Math.random()*90000) + 10000;

                    axios.post('api/sales', {
                        sale_id:id,
                        subtotal: this.subtotal,
                        grandtotal:this.grandtotal,
                        discount:this.discount
                    })
                        .then( (response => {
                            console.log(response);
                            this.sells.forEach(function (element) {
                                console.log("storing")

                                axios.post('api/salesdetails', {
                                    sale_id:id,
                                    product_id: element.id,
                                    quantity:element.quantity,
                                    price:element.sellingprice
                                })
                                    .then(function (response) {
                                        console.log(response);
                                    })
                                    .catch(function (error) {
                                        console.log(error);
                                    });

                            });

                            console.log("stored")
                        }))
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                updateSalesDetails(sale_id, product_id, quantity,price)
                {

                    axios.post('api/salesdetails', {
                        sale_id:sale_id,
                        product_id: product_id,
                        quantity:quantity,
                        price:price
                    })
                        .then(function (response) {
                            console.log(response);
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
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
