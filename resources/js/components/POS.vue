<template>

    <div class="container">
        <div class="row mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Products</h3>
                        <input placeholder="Search by Product Name" class="form-control" v-model="filters.name.value"/>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <v-table :data="products"
                                 :filters="filters"
                                 class="table table-hover">
                            <thead slot="head">
                            <tr>
                                <v-th  sortKey="id">ID</v-th>
                                <v-th  sortKey="name">Name</v-th>
                                <v-th  sortKey="sellingprice">Price</v-th>
                                <v-th  sortKey="quantity">Quantity</v-th>
                                <v-th  sortKey="edate">Expire Date</v-th>
                                <v-th>Options</v-th>
                            </tr>
                            </thead>
                            <tbody slot="body" slot-scope="{displayData}">
                            <v-tr v-for="row in displayData" :key="row.guid">
                                <td>{{row.id}}</td>
                                <td>{{row.name}}</td>
                                <td>{{row.sellingprice}}</td>
                                <td>{{row.quantity }}</td>
                                <td>{{row.edate | readableDate }}</td>
                                <td>
                                    <button  @click="addsell(row)"><i class="fas fa-plus-circle text-green"></i></button>
                                    <button  @click="removesell(row)"> <i class="fas fa-minus-circle text-red"></i></button>
                                </td>
                            </v-tr>
                            </tbody></v-table>
                    </div>
                    <!-- /.card-body -->

                </div>
                <!-- /.card -->
            </div>

            <tile  v-if="this.isLoading"></tile >

            <!-- /.Sells begin -->
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Sells</h3>
                    </div>
                    <!-- /.card-header -->

                    <div id="printMe" >
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody><tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                            <tr v-for="sell in sells" :key="sell.id" >
                                <td>{{sell.id}}</td>
                                <td>{{sell.name}}</td>
                                <td v-if="sell.quantity>0">{{sell.quantity }}</td>
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
                            <td><input type="number"  value="0" @input="grandtotalcalculation(discount)"   v-model="discount"></td>
                            <td>{{grandtotal}}</td>
                        </tr>
                        </tbody></table>
                        </div>
                    <button class="btn btn-flat btn-success" @click="check">Submit</button>

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

                subtotal:'',
             grandtotal:'',
                filters: {
                    name: { value: '', keys: ['name'] }
                },
                globalId:'',
                isLoading: false,
                 subtotal,
             grandtotal,
                discount:'',
                products:{},
                sells:[]
            }
        },
        methods:
            {
                check()
                {
                    swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Confirm'
                    }).then((result) => {
                        if (result.value) {
                           this.updateSales()
                        }
                    })
                },
                int()
                {

                    var x=JSON.stringify(this.sells);
                    var y = this.globalId;
                    var a = this.discount;
                    var i = this.subtotal;
                    var z = this.grandtotal;
                    window.open( 'api/invoice?id='+y+'&sells='+x+'&subtotal='+i+'&discount='+a+'&grandtotal='+z,'_blank');
                    //axios.get("api/invoice").then(({data}) => (console.log(data+"aaaaaaaaaa")));
                },
                clearSales() {
                    this.$router.go()
                },
                addsell(product){
                    console.log(product)
                    var added=false;
                    var found=false;
                    var tempProduct = JSON.parse(JSON.stringify(product));
                        this.sells.forEach(function (element) {
                            if (element.id == tempProduct.id) {
                                found=true
                                if( product.quantity>0){
                                element.quantity++;
                                product.quantity--;
                                added = true
                                }
                                else this.$toastr.error('Not egnough quantity', 'error')
                            }

                        });
                if(!added && product.quantity>0 && !found)
                    {
                        tempProduct.quantity=1;
                        product.quantity--;

                        this.sells.push(tempProduct)
                    }else


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
                        if (element.id == tempProduct.id && element.quantity>0 &&!removed) {
                            element.quantity--;
                            product.quantity++;
                            removed = true
                        }
                        if (element.id == tempProduct.id && element.quantity==0 && !removed) {
                            this.sells.slice(indexOf(element),1)
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
                    if(discount<1) {
                        discount = 0;
                    }var disc = parseInt(discount, 10);
                    var  tempsub =parseInt(this.subtotal, 10);
                    tempGrandtotal=tempsub - disc;
                    this.grandtotal = tempGrandtotal;



                },
                updateSales()
                {

                  var pr=false
                    // var id =Math.floor(Math.random()*90000) + 10000;
                    var disc =this.discount;
                    // this.globalId=id;
                    if(disc<1) {
                        disc = 0;
                    }
                    if(this.subtotal>1)
                    {
                        this.isLoading=true
                        this.$Progress.get()
                    axios.post('api/sales', {
                        // sale_id:id,
                        subtotal: this.subtotal,
                        grandtotal:this.grandtotal,
                        discount:disc
                    })
                        .then(

                            (response => {

                                this.globalId = response.data;
                                console.log("meee")
                                console.log(response.data)
                                console.log(this.globalId)
                            tempsells:[];
                            var tempsell;
                            var sellsdata = JSON.stringify(this.sells);
                            axios.post('api/salesdetails',{
                                sale_id:this.globalId,
                                sells:sellsdata
                            })
                                .then((data)=>{
                                    console.log(data)
                                    pr=true
                                    this.int();
                            this.clearSales();
                                    // this.updateProducts()
                                    console.log("check")
                                })
                                .catch(()=>{
                                    this.isLoading=false
                                })

                            console.log("stored")
                        }))
                        .catch(function (error) {
                            console.log(error);
                            this.isLoading=false
                            this.$Progress.fail()
                        });

                }},

                getResults(page = 1) {
                    axios.get('api/product?page=' + page)
                        .then(response => {
                            this.users = response.data;
                        });},
                getProducts()
                {
                    axios.get("api/product").then(({data}) => (this.products =data.data));
                }


            },
        mounted() {

    console.log(this.discount)
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

    $(function() {
        $("#printable").find('.print').on('click', function() {
            $.print("#printable");
        });
    });
</script>
