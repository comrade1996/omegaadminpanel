<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title ">المنتجات الناقصة</h3>
                        <div class="card-tools cardtitle">
                            <button class="btn btn-primary" @click="openCreateModal"> منتج جديد <i
                                class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>المعرف</th>
                                <th>الاسم</th>
                                <th>الوصف</th>
                                <th>تاريخ الانشاء</th>
                                <th>تاريخ التعديل</th>
                                <th>اسم المنشئ</th>
                                <th>العمليات</th>
                            </tr>
                            <tr v-for="item in Items.data" :key="item.id">
                                <td>{{item.id}}</td>
                                <td>{{item.name | capitalize}}</td>
                                <td>{{item.description | capitalize}}</td>
                                <td>{{item.created_at | readableDate }}</td>
                                <td>{{item.updated_at | readableDate }}</td>
                                <td>{{item.created_by}}</td>
                                <td>
                                    <a href="#" @click="openEditModal(item)">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteItem(item.id)">
                                        <i class="fa fa-trash text-red" style="color:red;"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="Items"
                                    @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="createItem" tabindex="-1" role="dialog" aria-labelledby="createItemTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createItemTitle">انشاء منتج</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateItem() : createItem()">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>الاسم</label>
                                <input v-model="form.name" type="text" name="name"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>

                            <div class="form-group">
                                <label>الوصف</label>
                                <input v-model="form.description" type="text" name="description"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
                                <has-error :form="form" field="description"></has-error>
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
        data() {

            return {
                editmode: true,
                Items: {},
                form: new Form({
                    id: '',
                    name: '',
                    description: ''
                })
            }
        },
        methods:
            {
                getResults(page = 1) {
                    axios.get('api/missingitem?page=' + page)
                        .then(response => {
                            this.Items = response.data;
                        });},
                openCreateModal() {
                    this.editmode = false;

                    this.form.clear();
                    this.form.reset();
                    $('#createItem').modal('show');
                },
                openEditModal(Item) {
                    this.editmode = true;
                    this.form.clear();
                    this.form.reset();
                    $('#createItem').modal('show');
                    this.form.fill(Item);
                },
                getItems() {
                    axios.get("api/missingitem").then(({data}) => (this.Items = data));
                },
                createItem() {

                    this.form.post('api/missingitem')
                        .then(() => {
                            this.$Progress.start();
                            Fire.$emit('afterCreate');
                            $('#createItem').modal('hide')
                            toast.fire({
                                type: 'success',
                                title: 'تم الانشاء بنجاح'
                            });
                            this.$Progress.finish();

                        })
                        .catch(() => {

                        })
                },
                updateItem() {
                    // this.$progress.start();

                    console.log(this.form.id)
                    console.log(this.form.description)
                    console.log("hoola");
                    this.form.put('api/missingitem/' + this.form.id)
                        .then(() => {
                            swal.fire(
                                'تم التعديل',
                                'تم التعديل بنجاح',
                                'success'
                            )
                            // this.$progress.finish();
                            $('#createItem').modal('hide');
                            Fire.$emit('afterCreate');
                        })
                        .catch(() => {
                            //  this.$Progress.fail();
                        })
                },
                deleteItem(id) {
                    swal.fire({
                        title: 'هل انت متأكد؟',
                        text: "لن تستطيع التراجع",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'موافق',
                        cancelButtonText: 'الغاء'
                    }).then((result) => {
                        if (result.value) {
                            this.form.delete('api/missingitem/' + id)
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
                axios.get('api/findmissingitem?q='+query)
                    .then((data)=>{
                        this.Items = data.data
                    })
                    .catch(()=>{})
            });
            this.getItems();
            Fire.$on('afterCreate', () => {
                this.getItems()
            });
            // setInterval(()=>this.getItems(), 3000);

        }
    }
</script>
