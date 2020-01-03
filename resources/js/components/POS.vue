<template>

    <div class="container">
        <div class="row-md-12">
            <tile v-if="this.isLoading"></tile>
            <div class="row mt-5">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">المنتجات</h3>
                            <input placeholder="Search by Product Name" class="form-control" v-model="filters.name.value"/>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <v-table :data="products"
                                     :filters="filters"
                                     class="table table-hover">
                                <thead slot="head">
                                <tr>
                                    <v-th sortKey="id">المعرف</v-th>
                                    <v-th sortKey="name">الاسم</v-th>
                                    <v-th sortKey="sellingprice">سعر البيع</v-th>
                                    <v-th sortKey="quantity">الكمية</v-th>
                                    <v-th sortKey="edate">تاريخ الانتهاء</v-th>
                                    <v-th>العمليات</v-th>
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
                                        <button @click="removesell(row)"><i class="fa fa-minus-circle text-red"
                                                                            style="color:red"></i></button>
                                        <button @click="addsell(row)"><i class="fa fa-plus-circle text-green"
                                                                         style="color:green"></i></button>
                                    </td>
                                </v-tr>
                                </tbody></v-table>
                        </div>
                        <!-- /.card-body -->

                    </div>
                    <!-- /.card -->
                </div>


                <!-- /.Sells begin -->
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">المبيعات</h3>
                        </div>
                        <!-- /.card-header -->

                        <div id="printMe" >
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover">
                                    <tbody><tr>
                                        <th>المعرف</th>
                                        <th>الاسم</th>
                                        <th>الكمية</th>
                                        <th>سعر البيع</th>
                                    </tr>
                                    <tr v-for="sell in sells" :key="sell.id" >
                                        <td v-if="sell.quantity>0">{{sell.id}}</td>
                                        <td v-if="sell.quantity>0">{{sell.name}}</td>
                                        <td v-if="sell.quantity>0">{{sell.quantity }}</td>
                                        <td v-if="sell.quantity>0">{{sell.sellingprice}}</td>
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
                                    <td>المبلغ الكلي</td>
                                    <td>الخصم</td>
                                    <td>المبلغ النهائي</td>
                                </tr>
                                <tr>
                                    <td>{{subtotal}}</td>
                                    <td><input type="number" value="0" @input="grandtotalcalculation(discount)" v-model="discount"></td>
                                    <td>{{grandtotal}}</td>
                                </tr>
                                </tbody></table>
                        </div>
                        <button class="btn btn-block btn-success" @click="check">Submit</button>

                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.Sells end -->
            </div>
            <!-- Modal -->
        </div>

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

                      // Create callback function to receive barcode when the scanner is already done
      onBarcodeScanned (barcode) {
        console.log(barcode)
        // do something...
      },
      // Reset to the last barcode before hitting enter (whatever anything in the input box)
      resetBarcode () {
        let barcode = this.$barcodeScanner.getPreviousCode()
        // do something...
      },

                check()
                {
                    swal.fire({
                        title: 'هل انت متأكد؟',
                        text: "لن تستطيع التراجع",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
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
                    window.open('api/cashierinvoice?id=' + y + '&sells=' + x + '&subtotal=' + i + '&discount=' + a + '&grandtotal=' + z, '_blank');
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
                                } else this.$toastr.error('Not enough quantity', 'error')
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
                },

                addByBarcode(data)
                {
                    var dat=data 
                    this.products.forEach(function (element) {
                        if(element.barcode== dat)
                        {
                            this.addsell(element);
                        }
                    });
                }


            },
        mounted() {

    console.log(this.discount)
                   },
                    destroyed () {
      // Remove listener when component is destroyed
      this.$barcodeScanner.destroy()
    },
        created() {
            this.$barcodeScanner.init(this.onBarcodeScanned)
             function setup ()
          {
              defaultScanner = new BarcodeReader(null,
                   onBarcodeReaderComplete);
          }
          function onBarcodeReaderComplete ( result )
         {
              if (result.status == 0)
              {
                   // BarcodeReader object was successfully created.
                   // Configure the symbologies needed.
                   defaultScanner.set("Symbology", "Code39", "Enable",
                        "true", onSetComplete);
                   defaultScanner.set("Symbology", "Code128", "EnableCode128",
                        "true", onSetComplete);

                   // Add an event handler for the barcodedataready event
                   defaultScanner.addEventListener("barcodedataready",
                        onBarcodeDataReady, false);
               }
               else
               {
                    defaultScanner = null;
                    alert('Failed to create BarcodeReader, '
                         + result.message);
               }
          }

          // Verify the symbology configuration.
          function onSetComplete ( result )
          {
               if (result.status != 0)
               {
                    alert('set Family: ' + result.family + ', Key: ' +
                         result.key + ', Option: ' + result.option +
                         ', Value: ' + result.value + 'failed. ' +
                         result.message);
               }
          }

          // Handle barcode data when available.
          function onBarcodeDataReady (data, type, time)
          {
              this.addByBarcode(data)
              console.log("data");
              console.log(data);
          }


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
