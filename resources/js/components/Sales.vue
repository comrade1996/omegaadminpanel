<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">المبيعات</h3>
                        <input placeholder="Search by Invoice ID" class="form-control" v-model="filters.sale_id.value"/>
                        <div class="card-tools">
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <v-table :data="sales"  :filters="filters"
                                 class="table table-hover">
                            <thead slot="head">
                            <tr>
                                <v-th sortKey="id"> رقم الفاتورة</v-th>
                                <v-th sortKey="subtotal">المبلغ الكلي</v-th>
                                <v-th sortKey="discount">الخصم</v-th>
                                <v-th sortKey="grandtotal">المبلغ النهائي</v-th>
                                <v-th sortKey="created_at">تاريخ الانشاء</v-th>
                                <v-th sortKey="updated_at">تاريخ التعديل</v-th>
                                <v-th>اسم المنشئ</v-th>
                                <v-th>الحالة</v-th>
                                <v-th>العمليات</v-th>
                            </tr>
                            </thead>
                            <tbody slot="body" slot-scope="{displayData}">
                            <v-tr v-for="row in displayData" :key="row.guid">
                                <td>{{row.id}}</td>
                                <td>{{row.subtotal}}</td>
                                <td>{{row.discount}}</td>
                                <td>{{row.grandtotal}}</td>
                                <td>{{row.created_at | readableDate }}</td>
                                <td>{{row.updated_at | readableDate }}</td>
                                <td>{{row.created_by}}</td>
                                <td>
                                    <p v-if="row.verified==1">مصدقة</p>
                                    <button v-if="row.verified==0" @click="updateProducts(row.id)"> تصديق الفاتورة
                                    </button>

                                </td>
                                <td>
                                    <a href="#" @click="deleteSales(row.id)">
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
                filters: {
                    sale_id: { value: '', keys: ['id'] }
                },
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
                    axios.get("api/sales").then(({data}) => (this.sales =data.data));
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
                updateProducts(id)
                {
                    axios.post('api/persistproduct',{
                        id:id
                    })
                        .then( (response=> {
                            console.log(response);
                            console.log("updated")
                            swal.fire(
                                'تم التعديل',
                                'تم التعديل بنجاح',
                                'success'
                            )
                                this.$router.go()
                        }))
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                deleteSales(id)
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
                            this.form.delete('api/sales/' + id)
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
