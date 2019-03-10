<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Products Table</h3>
                        <div class="card-tools">
                            <div class="row">
                                <div class="col-md-7">
                            <input placeholder="Search by Product Name" class="form-control" v-model="filters.name.value" />
                                </div>
                                    <div class="col-md-4 mr-1">
                            <button class="btn btn-primary" @click="openCreateModal"> New Product <i class="fas fa-Product-plus"></i></button>
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
                                <v-th sortKey="id">ID</v-th>
                                <v-th sortKey="name">Name</v-th>
                                <v-th sortKey="purchaseprice">Purchase Price</v-th>
                                <v-th sortKey="sellingprice">Selling Price</v-th>
                                <v-th sortKey="quantity">Quantity</v-th>
                                <v-th sortKey="company">Company</v-th>
                                <v-th sortKey="category.name">Category</v-th>
                                <v-th sortKey="edate">Expire Date</v-th>
                                <v-th sortKey="created_at">Created At</v-th>
                                <v-th sortKey="updated_at">Modify</v-th>
                                <v-th>Options</v-th>
                            </tr>
                            </thead>
                            <tbody slot="body" slot-scope="{displayData}">
                            <v-tr v-for="row in displayData" :key="row.guid">
                                <td>{{row.id}}</td>
                                <td>{{row.name}}</td>
                                <td>{{row.purchaseprice}}</td>
                                <td>{{row.sellingprice}}</td>
                                <td>{{row.quantity}}</td>
                                <td>{{row.company | capitalize}}</td>
                                <td>{{row.category.name | capitalize}}</td>
                                <td>{{row.edate | readableDate }}</td>
                                <td>{{row.created_at }}</td>
                                <td>{{row.updated_at }}</td>
                                <td>
                                    <a href="#" @click="openEditModal(row)">
                                        <i class="fas fa-pencil-alt text-blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteProduct(row.id)">
                                        <i class="fas fa-trash text-red"></i>
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
                        <h5 class="modal-title" id="createProductTitle">Create Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateProduct() : createProduct()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input v-model="form.name" type="text" name="name"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>

                        <div class="form-group">
                            <label>Purchase Price</label>
                            <input v-model="form.purchaseprice" type="text" name="purchaseprice"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('purchaseprice') }">
                            <has-error :form="form" field="purchaseprice"></has-error>
                        </div>

                        <div class="form-group">
                            <label>Selling Price</label>
                            <input v-model="form.sellingprice" type="text" name="sellingprice"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('sellingprice') }">
                            <has-error :form="form" field="sellingprice"></has-error>
                        </div>

                        <div class="form-group">
                            <label>Quantity</label>
                            <input v-model="form.quantity" type="text" name="quantity"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('quantity') }">
                            <has-error :form="form" field="quantity"></has-error>
                        </div>

                        <div class="form-group">
                            <label>Company</label>
                            <input v-model="form.company" type="text" name="company"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('company') }">
                            <has-error :form="form" field="company"></has-error>
                        </div>

                        <div class="form-group">
                            <label>Category</label>
                            <select v-model="form.category" name="category" class="form-control" :class="{ 'is-invalid': form.errors.has('category') }">
                                <option value="">Select Category for Product</option>
                                <option v-for="category in categories" :value="category.id">
                                    {{ category.name | capitalize}}
                                </option>
                            </select>
                            <has-error :form="form" field="category"></has-error>
                        </div>

                        <div class="form-group">
                            <label>Expire Date</label>
                            <input type="date"  v-model="form.edate" name="edate"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('edate') }">
                            <has-error :form="form" field="edate"></has-error>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
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
                    company: { value: '', keys: ['company'] },
                    category: { value: '', keys: ['category.name'] }

                },
                editmode:true,
                products:{},
                categories: [{}],
                form:new Form({
                    id:'',
                    name:'',
                    purchaseprice:'',
                    sellingprice:'',
                    quantity:'',
                    edate:'',
                    company:'',
                    category:'',
                    photo:''
                })
            }
        },
        methods:
            {
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
                createProduct()
                {

                    this.form.post('api/product')
                        .then(()=>{
                            this.$Progress.start();
                            Fire.$emit('afterCreate');
                            $('#createProduct').modal('hide')
                            toast.fire({
                                type: 'success',
                                title: 'Product Created successfully'
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
                },
                deleteProduct(id)
                {
                    swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if(result.value) {
                            this.form.delete('api/product/' + id)
                                .then(() => {
                                    swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                    )
                                    Fire.$emit('afterCreate');
                                })
                                .catch(() => {
                                    swal.fire(
                                        'Failed!',
                                        'Your file has been Filed.',
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
            //setInterval(()=>this.getProducts(), 3000);

        }
    }
</script>
