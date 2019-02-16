<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Sales Table</h3>
                        <div class="card-tools">
                            <button class="btn btn-primary" @click="openCreateModal"> New sales <i class="fas fa-sales-plus"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody><tr>
                                <th> Invoice ID</th>
                                <th>Sub Total</th>
                                <th>Discount</th>
                                <th>Grand Total</th>
                                <th>Created At</th>
                                <th>Modify</th>
                                <th>Options</th>
                            </tr>
                            <tr v-for="sale in sales.data" :key="sale.id">
                                <td>{{sale.id}}</td>
                                <td>{{sale.subtotal}}</td>
                                <td>{{sale.discount}}</td>
                                <td>{{sale.grandtotal}}</td>
                                <td>{{sale.created_at | readableDate }}</td>
                                <td>{{sale.updated_at | readableDate }}</td>
                                <td>
                                    <a href="#" @click="openEditModal(sale)">
                                        <i class="fas fa-pencil-alt text-blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteSales(sale.id)">
                                        <i class="fas fa-trash text-red"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody></table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="sales"
                                    @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="createsales" tabindex="-1" role="dialog" aria-labelledby="createsalesTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createsalesTitle">Create Sales</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateSales() : createSales()">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Sub Total</label>
                                <input v-model="form.subtotal" type="text" name="subtotal"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('subtotal') }">
                                <has-error :form="form" field="subtotal"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Discount</label>
                                <input v-model="form.discount" type="text" name="discount"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('discount') }">
                                <has-error :form="form" field="discount"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Grand Total</label>
                                <input v-model="form.grandtotal" type="text" name="grandtotal"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('grandtotal') }">
                                <has-error :form="form" field="grandtotal"></has-error>
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

            return{
                editmode:true,
                sales:{},
                form:new Form({
                    id:'',
                    subtotal:'',
                    discount:'',
                    grandtotal:''
                })
            }
        },
        methods:
            {
                getResults(page = 1) {
                    axios.get('api/sales?page=' + page)
                        .then(response => {
                            this.users = response.data;
                        });},
                openCreateModal()
                {
                    this.editmode=false;

                    this.form.clear();
                    this.form.reset();
                    $('#createsales').modal('show');
                },
                openEditModal(sales)
                {
                    this.editmode=true;
                    this.form.clear();
                    this.form.reset();
                    $('#createsales').modal('show');
                    this.form.fill(sales);
                },
                getSales()
                {
                    axios.get("api/sales").then(({data}) => (this.sales =data));
                },
                createSales()
                {

                    this.form.post('api/sales')
                        .then(()=>{
                            this.$Progress.start();
                            Fire.$emit('afterCreate');
                            $('#createsales').modal('hide')
                            toast.fire({
                                type: 'success',
                                title: 'sales Created successfully'
                            })
                            this.$Progress.finish();

                        })
                        .catch(()=>{

                        })
                },
                updateSales()
                {
                    // this.$progress.start();
                    console.log("hoola");
                    this.form.put('api/sales/'+this.form.id)
                        .then(()=>
                        {
                            swal.fire(
                                'Updated!',
                                'Your sales has been updated.',
                                'success'
                            )
                            // this.$progress.finish();
                            $('#createsales').modal('hide');
                            Fire.$emit('afterCreate');
                        })
                        .catch(()=>
                        {
                            //  this.$Progress.fail();
                        })
                },
                deleteSales(id)
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
                            this.form.delete('api/sales/' + id)
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
                axios.get('api/findSales?q='+query)
                    .then((data)=>{
                        this.sales = data.data
                    })
                    .catch(()=>{})
            });
            this.getSales();
            Fire.$on('afterCreate',()=>{this.getSales()});
            //setInterval(()=>this.getsaless(), 3000);

        }
    }
</script>
