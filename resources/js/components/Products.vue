<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">المنتجات</h3>
                        <div class="card-tools">
                            <div class="row">
                                <div class="col-md-7">
                            <input placeholder="Search by Product Name" class="form-control" v-model="filters.name.value" />
                                </div>
                                    <div class="col-md-4 mr-1">
                                        <button class="btn btn-primary" @click="openCreateModal">انشاء منتج <i
                                            class="fas fa-Product-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <v-table :data="products"  :filters="filters"
                                 class="table table-hover">
                            <thead slot="head">
                            <tr>
                                <v-th sortKey="id">المعرف</v-th>
                                <v-th sortKey="barcode">الباركود</v-th>
                                <v-th sortKey="name">الاسم</v-th>
                                <v-th sortKey="purchaseprice">سعر الشراء</v-th>
                                <v-th sortKey="sellingprice">السعر البيع</v-th>
                                <v-th sortKey="quantity">الكمية</v-th>
                                <v-th sortKey="company">الشركة</v-th>
                                <v-th sortKey="category.name">تصنيف المنتج</v-th>
                                <v-th sortKey="edate">تاريخ الانتهاء</v-th>
                                <v-th sortKey="created_by">اسم المنشئ</v-th>
                                <v-th sortKey="created_at">تاريخ الانشاء</v-th>
                                <v-th sortKey="updated_at">تاريخ التعديل</v-th>
                                <v-th>العمليات</v-th>
                            </tr>
                            </thead>
                            <tbody slot="body" slot-scope="{displayData}">
                            <v-tr v-for="row in displayData" :key="row.guid">
                                <td>{{row.id}}</td>
                                <td>{{row.barcode}}</td>
                                <td>{{row.name}}</td>
                                <td>{{row.purchaseprice}}</td>
                                <td>{{row.sellingprice}}</td>
                                <td :class="{backgroundAlert:row.quantity<15}">{{row.quantity}} {{row.unit.name }}</td>
                                <td>{{row.company.name | capitalize}}</td>
                                <td>{{row.category.name | capitalize}}</td>
                                <td :class="{backgroundAlert:expdatediff(row.edate)>90}">{{row.edate | readableDate }}</td>
                                <td>{{row.created_by }}</td>
                                <td>{{row.created_at }}</td>
                                <td>{{row.updated_at }}</td>
                                <td>
                                    <a href="#" @click="openEditModal(row)">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteProduct(row.id)">
                                        <i class="fa fa-trash text-red"></i>
                                    </a>
                                </td>
                            </v-tr>
                            </tbody></v-table>
                    </div>
                    <!-- /.card-body -->

                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="createProduct" tabindex="-1" role="dialog" aria-labelledby="createProductTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createProductTitle">انشاء المنتج</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateProduct() : createProduct()"> 
                    <div class="modal-body">
                        <div class="form-group">
                            <label>الاسم</label>
                            <input v-model="form.name" type="text" name="name"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>
                        <div class="form-group">
                            <label>الباركود</label>
                            <input v-model="form.barcode" type="text" name="barcode"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('barcode') }">
                            <has-error :form="form" field="barcode"></has-error>
                        </div>

                        <div class="form-group">
                            <label>سعر الشراء</label>
                            <input v-model="form.purchaseprice" type="text" name="purchaseprice"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('purchaseprice') }">
                            <has-error :form="form" field="purchaseprice"></has-error>
                        </div>

                        <div class="form-group">
                            <label>سعر البيع</label>
                            <input v-model="form.sellingprice" type="text" name="sellingprice"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('sellingprice') }">
                            <has-error :form="form" field="sellingprice"></has-error>
                        </div>

                        <div class="form-group">
                            <label>الكمية</label>
                            <input v-model="form.quantity" type="text" name="quantity"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('quantity') }">
                            <has-error :form="form" field="quantity"></has-error>
                        </div>

                        <div class="form-group">
                            <label>الشركة</label>
                            <select v-model="form.company" name="company" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('company') }">
                                <option value="">اختر الشركة للمنتج</option>
                                <option v-for="company in companies" :value="company.id">
                                    {{ company.name | capitalize}}
                                </option>
                            </select>
                            <has-error :form="form" field="company"></has-error>
                        </div>

                        <div class="form-group">
                            <label>التصنيف</label>
                            <select v-model="form.category" name="category" class="form-control" :class="{ 'is-invalid': form.errors.has('category') }">
                                <option value="">اختر تصنيف للمنتج</option>
                                <option v-for="category in categories" :value="category.id">
                                    {{ category.name | capitalize}}
                                </option>
                            </select>
                            <has-error :form="form" field="category"></has-error>
                        </div>

                        <div class="form-group">
                            <label>وحدة قياس المنتج</label>
                            <select v-model="form.unit" name="unit" class="form-control" :class="{ 'is-invalid': form.errors.has('unit') }">
                                <option value="">اختر وحدة قياس للمنتج</option>
                                <option v-for="unit in units" :value="unit.id">
                                    {{ unit.name | capitalize}}
                                </option>
                            </select>
                            <has-error :form="form" field="unit"></has-error>
                        </div>

                        <div class="form-group">
                            <label>تاريخ الانتهاء</label>
                            <input type="date"  v-model="form.edate" name="edate"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('edate') }">
                            <has-error :form="form" field="edate"></has-error>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data()
        {

            currentPage: 1;
                totalPages: 0;
            return{
                filters: {

                    name: { value: '', keys: ['name'] },
                    barcode: { value: '', keys: ['barcode'] },
                    company: {value: '', keys: ['company.name']},
                    category: { value: '', keys: ['category.name'] },
                    unit: { value: '', keys: ['unit.name'] }


                },
                editmode:true,
                products:{},
                categories: [{}],
                companies: [{}],
                units: [{}],

                form:new Form({
                    id:'',
                    name:'',
                    barcode:'',
                    purchaseprice:'',
                    sellingprice:'',
                    quantity:'',
                    edate:'',
                    company:'',
                    unit:'',
                    category:'',
                    photo:''
                })
            }
        },
        methods:
            {


                            expdatediff(date){
                                const moment = require('moment')
                //     console.log(date)
                //  var startDate = moment(date ).format("DD.MM.YYYY");
                //  console.log(startDate)
                // var endDate =  moment().format("DD.MM.YYYY")
                // console.log(endDate)

                var given = moment(date, "YYYY-MM-DD");
                var current = moment().startOf('day');
                console.log(current)
                //Difference in number of days
                var result =moment.duration(given.diff(current)).asDays();
                console.log(result)
                return result
                }
,


                getResults(page = 1) {
                    axios.get('api/product?page=' + page)
                        .then(response => {
                            this.users = response.data;
                        });},
                openCreateModal()
                {
                    this.editmode=false;

                    this.form.clear();
                    this.form.reset();
                    $('#createProduct').modal('show');
                },
                openEditModal(Product)
                {
                    this.editmode=true;
                    this.form.clear();
                    this.form.reset();
                    $('#createProduct').modal('show');
                    this.form.fill(Product);
                },
                getProducts()
                {
                    axios.get("api/product").then(({data}) => (this.products =data.data));
                },
                getCategories()
                {
                    axios.get("api/category").then(({data}) => (this.categories =data.data));
                },
                getUnits()
                {
                    axios.get("api/unit").then(({data}) => (this.units =data.data));
                }, getCompanies() {
                    axios.get("api/company").then(({data}) => (this.companies = data.data));
                },
                createProduct()
                {

                    this.form.post('api/product')
                        .then(()=>{
                            this.$Progress.start();
                            Fire.$emit('afterCreate');
                            $('#createProduct').modal('hide')
                            toast.fire({
                                type: 'success',
                                title: 'تم اﻹنشاء بنجاح'
                            })
                            this.$Progress.finish();

                        })
                        .catch(()=>{

                        })
                  },
                updateProduct()
                {
                   // this.$progress.start();
                    console.log("hoola");
                    this.form.put('api/product/'+this.form.id)
                        .then(()=>
                        {
                            swal.fire(
                                'تم التعديل',
                                'تم التعديل بنجاح',
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
                },
                deleteProduct(id)
                {
                    swal.fire({
                        title: 'هل انت متأكد؟',
                        text: "لن تستطيع التراجع",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'امسح!'
                    }).then((result) => {
                        if(result.value) {
                            this.form.delete('api/product/' + id)
                                .then(() => {
                                    swal.fire(
                                        ' تم المسح ',
                                        'لقد تم المسح بنجاح.',
                                        'success'
                                    )
                                    Fire.$emit('afterCreate');
                                })
                                .catch(() => {
                                    swal.fire(
                                        'فشل',
                                        '  تم المسح بنجاح.',
                                        'warning'
                                    )
                                })
                        }
                    })

                }
            },
        mounted() {
            console.log('Component mounted.')
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
            this.getCategories();
            Fire.$on('afterCreate',()=>{this.getCategories()});
            console.log(this.categories)
            this.getUnits();
            Fire.$on('afterCreate',()=>{this.getUnits()});
            console.log(this.units)
            this.getCompanies();
            Fire.$on('afterCreate', () => {
                this.getCompanies()
            });
            console.log(this.companies)
            //setInterval(()=>this.getProducts(), 3000);

        }
    }
</script>
